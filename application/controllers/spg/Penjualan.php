<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
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
  public function index()
  {
    $id_toko = $this->session->userdata('id_toko');
    $data['title'] = 'Penjualan';
    $data['list_penjualan'] = $this->db->query("SELECT * from tb_penjualan where id_toko = '$id_toko' order by id desc ")->result();
    $this->template->load('template/template', 'spg/penjualan/index', $data);
  }
  public function cari()
  {
    $keyword = $this->input->post('query');
    $id_toko = $this->session->userdata('id_toko');
    $query = $this->db->query("
          SELECT tp.*, ts.qty as stok 
          FROM tb_stok ts
          JOIN tb_produk tp ON ts.id_produk = tp.id
          WHERE ts.id_toko = '$id_toko' AND ts.status = 1 AND tp.status = 1 
          AND (tp.kode LIKE '%$keyword%' OR tp.nama_produk LIKE '%$keyword%')
      ");
    $output = '<ul class="list-group">';
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $output .= '<li class="list-group-item" data-kode="' . $row->id . '" title="pilih"> <small><strong>' . $row->kode . '</strong> ' . $row->nama_produk . '<br><b>Stok : </b>' . $row->stok . '</small></li>';
      }
    } else {
      $output .= '<li class="list-group-item">Artikel tidak ditemukan</li>';
    }
    $output .= '</ul>';
    echo $output;
  }
  public function pilih_list()
  {
    $id_toko = $this->session->userdata('id_toko');
    $kode = $this->input->post('kode');
    $query = $this->db->query("
          SELECT tp.*, ts.qty as stok 
          FROM tb_stok ts
          JOIN tb_produk tp ON ts.id_produk = tp.id
          WHERE tp.id = '$kode' AND ts.id_toko = '$id_toko'
      ");

    if ($query->num_rows() > 0) {
      $row = $query->row();
      $output = array(
        'success' => true,
        'id_produk' => $row->id,
        'kode' => $row->kode,
        'nama_produk' => $row->nama_produk,
        'stok' => $row->stok,
        'satuan' => $row->satuan
      );
    } else {
      $output = array('success' => false);
    }

    echo json_encode($output);
  }
  public function detail($id)
  {
    $data['title'] = 'Penjualan';
    $data['jual'] = $this->db->query("SELECT * from tb_penjualan where id = '$id'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tp.kode, tp.nama_produk from tb_penjualan_detail tpd
    join tb_produk tp on tp.id = tpd.id_produk where tpd.id_penjualan = '$id'")->result();
    $this->template->load('template/template', 'spg/penjualan/detail', $data);
  }
  public function tambah_penjualan()
  {
    $data['title'] = 'Penjualan';
    $id_toko = $this->session->userdata('id_toko');
    $data['toko'] = $this->db->query("SELECT * from tb_toko where id = '$id_toko'")->row();
    $this->template->load('template/template', 'spg/penjualan/tambah_penjualan', $data);
  }
  public function simpan()
  {
    $id_user = $this->session->userdata('id');
    $username = $this->session->userdata('username');
    $id_toko = $this->session->userdata('id_toko');
    $tgl_jual = $this->input->post('tgl_jual');
    $unique_id = $this->input->post('unique_id');
    $id_produk = $this->input->post('idProduk');
    $stok = $this->input->post('stokProduk');
    $qty = $this->input->post('qtyProduk');
    $id_penjualan = $this->M_spg->kode_penjualan();
    $jml = count($id_produk);

    if ($this->db->get_where('tb_penjualan', array('id_unik' => $unique_id))->num_rows() > 0) {
      tampil_alert('info', 'INTERNET ANDA LEMOT', 'Data penjualan tetap akan di simpan.');
      redirect(base_url('spg/Penjualan'));
      return;
    }
    $this->db->trans_start();
    $data = array(
      'id' => $id_penjualan,
      'id_toko' => $id_toko,
      'id_user' => $id_user,
      'tanggal_penjualan' => $tgl_jual,
      'id_unik' => $unique_id
    );
    $this->db->insert('tb_penjualan', $data);
    $query1 = $this->db->get_where('tb_toko', array('id' => $id_toko))->row();
    $kategori = $query1->het;
    $diskon_toko = $query1->diskon;
    for ($i = 0; $i < $jml; $i++) {
      $id_produk_real = $id_produk[$i];
      $query2 = $this->db->get_where('tb_produk', array('id' => $id_produk_real))->row();
      switch ($kategori) {
        case 1:
          $harga = $query2->harga_jawa;
          break;
        case 2:
          $harga = $query2->harga_indobarat;
          break;
        case 3:
          $harga = $query2->sp;
          break;
        default:
          $harga = 0;
          break;
      }
      $stok_real = $stok[$i];
      $qty_real = $qty[$i];
      $data_detail = array(
        'id_penjualan' => $id_penjualan,
        'id_produk' => $id_produk_real,
        'harga' => $harga,
        'diskon_toko' => $diskon_toko,
        'qty' => $qty_real,
      );
      $this->db->insert('tb_penjualan_detail', $data_detail);
      $kartu = array(
        'no_doc' => $id_penjualan,
        'id_produk' => $id_produk_real,
        'id_toko' => $id_toko,
        'keluar' => $qty_real,
        'stok' => $stok_real,
        'sisa' => $stok_real - $qty_real,
        'keterangan' => 'Penjualan',
        'pembuat' => $username
      );
      $this->db->insert('tb_kartu_stok', $kartu);

      // Update stock
      $this->db->set('qty', 'qty - ' . (int)$qty_real, FALSE);
      $this->db->set('updated_at', 'NOW()', FALSE);
      $this->db->where('id_toko', $id_toko);
      $this->db->where('id_produk', $id_produk_real);
      $this->db->update('tb_stok');
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      tampil_alert('error', 'Gagal', 'Terjadi kesalahan saat menyimpan data.');
    } else {
      $this->cart->destroy();
      tampil_alert('success', 'Berhasil', 'Data berhasil disimpan!');
    }

    redirect(base_url('spg/Penjualan/detail/' . $id_penjualan));
  }
  // hapus penjualan
  public function hapus_data($id)
  {
    $username = $this->session->userdata('username');
    $toko = $this->db->query("SELECT id_toko from tb_penjualan where id = '$id'")->row()->id_toko;
    $detail = $this->db->query("SELECT id_produk, qty from tb_penjualan_detail where id_penjualan = '$id'")->result();

    $this->db->trans_start();
    foreach ($detail as $d) {
      $currentStock = $this->db->select('qty')->where(['id_produk' => $d->id_produk, 'id_toko' => $toko])->get('tb_stok')->row()->qty;
      $newStock = $currentStock + $d->qty;
      $this->db->where(['id_produk' => $d->id_produk, 'id_toko' => $toko])->update('tb_stok', ['qty' => $newStock]);
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
    redirect(base_url('spg/penjualan'));
  }
}
