<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$role = $this->session->userdata('role');
		if ($role != "6") {
			tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
			redirect(base_url(''));
		}
		$this->load->model('M_dashboard');
	}
	public function index()
	{
		$data['title'] = 'Dashboard';
		$activity = $this->M_dashboard->verification_activity();
		$summary = $this->M_dashboard->summary();
		$data['t_minta'] = $this->M_dashboard->as_total($activity['minta']);
		$data['t_kirim'] = $this->M_dashboard->as_total($activity['kirim']);
		$data['t_retur'] = $this->M_dashboard->as_total($activity['retur']);
		$data['t_selisih'] = $this->M_dashboard->as_total($activity['selisih']);
		$data['t_stok'] = $this->M_dashboard->as_total($summary->stok_toko);
		$data['t_toko'] = $this->M_dashboard->as_total($summary->total_toko);
		$this->template->load('template/template', 'manager_mv/dashboard/index', $data);
	}
	public function transaksi()
	{
		$trend = $this->M_dashboard->transaction_trend(true);
		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode(array(
				'Pengiriman' => $trend['kirim'],
				'Retur' => $trend['retur'],
				'Permintaan' => $trend['minta']
			)));
	}
}
