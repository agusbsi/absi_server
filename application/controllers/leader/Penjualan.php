<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "3") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }

  //  fungsi lihat data
  public function index()
  {
    $id_leader = $this->session->userdata('id');
    $data['title'] = 'Penjualan';
    $data['list_data'] = $this->db->query("SELECT tp.*, tk.nama_toko from tb_penjualan tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        where tk.id_leader = '$id_leader'
        order by tp.id desc")->result();
    $this->template->load('template/template', 'leader/penjualan/lihat_data', $data);
  }
  // detail permintaan
  public function detail_p($id_jual)
  {

    $data['title'] = 'Penjualan';
    $data['penjualan'] = $this->db->query("SELECT tp.*, tk.nama_toko, tk.alamat, tk.telp, tu.nama_user as spg from tb_penjualan tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        JOIN tb_user tu on tp.id_user = tu.id
        where tp.id = '$id_jual'")->result();
    $data['detail_penjualan'] = $this->db->query("SELECT td.*,tpk.kode as kode_produk, tpk.nama_produk, tpk.satuan  from tb_penjualan_detail td
        JOIN tb_penjualan tp on td.id_penjualan = tp.id
        JOIN tb_produk tpk on td.id_produk = tpk.id
        where td.id_penjualan = '$id_jual'")->result();


    $this->template->load('template/template', 'leader/penjualan/detail', $data);
  }

  public function lap_artikel()
  {
    $data['title'] = 'Penjualan Artikel';
    $id_leader = $this->session->userdata('id');
    $data['artikel'] = $this->db->query("SELECT tp.* from tb_stok ts
    JOIN tb_produk tp on tp.id = ts.id_produk
    JOIN tb_toko tt on ts.id_toko = tt.id 
    where ts.status ='1' AND tt.id_leader = '$id_leader' GROUP BY ts.id_produk")->result();
    $this->template->load('template/template', 'leader/penjualan/lap_artikel', $data);
  }
  public function cari_artikel()
  {
    $id_artikel = $this->input->get('id_artikel');
    $id_leader = $this->session->userdata('id');
    $tgl_awal = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');
    $summary = $this->db->query("SELECT * from tb_produk where id = '$id_artikel'")->row();
    $tabel_data = $this->db->query("
          SELECT 
              tt.nama_toko, 
              SUM(tpd.qty) as total
          FROM 
              tb_penjualan_detail tpd 
              JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
              JOIN tb_toko tt ON tp.id_toko = tt.id
          WHERE 
              tpd.id_produk = '$id_artikel'  
              AND DATE(tp.tanggal_penjualan) BETWEEN '$tgl_awal' AND '$tgl_akhir'
              AND tt.id_leader = '$id_leader'
          GROUP BY 
              tt.id
          ORDER BY 
              SUM(tpd.qty) DESC
      ")->result();

    $data = [
      'kode' => $summary->kode,
      'artikel' => $summary->nama_produk,
      'awal' => date('d-M-Y', strtotime($tgl_awal)),
      'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
      'tabel_data' => $tabel_data
    ];
    echo json_encode($data);
  }
  public function lap_toko()
  {
    $data['title'] = 'Penjualan Toko';
    $id_leader = $this->session->userdata('id');
    $data['toko'] = $this->db->query("SELECT * from tb_toko where status ='1' AND id_leader = '$id_leader'")->result();
    $this->template->load('template/template', 'leader/penjualan/lap_toko', $data);
  }
  public function cari_toko()
  {
    $id_toko = $this->input->get('id_toko');
    $tgl_awal = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');
    $summary = $this->db->query("SELECT * from tb_toko where id = '$id_toko'")->row();
    $tabel_data = $this->db->query("SELECT tpk.kode, tpk.nama_produk, COALESCE(SUM(tpd.qty), 0) as total, COALESCE(ts.qty_awal, 0) as stok
    FROM tb_stok ts
    LEFT JOIN tb_produk tpk ON ts.id_produk = tpk.id
    LEFT JOIN (
        SELECT tpd.id_produk, SUM(tpd.qty) as qty
        FROM tb_penjualan_detail tpd
        JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
        WHERE tp.id_toko = '$id_toko' AND DATE(tp.tanggal_penjualan) BETWEEN '$tgl_awal' AND '$tgl_akhir'
        GROUP BY tpd.id_produk
    ) tpd ON tpk.id = tpd.id_produk
    WHERE ts.id_toko = '$id_toko'
    GROUP BY tpk.id
    ORDER BY COALESCE(SUM(tpd.qty), 0) DESC")->result();
    $data = [
      'toko' => $summary->nama_toko,
      'awal' => date('d-M-Y', strtotime($tgl_awal)),
      'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
      'tabel_data' => $tabel_data
    ];
    echo json_encode($data);
  }
}
