<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "14" && $role != 11 && $role != "15" && $role != "5" && $role != "1" && $role != "10" && $role != "17" && $role != "18") {
      tampil_alert('error', 'DI TOLAK !', 'Silahkan login kembali');
      redirect(base_url(''));
    }
    $this->load->model('M_adm_gudang');
    $this->load->model('M_dashboard');
  }
  public function index()
  {
    $data['title'] = 'Dashboard';
    $data['box'] = $this->M_dashboard->summary_boxes('full');
    foreach ($this->M_dashboard->monthly_activity() as $key => $total) {
      $data['t_' . $key] = $this->M_dashboard->as_total($total);
    }
    $this->template->load('template/template', 'manager_ops/dashboard', $data);
  }
  // fungsi box
  public function box()
  {
    return $this->M_dashboard->summary_boxes('full');
  }
  // list artikel
  public function artikel()
  {
    $data['title'] = 'Artikel';
    $data['list_data'] = $this->db->query("SELECT * from tb_produk where status = 1 order by kode asc")->result();
    $this->template->load('template/template', 'manager_ops/artikel/index.php', $data);
  }
  // customer
  public function customer()
  {
    $data['title'] = 'Kelola Customer';
    $data['customer'] = $this->db->query("SELECT tc.*, count(tt.id) as total_toko FROM tb_customer tc
    left join tb_toko tt on tt.id_customer = tc.id 
    where tc.deleted_at is null group by tc.nama_cust order by tc.id desc ")->result();
    $this->template->load('template/template', 'manager_ops/customer/index', $data);
  }
  // detail customer
  public function detail_cust($id_customer)
  {
    $data['title'] = 'Kelola Customer';
    $data['customer'] = $this->db->query("SELECT * from tb_customer where id ='$id_customer'")->row();
    $data['list_toko'] = $this->db->query("SELECT tb_toko.*, tu.nama_user as spv,tuu.nama_user as leader, tuuu.nama_user as spg from tb_toko
    join tb_customer tc on tb_toko.id_customer = tc.id
    join tb_user tu on tb_toko.id_spv = tu.id
    join tb_user tuu on tb_toko.id_leader = tuu.id
    left join tb_user tuuu on tb_toko.id_spg = tuuu.id
    where tb_toko.id_customer ='$id_customer'")->result();
    $this->template->load('template/template', 'manager_ops/customer/detail', $data);
  }
  public function toko()
  {
    $data['title'] = 'Toko';
    $data['toko'] = $this->db->query("SELECT tt.*, tu.nama_user as spg, tl.nama_user as leader
    from tb_toko tt
    left join tb_user tu on tt.id_spg = tu.id
    left join tb_user tl on tt.id_leader = tl.id
    where tt.status IN (1,7)
    order by tt.id desc")->result();
    $this->template->load('template/template', 'manager_ops/toko/index.php', $data);
  }
  // detail toko
  public function toko_detail($toko)
  {
    $data['title']         = 'Toko';
    $data['toko']          = $this->db->query("SELECT tt.*,tu.nama_user as spv,tu.foto_diri as foto_spv,tuu.nama_user as leader,tuu.foto_diri as foto_leader, tuuu.nama_user as spg,tuuu.foto_diri as foto_spg, tp.nama as provinsi,tk.nama as kabupaten,tc.nama as kecamatan, tt.provinsi as id_provinsi from tb_toko tt
     join wilayah_provinsi tp on tt.provinsi = tp.id
     join wilayah_kabupaten tk on tt.kabupaten = tk.id
     join wilayah_kecamatan tc on tt.kecamatan = tc.id
     left join tb_user tu on tt.id_spv = tu.id
     left join tb_user tuu on tt.id_leader = tuu.id
     left join tb_user tuuu on tt.id_spg = tuuu.id
     where tt.id = '$toko'")->row();
    $data['stok_produk']   = $this->db->query("SELECT tb_produk.nama_produk, tb_produk.satuan, tb_stok.*, tb_produk.kode from tb_stok
     join tb_produk on tb_stok.id_produk = tb_produk.id
     join tb_toko on tb_stok.id_toko = tb_toko.id
     where tb_stok.id_toko = '$toko'")->result();
    $this->template->load('template/template', 'manager_ops/toko/detail', $data);
  }
  // list leader
  public function user()
  {
    $data['title'] = 'user';
    $data['list_users'] = $this->db->query('SELECT * FROM tb_user 
    WHERE status = 1 and (role = 3 or role = 4)  order by id desc')->result();
    $this->template->load('template/template', 'manager_ops/user/index', $data);
  }
  // permintaan
  public function permintaan()
  {
    // ambil bulan kemarin
    $hari_ini = date('Y-m-d');
    $bulan_kemarin = date("Y-m-d", strtotime("-2 month", strtotime($hari_ini)));
    $data['title'] = 'Permintaan';
    $data['permintaan'] = $this->db->query("SELECT tp.*, tt.nama_toko from tb_permintaan tp
    join tb_toko tt on tp.id_toko = tt.id
    WHERE date(tp.created_at) >= '$bulan_kemarin' 
    order by tp.id desc")->result();
    $this->template->load('template/template', 'manager_ops/permintaan/index', $data);
  }
  // detail permintaan
  public function detail_p($id)
  {
    $data['title'] = 'Permintaan';
    $data['minta'] = $this->db->query("SELECT tp.*, tt.nama_toko from tb_permintaan tp 
    join tb_toko tt on tp.id_toko = tt.id
    where tp.id = '$id'")->row();
    $data['list_data'] = $this->db->query("SELECT tpd.*, tpk.kode, tpk.nama_produk from tb_permintaan_detail tpd
    join tb_permintaan tp on tpd.id_permintaan = tp.id
    join tb_produk tpk on tpd.id_produk = tpk.id
    where tpd.id_permintaan = '$id'")->result();
    $this->template->load('template/template', 'manager_ops/permintaan/detail', $data);
  }
  // Pengiriman
  public function pengiriman()
  {
    $data['title'] = 'pengiriman';
    $data['pengiriman'] = $this->db->query("SELECT tp.*, tt.nama_toko from tb_pengiriman tp
     join tb_toko tt on tp.id_toko = tt.id
     order by tp.id desc")->result();
    $this->template->load('template/template', 'manager_ops/pengiriman/index', $data);
  }
  // detail Pengiriman
  public function detail_kirim($id)
  {
    $data['title'] = 'pengiriman';
    $data['kirim'] = $this->db->query("SELECT tp.*, tt.nama_toko, tu.nama_user as spg from tb_pengiriman tp 
    join tb_toko tt on tp.id_toko = tt.id
    left join tb_user tu on tp.id_penerima = tu.id
    where tp.id = '$id'")->row();
    $data['list_data'] = $this->db->query("SELECT tpd.*, tpk.kode, tpk.nama_produk from tb_pengiriman_detail tpd
    join tb_pengiriman tp on tpd.id_pengiriman = tp.id
    join tb_produk tpk on tpd.id_produk = tpk.id
    where tpd.id_pengiriman = '$id'")->result();
    $this->template->load('template/template', 'manager_ops/pengiriman/detail', $data);
  }
  // Retur
  public function retur()
  {
    $currentMonth = date('m');
    $currentYear = date('Y');
    $data['title'] = 'retur';
    $data['retur'] = $this->db->query("SELECT tp.*, tt.nama_toko from tb_retur tp
      join tb_toko tt on tp.id_toko = tt.id
      WHERE MONTH(tp.created_at) = $currentMonth AND YEAR(tp.created_at) = $currentYear 
      order by tp.id desc")->result();
    $this->template->load('template/template', 'manager_ops/retur/index', $data);
  }

  public function adjust_stok()
  {
    $data['title'] = 'Adjustment Stok';
    $this->template->load('template/template', 'manager_ops/toko/adjust_tampil', $data);
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
    $data['row'] = $this->db->query("SELECT tas.*, tt.nama_toko, ts.tgl_so as periode from tb_adjust_stok tas
    JOIN tb_so ts on tas.id_so = ts.id
    JOIN tb_toko tt on ts.id_toko = tt.id
    WHERE tas.id = ?", array($id))->row();
    $data['detail'] = $this->db->query("SELECT tad.*, tp.kode,tp.nama_produk as artikel from tb_adjust_detail tad
    JOIN tb_produk tp on tad.id_produk = tp.id
    WHERE tad.id_adjust = ?", array($id))->result();
    $data['histori'] = $this->db->query("SELECT * from tb_adjust_histori where id_adjust = ?", array($id))->result();
    $this->template->load('template/template', 'manager_ops/toko/adjust_detail', $data);
  }
  public function adjust_save()
  {
    $this->load->library('upload');
    $pengguna = $this->session->userdata('nama_user');
    $no_so = $this->input->post('no_so', true);
    $get_toko = $this->input->post('toko', true);
    $id_produk = $this->input->post('id_produk', true);
    $qty_sistem = $this->input->post('qty_sistem', true);
    $hasil_so = $this->input->post('hasil_so', true);
    $catatan = $this->input->post('catatan', true);
    $pt = $this->session->userdata('pt');

    $config['upload_path'] = './assets/img/adj/';
    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
    $config['max_size'] = 9048;
    $config['file_name'] = 'berkas_' . time();

    if (!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, true);
    }

    $this->upload->initialize($config);
    $uploaded_file = null;

    if (!$this->upload->do_upload('bukti')) {
      tampil_alert('error', 'Gagal Upload', "Gagal upload gambar, cek ukuran file,pastikan di bawah 10 mb.");
      redirect(base_url('mng_ops/Dashboard/adjust'));
      return;
    } else {
      $uploaded_file = $this->upload->data('file_name');
    }

    $jml = count($id_produk);
    $this->db->trans_start();

    // Insert ke tb_adjust_stok
    $cek = $this->db->query("SELECT MAX(no_urut) as urut FROM tb_adjust_stok")->row();
    $urut = isset($cek->urut) ? $cek->urut + 1 : 1;
    $data_adjust = [
      'id_so' => $no_so,
      'no_urut' => $urut,
      'nomor' => 'AD-' . date('Y') . '-' . date('n') . '-' . $urut,
      'berkas' => $uploaded_file
    ];
    $this->db->insert('tb_adjust_stok', $data_adjust);
    $id_adjust = $this->db->insert_id();

    // Insert batch ke tb_adjust_detail
    $detail_data = [];
    for ($i = 0; $i < $jml; $i++) {
      $detail_data[] = [
        'id_adjust' => $id_adjust,
        'id_produk' => $id_produk[$i],
        'stok_akhir' => $qty_sistem[$i],
        'hasil_so' => $hasil_so[$i]
      ];
    }
    $this->db->insert_batch('tb_adjust_detail', $detail_data);

    // Insert ke tb_adjust_histori
    $this->db->insert('tb_adjust_histori', [
      'id_adjust' => $id_adjust,
      'aksi' => 'Diajukan oleh :',
      'pembuat' => $pengguna,
      'catatan' => $catatan
    ]);

    // Complete transaction
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      tampil_alert('error', 'Gagal', 'Terjadi kesalahan, data tidak tersimpan.');
    } else {
      tampil_alert('success', 'Berhasil', 'Data Adjustment Stok berhasil diajukan.');

      $hp = $this->db->select('no_telp')
        ->from('tb_user')
        ->where('role', 17)
        ->where('status', 1)
        ->get()
        ->result();
      foreach ($hp as $h) {
        $phone = $h->no_telp;
        $message = "Anda memiliki 1 Pengajuan Adjustment Stok ($get_toko - $pt) yang perlu di cek, silahkan kunjungi s.id/absi-app";
        kirim_wa($phone, $message);
      }
    }

    redirect(base_url('mng_ops/Dashboard/adjust_detail/' . $id_adjust));
  }
  public function approve_adjust()
  {
    $pengguna = $this->session->userdata('nama_user');
    $pt = $this->session->userdata('pt');
    $id_adjust = $this->input->post('id_adjust', true);
    $catatan = $this->input->post('catatan', true);
    $keputusan = $this->input->post('keputusan', true);
    $this->db->trans_start();
    if ($keputusan == 4) {
      $aksi = "Diverifikasi Oleh :";
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
      if ($keputusan == 4) {
        $hp = $this->db->select('no_telp')
          ->from('tb_user')
          ->where('role', 1)
          ->where('status', 1)
          ->get()
          ->result();
        foreach ($hp as $h) {
          $phone = $h->no_telp;
          $message = "Anda memiliki 1 Pengajuan Adjustment Stok ( $pt ) yang perlu di cek, silahkan kunjungi s.id/absi-app";
          kirim_wa($phone, $message);
        }
      }
    }
    redirect(base_url('mng_ops/Dashboard/adjust_detail/' . $id_adjust));
  }

  // Lock SO (Stok Opname)
  public function lock_so()
  {
    $pengguna = $this->session->userdata('nama_user');
    $pt = $this->session->userdata('pt');
    $id_so = $this->input->post('id_so', true);
    $data_produk_json = $this->input->post('data_produk', true);

    // Validasi input
    if (empty($id_so)) {
      tampil_alert('error', 'Gagal', 'Data SO tidak valid.');
      redirect($_SERVER['HTTP_REFERER']);
      return;
    }

    // Decode JSON data produk dari form
    $data_produk = json_decode($data_produk_json, true);
    
    if (empty($data_produk) || !is_array($data_produk)) {
      tampil_alert('error', 'Gagal', 'Tidak ada detail produk untuk dikunci.');
      redirect($_SERVER['HTTP_REFERER']);
      return;
    }

    // Mulai transaksi database
    $this->db->trans_start();

    try {
      // 1. Update status_kunci di tb_so  
      $this->db->update('tb_so', ['status_kunci' => 1], ['id' =>$id_so]);

      if ($this->db->affected_rows() == 0) {
        throw new Exception('Data SO tidak ditemukan atau sudah terkunci sebelumnya.');
      }

      // 2. Update dengan batch CASE statement (chunk per 50 item untuk performa)
      $chunk_size = 50;
      $chunks = array_chunk($data_produk, $chunk_size);

      foreach ($chunks as $chunk) {
        // Kumpulkan ID produk untuk IN clause
        $id_produk_list = [];
        foreach ($chunk as $produk) {
          $id_produk_list[] = (int)($produk['id_produk'] ?? 0);
        }
        $in_clause = implode(',', $id_produk_list);

        // Build CASE statements untuk setiap field
        $case_qty_awal = "qty_awal = CASE id_produk ";
        $case_po = "po = CASE id_produk ";
        $case_mutasi_masuk = "mutasi_masuk = CASE id_produk ";
        $case_retur = "retur = CASE id_produk ";
        $case_jual = "jual = CASE id_produk ";
        $case_mutasi_keluar = "mutasi_keluar = CASE id_produk ";
        $case_stok_akhir = "stok_akhir = CASE id_produk ";
        $case_hasil_so = "hasil_so = CASE id_produk ";
        $case_jual_lanjutan = "jual_lanjutan = CASE id_produk ";

        foreach ($chunk as $produk) {
          $id_p = (int)($produk['id_produk'] ?? 0);
          $case_qty_awal .= " WHEN " . $id_p . " THEN " . (int)($produk['qty_awal'] ?? 0);
          $case_po .= " WHEN " . $id_p . " THEN " . (int)($produk['po'] ?? 0);
          $case_mutasi_masuk .= " WHEN " . $id_p . " THEN " . (int)($produk['mutasi_masuk'] ?? 0);
          $case_retur .= " WHEN " . $id_p . " THEN " . (int)($produk['retur'] ?? 0);
          $case_jual .= " WHEN " . $id_p . " THEN " . (int)($produk['penjualan'] ?? 0);
          $case_mutasi_keluar .= " WHEN " . $id_p . " THEN " . (int)($produk['mutasi_keluar'] ?? 0);
          $case_stok_akhir .= " WHEN " . $id_p . " THEN " . (int)($produk['stok_akhir'] ?? 0);
          $case_hasil_so .= " WHEN " . $id_p . " THEN " . (int)($produk['hasil_so'] ?? 0);
          $case_jual_lanjutan .= " WHEN " . $id_p . " THEN " . (int)($produk['penjualan_lanjutan'] ?? 0);
        }

        $case_qty_awal .= " END";
        $case_po .= " END";
        $case_mutasi_masuk .= " END";
        $case_retur .= " END";
        $case_jual .= " END";
        $case_mutasi_keluar .= " END";
        $case_stok_akhir .= " END";
        $case_hasil_so .= " END";
        $case_jual_lanjutan .= " END";

        $sql = "UPDATE tb_so_detail SET ";
        $sql .= $case_qty_awal . ", " . $case_po . ", " . $case_mutasi_masuk . ", " . $case_retur . ", ";
        $sql .= $case_jual . ", " . $case_mutasi_keluar . ", " . $case_stok_akhir . ", " . $case_hasil_so . ", " . $case_jual_lanjutan;
        $sql .= " WHERE id_so = " . $this->db->escape($id_so) . " AND id_produk IN (" . $in_clause . ")";

        $this->db->query($sql);
      }

      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE) {
        tampil_alert('error', 'Gagal', 'Terjadi kesalahan, laporan gagal dikunci.');
        redirect($_SERVER['HTTP_REFERER']);
      } else {
        tampil_alert('success', 'Berhasil', 'Laporan SO berhasil dikunci. Data sekarang bersifat final dan tidak dapat diubah.');
        redirect($_SERVER['HTTP_REFERER']);
      }
    } catch (Exception $e) {
      $this->db->trans_complete();
      tampil_alert('error', 'Gagal', 'Terjadi kesalahan: ' . $e->getMessage());
      redirect($_SERVER['HTTP_REFERER']);
    }
  }
}
