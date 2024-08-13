<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bap extends CI_Controller
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
    $data['title'] = 'Bap';
    $data['list_data'] = $this->db->query("SELECT tp.*, tk.nama_toko, tu.nama_user as spg from tb_bap tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        JOIN tb_user tu on tp.id_user = tu.id
        where tk.id_leader = '$id_leader' order by tp.status = 0 desc, tp.id desc ")->result();
    $this->template->load('template/template', 'leader/bap/lihat_data', $data);
  }
  // detail permintaan
  public function detail_p($Bap)
  {
    $data['title'] = 'Bap';
    $data['bap'] = $this->db->query("SELECT tp.*, tk.nama_toko, tk.alamat, tk.telp, tu.nama_user as spg from tb_bap tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        JOIN tb_user tu on tp.id_user = tu.id
        where tp.id = '$Bap'")->row();
    $data['detail_bap'] = $this->db->query("SELECT td.*,tpk.kode as kode_produk, tpk.nama_produk, tpk.satuan  from tb_bap_detail td
        JOIN tb_bap tp on td.id_bap = tp.id
        JOIN tb_produk tpk on td.id_produk = tpk.id
        where td.id_bap = '$Bap'")->result();
    $this->template->load('template/template', 'leader/bap/detail', $data);
  }
  public function simpan()
  {
    $id_bap = $this->input->post('id_bap');
    $tindakan = $this->input->post('tindakan');
    $catatan_leader = $this->input->post('catatan_leader');
    $where = array('id' => $id_bap);
    $data = array(
      'status' => $tindakan,
      'catatan_leader' => $catatan_leader
    );
    if ($tindakan == 1) {
      $pesan = "Di setujui. ";
    } else {
      $pesan = "Di tolak. ";
    }
    $this->db->update('tb_bap', $data, $where);
    tampil_alert('success', 'Berhasil', 'Data Pengajuan BAP berhasil ' . $pesan);
    redirect(base_url('leader/Bap/detail_p/' . $id_bap));
  }
}
