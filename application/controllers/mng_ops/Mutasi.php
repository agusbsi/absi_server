<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "17") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }
  public function index()
  {
    $data['title'] = 'Mutasi Barang';
    $data['list_data'] = $this->db->query("SELECT tm.*, tt.nama_toko as asal, tk.nama_toko as tujuan 
                                            FROM tb_mutasi tm
                                            JOIN tb_toko tt ON tm.id_toko_asal = tt.id
                                            JOIN tb_toko tk ON tm.id_toko_tujuan = tk.id
                                            ORDER BY tm.status = 0 DESC, tm.status = 4 DESC, tm.id DESC")->result();
    $this->template->load('template/template', 'manager_ops/mutasi/lihat_data', $data);
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
    $this->template->load('template/template', 'manager_ops/mutasi/bap', $data);
  }
  public function detail($mutasi)
  {
    $data['title'] = 'Mutasi Barang';
    $query = $this->db->query("SELECT tm.*,tu.nama_user as leader, tt.nama_toko as asal, tk.nama_toko as tujuan, tt.alamat as alamat_asal, tk.alamat as alamat_tujuan from tb_mutasi tm
    join tb_toko tt on tm.id_toko_asal = tt.id
    join tb_toko tk on tm.id_toko_tujuan = tk.id
    join tb_user tu on tm.id_user = tu.id
    where tm.id = '$mutasi'")->row();
    $data['mutasi'] = $query;
    $id_toko = $query->id_toko_asal;
    $data['detail_mutasi']  = $this->db->query("SELECT tmd.*, tp.nama_produk, tp.kode, tp.satuan, ts.qty as stok from tb_mutasi_detail tmd
      join tb_produk tp on tmd.id_produk = tp.id
      JOIN tb_stok ts on tmd.id_produk = ts.id_produk 
      where tmd.id_mutasi = '$mutasi' AND ts.id_toko = '$id_toko'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_mutasi_histori tpo
    join tb_mutasi tp on tpo.id_mutasi = tp.id where tpo.id_mutasi = '$mutasi'")->result();
    $this->template->load('template/template', 'manager_ops/mutasi/detail', $data);
  }
  public function hapus_item()
  {
    $id = $this->input->post('id');
    $this->db->query("DELETE from tb_mutasi_detail where id = '$id'");
  }
  function proses_simpan()
  {
    $id_mv = $this->session->userdata('id');
    $mv = $this->session->userdata('nama_user');
    $pt = $this->session->userdata('pt');
    $id_mutasi  = $this->input->post('id_mutasi');
    $id_leader  = $this->input->post('id_leader');
    $id_detail  = $this->input->post('id_detail');
    $qty  = $this->input->post('qty');
    $catatan  = $this->input->post('catatan');
    $tindakan  = $this->input->post('tindakan');
    $jumlah = count($id_detail);
    $this->db->trans_start();
    if ($tindakan == 1) {
      $where = array('id' => $id_mutasi);
      $data = array(
        'status' => 1,
        'id_opr' => $id_mv,
        'catatan_mv' => $catatan
      );
      $this->db->update('tb_mutasi', $data, $where);
      $aksi = "Disetujui OPR : ";
      for ($i = 0; $i < $jumlah; $i++) {
        $d_id_detail  = $id_detail[$i];
        $d_qty        = $qty[$i];
        $data_detail = array(
          'qty' => $d_qty,
          'status' => 6
        );
        $this->db->where('id', $d_id_detail);
        $this->db->update('tb_mutasi_detail', $data_detail);
      }
      $phones = $this->db->query("SELECT no_telp FROM tb_user WHERE role = 9 and status = 1 ")->result_array();
      $message = "Ada pengajuan Mutasi baru ( " . $id_mutasi . " - " . $pt . " ) yang perlu di cek, silahkan kunjungi s.id/absi-app";
      // $message = "Pengajuan Mutasi anda ( " . $id_mutasi . " - " . $pt . " ) telah disetujui, silahkan kunjungi s.id/absi-app";
      foreach ($phones as $phone) {
        $number = $phone['no_telp'];
        $hp = substr($number, 0, 1);
        if ($hp == '0') {
          $number = '62' . substr($number, 1);
        }
        kirim_wa($number, $message);
      }
    } else {
      $tolak = array(
        'status' => '3'
      );
      $this->db->update('tb_mutasi', $tolak, array('id' => $id_mutasi));
      $aksi = "Ditolak OPR : ";
    }
    // Insert histori
    $histori = array(
      'id_mutasi' => $id_mutasi,
      'aksi' => $aksi,
      'pembuat' => $mv,
      'catatan' => $catatan
    );
    $this->db->insert('tb_mutasi_histori', $histori);
    $this->db->trans_complete();
    tampil_alert('success', 'Berhasil', 'Data Mutasi artikel berhasil di proses.');
    redirect(base_url('mng_ops/Mutasi/detail/' . $id_mutasi));
  }
  // setujui bap
  public function setujuiBap()
  {
    $toko_asal = $this->input->POST('toko_asal');
    $toko_tujuan = $this->input->POST('toko_tujuan');
    $id_mutasi = $this->input->POST('id_mutasi');
    $id_produk = $this->input->POST('id_produk');
    $qty_terima = $this->input->POST('qty_terima');
    $qty_update = $this->input->POST('qty_update');
    $list = count($id_produk);
    $this->db->trans_start();
    for ($i = 0; $i < $list; $i++) {
      $l_id_produk = $id_produk[$i];
      $qtyNew = $qty_update[$i];
      $qtyOld = $qty_terima[$i];
      // cek apakah artikel ada di stok 
      $cekTokoTujuan = $this->db->query("SELECT id_produk FROM tb_stok WHERE id_produk = '$l_id_produk' AND id_toko = '$toko_tujuan' ")->num_rows();
      if ($cekTokoTujuan > 0) {
        $this->db->query("UPDATE tb_stok set qty = (qty + '$qtyNew' - '$qtyOld'), updated_at = now() where id_produk = '$l_id_produk' and id_toko = '$toko_tujuan'");
        $this->db->query("UPDATE tb_stok set qty = (qty + '$qtyOld' - '$qtyNew'), updated_at = now() where id_produk = '$l_id_produk' and id_toko = '$toko_asal'");
      } else {
        $data_detail = array(
          'id_produk' => $l_id_produk,
          'qty' => $qtyNew,
          'id_toko' => $toko_tujuan,
          'status' => "1",
        );

        $this->db->insert('tb_stok', $data_detail);
        $this->db->query("UPDATE tb_stok set qty = (qty + '$qtyOld' - '$qtyNew'), updated_at = now() where id_produk = '$l_id_produk' and id_toko = '$toko_asal'");
      }
      //  update di tabel detail mutasi
      $where_mutasi = array(
        'id_mutasi' => $id_mutasi,
        'id_produk' => $l_id_produk,
      );
      $detail_mutasi = array(
        'status' => 2,
      );
      $this->db->update('tb_mutasi_detail', $detail_mutasi, $where_mutasi);
    }
    // update status di tabel permintaan
    $where = array(
      'id' => $id_mutasi,
    );
    $list_mutasi = array(
      'status' => 5,
      'updated_at' => date('Y-m-d H:i:s'),
    );
    $this->db->update('tb_mutasi', $list_mutasi, $where);
    $this->db->trans_complete();
    tampil_alert('success', 'BERHASIL', 'Proses BAP Mutasi Berhasil di perbarui.');
    redirect(base_url('mng_ops/Mutasi'));
  }
}
