<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aset extends CI_Controller
{
  private $upload_path = './assets/img/aset/toko/';

  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
    $role = $this->session->userdata('role');
    if ($role != "4") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_spg');
  }

  // tampil data Aset
  public function index()
  {
    $id_toko = $this->session->userdata('id_toko');
    $periode_awal = date('Y-m-01 00:00:00');
    $periode_akhir = date('Y-m-01 00:00:00', strtotime('+1 month'));

    $data['title'] = 'Aset';
    $data['toko'] = $this->db->get_where('tb_toko', ['id' => $id_toko])->row();
    $data['list_aset'] = $this->db->query(
      "SELECT
        tat.*,
        ta.aset,
        laporan.id_laporan,
        laporan.qty_laporan,
        laporan.keterangan_laporan,
        laporan.gambar_laporan
      FROM tb_aset_toko tat
      JOIN tb_aset_master ta ON tat.id_aset = ta.id
      LEFT JOIN (
        SELECT
          laporan_terbaru.id_aset,
          laporan_terbaru.id AS id_laporan,
          laporan_terbaru.qty AS qty_laporan,
          laporan_terbaru.keterangan AS keterangan_laporan,
          laporan_terbaru.gambar AS gambar_laporan
        FROM tb_aset_spg laporan_terbaru
        JOIN (
          SELECT id_aset, MAX(id) AS id
          FROM tb_aset_spg
          WHERE id_toko = ?
            AND tanggal >= ?
            AND tanggal < ?
          GROUP BY id_aset
        ) pilihan ON pilihan.id = laporan_terbaru.id
      ) laporan ON laporan.id_aset = tat.id
      WHERE tat.id_toko = ?
      ORDER BY tat.id ASC",
      [$id_toko, $periode_awal, $periode_akhir, $id_toko]
    )->result();

    $this->template->load('template/template', 'spg/aset/lihat_data', $data);
  }

  public function updateFotoAset()
  {
    if (strtoupper($this->input->method()) !== 'POST') {
      return $this->json_response(false, 'Metode permintaan tidak diizinkan.', [], 405);
    }

    $id_toko = (int) $this->session->userdata('id_toko');
    $id_aset_toko = (int) $this->input->post('id_aset_toko');
    $jumlah = $this->input->post('jumlah');
    $keterangan = trim((string) $this->input->post('keterangan', true));

    if (
      $id_aset_toko <= 0 ||
      filter_var($jumlah, FILTER_VALIDATE_INT) === false ||
      (int) $jumlah < 0 ||
      $keterangan === '' ||
      strlen($keterangan) > 250
    ) {
      return $this->json_response(false, 'Jumlah dan kondisi aset wajib diisi dengan benar.', [], 422);
    }

    $aset_toko = $this->db->select('id, no_aset')
      ->get_where('tb_aset_toko', ['id' => $id_aset_toko, 'id_toko' => $id_toko])
      ->row();

    if (!$aset_toko) {
      return $this->json_response(false, 'Aset tidak ditemukan untuk toko ini.', [], 404);
    }

    $periode_awal = date('Y-m-01 00:00:00');
    $periode_akhir = date('Y-m-01 00:00:00', strtotime('+1 month'));
    $aset_berikutnya = $this->db->query(
      "SELECT aset.id
      FROM tb_aset_toko aset
      WHERE aset.id_toko = ?
        AND NOT EXISTS (
          SELECT 1
          FROM tb_aset_spg laporan
          WHERE laporan.id_aset = aset.id
            AND laporan.id_toko = aset.id_toko
            AND laporan.tanggal >= ?
            AND laporan.tanggal < ?
        )
      ORDER BY aset.id ASC
      LIMIT 1",
      [$id_toko, $periode_awal, $periode_akhir]
    )->row();

    if (!$aset_berikutnya || (int) $aset_berikutnya->id !== $id_aset_toko) {
      return $this->json_response(false, 'Selesaikan aset sesuai urutan yang ditampilkan.', [], 409);
    }

    if (!isset($_FILES['foto_aset']) || $_FILES['foto_aset']['error'] === UPLOAD_ERR_NO_FILE) {
      return $this->json_response(false, 'Foto aset belum dipilih.', [], 422);
    }

    if (!is_dir($this->upload_path) || !is_writable($this->upload_path)) {
      return $this->json_response(false, 'Folder penyimpanan foto tidak tersedia.', [], 500);
    }

    $nama_aset = $this->sanitize_file_part($aset_toko->no_aset);
    if ($nama_aset === '') {
      $nama_aset = (string) $aset_toko->id;
    }

    $nama_file = 'aset-' . $nama_aset . '-' . date('m-Y');
    $config = [
      'upload_path' => $this->upload_path,
      'allowed_types' => 'jpg|jpeg|png',
      'max_size' => 4096,
      'max_width' => 6000,
      'max_height' => 6000,
      'file_name' => $nama_file,
      'overwrite' => true,
      'remove_spaces' => true,
      'detect_mime' => true
    ];

    $this->load->library('upload');
    $this->upload->initialize($config);

    if (!$this->upload->do_upload('foto_aset')) {
      return $this->json_response(false, trim(strip_tags($this->upload->display_errors('', ''))), [], 422);
    }

    $upload_data = $this->upload->data();
    if (!$this->compress_image($upload_data['full_path'])) {
      @unlink($upload_data['full_path']);
      return $this->json_response(false, 'Foto berhasil diterima, tetapi gagal dikompres.', [], 500);
    }

    $laporan_lama = $this->db->query(
      "SELECT id, gambar
      FROM tb_aset_spg
      WHERE id_aset = ?
        AND id_toko = ?
        AND tanggal >= ?
        AND tanggal < ?
      ORDER BY id DESC
      LIMIT 1",
      [$id_aset_toko, $id_toko, $periode_awal, $periode_akhir]
    )->row();

    $data_laporan = [
      'id_aset' => $id_aset_toko,
      'id_toko' => $id_toko,
      'qty' => (int) $jumlah,
      'keterangan' => $keterangan,
      'gambar' => $upload_data['file_name'],
      'tanggal' => date('Y-m-d H:i:s')
    ];

    $this->db->trans_begin();

    if ($laporan_lama) {
      $this->db->where('id', $laporan_lama->id)->update('tb_aset_spg', $data_laporan);
    } else {
      $this->db->insert('tb_aset_spg', $data_laporan);
    }

    $total_aset = (int) $this->db->where('id_toko', $id_toko)->count_all_results('tb_aset_toko');
    $total_selesai = (int) $this->db->query(
      "SELECT COUNT(DISTINCT id_aset) AS total
      FROM tb_aset_spg
      WHERE id_toko = ?
        AND tanggal >= ?
        AND tanggal < ?",
      [$id_toko, $periode_awal, $periode_akhir]
    )->row()->total;
    $semua_selesai = $total_aset > 0 && $total_selesai >= $total_aset;

    if ($this->db->trans_status() === false) {
      $this->db->trans_rollback();
      return $this->json_response(false, 'Data aset gagal disimpan. Silakan coba lagi.', [], 500);
    }

    $this->db->trans_commit();

    if ($laporan_lama && !empty($laporan_lama->gambar) && $laporan_lama->gambar !== $upload_data['file_name']) {
      $foto_lama = $this->upload_path . basename($laporan_lama->gambar);
      if (is_file($foto_lama)) {
        @unlink($foto_lama);
      }
    }

    return $this->json_response(true, 'Aset berhasil diperbarui.', [
      'file_name' => $upload_data['file_name'],
      'completed' => $total_selesai,
      'total' => $total_aset,
      'all_completed' => $semua_selesai
    ]);
  }

  public function update()
  {
    if (strtoupper($this->input->method()) !== 'POST') {
      redirect('spg/Aset');
      return;
    }

    $id_toko = (int) $this->session->userdata('id_toko');
    $total_aset = (int) $this->db->where('id_toko', $id_toko)->count_all_results('tb_aset_toko');

    if ($total_aset > 0) {
      $periode_awal = date('Y-m-01 00:00:00');
      $periode_akhir = date('Y-m-01 00:00:00', strtotime('+1 month'));
      $total_selesai = (int) $this->db->query(
        "SELECT COUNT(DISTINCT laporan.id_aset) AS total
        FROM tb_aset_spg laporan
        JOIN tb_aset_toko aset
          ON aset.id = laporan.id_aset
          AND aset.id_toko = laporan.id_toko
        WHERE laporan.id_toko = ?
          AND laporan.tanggal >= ?
          AND laporan.tanggal < ?",
        [$id_toko, $periode_awal, $periode_akhir]
      )->row()->total;

      if ($total_selesai < $total_aset) {
        tampil_alert('error', 'Belum Selesai', 'Masih ada aset yang harus diperbarui.');
        redirect('spg/Aset');
        return;
      }
    } elseif (!$this->input->post('terms')) {
      tampil_alert('error', 'Belum Lengkap', 'Konfirmasi aset kosong wajib dicentang.');
      redirect('spg/Aset');
      return;
    }

    $this->db->where('id', $id_toko)->update('tb_toko', ['status_aset' => 1]);
    tampil_alert('success', 'Berhasil', 'Data Aset berhasil disimpan!');
    redirect('spg/Aset');
  }

  public function deleteFotoAset()
  {
    if (strtoupper($this->input->method()) !== 'POST') {
      return $this->json_response(false, 'Metode permintaan tidak diizinkan.', [], 405);
    }

    $id_toko = (int) $this->session->userdata('id_toko');
    $id_aset_toko = (int) $this->input->post('id_aset_toko');
    if ($id_aset_toko <= 0) {
      return $this->json_response(false, 'Data aset tidak valid.', [], 422);
    }

    $toko = $this->db->select('status_aset')->get_where('tb_toko', ['id' => $id_toko])->row();
    if (!$toko || (int) $toko->status_aset === 1) {
      return $this->json_response(false, 'Laporan aset sudah diselesaikan dan tidak dapat dihapus.', [], 409);
    }

    $periode_awal = date('Y-m-01 00:00:00');
    $periode_akhir = date('Y-m-01 00:00:00', strtotime('+1 month'));
    $laporan = $this->db->query(
      "SELECT laporan.id, laporan.gambar
      FROM tb_aset_spg laporan
      JOIN tb_aset_toko aset ON aset.id = laporan.id_aset
      WHERE laporan.id_aset = ?
        AND laporan.id_toko = ?
        AND aset.id_toko = ?
        AND laporan.tanggal >= ?
        AND laporan.tanggal < ?",
      [$id_aset_toko, $id_toko, $id_toko, $periode_awal, $periode_akhir]
    )->result();

    if (empty($laporan)) {
      return $this->json_response(false, 'Data upload aset tidak ditemukan.', [], 404);
    }

    $this->db->where('id_aset', $id_aset_toko)
      ->where('id_toko', $id_toko)
      ->where('tanggal >=', $periode_awal)
      ->where('tanggal <', $periode_akhir)
      ->delete('tb_aset_spg');

    if ($this->db->affected_rows() < 1) {
      return $this->json_response(false, 'Data upload gagal dihapus.', [], 500);
    }

    foreach ($laporan as $data_laporan) {
      if (empty($data_laporan->gambar)) continue;

      $masih_digunakan = $this->db->where('gambar', $data_laporan->gambar)
        ->count_all_results('tb_aset_spg') > 0;
      $foto = $this->upload_path . basename($data_laporan->gambar);
      if (!$masih_digunakan && is_file($foto)) {
        @unlink($foto);
      }
    }

    return $this->json_response(true, 'Data upload aset berhasil dihapus.');
  }

  private function compress_image($file_path)
  {
    if (@getimagesize($file_path) === false) {
      return false;
    }

    if (!extension_loaded('gd')) {
      log_message('debug', 'GD extension tidak aktif. Foto aset memakai hasil kompresi dari browser.');
      return true;
    }

    $config = [
      'image_library' => 'gd2',
      'source_image' => $file_path,
      'new_image' => $file_path,
      'create_thumb' => false,
      'maintain_ratio' => true,
      'width' => 1280,
      'height' => 1280,
      'quality' => '75%'
    ];

    $this->load->library('image_lib');
    $this->image_lib->clear();
    $this->image_lib->initialize($config);
    $berhasil = $this->image_lib->resize();
    $this->image_lib->clear();

    return $berhasil;
  }

  private function sanitize_file_part($value)
  {
    $value = trim((string) $value);
    $value = preg_replace('/[^A-Za-z0-9]+/', '-', $value);
    return trim($value, '-');
  }

  private function json_response($success, $message, $data = [], $status_code = 200)
  {
    return $this->output
      ->set_status_header($status_code)
      ->set_content_type('application/json')
      ->set_output(json_encode(array_merge([
        'success' => (bool) $success,
        'message' => $message
      ], $data)));
  }
}
