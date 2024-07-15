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
    $id = $this->session->userdata('id');
    $role = $this->session->userdata('role');
    if ($role == 2) {
      $dsi = $this->db->query("SELECT * from tb_toko where status ='1' AND id_spv = '$id'");
    } else if ($role == 3) {
      $dsi = $this->db->query("SELECT * from tb_toko where status ='1' AND id_leader = '$id'");
    } else {
      $dsi = $this->db->query("SELECT * from tb_toko where status ='1'");
    }
    $data['toko'] = $dsi->result();
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
    $tabel_data = $this->db->query("SELECT tpk.kode, tpk.nama_produk, COALESCE(SUM(tpd.qty), 0) as total, COALESCE(ts.qty_awal, 0) as stok, COALESCE(vpb.jml_jual, 0) AS jml_jual
    FROM tb_stok ts
    LEFT JOIN tb_produk tpk ON ts.id_produk = tpk.id
    LEFT JOIN (
        SELECT tpd.id_produk, SUM(tpd.qty) as qty
        FROM tb_penjualan_detail tpd
        JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
        WHERE tp.id_toko = '$id_toko' AND DATE(tp.tanggal_penjualan) BETWEEN '$tgl_awal' AND '$tgl_akhir'
        GROUP BY tpd.id_produk
    ) tpd ON tpk.id = tpd.id_produk
    LEFT JOIN (SELECT  id_produk, jml_jual FROM vw_penjualan_buat WHERE id_toko = '$id_toko'
            AND tahun = YEAR(DATE_SUB(NOW(), INTERVAL 0 MONTH))
            AND bulan = MONTH(DATE_SUB(NOW(), INTERVAL 0 MONTH))
        GROUP BY 
            id_produk ) vpb ON vpb.id_produk = ts.id_produk
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
  public function pl()
  {
    $data['title'] = 'Marketing Analist';
    $query = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS periode
          FROM tb_so 
          WHERE created_at >= '2024-06-01' AND created_at < DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 0 MONTH), '%Y-%m-01')
          GROUP BY YEAR(created_at), MONTH(created_at)
          ORDER BY created_at DESC";
    $data['periode'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'adm/analist/pl', $data);
  }
  public function cari_pl()
  {
    $id = $this->session->userdata('id');
    $role = $this->session->userdata('role');
    if ($role == 2) {
      $queri = "AND tt.id_spv = '$id'";
    } else if ($role == 3) {
      $queri = "AND tt.id_leader = '$id'";
    } else {
      $queri = "";
    }
    $periode = $this->input->get('periode');
    list($tahun, $bulan) = explode('-', $periode);
    $tabel_data = $this->db->query("SELECT 
        tt.nama_toko, 
        COALESCE(SUM(ts.qty_awal), 0) as stok_awal, 
        COALESCE(SUM(ts.hasil_so), 0) as so_spg,
        jual,
        COALESCE((SUM(ts.qty_awal)) - jual, 0) as akhir
    FROM tb_toko tt
    LEFT JOIN (
        SELECT 
            tsd.qty_awal,
            tsd.hasil_so,
            ts.id_toko
        FROM tb_so ts
        JOIN tb_so_detail tsd ON tsd.id_so = ts.id
        WHERE DATE_FORMAT(ts.created_at, '%Y-%m') = '$periode'
    ) ts ON tt.id = ts.id_toko
    LEFT JOIN (
        SELECT 
             COALESCE(SUM(jml_jual), 0) as jual,
            id_toko
        FROM vw_penjualan_buat 
        WHERE tahun = $tahun AND bulan = $bulan
        GROUP BY id_toko
    ) vpb ON tt.id = vpb.id_toko
    WHERE tt.status = 1 $queri
    GROUP BY tt.id
    ORDER BY tt.id ASC")->result();

    $data = [
      'periode' => date('M Y', strtotime('-1 month', strtotime($periode))),
      'tabel_data' => $tabel_data
    ];
    echo json_encode($data);
  }
}
