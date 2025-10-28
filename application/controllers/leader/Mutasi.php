<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "3" && $role != "9" && $role != "17" && $role != "1") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_adm_gudang');
    $this->load->model('M_produk');
  }

  public function index()
  {
    $id_leader = $this->session->userdata('id');
    $data['title'] = 'Mutasi Barang';
    $data['list_data']  = $this->db->query("SELECT tm.*, tt.nama_toko as asal, tk.nama_toko as tujuan from tb_mutasi tm
    join tb_toko tt on tm.id_toko_asal = tt.id
    join tb_toko tk on tm.id_toko_tujuan = tk.id
    where tm.id_user = '$id_leader'
    order by tm.created_at desc")->result();
    $this->template->load('template/template', 'leader/mutasi/lihat_data', $data);
  }
  // pengiriman
  public function add()
  {
    $data['title'] = 'Mutasi Barang';
    $id_leader = $this->session->userdata('id');
    $id_toko = $this->input->get('id');
    $data['kode_mutasi'] = $this->M_adm_gudang->kode_mutasi();
    $data['list_toko'] = $this->db->query("SELECT * from tb_toko where status != 0 and id_leader='$id_leader'")->result();
    $data['toko_tujuan'] = $this->db->query("SELECT * from tb_toko where status != 0 and id != '$id_toko'")->result();
    $this->template->load('template/template', 'leader/mutasi/add', $data);
  }
  public function detail($id)
  {
    $data['title'] = 'Mutasi Barang';
    $data['mutasi'] = $this->db->query("SELECT tm.*, tt.nama_toko as asal, tj.nama_toko as tujuan from tb_mutasi tm
    join tb_toko tt on tm.id_toko_asal = tt.id 
    join tb_toko tj on tm.id_toko_tujuan = tj.id  where tm.id = '$id'")->row();
    $data['detail'] = $this->db->query("SELECT tmd.*, tp.kode,tp.nama_produk from tb_mutasi_detail tmd
    join tb_produk tp on tmd.id_produk = tp.id where tmd.id_mutasi = '$id'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_mutasi_histori tpo
    join tb_mutasi tp on tpo.id_mutasi = tp.id where tpo.id_mutasi = '$id'")->result();
    $this->template->load('template/template', 'leader/mutasi/detail', $data);
  }
  public function edit($id)
  {
    $data['title'] = 'Mutasi Barang';
    $data['mutasi'] = $this->db->query("SELECT tm.*, tt.nama_toko as asal, tj.nama_toko as tujuan from tb_mutasi tm
    join tb_toko tt on tm.id_toko_asal = tt.id 
    join tb_toko tj on tm.id_toko_tujuan = tj.id  where tm.id = '$id'")->row();
    $id_toko = $this->db->query("SELECT id_toko_asal from tb_mutasi where id = '$id'")->row()->id_toko_asal;
    $data['detail'] = $this->db->query("SELECT tmd.*, tp.kode,tp.nama_produk, ts.qty as stok from tb_mutasi_detail tmd
    join tb_produk tp on tmd.id_produk = tp.id
    JOIN tb_stok ts ON tmd.id_produk = ts.id_produk AND ts.id_toko = '$id_toko'
     where tmd.id_mutasi = '$id'")->result();
    $data['list_produk'] = $this->db->query("SELECT ts.*, tp.nama_produk, tp.satuan, tp.kode from tb_stok ts
     join tb_produk tp on ts.id_produk = tp.id
     where id_toko = '$id_toko' and tp.id NOT IN(SELECT id_produk from tb_mutasi_detail where id_mutasi = '$id')")->result();
    $this->template->load('template/template', 'leader/mutasi/edit', $data);
  }
  public function bap($id)
  {
    $data['title'] = 'Mutasi Barang';
    $data['mutasi'] = $this->db->query("SELECT tm.*, tt.nama_toko as asal, tj.nama_toko as tujuan from tb_mutasi tm
    join tb_toko tt on tm.id_toko_asal = tt.id 
    join tb_toko tj on tm.id_toko_tujuan = tj.id  where tm.id = '$id'")->row();
    $id_toko = $this->db->query("SELECT id_toko_asal from tb_mutasi where id = '$id'")->row()->id_toko_asal;
    $data['detail'] = $this->db->query("SELECT tmd.*, tp.kode,tp.nama_produk, ts.qty as stok from tb_mutasi_detail tmd
    join tb_produk tp on tmd.id_produk = tp.id
    JOIN tb_stok ts ON tmd.id_produk = ts.id_produk AND ts.id_toko = '$id_toko'
     where tmd.id_mutasi = '$id'")->result();
    $data['list_produk'] = $this->db->query("SELECT ts.*, tp.nama_produk, tp.satuan, tp.kode from tb_stok ts
     join tb_produk tp on ts.id_produk = tp.id
     where id_toko = '$id_toko' and tp.id NOT IN(SELECT id_produk from tb_mutasi_detail where id_mutasi = '$id')")->result();
    $this->template->load('template/template', 'leader/mutasi/bap', $data);
  }
  // ambil data ajax untuk wilayah
  function list_produk($id_toko)
  {
    $query = $this->db->query("SELECT ts.*, tp.kode,tp.nama_produk, tp.id as id_p from tb_stok ts
      join tb_produk tp on ts.id_produk = tp.id
      where ts.id_toko = '$id_toko'");
    $data = "<option value='' selected>- Pilih Artikel -</option>";
    foreach ($query->result() as $value) {
      $data .= "<option value='" . $value->id_p . "'>" . $value->kode . " | " . $value->nama_produk . "</option>";
    }
    echo $data;
  }
  // tampilkan detail produk
  public function tampilkan_detail_produk($id)
  {
    $id_toko = $this->input->get('id_toko');
    $data_produk = $this->db->query("SELECT ts.*, tp.nama_produk, tp.kode, tp.satuan from tb_stok ts
    join tb_produk tp on ts.id_produk = tp.id
    where ts.id_produk = '$id' and ts.id_toko = '$id_toko'")->row();
    echo json_encode($data_produk);
  }
  // menampilkan keranjang
  public function keranjang()
  {
    $this->load->view('leader/mutasi/keranjang');
  }
  // proses add mutasi
  function proses_add()
  {
    $id_leader = $this->session->userdata('id');
    $leader = $this->session->userdata('nama_user');
    $pt = $this->session->userdata('pt');
    $no_mutasi = $this->M_adm_gudang->kode_mutasi();
    $id_produk  = $this->input->post('id_produk');
    $qty  = $this->input->post('qty');
    $catatan  = $this->input->post('catatan');
    $jumlah = count($id_produk);
    $this->db->trans_start();
    $mutasi = [
      'id' => $no_mutasi,
      'id_toko_asal' => $this->input->post('toko_asal'),
      'id_toko_tujuan' => $this->input->post('toko_tujuan'),
      'id_user' => $id_leader,
      'status' => '0',
    ];
    for ($i = 0; $i < $jumlah; $i++) {
      $d_id_produk = $id_produk[$i];
      $d_qty = $qty[$i];
      $mutasi_detail[] = array(
        'id_mutasi' =>  $no_mutasi,
        'id_produk' =>  $d_id_produk,
        'qty' =>  $d_qty,
      );
    }
    $this->db->insert_batch('tb_mutasi_detail', $mutasi_detail);
    $this->db->insert('tb_mutasi', $mutasi);
    $histori = array(
      'id_mutasi' => $no_mutasi,
      'aksi' => 'Dibuat oleh : ',
      'pembuat' => $leader,
      'catatan' => $catatan
    );
    $this->db->insert('tb_mutasi_histori', $histori);
    $this->db->trans_complete();
    $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE role = 17 and status = 1")->result_array();
    $message = "Ada pengajuan Mutasi baru ( " . $no_mutasi . " - " . $pt . " ) yang perlu di cek, silahkan kunjungi s.id/absi-app";
    foreach ($phones as $phone) {
      $number = $phone['no_telp'];
      $hp = substr($number, 0, 1);
      if ($hp == '0') {
        $number = '62' . substr($number, 1);
      }
      kirim_wa($number, $message);
    }
    tampil_alert('success', 'Berhasil', 'Mutasi Barang berhasil di buat. !');
    redirect(base_url('leader/Mutasi'));
  }
  // update BAP
  public function updatebap()
  {
    $id_mutasi  = $this->input->post('id_mutasi');
    $id_detail  = $this->input->post('id_detail');
    $qty_update  = $this->input->post('qty_update');
    $catatan  = $this->input->post('catatan');

    // Memastikan bahwa $qty_update adalah array
    if (!is_array($qty_update)) {
      tampil_alert('error', 'Gagal', 'Data qty tidak valid.');
      redirect(base_url('leader/Mutasi'));
      return;
    }

    $jumlah = count($id_detail);
    $this->db->trans_start();

    for ($i = 0; $i < $jumlah; $i++) {
      $detail = $id_detail[$i];
      $qty = $qty_update[$i];

      // Memastikan bahwa $qty adalah numerik dan tidak negatif
      if (!is_numeric($qty) || $qty < 0) {
        tampil_alert('error', 'Gagal', 'Data qty tidak valid.');
        redirect(base_url('leader/Mutasi'));
        return;
      }

      $data = array(
        'qty_update' =>  $qty,
      );
      $this->db->update('tb_mutasi_detail', $data, array('id' => $detail));
    }

    // Mengupdate status mutasi
    $this->db->update('tb_mutasi', array('status' => 4, 'catatan' => $catatan), array('id' => $id_mutasi));

    $this->db->trans_complete();
    $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE role = 6")->result_array();
    $message = "Anda memiliki 1 BAP Perbaikan Mutasi dengan nomor ( " . $id_mutasi . " ) yang perlu approve silahkan kunjungi s.id/absi-app";
    foreach ($phones as $phone) {
      $number = $phone['no_telp'];
      $hp = substr($number, 0, 1);
      if ($hp == '0') {
        $number = '62' . substr($number, 1);
      }
      kirim_wa($number, $message);
    }
    // Menampilkan pesan sukses
    tampil_alert('success', 'Berhasil', 'Pengajuan BAP Mutasi Barang berhasil dibuat!');
    redirect(base_url('leader/Mutasi'));
  }

  // print sppr
  public function mutasi_print($mutasi)
  {
    $data['title'] = 'Surat Perintah Pengambilan retur Konsinyasi';
    $data['mutasi'] = $this->db->query("SELECT tm.*,tu.nama_user as leader, tu.ttd as ttd_leader,
    mv.ttd as ttd_mv, mv.nama_user as nama_mv,opr.ttd as ttd_opr, opr.nama_user as nama_opr,
    mm.ttd as ttd_mm, mm.nama_user as nama_mm,
    tt.nama_toko as asal, tk.nama_toko as tujuan, tt.alamat as alamat_asal, tk.alamat as alamat_tujuan, tst.nama_user as spg_asal, tst.no_telp as telp_asal,
    tsk.nama_user as spg_tujuan, tsk.no_telp as telp_tujuan from tb_mutasi tm
      join tb_toko tt on tm.id_toko_asal = tt.id
      join tb_user tst on tt.id_spg = tst.id
      join tb_toko tk on tm.id_toko_tujuan = tk.id
      join tb_user tsk on tk.id_spg = tsk.id
      join tb_user tu on tm.id_user = tu.id
      LEFT JOIN tb_user mv on tm.id_mv = mv.id
      LEFT JOIN tb_user opr on tm.id_opr = opr.id
      LEFT JOIN tb_user mm on tm.id_mm = mm.id
      where tm.id = '$mutasi'")->row();
    $data['detail_mutasi']  = $this->db->query("SELECT tmd.*, tp.nama_produk, tp.kode, tp.satuan from tb_mutasi_detail tmd
      join tb_produk tp on tmd.id_produk = tp.id
      where tmd.id_mutasi = '$mutasi' and tmd.status = '1'")->result();
    $this->load->view('leader/mutasi/mutasi_print', $data);
  }
  // hapus mutasi
  public function hapus_data($id)
  {
    $this->db->delete('tb_mutasi', array('id' => $id));

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      tampil_alert('error', 'GAGAL', 'Gagal menghapus data Mutasi ' . $id);
    } else {
      $this->db->trans_commit();
      tampil_alert('success', 'DI HAPUS', 'Data Mutasi ' . $id . ' berhasil dihapus');
    }

    redirect(base_url('leader/Mutasi'));
  }
  public function hapus_item()
  {
    $id = $this->input->post('id');
    $this->db->query("DELETE from tb_mutasi_detail where id = '$id'");
  }
  public function tambah_item()
  {
    $halaman = $this->input->post('halaman');
    $id_produk = $this->input->post('id_produk');
    $id_mutasi = $this->input->post('id_mutasi');
    $qty = $this->input->post('qty');
    if ($qty == 0 && $halaman == "edit") {
      tampil_alert('error', 'STOK KURANG', 'Stok tidak mencukupi untuk mutasi.');
      redirect(base_url('leader/Mutasi/edit/') . $id_mutasi);
      return; // Keluar dari fungsi tambah_item
    }
    $qty_to_use = ($halaman == "edit") ? $qty : 0;
    $data = array(
      'id_produk' => $id_produk,
      'id_mutasi' => $id_mutasi,
      'qty' => $qty_to_use
    );
    $this->db->insert('tb_mutasi_detail', $data);
    redirect(base_url('leader/Mutasi/' . $halaman . '/') . $id_mutasi);
  }
}
