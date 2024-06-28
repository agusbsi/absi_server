<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Stok extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('status') != 'login') {
      redirect(base_url());
    }
  }

  //   halaman utama
  public function index()
  {
    $data['title'] = 'Stok Artikel';
    $id_leader = $this->session->userdata('id');
    $query = "SELECT tp.*, COALESCE(SUM(ts.qty), 0) as stok
          FROM tb_produk tp
          JOIN tb_stok ts ON tp.id = ts.id_produk
          JOIN tb_toko tt ON ts.id_toko = tt.id
          WHERE tp.status = 1 AND tt.id_leader = '$id_leader'
          GROUP BY tp.id
          ORDER BY tp.kode ASC";
    $data['list_data'] = $this->db->query($query)->result();
    $data['artikel'] = $this->db->query("SELECT COUNT(DISTINCT ts.id_produk) as total, COALESCE(SUM(ts.qty), 0) as stok
    FROM tb_stok ts
    JOIN tb_toko tt on ts.id_toko = tt.id 
    WHERE tt.id_leader = '$id_leader' AND ts.status = 1")->row();
    $this->template->load('template/template', 'leader/stok/index', $data);
  }
  public function detail($id)
  {
    $data['title'] = 'Stok Artikel';
    $id_leader = $this->session->userdata('id');
    $query = "SELECT ts.*,tt.nama_toko, tp.nama_produk, tp.kode
          FROM tb_stok ts
          JOIN tb_toko tt ON ts.id_toko = tt.id
          join tb_produk tp on ts.id_produk = tp.id
          where ts.id_produk = '$id' AND tt.id_leader = '$id_leader'
          ORDER BY ts.qty DESC";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'leader/stok/detail', $data);
  }
  public function s_customer()
  {
    $data['title'] = 'Stok Customer';
    $id_leader = $this->session->userdata('id');
    $thn = date('Y');
    $bln = (new DateTime('first day of -2 month'))->format('m');
    $query = "SELECT 
        tc.id,
        tc.nama_cust,
        tc.alamat_cust,
        (SELECT COUNT(id) FROM tb_toko tt WHERE tt.id_customer = tc.id AND tt.status = 1 AND tt.id_leader = '$id_leader') AS t_toko,
        (SELECT COALESCE(SUM(ts.qty), 0) FROM tb_stok ts JOIN tb_toko tt ON ts.id_toko = tt.id WHERE tt.id_customer = tc.id AND tt.status = 1 AND tt.id_leader = '$id_leader') AS t_stok,
        (SELECT COALESCE(SUM(ts.qty_awal), 0) FROM tb_stok ts JOIN tb_toko tt ON ts.id_toko = tt.id WHERE tt.id_customer = tc.id AND tt.status = 1 AND tt.id_leader = '$id_leader') AS t_akhir,
        (SELECT COALESCE(SUM(ts.jml_jual), 0) FROM vw_penjualan ts JOIN tb_toko tt ON ts.id_toko = tt.id WHERE tt.id_customer = tc.id AND tt.status = 1 AND tt.id_leader = '$id_leader' AND ts.tahun = '$thn' AND ts.bulan = '$bln' ) AS t_jual

    FROM 
        tb_customer tc
    JOIN tb_toko tt on tc.id = tt.id_customer
    WHERE tt.id_leader = '$id_leader' AND tt.status = 1
    GROUP BY tc.id
    ORDER BY 
        tc.nama_cust ASC";
    $data['list_data'] = $this->db->query($query)->result();
    $data['cust'] = $this->db->query("SELECT count(DISTINCT tc.id) as total from tb_customer tc
    JOIN tb_toko tt on tc.id = tt.id_customer
    WHERE tt.id_leader = '$id_leader' AND tt.status = 1 ")->row();
    $data['stok'] = $this->db->query("SELECT SUM(ts.qty) as total, SUM(ts.qty_awal) as stok_akhir from tb_stok ts
    JOIN tb_toko tt on ts.id_toko = tt.id 
    where tt.status = 1 AND tt.id_leader = '$id_leader' ")->row();
    $data['jual'] = $this->db->query("SELECT SUM(jml_jual) as total from vw_penjualan tv
    JOIN tb_toko tt on tv.id_toko = tt.id 
    where tv.tahun = '$thn' AND tv.bulan = '$bln' AND tt.id_leader = '$id_leader' ")->row();
    $this->template->load('template/template', 'leader/stok/customer', $data);
  }
  public function detail_toko($id)
  {
    $data['title'] = 'Stok Customer';
    $thn = date('Y');
    $bln = (new DateTime('first day of -2 month'))->format('m');
    $id_leader = $this->session->userdata('id');
    $query = "
      SELECT 
          tc.nama_cust, 
          tt.nama_toko, 
          COALESCE(SUM(ts.qty), 0) AS t_stok,
          (SELECT COALESCE(SUM(ts.qty_awal), 0) FROM tb_stok ts WHERE ts.id_toko = tt.id) AS t_akhir,
          (SELECT COALESCE(SUM(ts.jml_jual), 0) FROM vw_penjualan ts WHERE ts.id_toko = tt.id AND ts.tahun = '$thn' AND ts.bulan = '$bln') AS t_jual
      FROM 
          tb_customer tc
      JOIN 
          tb_toko tt ON tc.id = tt.id_customer
      LEFT JOIN 
          tb_stok ts ON tt.id = ts.id_toko
      WHERE 
          tc.id = '$id' AND tt.status = 1 AND tt.id_leader = '$id_leader'
      GROUP BY 
          tt.id 
      ORDER BY 
          SUM(ts.qty) DESC
      ";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'leader/stok/detail_toko', $data);
  }

  public function detail_artikel($id)
  {
    $data['title'] = 'Stok Customer';
    $id_leader = $this->session->userdata('id');
    $query = "SELECT tc.nama_cust, tp.kode,tp.nama_produk as artikel, COALESCE(SUM(ts.qty), 0) AS t_stok FROM tb_customer tc
    JOIN tb_toko tt on tc.id = tt.id_customer
    LEFT JOIN tb_stok ts on tt.id = ts.id_toko
    JOIN tb_produk tp on ts.id_produk = tp.id
    WHERE tc.id = '$id' AND tt.status = 1 AND tt.id_leader = '$id_leader' GROUP BY tp.id ORDER BY SUM(ts.qty) DESC";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'leader/stok/detail_artikel', $data);
  }
}
