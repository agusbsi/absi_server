<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengiriman extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    if ($this->session->userdata('status') != 'login') {
      redirect(base_url());
    }

    $this->load->model('M_spg');
    $this->load->model('M_produk');
  }


  public function index()
  {
    $data['title'] = 'Pengiriman Barang';
    $tanggal = $this->input->post('tanggal');
    $kategori = $this->input->post('kategori');
    $awal = date('Y-m-01', strtotime('-1 month'));
    $akhir = date('Y-m-d');
    $data['kat'] = "";
    $data['tgl'] = "";
    if (!empty($kategori) && !empty($tanggal)) {
      list($awal, $akhir) = explode(' - ', $tanggal);
      $data['list'] = $this->db->query("
            SELECT tp.*, tt.nama_toko
            FROM tb_pengiriman tp
            JOIN tb_toko tt ON tp.id_toko = tt.id
            WHERE tp.created_at >= ? AND tp.created_at <= ? 
            AND (tp.id LIKE ? OR tt.nama_toko LIKE ?)
        ", [$awal, $akhir, "%$kategori%", "%$kategori%"])->result();
      $data['kat'] = $kategori;
      $data['tgl'] = $tanggal;
    } else if (empty($kategori) && !empty($tanggal)) {
      list($awal, $akhir) = explode(' - ', $tanggal);
      $data['list'] = $this->db->query("
      SELECT tp.*, tt.nama_toko
      FROM tb_pengiriman tp
      JOIN tb_toko tt ON tp.id_toko = tt.id
      WHERE tp.created_at >= ? AND tp.created_at <= ?
  ", [$awal, $akhir])->result();
      $data['tgl'] = $tanggal;
    } else if (!empty($kategori) && empty($tanggal)) {
      $data['list'] = $this->db->query("
      SELECT tp.*, tt.nama_toko
      FROM tb_pengiriman tp
      JOIN tb_toko tt ON tp.id_toko = tt.id
      AND (tp.id LIKE ? OR tt.nama_toko LIKE ?)
  ", ["%$kategori%", "%$kategori%"])->result();
      $data['kat'] = $kategori;
    } else {
      $data['list'] = $this->db->query("
            SELECT tp.*, tt.nama_toko
            FROM tb_pengiriman tp
            JOIN tb_toko tt ON tp.id_toko = tt.id
            WHERE tp.created_at >= ? AND tp.created_at <= ?
        ", [$awal, $akhir])->result();
    }
    $this->template->load('template/template', 'adm/transaksi/pengiriman', $data);
  }

  public function detail($id)
  {
    $data['title'] = 'Pengiriman Barang';
    $data['pengiriman'] = $this->db->query("SELECT tp.*, tt.nama_toko from tb_pengiriman tp join tb_toko tt on tt.id = tp.id_toko  where tp.id = '$id'")->row();
    $data['detail'] = $this->db->query("SELECT * from tb_pengiriman_detail tpd join tb_produk tp on tp.id = tpd.id_produk where tpd.id_pengiriman = '$id'")->result();
    $this->template->load('template/template', 'adm/transaksi/pengiriman_detail', $data);
  }
}
