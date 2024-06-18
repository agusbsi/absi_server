<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Otomatis extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function reset_so_toko()
	{
		$this->db->query("UPDATE tb_toko set status_aset='0', status_so ='0' where status = '1'");
		$deskripsi = "Update otomatis RESET ASET & SO SEMUA TOKO.";
		$tanggal = date("Y-m-d H:i:s");
		$data = array(
			'deskripsi' => $deskripsi,
			'tanggal' => $tanggal,
		);
		$this->db->insert('tb_otomatis', $data);
	}
	// SET DATA STOK AWAL SETIAP BULAN
	public function stok_awal()
	{
		$this->db->trans_start();
		$sql = "UPDATE tb_stok SET qty_awal = qty";
		$this->db->query($sql);
		$affected_rows = $this->db->affected_rows();
		$deskripsi = "Update otomatis SET DATA STOK AWAL. Total = " . $affected_rows . " Data";
		$tanggal = date("Y-m-d H:i:s");
		$data = array(
			'deskripsi' => $deskripsi,
			'tanggal' => $tanggal,
		);
		$this->db->insert('tb_otomatis', $data);
		$this->db->trans_complete();
	}
}
