<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analist extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('status') != 'login') {
      redirect(base_url());
    }
  }

  //   halaman utama
  public function index()
  {
    $data['title'] = 'Marketing Analist';
    $this->template->load('template/template', 'adm/analist/index', $data);
  }
  public function dsi()
  {
    $data['title'] = 'Marketing Analist';
    $data['toko'] = $this->db->query("SELECT * from tb_toko where status ='1'")->result();
    $this->template->load('template/template', 'adm/analist/dsi', $data);
  }
  public function cari_dsi()
  {
    $id_toko = $this->input->get('id_toko');
    $tgl_awal = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');
    $awal = new DateTime($tgl_awal);
    $akhir = new DateTime($tgl_akhir);
    $diff = $awal->diff($akhir);
    $jumlah_bulan = $diff->y * 12 + $diff->m + 1;
    $summary = $this->db->query("SELECT * from tb_toko where id = '$id_toko'")->row();
    $tabel_data = $this->db->query("SELECT tpk.kode, tpk.nama_produk, COALESCE(SUM(tpd.qty), 0) as total, COALESCE(ts.qty_awal, 0) as stok
    FROM tb_stok ts
    LEFT JOIN tb_produk tpk ON ts.id_produk = tpk.id
    LEFT JOIN (
        SELECT tpd.id_produk, SUM(tpd.qty) as qty
        FROM tb_penjualan_detail tpd
        JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
        WHERE tp.id_toko = '$id_toko' AND DATE(tp.tanggal_penjualan) BETWEEN '$tgl_awal' AND '$tgl_akhir'
        GROUP BY tpd.id_produk
    ) tpd ON tpk.id = tpd.id_produk
    WHERE ts.id_toko = '$id_toko'
    GROUP BY tpk.id
    ORDER BY COALESCE(SUM(tpd.qty), 0) DESC")->result();
    $data = [
      'toko' => $summary->nama_toko,
      'awal' => date('d-M-Y', strtotime($tgl_awal)),
      'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
      'tabel_data' => $tabel_data,
      'bln' => $jumlah_bulan
    ];
    echo json_encode($data);
  }
}
