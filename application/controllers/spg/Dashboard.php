<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    $id_toko = $this->session->userdata('id_toko');
    if ($role != "4") {
      tampil_alert('error', 'DITOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    if (!$id_toko) {
      tampil_alert('warning', 'Oops', 'Anda belum memilih toko, silahkan pilih toko yang akan anda kelola !');
      redirect(base_url('login/list_toko'));
    }
    $this->load->model('M_spg');
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $id_spg = $this->session->userdata('id');
    $id_toko = $this->session->userdata('id_toko');
    $data['toko_new'] = $this->db->query("SELECT * from tb_toko where id = '$id_toko'")->row();
    $data['terima'] = $this->db->query("SELECT * FROM tb_pengiriman WHERE  id_toko = '$id_toko' and status = '1'")->num_rows();
    $data['mutasi'] = $this->db->query("SELECT * FROM tb_mutasi WHERE status = '1' AND id_toko_tujuan ='$id_toko'")->num_rows();
    $data['jml'] = $this->db->query("SELECT * from tb_toko where id_spg = '$id_spg' and status IN (1,7)")->num_rows();
    $data['bap'] = $this->db->query("SELECT * FROM tb_pengiriman WHERE status = '3' AND id_toko ='$id_toko' AND id NOT IN(SELECT id_kirim FROM tb_bap WHERE status != '4')")->num_rows();
    $this->template->load('template/template', 'spg/dashboard', $data);
  }
  // menampilkan profil toko
  public function toko_spg()
  {
    $id_toko = $this->session->userdata('id_toko');
    $data['title'] = 'Toko spg';
    $data['toko'] = $this->db->query("SELECT tt.*, tl.nama_user as leader, ts.nama_user as spg from tb_toko tt
    LEFT join tb_user tl ON tl.id = tt.id_leader
    LEFT join tb_user ts ON ts.id = tt.id_spg
    where tt.id = '$id_toko'")->row();
    $data['stok_produk'] = $this->M_spg->get_stok_produk($id_toko);
    $this->template->load('template/template', 'spg/toko/lihat_data', $data);
  }
  public function get_produk_detail()
  {
    $id_produk = $this->input->post('id_produk');
    $data = $this->M_spg->get_produk_by_id($id_produk);
    echo json_encode($data);
  }
}
