<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Customer extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "1" && $role != "6" && $role != "9") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_admin');
    $this->load->model('M_support');
  }

  public function index()
  {
    $data['title'] = 'Kelola Customer';
    $data['customer'] = $this->db->query("
          SELECT 
              tc.*, 
              COUNT(DISTINCT tt.id) as total_produk,
              COUNT(DISTINCT tk.id) as total_toko 
          FROM tb_customer tc
          LEFT JOIN tb_produk_cust tt ON tt.id_customer = tc.id 
          LEFT JOIN tb_toko tk ON tc.id = tk.id_customer
          GROUP BY tc.id 
          ORDER BY tc.id DESC
      ")->result();
    $this->template->load('template/template', 'adm/customer/index', $data);
  }

  public function detail($id_customer)
  {
    $data['title'] = 'Kelola Customer';
    $data['cust'] = $this->db->query("SELECT * from tb_customer where id !='$id_customer'")->result();
    $data['customer'] = $this->db->query("SELECT * from tb_customer where id ='$id_customer'")->row();
    $data['cluster1'] = $this->db->query("SELECT tp.*, tpc.id as detail, tpc.barcode from tb_produk_cust tpc
    join tb_produk tp on tpc.id_produk = tp.id
    where tpc.id_customer ='$id_customer' order by tpc.id desc")->result();
    $data['cluster2'] = $this->db->query("SELECT tp.*, tpc.id as detail, tpc.barcode from tb_produk_cust tpc
    join tb_produk tp on tpc.id_produk = tp.id
    where tpc.id_customer ='$id_customer' AND FIND_IN_SET('2', tpc.cluster) order by tpc.id desc")->result();
    $data['cluster3'] = $this->db->query("SELECT tp.*, tpc.id as detail, tpc.barcode from tb_produk_cust tpc
    join tb_produk tp on tpc.id_produk = tp.id
    where tpc.id_customer ='$id_customer' AND FIND_IN_SET('3', tpc.cluster) order by tpc.id desc")->result();
    $data['list_produk']  = $this->db->query("SELECT * from tb_produk where id not in (select id_produk from tb_produk_cust where id_customer = '$id_customer') ")->result();
    $data['list2'] = $this->db->query("SELECT tpc.id,tp.kode,tp.nama_produk FROM tb_produk_cust tpc
    join tb_produk tp on tpc.id_produk = tp.id
    WHERE tpc.id_customer = '$id_customer' AND tpc.cluster NOT LIKE '%2%'")->result();
    $data['list3'] = $this->db->query("SELECT tpc.id,tp.kode,tp.nama_produk FROM tb_produk_cust tpc
    join tb_produk tp on tpc.id_produk = tp.id
    WHERE tpc.id_customer = '$id_customer' AND tpc.cluster NOT LIKE '%3%'")->result();
    $data['list_toko']  = $this->db->query("SELECT * from tb_toko where id_customer = '$id_customer' ")->result();
    $this->template->load('template/template', 'adm/customer/detail', $data);
  }
  public function update()
  {
    $id = $this->input->post('id');
    $kode = $this->input->post('kode');
    $nama = $this->input->post('nama');
    $telp = $this->input->post('telp');
    $alamat = $this->input->post('alamat');
    $data = array(
      'kode_customer' => $kode,
      'nama_cust' => $nama,
      'telp' => $telp,
      'alamat_cust' => $alamat,
    );
    $this->db->update('tb_customer', $data, array('id' => $id));
    tampil_alert('success', 'Berhasil', 'Data Customer berhasil di Perbaharui!');
    redirect(base_url('adm/Customer'));
  }
  public function tambah_artikel()
  {
    $id_cust = $this->input->post('id_customer');
    $id_produk = $this->input->post('id_produk');
    $jml = count($id_produk);
    $counter_artikel = 0; // Tambahkan variabel counter artikel

    if ($jml <= 0) {
      tampil_alert('error', 'KOSONG', 'Tidak ada artikel terpilih.');
      redirect(base_url('adm/Customer/detail/' . $id_cust));
      exit;
    }
    $this->db->trans_start();
    for ($x = 0; $x < $jml; $x++) {
      $data = array(
        'id_produk' => $id_produk[$x],
        'id_customer' => $id_cust,
      );
      $this->db->insert('tb_produk_cust', $data);
      $counter_artikel++;
    }
    $this->db->trans_complete();

    // Jika transaksi sudah selesai
    if ($this->db->trans_status() === FALSE) {
      tampil_alert('error', 'Gagal', 'Gagal menambahkan artikel.');
    } else {
      tampil_alert('success', 'Berhasil', 'Artikel Berhasil didaftarkan! Jumlah Artikel: ' . $counter_artikel); // Tampilkan jumlah artikel
    }
    redirect(base_url('adm/Customer/detail/' . $id_cust));
  }
  public function tambah_artikel2()
  {
    $id_cust = $this->input->post('id_customer');
    $id_produk = $this->input->post('id_produk');
    $jml = count($id_produk);
    $counter_artikel = 0; // Tambahkan variabel counter artikel

    if ($jml <= 0) {
      tampil_alert('error', 'KOSONG', 'Tidak ada artikel terpilih.');
      redirect(base_url('adm/Customer/detail/' . $id_cust));
      exit;
    }
    $this->db->trans_start();
    for ($x = 0; $x < $jml; $x++) {
      $this->db->set('cluster', 'CONCAT(cluster, ",2")', FALSE); // Menggunakan CONCAT untuk menambahkan ,2 ke cluster
      $this->db->where('id', $id_produk[$x]);
      $this->db->update('tb_produk_cust');
      $counter_artikel++;
    }
    $this->db->trans_complete();

    // Jika transaksi sudah selesai
    if ($this->db->trans_status() === FALSE) {
      tampil_alert('error', 'Gagal', 'Gagal menambahkan artikel.');
    } else {
      tampil_alert('success', 'Berhasil', 'Artikel Berhasil didaftarkan! Jumlah Artikel: ' . $counter_artikel); // Tampilkan jumlah artikel
    }
    redirect(base_url('adm/Customer/detail/' . $id_cust));
  }
  public function tambah_artikel3()
  {
    $id_cust = $this->input->post('id_customer');
    $id_produk = $this->input->post('id_produk');
    $jml = count($id_produk);
    $counter_artikel = 0; // Tambahkan variabel counter artikel

    if ($jml <= 0) {
      tampil_alert('error', 'KOSONG', 'Tidak ada artikel terpilih.');
      redirect(base_url('adm/Customer/detail/' . $id_cust));
      exit;
    }
    $this->db->trans_start();
    for ($x = 0; $x < $jml; $x++) {
      $this->db->set('cluster', 'CONCAT(cluster, ",3")', FALSE); // Menggunakan CONCAT untuk menambahkan ,2 ke cluster
      $this->db->where('id', $id_produk[$x]);
      $this->db->update('tb_produk_cust');
      $counter_artikel++;
    }
    $this->db->trans_complete();

    // Jika transaksi sudah selesai
    if ($this->db->trans_status() === FALSE) {
      tampil_alert('error', 'Gagal', 'Gagal menambahkan artikel.');
    } else {
      tampil_alert('success', 'Berhasil', 'Artikel Berhasil didaftarkan! Jumlah Artikel: ' . $counter_artikel); // Tampilkan jumlah artikel
    }
    redirect(base_url('adm/Customer/detail/' . $id_cust));
  }
  public function hapus_cust($id)
  {
    if (!is_numeric($id)) {
      tampil_alert('error', 'GAGAL', 'ID tidak valid.');
      redirect(base_url('adm/Customer'));
      return;
    }

    $cek = $this->db->query("SELECT id_customer FROM tb_toko WHERE id_customer = ?", array($id))->num_rows();

    if ($cek > 0) {
      tampil_alert('info', 'GAGAL', 'Ada Toko yang masih terkait, silahkan pindahkan toko terlebih dahulu.');
      redirect(base_url('adm/Customer'));
    } else {
      $this->db->delete("tb_customer", array("id" => $id));
      if ($this->db->affected_rows() > 0) {
        tampil_alert('success', 'DIHAPUS', 'Data Customer berhasil dihapus.');
      } else {
        tampil_alert('error', 'GAGAL', 'Gagal menghapus data Customer.');
      }
      redirect(base_url('adm/Customer'));
    }
  }
  public function pindahToko()
  {
    $id_cust = $this->input->post('id_cust');
    $id_toko = $this->input->post('id_toko');
    $customer = $this->input->post('customer');
    $data = array(
      'id_customer' => $customer
    );
    $this->db->update('tb_toko', $data, array('id' => $id_toko));
    tampil_alert('success', 'Berhasil', 'Toko berhasil di pindahkan!');
    redirect(base_url('adm/Customer/detail/' . $id_cust));
  }


  // export file template stok
  public function template_barcode($id)
  {
    $query = $this->db->query("SELECT tpc.id_customer,tpc.barcode,tc.nama_cust,tpc.id as id_detail,tp.kode,tp.nama_produk from tb_produk_cust tpc
     join tb_customer tc on tpc.id_customer = tc.id
     join tb_produk tp on tpc.id_produk = tp.id
     WHERE tpc.id_customer = '$id'");
    $cust = $query->row();
    $detail = $query->result();
    if (empty($cust) || empty($detail)) {
      tampil_alert('error', 'DATA KOSONG', 'Tambahkan Data Artikel Terlebih Dahulu.');
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      // Create a new Spreadsheet instance
      $spreadsheet = new Spreadsheet();
      $worksheet = $spreadsheet->getActiveSheet();
      $worksheet->setTitle($cust->nama_cust);
      $worksheet->getStyle('A2:E2')->getFont()->setBold(true);
      $worksheet->getStyle('A1:B1')->getFont()->setBold(true);
      $worksheet->getStyle('E2')
        ->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('FFFF00');
      $worksheet->getStyle('A1:B1')
        ->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('f42e35');
      $worksheet->getStyle('A1:B1')
        ->getFont()
        ->getColor()
        ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
      $worksheet->getStyle('B2')
        ->getFont()
        ->getColor()
        ->setARGB('FF0000'); // Mengubah warna teks menjadi merah

      $worksheet->setCellValue('A1', 'ID CUST : ');
      $worksheet->setCellValue('B1', $cust->id_customer);
      $worksheet->setCellValue('A2', 'NO URUT');
      $worksheet->setCellValue('B2', 'ID (jangan di rubah)');
      $worksheet->setCellValue('C2', 'KODE');
      $worksheet->setCellValue('D2', 'ARTIKEL');
      $worksheet->setCellValue('E2', 'BARCODE (kolom ini yang harus di isi)');
      $row = 3;
      $no = 1;
      foreach ($detail as $data) {
        $worksheet->setCellValue('A' . $row, $no);
        $worksheet->setCellValue('B' . $row, $data->id_detail);
        $worksheet->setCellValue('C' . $row, $data->kode);
        $worksheet->setCellValue('D' . $row, $data->nama_produk);
        $worksheet->setCellValue('E' . $row, $data->barcode);
        $row++;
        $no++;
      }
      $range = 'A1:E' . ($row - 1);
      $tableStyle = $worksheet->getStyle($range);
      $tableStyle->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $writer = new Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $cust->nama_cust . '.xlsx"');
      ob_end_clean();
      $writer->save('php://output');
      exit();
    }
  }
  // import Stok
  public function import_barcode()
  {
    $this->load->library('user_agent');
    $file = $_FILES['file']['tmp_name'];
    $reader = IOFactory::createReader('Xlsx');
    $spreadsheet = $reader->load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();
    $id_cust = $rows[0][1];
    if (empty($id_cust) || !is_numeric($id_cust)) {
      tampil_alert('error', 'DI TOLAK', 'Pastikan ID Customer Benar');
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      for ($i = 2; $i < count($rows); $i++) {
        $row = $rows[$i];
        $id_detail = intval($row[1]);
        $barcode = trim($row[4]);
        date_default_timezone_set('Asia/Jakarta');
        $tanggal_sekarang = date("Y-m-d H:i:s");
        $data_update = array(
          'barcode' => $barcode,
          'updated_at' => $tanggal_sekarang,
        );
        $where = array(
          'id' => $id_detail,
        );
        $this->db->update('tb_produk_cust', $data_update, $where);
      }
      tampil_alert('success', 'Berhasil', 'Data di update sesuai Kode Artikel yang sesuai.');
      redirect(base_url('adm/Customer/detail/' . $id_cust));
    }
  }
  // update barcode
  public function update_barcode()
  {
    $id = $this->input->post('id');
    $barcode = $this->input->post('barcode');
    $data = array(
      'barcode' => $barcode,
    );
    $this->db->update('tb_produk_cust', $data, array('id' => $id));
    tampil_alert('success', 'Berhasil', 'Data Barcode berhasil di Perbaharui!');
    redirect($_SERVER['HTTP_REFERER']);
  }
  public function hapus_item($id)
  {
    $this->db->delete("tb_produk_cust", array("id" => $id));
    tampil_alert('success', 'DIHAPUS', 'Artikel berhasil dihapus.');
    redirect($_SERVER['HTTP_REFERER']);
  }
  public function hapus_item2($id)
  {
    $dataCluster = $this->db->get_where('tb_produk_cust', array('id' => $id))->row()->cluster;
    $newCluster = str_replace(',2', '', $dataCluster);
    $this->db->update("tb_produk_cust", array("cluster" => $newCluster), array("id" => $id));
    tampil_alert('success', 'DIHAPUS', 'Artikel berhasil dihapus dari cluster 2.');
    redirect($_SERVER['HTTP_REFERER']);
  }
  public function hapus_item3($id)
  {
    $dataCluster = $this->db->get_where('tb_produk_cust', array('id' => $id))->row()->cluster;
    $newCluster = str_replace(',3', '', $dataCluster);
    $this->db->update("tb_produk_cust", array("cluster" => $newCluster), array("id" => $id));
    tampil_alert('success', 'DIHAPUS', 'Artikel berhasil dihapus dari cluster 3.');
    redirect($_SERVER['HTTP_REFERER']);
  }
}
