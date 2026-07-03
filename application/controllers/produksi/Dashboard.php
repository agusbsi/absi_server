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
    $this->load->model('M_dashboard');
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
    return $this->M_dashboard->summary_boxes('production');
  }

  // grafik Transaksi
  public function transaksi()
  {
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($this->M_dashboard->transaction_trend()));
  }
  // grafik Stok SPV - Top 10 Stok Terbanyak di Gudang
  public function stok_terbanyak()
  {
    $summary = $this->M_dashboard->summary();
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array(
        'top10' => $this->M_dashboard->warehouse_stock_distribution(10),
        'total_stok' => (int) $summary->stok_gudang,
        'total_artikel' => (int) $summary->total_produk
      )));
  }
}
