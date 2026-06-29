<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "1") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $data['box'] = $this->box();
    $month_start = date('Y-m-01 00:00:00');
    $next_month_start = date('Y-m-01 00:00:00', strtotime('+1 month'));
    $previous_month_start = date('Y-m-01 00:00:00', strtotime('-1 month'));
    $two_months_ago_start = date('Y-m-01 00:00:00', strtotime('-2 months'));

    // Gunakan rentang tanggal agar index kolom tanggal dapat dipakai. Empat total
    // digabung menjadi satu round-trip database.
    $activity = $this->db->query("
      SELECT 'minta' AS jenis, COALESCE(SUM(tpd.qty_acc), 0) AS total
      FROM tb_permintaan tp
      JOIN tb_permintaan_detail tpd ON tpd.id_permintaan = tp.id
      WHERE tp.created_at >= ? AND tp.created_at < ?
        AND tp.status >= 2 AND tp.status != 5 AND tpd.status = 1
      UNION ALL
      SELECT 'kirim', COALESCE(SUM(tpd.qty), 0)
      FROM tb_pengiriman tp
      JOIN tb_pengiriman_detail tpd ON tpd.id_pengiriman = tp.id
      WHERE tp.created_at >= ? AND tp.created_at < ?
      UNION ALL
      SELECT 'jual', COALESCE(SUM(tpd.qty), 0)
      FROM tb_penjualan tp
      JOIN tb_penjualan_detail tpd ON tpd.id_penjualan = tp.id
      WHERE tp.tanggal_penjualan >= ? AND tp.tanggal_penjualan < ?
      UNION ALL
      SELECT 'retur', COALESCE(SUM(tpd.qty), 0)
      FROM tb_retur tr
      JOIN tb_retur_detail tpd ON tpd.id_retur = tr.id
      WHERE tr.created_at >= ? AND tr.created_at < ?
        AND tr.status BETWEEN 2 AND 4
    ", array(
      $month_start, $next_month_start, $month_start, $next_month_start,
      $month_start, $next_month_start, $month_start, $next_month_start
    ))->result();
    $activity_totals = array('minta' => 0, 'kirim' => 0, 'jual' => 0, 'retur' => 0);
    foreach ($activity as $row) {
      $activity_totals[$row->jenis] = (int) $row->total;
    }
    foreach ($activity_totals as $key => $total) {
      $data['t_' . $key] = (object) array('total' => $total);
    }

    // Ambil seluruh agregat bulan lalu sekali, lalu pilih nilai tertinggi dan
    // terendah di PHP. Sebelumnya tabel transaksi besar dipindai dua kali.
    $sales_by_store = $this->db->query("
      SELECT tt.id, tt.nama_toko, tu.nama_user AS spg,
             current_sales.total AS total_bulan_ini,
             current_sales.total AS total,
             COALESCE(previous_sales.total, 0) AS total_bulan_lalu
      FROM (
        SELECT tp.id_toko, SUM(tpd.qty) AS total
        FROM tb_penjualan tp
        JOIN tb_penjualan_detail tpd ON tpd.id_penjualan = tp.id
        WHERE tp.tanggal_penjualan >= ? AND tp.tanggal_penjualan < ?
        GROUP BY tp.id_toko
      ) current_sales
      JOIN tb_toko tt ON tt.id = current_sales.id_toko
      JOIN tb_user tu ON tu.id = tt.id_spg
      LEFT JOIN (
        SELECT tp.id_toko, SUM(tpd.qty) AS total
        FROM tb_penjualan tp
        JOIN tb_penjualan_detail tpd ON tpd.id_penjualan = tp.id
        WHERE tp.tanggal_penjualan >= ? AND tp.tanggal_penjualan < ?
        GROUP BY tp.id_toko
      ) previous_sales ON previous_sales.id_toko = current_sales.id_toko
      ORDER BY current_sales.total DESC
    ", array(
      $previous_month_start, $month_start,
      $two_months_ago_start, $previous_month_start
    ))->result();
    $data['top_toko'] = array_slice($sales_by_store, 0, 5);
    $data['low_toko'] = array_reverse(array_slice($sales_by_store, -5));

    $sales_by_product = $this->db->query("
      SELECT produk.id, produk.kode, produk.nama_produk, SUM(detail.qty) AS total
      FROM tb_penjualan penjualan
      JOIN tb_penjualan_detail detail ON detail.id_penjualan = penjualan.id
      JOIN tb_produk produk ON produk.id = detail.id_produk
      WHERE penjualan.tanggal_penjualan >= ? AND penjualan.tanggal_penjualan < ?
      GROUP BY detail.id_produk, produk.kode, produk.nama_produk
      ORDER BY total DESC
    ", array($previous_month_start, $month_start))->result();
    $data['top_artikel'] = array_slice($sales_by_product, 0, 5);
    $data['low_artikel'] = array_reverse(array_slice($sales_by_product, -5));
    $data['top_stok'] = $this->db->query("SELECT tt.*, SUM(ts.qty) as total, tu.nama_user as spg 
     FROM tb_toko tt
     JOIN tb_user tu on tt.id_spg = tu.id
     JOIN tb_stok ts on tt.id = ts.id_toko
     GROUP BY ts.id_toko 
     ORDER BY total DESC 
     LIMIT 5")->result();
    $this->template->load('template/template', 'adm/dashboard', $data);
  }

  // fungsi box
  public function box()
  {
    // Semua angka kartu dikirim dalam satu query, bukan delapan query terpisah.
    $totals = $this->db->query("
      SELECT
        (SELECT COUNT(*) FROM tb_toko WHERE status = 1) AS toko_aktif,
        (SELECT COUNT(*) FROM tb_toko WHERE status = 0) AS toko_tutup,
        (SELECT COUNT(*) FROM tb_customer) AS customer,
        (SELECT COUNT(*) FROM tb_produk WHERE status != 0) AS artikel,
        (SELECT COUNT(*) FROM tb_user WHERE status != 0) AS pengguna,
        (SELECT COUNT(*) FROM tb_aset_master) AS jenis_aset,
        (SELECT COALESCE(SUM(ts.qty), 0)
           FROM tb_stok ts
           JOIN tb_toko tt ON tt.id = ts.id_toko
          WHERE ts.status = 1 AND tt.status = 1) AS stok_toko,
        (SELECT COALESCE(SUM(stok), 0) FROM tb_produk WHERE status = 1) AS stok_gudang
    ")->row();

    $definitions = array(
      array('toko_aktif', 'Toko Aktif', 'adm/Toko/', 'fas fa-store'),
      array('toko_tutup', 'Toko Tutup', 'adm/Toko/toko_tutup', 'fas fa-store-slash'),
      array('customer', 'Customer', 'adm/Customer', 'fas fa-building'),
      array('artikel', 'Artikel', 'adm/Produk/', 'fas fa-cube'),
      array('pengguna', 'User', 'adm/User/', 'fas fa-users'),
      array('jenis_aset', 'Jenis Aset', 'hrd/Aset', 'fas fa-layer-group'),
      array('stok_toko', 'Stok Semua Toko', 'adm/Stok', 'fas fa-chart-pie'),
      array('stok_gudang', 'Stok Gudang Prepedan', 'adm/Stok/stok_gudang', 'fas fa-cubes')
    );

    $box = array_map(function ($definition) use ($totals) {
      return array(
        'box'   => 'bg-primary',
        'total' => (int) $totals->{$definition[0]},
        'title' => $definition[1],
        'link'  => $definition[2],
        'icon'  => $definition[3]
      );
    }, $definitions);

    return json_decode(json_encode($box), FALSE);
  }

  // grafik Transaksi
  public function transaksi()
  {
    $bln = date('m');
    $year_start = date('Y-01-01 00:00:00');
    $next_month_start = date('Y-m-01 00:00:00', strtotime('+1 month'));
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
        WHERE tp.created_at >= ? AND tp.created_at < ? AND tp.status >= 2 AND tp.status <= 4
        GROUP BY MONTH(tp.created_at)
    ";
    $jual = "
        SELECT MONTH(tp.tanggal_penjualan) as month, SUM(tpd.qty) as total
        FROM tb_penjualan_detail tpd
        join tb_penjualan tp on tpd.id_penjualan = tp.id
        WHERE tp.tanggal_penjualan >= ? AND tp.tanggal_penjualan < ?
        GROUP BY MONTH(tp.tanggal_penjualan)
    ";
    $date_range = array($year_start, $next_month_start);
    $hasil_kirim = $this->db->query($kirim, $date_range)->result_array();
    $hasil_retur = $this->db->query($retur, $date_range)->result_array();
    $hasil_jual = $this->db->query($jual, $date_range)->result_array();
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

    echo json_encode($data);
  }
  // grafik Stok SPV
  public function stok_spv()
  {
    $this->db->select('tb_user.nama_user as nama, COUNT(DISTINCT tb_toko.id) as total_toko, SUM(tb_stok.qty) as total_stok');
    $this->db->from('tb_stok');
    $this->db->join('tb_toko', 'tb_toko.id = tb_stok.id_toko');
    $this->db->join('tb_user', 'tb_user.id = tb_toko.id_spv');
    $this->db->where('tb_toko.status', 1);
    $this->db->group_by('tb_user.nama_user');
    $this->db->order_by('total_stok', 'DESC');
    $query = $this->db->get();
    $data = $query->result_array();
    echo json_encode($data);
  }
  public function saran()
  {
    $data['title'] = 'Dashboard';
    $data['saran'] = $this->db->query("SELECT * from tb_saran order by id desc")->result();
    $this->template->load('template/template', 'adm/saran', $data);
  }
}
