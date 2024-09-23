<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Stok extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('status') != 'login') {
      redirect(base_url());
    }
  }

  //   halaman utama
  public function index()
  {
    $data['title'] = 'Stok Artikel';
    $query = "SELECT tp.*, COALESCE(SUM(ts.qty), 0) as stok
          FROM tb_produk tp
          LEFT JOIN tb_stok ts ON tp.id = ts.id_produk
          JOIN tb_toko tt on ts.id_toko = tt.id
          WHERE tp.status = 1 AND tt.status = 1
          GROUP BY tp.id
          ORDER BY tp.kode ASC";
    $data['list_data'] = $this->db->query($query)->result();
    $data['artikel'] = $this->db->query("SELECT count(id) as total from tb_produk where status = 1 ")->row();
    $data['stok'] = $this->db->query("SELECT sum(ts.qty) as total FROM tb_stok ts
    JOIN tb_toko tt on ts.id_toko = tt.id where ts.status = 1 AND tt.status = 1 ")->row();
    $this->template->load('template/template', 'adm/stok/index', $data);
  }
  public function detail($id)
  {
    $data['title'] = 'Stok Artikel';
    $query = "SELECT ts.*,tt.nama_toko, tp.nama_produk, tp.kode
          FROM tb_stok ts
          JOIN tb_toko tt ON ts.id_toko = tt.id
          join tb_produk tp on ts.id_produk = tp.id
          where ts.id_produk = '$id' AND ts.status = 1 AND tt.status = 1
          ORDER BY ts.qty DESC";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'adm/stok/detail', $data);
  }
  public function s_customer()
  {
    $data['title'] = 'Stok Customer';
    $thn = date('Y');
    $bln = (new DateTime('first day of -2 month'))->format('m');
    $query = "SELECT 
        tc.id,
        tc.nama_cust,
        tc.alamat_cust,
        (SELECT COUNT(id) FROM tb_toko tt WHERE tt.id_customer = tc.id AND tt.status = 1) AS t_toko,
        (SELECT COALESCE(SUM(ts.qty), 0) FROM tb_stok ts JOIN tb_toko tt ON ts.id_toko = tt.id WHERE tt.id_customer = tc.id AND tt.status = 1) AS t_stok,
        (SELECT COALESCE(SUM(ts.qty_awal), 0) FROM tb_stok ts JOIN tb_toko tt ON ts.id_toko = tt.id WHERE tt.id_customer = tc.id AND tt.status = 1) AS t_akhir,
        (SELECT COALESCE(SUM(ts.jml_jual), 0) FROM vw_penjualan ts JOIN tb_toko tt ON ts.id_toko = tt.id WHERE tt.id_customer = tc.id AND tt.status = 1 AND ts.tahun = '$thn' AND ts.bulan = '$bln' ) AS t_jual

    FROM 
        tb_customer tc
    ORDER BY 
        tc.nama_cust ASC";
    $data['list_data'] = $this->db->query($query)->result();
    $data['cust'] = $this->db->query("SELECT count(id) as total from tb_customer")->row();
    $data['stok'] = $this->db->query("SELECT SUM(ts.qty) as total, SUM(ts.qty_awal) as stok_akhir from tb_stok ts
    JOIN tb_toko tt on ts.id_toko = tt.id where ts.status = 1 AND tt.status = 1 ")->row();
    $data['jual'] = $this->db->query("SELECT SUM(jml_jual) as total from vw_penjualan where tahun = '$thn' AND bulan = '$bln' ")->row();
    $this->template->load('template/template', 'adm/stok/customer', $data);
  }
  public function detail_toko($id)
  {
    $data['title'] = 'Stok Customer';
    $thn = date('Y');
    $bln = (new DateTime('first day of -2 month'))->format('m');

    $query = "
      SELECT 
          tc.nama_cust, 
          tt.nama_toko, 
          COALESCE(SUM(ts.qty), 0) AS t_stok,
          (SELECT COALESCE(SUM(ts.qty_awal), 0) FROM tb_stok ts WHERE ts.id_toko = tt.id) AS t_akhir,
          (SELECT COALESCE(SUM(ts.jml_jual), 0) FROM vw_penjualan ts WHERE ts.id_toko = tt.id AND ts.tahun = '$thn' AND ts.bulan = '$bln') AS t_jual
      FROM 
          tb_customer tc
      JOIN 
          tb_toko tt ON tc.id = tt.id_customer
      LEFT JOIN 
          tb_stok ts ON tt.id = ts.id_toko
      WHERE 
          tc.id = '$id' AND tt.status = 1 
      GROUP BY 
          tt.id 
      ORDER BY 
          SUM(ts.qty) DESC
      ";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'adm/stok/detail_toko', $data);
  }

  public function detail_artikel($id)
  {
    $data['title'] = 'Stok Customer';
    $query = "SELECT tc.nama_cust, tp.kode,tp.nama_produk as artikel, COALESCE(SUM(ts.qty), 0) AS t_stok FROM tb_customer tc
    JOIN tb_toko tt on tc.id = tt.id_customer
    LEFT JOIN tb_stok ts on tt.id = ts.id_toko
    JOIN tb_produk tp on ts.id_produk = tp.id
    WHERE tc.id = '$id' AND tt.status = 1 GROUP BY tp.id ORDER BY SUM(ts.qty) DESC";

    $data['data'] = $this->db->query($query)->row();
    $data['list_data'] = $this->db->query($query)->result();
    $this->template->load('template/template', 'adm/stok/detail_artikel', $data);
  }

  // Kartu Stok
  public function kartu_stok()
  {
    $data['title'] = 'Kartu Stok';
    $data['toko'] = $this->db->query("SELECT * from tb_toko where status = 1")->result();
    $data['artikel'] = $this->db->query("SELECT * from tb_produk where status = 1")->result();
    $this->template->load('template/template', 'adm/stok/kartu_stok', $data);
  }
  public function cari_kartu()
  {
    $id_toko = $this->input->get('id_toko');
    $id_artikel = $this->input->get('id_artikel');
    $tgl_awal = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');

    // Ensure the inputs are properly sanitized and validated
    $id_toko = intval($id_toko);
    $id_artikel = intval($id_artikel);
    $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
    $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
    log_message('debug', 'tgl_awal: ' . $tgl_awal);
    $toko = $this->db->query("SELECT * FROM tb_toko WHERE id = ?", array($id_toko))->row();
    $artikel = $this->db->query("SELECT * FROM tb_produk WHERE id = ?", array($id_artikel))->row();
    $tabel_data = $this->db->query(
      "SELECT *, COALESCE(masuk, '-') as masuk, 
        COALESCE(keluar, '-') as keluar  FROM tb_kartu_stok 
                                      WHERE id_toko = ? AND id_produk = ? AND DATE(tanggal) BETWEEN ? AND ?",
      array($id_toko, $id_artikel, $tgl_awal, $tgl_akhir)
    )->result();
    // Determine s_awal and s_akhir
    $s_awal = !empty($tabel_data) ? $tabel_data[0]->stok : 0;
    $s_akhir = !empty($tabel_data) ? end($tabel_data)->sisa : 0;

    // Ensure we handle cases where there might be no data
    $data = [
      'toko' => isset($toko->nama_toko) ? $toko->nama_toko : 'Unknown',
      'artikel' => isset($artikel->nama_produk) ? $artikel->nama_produk : 'Unknown',
      'awal' => date('d-M-Y', strtotime($tgl_awal)),
      'akhir' => date('d-M-Y', strtotime($tgl_akhir)),
      'tabel_data' => $tabel_data,
      's_awal' => $s_awal,
      's_akhir' => $s_akhir,
    ];

    echo json_encode($data);
  }
  public function adjust_stok()
  {
    $data['title'] = 'Adjustment Stok';
    $this->template->load('template/template', 'adm/stok/adjust_tampil', $data);
  }
  public function get_adjust_stok()
  {
    $request = $this->input->post(null, true);
    $column_order = ['tas.id', 'tas.nomor', 'tt.nama_toko', 'tas.status', 'tas.created_at'];
    $search_value = $request['search']['value'] ?? '';
    $start = filter_var($request['start'], FILTER_VALIDATE_INT) ?: 0;
    $length = filter_var($request['length'], FILTER_VALIDATE_INT) ?: 10;
    $draw = filter_var($request['draw'], FILTER_VALIDATE_INT) ?: 1;
    $this->db->from('tb_adjust_stok tas')
      ->join('tb_so ts', 'tas.id_so = ts.id')
      ->join('tb_toko tt', 'ts.id_toko = tt.id');
    $total_data = $this->db->count_all_results();
    $this->db->select(['tas.*', 'tt.nama_toko'])
      ->from('tb_adjust_stok tas')
      ->join('tb_so ts', 'tas.id_so = ts.id')
      ->join('tb_toko tt', 'ts.id_toko = tt.id');
    if (!empty($search_value)) {
      $this->db->group_start()
        ->like('tas.nomor', $search_value)
        ->or_like('tt.nama_toko', $search_value)
        ->group_end();
    }
    $filtered_data = $this->db->count_all_results('', false);
    $this->db->limit($length, $start);
    if (isset($request['order'])) {
      $column_index = $request['order'][0]['column'];
      $column_dir = $request['order'][0]['dir'];
      $this->db->order_by($column_order[$column_index], $column_dir);
    } else {
      $this->db->order_by('tas.status', 'asc');
      $this->db->order_by('tas.id', 'desc');
    }
    $query = $this->db->get()->result();
    $data = [];
    $no = $start + 1;
    foreach ($query as $row) {
      $data[] = [
        'no' => $no++,
        'nomor' => html_escape($row->nomor),
        'nama_toko' => html_escape($row->nama_toko),
        'id_so' => html_escape($row->id_so),
        'status' => $row->status,
        'created_at' => $row->created_at,
        'id' => $row->id
      ];
    }
    $response = [
      "draw" => $draw,
      "recordsTotal" => $total_data,
      "recordsFiltered" => $filtered_data,
      "data" => $data
    ];

    echo json_encode($response);
  }
  public function adjust_detail($id)
  {
    $data['title'] = 'Adjustment Stok';
    $data['row'] = $this->db->query("SELECT tas.*, tt.nama_toko, ts.tgl_so as periode, ts.id_toko from tb_adjust_stok tas
    JOIN tb_so ts on tas.id_so = ts.id
    JOIN tb_toko tt on ts.id_toko = tt.id
    WHERE tas.id = ?", array($id))->row();
    $data['detail'] = $this->db->query("SELECT tad.*, tp.kode,tp.nama_produk as artikel from tb_adjust_detail tad
    JOIN tb_produk tp on tad.id_produk = tp.id
    WHERE tad.id_adjust = ?", array($id))->result();
    $data['histori'] = $this->db->query("SELECT * from tb_adjust_histori where id_adjust = ?", array($id))->result();
    $this->template->load('template/template', 'adm/stok/adjust_detail', $data);
  }
  public function adjust_save()
  {
    $pengguna = $this->session->userdata('nama_user');
    $id_adjust = $this->input->post('id_adjust', true);
    $no_adjust = $this->input->post('no_adjust', true);
    $id_so = $this->input->post('id_so', true);
    $id_toko = $this->input->post('id_toko', true);
    $id_produk = $this->input->post('id_produk', true);
    $hasil_so = $this->input->post('hasil_so', true);
    $catatan = $this->input->post('catatan', true);
    $keputusan = $this->input->post('keputusan', true);
    $jml = count($id_produk);
    $tgl_so = $this->db->query("SELECT tgl_so FROM tb_so WHERE id = ?", array($id_so))->row()->tgl_so;
    $tgl_acc = date('Y-m-d');
    $this->db->trans_start();
    if ($keputusan == 1) {
      $aksi = "Diverifikasi Oleh :";
      $kartu_data = [];
      for ($i = 0; $i < $jml; $i++) {
        $terima_result = $this->db->query("SELECT SUM(tpd.qty) AS total_qty FROM tb_pengiriman_detail tpd
        JOIN tb_pengiriman tp ON tpd.id_pengiriman = tp.id
        WHERE tp.id_toko = ? 
        AND tp.updated_at BETWEEN ? AND ? 
        AND tpd.id_produk = ?", array($id_toko, $tgl_so, $tgl_acc, $id_produk[$i]))->row();
        $jual_result = $this->db->query("SELECT SUM(tpd.qty) AS total_qty FROM tb_penjualan_detail tpd
        JOIN tb_penjualan tp ON tpd.id_penjualan = tp.id
        WHERE tp.id_toko = ? 
        AND tp.tanggal_penjualan BETWEEN ? AND ? 
        AND tpd.id_produk = ?", array($id_toko, $tgl_so, $tgl_acc, $id_produk[$i]))->row();
        $mutasi_k = $this->db->query("SELECT SUM(tpd.qty_terima) AS total_qty FROM tb_mutasi_detail tpd
        JOIN tb_mutasi tp ON tpd.id_mutasi = tp.id
        WHERE tp.id_toko_asal = ?  AND tp.status = 2
        AND tp.updated_at BETWEEN ? AND ? 
        AND tpd.id_produk = ?", array($id_toko, $tgl_so, $tgl_acc, $id_produk[$i]))->row();
        $mutasi_m = $this->db->query("SELECT SUM(tpd.qty_terima) AS total_qty FROM tb_mutasi_detail tpd
        JOIN tb_mutasi tp ON tpd.id_mutasi = tp.id
        WHERE tp.id_toko_tujuan = ?  AND tp.status = 2
        AND tp.updated_at BETWEEN ? AND ? 
        AND tpd.id_produk = ?", array($id_toko, $tgl_so, $tgl_acc, $id_produk[$i]))->row();
        $retur_result = $this->db->query("SELECT SUM(tpd.qty_terima) AS total_qty FROM tb_retur_detail tpd
        JOIN tb_retur tp ON tpd.id_retur = tp.id
        WHERE tp.id_toko = ?  AND tp.status = 4
        AND tp.updated_at BETWEEN ? AND ? 
        AND tpd.id_produk = ?", array($id_toko, $tgl_so, $tgl_acc, $id_produk[$i]))->row();
        $terima = $terima_result->total_qty ?? 0;
        $jual = $jual_result->total_qty ?? 0;
        $mutasi_keluar = $mutasi_k->total_qty ?? 0;
        $mutasi_masuk = $mutasi_m->total_qty ?? 0;
        $retur = $retur_result->total_qty ?? 0;
        $cek_stok = $this->db->query("SELECT qty from tb_stok where id_toko = ? AND id_produk = ?", array($id_toko, $id_produk[$i]))->row();
        $stok_sistem = $cek_stok->qty ?? 0;
        $this->db->set('qty', $hasil_so[$i] + $terima + $mutasi_masuk - $jual - $mutasi_keluar - $retur)
          ->set('qty_awal', $hasil_so[$i])
          ->where('id_produk', $id_produk[$i])
          ->where('id_toko', $id_toko)
          ->update('tb_stok');
        $kartu_data[] = [
          'no_doc' => $no_adjust,
          'id_produk' => $id_produk[$i],
          'id_toko' => $id_toko,
          'stok' => $stok_sistem,
          'sisa' => $hasil_so[$i] + $terima + $mutasi_masuk - $jual - $mutasi_keluar - $retur,
          'keterangan' => 'Adjustment Stok',
          'pembuat' => $pengguna
        ];
      }
      $this->db->insert_batch('tb_kartu_stok', $kartu_data);
    } else {
      $aksi = "Ditolak Oleh :";
    }

    $this->db->update('tb_adjust_stok', ['status' => $keputusan], ['id' => $id_adjust]);
    $this->db->insert('tb_adjust_histori', [
      'id_adjust' => $id_adjust,
      'aksi' => $aksi,
      'pembuat' => $pengguna,
      'catatan' => $catatan
    ]);

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      tampil_alert('error', 'Gagal', 'Terjadi kesalahan, data tidak tersimpan.');
    } else {
      tampil_alert('success', 'Berhasil', 'Data Adjustment Stok berhasil proses.');
    }
    redirect(base_url('adm/Stok/adjust_detail/' . $id_adjust));
  }
}
