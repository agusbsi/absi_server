<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Satu sumber query untuk seluruh dashboard manajemen.
 * Semua nilai transaksi adalah jumlah artikel (qty), bukan jumlah dokumen.
 */
class M_dashboard extends CI_Model
{
    private function periods()
    {
        return array(
            'month_start' => date('Y-m-01 00:00:00'),
            'next_month' => date('Y-m-01 00:00:00', strtotime('+1 month')),
            'previous_month' => date('Y-m-01 00:00:00', strtotime('-1 month')),
            'year_start' => date('Y-01-01 00:00:00')
        );
    }

    public function summary()
    {
        return $this->db->query("SELECT
            (SELECT COUNT(*) FROM tb_user WHERE status = 1) AS total_user,
            (SELECT COUNT(*) FROM tb_produk WHERE status = 1) AS total_produk,
            (SELECT COUNT(*) FROM tb_toko WHERE status = 1 OR status = 7) AS total_toko,
            (SELECT COUNT(*) FROM tb_toko WHERE status = 0) AS total_toko_tutup,
            (SELECT COUNT(*) FROM tb_customer) AS total_customer,
            (SELECT COUNT(*) FROM tb_aset_master) AS total_aset,
            (SELECT COALESCE(SUM(s.qty), 0) FROM tb_stok s
                JOIN tb_toko t ON t.id = s.id_toko
                JOIN tb_produk p ON p.id = s.id_produk
                WHERE s.status = 1 AND t.status != 0 AND p.status = 1) AS stok_toko,
            (SELECT COALESCE(SUM(stok), 0) FROM tb_produk WHERE status = 1) AS stok_gudang")->row();
    }

    public function monthly_activity()
    {
        $p = $this->periods();
        $rows = $this->db->query("SELECT 'minta' jenis, COALESCE(SUM(d.qty_acc),0) total
            FROM tb_permintaan h JOIN tb_permintaan_detail d ON d.id_permintaan=h.id
            WHERE h.created_at >= ? AND h.created_at < ? AND h.status >= 2 AND h.status != 5 AND d.status=1
            UNION ALL SELECT 'kirim', COALESCE(SUM(d.qty),0)
            FROM tb_pengiriman h JOIN tb_pengiriman_detail d ON d.id_pengiriman=h.id
            WHERE h.created_at >= ? AND h.created_at < ?
            UNION ALL SELECT 'jual', COALESCE(SUM(d.qty),0)
            FROM tb_penjualan h JOIN tb_penjualan_detail d ON d.id_penjualan=h.id
            WHERE h.tanggal_penjualan >= ? AND h.tanggal_penjualan < ?
            UNION ALL SELECT 'retur', COALESCE(SUM(d.qty),0)
            FROM tb_retur h JOIN tb_retur_detail d ON d.id_retur=h.id
            WHERE h.created_at >= ? AND h.created_at < ? AND h.status BETWEEN 2 AND 4",
            array($p['month_start'],$p['next_month'],$p['month_start'],$p['next_month'],
                $p['month_start'],$p['next_month'],$p['month_start'],$p['next_month']))->result();
        $result = array('minta'=>0, 'kirim'=>0, 'jual'=>0, 'retur'=>0);
        foreach ($rows as $row) $result[$row->jenis] = (int) $row->total;
        return $result;
    }

    public function transaction_trend($include_request = false)
    {
        $p = $this->periods();
        $series = array('kirim'=>array_fill(0,(int)date('n'),0), 'retur'=>array_fill(0,(int)date('n'),0));
        $queries = array(
            'kirim' => "SELECT MONTH(h.created_at) month,SUM(d.qty) total FROM tb_pengiriman h JOIN tb_pengiriman_detail d ON d.id_pengiriman=h.id WHERE h.created_at>=? AND h.created_at<? GROUP BY MONTH(h.created_at)",
            'retur' => "SELECT MONTH(h.created_at) month,SUM(d.qty) total FROM tb_retur h JOIN tb_retur_detail d ON d.id_retur=h.id WHERE h.created_at>=? AND h.created_at<? AND h.status BETWEEN 2 AND 4 GROUP BY MONTH(h.created_at)"
        );
        if ($include_request) {
            $series['minta'] = array_fill(0,(int)date('n'),0);
            $queries['minta'] = "SELECT MONTH(h.created_at) month,SUM(d.qty_acc) total FROM tb_permintaan h JOIN tb_permintaan_detail d ON d.id_permintaan=h.id WHERE h.created_at>=? AND h.created_at<? AND h.status>=2 AND h.status!=5 AND d.status=1 GROUP BY MONTH(h.created_at)";
        } else {
            $series['jual'] = array_fill(0,(int)date('n'),0);
            $queries['jual'] = "SELECT MONTH(h.tanggal_penjualan) month,SUM(d.qty) total FROM tb_penjualan h JOIN tb_penjualan_detail d ON d.id_penjualan=h.id WHERE h.tanggal_penjualan>=? AND h.tanggal_penjualan<? GROUP BY MONTH(h.tanggal_penjualan)";
        }
        foreach ($queries as $key=>$sql) foreach ($this->db->query($sql,array($p['year_start'],$p['next_month']))->result() as $row) $series[$key][(int)$row->month-1]=(int)$row->total;
        return $series;
    }

    public function sales_performance($limit = 5)
    {
        $p=$this->periods(); $limit=max(1,(int)$limit);
        $two_months_ago = date('Y-m-01 00:00:00', strtotime('-2 months'));
        $stores=$this->db->query("SELECT t.id,t.nama_toko,u.nama_user spg,
            current_sales.total total,current_sales.total total_bulan_ini,
            COALESCE(previous_sales.total,0) total_bulan_lalu
            FROM (SELECT h.id_toko,SUM(d.qty) total FROM tb_penjualan h
              JOIN tb_penjualan_detail d ON d.id_penjualan=h.id
              WHERE h.tanggal_penjualan>=? AND h.tanggal_penjualan<? GROUP BY h.id_toko) current_sales
            JOIN tb_toko t ON t.id=current_sales.id_toko LEFT JOIN tb_user u ON u.id=t.id_spg
            LEFT JOIN (SELECT h.id_toko,SUM(d.qty) total FROM tb_penjualan h
              JOIN tb_penjualan_detail d ON d.id_penjualan=h.id
              WHERE h.tanggal_penjualan>=? AND h.tanggal_penjualan<? GROUP BY h.id_toko) previous_sales
              ON previous_sales.id_toko=current_sales.id_toko
            ORDER BY current_sales.total DESC",
            array($p['previous_month'],$p['month_start'],$two_months_ago,$p['previous_month']))->result();
        $products=$this->db->query("SELECT p.id,p.kode,p.nama_produk,SUM(d.qty) total FROM tb_penjualan h JOIN tb_penjualan_detail d ON d.id_penjualan=h.id JOIN tb_produk p ON p.id=d.id_produk WHERE h.tanggal_penjualan>=? AND h.tanggal_penjualan<? GROUP BY p.id,p.kode,p.nama_produk ORDER BY total DESC",array($p['previous_month'],$p['month_start']))->result();
        return array('top_toko'=>array_slice($stores,0,$limit),'low_toko'=>array_reverse(array_slice($stores,-$limit)),'top_artikel'=>array_slice($products,0,$limit),'low_artikel'=>array_reverse(array_slice($products,-$limit)));
    }

    public function stock_distribution($limit = 10)
    {
        $sql="SELECT t.id,t.nama_toko,u.nama_user spg,COALESCE(SUM(s.qty),0) total FROM tb_stok s JOIN tb_toko t ON t.id=s.id_toko JOIN tb_produk p ON p.id=s.id_produk LEFT JOIN tb_user u ON u.id=t.id_spg WHERE s.status=1 AND t.status=1 AND p.status=1 GROUP BY t.id,t.nama_toko,u.nama_user ORDER BY total DESC";
        if ($limit !== null) $sql .= ' LIMIT '.max(1,(int)$limit);
        return $this->db->query($sql)->result();
    }

    public function stock_distribution_by_supervisor()
    {
        return $this->db->query("SELECT u.nama_user nama,
                COUNT(DISTINCT t.id) total_toko, COALESCE(SUM(s.qty),0) total_stok
            FROM tb_stok s
            JOIN tb_toko t ON t.id=s.id_toko
            JOIN tb_user u ON u.id=t.id_spv
            JOIN tb_produk p ON p.id=s.id_produk
            WHERE s.status=1 AND t.status !=0 AND p.status=1
            GROUP BY u.id,u.nama_user ORDER BY total_stok DESC")->result_array();
    }

    public function suggestions()
    {
        return $this->db->order_by('id', 'DESC')->get('tb_saran')->result();
    }

    /**
     * Bentuk kartu ringkasan yang dipakai view lama. Nilainya selalu berasal
     * dari summary(), sehingga definisi angka antar-role tidak bercabang lagi.
     */
    public function summary_boxes($profile = 'full')
    {
        $summary = $this->summary();
        $definitions = array(
            'toko' => array('total_toko', 'Toko Aktif', 'adm/Toko/', 'fas fa-store'),
            'toko_tutup' => array('total_toko_tutup', 'Toko Tutup', 'adm/Toko/toko_tutup', 'fas fa-store-slash'),
            'customer' => array('total_customer', 'Customer', 'mng_ops/Dashboard/customer', 'fas fa-building'),
            'produk' => array('total_produk', 'Artikel Aktif', 'adm/Produk/', 'fas fa-cube'),
            'user' => array('total_user', 'User Aktif', 'hrd/User/', 'fas fa-users'),
            'aset' => array('total_aset', 'Jenis Aset', 'hrd/Aset', 'fas fa-layer-group'),
            'stok_toko' => array('stok_toko', 'Stok Semua Toko', 'adm/Stok', 'fas fa-chart-pie'),
            'stok_gudang' => array('stok_gudang', 'Stok Gudang Prepedan', 'adm/Stok/stok_gudang', 'fas fa-cubes')
        );
        $profiles = array(
            'full' => array('toko','toko_tutup','customer','produk','user','aset','stok_toko','stok_gudang'),
            'accounting' => array('toko','produk','stok_gudang','aset'),
            'production' => array('toko','produk','stok_toko','stok_gudang')
        );
        $keys = isset($profiles[$profile]) ? $profiles[$profile] : $profiles['full'];
        $boxes = array();
        foreach ($keys as $key) {
            $item = $definitions[$key];
            $boxes[] = (object) array(
                'box' => 'bg-primary',
                'total' => (int) $summary->{$item[0]},
                'title' => $item[1],
                'link' => $item[2],
                'icon' => $item[3]
            );
        }
        return $boxes;
    }

    public function warehouse_stock_distribution($limit = 10)
    {
        $limit = max(1, (int) $limit);
        return $this->db->query("SELECT id,kode,nama_produk,stok
            FROM tb_produk WHERE status=1 ORDER BY stok DESC LIMIT " . $limit)->result_array();
    }

    /** Angka khusus alur verifikasi; transaksi utama tetap memakai satuan qty. */
    public function verification_activity()
    {
        $activity = $this->monthly_activity();
        $p = $this->periods();
        $activity['selisih'] = (int) $this->db->query("SELECT COUNT(*) total
            FROM tb_pengiriman WHERE status=3 AND created_at>=? AND created_at<?",
            array($p['month_start'], $p['next_month']))->row()->total;
        return $activity;
    }

    public function admin_verification_data($limit = 5)
    {
        $limit = max(1, (int) $limit);
        return array(
            'jumlah_permintaan' => $this->db->where('deleted_at IS NULL', null, false)->count_all_results('tb_permintaan'),
            'jumlah_retur' => $this->db->where('deleted_at IS NULL', null, false)->count_all_results('tb_retur'),
            'jumlah_selisih' => $this->db->select('COUNT(id) total')->where('status', 1)->get('tb_pengiriman')->row(),
            'list_minta' => $this->db->select('h.*,t.nama_toko,u.nama_user')->from('tb_permintaan h')
                ->join('tb_toko t', 't.id=h.id_toko')->join('tb_user u', 'u.id=h.id_user')
                ->where('h.status', 1)->order_by('h.id', 'DESC')->limit($limit)->get()->result(),
            'list_retur' => $this->db->select('h.*,t.nama_toko,u.nama_user')->from('tb_retur h')
                ->join('tb_toko t', 't.id=h.id_toko')->join('tb_user u', 'u.id=h.id_user')
                ->where('h.status', 1)->order_by('h.id', 'DESC')->limit($limit)->get()->result(),
            'list_selisih' => $this->db->select('h.*,t.nama_toko,u.nama_user')->from('tb_pengiriman h')
                ->join('tb_toko t', 't.id=h.id_toko')->join('tb_user u', 'u.id=h.id_penerima')
                ->where('h.status', 3)->order_by('h.id', 'DESC')->limit($limit)->get()->result()
        );
    }

    public function as_total($value) { return (object) array('total'=>(int)$value); }
}
