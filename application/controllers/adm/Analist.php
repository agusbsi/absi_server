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
    $id_toko   = $this->input->get('id_toko');
    $tgl_awal  = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');

    // Format tanggal untuk query
    $tgl_awal_formatted = date('Y-m-d 00:00:00', strtotime($tgl_awal));
    $tgl_akhir_formatted = date('Y-m-d 23:59:59', strtotime($tgl_akhir));

    $awal  = new DateTime($tgl_awal);
    $akhir = new DateTime($tgl_akhir);
    $diff  = $awal->diff($akhir);
    $jumlah_bulan = $diff->y * 12 + $diff->m + 1;

    $summary = $this->db->query("SELECT * FROM tb_toko WHERE id = ?", [$id_toko])->row();

    // cari SO bulan akhir
    $periode_akhir = date('Y-m', strtotime($tgl_akhir));
    $so_now = $this->db->query(
      "SELECT id, created_at FROM tb_so WHERE id_toko = ? AND DATE_FORMAT(created_at,'%Y-%m') = ? ORDER BY id DESC LIMIT 1",
      [$id_toko, $periode_akhir]
    )->row();

    if (!$so_now) {
      echo json_encode([
        'toko' => $summary->nama_toko,
        'awal' => date('d-M-Y', strtotime($tgl_awal)),
        'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
        'tabel_data' => [],
        'bln' => $jumlah_bulan,
        'error' => 'Data SO tidak ditemukan'
      ]);
      return;
    }

    $id_so = $so_now->id;

    // cari data so bulan kemarin
    $tgl_so_sekarang = $so_now->created_at;
    $bulan_kemarin = date('Y-m', strtotime('first day of last month', strtotime($tgl_so_sekarang)));

    // Query untuk mengambil data
    $kemarin = $this->db->query("SELECT id,tgl_so FROM tb_so WHERE DATE_FORMAT(created_at, '%Y-%m') = ? AND id_toko = ?", [$bulan_kemarin, $id_toko])->row();

    // Cek apakah hasil query ada
    if ($kemarin) {
      $so_kemarin = $kemarin->id;
      $tgl_kemarin = $kemarin->tgl_so;
      $bulan_kemarin_int = (int) date('m', strtotime($tgl_kemarin));
    } else {
      // Jika tidak ada data, lakukan sesuatu (misalnya beri nilai default atau tampilkan pesan)
      $so_kemarin = null;
      $tgl_kemarin = null;
      $bulan_kemarin_int = null;
    }

    // data so bulan ini
    $tgl_so = $this->db->query("SELECT tgl_so FROM tb_so WHERE id = ?", array($id_so))->row()->tgl_so;
    $tgl_so_sebelumnya = $this->db->query("SELECT DATE_SUB(tgl_so, INTERVAL 1 MONTH) AS tgl_sebelumnya FROM tb_so WHERE id = ?", array($id_so))->row()->tgl_sebelumnya;

    //cek status adjust
    $cek_toko = $this->db->query("SELECT * FROM tb_toko where id = ?", array($id_toko))->row();
    $cek_adjustmen = null;
    $awal_tahun = "2024-12-01";
    if ($cek_toko->status_adjust == 1) {
      $periode = date('Y-m', strtotime('-1 month', strtotime($so_now->created_at)));
      $cek_adjustmen = $this->db->query("SELECT tas.id as id_adjust,ts.id_toko,ts.created_at as periode FROM tb_adjust_stok tas
       JOIN tb_so ts ON tas.id_so = ts.id
       where ts.id_toko = ? AND DATE_FORMAT(ts.created_at, '%Y-%m') = ? AND tas.status = 1", array($id_toko, $periode))->row();
      if ($cek_adjustmen) {
        $select_adjust = "ts.qty_awal,COALESCE(adj.hasil_so,0) as stok_adjust,";
        $where_adjust = [
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so_sebelumnya,
          $tgl_so_sebelumnya,
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so_sebelumnya,
          $tgl_so_sebelumnya,
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so_sebelumnya,
          $tgl_so_sebelumnya,
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so_sebelumnya,
          $tgl_so_sebelumnya,
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so_sebelumnya,
          $tgl_so_sebelumnya,
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so_sebelumnya,
          $tgl_so_sebelumnya,
          $cek_adjustmen->id_adjust,
          $id_so,
          $so_kemarin,
          $id_toko
        ];
        $query_adjust = "
              LEFT JOIN (SELECT  id_produk, jml_terima FROM vw_penerimaan WHERE id_toko = ?
                  AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                  AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
              GROUP BY 
                  id_produk ) vt ON vt.id_produk = ts.id_produk
          LEFT JOIN (SELECT 
          tpd.id_produk, 
          SUM(tpd.qty_diterima) AS jml_terima 
            FROM tb_pengiriman_detail tpd
              JOIN tb_pengiriman tp 
                ON tpd.id_pengiriman = tp.id
            WHERE 
          tp.id_toko = ?
          AND tp.updated_at BETWEEN '2024-12-01' AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
            GROUP BY tpd.id_produk) vt_kemarin ON vt_kemarin.id_produk = ts.id_produk
          LEFT JOIN (SELECT  id_produk, jml_mutasi FROM vw_mutasi_masuk WHERE id_toko_tujuan = ?
                  AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                  AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
              GROUP BY 
                  id_produk ) vm ON vm.id_produk = ts.id_produk
          LEFT JOIN (SELECT 
              tpd.id_produk, 
              SUM(tpd.qty_terima) AS jml_mutasi 
            FROM tb_mutasi_detail tpd
            JOIN tb_mutasi tp 
                ON tpd.id_mutasi = tp.id
            WHERE 
                tp.id_toko_tujuan = ? AND tp.status = 2
                AND tp.updated_at BETWEEN '2024-12-01' AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
            GROUP BY tpd.id_produk) vm_kemarin ON vm_kemarin.id_produk = ts.id_produk
          LEFT JOIN (SELECT  id_produk, jml_jual FROM vw_penjualan WHERE id_toko = ?
                  AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                  AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
              GROUP BY 
                  id_produk ) vp ON vp.id_produk = ts.id_produk
          LEFT JOIN (SELECT 
              tpd.id_produk, 
              SUM(tpd.qty) AS jml_jual 
            FROM tb_penjualan_detail tpd
            JOIN tb_penjualan tp 
                ON tpd.id_penjualan = tp.id
            WHERE 
                tp.id_toko = ? 
                AND tp.tanggal_penjualan BETWEEN '2024-12-01' AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
            GROUP BY tpd.id_produk) vp_kemarin ON vp_kemarin.id_produk = ts.id_produk
          LEFT JOIN (SELECT  id_produk, jml_jual FROM vw_penjualan_buat WHERE id_toko = ?
                  AND tahun = YEAR(DATE_SUB(?, INTERVAL 0 MONTH))
                  AND bulan = MONTH(DATE_SUB(?, INTERVAL 0 MONTH))
              GROUP BY 
                  id_produk ) vpb ON vpb.id_produk = ts.id_produk
          LEFT JOIN (SELECT  id_produk, jml_retur FROM vw_retur WHERE id_toko = ?
                  AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                  AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
              GROUP BY 
                  id_produk ) vr ON vr.id_produk = ts.id_produk
          LEFT JOIN (SELECT 
              tpd.id_produk, 
              SUM(tpd.qty_terima) AS jml_retur 
            FROM tb_retur_detail tpd
            JOIN tb_retur tp 
                ON tpd.id_retur = tp.id
            WHERE 
                tp.id_toko = ? AND tp.status >= 2 AND tp.status <= 4
                AND tp.updated_at BETWEEN '2024-12-01' AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
            GROUP BY tpd.id_produk) vr_kemarin ON vr_kemarin.id_produk = ts.id_produk
          LEFT JOIN (SELECT  id_produk, jml_mutasi FROM vw_mutasi_keluar WHERE id_toko_asal = ?
                  AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                  AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
              GROUP BY 
                  id_produk ) vk ON vk.id_produk = ts.id_produk
          LEFT JOIN (SELECT 
                tpd.id_produk, 
                SUM(tpd.qty_terima) AS jml_mutasi 
            FROM tb_mutasi_detail tpd
            JOIN tb_mutasi tp 
                ON tpd.id_mutasi = tp.id
            WHERE 
                tp.id_toko_asal = ? AND tp.status = 2
                AND tp.updated_at BETWEEN '2024-12-01' AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
            GROUP BY tpd.id_produk) vk_kemarin ON vk_kemarin.id_produk = ts.id_produk
          LEFT JOIN (SELECT sum(tpdd.qty) as qty, tpdd.id_produk FROM tb_penjualan_detail tpdd
            JOIN tb_penjualan tpp ON tpdd.id_penjualan = tpp.id
            WHERE tpp.id_toko = ?
            AND tpp.tanggal_penjualan BETWEEN DATE_FORMAT(?, '%Y-%m-01 00:00:00') AND ?
            GROUP BY tpdd.id_produk ) nj ON nj.id_produk = ts.id_produk
          LEFT JOIN (SELECT sum(tpdd.qty) as qty, tpdd.id_produk FROM tb_penjualan_detail tpdd
            JOIN tb_penjualan tpp ON tpdd.id_penjualan = tpp.id
            WHERE tpp.id_toko = ?
            AND tpp.tanggal_penjualan BETWEEN DATE_FORMAT(?, '%Y-%m-01 00:00:00') AND ?
            GROUP BY tpdd.id_produk ) nj_kemarin ON nj_kemarin.id_produk = ts.id_produk
        LEFT JOIN (SELECT  id_produk, hasil_so FROM tb_adjust_detail WHERE id_adjust = ?
         GROUP BY 
             id_produk ) adj ON adj.id_produk = ts.id_produk";
      } else {
        $cari_awal_tahun = $this->db->query("SELECT created_at from tb_adjust_stok where id = ?", [$cek_toko->id_adjust])->row()->created_at;
        $awal_tahun = date('Y-m-01', strtotime($cari_awal_tahun));
        $select_adjust = "ts.qty_awal,COALESCE(adj.hasil_so,0) as stok_adjust,";
        $query_adjust = "
          LEFT JOIN (SELECT  id_produk, jml_terima FROM vw_penerimaan WHERE id_toko = ?
              AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
              AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
          GROUP BY 
              id_produk ) vt ON vt.id_produk = ts.id_produk
          LEFT JOIN (SELECT 
          tpd.id_produk, 
          SUM(tpd.qty_diterima) AS jml_terima 
            FROM tb_pengiriman_detail tpd
              JOIN tb_pengiriman tp 
                ON tpd.id_pengiriman = tp.id
            WHERE 
          tp.id_toko = ?
          AND tp.updated_at BETWEEN DATE('$awal_tahun') AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
            GROUP BY tpd.id_produk) vt_kemarin ON vt_kemarin.id_produk = ts.id_produk
          LEFT JOIN (SELECT  id_produk, jml_mutasi FROM vw_mutasi_masuk WHERE id_toko_tujuan = ?
                  AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                  AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
              GROUP BY 
                  id_produk ) vm ON vm.id_produk = ts.id_produk
          LEFT JOIN (SELECT 
              tpd.id_produk, 
              SUM(tpd.qty_terima) AS jml_mutasi 
            FROM tb_mutasi_detail tpd
            JOIN tb_mutasi tp 
                ON tpd.id_mutasi = tp.id
            WHERE 
                tp.id_toko_tujuan = ? AND tp.status = 2
                AND tp.updated_at BETWEEN DATE('$awal_tahun') AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
            GROUP BY tpd.id_produk) vm_kemarin ON vm_kemarin.id_produk = ts.id_produk
          LEFT JOIN (SELECT  id_produk, jml_jual FROM vw_penjualan WHERE id_toko = ?
                  AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                  AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
              GROUP BY 
                  id_produk ) vp ON vp.id_produk = ts.id_produk
          LEFT JOIN (SELECT 
              tpd.id_produk, 
              SUM(tpd.qty) AS jml_jual 
            FROM tb_penjualan_detail tpd
            JOIN tb_penjualan tp 
                ON tpd.id_penjualan = tp.id
            WHERE 
                tp.id_toko = ? 
                AND tp.tanggal_penjualan BETWEEN DATE('$awal_tahun') AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
            GROUP BY tpd.id_produk) vp_kemarin ON vp_kemarin.id_produk = ts.id_produk
          LEFT JOIN (SELECT  id_produk, jml_jual FROM vw_penjualan_buat WHERE id_toko = ?
                  AND tahun = YEAR(DATE_SUB(?, INTERVAL 0 MONTH))
                  AND bulan = MONTH(DATE_SUB(?, INTERVAL 0 MONTH))
              GROUP BY 
                  id_produk ) vpb ON vpb.id_produk = ts.id_produk
          LEFT JOIN (SELECT  id_produk, jml_retur FROM vw_retur WHERE id_toko = ?
                  AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                  AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
              GROUP BY 
                  id_produk ) vr ON vr.id_produk = ts.id_produk
          LEFT JOIN (SELECT 
              tpd.id_produk, 
              SUM(tpd.qty_terima) AS jml_retur 
            FROM tb_retur_detail tpd
            JOIN tb_retur tp 
                ON tpd.id_retur = tp.id
            WHERE 
                tp.id_toko = ? AND tp.status >= 2 AND tp.status <= 4
                AND tp.updated_at BETWEEN DATE('$awal_tahun') AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
            GROUP BY tpd.id_produk) vr_kemarin ON vr_kemarin.id_produk = ts.id_produk
          LEFT JOIN (SELECT  id_produk, jml_mutasi FROM vw_mutasi_keluar WHERE id_toko_asal = ?
                  AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                  AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
              GROUP BY 
                  id_produk ) vk ON vk.id_produk = ts.id_produk
          LEFT JOIN (SELECT 
                tpd.id_produk, 
                SUM(tpd.qty_terima) AS jml_mutasi 
            FROM tb_mutasi_detail tpd
            JOIN tb_mutasi tp 
                ON tpd.id_mutasi = tp.id
            WHERE 
                tp.id_toko_asal = ? AND tp.status = 2
                AND tp.updated_at BETWEEN DATE('$awal_tahun') AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
            GROUP BY tpd.id_produk) vk_kemarin ON vk_kemarin.id_produk = ts.id_produk
          LEFT JOIN (SELECT sum(tpdd.qty) as qty, tpdd.id_produk FROM tb_penjualan_detail tpdd
            JOIN tb_penjualan tpp ON tpdd.id_penjualan = tpp.id
            WHERE tpp.id_toko = ?
            AND tpp.tanggal_penjualan BETWEEN DATE_FORMAT(?, '%Y-%m-01 00:00:00') AND ?
            GROUP BY tpdd.id_produk ) nj ON nj.id_produk = ts.id_produk
          LEFT JOIN (SELECT sum(tpdd.qty) as qty, tpdd.id_produk FROM tb_penjualan_detail tpdd
            JOIN tb_penjualan tpp ON tpdd.id_penjualan = tpp.id
            WHERE tpp.id_toko = ?
            AND tpp.tanggal_penjualan BETWEEN DATE_FORMAT(?, '%Y-%m-01 00:00:00') AND ?
            GROUP BY tpdd.id_produk ) nj_kemarin ON nj_kemarin.id_produk = ts.id_produk
          LEFT JOIN (SELECT  id_produk, hasil_so FROM tb_adjust_detail WHERE id_adjust = ?
          GROUP BY 
              id_produk ) adj ON adj.id_produk = ts.id_produk";
        $where_adjust = [
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so_sebelumnya,
          $tgl_so_sebelumnya,
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so_sebelumnya,
          $tgl_so_sebelumnya,
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so_sebelumnya,
          $tgl_so_sebelumnya,
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so_sebelumnya,
          $tgl_so_sebelumnya,
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so_sebelumnya,
          $tgl_so_sebelumnya,
          $id_toko,
          $tgl_so,
          $tgl_so,
          $id_toko,
          $tgl_so_sebelumnya,
          $tgl_so_sebelumnya,
          $cek_toko->id_adjust,
          $id_so,
          $so_kemarin,
          $id_toko
        ];
      }
    } else {
      $select_adjust = "ts.qty_awal,";
      $query_adjust = "LEFT JOIN (SELECT  id_produk, jml_terima FROM vw_penerimaan WHERE id_toko = ?
            AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
            AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
        GROUP BY 
            id_produk ) vt ON vt.id_produk = ts.id_produk
        LEFT JOIN (SELECT 
        tpd.id_produk, 
        SUM(tpd.qty_diterima) AS jml_terima 
          FROM tb_pengiriman_detail tpd
            JOIN tb_pengiriman tp 
              ON tpd.id_pengiriman = tp.id
          WHERE 
        tp.id_toko = ?
        AND tp.updated_at BETWEEN '2024-12-01' AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
          GROUP BY tpd.id_produk) vt_kemarin ON vt_kemarin.id_produk = ts.id_produk
        LEFT JOIN (SELECT  id_produk, jml_mutasi FROM vw_mutasi_masuk WHERE id_toko_tujuan = ?
                AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
            GROUP BY 
                id_produk ) vm ON vm.id_produk = ts.id_produk
        LEFT JOIN (SELECT 
            tpd.id_produk, 
            SUM(tpd.qty_terima) AS jml_mutasi 
          FROM tb_mutasi_detail tpd
          JOIN tb_mutasi tp 
              ON tpd.id_mutasi = tp.id
          WHERE 
              tp.id_toko_tujuan = ? AND tp.status = 2
              AND tp.updated_at BETWEEN '2024-12-01' AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
          GROUP BY tpd.id_produk) vm_kemarin ON vm_kemarin.id_produk = ts.id_produk
        LEFT JOIN (SELECT  id_produk, jml_jual FROM vw_penjualan WHERE id_toko = ?
                AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
            GROUP BY 
                id_produk ) vp ON vp.id_produk = ts.id_produk
        LEFT JOIN (SELECT 
            tpd.id_produk, 
            SUM(tpd.qty) AS jml_jual 
          FROM tb_penjualan_detail tpd
          JOIN tb_penjualan tp 
              ON tpd.id_penjualan = tp.id
          WHERE 
              tp.id_toko = ? 
              AND tp.tanggal_penjualan BETWEEN '2024-12-01' AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
          GROUP BY tpd.id_produk) vp_kemarin ON vp_kemarin.id_produk = ts.id_produk
        LEFT JOIN (SELECT  id_produk, jml_jual FROM vw_penjualan_buat WHERE id_toko = ?
                AND tahun = YEAR(DATE_SUB(?, INTERVAL 0 MONTH))
                AND bulan = MONTH(DATE_SUB(?, INTERVAL 0 MONTH))
            GROUP BY 
                id_produk ) vpb ON vpb.id_produk = ts.id_produk
        LEFT JOIN (SELECT  id_produk, jml_retur FROM vw_retur WHERE id_toko = ?
                AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
            GROUP BY 
                id_produk ) vr ON vr.id_produk = ts.id_produk
        LEFT JOIN (SELECT 
            tpd.id_produk, 
            SUM(tpd.qty_terima) AS jml_retur 
          FROM tb_retur_detail tpd
          JOIN tb_retur tp 
              ON tpd.id_retur = tp.id
          WHERE 
              tp.id_toko = ? AND tp.status >= 2 AND tp.status <= 4
              AND tp.updated_at BETWEEN '2024-12-01' AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
          GROUP BY tpd.id_produk) vr_kemarin ON vr_kemarin.id_produk = ts.id_produk
        LEFT JOIN (SELECT  id_produk, jml_mutasi FROM vw_mutasi_keluar WHERE id_toko_asal = ?
                AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
                AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
            GROUP BY 
                id_produk ) vk ON vk.id_produk = ts.id_produk
        LEFT JOIN (SELECT 
              tpd.id_produk, 
              SUM(tpd.qty_terima) AS jml_mutasi 
          FROM tb_mutasi_detail tpd
          JOIN tb_mutasi tp 
              ON tpd.id_mutasi = tp.id
          WHERE 
              tp.id_toko_asal = ? AND tp.status = 2
              AND tp.updated_at BETWEEN '2024-12-01' AND DATE_SUB(?, INTERVAL DAYOFMONTH(?) DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND
          GROUP BY tpd.id_produk) vk_kemarin ON vk_kemarin.id_produk = ts.id_produk
        LEFT JOIN (SELECT sum(tpdd.qty) as qty, tpdd.id_produk FROM tb_penjualan_detail tpdd
          JOIN tb_penjualan tpp ON tpdd.id_penjualan = tpp.id
          WHERE tpp.id_toko = ?
          AND tpp.tanggal_penjualan BETWEEN DATE_FORMAT(?, '%Y-%m-01 00:00:00') AND ?
          GROUP BY tpdd.id_produk ) nj ON nj.id_produk = ts.id_produk
        LEFT JOIN (SELECT sum(tpdd.qty) as qty, tpdd.id_produk FROM tb_penjualan_detail tpdd
          JOIN tb_penjualan tpp ON tpdd.id_penjualan = tpp.id
          WHERE tpp.id_toko = ?
          AND tpp.tanggal_penjualan BETWEEN DATE_FORMAT(?, '%Y-%m-01 00:00:00') AND ?
          GROUP BY tpdd.id_produk ) nj_kemarin ON nj_kemarin.id_produk = ts.id_produk";
      $where_adjust = [
        $id_toko,
        $tgl_so,
        $tgl_so,
        $id_toko,
        $tgl_so_sebelumnya,
        $tgl_so_sebelumnya,
        $id_toko,
        $tgl_so,
        $tgl_so,
        $id_toko,
        $tgl_so_sebelumnya,
        $tgl_so_sebelumnya,
        $id_toko,
        $tgl_so,
        $tgl_so,
        $id_toko,
        $tgl_so_sebelumnya,
        $tgl_so_sebelumnya,
        $id_toko,
        $tgl_so,
        $tgl_so,
        $id_toko,
        $tgl_so,
        $tgl_so,
        $id_toko,
        $tgl_so_sebelumnya,
        $tgl_so_sebelumnya,
        $id_toko,
        $tgl_so,
        $tgl_so,
        $id_toko,
        $tgl_so_sebelumnya,
        $tgl_so_sebelumnya,
        $id_toko,
        $tgl_so,
        $tgl_so,
        $id_toko,
        $tgl_so_sebelumnya,
        $tgl_so_sebelumnya,
        $id_so,
        $so_kemarin,
        $id_toko
      ];
    }

    $query = "SELECT ts.id_produk,tp.kode,tp.nama_produk,tsd.hasil_so,
    $select_adjust
    COALESCE(ts.qty_awal + COALESCE(vt_kemarin.jml_terima, 0) + COALESCE(vm_kemarin.jml_mutasi, 0) - COALESCE(vp_kemarin.jml_jual, 0) - COALESCE(vr_kemarin.jml_retur, 0) - COALESCE(vk_kemarin.jml_mutasi, 0)  ,0) as qty_awal_kemarin,
    COALESCE(tsd_kemarin.hasil_so,0) as hasil_so_kemarin,
    COALESCE(nj.qty, 0) as qty_jual,
    COALESCE(nj_kemarin.qty, 0) as qty_jual_kemarin,
    COALESCE(vt.jml_terima, 0) AS jml_terima,
    COALESCE(vt_kemarin.jml_terima, 0) AS jml_terima_kemarin,
    COALESCE(vm.jml_mutasi, 0) AS mutasi_masuk,
    COALESCE(vm_kemarin.jml_mutasi, 0) AS mutasi_masuk_kemarin,
    COALESCE(vp.jml_jual, 0) AS jml_jual,
    COALESCE(vp_kemarin.jml_jual, 0) AS jml_jual_kemarin,
    COALESCE(vpb.jml_jual, 0) AS jml_jual_buat,
    COALESCE(vr.jml_retur, 0) AS jml_retur,
    COALESCE(vr_kemarin.jml_retur, 0) AS jml_retur_kemarin,
    COALESCE(vk.jml_mutasi, 0) AS mutasi_keluar,
    COALESCE(vk_kemarin.jml_mutasi, 0) AS mutasi_keluar_kemarin FROM tb_stok ts
    $query_adjust
    JOIN tb_produk tp ON ts.id_produk = tp.id
    LEFT JOIN tb_so_detail tsd ON tsd.id_produk = ts.id_produk AND tsd.id_so = ?
    LEFT JOIN tb_so_detail tsd_kemarin ON tsd_kemarin.id_produk = ts.id_produk AND tsd_kemarin.id_so = ?
      WHERE ts.id_toko = ?
      GROUP BY ts.id_produk ORDER BY tp.kode ASC";

    $tabel_data = $this->db->query($query, $where_adjust)->result();

    // Query untuk mendapatkan data penjualan terbaru sesuai periode yang dipilih
    $query_jual_terbaru = "SELECT 
        tpd.id_produk,
        SUM(tpd.qty) as total_qty,
        tp.tanggal_penjualan
      FROM tb_penjualan_detail tpd
      JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
      WHERE tp.id_toko = ?
      AND tp.tanggal_penjualan BETWEEN ? AND ?
      GROUP BY tpd.id_produk";

    $jual_terbaru_data = $this->db->query($query_jual_terbaru, [$id_toko, $tgl_awal_formatted, $tgl_akhir_formatted])->result();

    // Buat array untuk mapping id_produk ke data penjualan
    $jual_terbaru_map = [];
    foreach ($jual_terbaru_data as $jt) {
      $jual_terbaru_map[$jt->id_produk] = (int)$jt->total_qty;
    }

    // Query untuk mendapatkan data PO masuk terbaru sesuai periode yang dipilih
    $query_po_terbaru = "SELECT 
        tpd.id_produk,
        SUM(tpd.qty_diterima) as total_qty
      FROM tb_pengiriman_detail tpd
      JOIN tb_pengiriman tp ON tpd.id_pengiriman = tp.id
      WHERE tp.id_toko = ?
      AND tp.updated_at BETWEEN ? AND ?
      GROUP BY tpd.id_produk";

    $po_terbaru_data = $this->db->query($query_po_terbaru, [$id_toko, $tgl_awal_formatted, $tgl_akhir_formatted])->result();

    // Buat array untuk mapping id_produk ke data PO
    $po_terbaru_map = [];
    foreach ($po_terbaru_data as $pt) {
      $po_terbaru_map[$pt->id_produk] = (int)$pt->total_qty;
    }

    // Query untuk mendapatkan data mutasi masuk terbaru sesuai periode yang dipilih
    $query_mutasi_masuk_terbaru = "SELECT 
        tmd.id_produk,
        SUM(tmd.qty_terima) as total_qty
      FROM tb_mutasi_detail tmd
      JOIN tb_mutasi tm ON tmd.id_mutasi = tm.id
      WHERE tm.id_toko_tujuan = ? AND tm.status = 2
      AND tm.updated_at BETWEEN ? AND ?
      GROUP BY tmd.id_produk";

    $mutasi_masuk_terbaru_data = $this->db->query($query_mutasi_masuk_terbaru, [$id_toko, $tgl_awal_formatted, $tgl_akhir_formatted])->result();

    // Buat array untuk mapping id_produk ke data mutasi masuk
    $mutasi_masuk_terbaru_map = [];
    foreach ($mutasi_masuk_terbaru_data as $mmt) {
      $mutasi_masuk_terbaru_map[$mmt->id_produk] = (int)$mmt->total_qty;
    }

    // Query untuk mendapatkan data mutasi keluar terbaru sesuai periode yang dipilih
    $query_mutasi_keluar_terbaru = "SELECT 
        tmd.id_produk,
        SUM(tmd.qty_terima) as total_qty
      FROM tb_mutasi_detail tmd
      JOIN tb_mutasi tm ON tmd.id_mutasi = tm.id
      WHERE tm.id_toko_asal = ? AND tm.status = 2
      AND tm.updated_at BETWEEN ? AND ?
      GROUP BY tmd.id_produk";

    $mutasi_keluar_terbaru_data = $this->db->query($query_mutasi_keluar_terbaru, [$id_toko, $tgl_awal_formatted, $tgl_akhir_formatted])->result();

    // Buat array untuk mapping id_produk ke data mutasi keluar
    $mutasi_keluar_terbaru_map = [];
    foreach ($mutasi_keluar_terbaru_data as $mkt) {
      $mutasi_keluar_terbaru_map[$mkt->id_produk] = (int)$mkt->total_qty;
    }

    // Query untuk mendapatkan data retur terbaru sesuai periode yang dipilih
    $query_retur_terbaru = "SELECT 
        trd.id_produk,
        SUM(trd.qty_terima) as total_qty
      FROM tb_retur_detail trd
      JOIN tb_retur tr ON trd.id_retur = tr.id
      WHERE tr.id_toko = ? AND tr.status >= 2 AND tr.status <= 4
      AND tr.updated_at BETWEEN ? AND ?
      GROUP BY trd.id_produk";

    $retur_terbaru_data = $this->db->query($query_retur_terbaru, [$id_toko, $tgl_awal_formatted, $tgl_akhir_formatted])->result();

    // Buat array untuk mapping id_produk ke data retur
    $retur_terbaru_map = [];
    foreach ($retur_terbaru_data as $rt) {
      $retur_terbaru_map[$rt->id_produk] = (int)$rt->total_qty;
    }

    $hasil = [];
    foreach ($tabel_data as $d) {
      // Ambil bulan kemarin dari tanggal SO
      $bulan_kemarin_text = date('F Y', strtotime($tgl_so_sekarang . ' -1 month'));

      // Cek apakah bulan kemarin adalah December 2024
      $isDec2024 = ($bulan_kemarin_text == "December 2024");

      // Hitung stok awal yang benar
      if ($isDec2024) {
        $stok_awal_fix = $d->qty_awal;
      } else {
        if ($cek_toko->status_adjust == 1) {
          if ($cek_adjustmen) {
            $stok_awal_fix = $d->stok_adjust;
          } else {
            $stok_awal_fix = $d->stok_adjust + $d->jml_terima_kemarin + $d->mutasi_masuk_kemarin - $d->jml_jual_kemarin - $d->jml_retur_kemarin - $d->mutasi_keluar_kemarin;
          }
        } else {
          $stok_awal_fix = $d->qty_awal_kemarin;
        }
      }

      // Hitung stok akhir
      $stok_akhir = $stok_awal_fix + $d->jml_terima + $d->mutasi_masuk -
        $d->jml_retur - $d->jml_jual - $d->mutasi_keluar;

      // Ambil data jual_terbaru untuk produk ini
      $jual_terbaru = isset($jual_terbaru_map[$d->id_produk]) ? $jual_terbaru_map[$d->id_produk] : 0;
      $po_terbaru = isset($po_terbaru_map[$d->id_produk]) ? $po_terbaru_map[$d->id_produk] : 0;
      $mutasi_masuk_terbaru = isset($mutasi_masuk_terbaru_map[$d->id_produk]) ? $mutasi_masuk_terbaru_map[$d->id_produk] : 0;
      $mutasi_keluar_terbaru = isset($mutasi_keluar_terbaru_map[$d->id_produk]) ? $mutasi_keluar_terbaru_map[$d->id_produk] : 0;
      $retur_terbaru = isset($retur_terbaru_map[$d->id_produk]) ? $retur_terbaru_map[$d->id_produk] : 0;

      $hasil[] = [
        'kode' => $d->kode,
        'nama' => $d->nama_produk,
        'stok_awal' => (int)$stok_awal_fix,
        'po_masuk' => (int)$d->jml_terima,
        'mutasi_masuk' => (int)$d->mutasi_masuk,
        'mutasi_keluar' => (int)$d->mutasi_keluar,
        'retur' => (int)$d->jml_retur,
        'jual' => (int)$d->jml_jual,
        'stok_akhir' => (int)$stok_akhir,
        'jual_terbaru' => $jual_terbaru,
        'po_masuk_terbaru' => $po_terbaru,
        'mutasi_masuk_terbaru' => $mutasi_masuk_terbaru,
        'mutasi_keluar_terbaru' => $mutasi_keluar_terbaru,
        'retur_terbaru' => $retur_terbaru,
      ];
    }

    // Urutkan data berdasarkan jual_terbaru dari yang terbanyak
    usort($hasil, function ($a, $b) {
      return $b['jual_terbaru'] - $a['jual_terbaru'];
    });

    echo json_encode([
      'toko' => $summary->nama_toko,
      'awal' => date('d-M-Y', strtotime($tgl_awal)),
      'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
      'tabel_data' => $hasil,
      'bln' => $jumlah_bulan
    ]);
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
