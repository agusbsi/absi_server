<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "2" && $role != "3") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_spv');
    $this->load->model('M_spg');
  }
  public function index()
  {
    $id_spv = $this->session->userdata('id');
    $data['title'] = 'Kelola Toko';
    $data['toko'] = $this->db->query("SELECT tt.*, tu.nama_user
    from tb_toko tt
    left join tb_user tu on tt.id_leader = tu.id
    where tt.id_spv = $id_spv AND tt.status = 1 order by tt.id desc")->result();
    $this->template->load('template/template', 'spv/toko/lihat_data', $data);
  }
  public function pengajuanToko()
  {
    $id_spv = $this->session->userdata('id');
    $data['title'] = 'Pengajuan Toko';
    $data['pengajuan'] = $this->db->query("SELECT tpt.*, tt.nama_toko, tt.alamat, tc.nama_cust from tb_pengajuan_toko tpt
    JOIN tb_toko tt on tpt.id_toko = tt.id
    JOIN tb_customer tc on tt.id_customer = tc.id
    WHERE tpt.id_pembuat = '$id_spv'
    order by tpt.id desc")->result();
    $this->template->load('template/template', 'spv/toko/pengajuanToko', $data);
  }
  public function customer()
  {
    $id_spv = $this->session->userdata('id');
    $cekTTD = $this->db->query("SELECT ttd from tb_user where id = ?", array($id_spv))->row();
    if (empty($cekTTD->ttd)) {
      popup('Tanda Tangan Digital', 'Anda harus membuat TTD Digital terlebih dahulu untuk melanjutkan proses Pengajuan Toko', 'Profile');
      redirect('spv/Toko/pengajuanToko');
    }
    $data['title'] = 'Pengajuan Toko';
    $data['list_leader'] = $this->db->query("SELECT * FROM tb_user WHERE role = 3")->result();
    $data['list_spg'] = $this->db->query("SELECT * FROM tb_user WHERE role = 4")->result();
    $get_prov = $this->db->select('*')->from('wilayah_provinsi')->get();
    $data['provinsi'] = $get_prov->result();
    $this->template->load('template/template', 'spv/toko/customer', $data);
  }
  public function toko()
  {
    $id_spv = $this->session->userdata('id');
    $cekTTD = $this->db->query("SELECT ttd from tb_user where id = ?", array($id_spv))->row();
    if (empty($cekTTD->ttd)) {
      popup('Tanda Tangan Digital', 'Anda harus membuat TTD Digital terlebih dahulu untuk melanjutkan proses Pengajuan Toko', 'Profile');
      redirect('spv/Toko/pengajuanToko');
    }
    $data['title'] = 'Pengajuan Toko';
    $data['list_leader'] = $this->db->query("SELECT * FROM tb_user WHERE role = 3 AND status = 1")->result();
    $data['list_spg'] = $this->db->query("SELECT * FROM tb_user WHERE role = 4 AND status = 1")->result();
    $get_prov = $this->db->select('*')->from('wilayah_provinsi')->get();
    $data['provinsi'] = $get_prov->result();
    $data['customer'] = $this->db->query("SELECT * FROM tb_customer WHERE deleted_at is NULL order by id desc")->result();
    $this->template->load('template/template', 'spv/toko/toko', $data);
  }
  public function detail($id)
  {
    $data['title'] = 'Pengajuan Toko';
    $query = $this->db->query("SELECT tpt.*, tpt.id as id_pengajuan, tpt.status as status_p,tt.*,tc.*,tt.nama_pic as pic_toko, tt.telp as telp_toko,tu.nama_user as leader,ts.nama_user as spg,tp.nama_user as spv FROM tb_pengajuan_toko tpt
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
    $this->template->load('template/template', 'spv/toko/detail', $data);
  }
  public function detail_tutup($id)
  {
    $data['title'] = 'Pengajuan Toko';
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
    $this->template->load('template/template', 'spv/toko/toko_tutup_d', $data);
  }
  public function toko_tutup()
  {
    $role = $this->session->userdata('role');
    if ($role == 3) {
      $where = 'id_leader';
    } else {
      $where = 'id_spv';
    }
    $id = $this->session->userdata('id');
    $data['title'] = 'List Toko Tutup';
    $data['toko_tutup'] = $this->db->query("SELECT * from tb_toko
    where (status = 0 OR status = 6) AND $where = '$id' order by id desc")->result();
    $this->template->load('template/template', 'spv/toko/toko_tutup', $data);
  }
  public function getdataRetur()
  {
    // Mengambil parameter id_toko dari permintaan Ajax
    $id_retur = $this->input->get('id_retur');
    $artikel = $this->db->query("SELECT trd.qty,tp.kode, tp.nama_produk from tb_retur_detail trd
      join tb_produk tp on trd.id_produk = tp.id
      where trd.id_retur = ?  order by tp.nama_produk desc ", array($id_retur));
    $aset = $this->db->query("SELECT tra.*, ta.nama_aset from tb_retur_aset tra
      join tb_aset ta on tra.id_aset = ta.id
      where tra.id_retur = ?  order by ta.nama_aset desc ", array($id_retur));
    $retur = $this->db->query("SELECT * from tb_retur where id = ?", array($id_retur))->row();

    $result = array();

    if ($artikel->num_rows() > 0) {
      $result['artikel'] = $artikel->result_array();
    } else {
      $result['artikel'] = array();
    }

    if ($aset->num_rows() > 0) {
      $result['aset'] = $aset->result_array();
    } else {
      $result['aset'] = array();
    }
    // Menambahkan data nama toko ke dalam hasil
    $result['catatan'] = $retur->catatan;
    $result['tgl_tarik'] = $retur->tgl_jemput;

    header('Content-Type: application/json');
    echo json_encode($result);
    exit();
  }
  public function form_tutup()
  {
    $id = $this->session->userdata('id');
    $role = $this->session->userdata('role');
    if ($role == 3) {
      $where = 'id_leader';
    } else {
      $where = 'id_spv';
    }
    $cekTTD = $this->db->query("SELECT ttd from tb_user where id = ?", array($id))->row();
    if (empty($cekTTD->ttd)) {
      popup('Tanda Tangan Digital', 'Anda harus membuat TTD Digital terlebih dahulu untuk melanjutkan proses Pengajuan Toko', 'Profile');
      redirect('spv/Toko/pengajuanToko');
    }
    $data['title'] = 'Pengajuan Toko';
    $data['list_toko']  = $this->db->query("SELECT * from tb_toko where $where = '$id' AND status = 1")->result();
    $data['list_aset']  = $this->db->query("SELECT * from tb_aset where status = 1 order by nama_aset asc")->result();
    $this->template->load('template/template', 'spv/toko/form_tutup_toko', $data);
  }
  public function artikelToko()
  {
    $id_toko = $this->input->get('id_toko');

    $artikel = $this->db->query("SELECT ts.qty, ts.id_produk, tp.kode, tp.nama_produk FROM tb_stok ts
      JOIN tb_produk tp ON ts.id_produk = tp.id
      WHERE ts.id_toko = ?", array($id_toko))->result();

    $aset = $this->db->query("SELECT tat.*, tam.aset FROM tb_aset_toko tat
      JOIN tb_aset_master tam ON tat.id_aset = tam.id
      WHERE tat.id_toko = ?", array($id_toko))->result();

    $data = [
      'aset' => $aset,
      'artikel' => $artikel
    ];

    echo json_encode($data);
  }
  public function saveTutup()
  {
    $id_toko        = $this->input->post('id_toko');
    $tgl_tarik      = $this->input->post('tgl_tarik');
    $catatan        = $this->input->post('catatan');
    $id_spv         = $this->session->userdata('id');
    $nama           = $this->session->userdata('nama_user');
    $pt             = $this->session->userdata('pt');
    $no_retur       = $this->M_spg->kode_retur();
    $id_produk      = $this->input->post('id_produk');
    $qty_retur      = $this->input->post('qty_retur');
    $jml_produk     = count($id_produk);
    // ambil nama toko
    $get_toko = $this->db->query("SELECT nama_toko from tb_toko where id ='$id_toko'")->row()->nama_toko;
    $this->db->trans_start();
    // simpan ke tabel retur
    $dataRetur = array(
      'id'          => $no_retur,
      'id_toko'     => $id_toko,
      'id_user'     => $id_spv,
      'status'      => 10,
      'tgl_jemput'  => $tgl_tarik,
      'catatan'     => $catatan,
    );
    $this->db->insert('tb_retur', $dataRetur);
    //  cek jumlah id_produk
    $artikelData = [];
    for ($a = 0; $a < $jml_produk; $a++) {
      $artikelData[] = array(
        'id_produk'   => $id_produk[$a],
        'id_retur'    => $no_retur,
        'qty'         => $qty_retur[$a]
      );
    }
    if (!empty($artikelData)) {
      $this->db->insert_batch('tb_retur_detail', $artikelData);
    }

    // Insert history retur
    $histori = array(
      'id_retur' => $no_retur,
      'aksi' => 'Diajukan oleh : ',
      'pembuat' => $nama,
      'catatan_h' => $catatan
    );
    $this->db->insert('tb_retur_histori', $histori);
    $cek = $this->db->query("SELECT MAX(no_urut) as urut FROM tb_pengajuan_toko")->row();
    $urut = isset($cek->urut) ? $cek->urut + 1 : 1;
    $dataPengajuan = array(
      'id_toko' => $id_toko,
      'id_retur' => $no_retur,
      'kategori' => 3,
      'id_pembuat' => $id_spv,
      'no_urut' => $urut,
      'nomor' => 'T-' . date('Y') . '-' . date('n') . '-' . $urut
    );

    $this->db->insert('tb_pengajuan_toko', $dataPengajuan);

    $this->db->trans_complete();
    $hp = $this->db->select('no_telp')
      ->from('tb_user')
      ->where('role', 9)
      ->get()
      ->result();
    foreach ($hp as $h) {
      $phone = $h->no_telp;
      $message = "$nama Mengajukan Tutup Toko ($get_toko - $pt) yang perlu di cek, silahkan kunjungi s.id/absi-app";
      kirim_wa($phone, $message);
    }
    tampil_alert('success', 'Berhasil', 'Pengajuan Tutup Toko berhasil di ajukan.');
    redirect(base_url('spv/Toko/pengajuanToko'));
  }
  // ambil data ajax untuk wilayah
  function add_ajax_kab($id_prov)
  {
    $query = $this->db->get_where('wilayah_kabupaten', array('provinsi_id' => $id_prov));
    $data = "<option value=''>- Select Kabupaten -</option>";
    foreach ($query->result() as $value) {
      $data .= "<option value='" . $value->id . "'>" . $value->nama . "</option>";
    }
    echo $data;
  }

  function add_ajax_kec($id_kab)
  {
    $query = $this->db->get_where('wilayah_kecamatan', array('kabupaten_id' => $id_kab));
    $data = "<option value=''> - Pilih Kecamatan - </option>";
    foreach ($query->result() as $value) {
      $data .= "<option value='" . $value->id . "'>" . $value->nama . "</option>";
    }
    echo $data;
  }

  function add_ajax_des($id_kec)
  {
    $query = $this->db->get_where('wilayah_desa', array('kecamatan_id' => $id_kec));
    $data = "<option value=''> - Pilih Desa - </option>";
    foreach ($query->result() as $value) {
      $data .= "<option value='" . $value->id . "'>" . $value->nama . "</option>";
    }
    echo $data;
  }
  // Script profil toko
  public function profil($id_toko)
  {
    $cekspv = $this->db->query("SELECT id_spv from tb_toko where id = '$id_toko'")->row()->id_spv;
    $id_spv = $this->session->userdata('id');
    if ($cekspv != $id_spv) {
      tampil_alert('info', 'Information', 'Anda tidak punya akses di Toko ini!');
      redirect(base_url('spv/Customer'));
    }
    $data['last_update'] = $this->M_spv->last_update_stok($id_toko);
    $data['cek_status'] = $this->db->query("SELECT status from tb_toko where id = '$id_toko'")->row();
    $data['title']         = 'Kelola Toko';
    $data['toko']          = $this->db->query("SELECT tt.*, tp.nama as provinsi,tk.nama as kabupaten,tc.nama as kecamatan, tt.provinsi as id_provinsi from tb_toko tt
     join wilayah_provinsi tp on tt.provinsi = tp.id
     join wilayah_kabupaten tk on tt.kabupaten = tk.id
     join wilayah_kecamatan tc on tt.kecamatan = tc.id
     where tt.id = '$id_toko'")->row();
    //  list leader
    $data['list_leader']  = $this->db->query("SELECT * from tb_user where status = 1 and role = 3 ")->result();
    //  lihat leader toko
    $data['leader_toko']   = $this->db->query("SELECT tt.*, tb_user.nama_user
     from tb_toko tt
     join tb_user on tt.id_leader = tb_user.id
     where tt.id = '$id_toko' and tt.id_spv = '$id_spv' ")->row();
    //  lihat spg
    $data['spg']   = $this->db->query("SELECT tt.*,tb_user.nama_user 
     from tb_toko tt
     join tb_user on tt.id_spg = tb_user.id
     where tt.id = '$id_toko' ")->row();
    //  stok produk per toko
    $data['stok_produk'] = $this->db->query("
    SELECT tb_produk.nama_produk, tb_produk.satuan, tb_produk.kode, tb_stok.*, tb_produk.harga_jawa, tb_produk.harga_indobarat, tb_toko.diskon 
    FROM tb_stok
    JOIN tb_produk ON tb_stok.id_produk = tb_produk.id
    JOIN tb_toko ON tb_stok.id_toko = tb_toko.id
    WHERE tb_stok.id_toko = '$id_toko' 
    ORDER BY tb_stok.status != 1 DESC, tb_produk.kode ASC")->result();

    //  cek status di stok masing" toko
    $data['cek_status_stok']  = $this->db->query("SELECT status from tb_stok where id_toko = '$id_toko' and status = 2 ")->num_rows();
    //  list Produk
    $data['list_produk']  = $this->db->query("SELECT * from tb_produk where id not in (select id_produk from tb_stok where id_toko = '$id_toko') ")->result();

    $this->template->load('template/template', 'spv/toko/profil', $data);
  }

  // cek customer
  public function cek_cust()
  {
    $customer = $this->input->post('customer');
    $result = $this->db->get_where('tb_customer', array('nama_cust' => $customer))->result();
    if (count($result) > 0) {
      echo json_encode(TRUE);
      return;
    }
    echo json_encode(FALSE);
  }
  public function cek_toko()
  {
    $toko = $this->input->post('toko');
    $result = $this->db->get_where('tb_toko', array('nama_toko' => $toko, 'status' => 1))->result();
    if (count($result) > 0) {
      echo json_encode(TRUE);
      return;
    }
    echo json_encode(FALSE);
  }
  // proses tambah terbaru 2 foto
  public function add_customer()
  {
    $customer           = $this->input->post('customer');
    $pic_cust           = $this->input->post('pic_cust');
    $telp_cust          = $this->input->post('telp_cust');
    $top                = $this->input->post('top');
    $alamat_cust        = $this->input->post('alamat_cust');
    $catatan_spv        = $this->input->post('catatan_spv');

    $this->db->trans_start();
    $database = $this->db->database;
    $cek_cust = $this->db->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = 'tb_customer' ")->row();
    if ($cek_cust && isset($cek_cust->AUTO_INCREMENT)) {
      $id_auto_cust = $cek_cust->AUTO_INCREMENT;
    } else {
      $id_auto_cust = 1;
    }
    // Proses upload foto NPWP
    $config['upload_path'] = 'assets/img/customer/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['file_name'] = 'npwp_' . $id_auto_cust;
    $config['overwrite'] = TRUE;
    $config['remove_spaces'] = TRUE;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if ($this->upload->do_upload('foto_npwp')) {
      $foto_npwp = $this->upload->data('file_name');
    } else {
      $foto_npwp  = "";
    }

    // Proses upload foto ktp
    $config['upload_path'] = 'assets/img/customer/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['file_name'] = 'ktp_' . $id_auto_cust;
    $config['overwrite'] = TRUE;
    $config['remove_spaces'] = TRUE;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if ($this->upload->do_upload('foto_ktp')) {
      $foto_ktp = $this->upload->data('file_name');
    } else {
      $foto_ktp = "";
    }

    // Simpan data user ke dalam database
    $data_customer = array(
      'nama_cust'         => $customer,
      'nama_pic'          => $pic_cust,
      'telp'              => $telp_cust,
      'foto_npwp'         => $foto_npwp,
      'foto_ktp'          => $foto_ktp,
      'top'               => $top,
      'alamat_cust'       => $alamat_cust,
    );
    $this->db->insert('tb_customer', $data_customer);
    $id_customer  = $this->db->insert_id();
    $cek_toko = $this->db->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = 'tb_toko' ")->row();
    if ($cek_toko && isset($cek_toko->AUTO_INCREMENT)) {
      $id_auto_toko = $cek_toko->AUTO_INCREMENT;
    } else {
      $id_auto_toko = 1;
    }
    // Proses upload foto Toko
    $config['upload_path'] = 'assets/img/toko/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['file_name'] = 'toko_' . $id_auto_toko;
    $config['overwrite'] = TRUE;
    $config['remove_spaces'] = TRUE;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if ($this->upload->do_upload('foto_toko')) {
      $foto_toko = $this->upload->data('file_name');
    } else {
      $foto_toko  = "";
    }

    // Proses upload foto Kepala Toko
    $config['upload_path'] = 'assets/img/toko/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['file_name'] = 'kepala_toko_' . $id_auto_toko;
    $config['overwrite'] = TRUE;
    $config['remove_spaces'] = TRUE;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if ($this->upload->do_upload('foto_pic')) {
      $foto_pic = $this->upload->data('file_name');
    } else {
      $foto_pic = "";
    }
    $nama_toko          = $this->input->post('nama_toko');
    $s_rider            = $this->input->post('s_rider');
    $s_gtman            = $this->input->post('s_gtman');
    $s_crocodile        = $this->input->post('s_crocodile');
    $jenis_toko         = $this->input->post('jenis_toko');
    $target_toko        = $this->input->post('target');
    $limit_toko        = $this->input->post('limit');
    $listing            = $this->input->post('listing');
    $etc                = $this->input->post('etc');
    $sewa_rak           = $this->input->post('sewa_rak');
    $realisasi          = $this->input->post('realisasi');
    $provinsi           = $this->input->post('provinsi');
    $kabupaten          = $this->input->post('kabupaten');
    $kecamatan          = $this->input->post('kecamatan');
    $alamat             = $this->input->post('alamat_toko');
    $nama_pic           = $this->input->post('pic_toko');
    $nohp               = $this->input->post('telp_toko');
    $id_spv             = $this->session->userdata('id');
    $id_leader          = $this->input->post('id_leader');
    $id_spg             = $this->input->post('id_spg');
    $het                = $this->input->post('het');
    $diskon             = $this->input->post('diskon');
    $tgl_so             = $this->input->post('tgl_so');

    $data_toko = array(
      'id_customer'    => $id_customer,
      'id_spv'         => $id_spv,
      'id_leader'      => $id_leader,
      'id_spg'         => $id_spg,
      'nama_toko'      => $nama_toko,
      'jenis_toko'      => $jenis_toko,
      's_rider'        => str_replace(['Rp. ', '.'], '', $s_rider),
      's_gtman'        => str_replace(['Rp. ', '.'], '', $s_gtman),
      's_crocodile'    => str_replace(['Rp. ', '.'], '', $s_crocodile),
      'target'         => str_replace(['Rp. ', '.'], '', $target_toko),
      'limit_toko'     => str_replace(['Rp. ', '.'], '', $limit_toko),
      'listing'        => str_replace(['Rp. ', '.'], '', $listing),
      'etc'            => str_replace(['Rp. ', '.'], '', $etc),
      'sewa_rak'       => str_replace(['Rp. ', '.'], '', $sewa_rak),
      'realisasi'      => $realisasi,
      'provinsi'       => $provinsi,
      'kabupaten'      => $kabupaten,
      'kecamatan'      => $kecamatan,
      'alamat'         => $alamat,
      'nama_pic'       => $nama_pic,
      'telp'           => $nohp,
      'status'         => '2',
      'foto_toko'      => $foto_toko,
      'foto_pic'       => $foto_pic,
      'het'            => $het,
      'diskon'         => $diskon,
      'tgl_so'         => $tgl_so,
    );
    $this->db->insert('tb_toko', $data_toko);
    $id_toko  = $this->db->insert_id();
    $get_spv = $this->db->query("SELECT nama_user from tb_user where id ='$id_spv'")->row()->nama_user;
    $histori = array(
      'id_toko' => $id_toko,
      'aksi' => 'Dibuat oleh SPV: ',
      'pembuat' => $get_spv,
      'catatan' => $catatan_spv
    );
    $this->db->insert('tb_toko_histori', $histori);
    $cek = $this->db->query("SELECT MAX(no_urut) as urut FROM tb_pengajuan_toko")->row();
    $urut = isset($cek->urut) ? $cek->urut + 1 : 1;
    $dataPengajuan = array(
      'id_toko' => $id_toko,
      'kategori' => 1,
      'id_pembuat'  => $id_spv,
      'no_urut' => $urut,
      'nomor' => 'T-' . date('Y') . '-' . date('n') . '-' . $urut
    );
    $this->db->insert('tb_pengajuan_toko', $dataPengajuan);
    $this->db->trans_complete();
    $pt = $this->session->userdata('pt');
    $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE role = 9 and status = 1")->result_array();
    $message = $get_spv . " Mengajukan Customer & toko baru ( " . $nama_toko . " - " . $pt . " ) yang perlu di approve, silahkan kunjungi s.id/absi-app";
    foreach ($phones as $phone) {
      $number = $phone['no_telp'];
      $hp = substr($number, 0, 1);
      if ($hp == '0') {
        $number = '62' . substr($number, 1);
      }
      kirim_wa($number, $message);
    }
    tampil_alert('success', 'Berhasil', 'Data Customer & Toko Berhasil di buat');
    redirect(base_url('spv/Toko/pengajuanToko'));
  }
  // proses tambah terbaru 2 foto
  public function add_toko()
  {

    $id_customer        = $this->input->post('id_customer');
    $nama_toko          = $this->input->post('nama_toko');
    $s_rider            = $this->input->post('s_rider');
    $s_gtman            = $this->input->post('s_gtman');
    $s_crocodile        = $this->input->post('s_crocodile');
    $jenis_toko         = $this->input->post('jenis_toko');
    $target_toko        = $this->input->post('target');
    $limit_toko         = $this->input->post('limit');
    $listing            = $this->input->post('listing');
    $etc                = $this->input->post('etc');
    $sewa_rak           = $this->input->post('sewa_rak');
    $realisasi          = $this->input->post('realisasi');
    $provinsi           = $this->input->post('provinsi');
    $kabupaten          = $this->input->post('kabupaten');
    $kecamatan          = $this->input->post('kecamatan');
    $alamat             = $this->input->post('alamat_toko');
    $nama_pic           = $this->input->post('pic_toko');
    $nohp               = $this->input->post('telp_toko');
    $id_spv             = $this->session->userdata('id');
    $id_leader          = $this->input->post('id_leader');
    $id_spg             = $this->input->post('id_spg');
    $het                = $this->input->post('het');
    $diskon             = $this->input->post('diskon');
    $tgl_so             = $this->input->post('tgl_so');
    $catatan_spv        = $this->input->post('catatan_spv');

    $database = $this->db->database;
    $cek_toko = $this->db->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = 'tb_toko' ")->row();
    if ($cek_toko && isset($cek_toko->AUTO_INCREMENT)) {
      $id_auto_toko = $cek_toko->AUTO_INCREMENT;
    } else {
      $id_auto_toko = 1;
    }
    // Proses upload foto Toko
    $config['upload_path'] = 'assets/img/toko/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['file_name'] = 'toko_' . $id_auto_toko;
    $config['overwrite'] = TRUE;
    $config['remove_spaces'] = TRUE;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if ($this->upload->do_upload('foto_toko')) {
      $foto_toko = $this->upload->data('file_name');
    } else {
      $foto_toko  = "";
      // Tampilkan error jika upload foto KTP gagal
    }

    // Proses upload foto Kepala Toko
    $config['upload_path'] = 'assets/img/toko/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['file_name'] = 'kepala_toko_' . $id_auto_toko;
    $config['overwrite'] = TRUE;
    $config['remove_spaces'] = TRUE;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if ($this->upload->do_upload('foto_pic')) {
      $foto_pic = $this->upload->data('file_name');
    } else {
      $foto_pic = "";
    }
    $data_toko = array(
      'id_customer'    => $id_customer,
      'id_spv'         => $id_spv,
      'id_leader'      => $id_leader,
      'id_spg'         => $id_spg,
      'nama_toko'      => $nama_toko,
      'jenis_toko'      => $jenis_toko,
      's_rider'        => str_replace(['Rp. ', '.'], '', $s_rider),
      's_gtman'        => str_replace(['Rp. ', '.'], '', $s_gtman),
      's_crocodile'    => str_replace(['Rp. ', '.'], '', $s_crocodile),
      'target'         => str_replace(['Rp. ', '.'], '', $target_toko),
      'limit_toko'     => str_replace(['Rp. ', '.'], '', $limit_toko),
      'listing'        => str_replace(['Rp. ', '.'], '', $listing),
      'etc'            => str_replace(['Rp. ', '.'], '', $etc),
      'sewa_rak'       => str_replace(['Rp. ', '.'], '', $sewa_rak),
      'realisasi'      => $realisasi,
      'provinsi'       => $provinsi,
      'kabupaten'      => $kabupaten,
      'kecamatan'      => $kecamatan,
      'alamat'         => $alamat,
      'nama_pic'       => $nama_pic,
      'telp'           => $nohp,
      'status'         => '2',
      'foto_toko'      => $foto_toko,
      'foto_pic'       => $foto_pic,
      'het'            => $het,
      'diskon'         => $diskon,
      'tgl_so'         => $tgl_so,
    );
    $this->db->trans_start();
    $this->db->insert('tb_toko', $data_toko);
    $id_toko  = $this->db->insert_id();
    $get_spv             = $this->session->userdata('nama_user');
    $histori = array(
      'id_toko' => $id_toko,
      'aksi' => 'Dibuat oleh SPV: ',
      'pembuat' => $get_spv,
      'catatan' => $catatan_spv
    );
    $this->db->insert('tb_toko_histori', $histori);
    $cek = $this->db->query("SELECT MAX(no_urut) as urut FROM tb_pengajuan_toko")->row();
    $urut = isset($cek->urut) ? $cek->urut + 1 : 1;
    $dataPengajuan = array(
      'id_toko' => $id_toko,
      'kategori' => 2,
      'id_pembuat'  => $id_spv,
      'no_urut' => $urut,
      'nomor' => 'T-' . date('Y') . '-' . date('n') . '-' . $urut
    );
    $this->db->insert('tb_pengajuan_toko', $dataPengajuan);
    $this->db->trans_complete();
    $pt = $this->session->userdata('pt');

    $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE role = 9 and status = 1")->result_array();
    $message = $get_spv . " Mengajukan Toko baru ( " . $nama_toko . " - " . $pt . " ) yang perlu di approve, silahkan kunjungi s.id/absi-app";
    foreach ($phones as $phone) {
      $number = $phone['no_telp'];
      $hp = substr($number, 0, 1);
      if ($hp == '0') {
        $number = '62' . substr($number, 1);
      }
      kirim_wa($number, $message);
    }
    tampil_alert('success', 'Berhasil', 'Pengajuan Toko berhasil di kirim.');
    redirect(base_url('spv/Toko/pengajuanToko'));
  }
  // add leader
  public function add_leader()
  {
    $leader     = $this->input->post('leader');
    $id_toko     = $this->input->post('id_toko');
    $this->db->query("UPDATE tb_toko set id_leader = '$leader' where id ='$id_toko'");
    tampil_alert('success', 'Berhasil', 'Data team leader Berhasil di Kaitkan');
    redirect(base_url('spv/toko/profil/' . $id_toko));
  }
  // tambah artikel
  public function tambah_artikel()
  {
    $id_spv  = $this->session->userdata('id');
    $id_toko = $this->input->post('id_toko');
    $id_produk = $this->input->post('id_produk');
    $jml = count($id_produk);
    $counter_artikel = 0; // Tambahkan variabel counter artikel

    if ($jml <= 0) {
      tampil_alert('error', 'KOSONG', 'Tidak ada artikel terpilih.');
      redirect(base_url('spv/toko/profil/' . $id_toko));
      exit;
    }

    $get_toko = $this->db->query("SELECT nama_toko from tb_toko where id ='$id_toko'")->row()->nama_toko;
    $get_spv = $this->db->query("SELECT nama_user from tb_user where id ='$id_spv'")->row()->nama_user;

    $this->db->trans_start();
    for ($x = 0; $x < $jml; $x++) {
      // Cek apakah produk sudah terdaftar di toko ini
      $cek = $this->db->query("SELECT * FROM tb_stok WHERE id_produk = '$id_produk[$x]' AND id_toko = '$id_toko'")->num_rows();
      if ($cek == 0) {
        // Jika produk belum terdaftar, simpan ke tabel tb_stok
        $data = array(
          'id_produk' => $id_produk[$x],
          'id_toko' => $id_toko,
          'status' => '2',
        );
        $this->db->insert('tb_stok', $data);
        $counter_artikel++; // Tambahkan 1 ke counter artikel
      }
    }
    $this->db->trans_complete();

    // Jika transaksi sudah selesai
    if ($this->db->trans_status() === FALSE) {
      tampil_alert('error', 'Gagal', 'Gagal menambahkan artikel.');
    } else {
      // Jika transaksi berhasil
      $pt = $this->session->userdata('pt');
      $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE role = 9 and status = 1")->result_array();
      $message = $get_spv . " : Mengajukan " . $counter_artikel . " Artikel untuk toko ( " . $get_toko . " - " . $pt . " ) yang perlu di approve, silahkan kunjungi s.id/absi-app";
      foreach ($phones as $phone) {
        $number = $phone['no_telp'];
        $hp = substr($number, 0, 1);
        if ($hp == '0') {
          $number = '62' . substr($number, 1);
        }
        kirim_wa($number, $message);
      }
      tampil_alert('success', 'Berhasil', 'Artikel Berhasil didaftarkan, menunggu approve Manager! Jumlah Artikel: ' . $counter_artikel); // Tampilkan jumlah artikel
    }
    redirect(base_url('spv/toko/profil/' . $id_toko));
  }

  public function hapus_item($id)
  {
    $this->db->delete("tb_stok", array("id" => $id));
    tampil_alert('success', 'DIHAPUS', 'Artikel berhasil dihapus.');
    redirect($_SERVER['HTTP_REFERER']);
  }
}
