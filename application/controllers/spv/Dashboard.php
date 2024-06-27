<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "2") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }

    $this->load->model('M_spg');
  }

  public function index()
  {

    $id_spv = $this->session->userdata('id');
    $data['title'] = 'Dashboard';
    $data['t_toko'] = $this->db->query("SELECT count(id) as total from tb_toko where id_spv = '$id_spv' and status != 0")->row();
    $data['t_cust'] = $this->db->query("SELECT count(id) as total FROM tb_customer ")->row();
    $data['t_stok'] = $this->db->query("SELECT SUM(ts.qty) as total FROM tb_stok ts
        join tb_toko tt on ts.id_toko = tt.id
        WHERE tt.id_spv = '$id_spv'")->row();
    $data['t_leader'] = $this->db->query("SELECT count(tu.id) as total from tb_user tu
        JOIN tb_toko tt on tu.id = tt.id_leader
        where tt.id_spv = '$id_spv' group by tt.id_leader")->row();
    $data['top_stok'] = $this->db->query("SELECT tt.*, SUM(ts.qty) as total, tu.nama_user as spg 
    FROM tb_toko tt
    JOIN tb_user tu on tt.id_spg = tu.id
    JOIN tb_stok ts on tt.id = ts.id_toko
    WHERE tt.id_spv = '$id_spv'
    GROUP BY ts.id_toko 
    ORDER BY total DESC 
    LIMIT 5")->result();
    $bln = date('m');
    $thn = date('Y');
    // total permintaan
    $data['t_minta'] = $this->db->query("SELECT sum(tpd.qty_acc) as total FROM tb_permintaan_detail tpd
     join tb_permintaan tp on tpd.id_permintaan = tp.id
     join tb_toko tt on tp.id_toko = tt.id
     where tt.id_spv = '$id_spv' AND tp.status >= 2 AND tp.status != 5 AND tpd.status = 1 AND MONTH(tp.created_at) = $bln AND YEAR(tp.created_at) = $thn")->row();
    // total Pengiriman
    $data['t_kirim'] = $this->db->query("SELECT sum(tpd.qty) as total FROM tb_pengiriman_detail tpd
     join tb_pengiriman tp on tpd.id_pengiriman = tp.id
     join tb_toko tt on tp.id_toko = tt.id
     where tt.id_spv = '$id_spv' AND MONTH(tp.created_at) = $bln AND YEAR(tp.created_at) = $thn")->row();
    // Total Penjualan
    $data['t_jual'] = $this->db->query("SELECT sum(tpd.qty) as total FROM tb_penjualan_detail tpd
       join tb_penjualan tp on tpd.id_penjualan = tp.id
       join tb_toko tt on tp.id_toko = tt.id
       where tt.id_spv = '$id_spv' AND MONTH(tp.tanggal_penjualan) = $bln AND YEAR(tp.tanggal_penjualan) = $thn")->row();
    // retur
    $data['t_retur'] = $this->db->query("SELECT sum(tpd.qty) as total FROM tb_retur_detail tpd
       join tb_retur tr on tpd.id_retur = tr.id
       join tb_toko tt on tr.id_toko = tt.id
       where tt.id_spv = '$id_spv' AND tr.status >= 2 AND tr.status <= 4  AND MONTH(tr.created_at) = $bln AND YEAR(tr.created_at) = $thn")->row();

    $this->template->load('template/template', 'spv/dashboard', $data);
  }
  // grafik Transaksi
  public function transaksi()
  {
    $id_spv = $this->session->userdata('id');
    $thn = date('Y');
    $bln = date('m');
    $kirim = "
        SELECT MONTH(tp.created_at) as month, SUM(tpd.qty) as total
        FROM tb_pengiriman_detail tpd
        join tb_pengiriman tp on tpd.id_pengiriman = tp.id
        join tb_toko tt on tp.id_toko = tt.id
        WHERE tt.id_spv = '$id_spv' AND YEAR(tp.created_at) = ? AND MONTH(tp.created_at) <= ?
        GROUP BY MONTH(tp.created_at)
    ";
    $retur = "
        SELECT MONTH(tp.created_at) as month, SUM(tpd.qty) as total
        FROM tb_retur_detail tpd
        join tb_retur tp on tpd.id_retur = tp.id
        join tb_toko tt on tp.id_toko = tt.id
        WHERE tt.id_spv = '$id_spv' AND YEAR(tp.created_at) = ? AND MONTH(tp.created_at) <= ? AND  tp.status >= 2 AND tp.status <= 4
        GROUP BY MONTH(tp.created_at)
    ";
    $jual = "
        SELECT MONTH(tp.tanggal_penjualan) as month, SUM(tpd.qty) as total
        FROM tb_penjualan_detail tpd
        join tb_penjualan tp on tpd.id_penjualan = tp.id
        join tb_toko tt on tp.id_toko = tt.id
        WHERE tt.id_spv = '$id_spv' AND YEAR(tp.tanggal_penjualan) = ? AND MONTH(tp.tanggal_penjualan) <= ?
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
}
