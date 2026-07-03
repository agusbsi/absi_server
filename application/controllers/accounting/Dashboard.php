<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "15") {
      tampil_alert('error', 'DI TOLAK !', 'Silahkan login kembali');
      redirect(base_url(''));
    }
    $this->load->model('M_dashboard');
  }
  public function index()
  {
    $data['title'] = 'Dashboard';
    $data['box'] = $this->M_dashboard->summary_boxes('accounting');
    $summary = $this->M_dashboard->summary();
    $activity = $this->M_dashboard->monthly_activity();
    foreach ($activity as $key => $total) {
      $data['t_' . $key] = $this->M_dashboard->as_total($total);
    }
    $data['t_stok'] = $this->M_dashboard->as_total($summary->stok_toko);
    $this->template->load('template/template', 'accounting/dashboard', $data);
  }
  // grafik Transaksi
  public function transaksi()
  {
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($this->M_dashboard->transaction_trend()));
  }
  public function box()
  {
    return $this->M_dashboard->summary_boxes('accounting');
  }
}
