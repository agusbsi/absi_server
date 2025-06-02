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
    $data['detail_permintaan'] = $this->db->query("SELECT tpd.*,tpk.kode, tpk.nama_produk,tpk.packing, tt.het, tpk.harga_indobarat as het_indobarat, tpk.harga_jawa as het_jawa  from tb_permintaan_detail tpd
    join tb_permintaan tp on tpd.id_permintaan = tp.id
    join tb_toko tt on tp.id_toko = tt.id
    join tb_produk tpk on tpd.id_produk = tpk.id
    where tp.id = '$no_permintaan'")->result();
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
    $data['detail_permintaan'] = $this->db->query("SELECT tpd.*,tpk.kode, tpk.nama_produk, tt.het, tpk.harga_indobarat as het_indobarat, tpk.harga_jawa as het_jawa  from tb_permintaan_detail tpd
    join tb_permintaan tp on tpd.id_permintaan = tp.id
    join tb_toko tt on tp.id_toko = tt.id
    join tb_produk tpk on tpd.id_produk = tpk.id
    where tp.id = '$no_permintaan'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_po_histori where id_po = '$no_permintaan'")->result();
    $this->template->load('template/template', 'manager_mv/permintaan/detail', $data);
  }
  public function approve()
  {
    $id_user  = $this->session->userdata('id');
    $pt       = $this->session->userdata('pt');
    $id       = $this->input->post('id_permintaan');
    date_default_timezone_set('Asia/Jakarta');
    $update_at = date('Y-m-d H:i:s');
    $id_detail = $this->input->post('id_detail');
    $qty_acc   = $this->input->post('qty_acc');
    $catatan_mv = $this->input->post('catatan_mv');
    $tindakan  = $this->input->post('tindakan');
    $jumlah    = count($id_detail);
    $mv        = $this->db->select('nama_user')->get_where('tb_user', ['id' => $id_user])->row()->nama_user;

    $this->db->trans_start();

    if ($tindakan == 1) {
      // Update tb_permintaan
      $this->db->update('tb_permintaan', [
        'status' => 2,
        'keterangan' => $catatan_mv,
        'updated_at' => $update_at
      ], ['id' => $id]);

      $aksi = "Disetujui MV : ";

      // Update tb_permintaan_detail menggunakan batch update
      $detail_data = [];
      for ($i = 0; $i < $jumlah; $i++) {
        $detail_data[] = [
          'id' => $id_detail[$i],
          'qty_acc' => $qty_acc[$i]
        ];
      }
      $this->db->update_batch('tb_permintaan_detail', $detail_data, 'id');

      // Ambil nomor telepon user dengan sekali query
      $phones = $this->db->select('no_telp')
        ->where(['role' => 5, 'status' => 1])
        ->get('tb_user')
        ->result_array();

      $message = "Anda memiliki 1 PO Barang ( $id - $pt ) yang perlu disiapkan silahkan kunjungi s.id/absi-app";

      foreach ($phones as $phone) {
        $number = $phone['no_telp'];
        if (substr($number, 0, 1) == '0') {
          $number = '62' . substr($number, 1);
        }
        kirim_wa($number, $message);
      }
    } elseif ($tindakan == 2) {
      // Tunda
      $this->db->update('tb_permintaan', [
        'status' => 7,
        'updated_at' => $update_at
      ], ['id' => $id]);

      $aksi = "Ditunda MV : ";
    } else {
      // Tolak
      $this->db->update('tb_permintaan', [
        'status' => 5,
        'updated_at' => $update_at
      ], ['id' => $id]);

      $aksi = "Ditolak MV : ";
    }

    // Insert histori
    $this->db->insert('tb_po_histori', [
      'id_po' => $id,
      'aksi' => $aksi,
      'pembuat' => $mv,
      'catatan' => $catatan_mv
    ]);

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
  public function edit($po)
  {
    $mv  = $this->session->userdata('nama_user');
    $this->db->update('tb_permintaan', array('status' => 1), array('id' => $po));
    // Insert histori
    $histori = array(
      'id_po' => $po,
      'aksi' => 'Di edit Oleh :',
      'pembuat' => $mv
    );

    $this->db->insert('tb_po_histori', $histori);
    tampil_alert('success', 'Berhasil', 'Status Data PO telah di kembalikan ke tim MV.');
    redirect(base_url('sup/permintaan/terima/' . $po));
  }
}
