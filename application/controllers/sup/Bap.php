<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bap extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('status') != 'login') {
      redirect(base_url());
    }
  }

  public function index()
  {
    $data['title'] = 'Bap';
    $data['list_data'] = $this->db->query("SELECT tp.*, tk.nama_toko, tu.nama_user as spg from tb_bap tp
    JOIN tb_toko tk on tp.id_toko = tk.id
    JOIN tb_user tu on tp.id_user = tu.id
    where tp.status >= 1 order by tp.status = 1 desc, tp.id desc ")->result();
    $this->template->load('template/template', 'manager_mv/bap/lihat_data', $data);
  }
  // detail permintaan
  public function detail_p($Bap)
  {

    $data['title'] = 'Bap';
    $data['bap'] = $this->db->query("SELECT tp.*, tk.nama_toko, tk.alamat, tk.telp, tu.nama_user as spg from tb_bap tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        JOIN tb_user tu on tp.id_user = tu.id
        where tp.id = '$Bap'")->row();
    $data['detail_bap'] = $this->db->query("SELECT td.*,tpk.kode as kode_produk, tpk.nama_produk, tpk.satuan  from tb_bap_detail td
        JOIN tb_bap tp on td.id_bap = tp.id
        JOIN tb_produk tpk on td.id_produk = tpk.id
        where td.id_bap = '$Bap'")->result();
    $this->template->load('template/template', 'manager_mv/bap/detail', $data);
  }
  public function simpan()
  {
    $username = $this->session->userdata('username');
    $id_bap = $this->input->post('id_bap');
    $id_kirim = $this->input->post('id_kirim');
    $id_toko = $this->input->post('id_toko');
    $id_produk = $this->input->post('id_produk');
    $qty_terima = $this->input->post('qty_terima');
    $qty_update = $this->input->post('qty_update');
    $kategori = $this->input->post('kategori');
    $tindakan = $this->input->post('tindakan');
    $catatan_mv = $this->input->post('catatan_mv');
    $jml      = count($id_produk);
    $where = array('id' => $id_bap);
    $data = array(
      'status' => $tindakan,
      'catatan_mv' => $catatan_mv
    );

    $this->db->trans_start();

    // Update tabel tb_bap
    $this->db->update('tb_bap', $data, $where);

    if ($tindakan == 2) {
      $pesan = "Di setujui.";
      $this->db->update('tb_pengiriman', array('status' => '2'), array('id' => $id_kirim));
      for ($i = 0; $i < $jml; $i++) {
        $detail_kirim = array(
          'qty_diterima' => $qty_update[$i],
          'catatan'   => 'Update BAP - ' . $kategori[$i]
        );
        $where_kirim = array(
          'id_pengiriman' => $id_kirim,
          'id_produk' => $id_produk[$i]
        );
        $this->db->update('tb_pengiriman_detail', $detail_kirim, $where_kirim);
        // Mengambil stok terbaru
        $stok_awal = $this->db->select('qty')
          ->where(array('id_produk' => $id_produk[$i], 'id_toko' => $id_toko))
          ->get('tb_stok')
          ->row()
          ->qty;
        // Update stok di tb_stok
        $this->db->set('qty', 'qty - ' . $qty_terima[$i] . ' + ' . $qty_update[$i], FALSE)
          ->where(array('id_toko' => $id_toko, 'id_produk' => $id_produk[$i]))
          ->update('tb_stok');
        // Insert data ke tb_kartu_stok
        $kartu = array(
          'no_doc' => $id_kirim,
          'id_produk' => $id_produk[$i],
          'id_toko' => $id_toko,
          'stok' => $stok_awal,
          'masuk' => $qty_update[$i],
          'keluar' => $qty_terima[$i],
          'sisa' => $stok_awal - $qty_terima[$i] + $qty_update[$i],
          'keterangan' => 'BAP',
          'pembuat' => $username
        );
        $this->db->insert('tb_kartu_stok', $kartu);
      }
    } else {
      $pesan = "Ditolak.";
    }

    $this->db->trans_complete();

    tampil_alert('success', 'Berhasil', 'Data Pengajuan BAP berhasil ' . $pesan);
    redirect(base_url('sup/Bap/detail_p/' . $id_bap));
  }
}
