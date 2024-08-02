<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $role = $this->session->userdata('role');
    if ($role == null) {
      redirect(base_url());
    }
    $this->load->model('M_admin');
    $this->load->model('M_support');
    $this->load->model('M_login');
  }
  public function index()
  {
    $id = $this->session->userdata('id');
    $role = $this->session->userdata('role');
    $data['title'] = 'Profile';
    $data['profil'] = $this->db->query("SELECT * FROM tb_user WHERE id = '$id'")->row();
    $data['lihat_role'] = $this->db->query("SELECT * FROM tb_user_role WHERE id = '$role'")->row();
    $data['foto'] = "img/profil/" . $id . ".jpg";
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user', $this->session->userdata('username'));
    $this->template->load('template/template', 'profile/index', $data);
  }
  public function update()
  {
    $id = $this->input->post('id_user');
    $nama = $this->input->post('nama');
    $telp = $this->input->post('telp');
    $alamat = $this->input->post('alamat');
    $data = array(
      'nama_user' => $nama,
      'no_telp' => $telp,
      'alamat' => $alamat
    );
    $this->db->update('tb_user', $data, array('id' => $id));
    tampil_alert('success', 'Berhasil', 'Data berhasil di Perbaharui!');
    redirect(base_url('Profile'));
  }
  public function update_foto()
  {
    $id = $this->input->post('id');
    $config['upload_path'] = 'assets/img/user/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = '5048';
    $config['file_name'] = 'selfie_' . $id;
    $config['overwrite'] = TRUE;
    $config['remove_spaces'] = TRUE;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    if (!$this->upload->do_upload('foto')) {
      // Tampilkan error upload jika ada
      $error = $this->upload->display_errors();
      tampil_alert('error', 'Gagal', $error);
      redirect(base_url('Profile'));
    } else {
      // Ambil nama file foto lama dari database
      $query = $this->db->query("SELECT foto_diri FROM tb_user WHERE id = ?", array($id));
      $old_foto = $query->row()->foto_diri;

      // Hapus foto lama dari server jika ada
      if (!empty($old_foto) && file_exists('assets/img/user/' . $old_foto)) {
        unlink('assets/img/user/' . $old_foto);
      }

      // Simpan foto baru
      $foto = $this->upload->data('file_name');
      $this->db->query("UPDATE tb_user SET foto_diri = ? WHERE id = ?", array($foto, $id));
      tampil_alert('success', 'Berhasil', 'Foto Profil berhasil di Perbaharui!');
      redirect(base_url('Profile'));
    }
  }

  private function hash_password($password)
  {
    return password_hash($password, PASSWORD_DEFAULT);
  }
  public function ganti_password()
  {
    $this->form_validation->set_rules('pass_lama', 'Password Lama', 'required');
    $this->form_validation->set_rules('pass_baru', 'Password Baru', 'required');
    if ($this->form_validation->run() == TRUE) {
      $id = $this->input->post('id_user');
      $pass_lama = $this->input->post('pass_lama', TRUE);
      $pass_baru = $this->input->post('pass_baru', TRUE);
      $cek = $this->db->query("SELECT * from tb_user where id = '$id'");
      if ($cek->num_rows() != 1) {
        tampil_alert('error', 'NOT FOUND', 'Data tidak ditemukan.');
        redirect(base_url('profile'));
      } else {
        $isi = $cek->row();
        if (password_verify($pass_lama, $isi->password) === TRUE) {
          $data = array(
            'password' => $this->hash_password($pass_baru)
          );
          $where = array(
            'id' => $id
          );
          $this->db->update('tb_user', $data, $where);
          tampil_alert('success', 'Berhasil', 'Password Berhasil di ganti, Silahkan Login Kembali!');
          redirect(base_url('login'));
          $this->session->sess_destroy();
        } else {
          tampil_alert('error', 'Gagal', 'Password lama salah!');
          redirect(base_url('profile'));
        }
      }
    }
  }
  public function logout()
  {
    $id_user = $this->session->userdata('id');
    $this->db->query("UPDATE tb_user set last_online = null where id = '$id_user'");
    $this->session->sess_destroy();
    redirect(base_url());
  }
  public function signature()
  {
    $id_user = $this->session->userdata('id');
    if (!$id_user) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'error', 'message' => 'Session telah habis, silahkan login kembali.']));
      return;
    }

    // Ambil data dari request body
    $input = json_decode(file_get_contents('php://input'), true);
    $imageData = $input['image'];

    // Menghapus "data:image/png;base64," dari data URI
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);

    // Dekode base64 menjadi binary
    $data = base64_decode($imageData);

    // Tentukan nama file dan path
    $fileName = 'ttd_' . $id_user . '.png';
    $filePath = './assets/img/ttd/' . $fileName;

    // Simpan file ke server
    if (!is_dir('./assets/img/ttd')) {
      mkdir('./assets/img/ttd', 0777, true);
    }
    file_put_contents($filePath, $data);

    // Simpan informasi tanda tangan ke database
    $this->db->set('ttd', $fileName);
    $this->db->where('id', $id_user);
    $this->db->update('tb_user');

    // Kirim respon sukses
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(['status' => 'success', 'file' => $fileName]));
  }
  public function reset_ttd()
  {
    $id_user = $this->session->userdata('id');
    $query = $this->db->query("SELECT ttd FROM tb_user WHERE id = ?", array($id_user));
    $old_foto = $query->row()->ttd;
    if (!empty($old_foto) && file_exists('assets/img/ttd/' . $old_foto)) {
      unlink('assets/img/ttd/' . $old_foto);
    }
    $this->db->query("UPDATE tb_user set ttd = '' where id = '$id_user'");
    tampil_alert('success', 'BERHASIL', 'Pola Tanda tangan berhasil di kosongkan.');
    redirect(base_url('profile'));
  }
}
