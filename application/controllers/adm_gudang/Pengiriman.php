<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pengiriman extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "5" && $role != "16") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    // load base_url
    $this->load->helper('url');
    $this->load->model('M_adm_gudang');
  }
  // menampilkan pengiriman
  public function index()
  {
    $data['title'] = 'Pengiriman Barang';
    $tanggal = $this->input->post('tanggal');
    $kategori = $this->input->post('kategori');
    $data['kat'] = "";
    $data['tgl'] = "";
    if (!empty($kategori) && !empty($tanggal)) {
      list($awal, $akhir) = explode(' - ', $tanggal);
      $data['list'] = $this->db->query("
            SELECT tp.*, tt.nama_toko,tu.nama_user as leader
            FROM tb_pengiriman tp
            JOIN tb_toko tt ON tp.id_toko = tt.id
            join tb_user tu on tt.id_leader = tu.id
            WHERE tp.created_at >= ? AND tp.created_at <= ? 
            AND (tp.id LIKE ? OR tt.nama_toko LIKE ?)
        ", [$awal, $akhir, "%$kategori%", "%$kategori%"])->result();
      $data['kat'] = $kategori;
      $data['tgl'] = $tanggal;
    } else if (empty($kategori) && !empty($tanggal)) {
      list($awal, $akhir) = explode(' - ', $tanggal);
      $data['list'] = $this->db->query("
      SELECT tp.*, tt.nama_toko,tu.nama_user as leader
      FROM tb_pengiriman tp
      JOIN tb_toko tt ON tp.id_toko = tt.id
      join tb_user tu on tt.id_leader = tu.id
      WHERE tp.created_at >= ? AND tp.created_at <= ?
  ", [$awal, $akhir])->result();
      $data['tgl'] = $tanggal;
    } else if (!empty($kategori) && empty($tanggal)) {
      $data['list'] = $this->db->query("
      SELECT tp.*, tt.nama_toko, tu.nama_user as leader
      FROM tb_pengiriman tp
      JOIN tb_toko tt ON tp.id_toko = tt.id
      join tb_user tu on tt.id_leader = tu.id
      AND (tp.id LIKE ? OR tt.nama_toko LIKE ?)
  ", ["%$kategori%", "%$kategori%"])->result();
      $data['kat'] = $kategori;
    } else {
      $data['list'] = $this->db->query("SELECT tp.*, tt.nama_toko, tu.nama_user as leader from tb_pengiriman tp
      join tb_toko tt on tp.id_toko = tt.id
      join tb_user tu on tt.id_leader = tu.id
      order by tp.id desc LIMIT 500")->result();
    }
    $data['list_po'] = $this->db->query("SELECT tp.*, tt.nama_toko from tb_pengiriman tp
    join tb_toko tt on tp.id_toko = tt.id
    where tp.status = 1
    order by tp.id desc ")->result();
    $this->template->load('template/template', 'adm_gudang/pengiriman/lihat_data', $data);
  }

  // menampilkan form surat jalan/detail
  public function detail_p($no_pengiriman)
  {
    $data['title'] = 'Pengiriman Barang';
    $data['pengiriman'] = $this->db->query("SELECT tp.*,tt.id as id_toko, tt.nama_toko,tt.alamat, tt.telp,tu.nama_user,tk.nama_user as spg from tb_pengiriman tp
    join tb_toko tt on tp.id_toko = tt.id
    join tb_user tu on tp.id_user = tu.id
    join tb_user tk on tt.id_spg = tk.id
    where tp.id = '$no_pengiriman'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tpk.kode, tpk.nama_produk, tpk.satuan from tb_pengiriman_detail tpd
    join tb_produk tpk on tpd.id_produk = tpk.id
    where tpd.id_pengiriman = '$no_pengiriman' and tpd.qty != '0'")->result();
    $this->template->load('template/template', 'adm_gudang/pengiriman/detail', $data);
  }
  // print surat jalan
  public function detail_print($no_pengiriman)
  {
    $data['title'] = 'Pengiriman Barang';
    $data['pengiriman'] = $this->db->query("SELECT tp.*,tt.id as id_toko, tt.nama_toko,tt.alamat, tt.telp,tu.nama_user,tk.nama_user as spg from tb_pengiriman tp
      join tb_toko tt on tp.id_toko = tt.id
      join tb_user tu on tp.id_user = tu.id
      join tb_user tk on tt.id_spg = tk.id
      where tp.id = '$no_pengiriman'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tpk.kode, tpk.nama_produk, tpk.satuan from tb_pengiriman_detail tpd
    join tb_produk tpk on tpd.id_produk = tpk.id
    where tpd.id_pengiriman = '$no_pengiriman' and tpd.qty != '0'")->result();
    $this->load->view('adm_gudang/pengiriman/detail_print', $data);
  }
  // export ke Easy Accounting all
  public function export_ea_all()
  {
    $name_user = $this->session->userdata('nama_user');
    $id_kirim_all = $this->input->post('id_kirim_all');
    $gudang = $this->input->post('gudang');
    $tanggal = $this->input->post('tanggal_all');

    // Create a new Spreadsheet instance
    $spreadsheet = new Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();
    $worksheet->setTitle('Export MultiData PO');
    $worksheet->getStyle('A1:J1')->getFont()->setBold(true);
    $worksheet->setCellValue('A1', 'No. Transfer');
    $worksheet->setCellValue('B1', 'Tanggal');
    $worksheet->setCellValue('C1', 'Deskripsi');
    $worksheet->setCellValue('D1', 'Gudang Asal');
    $worksheet->setCellValue('E1', 'Gudang Tujuan');
    $worksheet->setCellValue('F1', 'Template');
    $worksheet->setCellValue('G1', 'No. Barang');
    $worksheet->setCellValue('H1', 'Kuantitas');
    $worksheet->setCellValue('I1', 'Unit');
    $worksheet->setCellValue('J1', 'User');

    $row = 2; // Start from the second row

    foreach ($id_kirim_all as $id_kirim) {
      $query = $this->db->query("SELECT tpd.*, tp.kode,tp.satuan from tb_pengiriman_detail tpd
          join tb_produk tp on tpd.id_produk = tp.id
          WHERE tpd.id_pengiriman = '$id_kirim'");
      $kirim = $this->db->query("SELECT tp.*, tt.nama_toko from tb_pengiriman tp
      join tb_toko tt on tp.id_toko = tt.id 
      where tp.id = '$id_kirim'")->row();
      if ($gudang == "PASIFIK") {
        $gudangTujuan = "51.4 GUD. KONSI PASIFIK";
      } else if ($gudang == "TOKO") {
        $gudangTujuan = $kirim->nama_toko;
      } else {
        $gudangTujuan = "51.1 GUD. KONSINYASI";
      }

      if ($query->num_rows() > 0) {
        $detail = $query->result();
        $tanggalkirim = new DateTime($tanggal);
        $tanggalkirimFormat = $tanggalkirim->format('d/m/Y');

        foreach ($detail as $data) {
          // Set values for each row
          $worksheet->setCellValue('A' . $row, $id_kirim);
          $worksheet->setCellValue('B' . $row, $tanggalkirimFormat);
          $worksheet->setCellValue('C' . $row, $kirim->nama_toko . " (" . $kirim->id_permintaan . ") ");
          $worksheet->setCellValue('D' . $row, "91 GUD. PREPEDAN");
          $worksheet->setCellValue('E' . $row, $gudangTujuan);
          $worksheet->setCellValue('F' . $row, "SJ Konsinyasi");
          $worksheet->setCellValue('G' . $row, $data->kode);
          $worksheet->setCellValue('H' . $row, $data->qty);
          $worksheet->setCellValue('I' . $row, $data->satuan);
          $worksheet->setCellValue('J' . $row, $name_user);
          $row++;
        }
      }
    }

    // Create Excel writer
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Export_Multiple_PO.xlsx"');

    ob_end_clean();
    $writer->save('php://output');
    exit();
  }

  // export ke Easy Accounting
  public function export_ea()
  {
    $name_user  = $this->session->userdata('nama_user');
    $id_kirim  = $this->input->post('id_kirim');
    $id_po  = $this->input->post('id_po');
    $toko  = $this->input->post('toko');
    $tanggal  = $this->input->post('tanggal_exp');
    $no_transfer  = $this->input->post('no_transfer');
    // Get invoice data from the model
    $query = $this->db->query("SELECT tpd.*, tp.kode,tp.satuan from tb_pengiriman_detail tpd
    join tb_produk tp on tpd.id_produk = tp.id
    WHERE tpd.id_pengiriman = '$id_kirim'");
    if ($query->num_rows() > 0) {
      $detail = $query->result();
      $tanggalkirim = new DateTime($tanggal);
      $tanggalkirimFormat = $tanggalkirim->format('d/m/Y');
      // Create a new Spreadsheet instance
      $spreadsheet = new Spreadsheet();
      $worksheet = $spreadsheet->getActiveSheet();
      $worksheet->setTitle($no_transfer);
      $worksheet->getStyle('A1:J1')->getFont()->setBold(true);
      $worksheet->setCellValue('A1', 'No. Transfer');
      $worksheet->setCellValue('B1', 'Tanggal');
      $worksheet->setCellValue('C1', 'Deskripsi');
      $worksheet->setCellValue('D1', 'Gudang Asal');
      $worksheet->setCellValue('E1', 'Gudang Tujuan');
      $worksheet->setCellValue('F1', 'Template');
      $worksheet->setCellValue('G1', 'No. Barang');
      $worksheet->setCellValue('H1', 'Kuantitas');
      $worksheet->setCellValue('I1', 'Unit');
      $worksheet->setCellValue('J1', 'User');
      $row = 2; // Start from the second row
      foreach ($detail as $data) {
        // Set values for each row
        $worksheet->setCellValue('A' . $row, $no_transfer);
        $worksheet->setCellValue('B' . $row, $tanggalkirimFormat);
        $worksheet->setCellValue('C' . $row, $toko . "  (" . $id_po . " ) " . "No : " . $id_kirim);
        $worksheet->setCellValue('D' . $row, "91 GUD. PREPEDAN");
        $worksheet->setCellValue('E' . $row, "51.1 GUD. KONSINYASI");
        $worksheet->setCellValue('F' . $row, "SJ Konsinyasi");
        $worksheet->setCellValue('G' . $row, $data->kode);
        $worksheet->setCellValue('H' . $row, $data->qty);
        $worksheet->setCellValue('I' . $row, $data->satuan);
        $worksheet->setCellValue('J' . $row, $name_user);
        $row++;
      }

      // Create Excel writer
      $writer = new Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $no_transfer . '.xlsx"');

      ob_end_clean();
      $writer->save('php://output');
      exit();
    }
  }
}
