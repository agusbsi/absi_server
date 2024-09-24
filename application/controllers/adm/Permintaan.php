<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
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
    $data['title'] = 'Permintaan Barang';
    $this->template->load('template/template', 'adm/transaksi/permintaan.php', $data);
  }
  public function get_po()
  {
    $search_nomor = $this->input->post('search_nomor');
    $search_nama_toko = $this->input->post('search_nama_toko');
    $search_status = $this->input->post('search_status');
    $search_periode = $this->input->post('search_periode');
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $this->db->select('tp.*, tt.nama_toko');
    $this->db->from('tb_permintaan tp');
    $this->db->join('tb_toko tt', 'tp.id_toko = tt.id');
    if (!empty($search_periode)) {
      list($start_date, $end_date) = explode(' - ', $search_periode);
      $this->db->where('tp.created_at >=', $start_date . ' 00:00:00');
      $this->db->where('tp.created_at <=', $end_date . ' 23:59:59');
    }
    if (!empty($search_nomor)) {
      $this->db->like('tp.id', $search_nomor);
    }
    if (!empty($search_status)) {
      $this->db->like('tp.status', $search_status);
    }
    if (!empty($search_nama_toko)) {
      $this->db->like('tt.nama_toko', $search_nama_toko);
    }
    $this->db->order_by('tp.created_at', 'desc');
    $query_total = clone $this->db;
    $total_data = $query_total->count_all_results('', FALSE);
    $this->db->limit($limit, $start);
    $query = $this->db->get();
    $data = $query->result();
    $output_data = array();
    $no = $start + 1;
    foreach ($data as $stok) {
      $row = array();
      $row['nomor_urut'] = $no++;
      $row['nomor'] = $stok->id;
      $row['nama_toko'] = $stok->nama_toko;
      ob_start();
      status_permintaan($stok->status);
      $row['status'] = ob_get_clean();
      $row['tgl_dibuat'] = date('d-M-Y H:i:s', strtotime($stok->created_at));
      $row['menu'] = $stok->id;
      $output_data[] = $row;
    }
    $this->db->select('tp.*, tt.nama_toko');
    $this->db->from('tb_permintaan tp');
    $this->db->join('tb_toko tt', 'tp.id_toko = tt.id');

    if (!empty($search_periode)) {
      list($start_date, $end_date) = explode(' - ', $search_periode);
      $this->db->where('tp.created_at >=', $start_date . ' 00:00:00');
      $this->db->where('tp.created_at <=', $end_date . ' 23:59:59');
    }

    if (!empty($search_nomor)) {
      $this->db->like('tp.id', $search_nomor);
    }
    if (!empty($search_status)) {
      $this->db->like('tp.status', $search_status);
    }

    if (!empty($search_nama_toko)) {
      $this->db->like('tt.nama_toko', $search_nama_toko);
    }

    $total_filtered = $this->db->count_all_results();
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $total_data,
      "recordsFiltered" => $total_filtered,
      "data" => $output_data
    );
    echo json_encode($output);
  }
  public function detail($id)
  {
    $data['title'] = 'Permintaan Barang';
    $data['permintaan'] = $this->db->query("SELECT tp.*, tt.nama_toko,tt.alamat, tu.username as spg from tb_permintaan tp join tb_toko tt on tt.id = tp.id_toko join tb_user tu on tu.id = tp.id_user where tp.id = '$id'")->row();
    $data['detail'] = $this->db->query("SELECT * from tb_permintaan_detail tpd join tb_produk tp on tp.id = tpd.id_produk where tpd.id_permintaan = '$id'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_po_histori where id_po = '$id'")->result();
    $this->template->load('template/template', 'adm/transaksi/permintaan_detail', $data);
  }
}
