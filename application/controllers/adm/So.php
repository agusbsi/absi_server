<?php
defined('BASEPATH') or exit('No direct script access allowed');

class So extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    // if ($role != "1") {
    //   tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
    //   redirect(base_url(''));
    // }
    $this->load->model('M_admin');
    $this->load->model('M_support');
  }
  public function index()
  {
    $id_spv = $this->session->userdata('id');
    $data['title'] = 'Management Stock Opname';
    $data['list_data'] = $this->db->query("SELECT tb_toko.*, date(tb_toko.tgl_so) as tgl_so, tb_user.nama_user FROM tb_toko 
    left JOIN tb_user ON tb_toko.id_spg = tb_user.id 
    WHERE tb_toko.status = '1'  ")->result();
    $data['list_spv'] = $this->db->query("SELECT * FROM tb_user WHERE role = 2")->result();
    $data['id_toko'] = $this->M_support->kode_toko();
    $this->template->load('template/template', 'adm/stokopname/index', $data);
  }

  // proses so untuk adjust stok
  public function detail($toko)
  {
    $data['title'] = 'Management Stock Opname';
    $data['so'] = $this->db->query("SELECT so.*, tt.nama_toko, tt.alamat, tt.telp, tu.nama_user from tb_so so
    join tb_toko tt on so.id_toko = tt.id
    join tb_user tu on so.id_user = tu.id
    where so.id_toko='$toko' order by so.id desc limit 1")->row();
    $id_so = $data['so']->id;
    $data['list_data'] = $this->db->query("SELECT ts.*,tp.kode,tp.satuan, tp.nama_produk from tb_stok ts
    join tb_produk tp on ts.id_produk = tp.id
    where ts.id_toko = '$toko'")->result();
    $this->template->load('template/template', 'adm/stokopname/detail', $data);
  }

  // proses approve so
  public function approve()
  {
    $id           = $this->input->post('id_so');
    $id_produk    = $this->input->post('id_produk');
    $id_toko      = $this->input->post('id_toko');
    $id_detail    = $this->input->post('id_detail');
    $hasil_so     = $this->input->post('hasil_so');
    $jumlah       = count($id_produk);

    $this->db->trans_start();
    for ($i = 0; $i < $jumlah; $i++) {
      $d_id_produk  = $id_produk[$i];
      $d_id_detail  = $id_detail[$i];
      $d_qty        = $hasil_so[$i];

      $data_detail = array(
        'qty' => $d_qty,
        'qty_awal' => $d_qty,
      );
      $where_stok = array(
        'id_produk' => $d_id_produk,
        'id_toko'   => $id_toko,
        'status'    => '1'
      );
      // update qty akhir di stok toko
      $this->db->update('tb_stok', $data_detail, $where_stok);
      $this->db->trans_complete();
    }
    tampil_alert('success', 'Berhasil', 'Data Berhasil di Approve');
    redirect(base_url('adm/So'));
  }
  // download pdf
  public function pdf($toko)
  {
    // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
    $this->load->library('pdfgenerator');
    // title dari pdf
    $data['title_pdf'] = 'List Artikel Stok Opname';
    // filename dari pdf ketika didownload
    $file_pdf = 'List_Artikel_Stok_Opname';
    // setting paper
    $paper = 'A4';
    //orientasi paper potrait / landscape 
    $orientation = "portrait";
    // menampilkan Data Toko
    $data['data_toko']  = $this->db->query("SELECT tb_toko.*, tb_user.nama_user from tb_toko 
        join tb_user on tb_toko.id_spg = tb_user.id
        where tb_toko.id ='$toko'")->row();
    // menampilkan Data Stok di toko
    $data['stok'] = $this->db->query("SELECT ts.*, tp.nama_produk, tp.kode, tp.satuan from tb_stok ts
        join tb_produk tp on ts.id_produk = tp.id
        where ts.id_toko = '$toko' and ts.qty != '0'")->result();
    $html = $this->load->view('adm/stokopname/print_so', $data, true);
    // run dompdf
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
  // download pdf
  public function hasil_so($toko)
  {

    // so terbaru
    $id_so = $this->db->query("SELECT id from tb_so where id_toko = '$toko' order by id desc limit 1")->row();
    // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
    $this->load->library('pdfgenerator');
    // title dari pdf
    $data['title_pdf'] = 'Hasil Stok Opname';
    // filename dari pdf ketika didownload
    $file_pdf = 'Hasil_Stok_Opname';
    // setting paper
    $paper = 'A4';
    //orientasi paper potrait / landscape 
    $orientation = "portrait";
    // menampilkan Data Toko
    $data['data_toko']  = $this->db->query("SELECT tb_toko.*, tb_user.nama_user from tb_toko 
      join tb_user on tb_toko.id_spg = tb_user.id
      where tb_toko.id ='$toko'")->row();
    // menampilkan Hasil SO terbaru
    $data['hasil_so'] = $this->db->query("SELECT tsd.*, tp.kode, tp.nama_produk, tp.satuan, tsd.hasil_so - tsd.qty_akhir as selisih from tb_so_detail tsd
      join tb_so ts on tsd.id_so = ts.id
      join tb_produk tp on tsd.id_produk = tp.id
      where ts.id_toko = '$toko' and tsd.id_so = '$id_so->id'")->result();
    $data['so_terbaru'] = $this->db->query("SELECT * from tb_so where id_toko = '$toko' order by id desc limit 1")->row();
    $html = $this->load->view('adm/stokopname/print_hasil_so', $data, true);
    // run dompdf
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }

  // RIWAYAT ASET
  public function histori_aset()
  {
    $data['title'] = 'Histori Aset';

    $id   = $this->session->userdata('id');
    $role = $this->session->userdata('role');

    // Rentang bulan yang mau ditampilkan:
    // dari 2025-01-01 s.d. H-1 bulan ini (pakai batas < first day of this month)
    $startDate = date('Y-m-d', strtotime('2024-12-31 +1 day')); // 2025-01-01
    $endDate   = date('Y-m-01');                                 // first day of current month

    // Filter role
    $roleWhere = '';
    $binds     = [$startDate, $endDate];

    if ($role == 2) {
      $roleWhere = ' AND tt.id_spv = ?';
      $binds[]   = $id;
    } else if ($role == 3) {
      $roleWhere = ' AND tt.id_leader = ?';
      $binds[]   = $id;
    }

    $sql = "
        SELECT
            tt.id                     AS id_toko,
            tt.nama_toko,
            tt.alamat,
            COALESCE(ta.total_aset, 0) AS total_aset,
            ts.periode_ym,
            ts.tanggal_terakhir       AS tanggal
        FROM (
            /* Ambil SATU baris per toko per bulan (pakai tanggal terakhir di bulan tsb) */
            SELECT
                id_toko,
                DATE_FORMAT(tanggal, '%Y-%m')      AS periode_ym,
                MAX(tanggal)                       AS tanggal_terakhir
            FROM tb_aset_spg
            WHERE tanggal >= ? AND tanggal < ?
            GROUP BY id_toko, DATE_FORMAT(tanggal, '%Y-%m')
        ) ts
        JOIN tb_toko tt
          ON tt.id = ts.id_toko
        LEFT JOIN (
            SELECT id_toko, SUM(qty) AS total_aset
            FROM tb_aset_toko
            GROUP BY id_toko
        ) ta
          ON ta.id_toko = tt.id
        WHERE 1=1
        {$roleWhere}
        /* Urut: bulan terbaru dulu, lalu nama toko A-Z */
        ORDER BY ts.periode_ym DESC, tt.nama_toko ASC
    ";

    $data['list_so'] = $this->db->query($sql, $binds)->result();
    $this->template->load('template/template', 'adm/stokopname/histori_aset', $data);
  }


  // detail aset
  public function detail_aset($id, $bulan)
  {
    $data['title'] = 'Detail Aset';
    $data['toko'] = $this->db->query("SELECT tt.*, tu.nama_user as spv, tuu.nama_user as leader, ts.nama_user as spg FROM tb_toko tt
    join tb_user tu on tt.id_spv = tu.id
    join tb_user tuu on tt.id_leader = tuu.id
    join tb_user ts on tt.id_spg = ts.id
    WHERE tt.id ='$id'")->row();
    $data['list'] = $this->db->query("SELECT ts.*, ta.aset, ta.kode,ta.unit from tb_aset_toko ts
    join tb_aset_master ta on ts.id_aset = ta.id
    where ts.id_toko = '$id' ")->result();
    $data['aset_spg'] = $this->db->query("
    SELECT ts.*, tat.no_aset, tam.aset
    FROM tb_aset_spg ts
    JOIN tb_aset_toko tat ON ts.id_aset = tat.id
    JOIN tb_aset_master tam ON tat.id_aset = tam.id
    WHERE ts.id_toko = '$id'
      AND DATE_FORMAT(ts.tanggal, '%Y-%m') = '$bulan'")->result();
    $data['aset'] = $this->db->query("SELECT * from tb_aset_master order by id asc")->result();
    $this->template->load('template/template', 'hrd/aset/detail', $data);
  }
}
