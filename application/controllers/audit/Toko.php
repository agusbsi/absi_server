<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "10") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_spv');
  }

  // tampil data Aset
  public function index()
  {
    $data['title'] = 'Toko';
    $data['toko'] = $this->db->query("SELECT tt.*, tu.nama_user
    from tb_toko tt
    left join tb_user tu on tt.id_spg = tu.id
    where tt.status = 1
    ORDER BY tt.id desc")->result();
    $this->template->load('template/template', 'audit/toko/lihat_data', $data);
  }
  public function pengajuanToko()
  {
    $data['title'] = 'Pengajuan Toko';
    $data['toko'] = $this->db->query("SELECT tt.*, tu.nama_user
    from tb_toko tt
    left join tb_user tu on tt.id_spg = tu.id
    where tt.status != 1 AND tt.status != 0
    ORDER BY FIELD(tt.status, 3) DESC, tt.id DESC")->result();
    $this->template->load('template/template', 'audit/toko/pengajuanToko', $data);
  }
  public function detail($id)
  {
    $data['title'] = 'Pengajuan Toko';
    $data['toko'] = $this->db->query("SELECT tt.*, tc.nama_cust,tc.top,tc.foto_ktp,tc.foto_npwp,tc.alamat_cust, tp.nama_user as spv,tl.nama_user as leader, ts.nama_user as spg from tb_toko tt
    join tb_customer tc on tt.id_customer = tc.id
    left join tb_user tl on tt.id_leader = tl.id
    left join tb_user ts on tt.id_spg = ts.id
    join tb_user tp on tt.id_spv = tp.id
    where tt.id = '$id'")->row();
    $this->template->load('template/template', 'audit/toko/detail', $data);
  }

  // Script profil toko
  public function profil($id_toko)
  {
    $id_spv = $this->session->userdata('id');
    $data['title']         = 'Toko';
    $data['toko']          = $this->db->query("SELECT tt.*, tp.nama as provinsi,tk.nama as kabupaten,tc.nama as kecamatan, tt.provinsi as id_provinsi from tb_toko tt
     join wilayah_provinsi tp on tt.provinsi = tp.id
     join wilayah_kabupaten tk on tt.kabupaten = tk.id
     join wilayah_kecamatan tc on tt.kecamatan = tc.id
     where tt.id = '$id_toko'")->row();
    //  lihat SPV toko
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
    //  cek status di stok masing" toko
    $data['cek_status_stok']  = $this->db->query("SELECT status from tb_stok where id_toko = '$id_toko' and status = 2 ")->num_rows();
    //  stok produk per toko
    $data['stok_produk']   = $this->db->query("SELECT tb_produk.nama_produk, tb_produk.satuan, tb_stok.*, tb_produk.kode, tb_produk.harga_jawa, tb_produk.harga_indobarat, tb_toko.diskon  from tb_stok
     join tb_produk on tb_stok.id_produk = tb_produk.id
     join tb_toko on tb_stok.id_toko = tb_toko.id
     where tb_stok.id_toko = '$id_toko'")->result();
    // cek status toko
    $data['cek_status'] = $this->db->query("SELECT status from tb_toko where id = '$id_toko'")->row();
    $this->template->load('template/template', 'audit/toko/profil', $data);
  }

  public function approve()
  {
    $pt = $this->session->userdata('pt');
    $id_toko = $this->input->post('id_toko');
    $toko = $this->input->post('toko');
    $catatan = $this->input->post('catatan');
    $keputusan = $this->input->post('keputusan');
    $this->db->query("UPDATE tb_toko set status = $keputusan, catatan_audit = '$catatan' where id = '$id_toko'");
    if ($keputusan == 4) {
      $pesan = "Data Toko di teruskan ke Direksi!";
      $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE role = 1 and status = 1")->result_array();
      $message = "Anda memiliki 1 Pengajuan Toko Baru ( " . $toko . " - " . $pt . " ) yang perlu approve silahkan kunjungi s.id/absi-app";
    } else {
      $pesan = "Data Toko DI Tolak";
      $spv = $this->db->query("SELECT id_spv FROM tb_toko WHERE id = '$id_toko'")->row()->id_spv;
      $phones = $this->db->query("SELECT no_telp FROM tb_user where id = '$spv'")->result_array();
      $message = "Pengajuan Toko ( " . $toko . " - " . $pt . " ) anda DI TOLAK, Silahkan ajukan kembali dengan data yang benar,  s.id/absi-app";
    }
    foreach ($phones as $phone) {
      $number = $phone['no_telp'];
      $hp = substr($number, 0, 1);
      if ($hp == '0') {
        $number = '62' . substr($number, 1);
      }
      kirim_wa($number, $message);
    }
    tampil_alert('success', 'Berhasil di Proses', $pesan);
    redirect(base_url('audit/Toko/pengajuanToko'));
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
  // list SO Adjust
  public function list_adjust()
  {
    $data['title'] = 'Adjust SO';
    $data['so'] = $this->db->query("SELECT ts.*, tt.nama_toko from tb_so_audit ts
    join tb_toko tt on ts.id_toko = tt.id")->result();
    $this->template->load('template/template', 'audit/toko/list_adjust', $data);
  }
  //  ADJUST SO TOKO
  public function adjust_so()
  {
    $data['title'] = 'Adjust SO';
    $data['list_toko']  = $this->db->query("SELECT * from tb_toko where  status = 1")->result();
    $data['kode_retur'] = $this->kode_so();
    $data['list_aset']  = $this->db->query("SELECT * from tb_aset where status = 1 order by nama_aset asc")->result();
    $this->template->load('template/template', 'audit/toko/adjust_so', $data);
  }
  // kode retur
  public function kode_so()
  {
    $q = $this->db->query("SELECT MAX(RIGHT(id,3)) AS kd_max FROM tb_so_audit");
    $kd = "";
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $k) {
        $tmp = ((int)$k->kd_max) + 1;
        $kd = sprintf("%03s", $tmp);
      }
    } else {
      $kd = "001";
    }
    date_default_timezone_set('Asia/Jakarta');
    return "SO-" . date('Y') . "-" . $kd;
  }
  // cek list artikel
  public function artikelToko()
  {
    $id_toko   = $this->input->get('id_toko');
    $data = $this->db->query("SELECT ts.qty,ts.id_produk, tp.kode, tp.nama_produk from tb_stok ts
     join tb_produk tp on ts.id_produk = tp.id
     where id_toko = '$id_toko'")->result();
    echo json_encode($data);
  }
  // simpan hasil so audit
  public function simpan_so_audit()
  {
    $id_user      = $this->session->userdata('id');
    $id_produk    = $this->input->post('id_produk');
    $qty_sistem   = $this->input->post('qty_sistem');
    $qty_input    = $this->input->post('qty_input');
    $no_audit     = $this->input->post('no_audit');
    $catatan      = $this->input->post('catatan');
    $id_toko      = $this->input->post('id_toko');

    // Validate the data or perform any other necessary checks
    $this->db->trans_start();
    // Process the data and insert into the database
    $insertedRows = 0;
    foreach ($id_produk as $index => $id) {
      $data = array(
        'id_produk' => $id,
        'qty_sistem' => $qty_sistem[$index],
        'qty_input' => $qty_input[$index],
        'id_so_audit' => $no_audit,
      );

      // Assuming you have a model to handle database interactions named "YourModel"
      $this->db->insert('tb_so_audit_detail', $data);
      $insertedRows++;
    }
    // simpan data so ke tb_so_audit
    $data_so = array(
      'id'  => $no_audit,
      'id_user'  => $id_user,
      'id_toko'  => $id_toko,
      'catatan'  => $catatan,
    );
    $this->db->insert('tb_so_audit', $data_so);
    $this->db->trans_complete();
    // Prepare the response
    $response = array(
      'success' => true,
      'message' => "Data successfully inserted. Rows inserted: " . $insertedRows,
    );

    // Send the response back to the client
    header('Content-Type: application/json');
    echo json_encode($response);
  }
  public function getdata()
  {
    // Mengambil parameter id_toko dari permintaan Ajax
    $id_penjualan = $this->input->get('id_penjualan');

    // Mengambil data artikel dari tabel tb_stok berdasarkan id_toko
    // Ganti dengan kode Anda untuk mengambil data dari database
    $artikel = $this->db->query("SELECT * from tb_so_audit_detail tpd
       join tb_produk tp on tpd.id_produk = tp.id
       where tpd.id_so_audit = '$id_penjualan'  order by tpd.id desc ");

    if ($artikel->num_rows() > 0) {
      $result = $artikel->result();
      header('Content-Type: application/json'); // Tambahkan header untuk menandakan bahwa respons adalah JSON
      echo json_encode($result);
    } else {
      header('Content-Type: application/json'); // Tambahkan header untuk menandakan bahwa respons adalah JSON
      echo json_encode(array());
    }
  }
}
