<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $role = $this->session->userdata('role');
    if ($role != "5" and $role != "16") {
      tampil_alert('error', 'DI TOLAK !', 'Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
    $this->load->model('M_adm_gudang');
  }
  //   halaman utama
  public function index()
  {

    $data['title'] = 'Dashboard';
    $data['box'] = $this->box();
    $bln = date('m');
    $thn = date('Y');
    // total permintaan
    $data['t_minta'] = $this->db->query("SELECT count(id) as total FROM tb_permintaan
    where status = 2  AND MONTH(created_at) = $bln AND YEAR(created_at) = $thn")->row();
    // total permintaan
    $data['t_retur'] = $this->db->query("SELECT count(id) as total FROM tb_retur
    where (status = '3' OR status = '6' OR status = '13' OR status = '14')  AND MONTH(created_at) = $bln AND YEAR(created_at) = $thn")->row();
    // total Kirim
    $data['t_kirim'] = $this->db->query("SELECT SUM(qty) as total FROM tb_pengiriman_detail tpd
    join tb_pengiriman tp on tpd.id_pengiriman = tp.id
    where tp.status != 0  AND MONTH(created_at) = $bln AND YEAR(created_at) = $thn")->row();
    $this->template->load('template/template', 'adm_gudang/dashboard', $data);
  }
  // identifikasi box
  public function box()
  {
    $box = [
      [
        'box'         => 'bg-info',
        'total'       => $this->db->query("SELECT SUM(qty) as total from tb_pengiriman_detail trd
        join tb_pengiriman tr on trd.id_pengiriman = tr.id
        where tr.status != 0 ")->row()->total,
        'title'       => 'Total Artikel di kirim',
        'link'        => '#',
        'icon'        => 'fas fa-truck'
      ],
      [
        'box'         => 'bg-danger',
        'total'       =>  $this->db->query("SELECT SUM(qty_terima) as total from tb_retur_detail trd
                join tb_retur tr on trd.id_retur = tr.id
                where tr.status = '4' or tr.status = '15'")->row()->total,
        'title'       => 'Total Artikel di Retur',
        'link'        => '#',
        'icon'        => 'fas fa-exchange-alt'
      ],

    ];
    $info_box = json_decode(json_encode($box), FALSE);
    return $info_box;
  }
}
