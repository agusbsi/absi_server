<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Produk extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "1" && $role != "6" && $role != "8" && $role != "15") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_admin');
  }

  //   halaman utama
  public function index()
  {
    $data['title'] = 'Produk';
    $data['list_data'] = $this->db->query("SELECT * from tb_produk order by id DESC")->result();
    $this->template->load('template/template', 'adm/produk/lihat_data', $data);
  }

  // hapus
  function hapus($id)
  {
    $where = array('id' => $id);
    $data = array(
      'deleted_at' => date('Y-m-d H:i:s'),
      'status' => 0,
    );
    $this->db->update('tb_produk', $data, $where);
    tampil_alert('success', 'BERHASIL', 'artikel berhasil dinonaktifkan');
    redirect('adm/Produk');
  }

  public function update_status()
  {
    header('Content-Type: application/json');

    // Ambil data dari request
    $json_data = json_decode(file_get_contents('php://input'), true);

    if (!isset($json_data['ids']) || !isset($json_data['status'])) {
      http_response_code(400);
      echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
      die();
    }

    $ids = $json_data['ids']; // Array ID produk
    $status = $json_data['status']; // 1 = aktif, 0 = nonaktif

    // Perbarui status di database
    $this->db->where_in('id', $ids);
    $update = $this->db->update('tb_produk', [
      'status' => $status,
      'deleted_at' => ($status == 0 ? date('Y-m-d H:i:s') : NULL)
    ]);

    if ($update) {
      echo json_encode(['status' => 'success', 'message' => 'Status berhasil diperbarui']);
    } else {
      http_response_code(500);
      echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui status']);
    }
    die();
  }

  // fungsi tambah produk
  public function proses_tambah()
  {
    $id_user = $this->session->userdata('id');
    $kode     = $this->input->post('kode');
    $nama     = $this->input->post('nama');
    $satuan   = $this->input->post('satuan');
    $packing   = $this->input->post('packing');
    $brand   = $this->input->post('brand');
    $deskripsi = $this->input->post('deskripsi');
    $harga1 = $this->input->post('harga_jawa');
    $harga2 = $this->input->post('harga_indo');
    $sp = $this->input->post('sp');
    $data = array(
      'kode'      => $kode,
      'nama_produk' => $nama,
      'satuan'    => $satuan,
      'packing'    => $packing,
      'brand'    => $brand,
      'deskripsi' => $deskripsi,
      'harga_jawa' => preg_replace('/[^0-9]/', '', $harga1),
      'harga_indobarat' => preg_replace('/[^0-9]/', '', $harga2),
      'sp' => preg_replace('/[^0-9]/', '', $sp),
      'status'    => "1",
      'id_user'       => $id_user
    );
    $cek = $this->db->query("SELECT * FROM tb_produk WHERE kode = '$kode'")->num_rows();
    if ($cek > 0) {
      tampil_alert('info', 'KODE SUDAH ADA', 'Kode artikel ' . $kode . ' sudah ada, harap diganti');
      redirect(base_url('adm/produk/'));
    } else {
      $this->db->insert('tb_produk', $data);
      tampil_alert('success', 'BERHASIL', 'Kode artikel ' . $kode . ' berhasil ditambahkan');
      redirect(base_url('adm/produk'));
    }
  }

  // Proses update
  public function proses_update()
  {
    $id_user = $this->session->userdata('id');
    $id = $this->input->post('id');
    $kode_baru = $this->input->post('kode');
    $kode_lama = $this->db->query("SELECT kode FROM tb_produk WHERE id = '$id'")->row()->kode;
    $nama = $this->input->post('nama_produk');
    $satuan = $this->input->post('satuan');
    $packing = $this->input->post('packing');
    $brand = $this->input->post('brand');
    $harga_jawa = preg_replace('/[^0-9]/', '', $this->input->post('harga_jawa'));
    $harga_indo = preg_replace('/[^0-9]/', '', $this->input->post('harga_indo'));
    $sp = preg_replace('/[^0-9]/', '', $this->input->post('sp'));
    $status = $this->input->post('status');

    if ($kode_baru != $kode_lama) {
      $kode_produk_exist = $this->db->query("SELECT kode FROM tb_produk WHERE kode = '$kode_baru'")->row();
      if ($kode_produk_exist) {
        tampil_alert('error', 'GAGAL', 'Kode artikel ' . $kode_baru . ' sudah ada dalam database');
        redirect(base_url('adm/Produk'));
        return;
      }
    }
    $data = array(
      'kode' => $kode_baru,
      'nama_produk' => $nama,
      'satuan' => $satuan,
      'packing' => $packing,
      'brand' => $brand,
      'status' => $status,
      'harga_jawa' => $harga_jawa,
      'harga_indobarat' => $harga_indo,
      'sp' => $sp,
      'updated_at' => date('Y-m-d H:i:s'),
      'id_user' => $id_user
    );
    $where = array('id' => $id);
    $this->db->update('tb_produk', $data, $where);
    tampil_alert('success', 'BERHASIL', 'Kode artikel ' . $kode_baru . ' berhasil diupdate');
    redirect(base_url('adm/Produk'));
  }

  public function produk_baru()
  {
    $data['title'] = 'Management Produk';
    $data['list_data'] = $this->db->query("SELECT * FROM tb_produk WHERE status ='2'")->result();
    $this->template->load('template/template', 'adm/produk/artikel_baru', $data);
  }
  public function approve()
  {
    $id = $this->uri->segment(4);
    $where = array('id' => $id);
    $data = array(
      'status' => "1",
    );
    $this->M_admin->update('tb_produk', $data, $where);
    tampil_alert('success', 'Berhasil', 'Artikel Berhasil Diaktifkan!!');
    redirect(base_url('adm/produk'));
  }

  public function reject()
  {
    $id = $this->uri->segment(4);
    $where = array('id' => $id);
    $data = array(
      'status' => "0",
    );
    $this->M_admin->update('tb_produk', $data, $where);
    tampil_alert('info', 'Information', 'Artikel dinonaktifkan!');
    redirect(base_url('adm/produk'));
  }
  // export file template stok
  public function template_artikel()
  {
    $query = $this->db->query("SELECT * from tb_produk");
    $detail = $query->result();
    if (empty($detail)) {
      redirect(base_url('/assets/excel/Template_artikel.xlsx'));
    } else {
      // Create a new Spreadsheet instance
      $spreadsheet = new Spreadsheet();
      $worksheet = $spreadsheet->getActiveSheet();
      $worksheet->setTitle('Template_Artikel');
      $worksheet->getStyle('A1:I1')->getFont()->setBold(true);
      $worksheet->getStyle('A1')
        ->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('FFFF00');
      $worksheet->setCellValue('A1', 'KODE ARTIKEL');
      $worksheet->setCellValue('B1', 'DESKRIPSI');
      $worksheet->setCellValue('C1', 'SATUAN');
      $worksheet->setCellValue('D1', 'HET JAWA');
      $worksheet->setCellValue('E1', 'HET INDOBARAT');
      $worksheet->setCellValue('F1', 'SP');
      $worksheet->setCellValue('G1', 'MIN PACKING');
      $worksheet->setCellValue('H1', 'BRAND');
      $worksheet->setCellValue('I1', 'NO RAK');
      $row = 2;
      $no = 1;
      foreach ($detail as $data) {
        $worksheet->setCellValue('A' . $row, $data->kode);
        $worksheet->setCellValue('B' . $row, $data->nama_produk);
        $worksheet->setCellValue('C' . $row, $data->satuan);
        $worksheet->setCellValue('D' . $row, $data->harga_jawa);
        $worksheet->setCellValue('E' . $row, $data->harga_indobarat);
        $worksheet->setCellValue('F' . $row, $data->sp);
        $worksheet->setCellValue('G' . $row, $data->packing);
        $worksheet->setCellValue('H' . $row, $data->brand);
        $worksheet->setCellValue('I' . $row, $data->no_rak);
        $row++;
        $no++;
      }
      $range = 'A1:I' . ($row - 1);
      $tableStyle = $worksheet->getStyle($range);
      $tableStyle->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $writer = new Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="template_artikel_new.xlsx"');
      ob_end_clean();
      $writer->save('php://output');
      exit();
    }
  }
  // import artikel
  public function import_artikel()
  {
    // Process the uploaded file
    $file = $_FILES['file']['tmp_name'];
    $reader = IOFactory::createReader('Xlsx');

    try {
      $spreadsheet = $reader->load($file);
      $worksheet = $spreadsheet->getActiveSheet();
      $rows = $worksheet->toArray();

      $lastRowIndex = count($rows) - 1;
      $id_user = $this->session->userdata('id');

      // Loop through each row starting from the second row (index 1) until the last row
      for ($i = 1; $i <= $lastRowIndex; $i++) {
        // Retrieve the values from each column of the current row
        $kode = trim($rows[$i][0]);
        $nama_produk = isset($rows[$i][1]) ? trim($rows[$i][1]) : '';
        $satuan = isset($rows[$i][2]) ? trim($rows[$i][2]) : '';
        $het_jawa = isset($rows[$i][3]) ? intval($rows[$i][3]) : 0;
        $het_indobarat = isset($rows[$i][4]) ? intval($rows[$i][4]) : 0;
        $sp = isset($rows[$i][5]) ? intval($rows[$i][5]) : 0;
        $packing = isset($rows[$i][6]) ? intval($rows[$i][6]) : 0;
        $brand = isset($rows[$i][7]) ? trim($rows[$i][7]) : '';
        $rak = isset($rows[$i][8]) ? trim($rows[$i][8]) : '';

        if (empty($kode) || empty($nama_produk) || empty($satuan)) {
          tampil_alert('warning', 'DATA KOSONG', 'Data pada baris ' . ($i + 1) . ' memiliki kolom yang kosong, tidak akan disimpan.');
          continue;
        }

        // Clean and validate input to prevent SQL injection
        $kode = $this->db->escape_str($kode);
        $nama_produk = $this->db->escape_str($nama_produk);
        $satuan = $this->db->escape_str($satuan);

        // Check if product exists
        $existing_produk = $this->db->get_where('tb_produk', array('kode' => $kode))->row();
        if ($existing_produk) {
          $data = array(
            'nama_produk' => $nama_produk,
            'satuan' => $satuan,
            'packing' => $packing,
            'brand' => $brand,
            'no_rak' => $rak,
            'harga_jawa' => $het_jawa,
            'harga_indobarat' => $het_indobarat,
            'sp' => $sp,
            'id_user' => $id_user,
            'status' => 1,
          );
          $this->db->update('tb_produk', $data, array('kode' => $kode));
          tampil_alert('success', 'Berhasil', 'Kode sudah ada & Data berhasil Update!');
        } else {
          // Add the new product to the database
          $data = array(
            'kode' => $kode,
            'nama_produk' => $nama_produk,
            'satuan' => $satuan,
            'packing' => $packing,
            'brand' => $brand,
            'no_rak' => $rak,
            'harga_jawa' => $het_jawa,
            'harga_indobarat' => $het_indobarat,
            'sp' => $sp,
            'id_user' => $id_user,
            'status' => 1,
          );
          $this->db->insert('tb_produk', $data);
          tampil_alert('success', 'Berhasil', 'Artikel berhasil ditambahkan!');
        }
      }
      redirect(base_url('adm/produk'));
    } catch (Exception $e) {
      tampil_alert('danger', 'Error', 'Gagal mengimpor artikel: ' . $e->getMessage());
      redirect(base_url('adm/produk'));
    }
  }
}
