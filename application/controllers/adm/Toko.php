<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Toko extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('status') != 'login') {
      redirect(base_url());
    }
  }

  public function index()
  {
    $data['title'] = 'Toko';
    $data['customer'] = $this->db->query("SELECT * FROM tb_customer WHERE deleted_at is NULL")->result();
    $data['provinsi'] = $this->db->query("SELECT * from wilayah_provinsi")->result();
    $data['toko'] = $this->db->query("SELECT tt.*, tu.nama_user as spg, tl.nama_user as leader, spv.nama_user as nama_spv
    from tb_toko tt
    left join tb_user tu on tt.id_spg = tu.id
    left join tb_user tl on tt.id_leader = tl.id
    left join tb_user spv on tt.id_spv = spv.id
    where tt.status = 1 OR tt.status = 7
    ORDER BY  tt.id desc")->result();
    $this->template->load('template/template', 'adm/toko/lihat_data', $data);
  }
  public function unduhExcel()
  {
    // Ambil data dari database
    $dataToko = $this->db->query("SELECT tt.nama_toko, tt.alamat, spv.nama_user as nama_spv, tl.nama_user as leader, tu.nama_user as spg
        from tb_toko tt
        left join tb_user tu on tt.id_spg = tu.id
        left join tb_user tl on tt.id_leader = tl.id
        left join tb_user spv on tt.id_spv = spv.id
        where tt.status = 1
        ORDER BY  tt.id desc")->result();

    // Buat spreadsheet baru
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Nama Toko');
    $sheet->setCellValue('C1', 'Alamat');
    $sheet->setCellValue('D1', 'SPV');
    $sheet->setCellValue('E1', 'Leader');
    $sheet->setCellValue('F1', 'SPG');
    $row = 2;
    $no = 1;
    foreach ($dataToko as $data) {
      $sheet->setCellValue('A' . $row, $no);
      $sheet->setCellValue('B' . $row, $data->nama_toko);
      $sheet->setCellValue('C' . $row, $data->alamat);
      $sheet->setCellValue('D' . $row, $data->nama_spv);
      $sheet->setCellValue('E' . $row, $data->leader);
      $sheet->setCellValue('F' . $row, $data->spg);
      $row++;
      $no++;
    }
    $fileName = 'Data_Toko_' . date('dMY') . '.xlsx';
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    ob_end_clean();
    $writer->save('php://output');
    exit();
  }
  // fitur proses pengajuan toko baru /tutup
  public function pengajuanToko()
  {
    $data['title'] = 'Pengajuan Toko';
    $role = $this->session->userdata('role');
    if ($role == '15') {
      $where = 'WHERE tpt.status = 4';
    } else {
      $where = '';
    }
    $data['pengajuan'] = $this->db->query("SELECT tpt.*, tt.nama_toko, tt.alamat, tc.nama_cust from tb_pengajuan_toko tpt
    JOIN tb_toko tt on tpt.id_toko = tt.id
    JOIN tb_customer tc on tt.id_customer = tc.id
    $where 
    order by tpt.status = 3 desc, tpt.id desc")->result();
    $this->template->load('template/template', 'adm/toko/pengajuanToko', $data);
  }
  public function detail($id)
  {
    $data['title'] = 'Pengajuan Toko';
    $id_user = $this->session->userdata('id');
    $cekTTD = $this->db->query("SELECT ttd from tb_user where id = ?", array($id_user))->row();
    if (empty($cekTTD->ttd)) {
      popup('Tanda Tangan Digital', 'Anda harus membuat TTD Digital terlebih dahulu untuk melanjutkan proses Pengajuan Toko', 'Profile');
      redirect('adm/Toko/pengajuanToko');
    }
    $query = $this->db->query("SELECT tpt.*,tpt.id as id_pengajuan,tpt.status as status_pengajuan,tt.*,tc.*,tt.nama_pic as pic_toko, tt.telp as telp_toko,tu.nama_user as leader,ts.nama_user as spg,tp.nama_user as spv FROM tb_pengajuan_toko tpt
    JOIN tb_toko tt on tpt.id_toko = tt.id
    join tb_customer tc on tt.id_customer = tc.id
    left join tb_user tu on tt.id_leader = tu.id
    left join tb_user ts on tt.id_spg = tu.id
    join tb_user tp on tt.id_spv = tp.id
     WHERE tpt.id = '$id'");
    $data['toko'] = $query->row();
    $id_toko = $query->row()->id_toko;
    $data['histori'] = $this->db->query("SELECT * from tb_toko_histori tpo
    join tb_toko tt on tpo.id_toko = tt.id where tpo.id_toko = '$id_toko'")->result();
    $this->template->load('template/template', 'adm/toko/detail', $data);
  }
  public function approve()
  {
    $pt = $this->session->userdata('pt');
    $id_toko = $this->input->post('id_toko');
    $id_pengajuan = $this->input->post('id_pengajuan');
    $id = $this->session->userdata('id');
    $direksi = $this->session->userdata('nama_user');
    $toko = $this->input->post('toko');
    $catatan = $this->input->post('catatan');
    $keputusan = $this->input->post('keputusan');
    $this->db->trans_start();
    $this->db->query("UPDATE tb_pengajuan_toko set status = $keputusan, id_direksi = '$id' where id = '$id_pengajuan'");
    if ($keputusan == 4) {
      $pesan = "Toko Berhasil di Aktifkan !";
      $aksi = "Di Setujui Oleh DIREKSI : ";
      $spv = $this->db->query("SELECT id_spv FROM tb_toko WHERE id = '$id_toko'")->row()->id_spv;
      $phones = $this->db->query("SELECT no_telp FROM tb_user where id = '$spv'")->result_array();
      $telpacc = $this->db->query("SELECT no_telp FROM tb_user where role = 15 AND status = 1")->result_array();
      $message = "Pengajuan Toko ( " . $toko . " - " . $pt . " ) anda telah di setujui & Sudah AKTIF, silahkan kunjungi s.id/absi-app";
      $pesancc = "Ada Toko Baru ( " . $toko . " - " . $pt . " ) telah di setujui di ABSI, silahkan input ke database Easy Accounting, info lebih lanjut silahkan kunjungi s.id/absi-app.";
      $this->db->query("UPDATE tb_toko set status = 1 where id = '$id_toko'");
    } else {
      $pesan = "Data Toko DI Tolak";
      $aksi = "Di Tolak Oleh DIREKSI : ";
      $spv = $this->db->query("SELECT id_spv FROM tb_toko WHERE id = '$id_toko'")->row()->id_spv;
      $phones = $this->db->query("SELECT no_telp FROM tb_user where id = '$spv'")->result_array();
      $message = "Pengajuan Toko ( " . $toko . " - " . $pt . " ) anda DI TOLAK, Silahkan ajukan kembali dengan data yang benar,  s.id/absi-app";
      $this->db->query("UPDATE tb_toko set status = 50 where id = '$id_toko'");
    }
    $histori = array(
      'id_toko' => $id_toko,
      'aksi' => $aksi,
      'pembuat' => $direksi,
      'catatan' => $catatan
    );
    $this->db->insert('tb_toko_histori', $histori);
    $this->db->trans_complete();
    foreach ($phones as $phone) {
      $number = $phone['no_telp'];
      $hp = substr($number, 0, 1);
      if ($hp == '0') {
        $number = '62' . substr($number, 1);
      }
      kirim_wa($number, $message);
    }
    foreach ($telpacc as $ta) {
      $no = $ta['no_telp'];
      $hpacc = substr($no, 0, 1);
      if ($hpacc == '0') {
        $no = '62' . substr($no, 1);
      }
      kirim_wa($no, $pesancc);
    }
    tampil_alert('success', 'Berhasil di Proses', $pesan);
    redirect(base_url('adm/Toko/detail/' . $id_pengajuan));
  }
  // fitur tambah toko sementara
  public function tambahToko()
  {
    $nama_toko = $this->input->post('namaToko');
    $customer = $this->input->post('id_customer');
    $jenis_toko = $this->input->post('jenis_toko');
    $het = $this->input->post('het');
    $provinsi = $this->input->post('provinsi');
    $kabupaten = $this->input->post('kabupaten');
    $kecamatan = $this->input->post('kecamatan');
    $alamat = $this->input->post('alamat');

    $data = array(
      'jenis_toko' => $jenis_toko,
      'nama_toko' => $nama_toko,
      'id_customer' => $customer,
      'het' => $het,
      'provinsi' => $provinsi,
      'kabupaten' => $kabupaten,
      'kecamatan' => $kecamatan,
      'alamat' => $alamat,
      'status' => 1
    );
    $this->db->insert('tb_toko', $data);
    tampil_alert('success', 'Berhasil', 'Data Toko berhasil di tambahkan!');
    redirect(base_url('adm/Toko/'));
  }
  public function toko_tutup()
  {
    $data['title'] = 'List Toko Tutup';
    $data['toko_tutup'] = $this->db->query("SELECT * from tb_toko
    where status = 0  order by tgl_suspend desc")->result();
    $this->template->load('template/template', 'adm/toko/toko_tutup', $data);
  }
  public function toko_tutup_d($id)
  {
    $data['title'] = 'Pengajuan Toko';
    $id_user = $this->session->userdata('id');
    // $cekTTD = $this->db->query("SELECT ttd from tb_user where id = ?", array($id_user))->row();
    // if (empty($cekTTD->ttd)) {
    //   popup('Tanda Tangan Digital', 'Anda harus membuat TTD Digital terlebih dahulu untuk melanjutkan proses Pengajuan Toko', 'Profile');
    //   redirect('adm/Toko/pengajuanToko');
    // }
    $query = $this->db->query("SELECT trt.*, tr.tgl_jemput, tt.nama_toko, tt.alamat from tb_pengajuan_toko trt
    JOIN tb_retur tr on trt.id_retur = tr.id
    JOIN tb_toko tt on tr.id_toko = tt.id
    WHERE trt.id = '$id'");
    $id_retur = $query->row()->id_retur;
    $data['retur'] = $query->row();
    $data['artikel'] = $this->db->query("SELECT trd.*,tp.kode, tp.nama_produk from tb_retur_detail trd
    join tb_produk tp on trd.id_produk = tp.id
    where trd.id_retur = ?  order by tp.nama_produk desc ", array($id_retur))->result();
    $data['aset'] = $this->db->query("SELECT tra.*, ta.aset, ta.kode from tb_retur_aset tra
    join tb_aset_master ta on tra.id_aset = ta.id
    where tra.id_retur = ?  order by ta.aset desc ", array($id_retur))->result();
    $data['histori'] = $this->db->query("SELECT * from tb_retur_histori tro
    join tb_retur tr on tro.id_retur = tr.id where tro.id_retur = '$id_retur'")->result();
    $this->template->load('template/template', 'adm/toko/toko_tutup_d', $data);
  }
  // tindakan tutup toko
  public function tindakan()
  {
    $catatan      = $this->input->post('catatan_direksi');
    $action       = $this->input->post('tindakan');
    $id_pengajuan = $this->input->post('id_pengajuan');
    $id_retur     = $this->input->post('id_retur');
    $id_toko      = $this->input->post('id_toko');
    $pembuat      = $this->input->post('pembuat');
    $id_direksi   = $this->session->userdata('id');
    $mm           = $this->session->userdata('nama_user');
    $pt           = $this->session->userdata('pt');
    $aksi         = $action == "4" ? 'Disetujui' : 'Ditolak';

    $this->db->trans_start();

    // Insert history retur
    $histori = [
      'id_retur'   => $id_retur,
      'aksi'       => $aksi . ' oleh : ',
      'pembuat'    => $mm,
      'catatan_h'  => $catatan
    ];
    $this->db->insert('tb_retur_histori', $histori);

    $get_toko = $this->db->query("SELECT nama_toko FROM tb_toko WHERE id = '$id_toko'")
      ->row()->nama_toko;

    if ($action == "4") {
      // Update status setuju
      $this->db->update('tb_pengajuan_toko', ['status' => 6, 'id_direksi' => $id_direksi], ['id' => $id_pengajuan]);
      $this->db->update('tb_toko', ['status' => 7], ['id' => $id_toko]);
      $this->db->update('tb_retur', ['status' => 13], ['id' => $id_retur]);
    } else {
      // Update status tolak
      $this->db->update('tb_pengajuan_toko', ['status' => 5, 'id_direksi' => $id_direksi], ['id' => $id_pengajuan]);
    }

    $this->db->trans_complete();

    // ====== Kirim respon ke user dulu ======
    tampil_alert('success', 'BERHASIL', 'Pengajuan Tutup Toko berhasil di' . $aksi);
    redirect(base_url('adm/Toko/toko_tutup_d/' . $id_pengajuan));

    // ====== Kirim WA di background ======
    // Gunakan fastcgi_finish_request() agar respon ke browser selesai
    if (function_exists('fastcgi_finish_request')) {
      fastcgi_finish_request();
    }

    // Ambil nomor WA setelah respon dikirim
    if ($action == "4") {
      $phones   = $this->db->query("SELECT no_telp FROM tb_user WHERE id = '$pembuat'")->row()->no_telp;
      $telp_Acc = $this->db->query("SELECT no_telp FROM tb_user WHERE role = '15' AND status = '1'")->row()->no_telp;

      // Pesan untuk pembuat
      $message_pembuat = "Pengajuan Tutup Toko ( $get_toko - $pt ) anda disetujui, silakan kunjungi s.id/absi-app.";
      kirim_wa($phones, $message_pembuat);

      // Pesan untuk akun role 15 (accounting)
      $message_acc = "Proses penutupan toko ( $get_toko - $pt ) telah disetujui oleh direksi. Silakan lakukan pengecekan untuk suspend.";
      kirim_wa($telp_Acc, $message_acc);
    } else {
      $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE id = '$pembuat'")->row()->no_telp;
      $message = "Pengajuan Tutup Toko ( " . $get_toko . " - " . $pt . " ) anda Di Tolak, silahkan kunjungi s.id/absi-app";
      kirim_wa($phones, $message);
    }
  }
  public function update($id)
  {
    $data['title'] = 'Toko';
    $query = $this->db->query("SELECT tb_toko.*, tb_user.nama_user as spg from tb_toko
    left join tb_user on tb_toko.id_spg = tb_user.id 
    where tb_toko.id = '$id'");
    $data['detail'] = $query->row();
    $id_prov = $query->row()->provinsi;
    $id_kab = $query->row()->kabupaten;
    $data['provinsi'] = $this->db->query("SELECT * from wilayah_provinsi")->result();
    $data['kabupaten'] = $this->db->query("SELECT * from wilayah_kabupaten where provinsi_id = '$id_prov'")->result();
    $data['kecamatan'] = $this->db->query("SELECT * from wilayah_kecamatan where kabupaten_id = '$id_kab'")->result();
    $data['customer'] = $this->db->query("SELECT * from tb_customer")->result();

    $data['supervisor'] = $this->db->query("SELECT * from tb_user where role ='2' and status ='1'")->result();
    $data['leader'] = $this->db->query("SELECT * from tb_user where role ='3' and status ='1'")->result();
    $data['spg'] = $this->db->query("SELECT * from tb_user where role ='4' and status ='1'")->result();
    $this->template->load('template/template', 'adm/toko/update', $data);
  }
  function add_ajax_kab($id_prov)
  {
    $this->db->select('id, nama'); // Pilih kolom yang ingin Anda sertakan dalam respons JSON
    $query = $this->db->get_where('wilayah_kabupaten', array('provinsi_id' => $id_prov));

    $kabupaten = $query->result(); // Ambil hasil query

    header('Content-Type: application/json'); // Tentukan tipe konten sebagai JSON
    echo json_encode($kabupaten); // Keluarkan data dalam format JSON
  }
  function add_ajax_kec($id_kab)
  {
    $this->db->select('id, nama'); // Pilih kolom yang ingin Anda sertakan dalam respons JSON
    $query = $this->db->get_where('wilayah_kecamatan', array('kabupaten_id' => $id_kab));

    $kecamatan = $query->result(); // Ambil hasil query

    header('Content-Type: application/json'); // Tentukan tipe konten sebagai JSON
    echo json_encode($kecamatan); // Keluarkan data dalam format JSON
  }

  public function proses_update()
  {
    $id_toko = $this->input->post('id_toko');
    $nama_toko = $this->input->post('nama_toko');
    $customer = $this->input->post('customer');
    $jenis_toko = $this->input->post('jenis_toko');
    $pic = $this->input->post('pic');
    $no_telp = $this->input->post('no_telp');
    $tgl_so = $this->input->post('tgl_so');
    $het = $this->input->post('het');
    $diskon = $this->input->post('diskon');
    $ssr = $this->input->post('ssr');
    $max_po = $this->input->post('max_po');
    $batas_po = $this->input->post('batas_po');
    $limit = $this->input->post('limit');
    $provinsi = $this->input->post('provinsi');
    $kabupaten = $this->input->post('kabupaten');
    $kecamatan = $this->input->post('kecamatan');
    $alamat = $this->input->post('alamat');
    $gudang = $this->input->post('gudang');

    $target = $this->input->post('target');
    $updated = date('Y-m-d H:i:s');

    $data = array(
      'jenis_toko' => $jenis_toko,
      'nama_toko' => $nama_toko,
      'id_customer' => $customer,
      'nama_pic' => $pic,
      'telp' => $no_telp,
      'tgl_so' => $tgl_so,
      'het' => $het,
      'diskon' => $diskon,
      'ssr' => $ssr,
      'max_po' => $max_po,
      'limit_toko' => str_replace(['Rp. ', '.'], '', $limit),
      'provinsi' => $provinsi,
      'kabupaten' => $kabupaten,
      'kecamatan' => $kecamatan,
      'alamat' => $alamat,
      'gudang' => $gudang,
      'status_ssr' => $batas_po,
      'target' => str_replace(['Rp. ', '.'], '', $target),
      'updated_at' => $updated
    );
    $where = array(
      'id' => $id_toko
    );
    $this->db->update('tb_toko', $data, $where);
    tampil_alert('success', 'Berhasil', 'Data Toko berhasil di Perbaharui!');
    redirect(base_url('adm/Toko/profil/' . $id_toko));
  }
  public function update_toko()
  {
    $id_toko = $this->input->post('id_toko');
    $nama_toko = $this->input->post('nama_toko');
    $this->db->update('tb_toko', array('nama_toko' => $nama_toko), array('id' => $id_toko));
    tampil_alert('success', 'Berhasil', 'Data Toko berhasil di Perbaharui!');
    redirect(base_url('adm/Toko/profil/' . $id_toko));
  }
  public function update_foto()
  {
    $id_toko = $this->input->post('id_toko_foto');
    $config['upload_path'] = 'assets/img/toko/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = '5048';
    $config['file_name'] = "toko_" . $id_toko;
    $config['overwrite'] = TRUE;
    $config['remove_spaces'] = TRUE;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if (!$this->upload->do_upload('foto')) {
      $error = $this->upload->display_errors();
      tampil_alert('error', 'Gagal', $error);
      redirect(base_url('adm/Toko/profil/' . $id_toko));
    } else {
      $foto = $this->upload->data('file_name');
      $this->db->query("UPDATE tb_toko SET foto_toko = ? WHERE id = ?", array($foto, $id_toko));
      tampil_alert('success', 'Berhasil', 'Foto Toko berhasil di Perbaharui!');
      redirect(base_url('adm/Toko/profil/' . $id_toko));
    }
  }
  public function update_detail()
  {
    $id_toko = $this->input->post('id_toko_detail');
    $id_cust = $this->input->post('id_cust');
    $jenis_toko = $this->input->post('jenis_toko');
    $pic = $this->input->post('pic');
    $telp = $this->input->post('telp');
    $provinsi = $this->input->post('provinsi');
    $kabupaten = $this->input->post('kabupaten');
    $kecamatan = $this->input->post('kecamatan');
    $alamat = $this->input->post('alamat');
    $detail = array(
      'id_customer' => $id_cust,
      'jenis_toko' => $jenis_toko,
      'nama_pic' => $pic,
      'telp' => $telp,
      'provinsi' => $provinsi,
      'kabupaten' => $kabupaten,
      'kecamatan' => $kecamatan,
      'alamat' => $alamat,
    );
    $this->db->update('tb_toko', $detail, array('id' => $id_toko));
    tampil_alert('success', 'Berhasil', 'Data Toko berhasil di Perbaharui!');
    redirect(base_url('adm/Toko/profil/' . $id_toko));
  }
  public function update_pengaturan()
  {
    $id_toko = $this->input->post('id_toko_pengaturan');
    $gudang = $this->input->post('gudang');
    $tgl_so = $this->input->post('tgl_so');
    $margin = $this->input->post('margin');
    $target = $this->input->post('target');
    $het = $this->input->post('het');
    $detail = array(
      'gudang' => $gudang,
      'tgl_so' => $tgl_so,
      'diskon' => $margin,
      'target' => str_replace(['Rp. ', '.'], '', $target),
      'het' => $het
    );
    $this->db->update('tb_toko', $detail, array('id' => $id_toko));
    tampil_alert('success', 'Berhasil', 'Data Toko berhasil di Perbaharui!');
    redirect(base_url('adm/Toko/profil/' . $id_toko));
  }
  public function update_po()
  {
    $id_toko = $this->input->post('id_toko_po');
    $batas_po = $this->input->post('batas_po');
    $ssr = $this->input->post('ssr');
    $max_po = $this->input->post('max_po');
    $detail = array(
      'status_ssr' => $batas_po,
      'ssr' => $ssr,
      'max_po' => $max_po
    );
    $this->db->update('tb_toko', $detail, array('id' => $id_toko));
    tampil_alert('success', 'Berhasil', 'Data Toko berhasil di Perbaharui!');
    redirect(base_url('adm/Toko/profil/' . $id_toko));
  }
  public function update_marketing()
  {
    $id_toko = $this->input->post('id_toko_marketing');
    $spv = $this->input->post('id_spv');
    $leader = $this->input->post('id_leader');
    $spg = $this->input->post('id_spg');
    $detail = array(
      'id_spv' => $spv,
      'id_leader' => $leader,
      'id_spg' => $spg
    );
    $this->db->update('tb_toko', $detail, array('id' => $id_toko));
    tampil_alert('success', 'Berhasil', 'Data Toko berhasil di Perbaharui!');
    redirect(base_url('adm/Toko/profil/' . $id_toko));
  }
  public function profil($id_toko)
  {
    $data['title']         = 'Toko';
    $query = $this->db->query("SELECT tt.*,tcs.nama_cust, tp.nama as provinsi,tk.nama as kabupaten,
    tc.nama as kecamatan, tt.provinsi as id_provinsi, tt.kabupaten as id_kab, tt.kecamatan as id_kec, tg.nama_user as spg, tl.nama_user as leader, ts.nama_user as nama_spv from tb_toko tt
     join wilayah_provinsi tp on tt.provinsi = tp.id
     join wilayah_kabupaten tk on tt.kabupaten = tk.id
     join wilayah_kecamatan tc on tt.kecamatan = tc.id
     join tb_customer tcs on tt.id_customer = tcs.id
     LEFT join tb_user tg on tt.id_spg = tg.id
     LEFT join tb_user tl on tt.id_leader = tl.id
     LEFT join tb_user ts on tt.id_spv = ts.id
     where tt.id = '$id_toko'")->row();
    $data['toko']          = $query;
    $data['cek_status_stok']  = $this->db->query("SELECT status from tb_stok where id_toko = '$id_toko' and status = 2 ")->num_rows();
    $ssr = $this->db->query("SELECT ssr from tb_toko where id = '$id_toko'")->row()->ssr;
    $data['stok_produk'] = $this->db->query("
        SELECT tb_produk.*, tb_stok.qty,tb_stok.updated_at, COALESCE(ROUND(AVG(penjualan_3_bulan.qty), 0), 0) * '$ssr' as ssr
        FROM tb_produk
        JOIN tb_stok ON tb_produk.id = tb_stok.id_produk AND tb_stok.id_toko = '$id_toko'
        LEFT JOIN (
            SELECT tb_penjualan_detail.id_produk, AVG(tb_penjualan_detail.qty) as qty
            FROM tb_penjualan_detail
            JOIN tb_penjualan ON tb_penjualan_detail.id_penjualan = tb_penjualan.id
            WHERE tb_penjualan.id_toko = '$id_toko'
                AND tb_penjualan.tanggal_penjualan >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
            GROUP BY tb_penjualan_detail.id_produk
        ) as penjualan_3_bulan ON tb_produk.id = penjualan_3_bulan.id_produk
        WHERE tb_stok.id_toko = '$id_toko'
        GROUP BY tb_produk.id
    ")->result();
    $data['list_produk'] = $this->db->query("SELECT * from tb_produk where id not in (select id_produk from tb_stok where id_toko = '$id_toko') ")->result();
    $data['cek_status'] = $this->db->query("SELECT status from tb_toko where id = '$id_toko'")->row();
    $data['customer'] = $this->db->query("SELECT * from tb_customer")->result();
    $data['spv'] = $this->db->query("SELECT * from tb_user where role = 2 AND status = 1")->result();
    $data['leader'] = $this->db->query("SELECT * from tb_user where role = 3 AND status = 1")->result();
    $data['spg'] = $this->db->query("SELECT * from tb_user where role = 4 AND status = 1")->result();
    $id_prov = $query->id_provinsi;
    $id_kab = $query->id_kab;
    $data['provinsi'] = $this->db->query("SELECT * from wilayah_provinsi")->result();
    $data['kabupaten'] = $this->db->query("SELECT * from wilayah_kabupaten where provinsi_id = '$id_prov'")->result();
    $data['kecamatan'] = $this->db->query("SELECT * from wilayah_kecamatan where kabupaten_id = '$id_kab'")->result();
    $this->template->load('template/template', 'adm/toko/profil', $data);
  }
  public function detail_toko($id_toko)
  {
    $data['title']         = 'List Toko Tutup';
    $query = $this->db->query("SELECT tt.*,tcs.nama_cust, tp.nama as provinsi,tk.nama as kabupaten,
    tc.nama as kecamatan, tt.provinsi as id_provinsi, tt.kabupaten as id_kab, tt.kecamatan as id_kec, tg.nama_user as spg, tl.nama_user as leader, ts.nama_user as nama_spv from tb_toko tt
     join wilayah_provinsi tp on tt.provinsi = tp.id
     join wilayah_kabupaten tk on tt.kabupaten = tk.id
     join wilayah_kecamatan tc on tt.kecamatan = tc.id
     join tb_customer tcs on tt.id_customer = tcs.id
     LEFT join tb_user tg on tt.id_spg = tg.id
     LEFT join tb_user tl on tt.id_leader = tl.id
     LEFT join tb_user ts on tt.id_spv = ts.id
     where tt.id = '$id_toko'")->row();
    $data['toko']          = $query;
    $data['cek_status_stok']  = $this->db->query("SELECT status from tb_stok where id_toko = '$id_toko' and status = 2 ")->num_rows();
    $ssr = $this->db->query("SELECT ssr from tb_toko where id = '$id_toko'")->row()->ssr;
    $data['stok_produk'] = $this->db->query("
        SELECT tb_produk.*, tb_stok.qty,tb_stok.updated_at, COALESCE(ROUND(AVG(penjualan_3_bulan.qty), 0), 0) * '$ssr' as ssr
        FROM tb_produk
        JOIN tb_stok ON tb_produk.id = tb_stok.id_produk AND tb_stok.id_toko = '$id_toko'
        LEFT JOIN (
            SELECT tb_penjualan_detail.id_produk, AVG(tb_penjualan_detail.qty) as qty
            FROM tb_penjualan_detail
            JOIN tb_penjualan ON tb_penjualan_detail.id_penjualan = tb_penjualan.id
            WHERE tb_penjualan.id_toko = '$id_toko'
                AND tb_penjualan.tanggal_penjualan >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
            GROUP BY tb_penjualan_detail.id_produk
        ) as penjualan_3_bulan ON tb_produk.id = penjualan_3_bulan.id_produk
        WHERE tb_stok.id_toko = '$id_toko'
        GROUP BY tb_produk.id
    ")->result();
    $data['list_produk'] = $this->db->query("SELECT * from tb_produk where id not in (select id_produk from tb_stok where id_toko = '$id_toko') ")->result();
    $data['cek_status'] = $this->db->query("SELECT status from tb_toko where id = '$id_toko'")->row();
    $data['customer'] = $this->db->query("SELECT * from tb_customer")->result();
    $data['spv'] = $this->db->query("SELECT * from tb_user where role = 2 AND status = 1")->result();
    $data['leader'] = $this->db->query("SELECT * from tb_user where role = 3 AND status = 1")->result();
    $data['spg'] = $this->db->query("SELECT * from tb_user where role = 4 AND status = 1")->result();
    $id_prov = $query->id_provinsi;
    $id_kab = $query->id_kab;
    $data['provinsi'] = $this->db->query("SELECT * from wilayah_provinsi")->result();
    $data['kabupaten'] = $this->db->query("SELECT * from wilayah_kabupaten where provinsi_id = '$id_prov'")->result();
    $data['kecamatan'] = $this->db->query("SELECT * from wilayah_kecamatan where kabupaten_id = '$id_kab'")->result();
    $this->template->load('template/template', 'adm/toko/profil', $data);
  }

  public function tambah_produk()
  {
    $id_produk = $this->input->post('id_produk');
    $id_toko = $this->input->post('id_toko');
    $data = array(
      'id_produk' => $id_produk,
      'id_toko' => $id_toko,
      'status' => '1',
      'updated_at' => date('Y-m-d H:i:s')
    );

    $this->db->insert('tb_stok', $data);
    tampil_alert('success', 'Berhasil', 'Artikel berhasil di tambahkan.');
    redirect(base_url('adm/toko/profil/' . $id_toko));
  }

  // download pdf
  public function unduh_pdf($id_toko)
  {
    // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
    $this->load->library('pdfgenerator');
    // title dari pdf
    $data['title_pdf'] = 'Berkas Toko';
    // filename dari pdf ketika didownload
    $file_pdf = 'Berkas_toko';
    // setting paper
    $paper = 'A4';
    //orientasi paper potrait / landscape 
    $orientation = "portrait";
    // menampilkan Data Toko
    $data['data_toko'] = $this->db->query("SELECT tt.*, tp.nama as provinsi,tk.nama as kabupaten,tc.nama as kecamatan, tt.provinsi as id_provinsi from tb_toko tt
        join wilayah_provinsi tp on tt.provinsi = tp.id
        join wilayah_kabupaten tk on tt.kabupaten = tk.id
        join wilayah_kecamatan tc on tt.kecamatan = tc.id
        where tt.id = '$id_toko'")->row();
    // nama Customer
    $data['customer']   = $this->db->query("SELECT tc.* from tb_customer tc
       join tb_toko on tc.id = tb_toko.id_customer
       where tb_toko.id = '$id_toko'")->row();
    // nama spv
    $data['spv']   = $this->db->query("SELECT tt.*, tb_user.nama_user
        from tb_toko tt
        left join tb_user on tt.id_spv = tb_user.id
        where tt.id = '$id_toko'
        ")->row();
    //  lihat leader toko
    $data['leader_toko']   = $this->db->query("SELECT tt.*, tb_user.nama_user
      from tb_toko tt
      left join tb_user on tt.id_leader = tb_user.id
      where tt.id = '$id_toko'
      ")->row();
    //  lihat spg
    $data['spg']   = $this->db->query("SELECT tt.*,tb_user.nama_user 
      from tb_toko tt
      left join tb_user on tt.id_spg = tb_user.id
      where tt.id = '$id_toko'
      ")->row();
    $html = $this->load->view('adm/toko/unduh', $data, true);
    // run dompdf
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
  // export file template stok
  public function templateStok($id_toko)
  {
    $query = $this->db->query("SELECT tp.kode, ts.qty,ts.id_toko,tt.nama_toko from tb_stok ts
    join tb_produk tp on ts.id_produk = tp.id
    join tb_toko tt on ts.id_toko = tt.id
    WHERE ts.id_toko = '$id_toko'");
    if ($query->num_rows() > 0) {
      $toko = $query->row();
      $detail = $query->result();
      // Create a new Spreadsheet instance
      $spreadsheet = new Spreadsheet();
      $worksheet = $spreadsheet->getActiveSheet();
      $worksheet->setTitle($toko->nama_toko);
      $worksheet->getStyle('A1:E1')->getFont()->setBold(true);
      $worksheet->getStyle('A1:E1')
        ->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('FFFF00'); // Kode warna kuning (FFFF00)
      $worksheet->setCellValue('A1', 'NO URUT');
      $worksheet->setCellValue('B1', 'ID TOKO (jangan di rubah)');
      $worksheet->setCellValue('C1', 'KODE ARTIKEL');
      $worksheet->setCellValue('D1', 'STOK SISTEM');
      $worksheet->setCellValue('E1', 'STOK TERBARU (kolom ini yang harus di isi)');

      $row = 2; // Start from the second row
      $no = 1; // Nomor urut
      foreach ($detail as $data) {
        // Set values for each row
        $worksheet->setCellValue('A' . $row, $no);
        $worksheet->setCellValue('B' . $row, $data->id_toko);
        $worksheet->setCellValue('C' . $row, $data->kode);
        $worksheet->setCellValue('D' . $row, $data->qty);
        $row++;
        $no++;
      }
      // Create Excel writer
      $writer = new Xlsx($spreadsheet);
      // Set headers for file download
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $toko->nama_toko . '.xlsx"');
      // Save Excel file to PHP output stream
      ob_end_clean();
      $writer->save('php://output');
      exit();
    } else {
      $cek = $this->db->query("SELECT * from tb_toko where id='$id_toko'");
      $dataToko = $cek->row();
      // Create a new Spreadsheet instance
      $spreadsheet = new Spreadsheet();
      $worksheet = $spreadsheet->getActiveSheet();
      $worksheet->setTitle($dataToko->nama_toko);
      $worksheet->getStyle('A1:E1')->getFont()->setBold(true);
      $worksheet->getStyle('A1:E1')
        ->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('FFFF00'); // Kode warna kuning (FFFF00)
      $worksheet->setCellValue('A1', 'NO URUT');
      $worksheet->setCellValue('B1', 'ID TOKO (Jangan di Ganti)');
      $worksheet->setCellValue('C1', 'KODE ARTIKEL');
      $worksheet->setCellValue('D1', 'STOK SISTEM');
      $worksheet->setCellValue('E1', 'STOK TERBARU (kolom ini yang harus di isi)');
      $worksheet->setCellValue('A2', '1');
      $worksheet->setCellValue('B2', $dataToko->id);
      $worksheet->setCellValue('C2', 'kode artikel disini');
      $worksheet->setCellValue('D2', '0');
      $worksheet->setCellValue('E2', '0');
      // Create Excel writer
      $writer = new Xlsx($spreadsheet);
      // Set headers for file download
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $dataToko->nama_toko . '.xlsx"');
      // Save Excel file to PHP output stream
      ob_end_clean();
      $writer->save('php://output');
      exit();
    }
  }
  // import Stok
  public function importStok()
  {
    $username = $this->session->userdata('username');
    $this->load->library('user_agent');
    $file = $_FILES['file']['tmp_name'];

    if (!$file) {
      tampil_alert('error', 'GAGAL', 'File tidak ditemukan.');
      redirect(base_url('adm/Toko/displayImportStatus'));
      return;
    }

    try {
      $reader = IOFactory::createReader('Xlsx');
      $spreadsheet = $reader->load($file);
      $worksheet = $spreadsheet->getActiveSheet();
      $rows = $worksheet->toArray();
    } catch (Exception $e) {
      tampil_alert('error', 'GAGAL', 'Gagal membaca file.');
      redirect(base_url('adm/Toko/displayImportStatus'));
      return;
    }

    $import_status = []; // Array to store import status for each code
    $this->db->trans_start();

    for ($i = 1; $i < count($rows); $i++) {
      $row = $rows[$i];
      $id_toko = intval($row[1]);
      $kode = trim($row[2]);
      $stok = trim($row[4]);

      $idproduk = null;
      $cariId = $this->db->get_where('tb_produk', array('kode' => $kode));

      if ($cariId->num_rows() > 0) {
        $idproduk = $cariId->row()->id;
      }

      date_default_timezone_set('Asia/Jakarta');
      $tanggal_sekarang = date("Y-m-d H:i:s");

      if ($idproduk !== null) {
        $query = $this->db->get_where('tb_stok', array('id_produk' => $idproduk, 'id_toko' => $id_toko));
        $existing_stok = $query->row();

        if ($existing_stok) {
          $data_update = array(
            'qty' => $stok,
            'qty_awal' => $stok,
            'updated_at' => $tanggal_sekarang,
          );
          $where = array(
            'id_produk' => $idproduk,
            'id_toko' => $id_toko,
          );
          $this->db->update('tb_stok', $data_update, $where);
          $import_status[$kode] = '<text style="color:green;">BERHASIL DIUPDATE</text>';
        } else {
          $data_insert = array(
            'qty' => $stok,
            'qty_awal' => $stok,
            'updated_at' => $tanggal_sekarang,
            'id_produk' => $idproduk,
            'id_toko' => $id_toko,
          );
          $this->db->insert('tb_stok', $data_insert);
          $import_status[$kode] = '<text style="color:green;">BERHASIL DITAMBAHKAN</text>';
        }

        // Insert into tb_kartu_stok
        $stok_awal = $this->db->get_where('tb_stok', array('id_produk' => $idproduk, 'id_toko' => $id_toko))->row()->qty;
        $kartu = array(
          'no_doc' => 'import stok',
          'id_produk' => $idproduk,
          'id_toko' => $id_toko,
          'stok' => $stok_awal,
          'sisa' => $stok,
          'keterangan' => 'import stok',
          'pembuat' => $username
        );
        $this->db->insert('tb_kartu_stok', $kartu);
      } else {
        $import_status[$kode] = '<text style="color:red;">KODE BELUM TERDAFTAR.</text>';
      }
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      tampil_alert('error', 'GAGAL', 'Gagal Import Data.');
    } else {
      $this->db->trans_commit();
      tampil_alert('success', 'Berhasil', 'DATA BERHASIL DI IMPORT');
    }

    // Store the import status in a session variable
    $this->session->set_userdata('import_status', $import_status);

    // Redirect back to the product list
    redirect(base_url('adm/Toko/displayImportStatus/' . $id_toko));
  }

  public function displayImportStatus($id_toko)
  {
    $data['title']         = 'Toko';
    $data['import_status'] = $this->session->userdata('import_status');
    $data['toko'] = $this->db->query("SELECT * from tb_toko where id = '$id_toko'")->row();
    $this->template->load('template/template', 'adm/toko/status_import', $data);
  }
  public function cari_kartu()
  {
    $id_toko = $this->input->get('id_toko');
    $id_artikel = $this->input->get('id_artikel');

    // Ensure the inputs are properly sanitized and validated
    $id_toko = intval($id_toko);
    $id_artikel = intval($id_artikel);
    $tabel_data = $this->db->query(
      "SELECT *, COALESCE(masuk, '-') as masuk, COALESCE(keluar, '-') as keluar  
      FROM tb_kartu_stok 
      WHERE id_toko = ? AND id_produk = ? 
      AND tanggal IN (
          SELECT tanggal 
          FROM (
              SELECT tanggal 
              FROM tb_kartu_stok 
              WHERE id_toko = ? AND id_produk = ?
              ORDER BY tanggal DESC 
          ) AS latest_dates
      )
      ORDER BY id ASC",
      array($id_toko, $id_artikel, $id_toko, $id_artikel)
    )->result();

    // Determine s_awal and s_akhir
    $s_awal = !empty($tabel_data) ? $tabel_data[0]->stok : 0;
    $s_akhir = !empty($tabel_data) ? end($tabel_data)->sisa : 0;

    // Ensure we handle cases where there might be no data
    $data = [
      'tabel_data' => $tabel_data,
      's_awal' => $s_awal,
      's_akhir' => $s_akhir,
    ];

    echo json_encode($data);
  }
  public function histori($id)
  {
    $histori = $this->db->query("SELECT * from tb_toko_histori where id_toko ='$id'")->result();

    // Format data untuk dikirim kembali sebagai JSON
    if ($histori) {
      $response = [
        'status' => 'success',
        'data' => $histori
      ];
    } else {
      $response = [
        'status' => 'error',
        'message' => 'Histori tidak ditemukan'
      ];
    }

    // Kirimkan sebagai JSON
    header('Content-Type: application/json');
    echo json_encode($response);
  }
  public function fpo($id)
  {
    $cek = $this->db->query("SELECT * from tb_pengajuan_toko where id = '$id'")->row();
    $id_toko = $cek->id_toko;
    $data['catatan'] = $this->db->query("SELECT catatan from tb_toko_histori where id_toko = '$id_toko' ORDER BY id asc LIMIT 1")->row()->catatan;
    $data['r'] = $this->db->query("SELECT tpt.*,spv.nama_user as nama_spv, spv.ttd as ttd_spv, mm.nama_user as nama_mm, mm.ttd as ttd_mm,
    dir.nama_user as nama_dir, dir.ttd as ttd_dir, tt.*, ts.nama_user as spg FROM tb_pengajuan_toko tpt
    JOIN tb_toko tt on tpt.id_toko = tt.id
    left join tb_user ts on tt.id_spg = ts.id
    join tb_user spv on tpt.id_pembuat = spv.id
    join tb_user mm on tpt.id_mm = mm.id
    join tb_user dir on tpt.id_direksi = dir.id
    WHERE tpt.id = '$id'")->row();
    $this->load->view('adm/toko/fpo', $data);
  }
  public function fpo_tutup($id)
  {
    $cek = $this->db->query("SELECT * from tb_pengajuan_toko where id = '$id'")->row();
    $id_retur = $cek->id_retur;
    $data['catatan'] = $this->db->query("SELECT catatan_h from tb_retur_histori where id_retur = '$id_retur' ORDER BY id asc LIMIT 1")->row()->catatan_h;
    $data['r'] = $this->db->query("SELECT tpt.*,spv.nama_user as nama_spv, spv.ttd as ttd_spv, mm.nama_user as nama_mm, mm.ttd as ttd_mm,
    dir.nama_user as nama_dir, dir.ttd as ttd_dir, tt.*, ts.nama_user as spg FROM tb_pengajuan_toko tpt
    JOIN tb_toko tt on tpt.id_toko = tt.id
    left join tb_user ts on tt.id_spg = ts.id
    join tb_user spv on tpt.id_pembuat = spv.id
    join tb_user mm on tpt.id_mm = mm.id
    join tb_user dir on tpt.id_direksi = dir.id
    WHERE tpt.id = '$id'")->row();
    $this->load->view('adm/toko/fpo_tutup', $data);
  }
  // import Stok
  public function update_nama()
  {
    $this->db->trans_start();
    $total_updated = 0;

    if (!empty($_FILES['file_excel']['name'])) {
      $file = $_FILES['file_excel']['tmp_name'];
      $spreadsheet = IOFactory::load($file);
      $sheet = $spreadsheet->getActiveSheet();
      $data = $sheet->toArray();

      $this->load->database();

      foreach ($data as $key => $row) {
        if ($key == 0) continue; // Skip header

        $toko_lama = trim($row[1]);
        $toko_baru = trim($row[2]);

        if (!empty($toko_lama) && !empty($toko_baru)) {
          $this->db->where('nama_toko', $toko_lama);
          $this->db->update('tb_toko', ['nama_toko' => $toko_baru]);

          if ($this->db->affected_rows() > 0) {
            $total_updated++;
          }
        }
      }

      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        tampil_alert('error', 'GAGAL', 'Gagal Import Data.');
      } else {
        $this->db->trans_commit();
        tampil_alert('success', 'Berhasil', "DATA BERHASIL DI IMPORT. Total: $total_updated");
      }
    } else {
      tampil_alert('error', 'GAGAL', 'Gagal mengunggah file!');
    }
    redirect('adm/Toko');
  }

  public function Suspend($id_pengajuan)
  {
    $pembuat = $this->session->userdata('nama_user');
    // Ambil data pengajuan untuk mendapatkan id_toko
    $pengajuan = $this->db->get_where('tb_pengajuan_toko', ['id' => $id_pengajuan])->row();
    if (!$pengajuan) {
      tampil_alert('error', 'Gagal', 'Data pengajuan tidak ditemukan.');
      redirect('adm/Toko/toko_tutup');
      return;
    }

    // Update status tb_pengajuan_toko menjadi 4 (Selesai)
    $this->db->where('id', $id_pengajuan)->update('tb_pengajuan_toko', ['status' => 4]);

    // Update status tb_toko menjadi 0 (Nonaktif)
    $this->db->where('id', $pengajuan->id_toko)->update('tb_toko', [
      'status' => 0,
      'tgl_suspend' => date('Y-m-d H:i:s')
    ]);
    $this->db->where('id_toko', $pengajuan->id_toko)->update('tb_stok', [
      'qty' => 0
    ]);

    // input ke history
    $histori = array(
      'id_toko' => $pengajuan->id_toko,
      'aksi' => 'Suspend Toko oleh :',
      'pembuat' => $pembuat,
      'catatan' => "Toko telah di-suspend & stok telah di-reset ke 0.",
    );
    $this->db->insert('tb_toko_histori', $histori);
    $this->db->trans_complete();
    tampil_alert('success', 'Berhasil', 'Toko berhasil di-suspend.');
    redirect('adm/Toko/toko_tutup');
  }

  public function nonaktifkan()
  {
    $id_toko = $this->input->post('id_toko');
    if (!$id_toko) {
      tampil_alert('error', 'Gagal', 'ID Toko tidak ditemukan.');
      redirect('adm/Toko');
      return;
    }

    $this->db->where('id', $id_toko);
    $this->db->update('tb_toko', ['status' => 0]);

    if ($this->db->affected_rows() > 0) {
      tampil_alert('success', 'Berhasil', 'Toko berhasil dinonaktifkan.');
    } else {
      tampil_alert('error', 'Gagal', 'Toko gagal dinonaktifkan atau sudah nonaktif.');
    }
    redirect('adm/Toko/profil/' . $id_toko);
  }
}
