<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "4") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_spg');
    $this->load->model('M_admin');
    $this->load->model('M_produk');
  }

  // menampilkan pengiriman
  public function index()
  {
    $data['title'] = 'Mutasi Barang';
    $id_toko = $this->session->userdata('id_toko');
    $data['list_data']  = $this->db->query("SELECT tm.*, tt.nama_toko as asal, tk.nama_toko as tujuan from tb_mutasi tm
    join tb_toko tt on tm.id_toko_asal = tt.id
    join tb_toko tk on tm.id_toko_tujuan = tk.id
    where tm.status = '1' and tm.id_toko_tujuan = '$id_toko'
    order by tm.created_at desc")->result();
    $this->template->load('template/template', 'spg/mutasi/lihat_data', $data);
  }
  // detail penerimaan
  public function detail($mutasi)
  {
    $id_toko = $this->session->userdata('id_toko');
    $data['title'] = 'Mutasi Barang';
    $data['mutasi'] = $this->db->query("SELECT tm.*,tu.nama_user as leader, tt.nama_toko as asal,tt.id as toko_asal, tk.nama_toko as tujuan, tt.alamat as alamat_asal, tk.alamat as alamat_tujuan from tb_mutasi tm
      join tb_toko tt on tm.id_toko_asal = tt.id
      join tb_toko tk on tm.id_toko_tujuan = tk.id
      join tb_user tu on tm.id_user = tu.id
      where tm.id = '$mutasi'")->row();
    $data['detail_mutasi']  = $this->db->query("SELECT tmd.*, tp.id as id_produk, tp.nama_produk, tp.kode, tp.satuan from tb_mutasi_detail tmd
      join tb_produk tp on tmd.id_produk = tp.id
      where tmd.id_mutasi = '$mutasi' and tmd.status='1'")->result();
    $this->template->load('template/template', 'spg/mutasi/detail', $data);
  }
  // fungsi terima barang
  public function terima()
  {
    $username = $this->session->userdata('username');
    $id_toko = $this->session->userdata('id_toko');
    $id_toko_asal = $this->input->post('id_toko_asal');
    $id_mutasi = $this->input->post('id_mutasi');
    $id_produk = $this->input->post('id_produk');
    $qty_terima = $this->input->post('qty_terima');
    $list = count($id_produk);

    $this->db->trans_start();

    for ($i = 0; $i < $list; $i++) {
      $l_id_produk = $id_produk[$i];
      $l_qty = $qty_terima[$i];

      // Check stock in the source store
      $stok_asal_query = $this->db->query("SELECT qty FROM tb_stok WHERE id_produk = ? AND id_toko = ?", array($l_id_produk, $id_toko_asal));
      $stok_asal = $stok_asal_query->row() ? $stok_asal_query->row()->qty : 0;

      // Check stock in the destination store
      $queri = $this->db->query("SELECT id_produk, qty FROM tb_stok WHERE id_produk = ? AND id_toko = ?", array($l_id_produk, $id_toko));
      $cek = $queri->num_rows();

      if ($cek > 0) {
        // Update stock in the destination store
        $this->db->query("UPDATE tb_stok SET qty = qty + ?, updated_at = NOW() WHERE id_produk = ? AND id_toko = ?", array($l_qty, $l_id_produk, $id_toko));
        // Update stock in the source store
        $this->db->query("UPDATE tb_stok SET qty = qty - ?, updated_at = NOW() WHERE id_produk = ? AND id_toko = ?", array($l_qty, $l_id_produk, $id_toko_asal));
        $stok_awal = $queri->row()->qty;
      } else {
        // Insert new stock record in the destination store
        $data_detail = array(
          'id_produk' => $l_id_produk,
          'qty' => $l_qty,
          'id_toko' => $id_toko,
          'status' => "1",
        );
        $stok_awal = 0;
        $this->db->insert('tb_stok', $data_detail);
        // Update stock in the source store
        $this->db->query("UPDATE tb_stok SET qty = qty - ?, updated_at = NOW() WHERE id_produk = ? AND id_toko = ?", array($l_qty, $l_id_produk, $id_toko_asal));
      }

      // Update detail mutasi
      $where_mutasi = array(
        'id_mutasi' => $id_mutasi,
        'id_produk' => $l_id_produk,
      );
      $detail_mutasi = array(
        'qty_terima' => $l_qty,
      );
      $this->db->update('tb_mutasi_detail', $detail_mutasi, $where_mutasi);

      // Insert into tb_kartu_stok for the destination store
      $kartu = array(
        'no_doc' => $id_mutasi,
        'id_produk' => $l_id_produk,
        'id_toko' => $id_toko,
        'masuk' => $l_qty,
        'stok' => $stok_awal,
        'sisa' => $stok_awal + $l_qty,
        'keterangan' => 'Mutasi Masuk',
        'pembuat' => $username,
      );
      $this->db->insert('tb_kartu_stok', $kartu);

      // Insert into tb_kartu_stok for the source store
      $kartu_keluar = array(
        'no_doc' => $id_mutasi,
        'id_produk' => $l_id_produk,
        'id_toko' => $id_toko_asal,
        'keluar' => $l_qty,
        'stok' => $stok_asal,
        'sisa' => $stok_asal - $l_qty,
        'keterangan' => 'Mutasi Keluar',
        'pembuat' => $username,
      );
      $this->db->insert('tb_kartu_stok', $kartu_keluar);
    }

    // Update status in the tb_mutasi table
    $where = array(
      'id' => $id_mutasi,
      'id_toko_tujuan' => $id_toko,
    );
    $list_mutasi = array(
      'status' => 2,
      'updated_at' => date('Y-m-d H:i:s'),
    );
    $this->db->update('tb_mutasi', $list_mutasi, $where);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      tampil_alert('error', 'GAGAL', 'Gagal memproses mutasi.');
    } else {
      $this->db->trans_commit();
      tampil_alert('success', 'Berhasil', 'Mutasi berhasil diproses.');
    }

    // Redirect back to the appropriate page
    redirect(base_url('spg/Mutasi'));
  }
}
