<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Permintaan extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "5" and $role != "16") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_adm_gudang');
  }

  //  fungsi lihat data
  public function index()
  {
    $data['title'] = 'Permintaan Barang';
    $data['list'] = $this->db->query("SELECT tp.*, tt.nama_toko, tu.nama_user as leader from tb_permintaan tp
    join tb_toko tt on tp.id_toko = tt.id
    join tb_user tu on tt.id_leader = tu.id
    where tp.status = '2'
    order by tp.id desc ")->result();
    $this->template->load('template/template', 'adm_gudang/permintaan/lihat_data', $data);
  }
  // detail permintaan
  public function detail($no_permintaan)
  {
    $data['title'] = 'Permintaan Barang';
    $data['permintaan'] = $this->db->query("SELECT tp.*, tt.nama_toko, tt.alamat from tb_permintaan tp
    join tb_toko tt on tp.id_toko = tt.id 
    where tp.id = '$no_permintaan'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tp.id_toko,tpk.*, tt.het from tb_permintaan_detail tpd
    join tb_permintaan tp on tpd.id_permintaan = tp.id
    join tb_toko tt on tp.id_toko = tt.id
    join tb_produk tpk on tpd.id_produk = tpk.id
    where tpd.id_permintaan = '$no_permintaan' AND tpd.qty != 0 ")->result();

    $this->template->load('template/template', 'adm_gudang/permintaan/detail', $data);
  }
  public function export_ea_all()
  {
    $name_user = $this->session->userdata('nama_user');
    $id_po_all = $this->input->post('id_po_all');
    $no_transfer = $this->input->post('no_transfer');
    $tanggal = $this->input->post('tanggal_all');

    // Create a new Spreadsheet instance
    $spreadsheet = new Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();
    $worksheet->setTitle('Export Packing List');
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

    // Buat array untuk menampung jumlah qty berdasarkan kode produk
    $products = [];

    // Looping setiap ID PO
    foreach ($id_po_all as $id_po) {
      $query = $this->db->query("
        SELECT SUM(tpd.qty) as jmlBarang, tp.kode, tp.satuan 
        FROM tb_permintaan_detail tpd
        JOIN tb_produk tp ON tpd.id_produk = tp.id
        WHERE tpd.id_permintaan = '$id_po'
        GROUP BY tp.id
    ");

      if ($query->num_rows() > 0) {
        $detail = $query->result();

        foreach ($detail as $data) {
          // Jika produk dengan kode yang sama sudah ada di array, tambahkan qty-nya
          if (isset($products[$data->kode])) {
            $products[$data->kode]['jmlBarang'] += $data->jmlBarang;
          } else {
            // Jika belum, masukkan produk baru ke dalam array
            $products[$data->kode] = [
              'kode' => $data->kode,
              'jmlBarang' => $data->jmlBarang,
              'satuan' => $data->satuan,
            ];
          }
        }
      }
    }

    // Setelah semua qty dijumlahkan, format tanggal dan mulai mengisi spreadsheet
    $tanggalkirim = new DateTime($tanggal);
    $tanggalkirimFormat = $tanggalkirim->format('d/m/Y');

    // Looping untuk mengisi spreadsheet berdasarkan produk yang sudah dijumlahkan
    foreach ($products as $product) {
      $worksheet->setCellValue('A' . $row, $no_transfer);
      $worksheet->setCellValue('B' . $row, $tanggalkirimFormat);
      $worksheet->setCellValue('C' . $row, "Konsinyasi Pasifik");
      $worksheet->setCellValue('D' . $row, "91 GUD. PREPEDAN");
      $worksheet->setCellValue('E' . $row, "51.4 GUD. KONSI PASIFIK");
      $worksheet->setCellValue('F' . $row, "SJ Konsinyasi");
      $worksheet->setCellValue('G' . $row, $product['kode']);
      $worksheet->setCellValue('H' . $row, $product['jmlBarang']);
      $worksheet->setCellValue('I' . $row, $product['satuan']);
      $worksheet->setCellValue('J' . $row, $name_user);
      $row++;
    }


    // Create Excel writer
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Export_Packing_List.xlsx"');

    ob_end_clean();
    $writer->save('php://output');
    exit();
  }
  // proses approve data terpending
  public function kirim()
  {
    $id_user           = $this->session->userdata('id');
    $id_kirim          = $this->M_adm_gudang->kode_kirim();
    $id_po             = $this->input->post('id_permintaan');
    $id_toko           = $this->input->post('id_toko');
    $id_produk         = $this->input->post('id_produk');
    $qty               = $this->input->post('qty_input');
    $catatan           = $this->input->post('catatan');
    date_default_timezone_set('Asia/Jakarta');
    $update_at         = date('Y-m-d h:i:s');
    $jumlah = count($id_produk);
    $cekPO = $this->db->get_where('tb_permintaan', array('id' => $id_po))->row();
    if (!$cekPO) {
      tampil_alert('error', 'DATA TIDAK DITEMUKAN', 'Data permintaan tidak ditemukan.');
      redirect(base_url('adm_gudang/Permintaan'));
      return;
    }
    $cekIDPo = $this->db->get_where('tb_pengiriman', array('id_permintaan' => $id_po))->num_rows();
    if ($cekPO->status == 1) {
      tampil_alert('error', 'PROSES DI BATALKAN', 'Data Permintaan sedang di perbarui oleh tim MV, silahkan tunggu dan buat kembali nanti.');
      redirect(base_url('adm_gudang/Permintaan'));
      return;
    }
    if ($cekIDPo > 0) {
      tampil_alert('info', 'BERHASIL BUAT DO', 'Sepertinya internet anda lemot, DO tetap berhasil di buat.');
      redirect(base_url('adm_gudang/Pengiriman'));
      return;
    }
    $this->db->trans_start();
    $kirim = array(
      'id' => $id_kirim,
      'id_permintaan' => $id_po,
      'id_user' => $id_user,
      'status' => 1,
      'keterangan' => $catatan,
      'id_toko' => $id_toko,
    );
    // insert ke tabel pengiriman
    $this->db->insert('tb_pengiriman', $kirim);
    // Insert detail pengiriman
    for ($i = 0; $i < $jumlah; $i++) {
      $d_id_produk = $id_produk[$i];
      $d_qty = $qty[$i];
      if ($d_qty > 0) {
        $detail = array(
          'id_pengiriman' => $id_kirim,
          'id_produk' => $d_id_produk,
          'qty' => $d_qty,
        );
        $this->db->insert('tb_pengiriman_detail', $detail);
      }
    }
    // Update permintaan
    $this->db->query("UPDATE tb_permintaan SET status = 4, updated_at = '$update_at' WHERE id = '$id_po'");
    $pembuat = $this->db->query("SELECT nama_user from tb_user where id = '$id_user'")->row()->nama_user;
    // Insert histori
    $histori = array(
      'id_po' => $id_po,
      'aksi' => 'Disiapkan & kirim oleh :',
      'pembuat' => $pembuat,
      'catatan' => $catatan
    );

    $this->db->insert('tb_po_histori', $histori);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      tampil_alert('error', 'Gagal', 'Data PO Barang gagal diproses.');
    } else {
      tampil_alert('success', 'Berhasil', 'Data PO Barang berhasil diproses.');
    }
    redirect(base_url('adm_gudang/Pengiriman/detail_p/' . $id_kirim));
  }
  // print packing_list
  public function packing_list($no_permintaan)
  {
    $data['title'] = 'Permintaan Barang';
    $data['permintaan'] = $this->db->query("SELECT tp.*, tt.nama_toko, tu.nama_user as spg, tt.alamat  from tb_permintaan tp
  join tb_toko tt on tp.id_toko = tt.id
  join tb_user tu on tt.id_spg = tu.id
  where tp.id = '$no_permintaan'")->result();
    $data['detail'] = $this->db->query("SELECT tpd.*, tpk.nama_produk, tpk.kode,tpk.satuan from tb_permintaan_detail tpd
  join tb_produk tpk on tpd.id_produk = tpk.id
  where tpd.id_permintaan = '$no_permintaan' and tpd.status ='1'")->result();
    $this->load->view('adm_gudang/permintaan/list_packing', $data);
  }
}
