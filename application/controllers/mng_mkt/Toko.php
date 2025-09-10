<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "9" && $role != "1") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_spv');
  }

  // tampil data Aset
  public function index()
  {
    $data['title'] = 'Kelola Toko';
    $data['toko'] = $this->db->query("SELECT tt.*, tu.nama_user
    from tb_toko tt
    left join tb_user tu on tt.id_spg = tu.id
    where tt.status IN (1,7)
    ORDER BY tt.id desc")->result();
    $this->template->load('template/template', 'manager_mkt/toko/lihat_data', $data);
  }
  public function pengajuanToko()
  {
    $data['title'] = 'Pengajuan Toko';
    $data['pengajuan'] = $this->db->query("SELECT tpt.*, tt.nama_toko, tt.alamat, tc.nama_cust from tb_pengajuan_toko tpt
    JOIN tb_toko tt on tpt.id_toko = tt.id
    JOIN tb_customer tc on tt.id_customer = tc.id
    order by tpt.id desc")->result();
    $this->template->load('template/template', 'manager_mkt/toko/pengajuanToko', $data);
  }
  // fitur proses pengajuan toko
  public function detail($id)
  {
    $data['title'] = 'Pengajuan Toko';
    $id_user = $this->session->userdata('id');
    $cekTTD = $this->db->query("SELECT ttd from tb_user where id = ?", array($id_user))->row();
    if (empty($cekTTD->ttd)) {
      popup('Tanda Tangan Digital', 'Anda harus membuat TTD Digital terlebih dahulu untuk melanjutkan proses Pengajuan Toko', 'Profile');
      redirect('mng_mkt/Toko/pengajuanToko');
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
    $this->template->load('template/template', 'manager_mkt/toko/detail', $data);
  }
  // list toko tutup
  public function toko_tutup()
  {
    $data['title'] = 'List Toko Tutup';
    $data['toko_tutup'] = $this->db->query("SELECT * from tb_toko
    where status = 0 OR status = 6 order by id desc")->result();
    $this->template->load('template/template', 'manager_mkt/toko/toko_tutup', $data);
  }

  public function toko_tutup_d($id)
  {
    $data['title'] = 'Pengajuan Toko';
    $id_user = $this->session->userdata('id');
    $cekTTD = $this->db->query("SELECT ttd from tb_user where id = ?", array($id_user))->row();
    if (empty($cekTTD->ttd)) {
      popup('Tanda Tangan Digital', 'Anda harus membuat TTD Digital terlebih dahulu untuk melanjutkan proses Pengajuan Toko', 'Profile');
      redirect('mng_mkt/Toko/pengajuanToko');
    }
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
    $this->template->load('template/template', 'manager_mkt/toko/toko_tutup_d', $data);
  }
  public function tindakan()
  {
    $catatan       = $this->input->post('catatan_mm');
    $action        = $this->input->post('tindakan');
    $id_retur      = $this->input->post('id_retur');
    $id_pengajuan  = $this->input->post('id_pengajuan');
    $id_toko       = $this->input->post('id_toko');
    $pembuat       = $this->input->post('pembuat');
    $mm            = $this->session->userdata('nama_user');
    $pt            = $this->session->userdata('pt');
    $id_mm         = $this->session->userdata('id');

    $status = $action == "1" ? "1" : "5";
    $aksi   = $action == "1" ? 'Disetujui' : 'Ditolak';

    // Mulai transaksi biar aman
    $this->db->trans_start();

    // Update status pengajuan
    $this->db->update('tb_pengajuan_toko', [
      'status' => $status,
      'id_mm'  => $id_mm
    ], ['id' => $id_pengajuan]);

    // Insert histori retur
    $this->db->insert('tb_retur_histori', [
      'id_retur'  => $id_retur,
      'aksi'      => $aksi . ' oleh : ',
      'pembuat'   => $mm,
      'catatan_h' => $catatan
    ]);

    // Ambil nama toko
    $get_toko = $this->db->select('nama_toko')
      ->where('id', $id_toko)
      ->get('tb_toko')
      ->row()->nama_toko;

    $this->db->trans_complete();
    tampil_alert('success', 'BERHASIL', "Pengajuan Tutup Toko berhasil di $aksi");
    redirect(base_url('mng_mkt/Toko/toko_tutup_d/' . $id_pengajuan));
    // Kirim WA di background (setelah respon terkirim)
    if (function_exists('fastcgi_finish_request')) {
      fastcgi_finish_request();
    }
    // Kirim WA di luar transaksi supaya DB commit dulu
    if ($action == "1") {
      // Kirim ke semua user role 6 & 8
      $hp_list = $this->db->select('no_telp')
        ->from('tb_user')
        ->where_in('role', [6, 8])
        ->where('status', '1')
        ->get()
        ->result();

      $message = "Anda memiliki 1 Pengajuan Tutup Toko ($get_toko - $pt) yang perlu dicek, silahkan kunjungi s.id/absi-app";

      foreach ($hp_list as $h) {
        $phone = $this->formatPhone($h->no_telp);
        kirim_wa($phone, $message);
      }
    } else {
      // Kirim ke pembuat
      $phone_pembuat = $this->db->select('no_telp')
        ->where('id', $pembuat)
        ->get('tb_user')
        ->row()->no_telp;

      $message = "Pengajuan Tutup Toko ( $get_toko - $pt ) anda Ditolak, silahkan kunjungi s.id/absi-app";
      kirim_wa($this->formatPhone($phone_pembuat), $message);
    }
  }

  private function formatPhone($number)
  {
    $number = preg_replace('/[^0-9]/', '', $number); // hanya angka
    if (substr($number, 0, 1) === '0') {
      return '62' . substr($number, 1);
    }
    return $number;
  }

  // halaman update toko
  public function update($id)
  {
    $data['title'] = 'Kelola Toko';
    $data['detail'] = $this->db->query("SELECT tb_toko.*, tb_user.nama_user as spg from tb_toko
    left join tb_user on tb_toko.id_spg = tb_user.id 
    where tb_toko.id = '$id'")->row();
    $data['provinsi'] = $this->db->query("SELECT * from wilayah_provinsi")->result();
    $data['kabupaten'] = $this->db->query("SELECT * from wilayah_kabupaten")->result();
    $data['kecamatan'] = $this->db->query("SELECT * from wilayah_kecamatan")->result();

    $data['supervisor'] = $this->db->query("SELECT * from tb_user where role ='2' and status ='1'")->result();
    $data['leader'] = $this->db->query("SELECT * from tb_user where role ='3' and status ='1'")->result();
    $data['spg'] = $this->db->query("SELECT * from tb_user where role ='4' and status ='1'")->result();
    $this->template->load('template/template', 'manager_mkt/toko/update', $data);
  }
  // ambil data kab
  function add_ajax_kab($id_prov)
  {
    $query = $this->db->get_where('wilayah_kabupaten', array('provinsi_id' => $id_prov));
    $data = "<option value=''>- Select Kabupaten -</option>";
    foreach ($query->result() as $value) {
      $data .= "<option value='" . $value->id . "'>" . $value->nama . "</option>";
    }
    echo $data;
  }
  //  ambil data kec
  function add_ajax_kec($id_kab)
  {
    $query = $this->db->get_where('wilayah_kecamatan', array('kabupaten_id' => $id_kab));
    $data = "<option value=''>- Select Kecamatan -</option>";
    foreach ($query->result() as $value) {
      $data .= "<option value='" . $value->id . "'>" . $value->nama . "</option>";
    }
    echo $data;
  }

  //  Update detail toko
  public function proses_update()
  {
    $id_toko = $this->input->post('id_toko');
    $jenis_toko = $this->input->post('jenis_toko');
    $pic = $this->input->post('pic');
    $no_telp = $this->input->post('no_telp');
    $tgl_so = $this->input->post('tgl_so');
    $het = $this->input->post('het');
    $diskon = $this->input->post('diskon');
    $limit = $this->input->post('limit');
    $provinsi = $this->input->post('provinsi');
    $kabupaten = $this->input->post('kabupaten');
    $kecamatan = $this->input->post('kecamatan');
    $alamat = $this->input->post('alamat');

    $target = $this->input->post('target');
    $updated = date('Y-m-d H:i:s');

    $data = array(
      'jenis_toko' => $jenis_toko,
      'nama_pic' => $pic,
      'telp' => $no_telp,
      'tgl_so' => $tgl_so,
      'het' => $het,
      'diskon' => $diskon,
      'limit_toko' => $limit,
      'provinsi' => $provinsi,
      'kabupaten' => $kabupaten,
      'kecamatan' => $kecamatan,
      'alamat' => $alamat,

      'target' => $target,
      'updated_at' => $updated
    );
    $where = array(
      'id' => $id_toko
    );
    $this->db->update('tb_toko', $data, $where);
    tampil_alert('success', 'Berhasil', 'Data Toko berhasil di Perbaharui!');
    redirect(base_url('mng_mkt/Toko/update/' . $id_toko));
  }
  // update foto toko
  public function update_foto()
  {
    $id_toko = $this->input->post('id_toko_foto');
    $config['upload_path'] = 'assets/img/toko/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = '2048';
    $config['file_name'] = $id_toko;
    $config['overwrite'] = TRUE;
    $config['remove_spaces'] = TRUE;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    if (!$this->upload->do_upload('foto')) {
    } else {
      // Jika upload berhasil, simpan data foto ke database
      $foto = $this->upload->data('file_name');
      $id_toko = $this->input->post('id_toko_foto');
      // simpan data foto ke database sesuai dengan id data yang ingin diupdate
      $this->db->query("UPDATE tb_toko set foto_toko ='$foto' where id='$id_toko'");
      $data['toko'] = $this->db->query("SELECT * from tb_toko where id = '$id_toko'")->row();
      $data['pesan'] = "berhasil di update";
      echo json_encode($data);
    }
  }
  // Script profil toko
  public function profil($id_toko)
  {
    $id_spv = $this->session->userdata('id');
    $data['last_update'] = $this->M_spv->last_update_stok($id_toko);
    $data['cek_status'] = $this->db->query("SELECT status from tb_toko where id = '$id_toko'")->row();
    $data['title'] = 'Kelola Toko';
    $data['toko'] = $this->db->query("SELECT tt.*, tp.nama as provinsi,tk.nama as kabupaten,tc.nama as kecamatan, tt.provinsi as id_provinsi from tb_toko tt
     join wilayah_provinsi tp on tt.provinsi = tp.id
     join wilayah_kabupaten tk on tt.kabupaten = tk.id
     join wilayah_kecamatan tc on tt.kecamatan = tc.id
     where tt.id = '$id_toko'")->row();
    //  lihat SPV toko
    $data['spv'] = $this->db->query("SELECT tt.*, tb_user.nama_user
    from tb_toko tt
    left join tb_user on tt.id_spv = tb_user.id
    where tt.id = '$id_toko'
    ")->row();
    //  lihat leader toko
    $data['leader_toko'] = $this->db->query("SELECT tt.*, tb_user.nama_user
    from tb_toko tt
    left join tb_user on tt.id_leader = tb_user.id
    where tt.id = '$id_toko'
    ")->row();
    //  lihat spg
    $data['spg'] = $this->db->query("SELECT tt.*,tb_user.nama_user 
    from tb_toko tt
    left join tb_user on tt.id_spg = tb_user.id
    where tt.id = '$id_toko'
    ")->row();
    //  cek status di stok masing" toko
    $data['cek_status_stok'] = $this->db->query("SELECT status from tb_stok where id_toko = '$id_toko' and status = 2 ")->num_rows();
    //  stok produk per toko
    $ssr = $this->db->query("SELECT ssr from tb_toko where id = '$id_toko'")->row()->ssr;
    $data['stok_produk'] = $this->db->query("
        SELECT tb_produk.*, tb_stok.qty, COALESCE(ROUND(AVG(penjualan_3_bulan.qty), 0), 0) * '$ssr' as ssr
        FROM tb_produk
        LEFT JOIN tb_stok ON tb_produk.id = tb_stok.id_produk AND tb_stok.id_toko = '$id_toko'
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
    //  list Produk
    $data['list_produk'] = $this->db->query("SELECT * from tb_produk where id not in (select id_produk from tb_stok where id_toko = '$id_toko') ")->result();

    $this->template->load('template/template', 'manager_mkt/toko/profil', $data);
  }
  //  approve toko
  public function approve()
  {
    $pt = $this->session->userdata('pt');
    $id = $this->session->userdata('id');
    $mm = $this->session->userdata('nama_user');
    $id_pengajuan = $this->input->post('id_pengajuan');
    $id_toko = $this->input->post('id_toko');
    $id_pembuat = $this->input->post('id_pembuat');
    $toko = $this->input->post('toko');
    $catatan = $this->input->post('catatan');
    $keputusan = $this->input->post('keputusan');
    $this->db->trans_start();
    $this->db->query("UPDATE tb_pengajuan_toko set status = $keputusan, id_mm = '$id' where id = '$id_pengajuan'");
    if ($keputusan == 2) {
      $pesan = "Data Toko di teruskan ke pihak Accounting!";
      $aksi = "Di Setujui Oleh MM : ";
      $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE role = 15 and status = 1")->result_array();
      $message = "Anda memiliki 1 Pengajuan Toko Baru ( " . $toko . " - " . $pt . " ) yang perlu approve silahkan kunjungi s.id/absi-app";
    } else {
      $pesan = "Data Toko DI Tolak";
      $aksi = "Di Tolak Oleh MM : ";
      $phones = $this->db->query("SELECT no_telp FROM tb_user where id = '$id_pembuat'")->result_array();
      $message = "Pengajuan Toko ( " . $toko . " - " . $pt . " ) anda DI TOLAK, Silahkan ajukan kembali dengan data yang benar,  s.id/absi-app";
    }
    $histori = array(
      'id_toko' => $id_toko,
      'aksi' => $aksi,
      'pembuat' => $mm,
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
    redirect(base_url('mng_mkt/Toko/detail/' . $id_pengajuan));
  }

  // tambah artikel
  public function tambah_artikel()
  {
    $this->form_validation->set_rules('id_toko', 'ID Toko', 'required');
    $this->form_validation->set_rules('id_produk', 'Id Produk', 'required');
    if ($this->form_validation->run() == TRUE) {
      $id_toko = $this->input->post('id_toko');
      $id_produk = $this->input->post('id_produk');
      $data = array(
        'id_produk' => $id_produk,
        'id_toko' => $id_toko,
        'status' => '1',
      );
      $cek = $this->db->query("SELECT * FROM tb_stok WHERE id_produk = '$id_produk' AND id_toko = '$id_toko'")->num_rows();
      if ($cek > 0) {
        tampil_alert('info', 'Information', 'Artikel sudah terdaftar di Toko ini!');
        redirect(base_url('mng_mkt/toko/profil/' . $id_toko));
      } else {
        $this->db->trans_start();
        $this->M_spv->insert('tb_stok', $data);
        $this->db->trans_complete();
        tampil_alert('success', 'Berhasil', 'Artikel Berhasil didaftarkan!');
        redirect(base_url('mng_mkt/toko/profil/' . $id_toko));
      }
    } else {
      tampil_alert('error', 'Gagal', 'Artikel Gagal didaftarkan!');
      redirect(base_url('mng_mkt/toko/profil/' . $id_toko));
    }
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
    $data['customer'] = $this->db->query("SELECT tc.* from tb_customer tc
       join tb_toko on tc.id = tb_toko.id_customer
       where tb_toko.id = '$id_toko'")->row();
    // nama spv
    $data['spv'] = $this->db->query("SELECT tt.*, tb_user.nama_user
         from tb_toko tt
         left join tb_user on tt.id_spv = tb_user.id
         where tt.id = '$id_toko'
         ")->row();
    //  lihat leader toko
    $data['leader_toko'] = $this->db->query("SELECT tt.*, tb_user.nama_user
       from tb_toko tt
       left join tb_user on tt.id_leader = tb_user.id
       where tt.id = '$id_toko'
       ")->row();
    //  lihat spg
    $data['spg'] = $this->db->query("SELECT tt.*,tb_user.nama_user 
       from tb_toko tt
       left join tb_user on tt.id_spg = tb_user.id
       where tt.id = '$id_toko'
       ")->row();
    $html = $this->load->view('manager_mkt/toko/unduh', $data, true);
    // run dompdf
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
}
