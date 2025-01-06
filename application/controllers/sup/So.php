<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class So extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    $allowed_roles = [1, 2, 3, 6, 8, 9, 10, 11, 14, 15, 17];
    if (!in_array($role, $allowed_roles)) {
      tampil_alert('error', 'DI TOLAK!', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }
  public function index()
  {
    $data['title'] = 'Management Stock Opname';
    $id = $this->session->userdata('id');
    $role = $this->session->userdata('role');
    if ($role == 2) {
      $query = "AND id_spv = '$id'";
    } else if ($role == 3) {
      $query = "AND id_leader = '$id'";
    } else {
      $query = "";
    }
    $data['t_toko'] = $this->db->query("SELECT * from tb_toko where status = '1' $query ")->num_rows();
    $data['t_so'] = $this->db->query("SELECT * from tb_toko where status_so = '1' and status = '1' $query ")->num_rows();
    $data['t_bso'] = $this->db->query("SELECT * from tb_toko where status_so = '0' and status = '1' $query ")->num_rows();
    $data['list_data'] = $this->db->query("SELECT tt.*, tb_user.nama_user,
    Max(ts.id) as id_so, Max(ts.created_at) as tgl_buat, max(ts.tgl_so) as tanggal_so FROM tb_toko tt
    left join tb_so ts on tt.id = ts.id_toko
    left JOIN tb_user ON tt.id_spg = tb_user.id 
    WHERE tt.status = '1' $query group by tt.id order by tt.id asc")->result();
    $this->template->load('template/template', 'manager_mv/stokopname/index', $data);
  }

  // riwayat so
  public function riwayat_so()
  {
    $data['title'] = 'Histori SO';
    $id = $this->session->userdata('id');
    $role = $this->session->userdata('role');
    if ($role == 2) {
      $query = "AND id_spv = '$id'";
    } else if ($role == 3) {
      $query = "AND id_leader = '$id'";
    } else {
      $query = "";
    }
    $thisMonth = date('Y-m-d', strtotime('first day of this month'));
    $data['list_so'] = $this->db->query(" SELECT ts.*, DATE_FORMAT(DATE_SUB(ts.created_at, INTERVAL 1 MONTH), '%M %Y') AS periode, tt.nama_toko, ts.created_at as dibuat from tb_so ts
    join tb_toko tt on ts.id_toko = tt.id
    WHERE ts.created_at < '$thisMonth' $query
    ORDER BY ts.created_at DESC")->result();
    $this->template->load('template/template', 'manager_mv/stokopname/riwayat_so', $data);
  }

  public function riwayat_so_toko($id_toko, $id_so)
  {
    tampil_alert('info', 'Maintenance', 'Fitur Laporan SO sedang di perbarui dan akan tampil pada tgl 11 Januari 2025.');
    redirect(base_url('sup/So'));
    $data['title'] = 'Detail SO';
    $cek = $this->db->query("SELECT * FROM tb_so where id = ?", array($id_so))->row();
    if ($cek->status == 1) {
      tampil_alert('info', 'SEDANG DI PERBARUI', 'Data SO sedang di perbarui oleh SPG, mohon tunggu dan coba lagi nanti.');
      redirect('sup/So');
      return;
    }
    $data['SO']  = $this->db->query("SELECT ts.*, tt.nama_toko from tb_so ts 
    join tb_toko tt on ts.id_toko = tt.id
    where ts.id_toko = '$id_toko' and ts.id = '$id_so'")->row();
    $tgl_so = $this->db->query("SELECT tgl_so FROM tb_so WHERE id = ?", array($id_so))->row()->tgl_so;
    $query = "SELECT ts.id_produk, COALESCE(nj.qty, 0) as qty_jual,tp.kode,tsd.hasil_so,tsd.qty_awal, COALESCE(vt.jml_terima, 0) AS jml_terima,COALESCE(vm.jml_mutasi, 0) AS mutasi_masuk,COALESCE(vp.jml_jual, 0) AS jml_jual,COALESCE(vpb.jml_jual, 0) AS jml_jual_buat,COALESCE(vr.jml_retur, 0) AS jml_retur,COALESCE(vk.jml_mutasi, 0) AS mutasi_keluar FROM tb_stok ts
    LEFT JOIN (SELECT  id_produk, jml_terima FROM vw_penerimaan WHERE id_toko = ?
            AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
            AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
        GROUP BY 
            id_produk ) vt ON vt.id_produk = ts.id_produk
    LEFT JOIN (SELECT  id_produk, jml_mutasi FROM vw_mutasi_masuk WHERE id_toko_tujuan = ?
            AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
            AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
        GROUP BY 
            id_produk ) vm ON vm.id_produk = ts.id_produk
    LEFT JOIN (SELECT  id_produk, jml_jual FROM vw_penjualan WHERE id_toko = ?
            AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
            AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
        GROUP BY 
            id_produk ) vp ON vp.id_produk = ts.id_produk
    LEFT JOIN (SELECT  id_produk, jml_jual FROM vw_penjualan_buat WHERE id_toko = ?
            AND tahun = YEAR(DATE_SUB(?, INTERVAL 0 MONTH))
            AND bulan = MONTH(DATE_SUB(?, INTERVAL 0 MONTH))
        GROUP BY 
            id_produk ) vpb ON vpb.id_produk = ts.id_produk
    LEFT JOIN (SELECT  id_produk, jml_retur FROM vw_retur WHERE id_toko = ?
            AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
            AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
        GROUP BY 
            id_produk ) vr ON vr.id_produk = ts.id_produk
    LEFT JOIN (SELECT  id_produk, jml_mutasi FROM vw_mutasi_keluar WHERE id_toko_asal = ?
            AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
            AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
        GROUP BY 
            id_produk ) vk ON vk.id_produk = ts.id_produk
    LEFT JOIN (SELECT sum(tpdd.qty) as qty, tpdd.id_produk FROM tb_penjualan_detail tpdd
    JOIN tb_penjualan tpp ON tpdd.id_penjualan = tpp.id
    WHERE tpp.id_toko = ?
    AND tpp.tanggal_penjualan BETWEEN DATE_FORMAT(?, '%Y-%m-01 00:00:00') AND ?
    GROUP BY tpdd.id_produk ) nj ON nj.id_produk = ts.id_produk

    JOIN tb_produk tp ON ts.id_produk = tp.id
    LEFT JOIN tb_so_detail tsd on tsd.id_produk = ts.id_produk
    WHERE ts.id_toko = ? AND tsd.id_so = ?

    GROUP BY ts.id_produk ORDER BY tp.kode ASC";

    $data['detail_so'] = $this->db->query($query, array($id_toko, $tgl_so, $tgl_so, $id_toko, $tgl_so, $tgl_so, $id_toko, $tgl_so, $tgl_so, $id_toko, $tgl_so, $tgl_so, $id_toko, $tgl_so, $tgl_so, $id_toko, $tgl_so, $tgl_so, $id_toko, $tgl_so, $tgl_so, $id_toko, $id_so))->result();
    $data['cek_adjust'] = $this->db->query("SELECT * FROM tb_adjust_stok WHERE id_so = ?", array($id_so))->num_rows();
    $this->template->load('template/template', 'manager_mv/stokopname/detail_so_toko', $data);
  }
  public function reset_so()
  {
    $id_so = $this->input->post('id_so');
    $this->db->update('tb_so', array('status' => 1), array('id' => $id_so));
    tampil_alert('success', 'Berhasil', 'Data SO berhasil direset.');
    redirect(base_url('sup/So'));
  }
  public function unduh_so($id_so)
  {
    $toko = $this->db->query("SELECT ts.*, tt.nama_toko from tb_so ts 
      join tb_toko tt on ts.id_toko = tt.id
      where ts.id = ?", array($id_so))->row();

    $tgl_so = $this->db->query("SELECT created_at FROM tb_so WHERE id = ?", array($id_so))->row()->created_at;

    $query = "SELECT COALESCE(nj.qty, 0) as qty_jual,tp.kode,tsd.hasil_so,tsd.qty_awal, COALESCE(vt.jml_terima, 0) AS jml_terima,COALESCE(vm.jml_mutasi, 0) AS mutasi_masuk,COALESCE(vp.jml_jual, 0) AS jml_jual,COALESCE(vpb.jml_jual, 0) AS jml_jual_buat,COALESCE(vr.jml_retur, 0) AS jml_retur,COALESCE(vk.jml_mutasi, 0) AS mutasi_keluar FROM tb_stok ts
       LEFT JOIN (SELECT  id_produk, jml_terima FROM vw_penerimaan WHERE id_toko = ?
               AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
               AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
           GROUP BY 
               id_produk ) vt ON vt.id_produk = ts.id_produk
       LEFT JOIN (SELECT  id_produk, jml_mutasi FROM vw_mutasi_masuk WHERE id_toko_tujuan = ?
               AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
               AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
           GROUP BY 
               id_produk ) vm ON vm.id_produk = ts.id_produk
       LEFT JOIN (SELECT  id_produk, jml_jual FROM vw_penjualan WHERE id_toko = ?
               AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
               AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
           GROUP BY 
               id_produk ) vp ON vp.id_produk = ts.id_produk
      LEFT JOIN (SELECT  id_produk, jml_jual FROM vw_penjualan_buat WHERE id_toko = ?
            AND tahun = YEAR(DATE_SUB(?, INTERVAL 0 MONTH))
            AND bulan = MONTH(DATE_SUB(?, INTERVAL 0 MONTH))
        GROUP BY 
            id_produk ) vpb ON vpb.id_produk = ts.id_produk
       LEFT JOIN (SELECT  id_produk, jml_retur FROM vw_retur WHERE id_toko = ?
               AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
               AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
           GROUP BY 
               id_produk ) vr ON vr.id_produk = ts.id_produk
       LEFT JOIN (SELECT  id_produk, jml_mutasi FROM vw_mutasi_keluar WHERE id_toko_asal = ?
               AND tahun = YEAR(DATE_SUB(?, INTERVAL 1 MONTH))
               AND bulan = MONTH(DATE_SUB(?, INTERVAL 1 MONTH))
           GROUP BY 
               id_produk ) vk ON vk.id_produk = ts.id_produk
       LEFT JOIN (SELECT sum(tpdd.qty) as qty, tpdd.id_produk FROM tb_penjualan_detail tpdd
       JOIN tb_penjualan tpp ON tpdd.id_penjualan = tpp.id
       WHERE tpp.id_toko = ?
       AND tpp.tanggal_penjualan BETWEEN DATE_FORMAT(?, '%Y-%m-01 00:00:00') AND ?
       GROUP BY tpdd.id_produk ) nj ON
       nj.id_produk = ts.id_produk
      JOIN tb_produk tp ON ts.id_produk = tp.id
      LEFT JOIN tb_so_detail tsd on tsd.id_produk = ts.id_produk
      WHERE ts.id_toko = ? AND tsd.id_so = ?

      GROUP BY ts.id_produk ORDER BY tp.kode ASC";

    $detail = $this->db->query($query, array($toko->id_toko, $tgl_so, $tgl_so, $toko->id_toko, $tgl_so, $tgl_so, $toko->id_toko, $tgl_so, $tgl_so, $toko->id_toko, $tgl_so, $tgl_so, $toko->id_toko, $tgl_so, $tgl_so, $toko->id_toko, $tgl_so, $tgl_so, $toko->id_toko, $tgl_so, $tgl_so, $toko->id_toko, $id_so))->result();

    if (empty($toko) || empty($detail)) {
      tampil_alert('error', 'DATA KOSONG', 'tidak ada data yang bisa di tampilkan');
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      // Create a new Spreadsheet instance
      $spreadsheet = new Spreadsheet();
      $worksheet = $spreadsheet->getActiveSheet();
      $worksheet->setTitle($toko->nama_toko);
      $worksheet->getStyle('A2:J2')->getFont()->setBold(true);
      $worksheet->getStyle('A1:E1')->getFont()->setBold(true);
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

      $worksheet->setCellValue('A1', 'Nama Toko : ');
      $worksheet->setCellValue('B1', $toko->nama_toko);
      $worksheet->setCellValue('D1', 'Tgl SO : ');
      $worksheet->setCellValue('E1', $toko->created_at);
      $worksheet->setCellValue('A2', 'No');
      $worksheet->setCellValue('B2', 'Kode Artikel');
      $worksheet->setCellValue('C2', 'Stok Awal');
      $worksheet->setCellValue('D2', 'Barang Masuk');
      $worksheet->setCellValue('D3', 'PO Masuk');
      $worksheet->setCellValue('E3', 'Mutasi Masuk');
      $worksheet->setCellValue('F2', 'Barang Keluar');
      $worksheet->setCellValue('F3', 'Retur');
      $worksheet->setCellValue('G3', 'Penjualan');
      $worksheet->setCellValue('H3', 'Mutasi Keluar');
      $worksheet->setCellValue('I2', 'Stok Akhir');
      $worksheet->setCellValue('J2', '( SO SPG ) Stok Fisik');
      $worksheet->setCellValue('K2', 'Penjualan (' . date('M-Y', strtotime($toko->created_at)) . ') 01 s/d ' . date('d', strtotime($toko->created_at)));
      $worksheet->setCellValue('L2', 'Selisih');

      // Merge cells for rowspan and colspan
      $worksheet->mergeCells('A2:A3'); // No
      $worksheet->mergeCells('B2:B3'); // Kode Artikel
      $worksheet->mergeCells('C2:C3'); // Stok Awal
      $worksheet->mergeCells('D2:E2'); // Barang Masuk
      $worksheet->mergeCells('F2:H2'); // Barang Keluar
      $worksheet->mergeCells('I2:I3'); // Stok Akhir
      $worksheet->mergeCells('J2:J3'); // ( SO SPG ) Stok Fisik
      $worksheet->mergeCells('K2:K3'); // Penjualan
      $worksheet->mergeCells('L2:L3'); // Selisih

      $row = 4;
      $no = 1;
      foreach ($detail as $d) {
        $stok_akhir = $d->qty_awal - $d->jml_jual_buat;
        $akhir = $d->qty_awal + $d->jml_terima + $d->mutasi_masuk  - $d->jml_retur - $d->jml_jual - $d->mutasi_keluar;
        $awal = $stok_akhir - $d->jml_terima - $d->mutasi_masuk  + $d->jml_retur + $d->jml_jual + $d->mutasi_keluar;
        $selisih = ($d->hasil_so + $d->qty_jual) - $akhir;
        $selisih_update = ($d->hasil_so + $d->qty_jual) - $stok_akhir;

        $worksheet->setCellValue('A' . $row, $no);
        $worksheet->setCellValue('B' . $row, $d->kode);
        $worksheet->setCellValue('C' . $row, DATE_FORMAT(new DateTime($toko->created_at), 'Y-m') <= '2024-05' ? $d->qty_awal : $awal);
        $worksheet->setCellValue('D' . $row, $d->jml_terima);
        $worksheet->setCellValue('E' . $row, $d->mutasi_masuk);
        $worksheet->setCellValue('F' . $row, $d->jml_retur);
        $worksheet->setCellValue('G' . $row, $d->jml_jual);
        $worksheet->setCellValue('H' . $row, $d->mutasi_keluar);
        $worksheet->setCellValue('I' . $row, DATE_FORMAT(new DateTime($toko->created_at), 'Y-m') <= '2024-05' ? $akhir : $stok_akhir);
        $worksheet->setCellValue('J' . $row, $d->hasil_so);
        $worksheet->setCellValue('K' . $row, $d->qty_jual);
        $worksheet->setCellValue('L' . $row, DATE_FORMAT(new DateTime($toko->created_at), 'Y-m') <= '2024-05' ? $selisih : $selisih_update);
        $row++;
        $no++;
      }
      $range = 'A1:L' . ($row - 1);
      $tableStyle = $worksheet->getStyle($range);
      $tableStyle->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $writer = new Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $toko->nama_toko . '.xlsx"');
      ob_end_clean();
      $writer->save('php://output');
      exit();
    }
  }

  // download pdf
  public function pdf($toko)
  {
    $this->load->library('pdfgenerator');
    $data['title_pdf'] = 'List Artikel Stok Opname';
    $file_pdf = 'List_Artikel_Stok_Opname';
    $paper = 'A4';
    $orientation = "portrait";
    $data['data_toko']  = $this->db->query("SELECT tb_toko.*, tb_user.nama_user from tb_toko 
        join tb_user on tb_toko.id_spg = tb_user.id
        where tb_toko.id ='$toko'")->row();
    $data['stok'] = $this->db->query("SELECT ts.*, tp.nama_produk, tp.kode, tp.satuan from tb_stok ts
        join tb_produk tp on ts.id_produk = tp.id
        where ts.id_toko = '$toko' ")->result();
    $html = $this->load->view('manager_mv/stokopname/print_so', $data, true);
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
}
