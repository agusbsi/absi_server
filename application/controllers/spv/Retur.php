<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Retur extends CI_Controller
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
  public function index()
  {
    $id_spv = $this->session->userdata('id');
    $data['title'] = 'Retur';
    $data['list_data'] = $this->db->query("SELECT tp.*, tk.nama_toko, tu.nama_user as spg from tb_retur tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        LEFT JOIN tb_user tu on tk.id_spg = tu.id
        where tk.id_spv = '$id_spv' AND YEAR(tp.created_at) = YEAR(CURDATE()) AND tp.status <= 9 order by tp.id desc")->result();
    $this->template->load('template/template', 'spv/retur/index', $data);
  }
  public function detail($id)
  {
    $data['title'] = 'Retur';
    $query = $this->db->query("SELECT tp.*, tk.nama_toko, tk.alamat, tk.telp from tb_retur tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        where tp.id = '$id'")->row();
    $data['kirim'] = $query;
    $data['list_data'] = $this->db->query("SELECT td.*,tpk.kode, tpk.nama_produk, tpk.satuan  from tb_retur_detail td
        JOIN tb_retur tp on td.id_retur = tp.id
        JOIN tb_produk tpk on td.id_produk = tpk.id
        where td.id_retur = '$id'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_retur_histori tro
    join tb_retur tr on tro.id_retur = tr.id where tro.id_retur = '$id'")->result();
    $this->template->load('template/template', 'spv/retur/detail', $data);
  }
}
