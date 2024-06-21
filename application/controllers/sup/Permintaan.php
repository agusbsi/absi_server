<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "6" && $role != "8") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }
  public function index()
  {
    $data['title'] = 'Permintaan Barang';
    $tanggal = $this->input->post('tanggal');
    $kategori = $this->input->post('kategori');
    $data['kat'] = "";
    $data['tgl'] = "";
    if (!empty($kategori) && !empty($tanggal)) {
      list($awal, $akhir) = explode(' - ', $tanggal);
      $data['list'] = $this->db->query("
            SELECT tp.*, tt.nama_toko
            FROM tb_permintaan tp
            JOIN tb_toko tt ON tp.id_toko = tt.id
            WHERE tp.created_at >= ? AND tp.created_at <= ? 
            AND (tp.id LIKE ? OR tt.nama_toko LIKE ?)
        ", [$awal, $akhir, "%$kategori%", "%$kategori%"])->result();
      $data['kat'] = $kategori;
      $data['tgl'] = $tanggal;
    } else if (empty($kategori) && !empty($tanggal)) {
      list($awal, $akhir) = explode(' - ', $tanggal);
      $data['list'] = $this->db->query("
      SELECT tp.*, tt.nama_toko
      FROM tb_permintaan tp
      JOIN tb_toko tt ON tp.id_toko = tt.id
      WHERE tp.created_at >= ? AND tp.created_at <= ?
  ", [$awal, $akhir])->result();
      $data['tgl'] = $tanggal;
    } else if (!empty($kategori) && empty($tanggal)) {
      $data['list'] = $this->db->query("
      SELECT tp.*, tt.nama_toko
      FROM tb_permintaan tp
      JOIN tb_toko tt ON tp.id_toko = tt.id
      AND (tp.id LIKE ? OR tt.nama_toko LIKE ?)
  ", ["%$kategori%", "%$kategori%"])->result();
      $data['kat'] = $kategori;
    } else {
      $data['list'] = $this->db->query("SELECT tp.*, tt.nama_toko from tb_permintaan tp
    join tb_toko tt on tp.id_toko = tt.id
    where tp.status != 0 AND tp.status != 5 AND tp.status != 6 order by tp.status = 7 DESC,tp.status = 1 DESC, tp.id desc ")->result();
    }
    $this->template->load('template/template', 'manager_mv/permintaan/index', $data);
  }
  public function terima($no_permintaan)
  {
    $data['title'] = 'Permintaan Barang';
    $data_permintaan = $this->db->query("SELECT * from tb_permintaan where id ='$no_permintaan'")->row();
    $id_toko = $data_permintaan->id_toko;
    $data['permintaan'] = $this->db->query("SELECT tp.*, tt.alamat,tt.id as id_toko,tt.nama_toko,tt.telp,tu.nama_user as spg from tb_permintaan tp
    join tb_toko tt on tp.id_toko = tt.id
    join tb_user tu on tp.id_user = tu.id where tp.id = '$no_permintaan'")->row();
    $data['detail_permintaan'] = $this->db->query("SELECT tpd.*,tpk.kode, tpk.nama_produk, tt.het, tpk.harga_indobarat as het_indobarat, tpk.harga_jawa as het_jawa, COALESCE(ts.qty, 0) as stok  from tb_permintaan_detail tpd
    join tb_permintaan tp on tpd.id_permintaan = tp.id
    join tb_toko tt on tp.id_toko = tt.id
    join tb_produk tpk on tpd.id_produk = tpk.id
    join tb_stok ts on ts.id_produk = tpd.id_produk
    where tp.id = '$no_permintaan' AND ts.id_toko = '$id_toko'")->result();
    $data['list_produk'] = $this->db->query("SELECT ts.*, tp.nama_produk, tp.satuan, tp.kode from tb_stok ts
    join tb_produk tp on ts.id_produk = tp.id
    where id_toko = '$id_toko' and tp.id NOT IN(SELECT id_produk from tb_permintaan_detail where id_permintaan = '$no_permintaan')")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_po_histori where id_po = '$no_permintaan'")->result();
    $this->template->load('template/template', 'manager_mv/permintaan/terima', $data);
  }
  public function detail($no_permintaan)
  {
    $data['title'] = 'Permintaan Barang';
    $data_permintaan = $this->db->query("SELECT * from tb_permintaan where id ='$no_permintaan'")->row();
    $id_toko = $data_permintaan->id_toko;
    $data['permintaan'] = $this->db->query("SELECT tp.*, tt.alamat,tt.id as id_toko,tt.nama_toko,tt.telp,tu.nama_user as spg from tb_permintaan tp
    join tb_toko tt on tp.id_toko = tt.id
    join tb_user tu on tp.id_user = tu.id where tp.id = '$no_permintaan'")->row();
    $data['detail_permintaan'] = $this->db->query("SELECT tpd.*,tpk.kode, tpk.nama_produk, tt.het, tpk.harga_indobarat as het_indobarat, tpk.harga_jawa as het_jawa, COALESCE(ts.qty, 0) as stok  from tb_permintaan_detail tpd
    join tb_permintaan tp on tpd.id_permintaan = tp.id
    join tb_toko tt on tp.id_toko = tt.id
    join tb_produk tpk on tpd.id_produk = tpk.id
    join tb_stok ts on ts.id_produk = tpd.id_produk
    where tp.id = '$no_permintaan' AND ts.id_toko = '$id_toko'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_po_histori where id_po = '$no_permintaan'")->result();
    $this->template->load('template/template', 'manager_mv/permintaan/detail', $data);
  }
  public function approve()
  {
    $id_user  = $this->session->userdata('id');
    $pt  = $this->session->userdata('pt');
    $id           = $this->input->post('id_permintaan');
    date_default_timezone_set('Asia/Jakarta');
    $update_at = date('Y-m-d H:i:s');
    $id_produk    = $this->input->post('id_produk');
    $id_detail    = $this->input->post('id_detail');
    $qty_acc      = $this->input->post('qty_acc');
    $catatan_mv   = $this->input->post('catatan_mv');
    $tindakan     = $this->input->post('tindakan');
    $jumlah       = count($id_produk);
    $mv = $this->db->query("SELECT nama_user from tb_user where id ='$id_user'")->row()->nama_user;

    $this->db->trans_start();
    if ($tindakan == 1) {
      $where = array('id' => $id);
      $data = array(
        'status' => 2,
        'keterangan' => $catatan_mv,
        'updated_at' => $update_at,
      );
      $this->db->update('tb_permintaan', $data, $where);
      $aksi = "Disetujui MV : ";
      for ($i = 0; $i < $jumlah; $i++) {
        $d_id_detail  = $id_detail[$i];
        $d_qty        = $qty_acc[$i];
        $data_detail = array(
          'qty_acc' => $d_qty,
        );
        $this->db->where('id', $d_id_detail);
        $this->db->where('status = 1');
        $this->db->update('tb_permintaan_detail', $data_detail);
      }
      $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE role = 5 and status = 1")->result_array();
      $message = "Anda memiliki 1 PO Barang ( " . $id . " - " . $pt . " ) yang perlu disiapkan silahkan kunjungi s.id/absi-app";
      foreach ($phones as $phone) {
        $number = $phone['no_telp'];
        $hp = substr($number, 0, 1);
        if ($hp == '0') {
          $number = '62' . substr($number, 1);
        }
        kirim_wa($number, $message);
      }
    } else if ($tindakan == 2) {
      $tunda = array(
        'status' => '7',
        'updated_at' => $update_at
      );

      $this->db->update('tb_permintaan', $tunda, array('id' => $id));
      $aksi = "Ditunda MV : ";
    } else {
      $tolak = array(
        'status' => '5',
        'updated_at' => $update_at
      );

      $this->db->update('tb_permintaan', $tolak, array('id' => $id));
      $aksi = "Ditolak MV : ";
    }
    // Insert histori
    $histori = array(
      'id_po' => $id,
      'aksi' => $aksi,
      'pembuat' => $mv,
      'catatan' => $catatan_mv
    );

    $this->db->insert('tb_po_histori', $histori);

    $this->db->trans_complete();
    tampil_alert('success', 'Berhasil', 'Data PO Barang berhasil di proses.');
    redirect(base_url('sup/permintaan/detail/' . $id));
  }
  public function hapus_item()
  {
    $id = $this->input->post('id');
    $hapus = $this->db->query("DELETE from tb_permintaan_detail where id = '$id'");
  }
  public function tambah_item()
  {
    $id_produk = $this->input->post('id_produk');
    $id_permintaan = $this->input->post('id_permintaan');
    $qty = $this->input->post('qty');
    $data = array(
      'id_produk' => $id_produk,
      'id_permintaan' => $id_permintaan,
      'qty' => $qty,
      'qty_acc' => 0,
      'status' => 1,
    );
    $this->db->insert('tb_permintaan_detail', $data);
    redirect(base_url('sup/Permintaan/terima/') . $id_permintaan);
  }
}
