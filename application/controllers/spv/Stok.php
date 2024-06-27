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
    $id_spv = $this->session->userdata('id');
    $query = "SELECT tp.*, COALESCE(SUM(ts.qty), 0) as stok
          FROM tb_produk tp
          JOIN tb_stok ts ON tp.id = ts.id_produk
          JOIN tb_toko tt ON ts.id_toko = tt.id
          WHERE tp.status = 1 AND tt.id_spv = '$id_spv'
          GROUP BY tp.id
          ORDER BY tp.kode ASC";
    $data['list_data'] = $this->db->query($query)->result();
    $data['artikel'] = $this->db->query("SELECT COUNT(DISTINCT ts.id_produk) as total, COALESCE(SUM(ts.qty), 0) as stok
    FROM tb_stok ts
    JOIN tb_toko tt on ts.id_toko = tt.id 
    WHERE tt.id_spv = '$id_spv' AND ts.status = 1")->row();
    $this->template->load('template/template', 'spv/stok/index', $data);
  }
  public function detail($id)
  {
    $data['title'] = 'Stok Artikel';
    $id_spv = $this->session->userdata('id');
    $query = "SELECT ts.*,tt.nama_toko, tp.nama_produk, tp.kode
          FROM tb_stok ts
          JOIN tb_toko tt ON ts.id_toko = tt.id
          join tb_produk tp on ts.id_produk = tp.id
          where ts.id_produk = '$id' AND tt.id_spv = '$id_spv'
          ORDER BY ts.qty DESC";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'spv/stok/detail', $data);
  }
  public function s_customer()
  {
    $data['title'] = 'Stok Customer';
    $thn = date('Y');
    $bln = (new DateTime('first day of -2 month'))->format('m');
    $query = "SELECT 
        tc.id,
        tc.nama_cust,
        tc.alamat_cust,
        (SELECT COUNT(id) FROM tb_toko tt WHERE tt.id_customer = tc.id AND tt.status = 1) AS t_toko,
        (SELECT COALESCE(SUM(ts.qty), 0) FROM tb_stok ts JOIN tb_toko tt ON ts.id_toko = tt.id WHERE tt.id_customer = tc.id AND tt.status = 1) AS t_stok,
        (SELECT COALESCE(SUM(ts.qty_awal), 0) FROM tb_stok ts JOIN tb_toko tt ON ts.id_toko = tt.id WHERE tt.id_customer = tc.id AND tt.status = 1) AS t_akhir,
        (SELECT COALESCE(SUM(ts.jml_jual), 0) FROM vw_penjualan ts JOIN tb_toko tt ON ts.id_toko = tt.id WHERE tt.id_customer = tc.id AND tt.status = 1 AND ts.tahun = '$thn' AND ts.bulan = '$bln' ) AS t_jual

    FROM 
        tb_customer tc
    ORDER BY 
        tc.nama_cust ASC";
    $data['list_data'] = $this->db->query($query)->result();
    $data['cust'] = $this->db->query("SELECT count(id) as total from tb_customer")->row();
    $data['stok'] = $this->db->query("SELECT SUM(qty) as total, SUM(qty_awal) as stok_akhir from tb_stok where status = 1 ")->row();
    $data['jual'] = $this->db->query("SELECT SUM(jml_jual) as total from vw_penjualan where tahun = '$thn' AND bulan = '$bln' ")->row();
    $this->template->load('template/template', 'adm/stok/customer', $data);
  }
  public function detail_toko($id)
  {
    $data['title'] = 'Stok Customer';
    $thn = date('Y');
    $bln = (new DateTime('first day of -2 month'))->format('m');

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
          tc.id = '$id' AND tt.status = 1 
      GROUP BY 
          tt.id 
      ORDER BY 
          SUM(ts.qty) DESC
      ";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'adm/stok/detail_toko', $data);
  }

  public function detail_artikel($id)
  {
    $data['title'] = 'Stok Customer';
    $query = "SELECT tc.nama_cust, tp.kode,tp.nama_produk as artikel, COALESCE(SUM(ts.qty), 0) AS t_stok FROM tb_customer tc
    JOIN tb_toko tt on tc.id = tt.id_customer
    LEFT JOIN tb_stok ts on tt.id = ts.id_toko
    JOIN tb_produk tp on ts.id_produk = tp.id
    WHERE tc.id = '$id' AND tt.status = 1 GROUP BY tp.id ORDER BY SUM(ts.qty) DESC";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'adm/stok/detail_artikel', $data);
  }

  // Kartu Stok
  public function kartu_stok()
  {
    $data['title'] = 'Kartu Stok';
    $data['toko'] = $this->db->query("SELECT * from tb_toko where status = 1")->result();
    $data['artikel'] = $this->db->query("SELECT * from tb_produk where status = 1")->result();
    $this->template->load('template/template', 'adm/stok/kartu_stok', $data);
  }
  public function cari_kartu()
  {
    $id_toko = $this->input->get('id_toko');
    $id_artikel = $this->input->get('id_artikel');
    $tgl_awal = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');

    // Ensure the inputs are properly sanitized and validated
    $id_toko = intval($id_toko);
    $id_artikel = intval($id_artikel);
    $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
    $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
    log_message('debug', 'tgl_awal: ' . $tgl_awal);
    $toko = $this->db->query("SELECT * FROM tb_toko WHERE id = ?", array($id_toko))->row();
    $artikel = $this->db->query("SELECT * FROM tb_produk WHERE id = ?", array($id_artikel))->row();
    $tabel_data = $this->db->query(
      "SELECT *, COALESCE(masuk, '-') as masuk, 
        COALESCE(keluar, '-') as keluar  FROM tb_kartu_stok 
                                      WHERE id_toko = ? AND id_produk = ? AND DATE(tanggal) BETWEEN ? AND ?",
      array($id_toko, $id_artikel, $tgl_awal, $tgl_akhir)
    )->result();
    // Determine s_awal and s_akhir
    $s_awal = !empty($tabel_data) ? $tabel_data[0]->stok : 0;
    $s_akhir = !empty($tabel_data) ? end($tabel_data)->sisa : 0;

    // Ensure we handle cases where there might be no data
    $data = [
      'toko' => isset($toko->nama_toko) ? $toko->nama_toko : 'Unknown',
      'artikel' => isset($artikel->nama_produk) ? $artikel->nama_produk : 'Unknown',
      'awal' => date('d-M-Y', strtotime($tgl_awal)),
      'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
      'tabel_data' => $tabel_data,
      's_awal' => $s_awal,
      's_akhir' => $s_akhir,
    ];

    echo json_encode($data);
  }
}
