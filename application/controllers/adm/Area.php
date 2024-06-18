<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Area extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('status') != 'login') {
      redirect(base_url());
    }
  }
  public function index()
  {
    $data['title'] = 'Area';
    $data['list'] = $this->db->query("SELECT ta.*, tu.nama_user as spv, COUNT(DISTINCT tad.id_toko) as t_toko from tb_area ta
    JOIN tb_user tu on ta.id_spv = tu.id
    LEFT JOIN tb_area_detail tad on ta.id = tad.id_area
    GROUP BY ta.id
    order by ta.id DESC")->result();
    $data['toko']  = $this->db->query("SELECT * from tb_toko WHERE status = 1 ")->result();
    $data['spv']  = $this->db->query("SELECT * from tb_user WHERE id NOT IN (SELECT id_spv FROM tb_area) AND  role = 2 AND status = 1 ")->result();
    $this->template->load('template/template', 'adm/area/index', $data);
  }
  public function detail($id)
  {
    $data['title'] = 'Area';
    $data['area'] = $this->db->query("SELECT ta.*, tu.nama_user as spv from tb_area ta
    LEFT JOIN tb_user tu on ta.id_spv = tu.id WHERE ta.id = '$id'
    order by ta.id DESC")->row();
    $data['detail'] = $this->db->query("SELECT tad.*, tt.nama_toko from tb_area_detail tad
    JOIN tb_toko tt on tad.id_toko = tt.id
    WHERE tad.id_area = '$id'
    order by tad.id DESC")->result();
    $data['toko']  = $this->db->query("SELECT * from tb_toko WHERE id NOT IN (SELECT id_toko FROM tb_area_detail WHERE id_area = '$id') AND status = 1 ")->result();
    $data['spv']  = $this->db->query("SELECT * from tb_user WHERE  role = 2 AND status = 1 ")->result();
    $this->template->load('template/template', 'adm/area/detail', $data);
  }
  public function update()
  {
    $id = $this->input->post('id');
    $area = $this->input->post('area');
    $spv = $this->input->post('spv');

    $this->db->trans_start();
    $data = array(
      'area' => $area,
      'id_spv' => $spv
    );
    $this->db->update('tb_area', $data, array('id' => $id));
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      tampil_alert('danger', 'GAGAL', 'Gagal menambahkan data Area');
    } else {
      tampil_alert('success', 'BERHASIL', 'Data Area berhasil ditambahkan');
    }
    redirect('adm/Area/detail/' . $id);
  }
  public function tambah()
  {
    $area = $this->input->post('area');
    $spv = $this->input->post('spv');
    $id_toko = $this->input->post('id_toko');
    $jml = count($id_toko);
    $this->db->trans_start();
    $data = array(
      'area' => $area,
      'id_spv' => $spv
    );
    $this->db->insert('tb_area', $data);
    $id_area = $this->db->insert_id();
    for ($x = 0; $x < $jml; $x++) {
      $detail = array(
        'id_toko' => $id_toko[$x],
        'id_area' => $id_area
      );
      $this->db->insert('tb_area_detail', $detail);
    }
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      tampil_alert('danger', 'GAGAL', 'Gagal menambahkan data Area');
    } else {
      tampil_alert('success', 'BERHASIL', 'Data Area berhasil ditambahkan');
    }
    redirect('adm/Area');
  }
  public function tambah_toko()
  {
    $id_area = $this->input->post('id_area');
    $id_toko = $this->input->post('id_toko');
    $jml = count($id_toko);
    $this->db->trans_start();
    for ($x = 0; $x < $jml; $x++) {
      $detail = array(
        'id_toko' => $id_toko[$x],
        'id_area' => $id_area
      );
      $this->db->insert('tb_area_detail', $detail);
    }
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      tampil_alert('danger', 'GAGAL', 'Gagal menambahkan data Area');
    } else {
      tampil_alert('success', 'BERHASIL', 'Data Area berhasil ditambahkan');
    }
    redirect('adm/Area/detail/' . $id_area);
  }

  public function hapus($id)
  {
    if (!is_numeric($id)) {
      tampil_alert('error', 'GAGAL', 'ID tidak valid.');
      redirect(base_url('adm/Area'));
      return;
    }
    $this->db->trans_start();
    $this->db->delete("tb_area", array("id" => $id));
    $this->db->delete("tb_area_detail", array("id_area" => $id));
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      tampil_alert('danger', 'GAGAL', 'Gagal Menghapus data Area');
    } else {
      tampil_alert('success', 'BERHASIL', 'Data Area berhasil dihapus');
    }
    redirect(base_url('adm/Area'));
  }
  public function hapus_toko($id, $id_area)
  {
    if (!is_numeric($id)) {
      tampil_alert('error', 'GAGAL', 'ID tidak valid.');
      redirect(base_url('adm/Area'));
      return;
    }
    $this->db->trans_start();
    $this->db->delete("tb_area_detail", array("id" => $id));
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      tampil_alert('danger', 'GAGAL', 'Gagal Menghapus toko dari Area ini');
    } else {
      tampil_alert('success', 'BERHASIL', 'Data toko berhasil dihapus dari area ini.');
    }
    redirect(base_url('adm/Area/detail/' . $id_area));
  }
}
