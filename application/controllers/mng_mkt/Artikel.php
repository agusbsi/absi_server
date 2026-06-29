<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if($role != "9"){
      tampil_alert('error','DI TOLAK !','Anda tidak punya akses untuk halaman ini.!');
      redirect(base_url(''));
    }
  }

  //  fungsi lihat data
  public function index()
  {
       
        $data['title'] = 'Artikel Baru';
        $data['list_data'] = $this->db->query("SELECT ts.*, tp.nama_produk,tp.kode,tt.nama_toko,tt.id as id_toko, tp.harga_jawa,tp.harga_indobarat, tt.het from tb_stok ts
        join tb_produk tp on ts.id_produk = tp.id
        JOIN tb_toko tt on ts.id_toko = tt.id
        where ts.status ='2'
        order by ts.id desc")->result();
        $this->template->load('template/template', 'manager_mkt/artikel/artikel_baru', $data);
  
  }

  //  approve artikel
  public function approve()
  {
    $this->update_status('1');
  }

  //  Reject  Artikel
  public function reject()
  {
    $this->update_status('0');
  }

  private function update_status($status)
  {
    $id = $this->input->post('id');

    // Tetap mendukung request lama yang masih mengirim data melalui query string.
    if ($id === null) {
      $id = $this->input->get('id');
    }

    $id = is_array($id) ? $id : array($id);
    $id = array_values(array_unique(array_filter(array_map('intval', $id), function ($value) {
      return $value > 0;
    })));

    if (empty($id)) {
      return $this->output
        ->set_status_header(400)
        ->set_content_type('application/json')
        ->set_output(json_encode(array('success' => false, 'message' => 'Artikel belum dipilih.')));
    }

    $updated = $this->db
      ->where_in('id', $id)
      ->update('tb_stok', array('status' => $status));

    if (!$updated) {
      return $this->output
        ->set_status_header(500)
        ->set_content_type('application/json')
        ->set_output(json_encode(array('success' => false, 'message' => 'Status artikel gagal diperbarui.')));
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('success' => true, 'total' => count($id))));
  }
  


}
?>
