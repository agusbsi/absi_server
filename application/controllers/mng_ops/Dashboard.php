<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "14" && $role != 11 && $role != "15" && $role != "5" && $role != "1" && $role != "10") {
      tampil_alert('error', 'DI TOLAK !', 'Silahkan login kembali');
      redirect(base_url(''));
    }
    $this->load->model('M_adm_gudang');
  }
  public function index()
  {
    $data['title'] = 'Dashboard';
    $data['box'] = $this->box();
    // Dapatkan bulan dan tahun saat ini
    $currentMonth = date('m');
    $currentYear = date('Y');
    // Query SQL untuk mengambil total permintaan dan pengiriman
    $query = "SELECT 
    (SELECT COUNT(id) FROM tb_permintaan WHERE MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS t_minta,
    (SELECT COUNT(id) FROM tb_pengiriman WHERE MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS t_kirim,
    (SELECT COUNT(id) FROM tb_retur WHERE MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS t_retur,
    (SELECT COUNT(id) FROM tb_penjualan WHERE MONTH(tanggal_penjualan) = $currentMonth AND YEAR(created_at) = $currentYear) AS t_jual";
    // Jalankan query SQL
    $result = $this->db->query($query)->row();
    // Simpan hasil dalam variabel data
    $data['t_minta'] = $result->t_minta;
    $data['t_kirim'] = $result->t_kirim;
    $data['t_retur'] = $result->t_retur;
    $data['t_jual'] = $result->t_jual;
    // 5 top toko
    $data['toko_aktif'] = $this->db->query("SELECT tk.*, tu.nama_user, COUNT(tp.id_toko) as total 
    FROM tb_toko tk
    JOIN tb_penjualan tp ON tk.id = tp.id_toko
    LEFT JOIN tb_user_toko tut ON tk.id = tut.id_toko
    LEFT JOIN tb_user tu ON tut.id_user = tu.id
    WHERE MONTH(tp.tanggal_penjualan) = $currentMonth AND YEAR(tp.tanggal_penjualan) = $currentYear
    GROUP BY tk.id, tu.nama_user
    ORDER BY total DESC
    LIMIT 5")->result();

    $this->template->load('template/template', 'manager_ops/dashboard', $data);
  }
  // fungsi box
  public function box()
  {
    $box = [

      [
        'box'         => 'bg-info',
        'total'       => $this->db->query("SELECT count(id) as total from tb_toko where  status = 1")->row()->total,
        'title'       => 'Toko Aktif',
        'link'        => 'mng_ops/Dashboard/toko/',
        'icon'        => 'fas fa-store'
      ],
      [
        'box'         => 'bg-warning',
        'total'       =>  $this->db->query("SELECT count(id) as total from tb_produk where  status = 1")->row()->total,
        'title'       => 'Jenis Artikel',
        'link'        => 'mng_ops/Dashboard/artikel/',
        'icon'        => 'fas fa-cube'
      ],
      [
        'box'         => 'bg-info',
        'total'       =>  $this->db->query("SELECT count(id) as total from tb_user where role = 3 and  status = 1")->row()->total,
        'title'       => 'Total Leader',
        'link'        => 'mng_ops/Dashboard/user',
        'icon'        => 'fas fa-users'
      ],
      [
        'box'         => 'bg-success',
        'total'       =>  $this->db->query("SELECT count(id) as total from tb_user where role = 4 and  status = 1")->row()->total,
        'title'       => 'Total SPG',
        'link'        => 'mng_ops/Dashboard/user',
        'icon'        => 'fas fa-users'
      ]

    ];
    $info_box = json_decode(json_encode($box), FALSE);
    return $info_box;
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
    where tt.status = 1
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
    $pengguna = $this->session->userdata('nama_user');
    $no_so = $this->input->post('no_so', true);
    $get_toko = $this->input->post('toko', true);
    $id_produk = $this->input->post('id_produk', true);
    $qty_sistem = $this->input->post('qty_sistem', true);
    $hasil_so = $this->input->post('hasil_so', true);
    $catatan = $this->input->post('catatan', true);
    $pt = $this->session->userdata('pt');

    $jml = count($id_produk);
    $this->db->trans_start();

    // Insert ke tb_adjust_stok
    $cek = $this->db->query("SELECT MAX(no_urut) as urut FROM tb_adjust_stok")->row();
    $urut = isset($cek->urut) ? $cek->urut + 1 : 1;
    $this->db->insert('tb_adjust_stok', ['id_so' => $no_so, 'no_urut' => $urut, 'nomor' => 'AD-' . date('Y') . '-' . date('n') . '-' . $urut]);
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
      tampil_alert('eror', 'Gagal', 'Terjadi kesalahan, data tidak tersimpan.');
    } else {
      tampil_alert('success', 'Berhasil', 'Data Adjustment Stok berhasil diajukan.');
      $hp = $this->db->select('no_telp')
        ->from('tb_user')
        ->where('role', 1)
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
}
