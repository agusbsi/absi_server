<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi extends CI_Controller
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
    $data['title'] = 'Mutasi Barang';
    $tanggal = $this->input->post('tanggal');
    $kategori = $this->input->post('kategori');
    $awal = date('Y-m-01', strtotime('-1 month'));
    $akhir = date('Y-m-d');
    $data['kat'] = "";
    $data['tgl'] = "";
    if (!empty($kategori) && !empty($tanggal)) {
      list($awal, $akhir) = explode(' - ', $tanggal);
      $data['list'] = $this->db->query("
            SELECT tp.*, tt.nama_toko as pengirim, tk.nama_toko as tujuan
            FROM tb_mutasi tp
            JOIN tb_toko tt ON tp.id_toko_asal = tt.id
            JOIN tb_toko tk ON tp.id_toko_tujuan = tk.id
            WHERE tp.created_at >= ? AND tp.created_at <= ? 
            AND (tp.id LIKE ? OR tt.nama_toko LIKE ? OR tk.nama_toko LIKE ?)
        ", [$awal, $akhir, "%$kategori%", "%$kategori%", "%$kategori%"])->result();
      $data['kat'] = $kategori;
      $data['tgl'] = $tanggal;
    } else if (empty($kategori) && !empty($tanggal)) {
      list($awal, $akhir) = explode(' - ', $tanggal);
      $data['list'] = $this->db->query("
      SELECT tp.*, tt.nama_toko as pengirim, tk.nama_toko as tujuan
            FROM tb_mutasi tp
            JOIN tb_toko tt ON tp.id_toko_asal = tt.id
            JOIN tb_toko tk ON tp.id_toko_tujuan = tk.id
      WHERE tp.created_at >= ? AND tp.created_at <= ?
  ", [$awal, $akhir])->result();
      $data['tgl'] = $tanggal;
    } else if (!empty($kategori) && empty($tanggal)) {
      $data['list'] = $this->db->query("
     SELECT tp.*, tt.nama_toko as pengirim, tk.nama_toko as tujuan
            FROM tb_mutasi tp
            JOIN tb_toko tt ON tp.id_toko_asal = tt.id
            JOIN tb_toko tk ON tp.id_toko_tujuan = tk.id
      AND (tp.id LIKE ? OR tt.nama_toko LIKE ? OR tk.nama_toko LIKE ?)
  ", ["%$kategori%", "%$kategori%", "%$kategori%"])->result();
      $data['kat'] = $kategori;
    } else {
      $data['list'] = $this->db->query("
            SELECT tp.*, tt.nama_toko as pengirim, tk.nama_toko as tujuan
            FROM tb_mutasi tp
            JOIN tb_toko tt ON tp.id_toko_asal = tt.id
            JOIN tb_toko tk ON tp.id_toko_tujuan = tk.id
             ORDER BY tp.id DESC LIMIT 1000 ")->result();
    }
    $this->template->load('template/template', 'adm/transaksi/mutasi', $data);
  }

  public function detail($id)
  {
    $data['title'] = 'Mutasi Barang';
    $data['mutasi'] = $this->db->query("SELECT tm.*, tt.nama_toko as asal, tk.nama_toko as tujuan from tb_mutasi tm
    JOIN tb_toko tt on tm.id_toko_asal = tt.id
    JOIN tb_toko tk on tm.id_toko_tujuan = tk.id 
    where tm.id ='$id'")->row();
    $data['detail'] = $this->db->query("SELECT tmd.*, tp.kode,tp.nama_produk from tb_mutasi_detail tmd
    join tb_produk tp on tmd.id_produk = tp.id
    where tmd.id_mutasi ='$id'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_mutasi_histori tpo
    join tb_mutasi tp on tpo.id_mutasi = tp.id where tpo.id_mutasi = '$id'")->result();
    $this->template->load('template/template', 'adm/transaksi/mutasi_detail', $data);
  }
}
