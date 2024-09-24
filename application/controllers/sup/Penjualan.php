<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "6" && $role != 1 && $role != 14 && $role != 10 && $role != "8") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }

  public function index()
  {
    $data['title'] = 'Transaksi Penjualan';
    $this->template->load('template/template', 'manager_mv/penjualan/index', $data);
  }
  public function get_jual()
  {
    $role = $this->session->userdata('role');
    $search_nomor = $this->input->post('search_nomor');
    $search_nama_toko = $this->input->post('search_nama_toko');
    $search_status = $this->input->post('search_status');
    $search_periode = $this->input->post('search_periode');
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $this->db->select('tp.*, tt.nama_toko');
    $this->db->from('tb_penjualan tp');
    $this->db->join('tb_toko tt', 'tp.id_toko = tt.id');
    if (!empty($search_periode)) {
      list($start_date, $end_date) = explode(' - ', $search_periode);
      $this->db->where('tp.tanggal_penjualan >=', $start_date . ' 00:00:00');
      $this->db->where('tp.tanggal_penjualan <=', $end_date . ' 23:59:59');
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
      $row['tgl_jual'] = date('d-M-Y', strtotime($stok->tanggal_penjualan));
      $row['tgl_dibuat'] = date('d-M-Y H:i:s', strtotime($stok->created_at));
      $row['menu'] = [
        'id' => $stok->id,
        'toko' => $stok->nama_toko,
        'tgl' => date('Y-m-d', strtotime($stok->tanggal_penjualan)),
        'role' => $role
      ];
      $output_data[] = $row;
    }
    $this->db->select('tp.*, tt.nama_toko');
    $this->db->from('tb_penjualan tp');
    $this->db->join('tb_toko tt', 'tp.id_toko = tt.id');

    if (!empty($search_periode)) {
      list($start_date, $end_date) = explode(' - ', $search_periode);
      $this->db->where('tp.tanggal_penjualan >=', $start_date . ' 00:00:00');
      $this->db->where('tp.tanggal_penjualan <=', $end_date . ' 23:59:59');
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
    $data['title'] = 'Transaksi Penjualan';
    $data['jual'] = $this->db->query("SELECT tp.*, tt.nama_toko from tb_penjualan tp 
    join tb_toko tt on tp.id_toko = tt.id
    where tp.id = '$id'")->row();
    $data['list_data'] = $this->db->query("SELECT tpd.*, tpk.kode, tpk.nama_produk from tb_penjualan_detail tpd
    join tb_penjualan tp on tpd.id_penjualan = tp.id
    join tb_produk tpk on tpd.id_produk = tpk.id
    where tpd.id_penjualan = '$id'")->result();
    $this->template->load('template/template', 'manager_mv/penjualan/detail', $data);
  }
  // update penjualan
  public function update_jual()
  {
    $id_jual     = $this->input->post('id_jual');
    $tanggal     = $this->input->post('tanggal_edit');
    $this->db->update('tb_penjualan', array('tanggal_penjualan' => $tanggal), array('id' => $id_jual));
    tampil_alert('success', 'BERHASIL', 'Data penjualan berhasil di perbaharui.');
    redirect(base_url('sup/penjualan'));
  }
  // hapus penjualan
  public function hapus_data($id)
  {
    $username = $this->session->userdata('username');
    // Ambil data detail penjualan
    $toko = $this->db->query("SELECT id_toko from tb_penjualan where id = '$id'")->row()->id_toko;
    $detail = $this->db->query("SELECT id_produk, qty from tb_penjualan_detail where id_penjualan = '$id'")->result();

    $this->db->trans_start();
    foreach ($detail as $d) {
      // Ambil stok saat ini
      $currentStock = $this->db->select('qty')->where(['id_produk' => $d->id_produk, 'id_toko' => $toko])->get('tb_stok')->row()->qty;
      // Hitung stok yang baru
      $newStock = $currentStock + $d->qty;
      // Update stok
      $this->db->where(['id_produk' => $d->id_produk, 'id_toko' => $toko])->update('tb_stok', ['qty' => $newStock]);
      // Insert into tb_kartu_stok
      $kartu = array(
        'no_doc' => $id,
        'id_produk' => $d->id_produk,
        'id_toko' => $toko,
        'masuk' => $d->qty,
        'stok' => $currentStock,
        'sisa' => $currentStock + $d->qty,
        'keterangan' => 'Cancel Penjualan',
        'pembuat' => $username
      );
      $this->db->insert('tb_kartu_stok', $kartu);
    }

    $this->db->delete('tb_penjualan', array('id' => $id));
    $this->db->delete('tb_penjualan_detail', array('id_penjualan' => $id));

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      tampil_alert('error', 'GAGAL', 'Gagal menghapus data penjualan ' . $id);
    } else {
      $this->db->trans_commit();
      tampil_alert('success', 'DI HAPUS', 'Data Penjualan ' . $id . ' berhasil dihapus');
    }

    redirect(base_url('sup/penjualan'));
  }
}
