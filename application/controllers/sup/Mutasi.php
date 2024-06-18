<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "6") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_admin');
    $this->load->model('M_support');
  }
  public function index()
  {
    $data['title'] = 'Mutasi Barang';
    $data['list_data'] = $this->db->query("SELECT tm.*, tt.nama_toko as asal, tk.nama_toko as tujuan 
                                            FROM tb_mutasi tm
                                            JOIN tb_toko tt ON tm.id_toko_asal = tt.id
                                            JOIN tb_toko tk ON tm.id_toko_tujuan = tk.id
                                            ORDER BY tm.status = 0 DESC, tm.status = 4 DESC, tm.id DESC")->result();
    $this->template->load('template/template', 'manager_mv/mutasi/lihat_data', $data);
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
    $this->template->load('template/template', 'manager_mv/mutasi/bap', $data);
  }


  // detail mutasi
  // detail permintaan
  public function detail($mutasi)
  {

    $data['title'] = 'Mutasi Barang';
    $data['mutasi'] = $this->db->query("SELECT tm.*,tu.nama_user as leader, tt.nama_toko as asal, tk.nama_toko as tujuan, tt.alamat as alamat_asal, tk.alamat as alamat_tujuan from tb_mutasi tm
      join tb_toko tt on tm.id_toko_asal = tt.id
      join tb_toko tk on tm.id_toko_tujuan = tk.id
      join tb_user tu on tm.id_user = tu.id
      where tm.id = '$mutasi'")->row();
    $data['detail_mutasi']  = $this->db->query("SELECT tmd.*, tp.nama_produk, tp.kode, tp.satuan from tb_mutasi_detail tmd
      join tb_produk tp on tmd.id_produk = tp.id
      where tmd.id_mutasi = '$mutasi'")->result();
    $this->template->load('template/template', 'manager_mv/mutasi/detail', $data);
  }
  // proses approve
  //  approve artikel
  public function approve()
  {
    $id = $this->input->get('id');
    $id_mutasi = $this->input->get('id_mutasi');

    $nilai = count($id);

    for ($i = 0; $i < $nilai; $i++) {
      $list_id = $id[$i];
      $this->db->trans_start();
      $this->db->query("UPDATE tb_mutasi_detail set status = '1' where id = '$list_id'");
      $this->db->query("UPDATE tb_mutasi set status = '1' where id = '$id_mutasi'");
      $this->db->trans_complete();
    }
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
    redirect(base_url('sup/Mutasi'));
  }

  // di tolak
  public function reject()
  {
    $id = $this->input->get('id_mutasi');
    $where = array('id' => $id);
    $data = array(
      'status' => '3',
    );
    $this->M_admin->update('tb_mutasi', $data, $where);
    tampil_alert('error', 'DITOLAK', 'Mutasi artikel telah ditolak!!');
    redirect(base_url('sup/Mutasi'));
  }
}
