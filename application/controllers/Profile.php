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
  public function saran()
  {
    $data['title'] = 'Profile';
    $this->template->load('template/template', 'profile/saran', $data);
  }
  public function saran_kirim()
  {
    $id_user = $this->session->userdata('id');
    $nama = $this->input->post('nama');
    $rating = $this->input->post('rating');
    $kritik = $this->input->post('kritik');
    $saran = $this->input->post('saran');
    $data = [
      'id_user' => $id_user,
      'nama' => $nama,
      'rating' => $rating,
      'kritik' => $kritik,
      'saran' => $saran
    ];
    $this->db->insert('tb_saran', $data);
    tampil_alert('success', 'TERKIRIM', 'Terima kasih telah memberikan saran dan masukan untuk ABSI.');
    redirect('profile');
  }
  public function chat()
  {
    $id_user = $this->session->userdata('id');
    $data['title'] = 'Profile';
    $data['foto'] = $this->db->query("SELECT foto_diri from tb_user where id ='$id_user'")->row()->foto_diri;
    $this->load->view('profile/chat', $data);
  }
  public function dashboard()
  {
    $role = $this->session->userdata('role');
    $roleRedirects = [
      '1' => 'adm/dashboard',
      '2' => 'spv/dashboard',
      '3' => 'leader/dashboard',
      '4' => 'spg/dashboard',
      '5' => 'adm_gudang/dashboard',
      '6' => 'sup/dashboard',
      '7' => 'hrd/dashboard',
      '8' => 'adm_mv/dashboard',
      '9' => 'mng_mkt/dashboard',
      '10' => 'audit/dashboard',
      '11' => 'staff_hrd/dashboard',
      '12' => 'staff_ga/dashboard',
      '14' => 'mng_ops/dashboard',
      '15' => 'accounting/dashboard',
    ];
    if (isset($roleRedirects[$role])) {
      redirect($roleRedirects[$role]);
    } else {
      redirect('profile');
    }
  }
  // ambil list chat
  public function list_chat()
  {
    $id_user = $this->session->userdata('id');

    // Subquery untuk mendapatkan pesan terakhir dari setiap pengguna
    $subquery = "
          SELECT 
              CASE
                  WHEN pengirim = '$id_user' THEN penerima
                  ELSE pengirim
              END AS user_interaction,
              MAX(waktu) AS tanggal_terakhir
          FROM tb_chat
          WHERE penerima = '$id_user' OR pengirim = '$id_user'
          GROUP BY CASE
                      WHEN pengirim = '$id_user' THEN penerima
                      ELSE pengirim
                    END
      ";

    // Query utama untuk mendapatkan data pengguna dan pesan terakhir
    $query = $this->db->query("
          SELECT 
              tu.id AS user_id,
              tu.nama_user,
              tu.foto_diri,
              tc.pesan AS pesan_terakhir,
              tc.waktu AS tanggal_terakhir,
              COALESCE(SUM(CASE WHEN tc_all.status = 0 AND tc_all.penerima = '$id_user' THEN 1 ELSE 0 END), 0) AS unread_count
          FROM tb_chat tc
          JOIN tb_user tu ON (
              (tc.pengirim = tu.id AND tc.penerima = '$id_user')
              OR
              (tc.penerima = tu.id AND tc.pengirim = '$id_user')
          )
          JOIN ($subquery) last_msg ON (
              (tc.pengirim = last_msg.user_interaction AND tc.penerima = '$id_user')
              OR
              (tc.penerima = last_msg.user_interaction AND tc.pengirim = '$id_user')
          ) AND tc.waktu = last_msg.tanggal_terakhir
          LEFT JOIN tb_chat tc_all ON (
              tc_all.pengirim = tu.id AND tc_all.penerima = '$id_user' AND tc_all.status = 0
          )
          WHERE tc.penerima = '$id_user' OR tc.pengirim = '$id_user'
          GROUP BY tu.id, tu.nama_user, tu.foto_diri, tc.pesan, tc.waktu
          ORDER BY tc.waktu ASC
      ");

    echo json_encode($query->result());
  }

  public function notif()
  {
    $penerima = $this->input->get('penerima'); // Ambil parameter penerima dari query string
    if (!$penerima) {
      echo json_encode(['error' => 'Parameter penerima tidak diberikan']);
      return;
    }

    $query = $this->db->query("SELECT sum(status = 0) as jmlPesan FROM tb_chat WHERE penerima = ?", array($penerima));
    echo json_encode($query->result());
  }

  public function get_messages()
  {
    // Ambil data JSON dari body request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true); // Decode JSON ke array asosiatif

    $penerima = $this->session->userdata('id');
    $pengirim = isset($data['pengirim']) ? $data['pengirim'] : '';

    if (empty($pengirim)) {
      echo json_encode(['error' => 'Pengirim tidak dikirim atau kosong']);
      return;
    }
    $this->db->update('tb_chat', array('status' => 1), array('pengirim' => $pengirim, 'penerima' => $penerima));
    // Ambil profil pengirim
    $profil = $this->db->query("SELECT * FROM tb_user WHERE id = ?", array($pengirim))->row();

    // Query untuk mendapatkan semua pesan antara pengirim dan penerima
    $query = $this->db->query(
      "SELECT tc.*, tu.nama_user, tu.foto_diri 
         FROM tb_chat tc
         JOIN tb_user tu ON tc.pengirim = tu.id
         WHERE (tc.penerima = ? AND tc.pengirim = ?) 
            OR (tc.penerima = ? AND tc.pengirim = ?)
         ORDER BY tc.waktu ASC",
      array($penerima, $pengirim, $pengirim, $penerima)
    );

    // Format hasil JSON
    echo json_encode(array(
      'pengirim' => $profil ? $profil->nama_user : '',
      'foto_pengirim' => $profil ? $profil->foto_diri : '',
      'chat' => $query->result()
    ));
  }

  public function send_message()
  {
    $pengirim = $this->session->userdata('id');
    $penerima = $this->input->post('penerima');
    $pesan = $this->input->post('message');

    // Simpan pesan ke database
    $data = [
      'penerima' => $penerima,
      'pengirim' => $pengirim,
      'pesan' => $pesan,
      'status' => 0,
    ];
    $this->db->insert('tb_chat', $data);

    // Ambil informasi chat terbaru
    $result = $this->db->query("
          SELECT 
              tu.id as user_id, 
              tu.nama_user, 
              tu.foto_diri, 
              COUNT(tc.id) as jml_pesan
          FROM 
              tb_chat tc
          JOIN 
              tb_user tu ON tc.pengirim = tu.id
          WHERE 
              tu.id = ? AND tc.status = 0 AND tc.penerima = ?
          GROUP BY 
              tu.id", [$pengirim, $penerima])->result();
    // Ambil informasi chat terbaru
    $dataPenerima = $this->db->query("
          SELECT 
              tu.id as user_id, 
              tu.nama_user, 
              tu.foto_diri
          FROM 
              tb_chat tc
          JOIN 
              tb_user tu ON tc.penerima = tu.id
          WHERE 
              tu.id = ?  AND tc.pengirim = ?
          GROUP BY 
              tu.id", [$penerima, $pengirim])->result();
    echo json_encode([
      'status' => 'success',
      'pesan' => $pesan,
      'pengirim' => $pengirim,
      'penerima' => $penerima,
      'chat_info' => $result,
      'chatPenerima' => $dataPenerima
    ]);
  }


  public function getUserList()
  {
    $id_user = $this->session->userdata('id');
    $role = $this->session->userdata('role');
    $where = "";
    if ($role == 4) {
      $where = "AND tu.role = 8 OR tu.role = 14 OR tu.id = 129";
    } else {
      $where = "LIMIT 10";
    }
    $query = $this->db->query("
        SELECT tu.id as id_user,tu.nama_user, tu.foto_diri, tr.nama as roleAkses 
        FROM tb_user tu
        JOIN tb_user_role tr ON tu.role = tr.id 
        WHERE tu.status = 1 AND tu.id != ? $where", [$id_user]);
    echo json_encode($query->result());
  }
  public function search_user()
  {
    $id_user = $this->session->userdata('id');
    $role = $this->session->userdata('role');
    $where = "";
    if ($role == 4) {
      $where = "AND tu.role != 1 AND tu.role != 9";
    }
    $keyword = $this->db->escape_like_str($this->input->get('keyword'));
    $sql = "SELECT tu.id as id_user,tu.nama_user, tu.foto_diri, tr.nama as roleAkses
            FROM tb_user tu
            JOIN tb_user_role tr ON tu.role = tr.id
            WHERE tu.nama_user LIKE '%$keyword%'
            AND tu.status = 1
            AND tu.id != ?
            $where LIMIT 20";
    $query = $this->db->query($sql, array($id_user));
    echo json_encode($query->result());
  }
}
