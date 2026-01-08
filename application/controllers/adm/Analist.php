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

    // Cari id_so berdasarkan tgl_akhir periode
    $periode_akhir = date('Y-m', strtotime($tgl_akhir));
    $so_query = $this->db->query("SELECT id, tgl_so, created_at FROM tb_so WHERE id_toko = '$id_toko' AND DATE_FORMAT(created_at, '%Y-%m') = '$periode_akhir' ORDER BY id DESC LIMIT 1")->row();

    // Jika tidak ada SO, return data kosong
    if (!$so_query) {
      $data = [
        'toko' => $summary->nama_toko,
        'awal' => date('d-M-Y', strtotime($tgl_awal)),
        'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
        'tabel_data' => [],
        'bln' => $jumlah_bulan,
        'error' => 'Data SO tidak ditemukan'
      ];
      echo json_encode($data);
      return;
    }

    $tgl_so = $so_query->tgl_so;
    $tgl_so_sebelumnya = date('Y-m-d', strtotime('-1 month', strtotime($tgl_so)));
    $bulan_kemarin = date('Y-m', strtotime('first day of last month', strtotime($so_query->created_at)));
    $isDec2024 = ($bulan_kemarin == "2024-12");

    // Cek status adjust toko
    $cek_toko = $this->db->query("SELECT * FROM tb_toko where id = '$id_toko'")->row();
    $cek_adjustmen = null;
    $awal_tahun = "2024-12-01";

    // Cek apakah ada adjustment
    if ($cek_toko->status_adjust == 1) {
      $periode = date('Y-m', strtotime('-1 month', strtotime($so_query->created_at)));
      $cek_adjustmen = $this->db->query("SELECT tas.id as id_adjust FROM tb_adjust_stok tas
        JOIN tb_so ts ON tas.id_so = ts.id
        WHERE ts.id_toko = '$id_toko' AND DATE_FORMAT(ts.created_at, '%Y-%m') = '$periode' AND tas.status = 1")->row();

      if (!$cek_adjustmen && $cek_toko->id_adjust) {
        $cari_awal_tahun = $this->db->query("SELECT created_at from tb_adjust_stok where id = '$cek_toko->id_adjust'")->row();
        if ($cari_awal_tahun) {
          $awal_tahun = date('Y-m-01', strtotime($cari_awal_tahun->created_at));
        }
      }
    }

    // Build query adjust
    $select_adjust = "";
    $join_adjust = "";
    if ($cek_adjustmen) {
      $select_adjust = "COALESCE(adj.hasil_so, 0) as stok_adjust,";
      $join_adjust = "LEFT JOIN (SELECT id_produk, hasil_so FROM tb_adjust_detail WHERE id_adjust = '{$cek_adjustmen->id_adjust}' GROUP BY id_produk) adj ON adj.id_produk = ts.id_produk";
    } else if ($cek_toko->id_adjust && $cek_toko->status_adjust == 1) {
      $select_adjust = "COALESCE(adj.hasil_so, 0) as stok_adjust,";
      $join_adjust = "LEFT JOIN (SELECT id_produk, hasil_so FROM tb_adjust_detail WHERE id_adjust = '{$cek_toko->id_adjust}' GROUP BY id_produk) adj ON adj.id_produk = ts.id_produk";
    }

    // Query data
    $tabel_data = $this->db->query("SELECT tpk.kode, tpk.nama_produk,
    ts.qty_awal,
    $select_adjust
    COALESCE(ts.qty_awal + COALESCE(vt_kemarin.jml_terima, 0) + COALESCE(vm_kemarin.jml_mutasi, 0) - COALESCE(vp_kemarin.jml_jual, 0) - COALESCE(vr_kemarin.jml_retur, 0) - COALESCE(vk_kemarin.jml_mutasi, 0), 0) as qty_awal_kemarin,
    COALESCE(vt.jml_terima, 0) AS jml_terima,
    COALESCE(vt_kemarin.jml_terima, 0) AS jml_terima_kemarin,
    COALESCE(vm.jml_mutasi, 0) AS mutasi_masuk,
    COALESCE(vm_kemarin.jml_mutasi, 0) AS mutasi_masuk_kemarin,
    COALESCE(vp.jml_jual, 0) AS jml_jual,
    COALESCE(vp_kemarin.jml_jual, 0) AS jml_jual_kemarin,
    COALESCE(vr.jml_retur, 0) AS jml_retur,
    COALESCE(vr_kemarin.jml_retur, 0) AS jml_retur_kemarin,
    COALESCE(vk.jml_mutasi, 0) AS mutasi_keluar,
    COALESCE(vk_kemarin.jml_mutasi, 0) AS mutasi_keluar_kemarin,
    COALESCE(tpd_user.qty, 0) as total
    FROM tb_stok ts
    LEFT JOIN tb_produk tpk ON ts.id_produk = tpk.id
    LEFT JOIN (SELECT tpd.id_produk, SUM(tpd.qty) as qty FROM tb_penjualan_detail tpd JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id WHERE tp.id_toko = '$id_toko' AND DATE(tp.tanggal_penjualan) BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY tpd.id_produk) tpd_user ON tpk.id = tpd_user.id_produk
    LEFT JOIN (SELECT tpd.id_produk, SUM(tpd.qty_diterima) AS jml_terima FROM tb_pengiriman_detail tpd JOIN tb_pengiriman tp ON tpd.id_pengiriman = tp.id WHERE tp.id_toko = '$id_toko' AND tp.updated_at BETWEEN '$awal_tahun' AND DATE_SUB('$tgl_so_sebelumnya', INTERVAL DAYOFMONTH('$tgl_so_sebelumnya') DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND GROUP BY tpd.id_produk) vt_kemarin ON vt_kemarin.id_produk = ts.id_produk
    LEFT JOIN (SELECT tpd.id_produk, SUM(tpd.qty_terima) AS jml_mutasi FROM tb_mutasi_detail tpd JOIN tb_mutasi tp ON tpd.id_mutasi = tp.id WHERE tp.id_toko_tujuan = '$id_toko' AND tp.status = 2 AND tp.updated_at BETWEEN '$awal_tahun' AND DATE_SUB('$tgl_so_sebelumnya', INTERVAL DAYOFMONTH('$tgl_so_sebelumnya') DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND GROUP BY tpd.id_produk) vm_kemarin ON vm_kemarin.id_produk = ts.id_produk
    LEFT JOIN (SELECT tpd.id_produk, SUM(tpd.qty) AS jml_jual FROM tb_penjualan_detail tpd JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id WHERE tp.id_toko = '$id_toko' AND tp.tanggal_penjualan BETWEEN '$awal_tahun' AND DATE_SUB('$tgl_so_sebelumnya', INTERVAL DAYOFMONTH('$tgl_so_sebelumnya') DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND GROUP BY tpd.id_produk) vp_kemarin ON vp_kemarin.id_produk = ts.id_produk
    LEFT JOIN (SELECT tpd.id_produk, SUM(tpd.qty_terima) AS jml_retur FROM tb_retur_detail tpd JOIN tb_retur tp ON tpd.id_retur = tp.id WHERE tp.id_toko = '$id_toko' AND tp.status >= 2 AND tp.status <= 4 AND tp.updated_at BETWEEN '$awal_tahun' AND DATE_SUB('$tgl_so_sebelumnya', INTERVAL DAYOFMONTH('$tgl_so_sebelumnya') DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND GROUP BY tpd.id_produk) vr_kemarin ON vr_kemarin.id_produk = ts.id_produk
    LEFT JOIN (SELECT tpd.id_produk, SUM(tpd.qty_terima) AS jml_mutasi FROM tb_mutasi_detail tpd JOIN tb_mutasi tp ON tpd.id_mutasi = tp.id WHERE tp.id_toko_asal = '$id_toko' AND tp.status = 2 AND tp.updated_at BETWEEN '$awal_tahun' AND DATE_SUB('$tgl_so_sebelumnya', INTERVAL DAYOFMONTH('$tgl_so_sebelumnya') DAY) + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND GROUP BY tpd.id_produk) vk_kemarin ON vk_kemarin.id_produk = ts.id_produk
    LEFT JOIN (SELECT id_produk, jml_terima FROM vw_penerimaan WHERE id_toko = '$id_toko' AND tahun = YEAR('$tgl_so') AND bulan = MONTH('$tgl_so') GROUP BY id_produk) vt ON vt.id_produk = ts.id_produk
    LEFT JOIN (SELECT id_produk, jml_mutasi FROM vw_mutasi_masuk WHERE id_toko_tujuan = '$id_toko' AND tahun = YEAR('$tgl_so') AND bulan = MONTH('$tgl_so') GROUP BY id_produk) vm ON vm.id_produk = ts.id_produk
    LEFT JOIN (SELECT id_produk, jml_jual FROM vw_penjualan WHERE id_toko = '$id_toko' AND tahun = YEAR('$tgl_so') AND bulan = MONTH('$tgl_so') GROUP BY id_produk) vp ON vp.id_produk = ts.id_produk
    LEFT JOIN (SELECT id_produk, jml_retur FROM vw_retur WHERE id_toko = '$id_toko' AND tahun = YEAR('$tgl_so') AND bulan = MONTH('$tgl_so') GROUP BY id_produk) vr ON vr.id_produk = ts.id_produk
    LEFT JOIN (SELECT id_produk, jml_mutasi FROM vw_mutasi_keluar WHERE id_toko_asal = '$id_toko' AND tahun = YEAR('$tgl_so') AND bulan = MONTH('$tgl_so') GROUP BY id_produk) vk ON vk.id_produk = ts.id_produk
    $join_adjust
    WHERE ts.id_toko = '$id_toko'
    GROUP BY tpk.id
    ORDER BY COALESCE(tpd_user.qty, 0) DESC")->result();

    // Kalkulasi stok_akhir dan output detail
    $hasil = [];
    foreach ($tabel_data as $d) {
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

      // Hitung stok akhir: stok_awal + po_masuk + mutasi_masuk - retur - mutasi_keluar - penjualan
      $stok_akhir = $stok_awal_fix + $d->jml_terima + $d->mutasi_masuk - $d->jml_retur - $d->mutasi_keluar - $d->jml_jual;

      // Kembalikan data lengkap
      $hasil[] = [
        'kode' => $d->kode,
        'nama' => $d->nama_produk,
        'stok_awal' => $stok_awal_fix,
        'po_masuk' => $d->jml_terima,
        'mutasi_masuk' => $d->mutasi_masuk,
        'retur' => $d->jml_retur,
        'penjualan' => $d->jml_jual,
        'mutasi_keluar' => $d->mutasi_keluar,
        'stok_akhir' => $stok_akhir,
        'jual' => $d->total
      ];
    }

    $data = [
      'toko' => $summary->nama_toko,
      'awal' => date('d-M-Y', strtotime($tgl_awal)),
      'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
      'tabel_data' => $hasil,
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
