<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aset extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "7" && $role != "11" && $role != "1" && $role != "14" && $role != "15") {
      tampil_alert('error', 'DI TOLAK !', 'Silahkan login kembali');
      redirect(base_url(''));
    }
    $this->load->model('M_admin');
    $this->load->model('M_support');
  }
  public function index()
  {

    $data['title'] = 'Kelola Aset';
    $data['list_data'] = $this->db->query("SELECT * FROM tb_aset_master order by id desc")->result();
    $data['id_aset'] = $this->M_support->kode_aset();
    $this->template->load('template/template', 'hrd/aset/index', $data);
  }
  // detail aset
  public function get_detail()
  {
    $aset = $this->input->post('aset');
    $barang = $this->db->query("SELECT * from tb_aset_master where id = '$aset'")->row();

    if ($barang) {
      echo json_encode($barang);
    } else {
      echo json_encode(array('error' => 'Data barang tidak ditemukan'));
    }
  }
  public function proses_update()
  {
    $id = $this->input->post('id');
    $kode = $this->input->post('kode');
    $aset = $this->input->post('aset');
    $qty = $this->input->post('qty');
    $unit = $this->input->post('unit');
    $tanggal = date("Y-m-d H:i:s");
    $data = array(
      'kode' => $kode,
      'aset' => $aset,
      'qty' => $qty,
      'unit' => $unit,
      'updated_at' => $tanggal
    );
    $where = array('id' => $id);

    $this->db->trans_start();
    $cek = $this->db->query("SELECT * FROM tb_aset_master WHERE kode = '$kode' AND id != '$id'")->num_rows();
    if ($cek > 0) {
      tampil_alert('info', 'DUPLIKAT', 'Kode Aset sudah ada, Gunakan kode yang lain!');
      redirect('hrd/aset');
    } else {
      $this->db->update('tb_aset_master', $data, $where);
      $this->db->trans_complete();
      tampil_alert('success', 'Berhasil', 'Data Aset Berhasil di Update');
      redirect(base_url('hrd/aset'));
    }
  }
  function hapus()
  {
    $id = $this->uri->segment(4);
    $where = array('id' => $id);
    $data = array(
      'deleted_at' => date('Y-m-d H:i:s'),
    );
    $this->M_admin->update('tb_aset', $data, $where);
    tampil_alert('success', 'Berhasil', 'Data berhasil dihapus !');
    redirect(base_url('hrd/aset'));
  }
  // detail aset
  public function get_asetToko()
  {
    $aset = $this->input->post('aset');
    $barang = $this->db->query("SELECT tt.*, ta.aset,ta.kode,ta.unit from tb_aset_toko tt
    join tb_aset_master ta on tt.id_aset = ta.id where tt.id = '$aset'")->row();

    if ($barang) {
      echo json_encode($barang);
    } else {
      echo json_encode(array('error' => 'Data barang tidak ditemukan'));
    }
  }
  // update aset toko
  public function update_asetToko()
  {
    $id = $this->input->post('id');
    $qty = $this->input->post('qty');
    $update_at = date('Y-m-d h:i:s');
    $data = array(
      'qty' => $qty,
      'updated_at' => $update_at,
    );

    $where = array('id' => $id);
    $this->db->update('tb_aset_toko', $data, $where);

    tampil_alert('success', 'Berhasil', 'Data Aset toko Berhasil di Update');
    redirect($_SERVER['HTTP_REFERER']);
  }
  public function hapus_asetToko($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('tb_aset_toko');
    if ($this->db->affected_rows() > 0) {
      tampil_alert('success', 'Berhasil', 'Data berhasil dihapus !');
    } else {
      tampil_alert('error', 'GAGAL', 'Data gagal dihapus !');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
  // fungsi tambah aset
  public function proses_tambah()
  {
    $kode = $this->input->post('kode');
    $aset = $this->input->post('aset');
    $qty = $this->input->post('qty');
    $unit = $this->input->post('unit');
    $data = array(
      'kode' => $kode,
      'aset' => $aset,
      'qty' => $qty,
      'unit' => $unit
    );

    $cek = $this->db->query("SELECT * FROM tb_aset_master WHERE kode = '$kode'")->num_rows();
    if ($cek > 0) {
      tampil_alert('info', 'DUPLIKAT', 'Kode Aset sudah ada, Gunakan kode yang lain!');
      redirect('hrd/aset');
    } else {
      $this->db->trans_start();
      $this->db->insert('tb_aset_master', $data);
      $this->db->trans_complete();
      tampil_alert('success', 'Berhasil', 'Data Aset Berhasil di tambahkan');
      redirect(base_url('hrd/aset'));
    }
  }
  public function list_aset()
  {
    $data['title'] = 'Management Aset';
    $data['list_data'] = $this->db->query("SELECT tt.id as id_toko, tt.nama_toko, tt.alamat, COUNT(ta.id_aset) AS total_aset, tt.status_aset from tb_toko tt
    left join tb_aset_toko ta on tt.id = ta.id_toko
    where tt.status = 1 GROUP BY tt.nama_toko ")->result();
    $this->template->load('template/template', 'hrd/aset/list_aset.php', $data);
  }

  public function tambah_aset_toko()
  {
    $id_toko   = $this->input->post('id_toko');
    $id_aset = $this->input->post('id_aset');
    $qty = $this->input->post('qty');
    $no_aset = $this->input->post('no_aset');
    $no_urut = $this->input->post('no_urut');
    $data = array(
      'id_aset'  => $id_aset,
      'id_toko' => $id_toko,
      'qty' => $qty,
      'no_aset' => $no_aset,
      'no_urut' => $no_urut,
    );
    $this->db->insert('tb_aset_toko', $data);

    tampil_alert('success', 'Berhasil', 'Aset berhasil ditambahkan ketoko ');
    redirect('hrd/Aset/detail/' . $id_toko);
  }
  public function edit_aset_toko()
  {
    $this->form_validation->set_rules('id_aset', 'Id Aset', 'required');
    $this->form_validation->set_rules('qty', 'Jumlah Qty', 'required');
    if ($this->form_validation->run() == TRUE) {
      $id          = $this->input->post('id', TRUE);
      $id_toko     = $this->input->post('id_toko', TRUE);
      $qty         = $this->input->post('qty', TRUE);
      $update_at   = $this->input->post('updated', TRUE);
      $where = array('id' => $id);
      $data = array(
        'id'            => $id,
        'qty'           => $qty,
        'updated_at'    => $update_at,
      );
      $this->M_admin->update('tb_aset_toko', $data, $where);
      tampil_alert('success', 'Berhasil', 'Data berhasil diupdate !');
      redirect('hrd/aset/list_aset?id_toko=' . $id_toko);
    } else {
      tampil_alert('erorr', 'Gagal', 'Data Gagal diupdate !');
      redirect('hrd/aset/list_aset?id_toko=' . $id_toko);
    }
  }
  public function approve()
  {
    $id = $this->uri->segment(4);
    $where = array('id' => $id);
    $data = array(
      'status' => 1,
    );
    $this->M_admin->update('tb_aset', $data, $where);
    tampil_alert('success', 'Berhasil', 'Aset Sudah Aktif!');
    redirect(base_url('hrd/aset'));
  }
  public function detail($id)
  {
    $data['title'] = 'Management Aset';
    $data['toko'] = $this->db->query("SELECT tt.*, tu.nama_user as spv, tuu.nama_user as leader, ts.nama_user as spg FROM tb_toko tt
    join tb_user tu on tt.id_spv = tu.id
    join tb_user tuu on tt.id_leader = tuu.id
    join tb_user ts on tt.id_spg = ts.id
    WHERE tt.id ='$id'")->row();
    $data['list'] = $this->db->query("SELECT ts.*, ta.aset, ta.kode,ta.unit from tb_aset_toko ts
    join tb_aset_master ta on ts.id_aset = ta.id
    where ts.id_toko = '$id' ")->result();
    $bulan = date("m");
    $data['aset_spg'] = $this->db->query("SELECT ts.*, tat.no_aset, tam.aset from tb_aset_spg ts
    join tb_aset_toko tat on ts.id_aset = tat.id
    join tb_aset_master tam on tat.id_aset = tam.id
    where ts.id_toko = '$id' and month(ts.tanggal) = '$bulan' ")->result();
    $data['aset'] = $this->db->query("SELECT * from tb_aset_master order by id asc")->result();
    $this->template->load('template/template', 'hrd/aset/detail', $data);
  }
  public function getLatestAsetNumber()
  {
    $id_aset = $this->input->post('id_aset');
    $aset = $this->db->query("SELECT kode,unit from tb_aset_master where id = '$id_aset'");
    $kode = $aset->row()->kode;
    $unit = $aset->row()->unit;
    $query = $this->db->query("SELECT MAX(no_urut) as max_no_urut FROM tb_aset_toko WHERE id_aset = ?", array($id_aset));
    $result = $query->row_array();
    $latestAsetNumber = intval($result['max_no_urut']);

    if ($latestAsetNumber === null) {
      $latestAsetNumber = 1;
    } else {
      $latestAsetNumber++;
    }
    $response = array('nomor_urut' => $latestAsetNumber, 'kode_aset' => $kode, 'unit' => $unit);
    echo json_encode($response);
  }
}
