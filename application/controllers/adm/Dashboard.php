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
    $this->load->model('M_dashboard');
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $data['box'] = $this->M_dashboard->summary_boxes('full');
    foreach ($this->M_dashboard->monthly_activity() as $key => $total) {
      $data['t_' . $key] = $this->M_dashboard->as_total($total);
    }
    $performance = $this->M_dashboard->sales_performance(5);
    $data = array_merge($data, $performance);
    $data['top_stok'] = $this->M_dashboard->stock_distribution(5);
    $this->template->load('template/template', 'adm/dashboard', $data);
  }

  // fungsi box
  public function box()
  {
    return $this->M_dashboard->summary_boxes('full');
  }

  // grafik Transaksi
  public function transaksi()
  {
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($this->M_dashboard->transaction_trend()));
  }
  // grafik Stok SPV
  public function stok_spv()
  {
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($this->M_dashboard->stock_distribution_by_supervisor()));
  }
  public function saran()
  {
    $data['title'] = 'Dashboard';
    $data['saran'] = $this->M_dashboard->suggestions();
    $this->template->load('template/template', 'adm/saran', $data);
  }
}
