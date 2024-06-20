<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "5" and $role != "16") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_adm_gudang');
  }

  //  fungsi lihat data
  public function index()
  {
    $data['title'] = 'Permintaan Barang';
    $data['list_data'] = $this->M_adm_gudang->lihat_data()->result();
    $this->template->load('template/template', 'adm_gudang/permintaan/lihat_data', $data);
  }
  // detail permintaan
  public function detail($no_permintaan)
  {
    $data['title'] = 'Permintaan Barang';
    $data['permintaan'] = $this->db->query("SELECT tp.*, tt.nama_toko, tt.alamat from tb_permintaan tp
    join tb_toko tt on tp.id_toko = tt.id 
    where tp.id = '$no_permintaan'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tp.id_toko,tpk.*, tt.het from tb_permintaan_detail tpd
    join tb_permintaan tp on tpd.id_permintaan = tp.id
    join tb_toko tt on tp.id_toko = tt.id
    join tb_produk tpk on tpd.id_produk = tpk.id
    where tpd.id_permintaan = '$no_permintaan'")->result();

    $this->template->load('template/template', 'adm_gudang/permintaan/detail', $data);
  }
  // proses approve data terpending
  public function kirim()
  {
    $id_user           = $this->session->userdata('id');
    $pt                = $this->session->userdata('pt');
    $id_kirim          = $this->M_adm_gudang->kode_kirim();
    $id_po             = $this->input->post('id_permintaan');
    $id_toko           = $this->input->post('id_toko');
    $id_produk         = $this->input->post('id_produk');
    $qty               = $this->input->post('qty_input');
    $catatan           = $this->input->post('catatan');
    date_default_timezone_set('Asia/Jakarta');
    $update_at         = date('Y-m-d h:i:s');
    $jumlah = count($id_produk);
    $this->db->trans_start();
    $kirim = array(
      'id' => $id_kirim,
      'id_permintaan' => $id_po,
      'id_user' => $id_user,
      'status' => 0,
      'keterangan' => $catatan,
      'id_toko' => $id_toko,
    );
    // insert ke tabel pengiriman
    $this->db->insert('tb_pengiriman', $kirim);
    //  detail
    for ($i = 0; $i < $jumlah; $i++) {
      $d_id_produk = $id_produk[$i];
      $d_qty = $qty[$i];
      $detail = array(
        'id_pengiriman' => $id_kirim,
        'id_produk' => $d_id_produk,
        'qty' => $d_qty
      );
      // insert ke tabel detail pengiriman
      $this->db->insert('tb_pengiriman_detail', $detail);
    }
    // Update permintaan
    $this->db->query("UPDATE tb_permintaan SET status = 3, updated_at = '$update_at' WHERE id = '$id_po'");
    $pembuat = $this->db->query("SELECT nama_user from tb_user where id = '$id_user'")->row()->nama_user;
    // Insert histori
    $histori = array(
      'id_po' => $id_po,
      'aksi' => 'Disiapkan & kirim oleh :',
      'pembuat' => $pembuat,
      'catatan' => $catatan
    );

    $this->db->insert('tb_po_histori', $histori);

    // Kirim notifikasi WA
    $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE role = 6 AND status = 1")->result_array();
    $message = "Anda memiliki 1 Pengiriman ( " . $id_kirim . " - " . $pt . " ) yang perlu approve silahkan kunjungi s.id/absi-app";

    foreach ($phones as $phone) {
      $number = $phone['no_telp'];
      $hp = substr($number, 0, 1);

      if ($hp == '0') {
        $number = '62' . substr($number, 1);
      }

      kirim_wa($number, $message);
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      // Handle transaction failure
      tampil_alert('error', 'Gagal', 'Data PO Barang gagal diproses.');
    } else {
      tampil_alert('success', 'Berhasil', 'Data PO Barang berhasil diproses.');
    }

    redirect(base_url('adm_gudang/permintaan'));
  }
  // print packing_list
  public function packing_list($no_permintaan)
  {
    $data['title'] = 'Permintaan Barang';
    $data['permintaan'] = $this->db->query("SELECT tp.*, tt.nama_toko, tu.nama_user as spg, tt.alamat  from tb_permintaan tp
  join tb_toko tt on tp.id_toko = tt.id
  join tb_user tu on tt.id_spg = tu.id
  where tp.id = '$no_permintaan'")->result();
    $data['detail'] = $this->db->query("SELECT tpd.*, tpk.nama_produk, tpk.kode,tpk.satuan from tb_permintaan_detail tpd
  join tb_produk tpk on tpd.id_produk = tpk.id
  where tpd.id_permintaan = '$no_permintaan' and tpd.status ='1'")->result();
    $this->load->view('adm_gudang/permintaan/list_packing', $data);
  }
}
