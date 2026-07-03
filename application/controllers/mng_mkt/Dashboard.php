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
    $this->load->model('M_dashboard');
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $summary = $this->M_dashboard->summary();
    $activity = $this->M_dashboard->monthly_activity();
    $data['t_toko'] = $this->M_dashboard->as_total($summary->total_toko);
    $data['t_user'] = $this->M_dashboard->as_total($summary->total_user);
    $data['t_stok'] = $this->M_dashboard->as_total($summary->stok_toko);
    $data['t_stok_gudang'] = $this->M_dashboard->as_total($summary->stok_gudang);
    $data['t_customer'] = $this->M_dashboard->as_total($summary->total_customer);
    $data['t_toko_tutup'] = $this->M_dashboard->as_total($summary->total_toko_tutup);
    foreach ($activity as $key => $total) {
      $data['t_' . $key] = $this->M_dashboard->as_total($total);
    }
    $this->template->load('template/template', 'manager_mkt/dashboard', $data);
  }

  public function ranking()
  {
    $performance = $this->M_dashboard->sales_performance(5);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array(
        'top_toko' => $performance['top_toko'],
        'top_artikel' => $performance['top_artikel'],
        'top_stok' => $this->M_dashboard->stock_distribution(5)
      )));
  }
  public function transaksi()
  {
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($this->M_dashboard->transaction_trend()));
  }
}
