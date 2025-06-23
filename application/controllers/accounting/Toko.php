<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "15") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }
  public function pengajuanToko()
  {
    $data['title'] = 'Pengajuan Toko';
    $data['pengajuan'] = $this->db->query("SELECT tpt.*, tt.nama_toko, tt.alamat, tc.nama_cust from tb_pengajuan_toko tpt
    JOIN tb_toko tt on tpt.id_toko = tt.id
    JOIN tb_customer tc on tt.id_customer = tc.id
    WHERE tpt.kategori != 3 or (tpt.kategori = 3 and tpt.status = 6)
    order by tpt.id desc")->result();
    $this->template->load('template/template', 'accounting/toko/pengajuanToko', $data);
  }
  public function detail($id)
  {
    $data['title'] = 'Pengajuan Toko';
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
    $this->template->load('template/template', 'accounting/toko/detail', $data);
  }
  public function approve()
  {
    $pt = $this->session->userdata('pt');
    $id = $this->session->userdata('id');
    $audit = $this->session->userdata('nama_user');
    $id_toko = $this->input->post('id_toko');
    $id_pengajuan = $this->input->post('id_pengajuan');
    $toko = $this->input->post('toko');
    $catatan = $this->input->post('catatan');
    $keputusan = $this->input->post('keputusan');
    $this->db->trans_start();
    $this->db->query("UPDATE tb_pengajuan_toko set status = $keputusan where id = '$id_pengajuan'");
    if ($keputusan == 3) {
      $pesan = "Data Toko di teruskan ke Direksi!";
      $aksi = "Di Setujui Oleh AUDIT : ";
      $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE role = 1 and status = 1")->result_array();
      $message = "Anda memiliki 1 Pengajuan Toko Baru ( " . $toko . " - " . $pt . " ) yang perlu approve silahkan kunjungi s.id/absi-app";
    } else {
      $pesan = "Data Toko DI Tolak";
      $aksi = "Di Tolak Oleh AUDIT : ";
      $spv = $this->db->query("SELECT id_spv FROM tb_toko WHERE id = '$id_toko'")->row()->id_spv;
      $phones = $this->db->query("SELECT no_telp FROM tb_user where id = '$spv'")->result_array();
      $message = "Pengajuan Toko ( " . $toko . " - " . $pt . " ) anda DI TOLAK, Silahkan ajukan kembali dengan data yang benar,  s.id/absi-app";
    }
    $histori = array(
      'id_toko' => $id_toko,
      'aksi' => $aksi,
      'pembuat' => $audit,
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
    tampil_alert('success', 'Berhasil di Proses', $pesan);
    redirect(base_url('accounting/Toko/detail/' . $id_pengajuan));
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
    $html = $this->load->view('audit/toko/unduh', $data, true);
    // run dompdf
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
  public function unduh_excel($id_toko)
  {

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
    $this->load->view('audit/toko/unduh_excel', $data);
  }
}
