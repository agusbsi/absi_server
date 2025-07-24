<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bap extends CI_Controller
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
  }

  public function index()
  {
    $data['title'] = 'Bap';
    $id_toko = $this->session->userdata('id_toko');

    $data['bap'] = $this->db->query("SELECT tb.*, tt.nama_toko FROM tb_bap tb
    JOIN tb_toko tt ON tb.id_toko = tt.id
    WHERE tb.id_toko = ?
    ORDER BY tb.id DESC", array($id_toko))->result();
    $this->template->load('template/template', 'spg/bap/index', $data);
  }
  public function selisih()
  {
    $data['title'] = 'Selisih';
    $id_toko = $this->session->userdata('id_toko');
    $data['bap'] = $this->db->query("SELECT * FROM tb_pengiriman
    WHERE id_toko = ? AND status = '3' AND id NOT IN(SELECT id_kirim FROM tb_bap)
    ORDER BY id DESC", array($id_toko))->result();

    $this->template->load('template/template', 'spg/bap/selisih', $data);
  }
  public function buat($id)
  {
    $data['title'] = 'Bap';
    $data['bap'] = $this->db->query("SELECT * FROM tb_pengiriman WHERE id = '$id'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tp.kode, tp.nama_produk as artikel from tb_pengiriman_detail tpd
    JOIN tb_produk tp on tpd.id_produk = tp.id
    WHERE tpd.id_pengiriman = '$id' AND tpd.qty != tpd.qty_diterima")->result();
    $this->template->load('template/template', 'spg/bap/buat', $data);
  }
  public function kirim()
  {
    $id_user          = $this->session->userdata('id');
    $id_toko          = $this->session->userdata('id_toko');
    $nama_user          = $this->session->userdata('nama_user');
    $id_kirim         = $this->input->post('id_kirim');
    $id_produk        = $this->input->post('id_produk');
    $kategori         = $this->input->post('kategori');
    $qty_kirim        = $this->input->post('qty_kirim');
    $qty_terima       = $this->input->post('qty_terima');
    $qty_update       = $this->input->post('qty_update');
    $catatan          = $this->input->post('catatan');
    $unique_id        = $this->input->post('unique_id');
    $jml              = count($id_produk);
    if ($this->db->get_where('tb_bap', array('id_unik' => $unique_id))->num_rows() > 0) {
      tampil_alert('info', 'INTERNET ANDA LEMOT', 'Data BAP tetap di proses dan akan di kirim.');
      redirect(base_url('spg/Bap'));
      return;
    }
    $no_urut = $this->db->query("SELECT COUNT(*) AS total FROM tb_bap WHERE id_toko = '$id_toko'")->row()->total;
    $nomorFormat = "BAP-" . date('y') . $id_toko . "-" . str_pad($no_urut + 1, 4, '0', STR_PAD_LEFT);
    $this->db->trans_start();
    $data_bap = array(
      'id_kirim'  => $id_kirim,
      'id_user'   => $id_user,
      'id_toko'   => $id_toko,
      'nomor'   => $nomorFormat,
      'status'    => '0',
      'id_unik'   => $unique_id
    );
    $this->db->insert('tb_bap', $data_bap);
    $id_bap = $this->db->insert_id();
    $data_detail = array();
    for ($i = 0; $i < $jml; $i++) {
      $data_detail[] = array(
        'id_bap' => $id_bap,
        'id_produk' => $id_produk[$i],
        'qty_kirim' => $qty_kirim[$i],
        'qty_awal' => $qty_terima[$i],
        'qty_update' => $qty_update[$i],
        'kategori' => $kategori[$i],
        'catatan' => $catatan[$i]
      );
    }
    $this->db->insert_batch('tb_bap_detail', $data_detail);
    $histori = array(
      'id_bap' => $id_bap,
      'aksi' => 'Dibuat oleh : ',
      'pembuat' => $nama_user,
    );
    $this->db->insert('tb_bap_histori', $histori);
    $this->db->trans_complete();
    tampil_alert('success', 'Berhasil', 'Berita Acara Sudah dikirim Ke Leader!');
    redirect(base_url('spg/Bap'));
  }
  public function detail($id)
  {
    $data['title'] = 'Bap';
    $data['bap'] = $this->db->query("SELECT * FROM tb_bap WHERE id = '$id'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tp.kode, tp.nama_produk as artikel, tb.catatan_leader, tb.catatan_mv from tb_bap_detail tpd
    JOIN tb_produk tp on tpd.id_produk = tp.id
    JOIN tb_bap tb on tpd.id_bap = tb.id
    WHERE tpd.id_bap = '$id'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_bap_histori where id_bap = '$id'")->result();
    $this->template->load('template/template', 'spg/bap/detail', $data);
  }
}
