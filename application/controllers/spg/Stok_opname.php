<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok_opname extends CI_Controller
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
  }

  // tampil data Aset
  public function index()
  {
    $data['title'] = 'Stok Opname';
    $id_toko = $this->session->userdata('id_toko');
    $data['stok_produk'] = $this->db->query("SELECT ts.*, tp.kode, tp.nama_produk
    from tb_stok ts
    join tb_produk tp on ts.id_produk = tp.id
    where ts.id_toko = '$id_toko'  order by tp.kode asc")->result();

    // ambil data toko
    $data['toko'] = $this->db->query("SELECT * from tb_toko 
    where id ='$id_toko'")->row();
    // cek data status aset
    $cek = $this->db->query("SELECT status_aset FROM tb_toko WHERE id = ?", array($id_toko))->row();
    if ($cek->status_aset != 1) {
      tampil_alert('info', 'WAJIB UPDATE ASET', 'Anda harus melakukan Update Aset terlebih dahulu agar bisa Stok Opname.');
      redirect('spg/Aset');
    } else {
      $this->template->load('template/template', 'spg/stok_opname/lihat_data', $data);
    }
  }

  public function simpan_so()
  {
    $id_user       = $this->session->userdata('id');
    $id_toko       = $this->session->userdata('id_toko');
    $kode_so       = $this->M_spg->kode_so();
    $id_produk     = $this->input->post('id_produk');
    $qty_awal      = $this->input->post('qty_awal');
    $qty_input     = $this->input->post('qty_input');
    $keterangan    = $this->input->post('keterangan');
    $tgl_so        = $this->input->post('tgl_so');
    $jumlah        = count($id_produk);
    $this->db->trans_start();
    for ($i = 0; $i < $jumlah; $i++) {
      $d_id_produk     = $id_produk[$i];
      $d_qty_awal      = $qty_awal[$i];
      $d_qty_input     = $qty_input[$i];
      if (empty($d_qty_input)) {
        $d_qty_input = 0;
      }
      $data_detail = array(
        'id_so'          => $kode_so,
        'id_produk'      => $d_id_produk,
        'qty_awal'       => $d_qty_awal,
        'hasil_so'       => $d_qty_input
      );
      $this->db->insert('tb_so_detail', $data_detail);
    }
    $data = array(
      'id' => $kode_so,
      'id_toko' => $id_toko,
      'id_user' => $id_user,
      'catatan' => $keterangan,
      'tgl_so' => $tgl_so,

    );
    $this->db->insert('tb_so', $data);
    $this->db->query("UPDATE tb_toko set status_so = 1 where id = '$id_toko'");
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      tampil_alert('error', 'Gagal', 'Terjadi kesalahan saat memproses data, coba lagi dengan jaringan yang bagus.');
    } else {
      $this->db->trans_commit();
      tampil_alert('success', 'Berhasil', 'Data berhasil diproses');
    }
    redirect('spg/Stok_opname');
  }
  // simpan penjualan
  public function saveSo()
  {
    $id_user = $this->input->post('id_user');
    $id_toko = $this->input->post('id_toko');
    $detail = $this->input->post('detail');
    $response = [];

    if (empty($id_toko) || empty($id_user)) {
      $response['success'] = false;
      $response['message'] = 'ID toko atau ID user tidak valid.';
      header('Content-Type: application/json');
      echo json_encode($response);
      return;
    }

    $id_so = $this->kodeSo();
    $data_so = array(
      'id' => $id_so,
      'id_toko' => $id_toko,
      'id_user' => $id_user,
    );

    $this->db->trans_start();

    $this->db->insert('tb_so', $data_so);

    if (is_array($detail)) {
      foreach ($detail as $d) {
        $data_detail = array(
          'id_so' => $id_so,
          'id_produk' => $d['id_produk'],
          'qty' => $d['qty'],
          'hasil_so' => $d['hasil_so'],
        );
        $this->db->insert('tb_so_detail', $data_detail);
      }
    }
    $this->db->query("UPDATE tb_toko set status_so = 1 where id = '$id_toko'");
    if ($this->db->trans_complete()) {
      $response['success'] = true;
      $response['message'] = 'Berhasil';
    } else {
      $response['success'] = false;
      $response['message'] = 'Gagal menyimpan transaksi.';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
  }

  //   no so otomatis
  public function kodeSo()
  {
    date_default_timezone_set('Asia/Jakarta');
    $q = $this->db->query("SELECT MAX(RIGHT(id, 4)) AS kd_max FROM tb_so WHERE DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')");
    $kd = "";

    if ($q->num_rows() > 0) {
      foreach ($q->result() as $k) {
        $tmp = ((int)$k->kd_max) + 1;
        $kd = sprintf("%04s", $tmp);
      }
    } else {
      $kd = "0001";
    }

    return "SO-" . date('ym') . "-" . $kd;
  }
}
