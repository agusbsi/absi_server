<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$role = $this->session->userdata('role');
		if ($role != "8") {
			tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
			redirect(base_url(''));
		}
		$this->load->model('M_dashboard');
		$this->load->model('M_admin');
		$this->load->model('M_support');
	}
	public function index()
	{
		$data['title'] = 'Dashboard';
		$summary = $this->M_dashboard->summary();
		$data['t_toko'] = $this->M_dashboard->as_total($summary->total_toko);
		$data['jumlah_produk'] = (int) $summary->total_produk;
		$data = array_merge($data, $this->M_dashboard->admin_verification_data(5));
		$this->template->load('template/template', 'admin_mv/dashboard/index', $data);
	}
}
