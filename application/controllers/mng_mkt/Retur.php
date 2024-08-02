<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Retur extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "9") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }

  //  fungsi tutup toko
  public function index()
  {

    $data['title'] = 'Retur';
    $data['list_data'] = $this->db->query("SELECT tp.*, tk.nama_toko from tb_retur tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        ")->result();
    $this->template->load('template/template', 'manager_mkt/retur/lihat_data', $data);
  }
  // detail detail tutup toko
  public function detail_p($Retur)
  {

    $data['title'] = 'Retur';
    $data['permintaan'] = $this->db->query("SELECT tp.*, tk.nama_toko, tk.alamat, tk.telp, tu.nama_user as spg from tb_retur tp
        JOIN tb_toko tk on tp.id_toko = tk.id
        JOIN tb_user tu on tp.id_user = tu.id
        where tp.id = '$Retur'")->result();
    $data['detail_retur'] = $this->db->query("SELECT td.*,tpk.kode as kode_produk, tpk.nama_produk, tpk.satuan  from tb_retur_detail td
        JOIN tb_retur tp on td.id_retur = tp.id
        JOIN tb_produk tpk on td.id_produk = tpk.id
        where td.id_retur = '$Retur'")->result();
    $this->template->load('template/template', 'manager_mkt/retur/detail', $data);
  }
  // retur barang dr spg
  public function retur()
  {
    $data['title'] = 'Retur Barang';
    $data['list_data'] = $this->db->query("SELECT tr.*, tk.nama_toko, tu.nama_user as spg from tb_retur tr
    JOIN tb_toko tk on tr.id_toko = tk.id
    JOIN tb_user tu on tr.id_user = tu.id
    WHERE tr.status > 0 AND tr.status < 7 ORDER BY tr.status = 1 desc, tr.id desc")->result();
    $this->template->load('template/template', 'manager_mkt/retur/retur', $data);
  }
  public function detail_retur($no_retur)
  {
    $data['title'] = 'Retur Barang';
    $data['retur'] = $this->db->query("SELECT tp.*, tk.nama_toko, tk.alamat, tk.telp, tu.nama_user as spg from tb_retur tp
    JOIN tb_toko tk on tp.id_toko = tk.id
    JOIN tb_user tu on tp.id_user = tu.id
    where tp.id = '$no_retur'")->row();
    $data['detail_retur'] = $this->db->query("SELECT td.*,tpk.kode as kode_produk, tpk.nama_produk, tpk.satuan  from tb_retur_detail td
     JOIN tb_retur tp on td.id_retur = tp.id
     JOIN tb_produk tpk on td.id_produk = tpk.id
     where td.id_retur = '$no_retur'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_retur_histori tro
    join tb_retur tr on tro.id_retur = tr.id where tro.id_retur = '$no_retur'")->result();
    $this->template->load('template/template', 'manager_mkt/retur/detail_retur', $data);
  }
  public function tindakan()
  {
    $catatan = $this->input->post('catatan_mm');
    $action = $this->input->post('tindakan');
    $id_retur = $this->input->post('id_retur');
    $mm = $this->session->userdata('nama_user');
    $pt = $this->session->userdata('pt');
    $id_mm = $this->session->userdata('id');
    $status = $action == "1" ? "2" : "5";
    $aksi = $action == "1" ? 'Disetujui' : 'Ditolak';

    // Update status retur
    $data = array('status' => $status, 'id_mm' => $id_mm);
    $where = array('id' => $id_retur);
    $this->db->update('tb_retur', $data, $where);

    // Insert history retur
    $histori = array(
      'id_retur' => $id_retur,
      'aksi' => $aksi . ' oleh : ',
      'pembuat' => $mm,
      'catatan_h' => $catatan
    );
    $this->db->insert('tb_retur_histori', $histori);
    if ($action == "1") {
      $hp = $this->db->select('no_telp')
        ->from('tb_user')
        ->where_in('role', array(6, 8))
        ->get()
        ->result();
      foreach ($hp as $h) {
        $phone = $h->no_telp;
        $message = "Anda memiliki 1 Pengajuan Retur ($id_retur - $pt) yang perlu di jemput, silahkan kunjungi s.id/absi-app";
        kirim_wa($phone, $message);
      }
    }
    tampil_alert('success', 'BERHASIL', 'Pengajuan Retur berhasil di' . $aksi);
    redirect(base_url('mng_mkt/Retur/detail_retur/' . $id_retur));
  }
  // print SPPR
  public function sppr($no_retur)
  {
    $data['r'] = $this->db->query("SELECT tr.*, tt.nama_toko, tu.nama_user as spg, tl.nama_user as leader, tu.no_telp, mv.ttd as ttd_mv,mm.ttd as ttd_mm from tb_retur tr
    JOIN tb_toko tt on tr.id_toko = tt.id
    JOIN tb_user tu on tt.id_spg = tu.id
    JOIN tb_user tl on tt.id_leader = tl.id
    LEFT JOIN tb_user mv on tr.id_mv = mv.id
    LEFT JOIN tb_user mm on tr.id_mm = mm.id
    where tr.id = '$no_retur'")->row();
    $data['detail'] = $this->db->query("SELECT trd.*, tpk.nama_produk, tpk.kode, tpk.satuan from tb_retur_detail trd
    join tb_produk tpk on trd.id_produk = tpk.id
    where trd.id_retur = '$no_retur' order by tpk.nama_produk desc")->result();
    $this->load->view('adm_gudang/retur/sppr', $data);
  }
}
