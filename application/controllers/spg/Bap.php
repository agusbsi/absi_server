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
    $data['limit'] = 5;
    $data['offset'] = 0;
    $tgl_update = '2024-08-13';

    $data['bap'] = $this->db->query("SELECT tp.*, tb.id as id_bap, tb.status as status_bap 
    FROM tb_pengiriman tp
    LEFT JOIN tb_bap tb on tp.id = tb.id_kirim AND tb.created_at > ?
    WHERE tp.id_toko = ? AND tp.status = '3'
    ORDER BY tp.id DESC", array($tgl_update, $id_toko))->result();

    $this->template->load('template/template', 'spg/bap/index', $data);
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
    $this->db->trans_start();
    $cek_kirim = $this->db->get_where('tb_bap', array('id_kirim' => $id_kirim, 'status' => 4));
    if ($cek_kirim->num_rows() > 0) {
      $id_bap = $cek_kirim->row()->id;
      $data_bap = array(
        'status'    => '0',
        'catatan_leader' => '',
        'catatan_mv'  => ''
      );
      $this->db->update('tb_bap', $data_bap, array('id' => $id_bap));
      for ($i = 0; $i < $jml; $i++) {
        $detail = array(
          'qty_kirim' => $qty_kirim[$i],
          'qty_awal' => $qty_terima[$i],
          'qty_update' => $qty_update[$i],
          'kategori' => $kategori[$i],
          'catatan' => $catatan[$i]
        );
        $where = array(
          'id_bap' => $id_bap,
          'id_produk' => $id_produk[$i]
        );
        $this->db->update('tb_bap_detail', $detail, $where);
      }
    } else {
      $data_bap = array(
        'id_kirim'  => $id_kirim,
        'id_user'   => $id_user,
        'id_toko'   => $id_toko,
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
    }
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
    $this->template->load('template/template', 'spg/bap/detail', $data);
  }
}
