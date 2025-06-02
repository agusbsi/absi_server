<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
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
    $data['title'] = 'Permintaan';
    $data['list_data'] = $this->db->query("SELECT tp.*, tk.nama_toko from tb_permintaan tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        where tk.id_leader = '$id_leader' order by tp.status = 0 DESC,tp.id desc")->result();
    $this->template->load('template/template', 'leader/permintaan/lihat_data', $data);
  }
  public function terima($no_permintaan)
  {

    $data['title'] = 'Permintaan';
    $data['permintaan'] = $this->db->query("SELECT * from tb_permintaan where id = '$no_permintaan'")->row();
    $data['detail_permintaan'] = $this->db->query("SELECT td.*,tpk.kode as kode_produk, tpk.nama_produk, tpk.satuan  from tb_permintaan_detail td
        JOIN tb_permintaan tp on td.id_permintaan = tp.id
        JOIN tb_produk tpk on td.id_produk = tpk.id
        where td.id_permintaan = '$no_permintaan'")->result();

    $this->template->load('template/template', 'leader/permintaan/terima', $data);
  }
  // detail permintaan
  public function detail($no_permintaan)
  {

    $data['title'] = 'Permintaan';
    $data['po'] = $this->db->query("SELECT * from tb_permintaan where id = '$no_permintaan'")->row();
    $data['detail'] = $this->db->query("SELECT td.*,tpk.kode as kode_produk, tpk.nama_produk, tpk.satuan  from tb_permintaan_detail td
        JOIN tb_permintaan tp on td.id_permintaan = tp.id
        JOIN tb_produk tpk on td.id_produk = tpk.id
        where td.id_permintaan = '$no_permintaan'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_po_histori where id_po = '$no_permintaan'")->result();
    $this->template->load('template/template', 'leader/permintaan/detail', $data);
  }

  public function hapus_item()
  {
    $id = $this->input->post('id');
    $hapus = $this->db->query("DELETE from tb_permintaan_detail where id = '$id'");
  }

  //  approve artikel
  public function approve()
  {
    $id_user = $this->session->userdata('id');

    if (!$id_user) {
      tampil_alert('error', 'GAGAL', 'Session Anda telah habis. Silakan login kembali.');
      redirect(base_url('login'));
      return;
    }

    $nama_leader = $this->db->select('nama_user')
      ->where('id', $id_user)
      ->get('tb_user')
      ->row('nama_user');

    // Terima array id_detail dan qty_acc dari form
    $id_detail_arr = $this->input->post('id_detail'); // array
    $qty_acc_arr = $this->input->post('qty_acc');     // array
    $id_permintaan = $this->input->post('id_minta');
    $catatan_leader = $this->input->post('catatan_leader', true);
    $tindakan = $this->input->post('tindakan');

    // Validasi input
    if (empty($id_detail_arr) || empty($qty_acc_arr) || empty($id_permintaan) || !isset($tindakan)) {
      tampil_alert('error', 'GAGAL', 'Data tidak lengkap atau tidak valid.');
      redirect(base_url('leader/Permintaan'));
      return;
    }

    $this->db->trans_start();

    if ($tindakan == '1') {
      // Update status permintaan menjadi disetujui
      $this->db->update('tb_permintaan', [
        'status' => '1',
        'updated_at' => date('Y-m-d H:i:s')
      ], ['id' => $id_permintaan]);

      // Siapkan data untuk update_batch
      $data_details = [];
      foreach ($id_detail_arr as $index => $id_detail) {
        $qty = isset($qty_acc_arr[$index]) ? (int)$qty_acc_arr[$index] : 0;
        $data_details[] = [
          'id' => (int)$id_detail,
          'qty_acc' => $qty,
          'status' => 1,
        ];
      }

      if (!empty($data_details)) {
        $this->db->update_batch('tb_permintaan_detail', $data_details, 'id');
      }

      $status_aksi = "Disetujui TL :";
    } else {
      // Update status permintaan menjadi ditolak
      $this->db->update('tb_permintaan', [
        'status' => '5',
        'updated_at' => date('Y-m-d H:i:s')
      ], ['id' => $id_permintaan]);

      $status_aksi = "Ditolak TL :";
    }

    // Insert histori aksi
    $this->db->insert('tb_po_histori', [
      'id_po' => $id_permintaan,
      'aksi' => $status_aksi,
      'pembuat' => $nama_leader,
      'catatan' => $catatan_leader
    ]);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      tampil_alert('error', 'GAGAL', 'Terjadi kesalahan saat memproses data.');
    } else {
      tampil_alert('success', 'BERHASIL', 'Permintaan artikel berhasil diproses!');
    }

    redirect(base_url('leader/Permintaan'));
  }



  public function edit($po)
  {
    $mv  = $this->session->userdata('nama_user');
    $this->db->update('tb_permintaan', array('status' => 0), array('id' => $po));
    // Insert histori
    $histori = array(
      'id_po' => $po,
      'aksi' => 'Di edit Oleh :',
      'pembuat' => $mv
    );

    $this->db->insert('tb_po_histori', $histori);
    tampil_alert('success', 'Berhasil', 'Status Data PO telah di kembalikan ke tim Leader.');
    redirect(base_url('leader/permintaan/terima/' . $po));
  }
}
