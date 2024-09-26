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
    $bln = date('m');
    $thn = date('Y');
    // total permintaan
    $data['t_minta'] = $this->db->query("SELECT sum(tpd.qty_acc) as total FROM tb_permintaan_detail tpd
    join tb_permintaan tp on tpd.id_permintaan = tp.id
    where tp.status >= 2 AND tp.status != 5 AND tpd.status = 1 AND MONTH(tp.created_at) = $bln AND YEAR(tp.created_at) = $thn")->row();
    // total Pengiriman
    $data['t_kirim'] = $this->db->query("SELECT sum(tpd.qty) as total FROM tb_pengiriman_detail tpd
    join tb_pengiriman tp on tpd.id_pengiriman = tp.id
    where MONTH(tp.created_at) = $bln AND YEAR(tp.created_at) = $thn")->row();
    // Total Penjualan
    $data['t_jual'] = $this->db->query("SELECT sum(tpd.qty) as total FROM tb_penjualan_detail tpd
      join tb_penjualan tp on tpd.id_penjualan = tp.id
      where MONTH(tp.tanggal_penjualan) = $bln AND YEAR(tp.tanggal_penjualan) = $thn")->row();
    // retur
    $data['t_retur'] = $this->db->query("SELECT sum(tpd.qty) as total FROM tb_retur_detail tpd
      join tb_retur tr on tpd.id_retur = tr.id
      where tr.status >= 2 AND tr.status <= 4  AND MONTH(tr.created_at) = $bln AND YEAR(tr.created_at) = $thn")->row();

    $data['t_stok'] = $this->db->query("SELECT sum(ts.qty) as total FROM tb_stok ts
    JOIN tb_toko tt on ts.id_toko = tt.id where ts.status = 1 AND tt.status = 1 ")->row();
    // 5 top toko
    $data['top_toko'] = $this->db->query("SELECT tt.*, SUM(tpd.qty) as total, tu.nama_user as spg 
    FROM tb_toko tt
    JOIN tb_user tu on tt.id_spg = tu.id
    JOIN tb_penjualan tp ON tt.id = tp.id_toko
    JOIN tb_penjualan_detail tpd ON tp.id = tpd.id_penjualan
    WHERE DATE_FORMAT(tp.tanggal_penjualan, '%Y-%m') = DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m')
    GROUP BY tp.id_toko 
    ORDER BY total DESC 
    LIMIT 5")->result();
    $data['top_artikel'] = $this->db->query("SELECT tp.*, SUM(tpd.qty) as total
    FROM tb_produk tp
    JOIN tb_penjualan_detail tpd ON tp.id = tpd.id_produk
    JOIN tb_penjualan tpk ON tpk.id = tpd.id_penjualan
    WHERE DATE_FORMAT(tpk.tanggal_penjualan, '%Y-%m') = DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m')
    GROUP BY tpd.id_produk 
    ORDER BY total DESC 
    LIMIT 5")->result();
    $data['top_stok'] = $this->db->query("SELECT tt.*, SUM(ts.qty) as total, tu.nama_user as spg 
     FROM tb_toko tt
     JOIN tb_user tu on tt.id_spg = tu.id
     JOIN tb_stok ts on tt.id = ts.id_toko
     GROUP BY ts.id_toko 
     ORDER BY total DESC 
     LIMIT 5")->result();
    $data['low_toko'] = $this->db->query("SELECT tt.*, SUM(tpd.qty) as total, tu.nama_user as spg 
      FROM tb_toko tt
      JOIN tb_user tu on tt.id_spg = tu.id
      JOIN tb_penjualan tp ON tt.id = tp.id_toko
      JOIN tb_penjualan_detail tpd ON tp.id = tpd.id_penjualan
      WHERE DATE_FORMAT(tp.tanggal_penjualan, '%Y-%m') = DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m')
      GROUP BY tp.id_toko 
      ORDER BY total ASC 
      LIMIT 5")->result();
    $data['low_artikel'] = $this->db->query("SELECT tp.*, SUM(tpd.qty) as total
       FROM tb_produk tp
       JOIN tb_penjualan_detail tpd ON tp.id = tpd.id_produk
       JOIN tb_penjualan tpk ON tpk.id = tpd.id_penjualan
       WHERE DATE_FORMAT(tpk.tanggal_penjualan, '%Y-%m') = DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m')
       GROUP BY tpd.id_produk 
       ORDER BY total ASC 
       LIMIT 5")->result();

    $this->template->load('template/template', 'adm/dashboard', $data);
  }

  // fungsi box
  public function box()
  {
    $box = [

      [
        'box'         => 'bg-info',
        'total'       => $this->db->query("SELECT count(id) as total from tb_toko where  status = 1")->row()->total,
        'title'       => 'Toko',
        'link'        => 'adm/Toko/',
        'icon'        => 'fas fa-store'
      ],
      [
        'box'         => 'bg-warning',
        'total'       =>  $this->db->query("SELECT count(id) as total from tb_produk where  status != 0")->row()->total,
        'title'       => 'Artikel',
        'link'        => 'adm/Produk/',
        'icon'        => 'fas fa-cube'
      ],
      [
        'box'         => 'bg-info',
        'total'       =>  $this->db->query("SELECT count(id) as total from tb_user where  status != 0")->row()->total,
        'title'       => 'User',
        'link'        => 'adm/User/',
        'icon'        => 'fas fa-users'
      ],
      [
        'box'         => 'bg-success',
        'total'       => $this->db->query("SELECT count(id) as total from tb_aset_master")->row()->total,
        'title'       => 'Aset',
        'link'        => 'adm/Promo',
        'icon'        => 'fas fa-hospital'
      ]

    ];
    $info_box = json_decode(json_encode($box), FALSE);
    return $info_box;
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
