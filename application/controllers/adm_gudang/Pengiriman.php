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
    $data['list_data'] = $this->db->query("SELECT tp.*, tt.nama_toko, tu.nama_user as leader from tb_pengiriman tp
    join tb_toko tt on tp.id_toko = tt.id
    left join tb_user tu on tt.id_leader = tu.id
    order by tp.id desc")->result();
    $this->template->load('template/template', 'adm_gudang/pengiriman/lihat_data', $data);
  }
  // pengiriman
  public function add()
  {
    $data['title'] = 'Pengiriman Barang';
    $data['list_permintaan'] = $this->M_adm_gudang->list_permintaan()->result();
    $data['kode_kirim'] = $this->M_adm_gudang->kode_kirim();
    $this->template->load('template/template', 'adm_gudang/pengiriman/tambah2', $data);
  }

  //   menampilkan data json
  public function view()
  {
    $id = $_POST['no_permintaan'];
    $data['data'] = $this->M_adm_gudang->info_toko($id)->row();
    // $data['isi_detail'] = $this->isi_detail($id);
    echo json_encode($data);
  }
  // menampilkan list detail json
  function list_detail()
  {
    $id = $_POST['no_permintaan'];
    $data = $this->M_adm_gudang->barang_list($id)->result();
    echo json_encode($data);
  }
  // proses tambah
  function proses_tambah2()
  {
    $this->form_validation->set_rules('kode', 'Kode Artikel', 'required');
    $id_permintaan = $this->input->post('id_permintaan');
    $id_detail_permintaan = $this->input->post('id_detail_permintaan');
    $id_produk = $this->input->post('id_produk');
    $id_toko = $this->input->post('id_toko');
    $keterangan = $this->input->post('catatan');
    $satuan = $this->input->post('satuan');
    $qty = $this->input->post('qty');
    $qty_dikirim = $this->input->post('qty_dikirim');
    $qty_input = $this->input->post('qty_input');
    $id_user = $this->session->userdata('id');
    $id_pengiriman = $this->M_adm_gudang->kode_kirim();
    $jumlah = count($id_produk);
    $belum_lengkap = 0;

    $this->db->trans_start();
    $data = array(
      'id' => $id_pengiriman,
      'id_permintaan' => $id_permintaan,
      'id_user' => $id_user,
      'status' => 0,
      'keterangan' => $keterangan,
      'id_toko' => $id_toko,
    );

    // insert ke tabel pengiriman
    $this->db->insert('tb_pengiriman', $data);
    $insert_id  = $this->db->insert_id();

    for ($i = 0; $i < $jumlah; $i++) {
      $d_id_produk = $id_produk[$i];
      $d_id_detail_permintaan = $id_detail_permintaan[$i];
      $d_qty = $qty[$i];
      $d_qty_dikirim = $qty_dikirim[$i];
      $d_qty_input = $qty_input[$i];
      $d_qty_akhir = $d_qty_dikirim + $d_qty_input;

      // hitung apakah qty pengiriman sudah full atau belum
      if ($d_qty != $d_qty_akhir) {
        $belum_lengkap += 1;
      }

      $data_detail = array(
        'id_pengiriman' => $id_pengiriman,
        'id_produk' => $d_id_produk,
        'qty' => $d_qty_input
      );

      // insert ke tabel detail pengiriman
      $this->db->insert('tb_pengiriman_detail', $data_detail);

      // update qty dikirim pada tabel permintaan
      $data = array(
        'qty_dikirim' => $d_qty_akhir
      );
      $this->db->where('id', $d_id_detail_permintaan);
      $this->db->update('tb_permintaan_detail', $data);
    }

    // cek apabila qty dikirim sudah sesuai dengan qty permintaan maka update status permintaan menjadi 3
    if ($belum_lengkap == 0) {
      $status = 4;
    } else {
      $status = 4;
    }
    $data2 = array(
      'status' => $status
    );
    $this->db->where('id', $id_permintaan);
    $this->db->update('tb_permintaan', $data2);
    $this->db->trans_complete();
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
  // export ke Easy Accounting
  public function export_ea()
  {
    $name_user  = $this->session->userdata('nama_user');
    $id_kirim  = $this->input->post('id_kirim');
    $id_po  = $this->input->post('id_po');
    $toko  = $this->input->post('toko');
    $tanggal  = $this->input->post('tanggal');
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
