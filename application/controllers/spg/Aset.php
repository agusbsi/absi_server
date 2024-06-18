<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aset extends CI_Controller
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
  }

  // tampil data Aset
  public function index()
  {
    $id_toko = $this->session->userdata('id_toko');
    $data['title'] = 'Aset';
    $data['toko']  = $this->db->query("SELECT * from tb_toko where id = '$id_toko' ")->row();
    $data['list_aset']  = $this->db->query("SELECT tat.*, ta.aset from tb_aset_toko tat
    join tb_aset_master ta on tat.id_aset = ta.id where tat.id_toko = '$id_toko'")->result();
    $this->template->load('template/template', 'spg/aset/lihat_data', $data);
  }
  public function updateFotoAset()
  {
    $toko = $this->session->userdata('id_toko');
    date_default_timezone_set('Asia/Jakarta');
    $updated = date('Y-m-d H:i:s');
    $this->db->trans_start();
    $config['upload_path'] = './assets/img/aset/toko/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['overwrite'] = true;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    foreach ($_POST['id_aset_toko'] as $key => $id_aset_toko) {
      $keterangan = $_POST['keterangan'][$key];
      $jumlah = $_POST['jumlah'][$key];
      $file_name = "aset_{$id_aset_toko}_" . date('Y');
      $_FILES['foto_aset_single']['name'] = $_FILES['foto_aset']['name'][$key];
      $_FILES['foto_aset_single']['type'] = $_FILES['foto_aset']['type'][$key];
      $_FILES['foto_aset_single']['tmp_name'] = $_FILES['foto_aset']['tmp_name'][$key];
      $_FILES['foto_aset_single']['error'] = $_FILES['foto_aset']['error'][$key];
      $_FILES['foto_aset_single']['size'] = $_FILES['foto_aset']['size'][$key];
      $old_file_name = $this->db->get_where('tb_aset_toko', ['id' => $id_aset_toko])->row()->foto_aset;
      if (!empty($old_file_name)) {
        $old_file_path = $config['upload_path'] . $old_file_name;
        if (file_exists($old_file_path)) {
          unlink($old_file_path); // Hapus file lama dari sistem
        }
      }

      if ($this->upload->do_upload('foto_aset_single')) {
        $upload_data = $this->upload->data();
        $file_extension = pathinfo($upload_data['file_name'], PATHINFO_EXTENSION);
        $new_file_name = "{$file_name}.{$file_extension}";
        $new_file_path = $config['upload_path'] . $new_file_name;
        rename($upload_data['full_path'], $new_file_path);
        $this->db->insert('tb_aset_spg', [
          'id_aset' => $id_aset_toko,
          'id_toko' => $toko,
          'qty' => $jumlah,
          'keterangan' => $keterangan,
          'gambar' => $new_file_name,
          'tanggal' => $updated
        ]);
      } else {
        $hasil =  $this->upload->display_errors();
        tampil_alert('error', 'GAGAL', $hasil);
        redirect('spg/Aset');
      }
    }
    $this->db->where('id', $toko);
    $this->db->update('tb_toko', array('status_aset' => '1'));
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      tampil_alert('error', 'Gagal', 'Terjadi kesalahan saat memproses data, coba lagi dengan jaringan yang bagus.');
    } else {
      $this->db->trans_commit();
      tampil_alert('success', 'Berhasil', 'Data Aset berhasil diupdate');
    }
    redirect('spg/Aset');
  }
  public function update()
  {
    $toko = $this->session->userdata('id_toko');
    $this->db->where('id', $toko);
    $this->db->update('tb_toko', array('status_aset' => '1'));
    tampil_alert('success', 'Berhasil', 'Data Aset berhasil disimpan!');
    redirect('spg/Aset');
  }
}
