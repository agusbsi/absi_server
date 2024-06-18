<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Retur extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    if ($this->session->userdata('status') != 'login') {
      redirect(base_url());
    }
  }


  public function index()
  {
    $data['title'] = 'Retur Barang';
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
            FROM tb_retur tp
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
      FROM tb_retur tp
      JOIN tb_toko tt ON tp.id_toko = tt.id
      WHERE tp.created_at >= ? AND tp.created_at <= ?
  ", [$awal, $akhir])->result();
      $data['tgl'] = $tanggal;
    } else if (!empty($kategori) && empty($tanggal)) {
      $data['list'] = $this->db->query("
      SELECT tp.*, tt.nama_toko
      FROM tb_retur tp
      JOIN tb_toko tt ON tp.id_toko = tt.id
      AND (tp.id LIKE ? OR tt.nama_toko LIKE ?)
  ", ["%$kategori%", "%$kategori%"])->result();
      $data['kat'] = $kategori;
    } else {
      $data['list'] = $this->db->query("
            SELECT tp.*, tt.nama_toko
            FROM tb_retur tp
            JOIN tb_toko tt ON tp.id_toko = tt.id ORDER BY tp.id DESC LIMIT 1000 ")->result();
    }
    $this->template->load('template/template', 'adm/transaksi/retur', $data);
  }

  public function detail($id)
  {
    $data['title'] = 'Retur Barang';
    $data_pengiriman = $this->db->query("SELECT tp.*, tt.nama_toko, tu.username from tb_retur tp join tb_toko tt on tt.id = tp.id_toko join tb_user tu on tu.id = tp.id_user where tp.id = '$id'")->row();
    $data['detail_retur'] = $this->db->query("SELECT * from tb_retur_detail tpd join tb_produk tp on tp.id = tpd.id_produk where tpd.id_retur = '$id'")->result();

    $data['no_retur'] = $id;
    $data['tanggal'] = $data_pengiriman->created_at;
    $data['status'] = $data_pengiriman->status;
    $data['nama_toko'] = $data_pengiriman->nama_toko;
    $data['nama'] = $data_pengiriman->username;
    $this->template->load('template/template', 'adm/transaksi/retur_detail', $data);
  }
}
