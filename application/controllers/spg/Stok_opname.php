<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok_opname extends CI_Controller
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
  }

  // tampil data Aset
  public function index()
  {
    $data['title'] = 'Stok Opname';
    $id_toko = $this->session->userdata('id_toko');
    $data['stok_produk'] = $this->db->query("SELECT ts.*, tp.kode, tp.nama_produk
    from tb_stok ts
    join tb_produk tp on ts.id_produk = tp.id
    where ts.id_toko = '$id_toko'  order by tp.kode asc")->result();
    $data['toko'] = $this->db->query("SELECT * from tb_toko 
    where id ='$id_toko'")->row();
    $thn = date('Y');
    $bln = date('m');
    $data['dataSo'] = $this->db->query("SELECT * from tb_so 
    where id_toko ='$id_toko' AND YEAR(created_at) = '$thn' AND MONTH(created_at) = '$bln' ORDER BY id desc LIMIT 1 ")->row();
    $cek = $this->db->query("SELECT status_aset FROM tb_toko WHERE id = ?", array($id_toko))->row();
    if ($cek->status_aset != 1) {
      tampil_alert('info', 'WAJIB UPDATE ASET', 'Anda harus melakukan Update Aset terlebih dahulu agar bisa Stok Opname.');
      redirect('spg/Aset');
    } else {
      $this->template->load('template/template', 'spg/stok_opname/lihat_data', $data);
    }
  }

  public function simpan_so()
  {
    $id_user       = $this->session->userdata('id');
    $id_toko       = $this->session->userdata('id_toko');
    $kode_so       = $this->M_spg->kode_so();
    $id_produk     = $this->input->post('id_produk');
    $qty_awal      = $this->input->post('qty_awal');
    $qty_input     = $this->input->post('qty_input');
    $keterangan    = $this->input->post('keterangan');
    $tgl_so        = $this->input->post('tgl_so');
    $jumlah        = count($id_produk);
    $this->db->trans_start();
    for ($i = 0; $i < $jumlah; $i++) {
      $d_id_produk     = $id_produk[$i];
      $d_qty_awal      = $qty_awal[$i];
      $d_qty_input     = $qty_input[$i];
      if (empty($d_qty_input)) {
        $d_qty_input = 0;
      }
      $data_detail = array(
        'id_so'          => $kode_so,
        'id_produk'      => $d_id_produk,
        'qty_awal'       => $d_qty_awal,
        'hasil_so'       => $d_qty_input
      );
      $this->db->insert('tb_so_detail', $data_detail);
    }
    $data = array(
      'id' => $kode_so,
      'id_toko' => $id_toko,
      'id_user' => $id_user,
      'catatan' => $keterangan,
      'tgl_so' => $tgl_so,

    );
    $this->db->insert('tb_so', $data);
    $this->db->query("UPDATE tb_toko set status_so = 1 where id = '$id_toko'");
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      tampil_alert('error', 'Gagal', 'Terjadi kesalahan saat memproses data, coba lagi dengan jaringan yang bagus.');
    } else {
      $this->db->trans_commit();
      tampil_alert('success', 'Berhasil', 'Data berhasil diproses');
    }
    redirect('spg/Stok_opname');
  }
  public function detail($id, $aksi)
  {
    $data['title'] = 'Stok Opname';
    $data['aksi'] = $aksi;
    if ($aksi == 'edit') {
      $cek = $this->db->query("SELECT * FROM tb_so WHERE id = ?", array($id))->row();
      if ($cek) {
        $waktu_sekarang = strtotime(date('Y-m-d H:i:s'));
        $waktu_created = strtotime($cek->created_at);
        $selisih_jam = ($waktu_sekarang - $waktu_created) / 3600; // Konversi selisih ke jam

        if ($selisih_jam < 25 || $cek->status == 1) {
          $data['aksi'] = 'edit';
        } else {
          tampil_alert('info', 'TERKUNCI', 'Batas waktu edit berakhir, silahkan hubungi tim Operasional');
          redirect('spg/Stok_opname');
          return;
        }
      }
    } elseif ($aksi != 'tampil') {
      tampil_alert('info', 'NOT FOUND', 'Halaman tidak ditemukan, Anda diarahakan ke Dashboard.');
      redirect('spg/Dashboard');
      return;
    }
    $data['so'] = $this->db->query("SELECT * FROM tb_so WHERE id = ?", array($id))->row();
    $data['detail'] = $this->db->query(
      "SELECT tsd.*, tp.kode, tp.nama_produk as artikel
         FROM tb_so_detail tsd
         JOIN tb_produk tp ON tsd.id_produk = tp.id
         WHERE tsd.id_so = ?",
      array($id)
    )->result();
    $this->template->load('template/template', 'spg/stok_opname/detail', $data);
  }
  public function update_so()
  {
    $id_so          = $this->input->post('id_so');
    $id_detail      = $this->input->post('id_detail');
    $qty            = $this->input->post('qty');
    $tgl_so            = $this->input->post('tgl_so');
    $jumlah        = count($id_detail);
    $this->db->trans_start();
    for ($i = 0; $i < $jumlah; $i++) {
      $d_id_detail = $id_detail[$i];
      $d_qty       = $qty[$i];
      $data_detail = array(
        'hasil_so'       => $d_qty
      );
      $this->db->update('tb_so_detail', $data_detail, array('id' => $d_id_detail));
    }
    $this->db->update('tb_so', ['status' => 0, 'tgl_so' => $tgl_so], ['id' => $id_so]);
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      tampil_alert('error', 'Gagal', 'Terjadi kesalahan saat memproses data, coba lagi dengan jaringan yang bagus.');
    } else {
      $this->db->trans_commit();
      tampil_alert('success', 'Berhasil', 'Data berhasil diproses');
    }
    redirect('spg/Stok_opname/detail/' . $id_so . '/tampil');
  }
}
