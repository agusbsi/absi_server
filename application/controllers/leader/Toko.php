<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "3") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }

  // tampil data Aset
  public function index()
  {
    $id_leader = $this->session->userdata('id');
    $data['title'] = 'Kelola Toko';
    $data['toko'] = $this->db->query("SELECT tt.*, tu.nama_user
    from tb_toko tt
    left join tb_user tu on tt.id_spg = tu.id
    where tt.id_leader = $id_leader AND tt.status IN (1,7) order by tt.id desc")->result();
    $this->template->load('template/template', 'leader/toko/lihat_data', $data);
  }

  // Script profil toko
  public function profil($id_toko)
  {
    $id_leader = $this->session->userdata('id');
    $data['title']         = 'Kelola Toko';
    $data['toko']          = $this->db->query("SELECT tt.*, tu.nama_user as spg from tb_toko tt
    LEFT join tb_user tu on tt.id_spg = tu.id
    where tt.id = '$id_toko'")->row();
    $data['cek_status'] = $this->db->query("SELECT status from tb_toko where id = '$id_toko'")->row();
    //  list SPG
    $data['list_spg']  = $this->db->query("SELECT * from tb_user 
    where status = 1 and role = 4 ")->result();
    //  lihat leader toko
    $data['leader_toko']   = $this->db->query("SELECT tt.*, tb_user.nama_user
     from tb_toko tt
     join tb_user on tt.id_leader = tb_user.id
     where tt.id = '$id_toko' and tt.id_leader = '$id_leader' ")->result();
    //  lihat spg
    $data['spg']   = $this->db->query("SELECT tt.*,tb_user.nama_user 
     from tb_toko tt
     join tb_user on tt.id_spg = tb_user.id
     where tt.id = '$id_toko' and tt.id_leader = '$id_leader' ")->result();
    //  stok produk per toko
    $data['stok_produk']   = $this->db->query("SELECT tb_produk.nama_produk, tb_produk.satuan, tb_produk.kode, tb_stok.*, tb_produk.harga_jawa, tb_produk.harga_indobarat, tb_toko.diskon from tb_stok
    join tb_produk on tb_stok.id_produk = tb_produk.id
    join tb_toko on tb_stok.id_toko = tb_toko.id
    where tb_stok.id_toko = '$id_toko' order by tb_stok.qty desc")->result();
    //  cek status di stok masing" toko
    $data['cek_status_stok']  = $this->db->query("SELECT status from tb_stok where id_toko = '$id_toko' and status = 2 ")->num_rows();
    $this->template->load('template/template', 'leader/toko/profil', $data);
  }
}
