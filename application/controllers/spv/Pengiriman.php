<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengiriman extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "2") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }

  //  fungsi lihat data
  public function index()
  {
    $id_spv = $this->session->userdata('id');
    $data['title'] = 'Pengiriman';
    $data['list_data'] = $this->db->query("SELECT tp.*, tk.nama_toko, tu.nama_user as spg from tb_pengiriman tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        LEFT JOIN tb_user tu on tk.id_spg = tu.id
        where tk.id_spv = '$id_spv' AND YEAR(tp.created_at) = YEAR(CURDATE()) order by tp.id desc")->result();
    $this->template->load('template/template', 'spv/pengiriman/index', $data);
  }
  // detail permintaan
  public function detail($id)
  {
    $data['title'] = 'Pengiriman';
    $query = $this->db->query("SELECT tp.*, tk.nama_toko, tk.alamat, tk.telp from tb_pengiriman tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        where tp.id = '$id'")->row();
    $data['kirim'] = $query;
    $data['list_data'] = $this->db->query("SELECT td.*,tpk.kode, tpk.nama_produk, tpk.satuan  from tb_pengiriman_detail td
        JOIN tb_pengiriman tp on td.id_pengiriman = tp.id
        JOIN tb_produk tpk on td.id_produk = tpk.id
        where td.id_pengiriman = '$id'")->result();
    $this->template->load('template/template', 'spv/pengiriman/detail', $data);
  }
}
