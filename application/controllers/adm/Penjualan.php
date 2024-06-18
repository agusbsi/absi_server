<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    if ($this->session->userdata('status') != 'login') {
      redirect(base_url());
    }

    $this->load->model('M_spg');
    $this->load->model('M_produk');
  }
  public function index()
  {
    $tgl_awal = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');
    $data['title'] = 'Penjualan Barang';

    $data['list_penjualan'] = $this->db->query("SELECT tp.* , tk.nama_toko from tb_penjualan tp join tb_toko tk on tk.id = tp.id_toko where date(tp.created_at) between '$tgl_awal' and '$tgl_akhir'")->result();
    $this->template->load('template/template', 'adm/transaksi/penjualan.php', $data);
  }

  public function detail($id)
  {
    $data['title'] = 'Penjualan Barang';
    $data_permintaan = $this->db->query("SELECT tp.*, tt.nama_toko, tu.username from tb_penjualan tp join tb_toko tt on tt.id = tp.id_toko join tb_user tu on tu.id = tp.id_user where tp.id = '$id'")->row();
    $data['detail_penjualan'] = $this->db->query("SELECT * from tb_penjualan_detail tpd join tb_produk tp on tp.id = tpd.id_produk where tpd.id_penjualan = '$id'")->result();

    $data['no_penjualan'] = $id;
    $data['tanggal'] = $data_permintaan->tgl_penjualan;
    $data['nama_toko'] = $data_permintaan->nama_toko;
    $data['nama'] = $data_permintaan->username;
    $this->template->load('template/template', 'adm/transaksi/penjualan_detail', $data);
  }
  // Laporan Penjualan
  public function lap_artikel()
  {
    $data['title'] = 'Penjualan Artikel';
    $data['artikel'] = $this->db->query("SELECT * from tb_produk where status ='1'")->result();
    $this->template->load('template/template', 'adm/penjualan/lap_artikel', $data);
  }
  public function cari_artikel()
  {
    $id_artikel = $this->input->get('id_artikel');
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
    $data['toko'] = $this->db->query("SELECT * from tb_toko where status ='1'")->result();
    $this->template->load('template/template', 'adm/penjualan/lap_toko', $data);
  }
  public function cari_toko()
  {
    $id_toko = $this->input->get('id_toko');
    $tgl_awal = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');
    $summary = $this->db->query("SELECT * from tb_toko where id = '$id_toko'")->row();
    $tabel_data = $this->db->query("SELECT tpk.kode,tpk.nama_produk, SUM(tpd.qty) as total,
    tt.nama_toko from tb_penjualan_detail tpd 
    join tb_penjualan tp on tpd.id_penjualan = tp.id
    join tb_produk tpk on tpd.id_produk = tpk.id 
    join tb_toko tt on tp.id_toko = tt.id
    where tp.id_toko = '$id_toko'  and  date(tp.tanggal_penjualan) between '$tgl_awal' and '$tgl_akhir' group by tpd.id_produk order by SUM(tpd.qty) DESC")->result();

    $data = [
      'toko' => $summary->nama_toko,
      'awal' => date('d-M-Y', strtotime($tgl_awal)),
      'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
      'tabel_data' => $tabel_data
    ];
    echo json_encode($data);
  }
  public function lap_cust()
  {
    $data['title'] = 'Penjualan Customer';
    $data['cust'] = $this->db->query("SELECT * from tb_customer")->result();
    $this->template->load('template/template', 'adm/penjualan/lap_cust', $data);
  }
  public function cari_cust()
  {
    $id_cust = $this->input->get('id_cust');
    $tgl_awal = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');
    $summary = $this->db->query("SELECT * from tb_customer where id = '$id_cust'")->row();
    $tabel_data = $this->db->query("SELECT tpk.kode,tpk.nama_produk, SUM(tpd.qty) as total from tb_penjualan_detail tpd 
    join tb_penjualan tp on tpd.id_penjualan = tp.id
    join tb_produk tpk on tpd.id_produk = tpk.id 
    join tb_toko tt on tp.id_toko = tt.id
    join tb_customer tc on tt.id_customer = tc.id
    where tc.id = '$id_cust'  and  date(tp.tanggal_penjualan) between '$tgl_awal' and '$tgl_akhir' group by tpd.id_produk order by SUM(tpd.qty) DESC")->result();

    $data = [
      'cust' => $summary->nama_cust,
      'awal' => date('d-M-Y', strtotime($tgl_awal)),
      'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
      'tabel_data' => $tabel_data
    ];
    echo json_encode($data);
  }
  public function lap_area()
  {
    $data['title'] = 'Penjualan Area';
    $data['area'] = $this->db->query("SELECT * from tb_area")->result();
    $this->template->load('template/template', 'adm/penjualan/lap_area', $data);
  }
  public function cari_area()
  {
    $id_area = $this->input->get('id_area');
    $tgl_awal = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');
    $summary = $this->db->query("SELECT * from tb_area where id = '$id_area'")->row();
    $tabel_data = $this->db->query("SELECT tpk.kode,tpk.nama_produk, SUM(tpd.qty) as total from tb_penjualan_detail tpd 
    join tb_penjualan tp on tpd.id_penjualan = tp.id
    join tb_produk tpk on tpd.id_produk = tpk.id 
    join tb_toko tt on tp.id_toko = tt.id
    join tb_area_detail tad on tt.id = tad.id_toko
    join tb_area ta on tad.id_area = ta.id
    where ta.id = '$id_area'  and  date(tp.tanggal_penjualan) between '$tgl_awal' and '$tgl_akhir' group by tpd.id_produk order by SUM(tpd.qty) DESC")->result();

    $data = [
      'area' => $summary->area,
      'awal' => date('d-M-Y', strtotime($tgl_awal)),
      'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
      'tabel_data' => $tabel_data
    ];
    echo json_encode($data);
  }
  public function lap_periode()
  {
    $data['title'] = 'Penjualan Periode';
    $this->template->load('template/template', 'adm/penjualan/lap_periode', $data);
  }
  public function cari_periode()
  {
    $tgl_awal = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');
    $query = "
          SELECT tt.nama_toko, tpk.kode, tpk.nama_produk, SUM(tpd.qty) as total
          FROM tb_penjualan_detail tpd 
          JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
          JOIN tb_produk tpk ON tpd.id_produk = tpk.id 
          JOIN tb_toko tt ON tp.id_toko = tt.id
          WHERE date(tp.tanggal_penjualan) BETWEEN '$tgl_awal' AND '$tgl_akhir'
          GROUP BY tt.nama_toko, tpd.id_produk 
          ORDER BY tt.nama_toko, SUM(tpd.qty) DESC
      ";
    $result = $this->db->query($query)->result();

    $tabel_data = [];
    foreach ($result as $row) {
      $tabel_data[$row->nama_toko][] = [
        'kode' => $row->kode,
        'nama_produk' => $row->nama_produk,
        'total' => $row->total,
      ];
    }

    $data = [
      'awal' => date('d-M-Y', strtotime($tgl_awal)),
      'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
      'tabel_data' => $tabel_data
    ];
    echo json_encode($data);
  }
}
