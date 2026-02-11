<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Permintaan extends CI_Controller
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
    $data['title'] = 'Permintaan Barang';
    $this->template->load('template/template', 'adm/transaksi/permintaan.php', $data);
  }
  public function get_po()
  {
    $search_nomor = $this->input->post('search_nomor');
    $search_nama_toko = $this->input->post('search_nama_toko');
    $search_status = $this->input->post('search_status');
    $search_periode = $this->input->post('search_periode');
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $this->db->select('tp.*, tt.nama_toko');
    $this->db->from('tb_permintaan tp');
    $this->db->join('tb_toko tt', 'tp.id_toko = tt.id');
    if (!empty($search_periode)) {
      list($start_date, $end_date) = explode(' - ', $search_periode);
      $this->db->where('tp.created_at >=', $start_date . ' 00:00:00');
      $this->db->where('tp.created_at <=', $end_date . ' 23:59:59');
    }
    if (!empty($search_nomor)) {
      $this->db->like('tp.id', $search_nomor);
    }
    if (!empty($search_status)) {
      $this->db->like('tp.status', $search_status);
    }
    if (!empty($search_nama_toko)) {
      $this->db->like('tt.nama_toko', $search_nama_toko);
    }
    $this->db->order_by('tp.created_at', 'desc');
    $query_total = clone $this->db;
    $total_data = $query_total->count_all_results('', FALSE);
    $this->db->limit($limit, $start);
    $query = $this->db->get();
    $data = $query->result();
    $output_data = array();
    $no = $start + 1;
    foreach ($data as $stok) {
      $row = array();
      $row['nomor_urut'] = $no++;
      $row['nomor'] = $stok->id;
      $row['nama_toko'] = $stok->nama_toko;
      ob_start();
      status_permintaan($stok->status);
      $row['status'] = ob_get_clean();
      $row['tgl_dibuat'] = date('d-M-Y H:i:s', strtotime($stok->created_at));
      $row['menu'] = $stok->id;
      $output_data[] = $row;
    }
    $this->db->select('tp.*, tt.nama_toko');
    $this->db->from('tb_permintaan tp');
    $this->db->join('tb_toko tt', 'tp.id_toko = tt.id');

    if (!empty($search_periode)) {
      list($start_date, $end_date) = explode(' - ', $search_periode);
      $this->db->where('tp.created_at >=', $start_date . ' 00:00:00');
      $this->db->where('tp.created_at <=', $end_date . ' 23:59:59');
    }

    if (!empty($search_nomor)) {
      $this->db->like('tp.id', $search_nomor);
    }
    if (!empty($search_status)) {
      $this->db->like('tp.status', $search_status);
    }

    if (!empty($search_nama_toko)) {
      $this->db->like('tt.nama_toko', $search_nama_toko);
    }

    $total_filtered = $this->db->count_all_results();
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $total_data,
      "recordsFiltered" => $total_filtered,
      "data" => $output_data
    );
    echo json_encode($output);
  }
  public function detail($id)
  {
    $data['title'] = 'Permintaan Barang';
    $data['permintaan'] = $this->db->query("SELECT tp.*, tt.nama_toko,tt.alamat, tu.username as spg from tb_permintaan tp join tb_toko tt on tt.id = tp.id_toko join tb_user tu on tu.id = tp.id_user where tp.id = '$id'")->row();
    $data['detail'] = $this->db->query("SELECT * from tb_permintaan_detail tpd join tb_produk tp on tp.id = tpd.id_produk where tpd.id_permintaan = '$id'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_po_histori where id_po = '$id'")->result();
    $this->template->load('template/template', 'adm/transaksi/permintaan_detail', $data);
  }

  public function export_excel($id)
  {
    // Get data
    $permintaan = $this->db->query("SELECT tp.*, tt.nama_toko, tt.alamat, tu.username as spg from tb_permintaan tp join tb_toko tt on tt.id = tp.id_toko join tb_user tu on tu.id = tp.id_user where tp.id = '$id'")->row();
    $detail = $this->db->query("SELECT * from tb_permintaan_detail tpd join tb_produk tp on tp.id = tpd.id_produk where tpd.id_permintaan = '$id'")->result();

    // Get status text
    $status_text = $this->get_status_text($permintaan->status);

    // Create new Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set column widths
    $sheet->getColumnDimension('A')->setWidth(5);
    $sheet->getColumnDimension('B')->setWidth(20);
    $sheet->getColumnDimension('C')->setWidth(40);
    $sheet->getColumnDimension('D')->setWidth(12);
    $sheet->getColumnDimension('E')->setWidth(12);
    $sheet->getColumnDimension('F')->setWidth(30);

    // Header section
    $row = 1;

    // Title
    $sheet->mergeCells('A' . $row . ':F' . $row);
    $sheet->setCellValue('A' . $row, 'DETAIL PERMINTAAN BARANG');
    $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $row++;

    $row++; // Skip a row

    // Info section
    $sheet->setCellValue('A' . $row, 'No. Permintaan');
    $sheet->setCellValue('B' . $row, ': ' . $permintaan->id);
    $sheet->getStyle('A' . $row)->getFont()->setBold(true);
    $row++;

    $sheet->setCellValue('A' . $row, 'Nama Toko');
    $sheet->setCellValue('B' . $row, ': ' . $permintaan->nama_toko);
    $sheet->getStyle('A' . $row)->getFont()->setBold(true);
    $row++;

    $sheet->setCellValue('A' . $row, 'Tanggal');
    $sheet->setCellValue('B' . $row, ': ' . date('d-M-Y H:i:s', strtotime($permintaan->created_at)));
    $sheet->getStyle('A' . $row)->getFont()->setBold(true);
    $row++;

    $sheet->setCellValue('A' . $row, 'Status');
    $sheet->setCellValue('B' . $row, ': ' . $status_text);
    $sheet->getStyle('A' . $row)->getFont()->setBold(true);
    $row++;

    $sheet->setCellValue('A' . $row, 'Nama SPG');
    $sheet->setCellValue('B' . $row, ': ' . $permintaan->spg);
    $sheet->getStyle('A' . $row)->getFont()->setBold(true);
    $row++;

    $sheet->setCellValue('A' . $row, 'Alamat Toko');
    $sheet->setCellValue('B' . $row, ': ' . $permintaan->alamat);
    $sheet->getStyle('A' . $row)->getFont()->setBold(true);
    $row++;

    $row++; // Skip a row

    // Table header
    $sheet->setCellValue('A' . $row, 'No');
    $sheet->setCellValue('B' . $row, 'Kode Artikel');
    $sheet->setCellValue('C' . $row, 'Nama Artikel');
    $sheet->setCellValue('D' . $row, 'Qty Minta');
    $sheet->setCellValue('E' . $row, 'Qty ACC');
    $sheet->setCellValue('F' . $row, 'Keterangan');

    // Style header
    $headerRange = 'A' . $row . ':F' . $row;
    $sheet->getStyle($headerRange)->applyFromArray([
      'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4472C4']
      ],
      'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
      'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
      ]
    ]);
    $row++;

    // Table data
    $no = 1;
    $t_minta = 0;
    $t_acc = 0;
    $startDataRow = $row;

    foreach ($detail as $d) {
      $sheet->setCellValue('A' . $row, $no);
      $sheet->setCellValue('B' . $row, $d->kode);
      $sheet->setCellValue('C' . $row, $d->nama_produk);
      $sheet->setCellValue('D' . $row, $d->qty);
      $sheet->setCellValue('E' . $row, $d->qty_acc);
      $sheet->setCellValue('F' . $row, $d->keterangan);

      // Alignment
      $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      $t_minta += $d->qty;
      $t_acc += $d->qty_acc;
      $no++;
      $row++;
    }

    // Total row
    $sheet->mergeCells('A' . $row . ':C' . $row);
    $sheet->setCellValue('A' . $row, 'Total');
    $sheet->setCellValue('D' . $row, $t_minta);
    $sheet->setCellValue('E' . $row, $t_acc);
    $sheet->setCellValue('F' . $row, '');

    // Style total row
    $sheet->getStyle('A' . $row . ':F' . $row)->getFont()->setBold(true);
    $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Apply borders to data range
    $dataRange = 'A' . $startDataRow . ':F' . $row;
    $sheet->getStyle($dataRange)->applyFromArray([
      'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
      ]
    ]);

    // Generate filename
    $filename = $permintaan->id  . '.xlsx';

    // Set headers and output
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    ob_end_clean();
    $writer->save('php://output');
    exit();
  }

  private function get_status_text($id)
  {
    $status_map = [
      0 => 'Diproses Leader',
      1 => 'Diproses MV',
      2 => 'Disetujui',
      3 => 'Disiapkan',
      4 => 'Dikirim',
      6 => 'Selesai',
      7 => 'Ditunda',
      5 => 'Ditolak'
    ];

    return isset($status_map[$id]) ? $status_map[$id] : 'Ditolak';
  }
}
