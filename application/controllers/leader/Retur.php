<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Retur extends CI_Controller
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
    $data['title'] = 'Retur';
    $data['list_data'] = $this->db->query("SELECT tp.*, tk.nama_toko from tb_retur tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        where tk.id_leader = '$id_leader' and tp.status < 10 order by tp.id desc ")->result();
    $this->template->load('template/template', 'leader/retur/lihat_data', $data);
  }
  // detail permintaan
  public function detail_p($Retur)
  {
    $id_user = $this->session->userdata('id');
    $cekTTD = $this->db->query("SELECT ttd from tb_user where id = ?", array($id_user))->row();
    if (empty($cekTTD->ttd)) {
      popup('Tanda Tangan Digital', 'Anda harus membuat TTD Digital terlebih dahulu sebelum memverifikasi Retur', 'Profile');
      redirect('leader/Retur');
    }
    $data['title'] = 'Retur';
    $data['retur'] = $this->db->query("SELECT tp.*, tk.nama_toko, tk.alamat, tk.telp, tu.nama_user as spg from tb_retur tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        JOIN tb_user tu on tp.id_user = tu.id
        where tp.id = '$Retur'")->row();
    $data['detail_permintaan'] = $this->db->query("SELECT td.*,tpk.kode as kode_produk, tpk.nama_produk, tpk.satuan  from tb_retur_detail td
        JOIN tb_retur tp on td.id_retur = tp.id
        JOIN tb_produk tpk on td.id_produk = tpk.id
        where td.id_retur = '$Retur'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_retur_histori tro
    join tb_retur tr on tro.id_retur = tr.id where tro.id_retur = '$Retur'")->result();
    $this->template->load('template/template', 'leader/retur/detail', $data);
  }
  public function tindakan()
  {
    $catatan = $this->input->post('catatan_leader');
    $action = $this->input->post('tindakan');
    $tgl_jemput = $this->input->post('tgl_jemput');
    $id_retur = $this->input->post('id_retur');
    $leader = $this->session->userdata('nama_user');
    $pt = $this->session->userdata('pt');
    $status = $action == "1" ? "1" : "5";
    $aksi = $action == "1" ? 'Disetujui' : 'Ditolak';

    // Update status retur
    $data = array('status' => $status, 'tgl_jemput' => $tgl_jemput);
    $where = array('id' => $id_retur);
    $this->db->update('tb_retur', $data, $where);

    // Insert history retur
    $histori = array(
      'id_retur' => $id_retur,
      'aksi' => $aksi . ' oleh : ',
      'pembuat' => $leader,
      'catatan_h' => $catatan
    );
    $this->db->insert('tb_retur_histori', $histori);
    if ($action == "1") {
      $hp = $this->db->select('no_telp')
        ->from('tb_user')
        ->where('role', 17)
        ->where('status', 1)
        ->get()
        ->row();
      if ($hp) {
        $phone = $hp->no_telp;
        $message = "Anda memiliki 1 Pengajuan Retur ($id_retur - $pt) yang perlu dicek, silahkan kunjungi s.id/absi-app";
        kirim_wa($phone, $message);
      } else {
        log_message('error', 'User tidak ditemukan.');
      }
    }
    tampil_alert('success', 'BERHASIL', 'Pengajuan Retur berhasil di' . $aksi);
    redirect(base_url('leader/Retur'));
  }
}
