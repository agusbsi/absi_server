<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Sales_Invoice extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    if ($this->session->userdata('status') != 'login') {
      redirect(base_url());
    }
  }
  public function index()
  {
    $data['title'] = 'Sales Invoice';
    $data['cust'] = $this->db->query("SELECT * from tb_customer ")->result();
    $data['list_toko'] = $this->db->query("SELECT * from tb_toko where status = 1")->result();
    $pt = $this->session->userdata('pt');
    if ($pt == 'VISTA MANDIRI GEMILANG') {
      $halaman = 'sales_invoice';
    } else {
      $halaman = 'sales_invoice_pkp';
    }
    $this->template->load('template/template', 'template_easy/' . $halaman, $data);
  }

  public function list_jual()
  {
    $id_toko = $this->input->get('id_toko');
    $tgl_awal  = $this->input->GET('tgl_awal');
    $tgl_akhir = $this->input->GET('tgl_akhir');
    $data = $this->db->query("SELECT tpd.*, tpd.id as id_detail, tpk.kode,tpk.nama_produk, tpk.satuan,SUM(tpd.qty) as total_qty, round((tpd.harga - (tpd.harga * tpd.diskon_toko / 100)),0) as harga_satuan, tc.kode_customer, tc.nama_cust from tb_penjualan_detail tpd
    join tb_penjualan tp on tpd.id_penjualan = tp.id
    join tb_produk tpk on tpd.id_produk = tpk.id
    join tb_toko tt on tp.id_toko = tt.id
    join tb_customer tc on tt.id_customer = tc.id
    where tp.id_toko = '$id_toko' and  date(tp.tanggal_penjualan) between '$tgl_awal' and '$tgl_akhir'
    GROUP BY tpk.kode ORDER BY tpk.kode ASC")->result();
    echo json_encode($data);
  }
  public function export_ea()
  {
    $pengguna = $this->session->userdata('nama_user');
    $faktur = preg_replace("/[^A-Za-z0-9]/", "", $this->input->post('faktur'));
    $pesanan  = $this->input->post('pesanan');
    $kode_pelanggan  = $this->input->post('kode_pelanggan');
    $pelanggan  = $this->input->post('pelanggan');
    $tgl_f = $this->input->post('tgl_faktur');
    $tgl_k  = $this->input->post('tgl_kirim');
    $tgl_faktur = date('d/m/Y', strtotime($tgl_f));
    $tgl_kirim = date('d/m/Y', strtotime($tgl_k));
    $deskripsi  = $this->input->post('deskripsi');
    $diskon  = str_replace(".", "", $this->input->post('diskon'));
    $kode      = $this->input->post('kode');
    $qty      = $this->input->post('qty');
    $harga      = str_replace(".", "", $this->input->post('harga'));
    $satuan      = $this->input->post('satuan');
    $jml      = count($kode);
    // Create a new Spreadsheet instance
    $spreadsheet = new Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();
    $worksheet->setTitle($faktur);
    $worksheet->getStyle('A1:AD1')->getFont()->setBold(true);
    $worksheet->setCellValue('A1', 'No. Faktur');
    $worksheet->setCellValue('B1', 'No. Pelanggan');
    $worksheet->setCellValue('C1', 'Tanggal');
    $worksheet->setCellValue('D1', 'Akun Piutang');
    $worksheet->setCellValue('E1', 'Deskripsi');
    $worksheet->setCellValue('F1', 'Nilai Tukar');
    $worksheet->setCellValue('G1', 'Nilai Pajak');
    $worksheet->setCellValue('H1', 'Diskon');
    $worksheet->setCellValue('I1', 'Prosentase Diskon');
    $worksheet->setCellValue('J1', 'Pengguna');
    $worksheet->setCellValue('K1', 'Syarat');
    $worksheet->setCellValue('L1', 'Kirim Ke');
    $worksheet->setCellValue('M1', 'Kirim Melalui');
    $worksheet->setCellValue('N1', 'Tgl. Kirim');
    $worksheet->setCellValue('O1', 'Penjual');
    $worksheet->setCellValue('P1', 'FOB');
    $worksheet->setCellValue('Q1', 'Rancangan');
    $worksheet->setCellValue('R1', 'Seri Pajak 1');
    $worksheet->setCellValue('S1', 'Seri Pajak 2');
    $worksheet->setCellValue('T1', 'Tgl. Faktur Pajak');
    $worksheet->setCellValue('U1', 'Termasuk Pajak');
    $worksheet->setCellValue('V1', 'No. Barang');
    $worksheet->setCellValue('W1', 'Qty');
    $worksheet->setCellValue('X1', 'Harga Satuan');
    $worksheet->setCellValue('Y1', 'Kode Pajak');
    $worksheet->setCellValue('Z1', 'Diskon');
    $worksheet->setCellValue('AA1', 'Satuan');
    $worksheet->setCellValue('AB1', 'Departemen');
    $worksheet->setCellValue('AC1', 'Proyek');
    $worksheet->setCellValue('AD1', 'Gudang');
    $row = 2;
    for ($i = 0; $i < $jml; $i++) {
      $worksheet->setCellValue('A' . $row, $faktur);
      $worksheet->setCellValue('B' . $row, $kode_pelanggan);
      $worksheet->setCellValue('C' . $row, $tgl_faktur);
      $worksheet->setCellValue('D' . $row, '1102.001');
      $worksheet->setCellValue('E' . $row, $deskripsi);
      $worksheet->setCellValue('F' . $row, '1');
      $worksheet->setCellValue('G' . $row, '1');
      $worksheet->setCellValue('H' . $row, $diskon);
      $worksheet->setCellValue('I' . $row, '');
      $worksheet->setCellValue('J' . $row, $pengguna);
      $worksheet->setCellValue('K' . $row, 'Net 30');
      $worksheet->setCellValue('L' . $row, $pelanggan);
      $worksheet->setCellValue('M' . $row, '');
      $worksheet->setCellValue('N' . $row, $tgl_kirim);
      $worksheet->setCellValue('O' . $row, '');
      $worksheet->setCellValue('P' . $row, '');
      $worksheet->setCellValue('Q' . $row, 'Sales Invoice');
      $worksheet->setCellValue('R' . $row, '');
      $worksheet->setCellValue('S' . $row, '');
      $worksheet->setCellValue('T' . $row, '');
      $worksheet->setCellValue('U' . $row, 'Yes');
      $worksheet->setCellValue('V' . $row, $kode[$i]);
      $worksheet->setCellValue('W' . $row, $qty[$i]);
      $worksheet->setCellValue('X' . $row, $harga[$i]);
      $worksheet->setCellValue('Y' . $row, 'P');
      $worksheet->setCellValue('Z' . $row, '0');
      $worksheet->setCellValue('AA' . $row, $satuan[$i]);
      $worksheet->setCellValue('AB' . $row, 'Non Department');
      $worksheet->setCellValue('AC' . $row, 'Non Project');
      $worksheet->setCellValue('AD' . $row, '51.1 GUD. KONSINYASI');
      $row++;
    }

    // Create Excel writer
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $faktur . '.xlsx"');
    ob_end_clean();
    $writer->save('php://output');
    exit();
  }

  // format selain vista
  public function cari_group()
  {
    $id_cust   = $this->input->get('id_cust');
    $tgl_awal  = $this->input->GET('tgl_awal');
    $tgl_akhir = $this->input->GET('tgl_akhir');
    $cust = $this->db->query("SELECT * from tb_customer where id = '$id_cust'")->row();
    $query = "SELECT tt.nama_toko, tt.gudang, tpk.kode, tpk.nama_produk, SUM(tpd.qty) as total,tpk.satuan, round((tpd.harga - (tpd.harga * tpd.diskon_toko / 100)),0) as harga_satuan
          FROM tb_penjualan_detail tpd 
          JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
          JOIN tb_produk tpk ON tpd.id_produk = tpk.id 
          JOIN tb_toko tt ON tp.id_toko = tt.id
          JOIN tb_customer tc ON tt.id_customer = tc.id
          WHERE date(tp.tanggal_penjualan) BETWEEN '$tgl_awal' AND '$tgl_akhir' AND tt.id_customer = '$id_cust'
          GROUP BY tt.nama_toko, tpd.id_produk 
          ORDER BY tt.nama_toko ASC, tpk.kode ASC";
    $result = $this->db->query($query)->result();

    $tabel_data = [];
    foreach ($result as $row) {
      $tabel_data[$row->nama_toko][] = [
        'kode' => $row->kode,
        'nama_produk' => $row->nama_produk,
        'total' => $row->total,
        'harga' => $row->harga_satuan,
        'satuan' => $row->satuan,
        'gudang'  => $row->gudang
      ];
    }

    $data = [
      'nama_cust' => $cust->nama_cust,
      'kode_cust' => $cust->kode_customer,
      'tabel_data' => $tabel_data
    ];
    echo json_encode($data);
  }
}
