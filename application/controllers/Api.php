<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

    // login
    public function login()
    {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);


            if (!isset($data['username']) || !isset($data['password'])) {
                $response['status'] = 'error';
                $response['message'] = 'Username & Password tidak boleh kosong.';
                echo json_encode($response);
                return;
            }
            $username = $data['username'];
            $password = $data['password'];
            // Check username or phone number in the database
            $this->db->where('username', $username);
            $user_query = $this->db->get('tb_user');

            if ($user_query->num_rows() != 1) {
                $response['status'] = 'error';
                $response['message'] = 'Username belum terdaftar.';
                echo json_encode($response);
                return;
            }

            $user_data = $user_query->row();
            if ($user_data->role != 4) {
                $response['status'] = 'error';
                $response['message'] = 'Maaf, Aplikasi ini hanya untuk akun SPG!';
                echo json_encode($response);
                return;
            }
            if (password_verify($password, $user_data->password)) {
                $data_session = array(
                    'id_user' => $user_data->id,
                    'nama_user' => $user_data->nama,
                );
                $response['status'] = 'success';
                $response['message'] = 'Login Berhasil.';
                $response['data_user'] = $data_session;
                echo json_encode($response);
            } else {
                // Password is incorrect
                $response['status'] = 'error';
                $response['message'] = 'Username atau password Salah';
                echo json_encode($response);
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid request method.';
            echo json_encode($response);
        }
    }
    // list toko
    public function getToko()
    {
        $id_user = $this->input->post('id_user');

        // Pastikan ID pengguna tidak kosong atau null
        if (empty($id_user)) {
            $response['success'] = false;
            $response['message'] = 'ID pengguna tidak valid.';
        } else {
            $data_toko = $this->db->query("SELECT id as id_toko, nama_toko, alamat, telp from tb_toko where id_spg = '$id_user' and status = 1");

            // Handle database query error
            if ($data_toko === false) {
                $response['success'] = false;
                $response['message'] = 'Terjadi kesalahan saat mengambil data toko dari database.';
            } else {
                if ($data_toko->num_rows() > 0) {
                    $toko_list = $data_toko->result();
                    $response['success'] = true;
                    $response['message'] = 'Toko ditemukan.';
                    $response['stores'] = $toko_list;
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Toko tidak ditemukan.';
                }
            }
        }

        // Tetapkan header Content-Type ke application/json
        header('Content-Type: application/json');

        // Menggunakan echo untuk mengirimkan respons
        echo json_encode($response);
    }
    // List Po per toko
    public function getPo()
    {
        $id_toko = $this->input->post('id_toko');

        // Pastikan ID toko tidak kosong
        if (empty($id_toko)) {
            $response['success'] = false;
            $response['message'] = 'ID toko tidak valid.';
        } else {
            // Query data permintaan barang
            $list_permintaan = $this->db->query("SELECT * FROM tb_permintaan WHERE id_toko = '$id_toko' ORDER BY id DESC")->result();

            if (!empty($list_permintaan)) {
                // Data permintaan barang ditemukan
                $response['success'] = true;
                $response['message'] = 'Data permintaan barang ditemukan.';
                $response['permintaan'] = $list_permintaan;
            } else {
                // Data permintaan barang tidak ditemukan
                $response['success'] = false;
                $response['message'] = 'Data permintaan barang tidak ditemukan.';
            }
        }

        // Mengirim respons dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    // detail Po toko
    public function getPoDetail()
    {
        $id_po = $this->input->get('id_po');
        if (empty($id_po)) {
            $response['success'] = false;
            $response['message'] = 'ID PO tidak valid.';
        } else {
            $po = $this->db->query("SELECT * FROM tb_permintaan WHERE id = '$id_po'")->row();
            $detail_po = $this->db->query("SELECT tpd.*, tp.kode, tp.nama_produk FROM tb_permintaan_detail tpd JOIN tb_produk tp ON tp.id = tpd.id_produk WHERE tpd.id_permintaan = '$id_po'")->result();

            if ($po && $detail_po) {
                // Data detail permintaan barang ditemukan
                $response['success'] = true;
                $response['message'] = 'Data detail permintaan barang ditemukan.';
                $response['po'] = $po;
                $response['detail_po'] = $detail_po;
            } else {
                // Data detail permintaan barang tidak ditemukan
                $response['success'] = false;
                $response['message'] = 'Data detail permintaan barang tidak ditemukan.';
            }
        }
        // Mengirim respons dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    // list Produk per toko
    public function listProdukToko()
    {
        $toko = $this->input->get('id_toko');
        $response = []; // Inisialisasi respons

        if (empty($toko)) {
            $response['success'] = false;
            $response['message'] = 'ID toko tidak valid.';
        } else {
            $cek = $this->db->query("SELECT ssr from tb_toko where id = '$toko'");
            if ($cek->num_rows() <= 0) {
                $response['success'] = false;
                $response['message'] = 'Toko tidak ditemukan.';
            } else {
                $ssr = $cek->row()->ssr;
                $data_produk = $this->db->query("
                SELECT tb_produk.*, tb_stok.qty, COALESCE(ROUND(AVG(penjualan_3_bulan.qty), 0), 0) * '$ssr' as ssr
                FROM tb_produk
                LEFT JOIN tb_stok ON tb_produk.id = tb_stok.id_produk AND tb_stok.id_toko = '$toko'
                LEFT JOIN (
                    SELECT tb_penjualan_detail.id_produk, AVG(tb_penjualan_detail.qty) as qty
                    FROM tb_penjualan_detail
                    JOIN tb_penjualan ON tb_penjualan_detail.id_penjualan = tb_penjualan.id
                    WHERE tb_penjualan.id_toko = '$toko'
                        AND tb_penjualan.tanggal_penjualan >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
                    GROUP BY tb_penjualan_detail.id_produk
                ) as penjualan_3_bulan ON tb_produk.id = penjualan_3_bulan.id_produk
                WHERE tb_stok.id_toko = '$toko'
                GROUP BY tb_produk.id
            ")->result();

                // Ubah format data menjadi array
                foreach ($data_produk as $produk) {
                    $response[] = [
                        'id' => $produk->id,
                        'nama_produk' => $produk->nama_produk,
                        'qty' => $produk->qty,
                        'ssr' => $produk->ssr
                        // Tambahkan kolom lain yang ingin Anda kirim
                    ];
                }
            }
        }

        // Mengembalikan data dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
