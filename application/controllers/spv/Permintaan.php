<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
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
    $data['title'] = 'Permintaan';
    $data['list_data'] = $this->db->query("SELECT tp.*, tk.nama_toko, tu.nama_user as spg from tb_permintaan tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        JOIN tb_user tu on tk.id_spg = tu.id
        where tk.id_spv = '$id_spv' order by tp.id desc")->result();
    $this->template->load('template/template', 'spv/permintaan/lihat_data', $data);
  }
  // detail permintaan
  public function detail_p($no_permintaan)
  {

    $data['title'] = 'Permintaan';
    $data['p'] = $this->db->query("SELECT tp.*, tk.nama_toko, tk.alamat, tk.telp, tu.nama_user as spg from tb_permintaan tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        JOIN tb_user tu on tp.id_user = tu.id
        where tp.id = '$no_permintaan'")->row();
    $data['detail_permintaan'] = $this->db->query("SELECT td.*,tpk.kode as kode_produk, tpk.nama_produk, tpk.satuan  from tb_permintaan_detail td
        JOIN tb_permintaan tp on td.id_permintaan = tp.id
        JOIN tb_produk tpk on td.id_produk = tpk.id
        where td.id_permintaan = '$no_permintaan'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_po_histori tpo
    join tb_permintaan tp on tpo.id_po = tp.id where tpo.id_po = '$no_permintaan'")->result();

    $this->template->load('template/template', 'spv/permintaan/detail', $data);
  }
}
