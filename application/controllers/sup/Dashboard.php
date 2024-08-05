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
	}
	public function index()
	{
		$data['title'] = 'Dashboard';
		$bln = date('m');
		$thn = date('Y');
		$data['t_minta'] = $this->db->query("SELECT COUNT(id) as total FROM tb_permintaan
		where status >= 2 AND status != 5 AND MONTH(created_at) = $bln AND YEAR(created_at) = $thn")->row();
		$data['t_kirim'] = $this->db->query("SELECT COUNT(id) as total FROM tb_pengiriman
		where MONTH(created_at) = $bln AND YEAR(created_at) = $thn")->row();
		$data['t_selisih'] = $this->db->query("SELECT COUNT(id) as total FROM tb_pengiriman
		where status = 3 AND MONTH(created_at) = $bln AND YEAR(created_at) = $thn ")->row();
		$data['t_retur'] = $this->db->query("SELECT COUNT(id) as total FROM tb_retur
		where status >= 2 AND status <= 4  AND MONTH(created_at) = $bln AND YEAR(created_at) = $thn")->row();
		$data['t_stok'] = $this->db->query("SELECT sum(ts.qty) as total FROM tb_stok ts
    	JOIN tb_toko tt on ts.id_toko = tt.id where ts.status = 1 AND tt.status = 1 ")->row();
		$data['t_toko'] = $this->db->query("SELECT COUNT(id) as total FROM tb_toko
    	where status = 1")->row();
		$this->template->load('template/template', 'manager_mv/dashboard/index', $data);
	}
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
		$po = "
        SELECT MONTH(tp.created_at) as month, SUM(tpd.qty) as total
        FROM tb_permintaan_detail tpd
        join tb_permintaan tp on tpd.id_permintaan = tp.id
        WHERE YEAR(tp.created_at) = ? AND MONTH(tp.created_at) <= ?
        GROUP BY MONTH(tp.created_at)
    ";
		$hasil_kirim = $this->db->query($kirim, array($thn, $bln))->result_array();
		$hasil_retur = $this->db->query($retur, array($thn, $bln))->result_array();
		$hasil_jual = $this->db->query($po, array($thn, $bln))->result_array();
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
			'Pengiriman' => $data_kirim,
			'Retur' => $data_retur,
			'Permintaan' => $data_jual,
		);

		echo json_encode($data);
	}
}
