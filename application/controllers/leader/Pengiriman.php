<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengiriman extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "3") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_admin');
  }

  //  fungsi lihat data
  public function index()
  {
    $id_leader = $this->session->userdata('id');
    $data['title'] = 'Pengiriman';
    $data['list_data'] = $this->db->query("SELECT tp.*, tk.nama_toko from tb_pengiriman tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        where tk.id_leader = '$id_leader' order by tp.id desc")->result();
    $this->template->load('template/template', 'leader/pengiriman/lihat_data', $data);
  }
  // detail Pengiriman
  public function detail($no_Pengiriman)
  {

    $data['title'] = 'Pengiriman';
    $data['po'] = $this->db->query("SELECT * from tb_pengiriman where id = '$no_Pengiriman'")->row();
    $data['detail'] = $this->db->query("SELECT td.*,tpk.kode as kode_produk, tpk.nama_produk, tpk.satuan  from tb_pengiriman_detail td
        JOIN tb_pengiriman tp on td.id_pengiriman = tp.id
        JOIN tb_produk tpk on td.id_produk = tpk.id
        where td.id_pengiriman = '$no_Pengiriman'")->result();
    $this->template->load('template/template', 'leader/pengiriman/detail', $data);
  }
}
