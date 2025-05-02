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
    $pt = $this->session->userdata('pt');
    $id_user = $this->session->userdata('id');
    $leader = $this->db->query("SELECT nama_user FROM tb_user WHERE id = ?", array($id_user))->row()->nama_user;
    $id = $this->input->post('id_detail');
    $id_minta = $this->input->post('id_minta');
    $catatan_leader = $this->input->post('catatan_leader');
    $tindakan = $this->input->post('tindakan');
    $qty_acc = $this->input->post('qty_acc');
    $jumlah = count($id);

    // Mulai transaksi database
    $this->db->trans_start();

    if ($tindakan == 1) {
      // Update tb_permintaan
      $setuju = array(
        'status' => '1',
        'updated_at' => date('Y-m-d H:i:s')
      );

      $this->db->update('tb_permintaan', $setuju, array('id' => $id_minta));

      // Siapkan data untuk update_batch
      $data_details = [];
      for ($i = 0; $i < $jumlah; $i++) {
        $data_details[] = array(
          'id' => $id[$i],
          'qty' => $qty_acc[$i],
          'status' => 1
        );
      }

      // Batch update tb_permintaan_detail
      $this->db->update_batch('tb_permintaan_detail', $data_details, 'id');
      $aksi = "Disetujui TL : ";
      // Ambil nomor telepon user dengan sekali query
      $phones = $this->db->select('no_telp')
        ->where_in('role', [6, 8])
        ->where('status', 1)
        ->get('tb_user')
        ->result_array();
      $message = "Anda memiliki PO Barang ( $id - $pt ) yang perlu di cek, silahkan kunjungi s.id/absi-app";

      foreach ($phones as $phone) {
        $number = $phone['no_telp'];
        if (substr($number, 0, 1) == '0') {
          $number = '62' . substr($number, 1);
        }
        kirim_wa($number, $message);
      }
    } else {
      // Tolak permintaan
      $tolak = array(
        'status' => '5',
        'updated_at' => date('Y-m-d H:i:s')
      );
      $this->db->update('tb_permintaan', $tolak, array('id' => $id_minta));
      $aksi = "Ditolak TL : ";
    }
    // Insert histori
    $histori = array(
      'id_po' => $id_minta,
      'aksi' => $aksi,
      'pembuat' => $leader,
      'catatan' => $catatan_leader
    );
    $this->db->insert('tb_po_histori', $histori);
    $this->db->trans_complete();
    tampil_alert('success', 'BERHASIL', 'Permintaan artikel berhasil diproses!');
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
