<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role != "11") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }

    $this->load->model('M_spg');
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $data['box'] = $this->box();
    $data['so_aset'] = $this->db->query("SELECT tt.*, tu.nama_user as spg 
        FROM tb_toko tt
        LEFT JOIN tb_user tu ON tt.id_spg = tu.id 
        WHERE tt.id NOT IN (
            SELECT id_toko 
            FROM tb_aset_spg 
            WHERE MONTH(tanggal) = MONTH(NOW()) 
            AND YEAR(tanggal) = YEAR(NOW())
        )
        GROUP BY tt.id, tu.nama_user")->result();
    $data['so_artikel'] = $this->db->query("SELECT tt.*, tu.nama_user as spg 
        FROM tb_toko tt
        LEFT JOIN tb_user tu ON tt.id_spg = tu.id 
        WHERE tt.id NOT IN (
            SELECT id_toko 
            FROM tb_so 
            WHERE MONTH(created_at) = MONTH(NOW()) 
            AND YEAR(created_at) = YEAR(NOW())
        )
        GROUP BY tt.id, tu.nama_user")->result();
    $this->template->load('template/template', 'staff_hrd/dashboard', $data);
  }
  public function box()
  {
    $queries = [
      ['bg-primary', 'SELECT count(id) as total from tb_toko where status = 1', 'Toko Aktif', 'adm/Toko/', 'fas fa-store'],
      ['bg-primary', 'SELECT count(id) as total from tb_toko where status = 0', 'Toko Tutup', 'adm/Toko/toko_tutup', 'fas fa-store-slash'],
      ['bg-primary', 'SELECT count(id) as total from tb_customer', 'Customer', 'adm/Customer', 'fas fa-building'],
      ['bg-primary', 'SELECT count(id) as total from tb_produk where status != 0', 'Jenis Artikel', 'adm/Produk/', 'fas fa-cube'],
      ['bg-primary', 'SELECT count(id) as total from tb_user where status != 0', 'Semua User', 'adm/User/', 'fas fa-users'],
      ['bg-primary', 'SELECT count(id) as total from tb_user where status != 0 AND role = 3', 'Team Leader', 'adm/User/', 'fas fa-users'],
      ['bg-primary', 'SELECT count(id) as total from tb_user where status != 0 AND role = 4', 'SPG', 'adm/User/', 'fas fa-users'],
      ['bg-primary', 'SELECT count(id) as total from tb_aset_master', 'Jenis Aset', 'hrd/Aset', 'fas fa-layer-group'],
    ];

    $box = array_map(function ($query) {
      return [
        'box'   => $query[0],
        'total' => $this->db->query($query[1])->row()->total,
        'title' => $query[2],
        'link'  => $query[3],
        'icon'  => $query[4]
      ];
    }, $queries);

    return json_decode(json_encode($box), FALSE);
  }
}
