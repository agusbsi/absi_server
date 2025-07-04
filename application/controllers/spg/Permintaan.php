
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "4") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url());
      exit();
    }

    $this->load->model('M_spg');
    $this->load->model('M_produk');
  }


  public function index()
  {
    $id_toko = $this->session->userdata('id_toko');
    $data['title'] = 'Permintaan Barang';
    $data['list_permintaan'] = $this->db->query("SELECT * from tb_permintaan where id_toko = '$id_toko' order by id Desc limit 500")->result();
    $this->template->load('template/template', 'spg/permintaan/index', $data);
  }

  public function detail($id)
  {
    $data['title'] = 'Permintaan Barang';
    $data['po'] = $this->db->query("SELECT * from tb_permintaan where id = '$id'")->row();
    $data['detail'] = $this->db->query("SELECT tpd.*, tp.kode, tp.nama_produk as artikel from tb_permintaan_detail tpd join tb_produk tp on tp.id = tpd.id_produk where tpd.id_permintaan = '$id'")->result();
    $data['histori'] = $this->db->query("SELECT * from tb_po_histori tpo
    join tb_permintaan tp on tpo.id_po = tp.id where tpo.id_po = '$id'")->result();

    $this->template->load('template/template', 'spg/permintaan/detail', $data);
  }

  public function tampilkan_detail_produk()
  {
    $id = $this->input->post('id');
    $toko = $this->input->post('toko');
    $data_produk = $this->db->query("SELECT tb_produk.*, tb_stok.qty
        FROM tb_produk
        LEFT JOIN tb_stok ON tb_produk.id = tb_stok.id_produk AND tb_stok.id_toko = '$toko'
        WHERE tb_stok.id_toko = '$toko' AND tb_stok.id_produk = '$id'
        GROUP BY tb_produk.id")->row();
    echo json_encode($data_produk);
  }
  public function tambah_permintaan()
  {
    if ($this->session->userdata('cart') != "Permintaan") {
      $this->cart->destroy();
    }
    $data['title'] = 'Permintaan Barang';
    $data['no_permintaan'] = $this->M_spg->invoice(); // generate no permintaan
    $id_toko = $this->session->userdata('id_toko');
    $data['toko_new'] = $this->db->query("SELECT tt.*, SUM(qty_awal) as stok_akhir from tb_toko tt
    join tb_stok ts on tt.id = ts.id_toko
    where tt.id = '$id_toko'")->row();
    $data['data_cart'] = $this->cart->contents(); // menampilkan data cart
    $data['list_produk'] = $this->db->query("SELECT tp.id,tp.kode, tp.nama_produk as artikel from tb_stok ts
    join tb_produk tp on ts.id_produk = tp.id
    where ts.id_toko = '$id_toko' and tp.status = 1")->result();
    $data['max_po'] = $this->db->query("SELECT SUM(qty) as total 
    FROM tb_penjualan_detail tpd
    JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
    WHERE tp.id_toko = '$id_toko' 
    AND tp.tanggal_penjualan BETWEEN DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01') 
    AND LAST_DAY(CURDATE() - INTERVAL 1 MONTH)")->row();
    $data['po'] = $this->db->query("SELECT SUM(qty) as total 
    FROM tb_permintaan_detail tpd
    JOIN tb_permintaan tp ON tpd.id_permintaan = tp.id
    WHERE tp.id_toko = '$id_toko' 
    AND tp.status != 5
    AND tp.created_at BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') 
    AND LAST_DAY(CURDATE())")->row();
    $data['jual'] = $this->db->query("SELECT SUM(qty) as total 
     FROM tb_penjualan_detail tpd
     JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
     WHERE tp.id_toko = '$id_toko' 
     AND tp.tanggal_penjualan BETWEEN DATE_FORMAT(CURDATE() - INTERVAL 2 MONTH, '%Y-%m-01') 
     AND LAST_DAY(CURDATE() - INTERVAL 2 MONTH)")->row();

    $this->template->load('template/template', 'spg/permintaan/tambah_permintaan', $data);
  }

  public function tambah_cart()
  {
    $id = $this->input->post('id');
    $qty = $this->input->post('qty');
    $keterangan = $this->input->post('keterangan');
    $produk = $this->M_produk->get_by_id($id);
    $data = array(
      'id'      => $id,
      'qty'     => $qty,
      'price'   => "",
      'name'    => $produk->id,
      'options' => $produk->kode,
      'satuan'  => $keterangan
    );
    $this->cart->insert($data);
    $this->session->set_userdata('cart', 'Permintaan');
    redirect(base_url('spg/permintaan/tambah_permintaan'));
  }

  public function hapus_cart($id)
  {
    $this->cart->remove($id);

    redirect(base_url('spg/permintaan/tambah_permintaan'));
  }

  public function reset_cart()
  {
    $this->cart->destroy();

    redirect(base_url('spg/tambah_permintaan'));
  }

  public function kirim_permintaan()
  {
    $pt = $this->session->userdata('pt');
    $id_user = $this->session->userdata('id');
    $id_toko = $this->session->userdata('id_toko');
    $id_permintaan = $this->M_spg->invoice();
    $data = array(
      'id' => $id_permintaan,
      'id_toko' => $id_toko,
      'id_user' => $id_user,
    );

    // Ambil data SPG, toko, dan leader dari database
    $spg_query = $this->db->query("SELECT nama_user FROM tb_user WHERE id = '$id_user'");
    $spg_row = $spg_query->row();
    $spg = $spg_row ? $spg_row->nama_user : 'Tanpa Nama';

    $this->db->trans_start();
    $this->db->insert('tb_permintaan', $data);

    $data_cart = $this->cart->contents();
    foreach ($data_cart as $d) {
      // Ambil stok produk di tb_stok berdasarkan id_produk dan id_toko
      $stok_query = $this->db->select('qty')
        ->where('id_produk', $d['id'])
        ->where('id_toko', $id_toko)
        ->get('tb_stok')
        ->row();

      $stok = $stok_query ? $stok_query->qty : 0; // Jika stok tidak ditemukan, default 0

      $data_detail = array(
        'id_permintaan' => $id_permintaan,
        'id_produk' => $d['id'],
        'qty' => $d['qty'],
        'stok' => $stok,
        'keterangan' => $d['satuan'],
      );

      $this->db->insert('tb_permintaan_detail', $data_detail);
    }

    $histori = array(
      'id_po' => $id_permintaan,
      'aksi' => 'Dibuat oleh : ',
      'pembuat' => $spg,
    );
    $this->db->insert('tb_po_histori', $histori);
    $this->db->trans_complete();
    $this->cart->destroy();

    $toko_query = $this->db->query("SELECT id_leader, nama_toko FROM tb_toko WHERE id = '$id_toko'")->row();
    $leader = $toko_query ? $toko_query->id_leader : null;
    $namaToko = $toko_query ? $toko_query->nama_toko : 'Tanpa Nama';

    if ($leader) {
      // Ambil nomor telepon dari tabel tb_user
      $phones = $this->db->select('no_telp')
        ->where('id', $leader)
        ->get('tb_user')
        ->result_array();

      // Jika ada nomor telepon, kirim pesan
      if (!empty($phones)) {
        $message = "$spg : Mengajukan PO Barang ($id_permintaan) untuk toko: $namaToko - $pt yang perlu approve, silahkan kunjungi s.id/absi-app";

        foreach ($phones as $phone) {
          if (isset($phone['no_telp'])) {
            $number = $phone['no_telp'];
            // Ubah nomor telepon jika dimulai dengan '0'
            if (substr($number, 0, 1) == '0') {
              $number = '62' . substr($number, 1);
            }
            // Kirim pesan
            kirim_wa($number, $message);
          }
        }
      }
    }

    // Tampilkan alert sukses jika data berhasil disimpan
    tampil_alert('success', 'Berhasil', 'Data berhasil disimpan !');
    redirect(base_url('spg/Permintaan'));
  }
}
?>
