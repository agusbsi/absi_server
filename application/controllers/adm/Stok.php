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
    $this->load->library('upload');
    $this->load->database();
  }

  //   halaman utama
  public function index()
  {
    $data['title'] = 'Stok Artikel';
    $data['artikel'] = $this->db->query("SELECT * FROM tb_produk WHERE status = 1 ORDER BY kode ASC")->result();
    $data['stok'] = $this->db->query("SELECT sum(ts.qty) as total FROM tb_stok ts
    JOIN tb_toko tt on ts.id_toko = tt.id where ts.status = 1 AND tt.status != 0 ")->row();
    $this->template->load('template/template', 'adm/stok/index', $data);
  }
  public function detail($id_artikel, $tanggal)
  {
    $data['title'] = 'Stok Artikel';

    $query = "
        SELECT tt.nama_toko, ks.sisa AS stok
        FROM tb_kartu_stok ks
        JOIN tb_toko tt ON ks.id_toko = tt.id
        WHERE ks.id_produk = ?
          AND tt.status != 0
          AND ks.tanggal = (
              SELECT MAX(tanggal)
              FROM tb_kartu_stok
              WHERE id_produk = ks.id_produk
                AND id_toko = ks.id_toko
                AND tanggal <= ?
          )
        ORDER BY tt.nama_toko ASC
    ";
    $params = [$id_artikel, $tanggal];

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
          where ts.id_produk = '$id' AND ts.status = 1 AND tt.status != 0
          GROUP BY tc.id
          ORDER BY SUM(ts.qty) DESC";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'adm/stok/detail_cust', $data);
  }
  public function s_customer()
  {
    $data['title'] = 'Laporan Stok Customer';

    $bulan = $this->input->post('bulan') ?: $this->input->get('bulan') ?: date('m');
    $tahun = $this->input->post('tahun') ?: $this->input->get('tahun') ?: date('Y');
    $bulan = str_pad((int)$bulan, 2, '0', STR_PAD_LEFT);
    $tahun = (string)(int)$tahun;

    $tanggal = strtotime("$tahun-$bulan-01");
    $start_so = date('Y-m-01 00:00:00', strtotime("+1 month", $tanggal));
    $end_so = date('Y-m-01 00:00:00', strtotime("+2 month", $tanggal));

    $query = "SELECT 
        tc.id,
        tc.nama_cust,
        COALESCE(sc.stok_awal, 0) AS stok_awal,
        COALESCE(sc.penjualan, 0) AS penjualan,
        COALESCE(sc.stok_akhir, 0) AS stok_akhir
      FROM tb_customer tc
      JOIN (
        SELECT DISTINCT id_customer
        FROM tb_toko
        WHERE status = 1
      ) active_customer ON active_customer.id_customer = tc.id
      LEFT JOIN (
        SELECT 
          tt.id_customer,
          SUM(COALESCE(sod.qty_awal, 0)) AS stok_awal,
          SUM(COALESCE(sod.jual, 0)) AS penjualan,
          SUM(COALESCE(sod.stok_akhir, 0)) AS stok_akhir
        FROM tb_toko tt
        JOIN tb_so so ON tt.id = so.id_toko
          AND so.created_at >= ?
          AND so.created_at < ?
          AND so.status_kunci = 1
        LEFT JOIN tb_so_detail sod ON so.id = sod.id_so
        WHERE tt.status != 0
        GROUP BY tt.id_customer
      ) sc ON tc.id = sc.id_customer
      ORDER BY tc.nama_cust ASC";

    $data['list_data'] = $this->db->query($query, [$start_so, $end_so])->result();
    $data['periode'] = date('F Y', strtotime("$tahun-$bulan-01"));
    $data['bulan_filter'] = $bulan;
    $data['tahun_filter'] = $tahun;
    $data['total_stok_awal'] = 0;
    $data['total_penjualan'] = 0;
    $data['total_stok_akhir'] = 0;

    foreach ($data['list_data'] as $item) {
      $data['total_stok_awal'] += $item->stok_awal;
      $data['total_penjualan'] += $item->penjualan;
      $data['total_stok_akhir'] += $item->stok_akhir;
    }

    $this->template->load('template/template', 'adm/stok/customer', $data);
  }

  public function detail_customer($id_cust, $tahun, $bulan)
  {
    $id_cust = (int)$id_cust;
    $tahun = (string)(int)$tahun;
    $bulan = str_pad((int)$bulan, 2, '0', STR_PAD_LEFT);

    $tanggal = strtotime("$tahun-$bulan-01");
    $start_so = date('Y-m-01 00:00:00', strtotime("+1 month", $tanggal));
    $end_so = date('Y-m-01 00:00:00', strtotime("+2 month", $tanggal));

    $data['title'] = 'Detail Stok Customer';
    $data['customer'] = $this->db->get_where('tb_customer', ['id' => $id_cust])->row();
    $data['periode'] = date('F Y', strtotime("$tahun-$bulan-01"));
    $data['bulan_filter'] = $bulan;
    $data['tahun_filter'] = $tahun;

    $query = "SELECT 
        tt.id,
        tt.nama_toko,
        so_data.status_kunci,
        so_data.nomor_so,
        COALESCE(so_data.stok_awal, 0) AS stok_awal,
        COALESCE(so_data.penjualan, 0) AS penjualan,
        COALESCE(so_data.stok_akhir, 0) AS stok_akhir
      FROM tb_toko tt
      LEFT JOIN (
        SELECT
          so.id_toko,
          MAX(so.status_kunci) AS status_kunci,
          MAX(so.id) AS nomor_so,
          SUM(COALESCE(sod.qty_awal, 0)) AS stok_awal,
          SUM(COALESCE(sod.jual, 0)) AS penjualan,
          SUM(COALESCE(sod.stok_akhir, 0)) AS stok_akhir
        FROM tb_so so
        LEFT JOIN tb_so_detail sod ON so.id = sod.id_so
        WHERE so.created_at >= ?
          AND so.created_at < ?
          AND so.status_kunci = 1
        GROUP BY so.id_toko
      ) so_data ON tt.id = so_data.id_toko
      WHERE tt.id_customer = ? AND tt.status != 0
      ORDER BY tt.nama_toko ASC";

    $data['list_data'] = $this->db->query($query, [$start_so, $end_so, $id_cust])->result();
    $data['total_stok_awal'] = 0;
    $data['total_penjualan'] = 0;
    $data['total_stok_akhir'] = 0;

    foreach ($data['list_data'] as $item) {
      $data['total_stok_awal'] += $item->stok_awal;
      $data['total_penjualan'] += $item->penjualan;
      $data['total_stok_akhir'] += $item->stok_akhir;
    }

    $this->template->load('template/template', 'adm/stok/detail_customer', $data);
  }
  public function s_toko()
  {
    // tampil_alert('info', 'Maintenance', 'Fitur laporan Stok per toko sedang di perbarui, silahkan coba lagi nanti.');
    // redirect(base_url('adm/Dashboard'));
    $data['title'] = 'Stok per Toko';
    $data['toko'] = $this->db->query("SELECT * FROM tb_toko WHERE status = 1 ORDER BY nama_toko ASC")->result();
    $this->template->load('template/template', 'adm/stok/stok_toko', $data);
  }
  function list_ajax_artikel($toko)
  {
    $hasil = $this->db->query("SELECT DISTINCT tp.* FROM tb_stok ts
    JOIN tb_produk tp ON ts.id_produk = tp.id
    JOIN tb_toko tt ON ts.id_toko = tt.id
    WHERE ts.id_toko = ?
      AND ts.status = 1
      AND tp.status = 1
      AND tt.status = 1
    ORDER BY tp.kode ASC", $toko)->result();
    header('Content-Type: application/json');
    echo json_encode($hasil);
  }
  public function cari_stokartikel()
  {
    $id_artikel = $this->input->get('id_artikel');
    $tanggal = $this->input->get('tanggal');
    $artikel = "Semua Artikel";
    $where_artikel = "";
    // Gunakan batas eksklusif hari berikutnya agar seluruh transaksi pada
    // tanggal yang dipilih masuk, termasuk yang memiliki pecahan detik.
    $params = [$tanggal];

    if ($id_artikel !== "all") {
      $where_artikel = "AND tp.id = ?";
      $params[] = $id_artikel;

      $summary = $this->db->get_where('tb_produk', ['id' => $id_artikel])->row();
      if ($summary) {
        $artikel = '<strong>' . htmlspecialchars($summary->kode) . '</strong><br>' . htmlspecialchars($summary->nama_produk);
      } else {
        $artikel = 'Artikel tidak ditemukan';
      }
    }

    $query = "
        SELECT
            tp.id,
            tp.kode,
            tp.nama_produk as deskripsi,
            COALESCE(SUM(ks.sisa), 0) AS stok
        FROM tb_stok ts
        JOIN tb_toko tt ON tt.id = ts.id_toko
        JOIN tb_produk tp ON tp.id = ts.id_produk
        LEFT JOIN (
            SELECT ks1.id_produk, ks1.id_toko, ks1.sisa
            FROM tb_kartu_stok ks1
            JOIN (
                SELECT id_produk, id_toko, MAX(id) AS last_id
                FROM tb_kartu_stok
                WHERE tanggal < DATE_ADD(?, INTERVAL 1 DAY)
                GROUP BY id_produk, id_toko
            ) last_ks ON last_ks.last_id = ks1.id
        ) ks ON ks.id_produk = ts.id_produk
            AND ks.id_toko = ts.id_toko
        WHERE ts.status = 1
          AND tt.status != 0
          AND tp.status = 1
          $where_artikel
        GROUP BY tp.id, tp.kode, tp.nama_produk
        ORDER BY tp.kode ASC
    ";

    $hasil_data = $this->db->query($query, $params)->result();

    $no = 1;
    foreach ($hasil_data as $row) {
      $row->nomor = $no++;
      $row->tanggal = date('d M Y', strtotime($tanggal));
    }

    $data = [
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
    $semua_artikel = ($id_artikel === 'all' || empty($id_artikel));
    $where_artikel_subquery = '';
    $where_artikel_utama = '';
    $params = [$id_toko, $tanggal];

    if ($semua_artikel) {
      $artikel = '( Semua Artikel )';
    } else {
      $where_artikel_subquery = 'AND id_produk = ?';
      $where_artikel_utama = 'AND ts.id_produk = ?';
      $params[] = $id_artikel;

      $summary = $this->db->get_where('tb_produk', ['id' => $id_artikel])->row();
      $artikel = $summary
        ? '<strong>' . htmlspecialchars($summary->kode) . '</strong></br>' . htmlspecialchars($summary->nama_produk)
        : 'Artikel tidak ditemukan';
    }

    $params[] = $id_toko;
    if (!$semua_artikel) {
      $params[] = $id_artikel;
    }

    $query = "
        SELECT
            tt.nama_toko,
            tp.nama_produk,
            tp.kode,
            tp.satuan,
            COALESCE(ks.sisa, 0) AS stok
        FROM tb_stok ts
        JOIN tb_toko tt ON tt.id = ts.id_toko
        JOIN tb_produk tp ON tp.id = ts.id_produk
        LEFT JOIN (
            SELECT ks1.id_produk, ks1.id_toko, ks1.sisa
            FROM tb_kartu_stok ks1
            JOIN (
                SELECT id_produk, id_toko, MAX(id) AS last_id
                FROM tb_kartu_stok
                WHERE id_toko = ?
                  AND tanggal < DATE_ADD(?, INTERVAL 1 DAY)
                  $where_artikel_subquery
                GROUP BY id_produk, id_toko
            ) last_ks ON last_ks.last_id = ks1.id
        ) ks ON ks.id_produk = ts.id_produk
            AND ks.id_toko = ts.id_toko
        WHERE ts.id_toko = ?
          AND ts.status = 1
          AND tt.status != 0
          AND tp.status = 1
          $where_artikel_utama
        ORDER BY tp.kode ASC";

    $hasil_data = $this->db->query($query, $params)->result();
    $toko = $this->db->get_where('tb_toko', ['id' => $id_toko])->row();

    $data = [
      'toko' => $toko ? $toko->nama_toko : 'Toko tidak ditemukan',
      'artikel' => $artikel,
      'tanggal' => date('d M Y', strtotime($tanggal)),
      'tabel_data' => $hasil_data
    ];

    echo json_encode($data);
  }


  public function detail_toko($id)
  {
    $data['title'] = 'Detail Toko per Customer';
    $lastMonth = new DateTime('first day of -1 month');
    $thn = $lastMonth->format('Y');
    $bln = $lastMonth->format('m');

    // Query untuk mendapatkan data customer
    $data['customer'] = $this->db->get_where('tb_customer', ['id' => $id])->row();

    // Query detail per toko dengan informasi lengkap
    $query = "
      SELECT 
          tc.id as id_customer,
          tc.nama_cust, 
          tt.id as id_toko,
          tt.nama_toko,
          tt.alamat,
          tt.telp,
          (SELECT COUNT(DISTINCT ts.id_produk) FROM tb_stok ts WHERE ts.id_toko = tt.id AND ts.status = 1 AND ts.qty > 0) AS total_item,
          COALESCE(SUM(ts.qty), 0) AS t_stok,
          (SELECT COALESCE(SUM(ts.qty_awal), 0) FROM tb_stok ts WHERE ts.id_toko = tt.id AND ts.status = 1) AS t_akhir,
          (SELECT COALESCE(SUM(ts.jml_jual), 0) FROM vw_penjualan ts WHERE ts.id_toko = tt.id AND ts.tahun = '$thn' AND ts.bulan = '$bln') AS t_jual,
          (SELECT COALESCE(COUNT(DISTINCT tp.id), 0) FROM tb_penjualan tp WHERE tp.id_toko = tt.id AND YEAR(tp.tanggal_penjualan) = '$thn' AND MONTH(tp.tanggal_penjualan) = '$bln') AS total_transaksi
      FROM 
          tb_customer tc
      JOIN 
          tb_toko tt ON tc.id = tt.id_customer
      LEFT JOIN 
          tb_stok ts ON tt.id = ts.id_toko AND ts.status = 1
      WHERE 
          tc.id = '$id' AND tt.status != 0 
      GROUP BY 
          tt.id 
      ORDER BY 
          t_stok DESC
      ";

    $data['list_data'] = $this->db->query($query)->result();

    // Ringkasan total untuk customer ini
    $summary_query = "
      SELECT 
          COUNT(DISTINCT tt.id) AS total_toko,
          COALESCE(SUM(ts.qty), 0) AS total_stok,
          COALESCE(SUM(ts.qty_awal), 0) AS total_stok_akhir,
          (SELECT COALESCE(SUM(vp.jml_jual), 0) FROM vw_penjualan vp 
           JOIN tb_toko t ON vp.id_toko = t.id 
           WHERE t.id_customer = '$id' AND vp.tahun = '$thn' AND vp.bulan = '$bln') AS total_jual
      FROM 
          tb_toko tt
      LEFT JOIN 
          tb_stok ts ON tt.id = ts.id_toko AND ts.status = 1
      WHERE 
          tt.id_customer = '$id' AND tt.status != 0
      ";

    $data['summary'] = $this->db->query($summary_query)->row();
    $data['periode'] = $lastMonth->format('F Y');

    $this->template->load('template/template', 'adm/stok/detail_toko', $data);
  }

  public function detail_artikel($id)
  {
    $data['title'] = 'Detail Artikel per Customer';
    $lastMonth = new DateTime('first day of -1 month');
    $thn = $lastMonth->format('Y');
    $bln = $lastMonth->format('m');

    // Query untuk mendapatkan data customer
    $data['customer'] = $this->db->get_where('tb_customer', ['id' => $id])->row();

    // Query detail per artikel dengan informasi lengkap
    $query = "
      SELECT 
          tp.id as id_produk,
          tp.kode,
          tp.nama_produk as artikel,
          tp.satuan,
          COALESCE(SUM(ts.qty), 0) AS t_stok,
          (SELECT COALESCE(SUM(ts.qty_awal), 0) FROM tb_stok ts 
           JOIN tb_toko tt ON ts.id_toko = tt.id 
           WHERE ts.id_produk = tp.id AND tt.id_customer = tc.id AND ts.status = 1 AND tt.status != 0) AS t_akhir,
          (SELECT COALESCE(SUM(tpd.qty), 0) FROM tb_penjualan_detail tpd
           JOIN tb_penjualan tpj ON tpd.id_penjualan = tpj.id
           JOIN tb_toko tt ON tpj.id_toko = tt.id
           WHERE tpd.id_produk = tp.id AND tt.id_customer = tc.id AND YEAR(tpj.tanggal_penjualan) = '$thn' AND MONTH(tpj.tanggal_penjualan) = '$bln') AS t_jual
      FROM 
          tb_customer tc
      JOIN 
          tb_toko tt ON tc.id = tt.id_customer
      LEFT JOIN 
          tb_stok ts ON tt.id = ts.id_toko AND ts.status = 1
      JOIN 
          tb_produk tp ON ts.id_produk = tp.id
      WHERE 
          tc.id = '$id' AND tt.status != 0 AND tp.status = 1
      GROUP BY 
          tp.id 
      ORDER BY 
          t_jual DESC
      ";

    $data['list_data'] = $this->db->query($query)->result();

    // Ringkasan total untuk customer ini
    $summary_query = "
      SELECT 
          COUNT(DISTINCT tp.id) AS total_artikel,
          COALESCE(SUM(ts.qty), 0) AS total_stok,
          COALESCE(SUM(ts.qty_awal), 0) AS total_stok_akhir,
          (SELECT COALESCE(SUM(tpd.qty), 0) FROM tb_penjualan_detail tpd
           JOIN tb_penjualan tpj ON tpd.id_penjualan = tpj.id
           JOIN tb_toko tt ON tpj.id_toko = tt.id
           WHERE tt.id_customer = '$id' AND YEAR(tpj.tanggal_penjualan) = '$thn' AND MONTH(tpj.tanggal_penjualan) = '$bln') AS total_jual
      FROM 
          tb_toko tt
      LEFT JOIN 
          tb_stok ts ON tt.id = ts.id_toko AND ts.status = 1
      LEFT JOIN
          tb_produk tp ON ts.id_produk = tp.id
      WHERE 
          tt.id_customer = '$id' AND tt.status != 0 AND tp.status = 1
      ";

    $data['summary'] = $this->db->query($summary_query)->row();
    $data['periode'] = $lastMonth->format('F Y');

    $this->template->load('template/template', 'adm/stok/detail_artikel', $data);
  }

  // Utilitas sementara; sengaja tidak ditambahkan ke sidebar.
  public function perbaikan_stok()
  {
    $data['title'] = 'Perbaikan Stok';
    $data['ringkasan'] = $this->ringkasan_perbaikan_stok();
    $this->template->load('template/template', 'adm/stok/perbaikan_stok', $data);
  }

  public function cek_perbaikan_stok()
  {
    $this->jawaban_stok(['success' => true, 'data' => $this->ringkasan_perbaikan_stok()]);
  }

  public function backup_kartu_stok()
  {
    if (strtoupper($this->input->method()) !== 'POST') return $this->jawaban_stok(['success' => false, 'message' => 'Metode tidak diizinkan.'], 405);
    $this->db->query('DROP TABLE IF EXISTS tb_kartu_stok_backup');
    if (!$this->db->query('CREATE TABLE tb_kartu_stok_backup AS SELECT * FROM tb_kartu_stok')) {
      return $this->jawaban_stok(['success' => false, 'message' => 'Backup gagal dibuat.'], 500);
    }
    $this->jawaban_stok(['success' => true, 'jumlah' => (int) $this->db->count_all('tb_kartu_stok_backup'), 'waktu' => date('d-m-Y H:i:s')]);
  }

  public function mulai_perbaikan_stok()
  {
    if (strtoupper($this->input->method()) !== 'POST') return $this->jawaban_stok(['success' => false, 'message' => 'Metode tidak diizinkan.'], 405);
    $this->session->set_userdata('perbaikan_stok_berhenti', false);
    $this->jawaban_stok(['success' => true, 'data' => $this->ringkasan_perbaikan_stok()]);
  }

  public function proses_perbaikan_stok()
  {
    if (strtoupper($this->input->method()) !== 'POST') return $this->jawaban_stok(['success' => false, 'message' => 'Metode tidak diizinkan.'], 405);
    if ($this->session->userdata('perbaikan_stok_berhenti')) return $this->jawaban_stok(['success' => true, 'stopped' => true, 'data' => $this->ringkasan_perbaikan_stok()]);

    $this->db->query("UPDATE tb_kartu_stok SET sisa = COALESCE(stok,0)+COALESCE(masuk,0)-COALESCE(keluar,0)
      WHERE COALESCE(no_doc,'') <> 'import stok' AND COALESCE(no_doc,'') NOT LIKE 'AD-%'
      AND COALESCE(keterangan,'') NOT LIKE '%BAP%'
      AND COALESCE(sisa,0) <> COALESCE(stok,0)+COALESCE(masuk,0)-COALESCE(keluar,0)");
    $sisa = (int) $this->db->affected_rows();

    $this->db->query("UPDATE tb_kartu_stok k JOIN (
      SELECT id, stok_seharusnya FROM (
        SELECT id, stok, LAG(sisa) OVER (PARTITION BY id_produk,id_toko ORDER BY tanggal,id) stok_seharusnya FROM tb_kartu_stok
      ) x WHERE stok_seharusnya IS NOT NULL AND COALESCE(stok,0) <> COALESCE(stok_seharusnya,0)
    ) fix ON fix.id=k.id SET k.stok=fix.stok_seharusnya");
    $stok = (int) $this->db->affected_rows();
    $hasil = $this->ringkasan_perbaikan_stok();
    $this->jawaban_stok(['success' => true, 'stopped' => false, 'selesai' => $hasil['total_masalah'] === 0,
      'data' => $hasil, 'diperbaiki' => ['stok' => $stok, 'sisa' => $sisa]]);
  }

  public function berhenti_perbaikan_stok()
  {
    if (strtoupper($this->input->method()) !== 'POST') return $this->jawaban_stok(['success' => false, 'message' => 'Metode tidak diizinkan.'], 405);
    $this->session->set_userdata('perbaikan_stok_berhenti', true);
    $this->jawaban_stok(['success' => true]);
  }

  private function ringkasan_perbaikan_stok()
  {
    $stok = $this->db->query("SELECT COUNT(*) total FROM (
      SELECT stok,LAG(sisa) OVER (PARTITION BY id_produk,id_toko ORDER BY tanggal,id) stok_seharusnya FROM tb_kartu_stok
    ) x WHERE stok_seharusnya IS NOT NULL AND COALESCE(stok,0) <> COALESCE(stok_seharusnya,0)")->row();
    $sisa = $this->db->query("SELECT COUNT(*) total FROM tb_kartu_stok
      WHERE COALESCE(no_doc,'') <> 'import stok' AND COALESCE(no_doc,'') NOT LIKE 'AD-%'
      AND COALESCE(keterangan,'') NOT LIKE '%BAP%'
      AND COALESCE(sisa,0) <> COALESCE(stok,0)+COALESCE(masuk,0)-COALESCE(keluar,0)")->row();
    $a = (int) $stok->total; $b = (int) $sisa->total;
    return ['total_stok_tidak_sinkron' => $a, 'total_sisa_salah' => $b, 'total_masalah' => $a + $b];
  }

  private function jawaban_stok($data, $status = 200)
  {
    return $this->output->set_status_header($status)->set_content_type('application/json')->set_output(json_encode($data));
  }

  // Kartu Stok
  public function kartu_stok()
  {
    $data['title'] = 'Kartu Stok';
    $data['toko'] = $this->db->query("SELECT * from tb_toko where status = 1")->result();
    $data['artikel'] = $this->db->query("SELECT * from tb_produk where status = 1")->result();
    $this->template->load('template/template', 'adm/stok/kartu_stok', $data);
  }

  // Get products by store - used for dynamic product loading
  public function get_produk_by_toko()
  {
    $id_toko = $this->input->get('id_toko');

    if (!$id_toko) {
      echo json_encode([]);
      return;
    }

    // Query to get distinct products from tb_stok for the selected store
    $query = "SELECT DISTINCT tp.id, tp.kode, tp.nama_produk 
              FROM tb_stok ts
              JOIN tb_produk tp ON ts.id_produk = tp.id
              WHERE ts.id_toko = ? 
              AND tp.status = 1
              ORDER BY tp.kode ASC";

    $result = $this->db->query($query, array($id_toko))->result();

    header('Content-Type: application/json');
    echo json_encode($result);
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
    WHERE ta.status = ?", [4])->result();
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
      // $this->db->order_by('tas.status', 'asc');
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

    // Auto-update status jika memenuhi kondisi
    if ($data['row']) {
      $status = $data['row']->status;
      $created_at = $data['row']->created_at;

      // Cek jika status selain 1 atau 2, dan created_at lebih dari 2 hari
      if ($status != 1 && $status != 2) {
        // Set timezone ke Asia/Jakarta untuk waktu lokal
        $timezone = new DateTimeZone('Asia/Jakarta');
        $created_date = new DateTime($created_at, $timezone);
        $current_date = new DateTime('now', $timezone);
        $interval = $current_date->diff($created_date);
        $days_diff = $interval->days;

        // Jika 2 hari atau lebih, update status menjadi 5
        if ($days_diff >= 2) {
          $this->db->where('id', $id);
          $this->db->update('tb_adjust_stok', array('status' => 5));

          // Refresh data setelah update
          $data['row'] = $this->db->query("SELECT tas.*, tt.nama_toko, ts.tgl_so as periode, ts.id_toko from tb_adjust_stok tas
          JOIN tb_so ts on tas.id_so = ts.id
          JOIN tb_toko tt on ts.id_toko = tt.id
          WHERE tas.id = ?", array($id))->row();
        }
      }
    }

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
    // Set time limit for processing large files
    set_time_limit(300); // 5 minutes
    ini_set('memory_limit', '512M'); // Increase memory limit

    if (!isset($_FILES['excel_file']) || $_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
      echo json_encode(['error' => 'No file uploaded or upload error occurred']);
      return;
    }

    if ($_FILES['excel_file']['name']) {
      $config['upload_path'] = './assets/excel/';
      $config['allowed_types'] = 'xlsx|xls';
      $config['max_size'] = 51200; // Increase to 50MB for large files
      $config['file_name'] = 'import_' . time() . '_' . $_FILES['excel_file']['name'];

      $this->upload->initialize($config);

      if (!$this->upload->do_upload('excel_file')) {
        $error = array('error' => $this->upload->display_errors());
        echo json_encode($error);
      } else {
        $data = $this->upload->data();
        $file_path = './assets/excel/' . $data['file_name'];

        try {
          $spreadsheet = IOFactory::load($file_path);
          $sheet = $spreadsheet->getActiveSheet();
          $excelData = '';
          $rowNum = 1;
          $startRow = 2;
          $highestRow = $sheet->getHighestRow();
          $totalData = 0;
          $totalTerverifikasi = 0;
          $totalTidakDitemukan = 0;
          $kodeArray = [];

          // Check if file is too large (more than 10,000 rows)
          if (($highestRow - $startRow + 1) > 10000) {
            unlink($file_path);
            echo json_encode(['error' => 'File terlalu besar. Maksimal 10,000 baris data yang dapat diproses.']);
            return;
          }

          // Collect all codes first for batch verification - using smaller chunks
          $kodeArray = [];
          for ($row = $startRow; $row <= $highestRow; $row++) {
            $kode = trim($sheet->getCell('B' . $row)->getValue());
            if (!empty($kode)) {
              $kodeArray[] = $kode;
            }
          }

          // Check existing products in smaller batches to avoid regex overflow
          $existingKodeArray = [];
          if (!empty($kodeArray)) {
            $batchSize = 50; // Smaller batch size to prevent regex overflow
            $kodeChunks = array_chunk($kodeArray, $batchSize);

            foreach ($kodeChunks as $chunk) {
              // Use direct SQL to avoid CodeIgniter regex issues with large IN clauses
              if (count($chunk) > 25) {
                // For very large chunks, use FIND_IN_SET or multiple OR conditions
                $kodeList = "'" . implode("','", array_map([$this->db, 'escape_str'], $chunk)) . "'";
                $query = "SELECT kode FROM tb_produk WHERE kode IN ($kodeList)";
                $result = $this->db->query($query);
                $batchResults = $result->result_array();
              } else {
                // For smaller chunks, use normal where_in
                $this->db->where_in('kode', $chunk);
                $batchResults = $this->db->get('tb_produk')->result_array();
              }

              $batchKodes = array_column($batchResults, 'kode');
              $existingKodeArray = array_merge($existingKodeArray, $batchKodes);
            }
          }          // Process each row
          for ($row = $startRow; $row <= $highestRow; $row++) {
            $kode = trim($sheet->getCell('B' . $row)->getValue());
            $nama_artikel = trim($sheet->getCell('C' . $row)->getValue());
            $stok = trim($sheet->getCell('E' . $row)->getValue());

            // Skip empty rows
            if (empty($kode) && empty($nama_artikel) && empty($stok)) {
              continue;
            }

            $totalData++;

            $excelData .= '<tr>';
            $excelData .= '<td>' . ($row - $startRow + 1) . '</td>';

            if (in_array($kode, $existingKodeArray)) {
              $status = "<small class='text-success'><i class='fas fa-check'></i> Terverifikasi</small>";
              $totalTerverifikasi++;
            } else {
              $status = "<small class='text-danger'><i class='fas fa-times'></i> Kode tidak ditemukan</small>";
              $totalTidakDitemukan++;
            }

            $excelData .= '<td>' . htmlspecialchars($kode) . '</td>';
            $excelData .= '<td>' . htmlspecialchars($nama_artikel) . '</td>';
            $excelData .= '<td>' . htmlspecialchars($stok) . '</td>';
            $excelData .= '<td>' . $status . '</td>';
            $excelData .= '</tr>';
          }

          // Clean up uploaded file
          unlink($file_path);

          $response = [
            'excelData' => $excelData,
            'totalData' => $totalData,
            'totalTerverifikasi' => $totalTerverifikasi,
            'totalTidakDitemukan' => $totalTidakDitemukan,
            'fileInfo' => [
              'fileName' => $_FILES['excel_file']['name'],
              'fileSize' => round($_FILES['excel_file']['size'] / 1024, 2) . ' KB',
              'uploadTime' => date('Y-m-d H:i:s'),
              'startRow' => $startRow,
              'endRow' => $highestRow
            ],
            'validation' => [
              'isValid' => $totalTidakDitemukan == 0,
              'accuracy' => $totalData > 0 ? round(($totalTerverifikasi / $totalData) * 100, 2) : 0,
              'recommendation' => $totalTidakDitemukan > 0 ?
                'Periksa kembali kode artikel yang tidak ditemukan sebelum menyimpan data.' :
                'Data siap untuk disimpan ke database.'
            ]
          ];

          echo json_encode($response);
        } catch (Exception $e) {
          // Clean up uploaded file on error
          if (file_exists($file_path)) {
            unlink($file_path);
          }

          echo json_encode(['error' => 'Error processing Excel file: ' . $e->getMessage()]);
        }
      }
    } else {
      echo json_encode(['error' => 'No file uploaded']);
    }
  }
  public function save_import()
  {
    // Set time limit and memory for processing large datasets
    set_time_limit(600); // 10 minutes
    ini_set('memory_limit', '1024M'); // 1GB memory limit

    $pengguna = $this->session->userdata('nama_user');

    // Start database transaction
    $this->db->trans_start();

    try {
      // Insert history record
      $this->db->insert('tb_produk_histori', array(
        'pengguna' => $pengguna,
        'updated_at' => date('Y-m-d H:i:s')
      ));

      $postData = json_decode(file_get_contents('php://input'), true);

      if (!empty($postData)) {
        $notFoundCodes = [];
        $updateData = [];
        $successCount = 0;
        $batchSize = 50; // Reduced batch size to prevent regex overflow

        // Process data in batches to handle large datasets
        $dataChunks = array_chunk($postData, $batchSize);

        foreach ($dataChunks as $chunkIndex => $chunk) {
          $kodesToCheck = array_column($chunk, 'kode');

          // Use smaller sub-batches for database queries to avoid regex overflow
          $subBatchSize = 25; // Even smaller for WHERE IN queries
          $kodeSubChunks = array_chunk($kodesToCheck, $subBatchSize);
          $existingKodes = [];

          foreach ($kodeSubChunks as $subChunk) {
            // Use direct SQL for larger chunks to avoid regex overflow
            if (count($subChunk) > 15) {
              $kodeList = "'" . implode("','", array_map([$this->db, 'escape_str'], $subChunk)) . "'";
              $query = "SELECT kode FROM tb_produk WHERE kode IN ($kodeList)";
              $result = $this->db->query($query);
              $existingProducts = $result->result_array();
            } else {
              $this->db->where_in('kode', $subChunk);
              $existingProducts = $this->db->get('tb_produk')->result_array();
            }

            $subBatchKodes = array_column($existingProducts, 'kode');
            $existingKodes = array_merge($existingKodes, $subBatchKodes);
          }

          $batchUpdateData = [];

          foreach ($chunk as $data) {
            $kode = trim($data['kode']);
            $stok = is_numeric($data['stok']) ? floatval($data['stok']) : 0;

            if (in_array($kode, $existingKodes)) {
              $batchUpdateData[] = [
                'kode' => $kode,
                'stok' => $stok,
                'updated_at' => date('Y-m-d H:i:s')
              ];
              $successCount++;
            } else {
              $notFoundCodes[] = $kode;
            }
          }

          // Batch update for this chunk
          if (!empty($batchUpdateData)) {
            $this->db->update_batch('tb_produk', $batchUpdateData, 'kode');
          }
        }

        // Complete transaction
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
          $response = [
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat menyimpan data ke database.'
          ];
        } else {
          $message = "Berhasil menyimpan {$successCount} data.";
          if (!empty($notFoundCodes)) {
            $notFoundCount = count($notFoundCodes);
            $message .= " {$notFoundCount} kode artikel tidak ditemukan.";
          }

          $response = [
            'status' => 'success',
            'message' => $message,
            'details' => [
              'total_processed' => count($postData),
              'success_count' => $successCount,
              'not_found_count' => count($notFoundCodes)
            ]
          ];
        }

        echo json_encode($response);
      } else {
        $this->db->trans_rollback();
        $response = [
          'status' => 'error',
          'message' => 'Tidak ada data yang diterima.'
        ];
        echo json_encode($response);
      }
    } catch (Exception $e) {
      $this->db->trans_rollback();
      $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
      ];
      echo json_encode($response);
    }
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

  // Print Customer Stock Report
  public function print_customer($id_cust, $tahun, $bulan)
  {
    $id_cust = intval($id_cust);
    $tahun = intval($tahun);
    $bulan = str_pad(intval($bulan), 2, '0', STR_PAD_LEFT);
    
    // Get customer info
    $data['customer'] = $this->db->get_where('tb_customer', ['id' => $id_cust])->row();
    $data['periode'] = date('F Y', strtotime("$tahun-$bulan-01"));
    $data['bulan_filter'] = $bulan;
    $data['tahun_filter'] = $tahun;
    
    // Get store and stock details for this customer from tb_so_detail
    // Using LEFT JOIN dengan kondisi di ON clause agar toko tetap tampil meski SO belum ada
    $query = "SELECT 
        tt.id,
        tt.nama_toko,
        COALESCE(MIN(so.status_kunci), 1) AS status_kunci,
        COALESCE(SUM(sod.qty_awal), 0) AS stok_awal,
        COALESCE(SUM(sod.jual), 0) AS penjualan,
        COALESCE(SUM(sod.stok_akhir), 0) AS stok_akhir
      FROM tb_toko tt
      LEFT JOIN tb_so so ON tt.id = so.id_toko AND YEAR(so.created_at) = ? AND MONTH(so.created_at) = ?
      LEFT JOIN tb_so_detail sod ON so.id = sod.id_so
      WHERE tt.id_customer = ? AND tt.status != 0
      GROUP BY tt.id, tt.nama_toko
      ORDER BY tt.nama_toko ASC";
    
    $data['list_data'] = $this->db->query($query, [$tahun, $bulan, $id_cust])->result();
    
    // Calculate totals
    $data['total_stok_awal'] = 0;
    $data['total_penjualan'] = 0;
    $data['total_stok_akhir'] = 0;
    
    foreach ($data['list_data'] as $item) {
      $data['total_stok_awal'] += $item->stok_awal;
      $data['total_penjualan'] += $item->penjualan;
      $data['total_stok_akhir'] += $item->stok_akhir;
    }

    $this->load->view('adm/stok/print_customer', $data);
  }

  // Export PDF Customer Stock Report
  public function export_pdf_customer($id_cust, $tahun, $bulan)
  {
    $id_cust = intval($id_cust);
    $tahun = intval($tahun);
    $bulan = str_pad(intval($bulan), 2, '0', STR_PAD_LEFT);
    
    // Get customer info
    $customer = $this->db->get_where('tb_customer', ['id' => $id_cust])->row();
    $periode = date('F Y', strtotime("$tahun-$bulan-01"));
    
    // Get store and stock details for this customer from tb_so_detail
    // Using LEFT JOIN dengan kondisi di ON clause agar toko tetap tampil meski SO belum ada
    $query = "SELECT 
        tt.id,
        tt.nama_toko,
        COALESCE(MIN(so.status_kunci), 1) AS status_kunci,
        COALESCE(SUM(sod.qty_awal), 0) AS stok_awal,
        COALESCE(SUM(sod.jual), 0) AS penjualan,
        COALESCE(SUM(sod.stok_akhir), 0) AS stok_akhir
      FROM tb_toko tt
      LEFT JOIN tb_so so ON tt.id = so.id_toko AND YEAR(so.created_at) = ? AND MONTH(so.created_at) = ?
      LEFT JOIN tb_so_detail sod ON so.id = sod.id_so
      WHERE tt.id_customer = ? AND tt.status != 0
      GROUP BY tt.id, tt.nama_toko
      ORDER BY tt.nama_toko ASC";
    
    $list_data = $this->db->query($query, [$tahun, $bulan, $id_cust])->result();
    
    // Calculate totals
    $total_stok_awal = 0;
    $total_penjualan = 0;
    $total_stok_akhir = 0;
    
    foreach ($list_data as $item) {
      $total_stok_awal += $item->stok_awal;
      $total_penjualan += $item->penjualan;
      $total_stok_akhir += $item->stok_akhir;
    }

    $html = '<h2 style="text-align:center; margin-bottom: 5px;">' . strtoupper($customer->nama_cust) . '</h2>';
    $html .= '<p style="text-align:center; margin: 5px 0; color: #666;">Periode: ' . $periode . '</p>';
    $html .= '<p style="text-align:center; margin-bottom: 20px; font-size: 11px; color: #999;">Laporan Stok Pelanggan - ' . date('d M Y H:i') . '</p>';
    
    $html .= '<table cellpadding="6" cellspacing="0" border="1" style="width: 100%; font-size: 11px; border-collapse: collapse;">';
    $html .= '<thead>';
    $html .= '<tr style="background-color: #f0f0f0; font-weight: bold; text-align: center;">';
    $html .= '<td style="width: 5%">No</td>';
    $html .= '<td>Nama Toko</td>';
    $html .= '<td style="width: 12%; text-align: right;">Stok Awal</td>';
    $html .= '<td style="width: 12%; text-align: right;">Penjualan</td>';
    $html .= '<td style="width: 12%; text-align: right;">Stok Akhir</td>';
    $html .= '<td style="width: 12%; text-align: right;">Rasio</td>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    
    $no = 0;
    foreach ($list_data as $item) {
      $no++;
      $rasio = (!empty($item->penjualan) && $item->penjualan != 0) 
        ? round($item->stok_akhir / $item->penjualan, 2) 
        : round($item->stok_akhir / 1, 2);
      
      $html .= '<tr>';
      $html .= '<td style="text-align: center;">' . $no . '</td>';
      $html .= '<td>' . $item->nama_toko . '</td>';
      $html .= '<td style="text-align: right;">' . number_format($item->stok_awal) . '</td>';
      $html .= '<td style="text-align: right;">' . number_format($item->penjualan) . '</td>';
      $html .= '<td style="text-align: right;">' . number_format($item->stok_akhir) . '</td>';
      $html .= '<td style="text-align: right;">' . $rasio . 'x</td>';
      $html .= '</tr>';
    }
    
    $html .= '<tr style="background-color: #f0f0f0; font-weight: bold;">';
    $html .= '<td colspan="2" style="text-align: right;">TOTAL</td>';
    $html .= '<td style="text-align: right;">' . number_format($total_stok_awal) . '</td>';
    $html .= '<td style="text-align: right;">' . number_format($total_penjualan) . '</td>';
    $html .= '<td style="text-align: right;">' . number_format($total_stok_akhir) . '</td>';
    $total_rasio = (!empty($total_penjualan) && $total_penjualan != 0) 
      ? round($total_stok_akhir / $total_penjualan, 2) 
      : round($total_stok_akhir / 1, 2);
    $html .= '<td style="text-align: right;">' . $total_rasio . 'x</td>';
    $html .= '</tr>';
    
    $html .= '</tbody>';
    $html .= '</table>';

    $this->load->library('Pdfgenerator');
    $this->pdfgenerator->generate($html, 'Laporan_Stok_' . $customer->nama_cust . '_' . $periode, true, 'A4', 'landscape');
  }
}
