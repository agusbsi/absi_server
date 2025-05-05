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
    $nama_perusahaan = $this->session->userdata('pt');
    $id_user = $this->session->userdata('id');
    $nama_leader = $this->db->query("SELECT nama_user FROM tb_user WHERE id = ?", array($id_user))->row()->nama_user;

    $id_detail = $this->input->post('id_detail');
    $id_permintaan = $this->input->post('id_minta');
    $catatan_leader = $this->input->post('catatan_leader');
    $tindakan = $this->input->post('tindakan');
    $qty_acc = $this->input->post('qty_acc');

    // Validasi awal
    if (empty($id_detail) || empty($id_permintaan) || $tindakan === null) {
      tampil_alert('error', 'GAGAL', 'Data tidak lengkap.');
      redirect(base_url('leader/Permintaan'));
      return;
    }

    $jumlah_item = count($id_detail);

    // Mulai transaksi database
    $this->db->trans_start();

    if ($tindakan == 1) {
      // Setujui permintaan
      $this->db->update('tb_permintaan', [
        'status' => '1',
        'updated_at' => date('Y-m-d H:i:s')
      ], ['id' => $id_permintaan]);

      // Siapkan data untuk update_batch
      $data_details = [];
      for ($i = 0; $i < $jumlah_item; $i++) {
        $data_details[] = [
          'id' => $id_detail[$i],
          'qty' => isset($qty_acc[$i]) ? $qty_acc[$i] : 0,
          'status' => 1
        ];
      }

      // Update detail permintaan
      $this->db->update_batch('tb_permintaan_detail', $data_details, 'id');

      $status_aksi = "Disetujui TL : ";

      // Kirim WA ke user dengan role 6 dan 8
      $user_tujuan = $this->db->select('no_telp')
        ->where_in('role', [6, 8])
        ->where('status', 1)
        ->get('tb_user')
        ->result_array();

      $pesan_wa = "Anda memiliki PO Barang ( $nama_perusahaan ) yang perlu di cek, silahkan kunjungi s.id/absi-app";

      foreach ($user_tujuan as $u) {
        $nomor = $u['no_telp'];
        if (substr($nomor, 0, 1) === '0') {
          $nomor = '62' . substr($nomor, 1);
        }
        kirim_wa($nomor, $pesan_wa);
      }
    } else {
      // Tolak permintaan
      $this->db->update('tb_permintaan', [
        'status' => '5',
        'updated_at' => date('Y-m-d H:i:s')
      ], ['id' => $id_permintaan]);

      $status_aksi = "Ditolak TL : ";
    }

    // Simpan histori tindakan
    $this->db->insert('tb_po_histori', [
      'id_po' => $id_permintaan,
      'aksi' => $status_aksi,
      'pembuat' => $nama_leader,
      'catatan' => $catatan_leader
    ]);

    $this->db->trans_complete();

    // Periksa status transaksi
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
