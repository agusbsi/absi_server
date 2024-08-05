<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Selisih extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "6") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }
  public function index()
  {
    $data['title'] = 'Selisih Penerimaan';
    $data['selisih'] = $this->db->query("SELECT tp.*, tt.nama_toko, tu.nama_user from tb_pengiriman tp
    JOIN tb_toko tt on tp.id_toko = tt.id
    JOIN tb_user tu on tt.id_spg = tu.id
    WHERE tp.status = 3")->result();
    $this->template->load('template/template', 'manager_mv/selisih/index', $data);
  }
  public function detail($id)
  {
    $data['title'] = 'Selisih Penerimaan';
    $query = $this->db->query("SELECT tp.*, tt.nama_toko, tu.nama_user as spg from tb_pengiriman tp
    JOIN tb_toko tt on tp.id_toko = tt.id
    JOIN tb_user tu on tt.id_spg = tu.id where tp.id = '$id'");
    $data['pengiriman']  = $query->row();
    $id_po = $query->row()->id_permintaan;
    $data['detail']  = $this->db->query("SELECT tpd.*,tp.kode, tp.nama_produk from tb_pengiriman_detail tpd
    JOIN tb_produk tp on tpd.id_produk = tp.id
    where tpd.id_pengiriman = '$id'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_po_histori where id_po = '$id_po'")->result();
    $this->template->load('template/template', 'manager_mv/selisih/detail', $data);
  }
}
