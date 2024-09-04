<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $login = $this->session->userdata('status');
    $role = $this->session->userdata('role');
    if ($login != "login") {
      tampil_alert('error', 'Session Habis', 'Sesi login anda habis, silahkan login kembali');
      redirect(base_url(''));
    } else if ($role != "16") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }
  public function index()
  {
    $data['title'] = 'Dashboard';
    $bln = date('m');
    $thn = date('Y');
    $data['t_minta'] = $this->db->query("
        SELECT 
            COUNT(DISTINCT tp.id) as total, 
            SUM(tpd.qty) as total_qty
        FROM tb_permintaan_detail tpd
        JOIN tb_permintaan tp ON tpd.id_permintaan = tp.id
        WHERE tp.status >= 2 AND tp.status != 5 AND tpd.status = 1 AND MONTH(tp.updated_at) = $bln 
        AND YEAR(tp.updated_at) = $thn
    ")->row();
    $data['t_kirim'] = $this->db->query("
        SELECT 
            COUNT(DISTINCT tp.id) as total, 
            SUM(tpd.qty) as total_qty
        FROM tb_pengiriman_detail tpd
        JOIN tb_pengiriman tp ON tpd.id_pengiriman = tp.id
        WHERE MONTH(tp.created_at) = $bln 
        AND YEAR(tp.created_at) = $thn
    ")->row();
    $data['t_retur'] = $this->db->query("
        SELECT 
            COUNT(DISTINCT tp.id) as total, 
            SUM(tpd.qty) as total_qty
        FROM tb_retur_detail tpd
        JOIN tb_retur tp ON tpd.id_retur = tp.id
        WHERE (tp.status = '3' OR tp.status = '4' OR tp.status = '7' OR tp.status = '13' OR tp.status = '14' OR tp.status = '15') AND MONTH(tp.created_at) = $bln 
        AND YEAR(tp.created_at) = $thn
    ")->row();
    $data['t_artikel'] = $this->db->query("SELECT count(id) as total from tb_produk")->row();
    $data['t_toko'] = $this->db->query("SELECT count(id) as total from tb_toko where status = 1")->row();
    $data['t_stok'] = $this->db->query("SELECT sum(ts.qty) as total FROM tb_stok ts
    JOIN tb_toko tt on ts.id_toko = tt.id where ts.status = 1 AND tt.status = 1 ")->row();
    $this->template->load('template/template', 'k_gudang/dashboard', $data);
  }
  public function artikel()
  {
    $data['title'] = 'Artikel';
    $data['artikel'] = $this->db->query("SELECT * from tb_produk")->result();
    $this->template->load('template/template', 'k_gudang/artikel', $data);
  }
  public function toko()
  {
    $data['title'] = 'Toko';
    $data['toko'] = $this->db->query("SELECT tt.*, ts.nama_user as spv, tl.nama_user as leader, tp.nama_user as spg from tb_toko tt
    LEFT JOIN tb_user ts on tt.id_spv = ts.id
    LEFT JOIN tb_user tl on tt.id_leader = tl.id
    LEFT JOIN tb_user tp on tt.id_spg = tp.id
    WHERE tt.status = 1")->result();
    $this->template->load('template/template', 'k_gudang/toko', $data);
  }
  public function po()
  {
    $data['title'] = 'Permintaan';
    $data['po'] = $this->db->query("SELECT tp.*, tt.nama_toko, tt.alamat,tl.nama_user as leader from tb_permintaan tp
    JOIN tb_toko tt on tp.id_toko = tt.id
    LEFT JOIN tb_user tl on tt.id_leader = tl.id
    WHERE tp.status >= 2 AND tp.status != 5
    ORDER BY tp.id desc")->result();
    $this->template->load('template/template', 'k_gudang/po', $data);
  }
  public function po_detail($id)
  {
    $data['title'] = 'Permintaan';
    $data['permintaan'] = $this->db->query("SELECT tp.*, tt.nama_toko, tt.alamat from tb_permintaan tp
    join tb_toko tt on tp.id_toko = tt.id 
    where tp.id = '$id'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tp.id_toko,tpk.*, tt.het from tb_permintaan_detail tpd
    join tb_permintaan tp on tpd.id_permintaan = tp.id
    join tb_toko tt on tp.id_toko = tt.id
    join tb_produk tpk on tpd.id_produk = tpk.id
    where tpd.id_permintaan = '$id' AND tpd.qty != 0 ")->result();
    $this->template->load('template/template', 'k_gudang/po_detail', $data);
  }
  public function kirim()
  {
    $data['title'] = 'Pengiriman';
    $data['po'] = $this->db->query("SELECT tp.*, tt.nama_toko, tt.alamat,tl.nama_user as leader from tb_pengiriman tp
    JOIN tb_toko tt on tp.id_toko = tt.id
    LEFT JOIN tb_user tl on tt.id_leader = tl.id
    ORDER BY tp.id desc")->result();
    $this->template->load('template/template', 'k_gudang/kirim', $data);
  }
  public function kirim_detail($id)
  {
    $data['title'] = 'Pengiriman';
    $data['pengiriman'] = $this->db->query("SELECT tp.*,tt.id as id_toko, tt.nama_toko,tt.alamat, tt.telp,tu.nama_user,tk.nama_user as spg from tb_pengiriman tp
    join tb_toko tt on tp.id_toko = tt.id
    join tb_user tu on tp.id_user = tu.id
    join tb_user tk on tt.id_spg = tk.id
    where tp.id = '$id'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tpk.kode, tpk.nama_produk, tpk.satuan from tb_pengiriman_detail tpd
    join tb_produk tpk on tpd.id_produk = tpk.id
    where tpd.id_pengiriman = '$id' and tpd.qty != '0'")->result();
    $this->template->load('template/template', 'k_gudang/kirim_detail', $data);
  }
  public function retur()
  {
    $data['title'] = 'Retur';
    $data['po'] = $this->db->query("SELECT tp.*, tt.nama_toko, tt.alamat,tl.nama_user as leader from tb_retur tp
    JOIN tb_toko tt on tp.id_toko = tt.id
    LEFT JOIN tb_user tl on tt.id_leader = tl.id
    WHERE tp.status IN (3,4,7,13,14,15)
    ORDER BY tp.status = 3 desc, tp.status = 13 desc, tp.id desc")->result();
    $this->template->load('template/template', 'k_gudang/retur', $data);
  }
  public function retur_detail($id)
  {
    $id_user = $this->session->userdata('id');
    $cekTTD = $this->db->query("SELECT ttd from tb_user where id = ?", array($id_user))->row();
    if (empty($cekTTD->ttd)) {
      popup('Tanda Tangan Digital', 'Anda harus membuat TTD Digital terlebih dahulu untuk melanjutkan proses Retur', 'Profile');
      redirect('k_gudang/Dashboard/retur');
    }
    $data['title'] = 'Retur';
    $query = $this->db->query("SELECT tr.*, tu.nama_user as spg, tt.nama_toko,tt.alamat, tt.telp from tb_retur tr
    join tb_user tu on tr.id_user = tu.id
    join tb_toko tt on tr.id_toko = tt.id  where tr.id = '$id'")->row();
    $data['retur'] = $query;
    if ($query->status == 3 || $query->status == 7) {
      $detail = 'retur_detail';
    } else {
      $detail = 'retur_detail_toko';
    }
    $data['detail_retur'] = $this->db->query("SELECT trd.*,tr.foto_resi,tr.no_resi,tp.kode,tp.nama_produk,tp.satuan from tb_retur_detail trd
      join tb_retur tr on trd.id_retur = tr.id
      join tb_produk tp on trd.id_produk = tp.id
      where trd.id_retur = '$id' order by tp.nama_produk desc")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_retur_histori tro
    join tb_retur tr on tro.id_retur = tr.id where tro.id_retur = '$id'")->result();
    $this->template->load('template/template', 'k_gudang/' . $detail, $data);
  }
  public function retur_simpan()
  {
    $tgl_jemput = $this->input->post('tgl_jemput');
    $catatan = $this->input->post('catatan');
    $id_retur = $this->input->post('id_retur');
    $jenis = $this->input->post('jenis');
    $kg = $this->session->userdata('nama_user');
    $pt = $this->session->userdata('pt');
    $id_kg = $this->session->userdata('id');
    $status = $jenis == "retur_spg" ? "7" : "14";
    $data = array('status' => $status, 'tgl_jemput' => $tgl_jemput, 'id_kgudang' => $id_kg);
    $where = array('id' => $id_retur);
    $this->db->update('tb_retur', $data, $where);

    // Insert history retur
    $histori = array(
      'id_retur' => $id_retur,
      'aksi' => 'Di Ketahui oleh : ',
      'pembuat' => $kg,
      'catatan_h' => $catatan
    );
    $this->db->insert('tb_retur_histori', $histori);
    $hp = $this->db->select('no_telp')
      ->from('tb_user')
      ->where('role', 5)
      ->get()
      ->result();
    foreach ($hp as $h) {
      $phone = $h->no_telp;
      $message = "Anda memiliki 1 Pengajuan Retur ($id_retur - $pt) yang perlu di jemput, silahkan kunjungi s.id/absi-app";
      kirim_wa($phone, $message);
    }
    tampil_alert('success', 'BERHASIL', 'Pengajuan Retur berhasil di proses dan siap dibuatkan SPPR');
    redirect(base_url('k_gudang/Dashboard/retur_detail/' . $id_retur));
  }
}
