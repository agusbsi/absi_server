<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "4") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_spg');
    $this->load->model('M_admin');
    $this->load->model('M_produk');
  }

  // menampilkan pengiriman
  public function index()
  {
    $data['title'] = 'Penerimaan Barang';
    $id_toko = $this->session->userdata('id_toko');
    $data['list_data'] = $this->M_spg->get_penerimaan($id_toko)->result();
    $this->template->load('template/template', 'spg/penerimaan/lihat_data', $data);
  }
  // detail penerimaan
  public function terima($no_penerimaan)
  {
    $data['title'] = 'Penerimaan Barang';
    $data['terima'] = $this->db->query("SELECT * from tb_pengiriman where id = '$no_penerimaan'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tp.kode, tp.nama_produk, tp.satuan from tb_pengiriman_detail tpd
    join tb_produk tp on tpd.id_produk = tp.id
    where tpd.id_pengiriman = '$no_penerimaan' AND tpd.qty != 0 order by tp.kode ASC")->result();
    $this->template->load('template/template', 'spg/penerimaan/terima', $data);
  }
  public function detail($no_penerimaan)
  {
    $data['title'] = 'Penerimaan Barang';
    $id_toko = $this->session->userdata('id_toko');
    $data['terima'] = $this->db->query("SELECT * from tb_pengiriman where id = '$no_penerimaan'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tp.kode, tp.nama_produk, tp.satuan from tb_pengiriman_detail tpd
    join tb_produk tp on tpd.id_produk = tp.id
    where tpd.id_pengiriman = '$no_penerimaan' order by tp.kode ASC")->result();
    $data['artikel_new'] = $this->db->query("SELECT ts.*, tb_produk.kode, tb_produk.nama_produk from tb_stok ts
    join tb_produk on ts.id_produk = tb_produk.id
    where ts.id_toko = '$id_toko'")->result();
    $this->template->load('template/template', 'spg/penerimaan/detail', $data);
  }
  // fungsi terima barang
  public function terima_barang()
  {
    $id_penerima = $this->session->userdata('id');
    $username = $this->session->userdata('username');
    $id_produk = $this->input->POST('id_produk');
    $id_detail = $this->input->POST('id_detail');
    $id_kirim = $this->input->post('id_kirim');
    $catatan_spg = $this->input->POST('catatan');
    $id_po = $this->input->post('id_po');
    $id_toko = $this->input->post('id_toko');
    $qty = $this->input->post('qty');
    $qty_terima = $this->input->post('qty_terima');
    $unique_id = $this->input->post('unique_id');
    $spg = $this->db->query("SELECT nama_user from tb_user where id ='$id_penerima'")->row()->nama_user;
    $nilai = count($id_produk);
    $selisih = 0;

    if ($this->db->get_where('tb_pengiriman', array('id_unik' => $unique_id))->num_rows() > 0) {
      tampil_alert('info', 'INTERNET ANDA LEMOT', 'Data penerimaan Artikel sedang di proses dan tetap akan disimpan.');
      redirect(base_url('spg/Penerimaan'));
      return;
    }
    $this->db->trans_start();
    for ($i = 0; $i < $nilai; $i++) {
      $d_id_produk = $id_produk[$i];
      $d_id_detail = $id_detail[$i];
      $d_qty_diterima = (float) $qty_terima[$i];
      $d_qty = (float) $qty[$i];
      $data_detail = array(
        'qty_diterima' =>  $d_qty_diterima,
      );
      $stok = $this->db->get_where('tb_stok', array('id_produk' => $d_id_produk, 'id_toko' => $id_toko))->row()->qty;
      if ($stok === null) {
        $stok = 0;
      }
      $this->db->where('id', $d_id_detail);
      $this->db->update('tb_pengiriman_detail', $data_detail);
      if ($d_qty != $d_qty_diterima) {
        $selisih += 1;
      }
      // Update tb_stok
      $this->db->set('updated_at', 'NOW()', FALSE);
      $this->db->set('qty', $stok + $d_qty_diterima, FALSE);
      $this->db->where('id_produk', $d_id_produk);
      $this->db->where('id_toko', $id_toko);
      $this->db->update('tb_stok');
      // Insert into tb_kartu_stok

      $kartu = array(
        'no_doc' => $id_kirim,
        'id_produk' => $d_id_produk,
        'id_toko' => $id_toko,
        'masuk' => $d_qty_diterima,
        'stok' => $stok,
        'sisa' => $stok + $d_qty_diterima,
        'keterangan' => 'Terima Barang',
        'pembuat' => $username
      );
      $this->db->insert('tb_kartu_stok', $kartu);
    }
    $status = ($selisih == 0) ? 2 : 3;
    $where = array('id' => $id_kirim);
    $data = array(
      'status' => $status,
      'updated_at' => date('Y-m-d H:i:s'),
      'id_penerima' => $id_penerima,
      'catatan_spg' => $catatan_spg,
      'id_unik' => $unique_id
    );
    $this->db->update('tb_pengiriman', $data, $where);
    $where2 = array('id' => $id_po);
    $data2 = array(
      'status' => 6,
      'updated_at' => date('Y-m-d H:i:s'),
    );
    $this->db->update('tb_permintaan', $data2, $where2);
    // Insert histori
    $histori = array(
      'id_po' => $id_po,
      'aksi' => 'Diterima oleh : ',
      'pembuat' => $spg,
      'catatan' => $catatan_spg
    );

    $this->db->insert('tb_po_histori', $histori);
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      tampil_alert('error', 'Gagal', 'Terjadi kesalahan saat menyimpan data.');
    } else {
      $this->cart->destroy();
      tampil_alert('success', 'Berhasil', 'Data berhasil disimpan!');
    }

    redirect(base_url('spg/Penerimaan/detail/' . $id_kirim));
  }
}
