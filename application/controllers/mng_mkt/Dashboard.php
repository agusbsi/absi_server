<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "9") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }

    $this->load->model('M_spg');
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $awal_bulan = date('Y-m-01 00:00:00');
    $awal_bulan_depan = date('Y-m-01 00:00:00', strtotime('+1 month'));

    // Satu round-trip untuk seluruh angka ringkasan. Rentang tanggal menjaga index tetap terpakai.
    $summary = $this->db->query("SELECT
      (SELECT COUNT(id) FROM tb_toko WHERE status != 0) AS total_toko,
      (SELECT COUNT(id) FROM tb_user WHERE status = 1) AS total_user,
      (SELECT COALESCE(SUM(tpd.qty_acc), 0)
        FROM tb_permintaan tp
        JOIN tb_permintaan_detail tpd ON tpd.id_permintaan = tp.id
        WHERE tp.created_at >= ? AND tp.created_at < ?
          AND tp.status >= 2 AND tp.status != 5 AND tpd.status = 1) AS total_minta,
      (SELECT COALESCE(SUM(tpd.qty), 0)
        FROM tb_pengiriman tp
        JOIN tb_pengiriman_detail tpd ON tpd.id_pengiriman = tp.id
        WHERE tp.created_at >= ? AND tp.created_at < ?) AS total_kirim,
      (SELECT COALESCE(SUM(tpd.qty), 0)
        FROM tb_penjualan tp
        JOIN tb_penjualan_detail tpd ON tpd.id_penjualan = tp.id
        WHERE tp.tanggal_penjualan >= ? AND tp.tanggal_penjualan < ?) AS total_jual,
      (SELECT COALESCE(SUM(tpd.qty), 0)
        FROM tb_retur tr
        JOIN tb_retur_detail tpd ON tpd.id_retur = tr.id
        WHERE tr.created_at >= ? AND tr.created_at < ?
          AND tr.status BETWEEN 2 AND 4) AS total_retur,
      (SELECT COALESCE(SUM(qty), 0) FROM tb_stok WHERE status = 1) AS total_stok", array(
        $awal_bulan, $awal_bulan_depan,
        $awal_bulan, $awal_bulan_depan,
        $awal_bulan, $awal_bulan_depan,
        $awal_bulan, $awal_bulan_depan
      ))->row();

    $data['t_toko'] = (object) array('total' => $summary->total_toko);
    $data['t_user'] = (object) array('total' => $summary->total_user);
    $data['t_minta'] = (object) array('total' => $summary->total_minta);
    $data['t_kirim'] = (object) array('total' => $summary->total_kirim);
    $data['t_jual'] = (object) array('total' => $summary->total_jual);
    $data['t_retur'] = (object) array('total' => $summary->total_retur);
    $data['t_stok'] = (object) array('total' => $summary->total_stok);
    $this->template->load('template/template', 'manager_mkt/dashboard', $data);
  }

  public function ranking()
  {
    $awal_bulan_lalu = date('Y-m-01 00:00:00', strtotime('first day of last month'));
    $awal_bulan_ini = date('Y-m-01 00:00:00');

    $top_toko = $this->db->query("SELECT tt.nama_toko, tu.nama_user AS spg, SUM(tpd.qty) AS total
      FROM tb_penjualan tp
      JOIN tb_penjualan_detail tpd ON tpd.id_penjualan = tp.id
      JOIN tb_toko tt ON tt.id = tp.id_toko
      JOIN tb_user tu ON tu.id = tt.id_spg
      WHERE tp.tanggal_penjualan >= ? AND tp.tanggal_penjualan < ?
      GROUP BY tp.id_toko, tt.nama_toko, tu.nama_user
      ORDER BY total DESC
      LIMIT 5", array($awal_bulan_lalu, $awal_bulan_ini))->result();

    $top_artikel = $this->db->query("SELECT pr.kode, pr.nama_produk, SUM(tpd.qty) AS total
      FROM tb_penjualan tp
      JOIN tb_penjualan_detail tpd ON tpd.id_penjualan = tp.id
      JOIN tb_produk pr ON pr.id = tpd.id_produk
      WHERE tp.tanggal_penjualan >= ? AND tp.tanggal_penjualan < ?
      GROUP BY tpd.id_produk, pr.kode, pr.nama_produk
      ORDER BY total DESC
      LIMIT 5", array($awal_bulan_lalu, $awal_bulan_ini))->result();

    $top_stok = $this->db->query("SELECT tt.nama_toko, tu.nama_user AS spg, SUM(ts.qty) AS total
      FROM tb_stok ts
      JOIN tb_toko tt ON tt.id = ts.id_toko
      JOIN tb_user tu ON tu.id = tt.id_spg
      WHERE ts.status = 1
      GROUP BY ts.id_toko, tt.nama_toko, tu.nama_user
      ORDER BY total DESC
      LIMIT 5")->result();

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array(
        'top_toko' => $top_toko,
        'top_artikel' => $top_artikel,
        'top_stok' => $top_stok
      )));
  }
  public function transaksi()
  {
    $bln = (int) date('m');
    $awal_tahun = date('Y-01-01 00:00:00');
    $awal_bulan_depan = date('Y-m-01 00:00:00', strtotime('+1 month'));
    $kirim = "
        SELECT MONTH(tp.created_at) as month, SUM(tpd.qty) as total
        FROM tb_pengiriman_detail tpd
        join tb_pengiriman tp on tpd.id_pengiriman = tp.id
        WHERE tp.created_at >= ? AND tp.created_at < ?
        GROUP BY MONTH(tp.created_at)
    ";
    $retur = "
        SELECT MONTH(tp.created_at) as month, SUM(tpd.qty) as total
        FROM tb_retur_detail tpd
        join tb_retur tp on tpd.id_retur = tp.id
        WHERE tp.created_at >= ? AND tp.created_at < ? AND tp.status BETWEEN 2 AND 4
        GROUP BY MONTH(tp.created_at)
    ";
    $jual = "
        SELECT MONTH(tp.tanggal_penjualan) as month, SUM(tpd.qty) as total
        FROM tb_penjualan_detail tpd
        join tb_penjualan tp on tpd.id_penjualan = tp.id
        WHERE tp.tanggal_penjualan >= ? AND tp.tanggal_penjualan < ?
        GROUP BY MONTH(tp.tanggal_penjualan)
    ";
    $hasil_kirim = $this->db->query($kirim, array($awal_tahun, $awal_bulan_depan))->result_array();
    $hasil_retur = $this->db->query($retur, array($awal_tahun, $awal_bulan_depan))->result_array();
    $hasil_jual = $this->db->query($jual, array($awal_tahun, $awal_bulan_depan))->result_array();
    $data_kirim = array_fill(0, $bln, 0);
    $data_retur = array_fill(0, $bln, 0);
    $data_jual = array_fill(0, $bln, 0);

    // Fill the arrays with the query results
    foreach ($hasil_kirim as $row) {
      $data_kirim[$row['month'] - 1] = (int) $row['total'];
    }
    foreach ($hasil_retur as $row) {
      $data_retur[$row['month'] - 1] = (int) $row['total'];
    }
    foreach ($hasil_jual as $row) {
      $data_jual[$row['month'] - 1] = (int) $row['total'];
    }


    $data = array(
      'kirim' => $data_kirim,
      'retur' => $data_retur,
      'jual' => $data_jual,
    );

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
}
