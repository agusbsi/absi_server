<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Retur extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $role = $this->session->userdata('role');
    if ($role != "4") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }

    $this->load->model('M_spg');
    $this->load->model('M_produk');
    $this->load->model('M_admin');
  }

  // tampil data retur
  public function index()
  {
    $id_toko = $this->session->userdata('id_toko');
    $data['title'] = 'Retur Barang';
    $data['list_retur'] = $this->db->query("SELECT * from tb_retur where id_toko ='$id_toko' and status < 10 Order By id desc ")->result();
    $this->template->load('template/template', 'spg/retur/index', $data);
  }
  // detail retur
  public function detail($id)
  {

    $data['title'] = 'Retur Barang';
    $data['retur'] = $this->db->query("SELECT tp.*, tt.nama_toko, tu.nama_user  from tb_retur tp 
    join tb_toko tt on tt.id = tp.id_toko 
    join tb_user tu on tu.id = tp.id_user 
    where  tp.id = '$id'")->row();
    $data['detail_retur'] = $this->db->query("SELECT td.*, tp.nama_produk as artikel, tp.kode FROM tb_retur_detail td
    join tb_produk tp on td.id_produk = tp.id
    WHERE id_retur = '$id'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_retur_histori tro
    join tb_retur tr on tro.id_retur = tr.id where tro.id_retur = '$id'")->result();
    $this->template->load('template/template', 'spg/retur/detail', $data);
  }
  // tambah retur
  public function tambah_retur()
  {
    if ($this->session->userdata('cart') != "Retur") {
      $this->cart->destroy();
    }
    $id_toko = $this->session->userdata('id_toko');
    $data['title'] = 'Retur Barang';
    $data['nama'] = $this->session->userdata('nama_user'); // generate no permintaan
    $user_id = $this->session->userdata('id');
    $data_toko = $this->M_spg->user_toko($user_id)->row(); // generate no permintaan
    $id_toko = $this->session->userdata('id_toko');
    $data['toko_new'] = $this->db->query("SELECT * from tb_toko where id = '$id_toko'")->row();
    $data['kode_retur'] = $this->M_spg->kode_retur(); // generate no permintaan
    // Ambil ID produk dari cart
    $produk_di_cart = array();
    foreach ($this->cart->contents() as $item) {
      $produk_di_cart[] = $item['name'];
    }
    $produk_di_cart_str = implode(',', array_map('intval', $produk_di_cart));
    $sql = "SELECT tp.kode, ts.id_produk 
             FROM tb_stok ts
             JOIN tb_produk tp ON ts.id_produk = tp.id
             WHERE id_toko = ?";
    if (!empty($produk_di_cart)) {
      $sql .= " AND tp.id NOT IN ($produk_di_cart_str)";
    }
    $data['list_produk'] = $this->db->query($sql, array($id_toko))->result();
    $data['data_cart'] = $this->cart->contents(); // menampilkan data cart

    $this->template->load('template/template', 'spg/retur/tambah_retur', $data);
  }
  public function tambah_cart()
  {
    $id = $this->input->post('id_produk');
    $kirim = $this->input->post('no_kirim');
    $qty = $this->input->post('qty');
    $keterangan = $this->input->post('keterangan');
    $catatan = $this->input->post('catatan');
    $no_retur = $this->M_spg->kode_retur();
    $produk = $this->M_produk->get_by_id($id);

    // Upload foto
    $file_name = str_replace('-', '', $produk->id . $no_retur);
    $config['upload_path'] = 'assets/img/retur/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['file_name'] = $file_name;
    $config['overwrite'] = true;

    $this->load->library('upload');
    $this->upload->initialize($config); // Inisialisasi ulang sebelum upload

    // Cek apakah ada unggahan foto
    if (isset($_FILES['foto_retur']) && $_FILES['foto_retur']['error'] != UPLOAD_ERR_NO_FILE) {
      if ($this->upload->do_upload('foto_retur')) {
        // Ambil data file yang diunggah
        $gbr = $this->upload->data();
        $foto_retur = $gbr['file_name'];

        // Kompres gambar
        $config_resize['image_library'] = 'gd2';
        $config_resize['source_image'] = 'assets/img/retur/' . $foto_retur;
        $config_resize['create_thumb'] = false;
        $config_resize['maintain_ratio'] = true;
        $config_resize['width'] = 800; // Lebar maksimum
        $config_resize['height'] = 800; // Tinggi maksimum
        $config_resize['quality'] = '80%'; // Kualitas kompresi

        $this->load->library('image_lib');
        $this->image_lib->initialize($config_resize); // Inisialisasi ulang konfigurasi resize
        if (!$this->image_lib->resize()) {
          echo 'Resize Error: ' . $this->image_lib->display_errors();
        }
        $this->image_lib->clear();
      } else {
        // Jika upload gagal
        echo 'Upload Error: ' . $this->upload->display_errors();
        $foto_retur = '';
      }
    } else {
      $foto_retur = '';
    }

    // Masukkan ke keranjang
    $data = array(
      'id' => $id,
      'qty' => $qty,
      'price' => "",
      'name' => $produk->id,
      'options' => $produk->kode,
      'sj' => $kirim,
      'keterangan' => array(
        'status' => $keterangan,
        'catatan' => $catatan,
        'artikel' => $produk->nama_produk
      ),
      'foto_retur' => $foto_retur,
    );

    $this->cart->insert($data);
    $this->session->set_userdata('cart', 'Retur');
    redirect(base_url('spg/retur/tambah_retur'));
  }



  public function hapus_cart($id)
  {
    $item = null;
    foreach ($this->cart->contents() as $cart_item) {
      if ($cart_item['rowid'] === $id) {
        $item = $cart_item;
        break;
      }
    }

    if ($item) {
      $foto_retur = $item['foto_retur'];
      $foto_path = FCPATH . 'assets/img/retur/' . $foto_retur;
      if (file_exists($foto_path)) {
        unlink($foto_path);
      }
    }

    $this->cart->remove($id);
    redirect(base_url('spg/retur/tambah_retur'));
  }

  public function reset_cart()
  {
    $this->cart->destroy();

    redirect(base_url('spg/tambah_retur'));
  }
  // menampilkan list detail json
  function list_detail()
  {
    $id = $_POST['no_kirim'];
    $id_toko = $this->session->userdata('id_toko');
    $data = $this->M_spg->barang_list($id, $id_toko);
    echo json_encode($data);
  }
  public function tampilkan_detail_produk($id)
  {
    $id_toko = $this->session->userdata('id_toko');
    $data_produk = $this->db->query("SELECT qty from tb_stok 
        where id_produk = '$id' and id_toko = '$id_toko' ")->row();
    if ($data_produk) {
      $hasil = array(
        'stok' => $data_produk->qty,
      );
    } else {
      $hasil = array(
        'stok' => "0"
      );
    }
    echo json_encode($hasil);
  }
  // proses simpan
  public function kirim_retur()
  {
    $id_toko = $this->session->userdata('id_toko');
    $id_user = $this->session->userdata('id');
    $no_retur = $this->M_spg->kode_retur();

    $config['upload_path'] = 'assets/img/retur/lampiran/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = 10048; // Maksimal ukuran file
    $config['overwrite'] = true;

    $this->load->library('upload', $config);
    $this->load->library('image_lib');

    $upload_data_lampiran = null;
    $upload_data_foto_packing = null;
    $lampiran = "";
    $packing = "";

    // Upload dan kompres 'lampiran'
    $config['file_name'] = "lampiran_" . $no_retur;
    $this->upload->initialize($config);
    if ($this->upload->do_upload('lampiran')) {
      $upload_data_lampiran = $this->upload->data();
      $lampiran = $upload_data_lampiran['file_name'];

      // Kompres gambar lampiran
      $config_resize['image_library'] = 'gd2';
      $config_resize['source_image'] = 'assets/img/retur/lampiran/' . $lampiran;
      $config_resize['maintain_ratio'] = true;
      $config_resize['width'] = 800;
      $config_resize['height'] = 800;
      $config_resize['quality'] = '80%';

      $this->image_lib->initialize($config_resize);
      if (!$this->image_lib->resize()) {
        echo 'Resize Error (Lampiran): ' . $this->image_lib->display_errors();
      }
      $this->image_lib->clear();
    } else {
      $error = $this->upload->display_errors();
    }

    // Upload dan kompres 'foto_packing'
    $config['file_name'] = "packing_" . $no_retur;
    $this->upload->initialize($config);
    if ($this->upload->do_upload('foto_packing')) {
      $upload_data_foto_packing = $this->upload->data();
      $packing = $upload_data_foto_packing['file_name'];

      // Kompres gambar foto_packing
      $config_resize['source_image'] = 'assets/img/retur/lampiran/' . $packing;
      $this->image_lib->initialize($config_resize);
      if (!$this->image_lib->resize()) {
        echo 'Resize Error (Foto Packing): ' . $this->image_lib->display_errors();
      }
      $this->image_lib->clear();
    } else {
      $error = $this->upload->display_errors();
    }

    // Data retur
    $tgl_jemput = $this->input->post('tgl_jemput');
    $data_retur = array(
      'id' => $no_retur,
      'id_toko' => $id_toko,
      'id_user' => $id_user,
      'lampiran' => $lampiran,
      'foto_packing' => $packing,
      'tgl_jemput' => $tgl_jemput
    );

    // Simpan data ke database
    $this->db->trans_start();
    $this->db->insert('tb_retur', $data_retur);
    $data_cart = $this->cart->contents();
    foreach ($data_cart as $d) {
      $data = array(
        'id_retur' => $no_retur,
        'id_produk' => $d['id'],
        'keterangan' => $d['keterangan']['status'],
        'catatan' => $d['keterangan']['catatan'],
        'qty' => $d['qty'],
        'foto' => $d['foto_retur'],
      );
      $this->db->insert('tb_retur_detail', $data);
    }

    // Simpan histori retur
    $spg_query = $this->db->query("SELECT nama_user FROM tb_user WHERE id = '$id_user'");
    $spg_row = $spg_query->row();
    $spg = $spg_row ? $spg_row->nama_user : 'Tanpa Nama';
    $histori = array(
      'id_retur' => $no_retur,
      'aksi' => 'Dibuat oleh : ',
      'pembuat' => $spg,
    );
    $this->db->insert('tb_retur_histori', $histori);

    // Finalisasi transaksi
    $this->db->trans_complete();
    $this->cart->destroy();

    // Kirim notifikasi WhatsApp
    $got_lead = $this->db->query("SELECT id_leader FROM tb_toko WHERE id = '$id_toko' AND id_spg = '$id_user'")->row();
    $id_lead = $got_lead->id_leader;
    $hp = $this->db->query("SELECT no_telp FROM tb_user WHERE id = '$id_lead'")->row();
    $phone = $hp->no_telp;
    $pt = $this->session->userdata('pt');
    $message = "$spg : Mengajukan Retur Barang ($no_retur) di $pt yang perlu approve, silahkan kunjungi s.id/absi-app";
    kirim_wa($phone, $message);

    tampil_alert('success', 'Berhasil', 'Data berhasil disimpan !');
    redirect(base_url('spg/Retur'));
  }

  public function resi()
  {
    $this->form_validation->set_rules('no_retur', 'Nomor Retur', 'required');

    if ($this->form_validation->run() == TRUE) {
      $id_retur = $this->input->post('no_retur');
      $resi = $this->input->post('resi');
      $ekspedisi = $this->input->post('ekspedisi');
      $where = array('id' => $id_retur);
      if ($ekspedisi == "gudang") {
        $tgl_jemput = $this->input->post('tgl_penjemputan');
        $data = array(
          'status' => '6',
          'tgl_jemput' => $tgl_jemput,
          'ekspedisi' => $ekspedisi,
        );
        $this->M_admin->update('tb_retur', $data, $where);
        tampil_alert('success', 'Berhasil', 'Tanggal Penjemputan Sudah Diinfokan ke pihak Gudang!');
      } else {
        $data = array(
          'status' => '3',
          'no_resi' => $resi,
          'ekspedisi' => $ekspedisi,
        );
        $this->M_admin->update('tb_retur', $data, $where);
        tampil_alert('success', 'Berhasil', 'Nomor Resi Berhasil Dikirim!');
      }
      redirect(base_url('spg/retur'));
    }
  }

  // get retur
  public function getRetur()
  {
    $id_toko = $this->input->post('id_toko');
    if (empty($id_toko)) {
      $response['success'] = false;
      $response['message'] = 'ID toko tidak valid.';
    } else {
      $retur = $this->db->query("SELECT * from tb_retur where id_toko ='$id_toko'")->result();
      if (!empty($retur)) {
        $response['success'] = true;
        $response['message'] = 'Data retur ditemukan.';
        $response['retur'] = $retur;
      } else {
        $response['success'] = false;
        $response['message'] = 'Data retur tidak ditemukan.';
      }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }
  // get detail retur
  public function getReturDetail()
  {
    $id_retur = $this->input->post('id_retur');
    if (empty($id_retur)) {
      $response['success'] = false;
      $response['message'] = 'ID retur tidak valid.';
    } else {
      $retur = $this->db->query("SELECT * from tb_retur where id ='$id_retur'")->row();
      $detail = $this->db->query("SELECT td.*, tp.nama_produk, tp.kode FROM tb_retur_detail td
      join tb_produk tp on td.id_produk = tp.id
      WHERE id_retur = '$id_retur'")->result();

      if ($retur && $detail) {
        $response['success'] = true;
        $response['message'] = 'Data detail retur barang ditemukan.';
        $response['retur'] = $retur;
        $response['detail'] = $detail;
      } else {
        $response['success'] = false;
        $response['message'] = 'Data detail retur barang tidak ditemukan.';
      }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }

  // get bap
  public function getBap()
  {
    $id_toko = $this->input->post('id_toko');
    if (empty($id_toko)) {
      $response['success'] = false;
      $response['message'] = 'ID toko tidak valid.';
    } else {
      $bap = $this->db->query("SELECT * from tb_bap where id_toko ='$id_toko'")->result();
      if (!empty($bap)) {
        $response['success'] = true;
        $response['message'] = 'Data bap ditemukan.';
        $response['bap'] = $bap;
      } else {
        $response['success'] = false;
        $response['message'] = 'Data bap tidak ditemukan.';
      }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }
  // get detail retur
  public function getBapDetail()
  {
    $id_bap = $this->input->post('id_bap');
    if (empty($id_bap)) {
      $response['success'] = false;
      $response['message'] = 'ID Bap tidak valid.';
    } else {
      $bap = $this->db->query("SELECT * from tb_bap where id ='$id_bap'")->row();
      $detail = $this->db->query("SELECT td.*, tp.nama_produk, tp.kode FROM tb_bap_detail td
      join tb_produk tp on td.id_produk = tp.id
      WHERE id_bap = '$id_bap'")->result();

      if ($bap && $detail) {
        $response['success'] = true;
        $response['message'] = 'Data detail bap barang ditemukan.';
        $response['bap'] = $bap;
        $response['detail'] = $detail;
      } else {
        $response['success'] = false;
        $response['message'] = 'Data detail bap barang tidak ditemukan.';
      }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }

  // list nomor kirim/mutasi
  public function getNomor()
  {
    $id_toko = $this->input->post('id_toko');
    $kategori = $this->input->post('kategori');
    if (empty($id_toko) || empty($kategori)) {
      $response['success'] = false;
      $response['message'] = 'ID toko / Kategori tidak valid.';
    } else {
      if ($kategori == 1) {
        $list = $this->db->query("SELECT * from tb_pengiriman where id_toko ='$id_toko' and status = 3 and id not in (select id_kirim from tb_bap where id_toko = '$id_toko')")->result();
        if (!empty($list)) {
          $response['success'] = true;
          $response['message'] = 'Data list ditemukan.';
          $response['list'] = $list;
        } else {
          $response['success'] = false;
          $response['message'] = 'Data list tidak ditemukan.';
        }
      } else {
        $list = $this->db->query("SELECT * from tb_mutasi where id_toko ='$id_toko' and status = 2 and id not in (select id_mutasi from tb_bap where id_toko = '$id_toko')")->result();
        if (!empty($list)) {
          $response['success'] = true;
          $response['message'] = 'Data list ditemukan.';
          $response['list'] = $list;
        } else {
          $response['success'] = false;
          $response['message'] = 'Data list tidak ditemukan.';
        }
      }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }

  // save Retur
  public function saveRetur()
  {
    $data_detail = [];
    $id_toko = $this->input->post('id_toko');
    $id_user = $this->input->post('id_user');
    $no_retur = $this->M_spg->kode_retur();
    $ids = $this->input->post('id_produk'); // Array ID produk
    $qtys = $this->input->post('qty'); // Array kuantitas
    $keterangan = $this->input->post('keterangan'); // Array keterangan
    $catatan = $this->input->post('catatan'); // Array catatan

    // Validasi input array
    if (!is_array($ids) || !is_array($qtys) || !is_array($keterangan)) {
      $response = [
        'status' => 'error',
        'message' => 'Data input tidak valid. Harus berupa array.'
      ];
      echo json_encode($response);
      return;
    }

    $this->db->trans_start();

    // Konfigurasi upload file
    $config['upload_path'] = './assets/img/retur/lampiran/';
    $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
    $config['max_size'] = 20048;
    $config['overwrite'] = true;
    $this->load->library('upload', $config);

    $lampiran = "";
    $packing = "";

    // Upload file 'lampiran'
    $config['file_name'] = "lampiran_" . $no_retur;
    $this->upload->initialize($config);
    if ($this->upload->do_upload('lampiran')) {
      $upload_data_lampiran = $this->upload->data();
      $lampiran = $upload_data_lampiran['file_name'];
    } else {
      $error = $this->upload->display_errors();
      echo json_encode(['status' => 'error', 'message' => $error]);
      return;
    }

    // Upload file 'foto_packing'
    $config['file_name'] = "packing_" . $no_retur;
    $this->upload->initialize($config);
    if ($this->upload->do_upload('foto_packing')) {
      $upload_data_foto_packing = $this->upload->data();
      $packing = $upload_data_foto_packing['file_name'];
    } else {
      $error = $this->upload->display_errors();
      echo json_encode(['status' => 'error', 'message' => $error]);
      return;
    }

    // Insert data retur
    $data_retur = [
      'id' => $no_retur,
      'id_toko' => $id_toko,
      'id_user' => $id_user,
      'lampiran' => $lampiran,
      'foto_packing' => $packing,
    ];
    $this->db->insert('tb_retur', $data_retur);

    // Insert data detail retur
    foreach ($ids as $index => $id) {
      $data_detail[] = [
        'id' => $id,
        'id_retur' => $no_retur,
        'qty' => $qtys[$index],
        'keterangan' => $keterangan[$index],
        'catatan' => $catatan[$index],
      ];
    }
    $this->db->insert_batch('tb_retur_detail', $data_detail);

    // Upload file gambar terkait detail retur
    $uploaded_files = [];
    $current_time = time();

    foreach ($_FILES as $key => $value) {
      if (!empty($value['name'][0])) {
        foreach ($value['name'] as $index => $file) {
          $new_filename = $ids[$index] . '_' . $current_time . '_' . ($index + 1);

          $_FILES['userfile']['name'] = $new_filename . '.' . pathinfo($value['name'][$index], PATHINFO_EXTENSION);
          $_FILES['userfile']['type'] = $value['type'][$index];
          $_FILES['userfile']['tmp_name'] = $value['tmp_name'][$index];
          $_FILES['userfile']['error'] = $value['error'][$index];
          $_FILES['userfile']['size'] = $value['size'][$index];

          $config['upload_path'] = './assets/img/retur/';
          $config['allowed_types'] = 'gif|jpg|jpeg|png';
          $config['max_size'] = 2048;
          $config['file_name'] = $new_filename;

          $this->upload->initialize($config);

          if ($this->upload->do_upload('userfile')) {
            $upload_data = $this->upload->data();
            $uploaded_files[] = $upload_data['file_name'];
            $this->db->insert('tb_retur_detail', ['foto' => $upload_data['file_name']]);
          } else {
            $error = $this->upload->display_errors();
            echo json_encode(['status' => 'error', 'message' => $error]);
            return;
          }
        }
      }
    }

    // Selesaikan transaksi
    $this->db->trans_complete();

    // Cek status transaksi
    if ($this->db->trans_status() === FALSE) {
      $response = [
        'status' => 'error',
        'message' => 'Transaksi gagal.'
      ];
    } else {
      $response = [
        'status' => 'success',
        'message' => 'Data dan gambar berhasil diunggah.',
        'uploaded_files' => $uploaded_files
      ];
    }

    echo json_encode($response);
  }
}
