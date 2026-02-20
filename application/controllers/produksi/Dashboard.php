<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    $allowed_roles = [1, 18];
    if (!in_array($role, $allowed_roles)) {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $data['box'] = $this->box();
    $this->template->load('template/template', 'produksi/dashboard', $data);
  }

  // fungsi box
  public function box()
  {
    $queries = [
      ['bg-primary', 'SELECT count(id) as total from tb_toko where status = 1', 'Toko Aktif', 'adm/Toko/', 'fas fa-store'],
      ['bg-primary', 'SELECT count(id) as total from tb_produk where status = 1', 'Artikel', 'adm/Produk/', 'fas fa-cube'],
      ['bg-primary', 'SELECT sum(ts.qty) as total FROM tb_stok ts JOIN tb_toko tt on ts.id_toko = tt.id where ts.status = 1 AND tt.status = 1', 'Stok Di Toko', 'adm/Stok', 'fas fa-chart-pie'],
      ['bg-primary', 'SELECT SUM(stok) as total FROM tb_produk where status = 1', 'Stok Di Gudang Prepedan', 'adm/Stok/stok_gudang', 'fas fa-cubes'],
    ];

    $box = array_map(function ($query) {
      return [
        'box'   => $query[0],
        'total' => $this->db->query($query[1])->row()->total,
        'title' => $query[2],
        'link'  => $query[3],
        'icon'  => $query[4]
      ];
    }, $queries);

    return json_decode(json_encode($box), FALSE);
  }

  // grafik Transaksi
  public function transaksi()
  {
    $thn = date('Y');
    $bln = date('m');
    $kirim = "
        SELECT MONTH(tp.created_at) as month, SUM(tpd.qty) as total
        FROM tb_pengiriman_detail tpd
        join tb_pengiriman tp on tpd.id_pengiriman = tp.id
        WHERE YEAR(tp.created_at) = ? AND MONTH(tp.created_at) <= ?
        GROUP BY MONTH(tp.created_at)
    ";
    $retur = "
        SELECT MONTH(tp.created_at) as month, SUM(tpd.qty) as total
        FROM tb_retur_detail tpd
        join tb_retur tp on tpd.id_retur = tp.id
        WHERE YEAR(tp.created_at) = ? AND MONTH(tp.created_at) <= ? AND  tp.status >= 2 AND tp.status <= 4
        GROUP BY MONTH(tp.created_at)
    ";
    $jual = "
        SELECT MONTH(tp.tanggal_penjualan) as month, SUM(tpd.qty) as total
        FROM tb_penjualan_detail tpd
        join tb_penjualan tp on tpd.id_penjualan = tp.id
        WHERE YEAR(tp.tanggal_penjualan) = ? AND MONTH(tp.tanggal_penjualan) <= ?
        GROUP BY MONTH(tp.tanggal_penjualan)
    ";
    $hasil_kirim = $this->db->query($kirim, array($thn, $bln))->result_array();
    $hasil_retur = $this->db->query($retur, array($thn, $bln))->result_array();
    $hasil_jual = $this->db->query($jual, array($thn, $bln))->result_array();
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
  // grafik Stok SPV - Top 10 Stok Terbanyak di Gudang
  public function stok_terbanyak()
  {
    // Get top 10 products
    $this->db->select('id, kode, nama_produk, stok');
    $this->db->from('tb_produk');
    $this->db->where('status', 1);
    $this->db->order_by('stok', 'DESC');
    $this->db->limit(10);
    $query = $this->db->get();
    $top10 = $query->result_array();

    // Get total stock of all products
    $this->db->select('SUM(stok) as total_stok, COUNT(id) as total_artikel');
    $this->db->from('tb_produk');
    $this->db->where('status', 1);
    $query_total = $this->db->get();
    $total = $query_total->row_array();

    $data = array(
      'top10' => $top10,
      'total_stok' => $total['total_stok'],
      'total_artikel' => $total['total_artikel']
    );

    echo json_encode($data);
  }
}
