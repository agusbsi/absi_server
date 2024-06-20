<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengiriman extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "6") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_admin');
    $this->load->model('M_support');
  }
  public function index()
  {
    $data['title'] = 'Pengiriman Barang';
    $tanggal = $this->input->post('tanggal');
    $kategori = $this->input->post('kategori');
    $data['kat'] = "";
    $data['tgl'] = "";
    if (!empty($kategori) && !empty($tanggal)) {
      list($awal, $akhir) = explode(' - ', $tanggal);
      $data['list'] = $this->db->query("
            SELECT tp.*, tt.nama_toko,tu.nama_user
            FROM tb_pengiriman tp
            JOIN tb_toko tt ON tp.id_toko = tt.id
            join tb_user tu on tp.id_user = tu.id
            WHERE tp.created_at >= ? AND tp.created_at <= ? 
            AND (tp.id LIKE ? OR tt.nama_toko LIKE ?)
        ", [$awal, $akhir, "%$kategori%", "%$kategori%"])->result();
      $data['kat'] = $kategori;
      $data['tgl'] = $tanggal;
    } else if (empty($kategori) && !empty($tanggal)) {
      list($awal, $akhir) = explode(' - ', $tanggal);
      $data['list'] = $this->db->query("
      SELECT tp.*, tt.nama_toko,tu.nama_user
      FROM tb_pengiriman tp
      JOIN tb_toko tt ON tp.id_toko = tt.id
      join tb_user tu on tp.id_user = tu.id
      WHERE tp.created_at >= ? AND tp.created_at <= ?
  ", [$awal, $akhir])->result();
      $data['tgl'] = $tanggal;
    } else if (!empty($kategori) && empty($tanggal)) {
      $data['list'] = $this->db->query("
      SELECT tp.*, tt.nama_toko, tu.nama_user
      FROM tb_pengiriman tp
      JOIN tb_toko tt ON tp.id_toko = tt.id
      join tb_user tu on tp.id_user = tu.id
      AND (tp.id LIKE ? OR tt.nama_toko LIKE ?)
  ", ["%$kategori%", "%$kategori%"])->result();
      $data['kat'] = $kategori;
    } else {
      $data['list'] = $this->db->query("SELECT tp.*, tt.nama_toko, tu.nama_user from tb_pengiriman tp
      join tb_toko tt on tp.id_toko = tt.id
      join tb_user tu on tp.id_user = tu.id
      order by tp.id desc limit 500")->result();
    }

    $this->template->load('template/template', 'manager_mv/pengiriman/index', $data);
  }
  public function detail($id_kirim)
  {
    $data['title'] = 'Pengiriman Barang';
    $data['pengiriman'] = $this->db->query("SELECT tp.*, tt.nama_toko,tt.alamat, tt.telp, tu.nama_user, tk.nama_user as spg from tb_pengiriman tp
    join tb_toko tt on tp.id_toko = tt.id
    join tb_user tu on tp.id_user = tu.id
    join tb_user tk on tt.id_spg = tk.id
    where tp.id ='$id_kirim'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tpk.nama_produk, tpk.satuan,tpk.kode,tpk.harga_jawa as het_jawa, tpk.harga_indobarat as het_indobarat, tk.het from tb_pengiriman_detail tpd
    join tb_pengiriman tp on tpd.id_pengiriman = tp.id
    join tb_produk tpk on tpd.id_produk = tpk.id
    join tb_toko tk ON tp.id_toko = tk.id
    where tpd.id_pengiriman = '$id_kirim'")->result();

    $this->template->load('template/template', 'manager_mv/pengiriman/detail', $data);
  }
  public function approve()
  {
    $id_user = $this->session->userdata('id');
    $pt = $this->session->userdata('pt');
    $id_kirim     = $this->input->post('id_kirim');
    $id_po     = $this->input->post('id_po');
    $catatan     = $this->input->post('catatan');
    $pembuat     = $this->db->query("SELECT nama_user from tb_user where id ='$id_user'")->row()->nama_user;
    date_default_timezone_set('Asia/Jakarta');
    $update_at         = date('Y-m-d h:i:s');
    $this->db->trans_start();
    $where  = array('id' => $id_kirim);
    $data   = array(
      'status'  => '1',
      'updated_at'  => $update_at,
    );
    $this->db->update('tb_pengiriman', $data, $where);
    // Update permintaan
    $this->db->query("UPDATE tb_permintaan SET status = 4, updated_at = '$update_at' WHERE id = '$id_po'");
    // Insert histori
    $histori = array(
      'id_po' => $id_po,
      'aksi' => 'Disetujui oleh :',
      'pembuat' => $pembuat,
      'catatan' => $catatan
    );

    $this->db->insert('tb_po_histori', $histori);
    // Kirim notifikasi WA gudang
    $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE role = 5 AND status = 1")->result_array();
    $message = "Nomor Pengiriman ( " . $id_kirim . " - " . $pt . " ) Sudah di setujui, silahkan kunjungi s.id/absi-app";
    foreach ($phones as $phone) {
      $number = $phone['no_telp'];
      $hp = substr($number, 0, 1);

      if ($hp == '0') {
        $number = '62' . substr($number, 1);
      }

      kirim_wa($number, $message);
    }
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      // Handle transaction failure
      tampil_alert('error', 'Gagal', 'Data Pengiriman Barang gagal diproses.');
    } else {
      tampil_alert('success', 'Berhasil', 'Data Pengiriman Barang berhasil diproses.');
    }
    redirect(base_url('sup/Pengiriman'));
  }
}
