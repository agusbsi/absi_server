<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Stok extends CI_Controller
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
    $data['title'] = 'Stok Artikel';
    $data['artikel'] = $this->db->query("SELECT * from tb_produk ")->result();
    $data['stok'] = $this->db->query("SELECT sum(ts.qty) as total FROM tb_stok ts
    JOIN tb_toko tt on ts.id_toko = tt.id where ts.status = 1 AND tt.status = 1 ")->row();
    $this->template->load('template/template', 'adm/stok/index', $data);
  }
  public function detail($id_artikel, $tanggal)
  {
    $data['title'] = 'Stok Artikel';
    $start_date = "2024-12-01";
    $params = [$start_date, $tanggal, $start_date, $tanggal, $start_date, $tanggal, $start_date, $tanggal, $start_date, $tanggal, $id_artikel];

    $query = "
          SELECT 
      tt.nama_toko, tsh.qty_awal AS stok_awal, 
      COALESCE(tpd.qty, 0) AS jual, 
      COALESCE(trd.qty_retur, 0) AS retur, 
      COALESCE(mk.qty_mk, 0) AS mutasi_keluar, 
      COALESCE(mm.qty_mk, 0) AS mutasi_masuk, 
      COALESCE(tpk.qty_terima, 0) AS terima,
      (tsh.qty_awal 
          - COALESCE(tpd.qty, 0) 
          - COALESCE(trd.qty_retur, 0) 
          - COALESCE(mk.qty_mk, 0) 
          + COALESCE(mm.qty_mk, 0) 
          + COALESCE(tpk.qty_terima, 0)
      ) AS stok_akhir
      FROM tb_stok tsh
      LEFT JOIN (
          SELECT tp.id_toko, tpd.id_produk, SUM(tpd.qty) AS qty
          FROM tb_penjualan_detail tpd
          JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
          WHERE DATE(tp.tanggal_penjualan) BETWEEN ? AND ?
          GROUP BY tp.id_toko, tpd.id_produk
      ) tpd ON tsh.id_produk = tpd.id_produk AND tsh.id_toko = tpd.id_toko
      LEFT JOIN (
          SELECT tr.id_toko, trd.id_produk, SUM(trd.qty_terima) AS qty_retur
          FROM tb_retur_detail trd
          JOIN tb_retur tr ON trd.id_retur = tr.id
          WHERE DATE(tr.updated_at) BETWEEN ? AND ?
          GROUP BY tr.id_toko, trd.id_produk
      ) trd ON tsh.id_produk = trd.id_produk AND tsh.id_toko = trd.id_toko
      LEFT JOIN (
          SELECT tm.id_toko_asal AS id_toko, tmd.id_produk, SUM(tmd.qty_terima) AS qty_mk
          FROM tb_mutasi_detail tmd
          JOIN tb_mutasi tm ON tmd.id_mutasi = tm.id
          WHERE DATE(tm.updated_at) BETWEEN ? AND ?
          GROUP BY tm.id_toko_asal, tmd.id_produk
      ) mk ON tsh.id_produk = mk.id_produk AND tsh.id_toko = mk.id_toko
      LEFT JOIN (
          SELECT tm.id_toko_tujuan AS id_toko, tmd.id_produk, SUM(tmd.qty_terima) AS qty_mk
          FROM tb_mutasi_detail tmd
          JOIN tb_mutasi tm ON tmd.id_mutasi = tm.id
          WHERE DATE(tm.updated_at) BETWEEN ? AND ?
          GROUP BY tm.id_toko_tujuan, tmd.id_produk
      ) mm ON tsh.id_produk = mm.id_produk AND tsh.id_toko = mm.id_toko
      LEFT JOIN (
          SELECT tp.id_toko, tpd.id_produk, SUM(tpd.qty_diterima) AS qty_terima
          FROM tb_pengiriman_detail tpd
          JOIN tb_pengiriman tp ON tpd.id_pengiriman = tp.id
          WHERE DATE(tp.updated_at) BETWEEN ? AND ?
          GROUP BY tp.id_toko, tpd.id_produk
      ) tpk ON tsh.id_produk = tpk.id_produk AND tsh.id_toko = tpk.id_toko
      JOIN tb_toko tt ON tsh.id_toko = tt.id
      WHERE tsh.id_produk = ? 
      GROUP BY tsh.id_toko, tsh.qty_awal, tt.nama_toko, tpd.qty, trd.qty_retur, mk.qty_mk, mm.qty_mk, tpk.qty_terima
      ORDER BY tt.nama_toko ASC
      ";


    $data['data'] = $this->db->get_where('tb_produk', ['id' => $id_artikel])->row();
    $data['list_data'] = $this->db->query($query, $params)->result();
    $data['tanggal'] = date('d M Y', strtotime($tanggal));
    $this->template->load('template/template', 'adm/stok/detail', $data);
  }
  public function detail_cust($id)
  {
    $data['title'] = 'Stok Artikel';
    $query = "SELECT SUM(ts.qty) as stok,tc.nama_cust, tp.nama_produk, tp.kode
          FROM tb_stok ts
          JOIN tb_toko tt ON ts.id_toko = tt.id
          JOIN tb_customer tc ON tt.id_customer = tc.id
          join tb_produk tp on ts.id_produk = tp.id
          where ts.id_produk = '$id' AND ts.status = 1 AND tt.status = 1
          GROUP BY tc.id
          ORDER BY SUM(ts.qty) DESC";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'adm/stok/detail_cust', $data);
  }
  public function s_customer()
  {
    $data['title'] = 'Stok Customer';
    $thn = date('Y');
    $bln = (new DateTime('first day of -2 month'))->format('m');
    $query = "SELECT 
        tc.id,
        tc.nama_cust,
        tc.alamat_cust,
        (SELECT COUNT(id) FROM tb_toko tt WHERE tt.id_customer = tc.id AND tt.status = 1) AS t_toko,
        (SELECT COALESCE(SUM(ts.qty), 0) FROM tb_stok ts JOIN tb_toko tt ON ts.id_toko = tt.id WHERE tt.id_customer = tc.id AND tt.status = 1) AS t_stok,
        (SELECT COALESCE(SUM(ts.qty_awal), 0) FROM tb_stok ts JOIN tb_toko tt ON ts.id_toko = tt.id WHERE tt.id_customer = tc.id AND tt.status = 1) AS t_akhir,
        (SELECT COALESCE(SUM(ts.jml_jual), 0) FROM vw_penjualan ts JOIN tb_toko tt ON ts.id_toko = tt.id WHERE tt.id_customer = tc.id AND tt.status = 1 AND ts.tahun = '$thn' AND ts.bulan = '$bln' ) AS t_jual

    FROM 
        tb_customer tc
    ORDER BY 
        tc.nama_cust ASC";
    $data['list_data'] = $this->db->query($query)->result();
    $data['cust'] = $this->db->query("SELECT count(id) as total from tb_customer")->row();
    $data['stok'] = $this->db->query("SELECT SUM(ts.qty) as total, SUM(ts.qty_awal) as stok_akhir from tb_stok ts
    JOIN tb_toko tt on ts.id_toko = tt.id where ts.status = 1 AND tt.status = 1 ")->row();
    $data['jual'] = $this->db->query("SELECT SUM(jml_jual) as total from vw_penjualan where tahun = '$thn' AND bulan = '$bln' ")->row();
    $this->template->load('template/template', 'adm/stok/customer', $data);
  }
  public function s_toko()
  {
    // tampil_alert('info', 'Maintenance', 'Fitur laporan Stok per toko sedang di perbarui, silahkan coba lagi nanti.');
    // redirect(base_url('adm/Dashboard'));
    $data['title'] = 'Stok per Toko';
    $data['toko'] = $this->db->query("SELECT * from tb_toko order by id desc")->result();
    $this->template->load('template/template', 'adm/stok/stok_toko', $data);
  }
  function list_ajax_artikel($toko)
  {
    $hasil = $this->db->query("SELECT tp.* from tb_stok ts
    join tb_produk tp on ts.id_produk = tp.id
    where ts.id_toko = ?", $toko)->result();
    header('Content-Type: application/json');
    echo json_encode($hasil);
  }
  public function cari_stokartikel()
  {
    $id_artikel = $this->input->get('id_artikel');
    $tanggal = $this->input->get('tanggal');
    $start_date = "2024-12-01";

    $artikel = "Semua Artikel";
    $where_artikel = "";
    $params = [$start_date, $tanggal, $start_date, $tanggal, $start_date, $tanggal, $start_date, $tanggal, $start_date, $tanggal];

    if ($id_artikel != "all") {
      $where_artikel = "WHERE tsh.id_produk = ?";
      $params[] = $id_artikel;

      $summary = $this->db->get_where('tb_produk', ['id' => $id_artikel])->row();
      $artikel = '<strong>' . $summary->kode . '</strong></br>' . $summary->nama_produk;
    }

    $query = "
    SELECT
      tpp.id as id_artikel,
      tpp.kode,
      tpp.nama_produk AS deskripsi,
      COALESCE(SUM(tsh.qty_awal), 0) AS stok_awal,
      COALESCE(SUM(tpd.qty), 0) AS jual,
      COALESCE(SUM(trd.qty_retur), 0) AS retur,
      COALESCE(SUM(mk.qty_mk), 0) AS mutasi_keluar,
      COALESCE(SUM(mm.qty_mk), 0) AS mutasi_masuk,
      COALESCE(SUM(tpk.qty_terima), 0) AS terima,
      (
        COALESCE(SUM(tsh.qty_awal), 0)
        - COALESCE(SUM(tpd.qty), 0)
        + COALESCE(SUM(trd.qty_retur), 0)
        - COALESCE(SUM(mk.qty_mk), 0)
        + COALESCE(SUM(mm.qty_mk), 0)
        + COALESCE(SUM(tpk.qty_terima), 0)
      ) AS stok_akhir
      FROM tb_stok tsh
      LEFT JOIN (
          SELECT tp.id_toko, tpd.id_produk, SUM(tpd.qty) AS qty
          FROM tb_penjualan_detail tpd
          JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
          WHERE DATE(tp.tanggal_penjualan) BETWEEN ? AND ?
          GROUP BY tp.id_toko, tpd.id_produk
      ) tpd ON tsh.id_produk = tpd.id_produk AND tsh.id_toko = tpd.id_toko
      LEFT JOIN (
          SELECT tr.id_toko, trd.id_produk, SUM(trd.qty_terima) AS qty_retur
          FROM tb_retur_detail trd
          JOIN tb_retur tr ON trd.id_retur = tr.id
          WHERE DATE(tr.updated_at) BETWEEN ? AND ?
          GROUP BY tr.id_toko, trd.id_produk
      ) trd ON tsh.id_produk = trd.id_produk AND tsh.id_toko = trd.id_toko
      LEFT JOIN (
          SELECT tm.id_toko_asal AS id_toko, tmd.id_produk, SUM(tmd.qty_terima) AS qty_mk
          FROM tb_mutasi_detail tmd
          JOIN tb_mutasi tm ON tmd.id_mutasi = tm.id
          WHERE DATE(tm.updated_at) BETWEEN ? AND ?
          GROUP BY tm.id_toko_asal, tmd.id_produk
      ) mk ON tsh.id_produk = mk.id_produk AND tsh.id_toko = mk.id_toko
      LEFT JOIN (
          SELECT tm.id_toko_tujuan AS id_toko, tmd.id_produk, SUM(tmd.qty_terima) AS qty_mk
          FROM tb_mutasi_detail tmd
          JOIN tb_mutasi tm ON tmd.id_mutasi = tm.id
          WHERE DATE(tm.updated_at) BETWEEN ? AND ?
          GROUP BY tm.id_toko_tujuan, tmd.id_produk
      ) mm ON tsh.id_produk = mm.id_produk AND tsh.id_toko = mm.id_toko
      LEFT JOIN (
          SELECT tp.id_toko, tpd.id_produk, SUM(tpd.qty_diterima) AS qty_terima
          FROM tb_pengiriman_detail tpd
          JOIN tb_pengiriman tp ON tpd.id_pengiriman = tp.id
          WHERE DATE(tp.updated_at) BETWEEN ? AND ?
          GROUP BY tp.id_toko, tpd.id_produk
      ) tpk ON tsh.id_produk = tpk.id_produk AND tsh.id_toko = tpk.id_toko
      JOIN tb_produk tpp ON tsh.id_produk = tpp.id
      $where_artikel
      GROUP BY tsh.id_produk, tpp.kode, tpp.nama_produk
      ORDER BY tpp.kode ASC
    ";

    $hasil_data = $this->db->query($query, $params)->result();

    $data = [
      'toko' => "Semua Toko",
      'artikel' => $artikel,
      'tanggal' => date('d M Y', strtotime($tanggal)),
      'tabel_data' => $hasil_data
    ];

    echo json_encode($data);
  }
  public function cari_stoktoko()
  {
    $id_toko = $this->input->get('id_toko');
    $id_artikel = $this->input->get('id_artikel');
    $tanggal = $this->input->get('tanggal');
    $start_date = '2024-12-01'; // Stok awal dihitung sejak 1 Desember 2024

    // Cek apakah user memilih semua artikel atau artikel tertentu
    if ($id_artikel == 'all') {
      $artikel = '( Semua Artikel )';
      $artikel_condition = '';
      $params = [$start_date, $tanggal, $id_toko, $start_date, $tanggal, $id_toko, $start_date, $tanggal, $id_toko, $start_date, $tanggal, $id_toko, $start_date, $tanggal, $id_toko, $id_toko];
    } else {
      $summary = $this->db->get_where('tb_produk', ['id' => $id_artikel])->row();
      $artikel = '<strong>' . $summary->kode . '</strong></br>' . $summary->nama_produk;
      $artikel_condition = 'AND tsh.id_produk = ?';
      $params = [$start_date, $tanggal, $id_toko, $start_date, $tanggal, $id_toko, $start_date, $tanggal, $id_toko, $start_date, $tanggal, $id_toko, $start_date, $tanggal, $id_toko, $id_toko, $id_artikel];
    }

    $query = "
          SELECT 
              tpp.nama_produk, tpp.kode, tpp.satuan, tsh.qty_awal AS stok_awal, 
              COALESCE(SUM(tpd.qty), 0) AS jual, 
              COALESCE(SUM(trd.qty_retur), 0) AS retur, 
              COALESCE(SUM(mk.qty_mk), 0) AS mutasi_keluar, 
              COALESCE(SUM(mm.qty_mk), 0) AS mutasi_masuk, 
              COALESCE(SUM(tpk.qty_terima), 0) AS terima,
              (tsh.qty_awal 
                  - COALESCE(SUM(tpd.qty), 0) 
                  + COALESCE(SUM(trd.qty_retur), 0) 
                  - COALESCE(SUM(mk.qty_mk), 0) 
                  + COALESCE(SUM(mm.qty_mk), 0) 
                  + COALESCE(SUM(tpk.qty_terima), 0)
              ) AS stok_akhir
          FROM tb_stok tsh
          LEFT JOIN (
              SELECT tpd.id_produk, SUM(tpd.qty) AS qty
              FROM tb_penjualan_detail tpd
              JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
              WHERE DATE(tp.tanggal_penjualan) BETWEEN ? AND ? AND tp.id_toko = ?
              GROUP BY tpd.id_produk
          ) tpd ON tsh.id_produk = tpd.id_produk
          LEFT JOIN (
              SELECT trd.id_produk, SUM(trd.qty_terima) AS qty_retur
              FROM tb_retur_detail trd
              JOIN tb_retur tr ON trd.id_retur = tr.id
              WHERE DATE(tr.updated_at) BETWEEN ? AND ? AND tr.id_toko = ?
              GROUP BY trd.id_produk
          ) trd ON tsh.id_produk = trd.id_produk
          LEFT JOIN (
              SELECT tmd.id_produk, SUM(tmd.qty_terima) AS qty_mk
              FROM tb_mutasi_detail tmd
              JOIN tb_mutasi tm ON tmd.id_mutasi = tm.id
              WHERE DATE(tm.updated_at) BETWEEN ? AND ? AND tm.id_toko_asal = ?
              GROUP BY tmd.id_produk
          ) mk ON tsh.id_produk = mk.id_produk
          LEFT JOIN (
              SELECT tmd.id_produk, SUM(tmd.qty_terima) AS qty_mk
              FROM tb_mutasi_detail tmd
              JOIN tb_mutasi tm ON tmd.id_mutasi = tm.id
              WHERE DATE(tm.updated_at) BETWEEN ? AND ? AND tm.id_toko_tujuan = ?
              GROUP BY tmd.id_produk
          ) mm ON tsh.id_produk = mm.id_produk
          LEFT JOIN (
              SELECT tpd.id_produk, SUM(tpd.qty_diterima) AS qty_terima
              FROM tb_pengiriman_detail tpd
              JOIN tb_pengiriman tp ON tpd.id_pengiriman = tp.id
              WHERE DATE(tp.updated_at) BETWEEN ? AND ? AND tp.id_toko = ?
              GROUP BY tpd.id_produk
          ) tpk ON tsh.id_produk = tpk.id_produk
          JOIN tb_produk tpp ON tsh.id_produk = tpp.id
          WHERE tsh.id_toko = ? $artikel_condition
          GROUP BY tsh.id_produk
          ORDER BY tpp.kode ASC";

    $hasil_data = $this->db->query($query, $params)->result();
    $toko = $this->db->get_where('tb_toko', ['id' => $id_toko])->row();

    $data = [
      'toko' => $toko->nama_toko,
      'artikel' => $artikel,
      'tanggal' => date('d M Y', strtotime($tanggal)),
      'tabel_data' => $hasil_data
    ];

    echo json_encode($data);
  }


  public function detail_toko($id)
  {
    $data['title'] = 'Stok Customer';
    $thn = date('Y');
    $bln = (new DateTime('first day of -2 month'))->format('m');

    $query = "
      SELECT 
          tc.nama_cust, 
          tt.nama_toko, 
          COALESCE(SUM(ts.qty), 0) AS t_stok,
          (SELECT COALESCE(SUM(ts.qty_awal), 0) FROM tb_stok ts WHERE ts.id_toko = tt.id) AS t_akhir,
          (SELECT COALESCE(SUM(ts.jml_jual), 0) FROM vw_penjualan ts WHERE ts.id_toko = tt.id AND ts.tahun = '$thn' AND ts.bulan = '$bln') AS t_jual
      FROM 
          tb_customer tc
      JOIN 
          tb_toko tt ON tc.id = tt.id_customer
      LEFT JOIN 
          tb_stok ts ON tt.id = ts.id_toko
      WHERE 
          tc.id = '$id' AND tt.status = 1 
      GROUP BY 
          tt.id 
      ORDER BY 
          SUM(ts.qty) DESC
      ";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'adm/stok/detail_toko', $data);
  }

  public function detail_artikel($id)
  {
    $data['title'] = 'Stok Customer';
    $query = "SELECT tc.nama_cust, tp.kode,tp.nama_produk as artikel, COALESCE(SUM(ts.qty), 0) AS t_stok FROM tb_customer tc
    JOIN tb_toko tt on tc.id = tt.id_customer
    LEFT JOIN tb_stok ts on tt.id = ts.id_toko
    JOIN tb_produk tp on ts.id_produk = tp.id
    WHERE tc.id = '$id' AND tt.status = 1 GROUP BY tp.id ORDER BY SUM(ts.qty) DESC";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'adm/stok/detail_artikel', $data);
  }

  // Kartu Stok
  public function kartu_stok()
  {
    $data['title'] = 'Kartu Stok';
    $data['toko'] = $this->db->query("SELECT * from tb_toko where status = 1")->result();
    $data['artikel'] = $this->db->query("SELECT * from tb_produk where status = 1")->result();
    $this->template->load('template/template', 'adm/stok/kartu_stok', $data);
  }
  public function cari_kartu()
  {
    $id_toko = $this->input->get('id_toko');
    $id_artikel = $this->input->get('id_artikel');
    $tgl_awal = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');

    // Ensure the inputs are properly sanitized and validated
    $id_toko = intval($id_toko);
    $id_artikel = intval($id_artikel);
    $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
    $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
    log_message('debug', 'tgl_awal: ' . $tgl_awal);
    $toko = $this->db->query("SELECT * FROM tb_toko WHERE id = ?", array($id_toko))->row();
    $artikel = $this->db->query("SELECT * FROM tb_produk WHERE id = ?", array($id_artikel))->row();
    $tabel_data = $this->db->query(
      "SELECT *, COALESCE(masuk, '-') as masuk, 
        COALESCE(keluar, '-') as keluar  FROM tb_kartu_stok 
                                      WHERE id_toko = ? AND id_produk = ? AND DATE(tanggal) BETWEEN ? AND ?",
      array($id_toko, $id_artikel, $tgl_awal, $tgl_akhir)
    )->result();
    // Determine s_awal and s_akhir
    $s_awal = !empty($tabel_data) ? $tabel_data[0]->stok : 0;
    $s_akhir = !empty($tabel_data) ? end($tabel_data)->sisa : 0;

    // Ensure we handle cases where there might be no data
    $data = [
      'toko' => isset($toko->nama_toko) ? $toko->nama_toko : 'Unknown',
      'artikel' => isset($artikel->nama_produk) ? $artikel->nama_produk : 'Unknown',
      'awal' => date('d-M-Y', strtotime($tgl_awal)),
      'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
      'tabel_data' => $tabel_data,
      's_awal' => $s_awal,
      's_akhir' => $s_akhir,
    ];

    echo json_encode($data);
  }
  public function adjust_stok()
  {
    $data['title'] = 'Adjustment Stok';
    $data['list'] = $this->db->query("SELECT ta.*, tt.nama_toko from tb_adjust_stok ta
    JOIN tb_so ts ON ta.id_so = ts.id
    JOIN tb_toko tt ON ts.id_toko = tt.id 
    WHERE ta.status = ?", [1])->result();
    $this->template->load('template/template', 'adm/stok/adjust_tampil', $data);
  }
  public function export_adjust()
  {
    $name_user = $this->session->userdata('nama_user');
    $id_kirim_all = $this->input->post('id_kirim_all');
    $gudang = $this->input->post('gudang');
    $deskripsi = $this->input->post('deskripsi');

    // Create a new Spreadsheet instance
    $spreadsheet = new Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();
    $worksheet->setTitle('Export Adjust Stok');
    $worksheet->getStyle('A1:M1')->getFont()->setBold(true);
    $worksheet->setCellValue('A1', 'No. Penyesuaian');
    $worksheet->setCellValue('B1', 'Tanggal');
    $worksheet->setCellValue('C1', 'Akun Penyesuaian');
    $worksheet->setCellValue('D1', 'Deskripsi');
    $worksheet->setCellValue('E1', 'Tipe');
    $worksheet->setCellValue('F1', 'Pengguna');
    $worksheet->setCellValue('G1', 'Template');
    $worksheet->setCellValue('H1', 'Nomor Barang');
    $worksheet->setCellValue('I1', 'Kuantitas');
    $worksheet->setCellValue('J1', 'Nilai');
    $worksheet->setCellValue('K1', 'Gudang');
    $worksheet->setCellValue('L1', 'Departemen');
    $worksheet->setCellValue('M1', 'Proyek');

    $row = 2; // Start from the second row

    foreach ($id_kirim_all as $id_adj) {
      $query = $this->db->query("SELECT tpd.*, tp.kode,tp.satuan from tb_adjust_detail tpd
          join tb_produk tp on tpd.id_produk = tp.id
          WHERE tpd.id_adjust = '$id_adj'");
      $adjust = $this->db->query("SELECT ta.*, tt.nama_toko, ts.tgl_so from tb_adjust_stok ta
      JOIN tb_so ts ON ta.id_so = ts.id
      join tb_toko tt on ts.id_toko = tt.id 
      where ta.id = '$id_adj'")->row();
      if ($gudang == "VISTA") {
        $gudangTujuan = "51.1 GUD. KONSINYASI";
      } else if ($gudang == "TOKO") {
        $gudangTujuan = $adjust->nama_toko;
      }

      if ($query->num_rows() > 0) {
        $detail = $query->result();
        $tanggalkirim = new DateTime($adjust->tgl_so);
        $tanggalkirimFormat = $tanggalkirim->format('d/m/Y');

        foreach ($detail as $data) {
          // Set values for each row
          $worksheet->setCellValue('A' . $row, $adjust->nomor);
          $worksheet->setCellValue('B' . $row, $tanggalkirimFormat);
          $worksheet->setCellValue('C' . $row, "310001");
          $worksheet->setCellValue('D' . $row, $deskripsi);
          $worksheet->setCellValue('E' . $row, "PENJUMLAHAN");
          $worksheet->setCellValue('F' . $row, $name_user);
          $worksheet->setCellValue('G' . $row, "Inventory Adjustment");
          $worksheet->setCellValue('H' . $row, $data->kode);
          $worksheet->setCellValue('I' . $row, $data->hasil_so);
          $worksheet->setCellValue('J' . $row, "0");
          $worksheet->setCellValue('K' . $row, $gudangTujuan);
          $worksheet->setCellValue('L' . $row, "Non Department");
          $worksheet->setCellValue('M' . $row, "Non Project");
          $row++;
        }
      }
    }

    // Create Excel writer
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Export_adjustment.xlsx"');

    ob_end_clean();
    $writer->save('php://output');
    exit();
  }
  public function get_adjust_stok()
  {
    $request = $this->input->post(null, true);
    $column_order = ['tas.id', 'tas.nomor', 'tt.nama_toko', 'ts.tgl_so', 'tas.status', 'tas.created_at'];
    $search_value = $request['search']['value'] ?? '';
    $start = filter_var($request['start'], FILTER_VALIDATE_INT) ?: 0;
    $length = filter_var($request['length'], FILTER_VALIDATE_INT) ?: 10;
    $draw = filter_var($request['draw'], FILTER_VALIDATE_INT) ?: 1;
    $this->db->from('tb_adjust_stok tas')
      ->join('tb_so ts', 'tas.id_so = ts.id')
      ->join('tb_toko tt', 'ts.id_toko = tt.id');
    $total_data = $this->db->count_all_results();
    $this->db->select(['tas.*', 'tt.nama_toko', 'ts.tgl_so'])
      ->from('tb_adjust_stok tas')
      ->join('tb_so ts', 'tas.id_so = ts.id')
      ->join('tb_toko tt', 'ts.id_toko = tt.id');
    if (!empty($search_value)) {
      $this->db->group_start()
        ->like('tas.nomor', $search_value)
        ->or_like('tt.nama_toko', $search_value)
        ->group_end();
    }
    $filtered_data = $this->db->count_all_results('', false);
    $this->db->limit($length, $start);
    if (isset($request['order'])) {
      $column_index = $request['order'][0]['column'];
      $column_dir = $request['order'][0]['dir'];
      $this->db->order_by($column_order[$column_index], $column_dir);
    } else {
      $this->db->order_by('tas.status', 'asc');
      $this->db->order_by('tas.id', 'desc');
    }
    $query = $this->db->get()->result();
    $data = [];
    $no = $start + 1;
    foreach ($query as $row) {
      $data[] = [
        'no' => $no++,
        'nomor' => html_escape($row->nomor),
        'nama_toko' => html_escape($row->nama_toko),
        'id_so' => html_escape($row->id_so),
        'tgl_so' => html_escape($row->tgl_so),
        'status' => $row->status,
        'created_at' => $row->created_at,
        'id' => $row->id
      ];
    }
    $response = [
      "draw" => $draw,
      "recordsTotal" => $total_data,
      "recordsFiltered" => $filtered_data,
      "data" => $data
    ];

    echo json_encode($response);
  }
  public function adjust_detail($id)
  {
    $data['title'] = 'Adjustment Stok';
    $data['row'] = $this->db->query("SELECT tas.*, tt.nama_toko, ts.tgl_so as periode, ts.id_toko from tb_adjust_stok tas
    JOIN tb_so ts on tas.id_so = ts.id
    JOIN tb_toko tt on ts.id_toko = tt.id
    WHERE tas.id = ?", array($id))->row();
    $data['detail'] = $this->db->query("SELECT tad.*, tp.kode,tp.nama_produk as artikel from tb_adjust_detail tad
    JOIN tb_produk tp on tad.id_produk = tp.id
    WHERE tad.id_adjust = ?", array($id))->result();
    $data['histori'] = $this->db->query("SELECT * from tb_adjust_histori where id_adjust = ?", array($id))->result();
    $this->template->load('template/template', 'adm/stok/adjust_detail', $data);
  }
  public function adjust_save()
  {
    $pengguna = $this->session->userdata('nama_user');
    $id_adjust = $this->input->post('id_adjust', true);
    $no_adjust = $this->input->post('no_adjust', true);
    $id_so = $this->input->post('id_so', true);
    $id_toko = $this->input->post('id_toko', true);
    $id_produk = $this->input->post('id_produk', true);
    $hasil_so = $this->input->post('hasil_so', true);
    $catatan = $this->input->post('catatan', true);
    $keputusan = $this->input->post('keputusan', true);
    $jml = count($id_produk);
    $tgl_so = $this->db->query("SELECT tgl_so FROM tb_so WHERE id = ?", array($id_so))->row()->tgl_so;
    $tgl_acc = date('Y-m-d H:i:s');
    $this->db->trans_start();
    if ($keputusan == 1) {
      $aksi = "Diverifikasi Oleh :";
      $kartu_data = [];
      for ($i = 0; $i < $jml; $i++) {
        $terima_result = $this->db->query("SELECT SUM(tpd.qty_diterima) AS total_qty FROM tb_pengiriman_detail tpd
        JOIN tb_pengiriman tp ON tpd.id_pengiriman = tp.id
        WHERE tp.id_toko = ? 
        AND tp.updated_at BETWEEN ? AND ? 
        AND tpd.id_produk = ?", array($id_toko, $tgl_so, $tgl_acc, $id_produk[$i]))->row();
        $jual_result = $this->db->query("SELECT SUM(tpd.qty) AS total_qty FROM tb_penjualan_detail tpd
        JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
        WHERE tp.id_toko = ? 
        AND tp.tanggal_penjualan BETWEEN ? AND ? 
        AND tpd.id_produk = ?", array($id_toko, $tgl_so, $tgl_acc, $id_produk[$i]))->row();
        $mutasi_k = $this->db->query("SELECT SUM(tpd.qty_terima) AS total_qty FROM tb_mutasi_detail tpd
        JOIN tb_mutasi tp ON tpd.id_mutasi = tp.id
        WHERE tp.id_toko_asal = ?  AND tp.status = 2
        AND tp.updated_at BETWEEN ? AND ? 
        AND tpd.id_produk = ?", array($id_toko, $tgl_so, $tgl_acc, $id_produk[$i]))->row();
        $mutasi_m = $this->db->query("SELECT SUM(tpd.qty_terima) AS total_qty FROM tb_mutasi_detail tpd
        JOIN tb_mutasi tp ON tpd.id_mutasi = tp.id
        WHERE tp.id_toko_tujuan = ?  AND tp.status = 2
        AND tp.updated_at BETWEEN ? AND ? 
        AND tpd.id_produk = ?", array($id_toko, $tgl_so, $tgl_acc, $id_produk[$i]))->row();
        $retur_result = $this->db->query("SELECT SUM(tpd.qty_terima) AS total_qty FROM tb_retur_detail tpd
        JOIN tb_retur tp ON tpd.id_retur = tp.id
        WHERE tp.id_toko = ?  AND tp.status = 4
        AND tp.updated_at BETWEEN ? AND ? 
        AND tpd.id_produk = ?", array($id_toko, $tgl_so, $tgl_acc, $id_produk[$i]))->row();
        $terima = $terima_result->total_qty ?? 0;
        $jual = $jual_result->total_qty ?? 0;
        $mutasi_keluar = $mutasi_k->total_qty ?? 0;
        $mutasi_masuk = $mutasi_m->total_qty ?? 0;
        $retur = $retur_result->total_qty ?? 0;
        $cek_stok = $this->db->query("SELECT qty from tb_stok where id_toko = ? AND id_produk = ?", array($id_toko, $id_produk[$i]))->row();
        $stok_sistem = $cek_stok->qty ?? 0;
        $this->db->set('qty', $hasil_so[$i] + $terima + $mutasi_masuk - $jual - $mutasi_keluar - $retur)
          ->where('id_produk', $id_produk[$i])
          ->where('id_toko', $id_toko)
          ->update('tb_stok');
        $kartu_data[] = [
          'no_doc' => $no_adjust,
          'id_produk' => $id_produk[$i],
          'id_toko' => $id_toko,
          'stok' => $stok_sistem,
          'sisa' => $hasil_so[$i] + $terima + $mutasi_masuk - $jual - $mutasi_keluar - $retur,
          'keterangan' => 'Adjustment Stok',
          'pembuat' => $pengguna
        ];
      }
      $this->db->insert_batch('tb_kartu_stok', $kartu_data);
      // update status adjust di tb
      $this->db->update('tb_toko', ['status_adjust' => '1', 'id_adjust' => $id_adjust], ['id' => $id_toko]);
    } else {
      $aksi = "Ditolak Oleh :";
    }

    $this->db->update('tb_adjust_stok', ['status' => $keputusan], ['id' => $id_adjust]);
    $this->db->insert('tb_adjust_histori', [
      'id_adjust' => $id_adjust,
      'aksi' => $aksi,
      'pembuat' => $pengguna,
      'catatan' => $catatan
    ]);

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      tampil_alert('error', 'Gagal', 'Terjadi kesalahan, data tidak tersimpan.');
    } else {
      tampil_alert('success', 'Berhasil', 'Data Adjustment Stok berhasil proses.');
    }
    redirect(base_url('adm/Stok/adjust_detail/' . $id_adjust));
  }
  public function adjust_restore()
  {
    $pengguna = $this->session->userdata('nama_user');
    $id_adjust = $this->input->post('id_adjust', true);
    $id_so = $this->input->post('id_so', true);
    $id_toko = $this->input->post('id_toko', true);
    $id_produk = $this->input->post('id_produk', true);
    $stok_akhir = $this->input->post('stok_akhir', true);

    // Validasi awal
    if (empty($id_adjust) || empty($id_so) || empty($id_toko) || empty($id_produk)) {
      $this->session->set_flashdata('error', 'Data tidak lengkap untuk proses restore.');
      redirect('adm/Stok/adjust_stok');
      return;
    }

    $jml = count($id_produk);

    // Ambil tanggal stock opname
    $tgl_so = $this->db->query("SELECT tgl_so FROM tb_so WHERE id = ?", array($id_so))->row_array()['tgl_so'] ?? null;
    if (!$tgl_so) {
      $this->session->set_flashdata('error', 'Data stok opname tidak ditemukan.');
      redirect('adm/Stok/adjust_stok');
      return;
    }

    $this->db->trans_start(); // Mulai transaksi

    for ($i = 0; $i < $jml; $i++) {
      $id_produk[$i] = intval($id_produk[$i]);
      $stok_akhir[$i] = intval($stok_akhir[$i]);

      $query_params = [$id_toko, $tgl_so, $id_produk[$i]];
      $terima = $this->db->query("SELECT SUM(tpd.qty_diterima) AS total_qty  FROM tb_pengiriman_detail tpd
      JOIN tb_pengiriman tp 
          ON tpd.id_pengiriman = tp.id
      WHERE 
          tp.id_toko = ?
          AND tp.updated_at BETWEEN '2024-12-01' AND ? 
            AND tpd.id_produk = ?", $query_params)->row_array()['total_qty'] ?? 0;
      $jual = $this->db->query("SELECT SUM(tpd.qty) AS total_qty FROM tb_penjualan_detail tpd
      JOIN tb_penjualan tp 
          ON tpd.id_penjualan = tp.id
      WHERE 
          tp.id_toko = ? 
          AND tp.tanggal_penjualan BETWEEN '2024-12-01' AND ?
            AND tpd.id_produk = ?", $query_params)->row_array()['total_qty'] ?? 0;
      $mutasi_keluar = $this->db->query("SELECT SUM(tpd.qty_terima) AS total_qty FROM tb_mutasi_detail tpd
      JOIN tb_mutasi tp 
          ON tpd.id_mutasi = tp.id
      WHERE 
          tp.id_toko_asal = ? AND tp.status = 2
          AND tp.updated_at BETWEEN '2024-12-01' AND ?
            AND tpd.id_produk = ?", $query_params)->row_array()['total_qty'] ?? 0;
      $mutasi_masuk = $this->db->query("SELECT SUM(tpd.qty_terima) AS total_qty FROM tb_mutasi_detail tpd
      JOIN tb_mutasi tp 
          ON tpd.id_mutasi = tp.id
      WHERE 
          tp.id_toko_tujuan = ? AND tp.status = 2
          AND tp.updated_at BETWEEN '2024-12-01' AND ?
            AND tpd.id_produk = ?", $query_params)->row_array()['total_qty'] ?? 0;
      $retur = $this->db->query("SELECT SUM(tpd.qty_terima) AS total_qty FROM tb_retur_detail tpd
      JOIN tb_retur tp 
          ON tpd.id_retur = tp.id
      WHERE 
          tp.id_toko = ? AND tp.status >= 2 AND tp.status <= 4
          AND tp.updated_at BETWEEN '2024-12-01' AND ?
            AND tpd.id_produk = ?", $query_params)->row_array()['total_qty'] ?? 0;
      $nextJual = $this->db->query("SELECT SUM(tpdd.qty) AS total_qty FROM tb_penjualan_detail tpdd
      JOIN tb_penjualan tpp ON tpdd.id_penjualan = tpp.id
      WHERE tpp.id_toko = ?
      AND tpp.tanggal_penjualan BETWEEN DATE_FORMAT(?, '%Y-%m-01 00:00:00') AND ?
            AND tpdd.id_produk = ?", [$id_toko, $tgl_so, $tgl_so, $id_produk[$i]])->row_array()['total_qty'] ?? 0;
      // Hitung stok awal
      $qty_awal = $stok_akhir[$i] - $terima - $mutasi_masuk + $jual + $mutasi_keluar + $retur - $nextJual;

      // Update stok awal di tabel tb_stok
      $this->db->set('qty_awal', $qty_awal)
        ->where('id_produk', $id_produk[$i])
        ->where('id_toko', $id_toko)
        ->update('tb_stok');
    }

    // Insert histori adjustment
    $this->db->insert('tb_adjust_histori', [
      'id_adjust' => $id_adjust,
      'aksi' => 'Direstore Oleh :',
      'pembuat' => $pengguna,
      'catatan' => 'Restore Data Adjust Stok.'
    ]);

    $this->db->trans_complete(); // Selesaikan transaksi

    if ($this->db->trans_status() === FALSE) {
      tampil_alert('error', 'Gagal', 'Terjadi kesalahan, data tidak tersimpan.');
    } else {
      tampil_alert('success', 'Berhasil', 'Proses Restore data berhasil..');
    }

    redirect('adm/Stok/adjust_stok');
  }

  public function stok_gudang()
  {
    $data['title'] = 'Stok Gudang';
    $data['t_item'] = $this->db->query("SELECT count(id) as total_item, SUM(stok) as total_stok FROM tb_produk where status = 1  ")->row();
    $data['waktu']  = $this->db->query("SELECT updated_at from tb_produk_histori order by id desc limit 1")->row();
    $this->template->load('template/template', 'adm/stok/stok_gudang', $data);
  }
  public function get_stokGudang()
  {
    $request = $this->input->post(null, true);
    $column_order = ['id', 'kode', 'nama_produk', 'satuan', 'stok'];
    $search_value = $request['search']['value'] ?? '';
    $start = filter_var($request['start'], FILTER_VALIDATE_INT) ?: 0;
    $length = filter_var($request['length'], FILTER_VALIDATE_INT) ?: 10;
    $draw = filter_var($request['draw'], FILTER_VALIDATE_INT) ?: 1;
    $this->db->from('tb_produk');
    $total_data = $this->db->count_all_results();
    $this->db->select(['*'])
      ->from('tb_produk');
    if (!empty($search_value)) {
      $this->db->group_start()
        ->like('kode', $search_value)
        ->or_like('nama_produk', $search_value)
        ->or_like('stok', $search_value)
        ->or_like('satuan', $search_value)
        ->group_end();
    }
    $filtered_data = $this->db->count_all_results('', false);
    $this->db->limit($length, $start);
    if (isset($request['order'])) {
      $column_index = $request['order'][0]['column'];
      $column_dir = $request['order'][0]['dir'];
      $this->db->order_by($column_order[$column_index], $column_dir);
    } else {
      $this->db->order_by('id', 'desc');
    }
    $query = $this->db->get()->result();
    $data = [];
    $no = $start + 1;
    foreach ($query as $row) {
      $data[] = [
        'no' => $no++,
        'kode' => html_escape($row->kode),
        'nama_produk' => html_escape($row->nama_produk),
        'satuan' => html_escape($row->satuan),
        'stok' => $row->stok
      ];
    }
    $response = [
      "draw" => $draw,
      "recordsTotal" => $total_data,
      "recordsFiltered" => $filtered_data,
      "data" => $data
    ];

    echo json_encode($response);
  }
  public function process_import()
  {
    if ($_FILES['excel_file']['name']) {
      $config['upload_path'] = './assets/excel/';
      $config['allowed_types'] = 'xlsx';
      $config['max_size'] = 2048;
      $this->upload->initialize($config);
      if (!$this->upload->do_upload('excel_file')) {
        $error = array('error' => $this->upload->display_errors());
        echo json_encode($error);
      } else {
        $data = $this->upload->data();
        $file_path = './assets/excel/' . $data['file_name'];
        $spreadsheet = IOFactory::load($file_path);
        $sheet = $spreadsheet->getActiveSheet();
        $excelData = '';
        $rowNum = 1;
        $startRow = 6;
        $highestRow = $sheet->getHighestRow();
        $totalData = 0;
        $totalTerverifikasi = 0;
        $totalTidakDitemukan = 0;
        $kodeArray = [];
        for ($row = $startRow; $row <= $highestRow; $row++) {
          $kode = $sheet->getCell('C' . $row)->getValue();
          $kodeArray[] = $kode;
        }
        $this->db->where_in('kode', $kodeArray);
        $produkQuery = $this->db->get('tb_produk');
        $existingProduk = $produkQuery->result_array();
        $existingKodeArray = array_column($existingProduk, 'kode');
        for ($row = $startRow; $row <= $highestRow; $row++) {
          $excelData .= '<tr>';
          $excelData .= '<td>' . ($row - $startRow + 1) . '</td>';
          $kode = $sheet->getCell('C' . $row)->getValue();
          $nama_artikel = $sheet->getCell('F' . $row)->getValue();
          $stok = $sheet->getCell('I' . $row)->getValue();
          $totalData++;
          if (in_array($kode, $existingKodeArray)) {
            $status = "<small class='text-success'> Terverifikasi </small>";
            $totalTerverifikasi++;
          } else {
            $status = "<small class='text-danger'> Kode tidak ditemukan </small>";
            $totalTidakDitemukan++;
          }
          $excelData .= '<td>' . $kode . '</td>';
          $excelData .= '<td>' . $nama_artikel . '</td>';
          $excelData .= '<td>' . $stok . '</td>';
          $excelData .= '<td>' . $status . '</td>';
          $excelData .= '</tr>';
        }
        unlink($file_path);
        $response = [
          'excelData' => $excelData,
          'totalData' => $totalData,
          'totalTerverifikasi' => $totalTerverifikasi,
          'totalTidakDitemukan' => $totalTidakDitemukan
        ];
        echo json_encode($response);
      }
    } else {
      echo json_encode(['error' => 'No file uploaded']);
    }
  }
  public function save_import()
  {
    $pengguna = $this->session->userdata('nama_user');
    $this->db->trans_start();
    $this->db->insert('tb_produk_histori', array('pengguna' => $pengguna));
    $postData = json_decode(file_get_contents('php://input'), true);
    if (!empty($postData)) {
      $notFoundCodes = [];
      $updateData = [];
      foreach ($postData as $data) {
        $kode = $data['kode'];
        $stok = $data['stok'];
        $productExists = $this->db->get_where('tb_produk', ['kode' => $kode])->row();
        if ($productExists) {
          $updateData[] = [
            'kode' => $kode,
            'stok' => $stok
          ];
        } else {
          $notFoundCodes[] = $kode;
        }
      }
      if (!empty($updateData)) {
        $this->db->update_batch('tb_produk', $updateData, 'kode');
      }
      $response = [
        'status' => 'success',
        'message' => empty($notFoundCodes) ? 'Semua data berhasil disimpan.' : 'Menyimpan data sebagian, beberapa kode artikel tidak ditemukan.'
      ];
      echo json_encode($response);
    } else {
      $response = [
        'status' => 'error',
        'message' => 'Tidak ada data yang diterima.'
      ];
      echo json_encode($response);
    }
    $this->db->trans_complete();
  }
  public function unduhExcel()
  {
    $dataToko = $this->db->query("SELECT * from tb_produk where status = 1 ORDER BY id desc")->result();
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Kode');
    $sheet->setCellValue('C1', 'Artikel');
    $sheet->setCellValue('D1', 'Satuan');
    $sheet->setCellValue('E1', 'Stok');
    $row = 2;
    $no = 1;
    foreach ($dataToko as $data) {
      $sheet->setCellValue('A' . $row, $no);
      $sheet->setCellValue('B' . $row, $data->kode);
      $sheet->setCellValue('C' . $row, $data->nama_produk);
      $sheet->setCellValue('D' . $row, $data->satuan);
      $sheet->setCellValue('E' . $row, $data->stok);
      $row++;
      $no++;
    }
    $fileName = 'stok_gudang' . date('dMY') . '.xlsx';
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    ob_end_clean();
    $writer->save('php://output');
    exit();
  }
}
