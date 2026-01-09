<?php
$id = $this->session->userdata('id');
$Permintaan = $this->db->query("SELECT * FROM tb_permintaan JOIN tb_toko ON tb_permintaan.id_toko = tb_toko.id JOIN tb_user ON tb_user.id = tb_toko.id_leader WHERE tb_permintaan.status = '0' AND tb_toko.id_leader ='$id'")->num_rows();
$Retur = $this->db->query("SELECT * FROM tb_retur JOIN tb_toko ON tb_retur.id_toko = tb_toko.id JOIN tb_user ON tb_user.id = tb_toko.id_leader WHERE tb_retur.status = '0' AND tb_toko.id_leader ='$id'")->num_rows();
$Bap = $this->db->query("SELECT * FROM tb_bap 
  JOIN tb_toko ON tb_bap.id_toko = tb_toko.id 
  JOIN tb_user ON tb_user.id = tb_toko.id_leader 
  WHERE tb_bap.status = '0' AND tb_toko.id_leader ='$id'")->num_rows();
?>
<!-- Sidebar -->
<div class="sidebar modern-sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column modern-nav" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="<?= base_url('leader/Dashboard') ?>" class="nav-link <?= ($title == 'Dashboard') ? "active" : "" ?>">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-header">Master Data</li>
      <li class="nav-item <?= ($title == 'Kelola Toko' || $title == 'List Toko Tutup') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Kelola Toko' || $title == 'List Toko Tutup') ? "active" : "" ?>">
          <i class="nav-icon fas fa-store"></i>
          <p>
            Toko
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('leader/Toko') ?>" class="nav-link <?= ($title == 'Kelola Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Toko Aktif</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('spv/Toko/toko_tutup') ?>" class="nav-link <?= ($title == 'List Toko Tutup') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Toko Tutup</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('leader/spg') ?>" class="nav-link <?= ($title == 'Kelola User') ? "active" : "" ?>">
          <i class="nav-icon fas fa-users"></i>
          <p>
            Kelola SPG
          </p>
        </a>
      </li>
      <li class="nav-header">Menu Utama</li>
      <li class="nav-item <?= ($title == 'Management Aset' || $title == 'Histori Aset' || $title == 'Detail Aset') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Management Aset' || $title == 'Histori ASET' || $title == 'Detail Aset') ? "active" : "" ?>">
          <i class="nav-icon fas fa-dolly"></i>
          <p>
            Management Aset Toko
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('hrd/Aset/list_aset') ?>" class="nav-link <?= ($title == 'Management Aset') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Bulan ini
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/So/histori_aset') ?>" class="nav-link <?= ($title == 'Histori Aset') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Histori</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item <?= ($title == 'Management Stock Opname' || $title == 'Histori SO' || $title == 'Detail SO') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Management Stock Opname' || $title == 'Histori SO' || $title == 'Detail SO') ? "active" : "" ?>">
          <i class="nav-icon fas fa-file"></i>
          <p>
            Management SO Toko
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('sup/So') ?>" class="nav-link <?= ($title == 'Management Stock Opname') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Bulan ini
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('sup/So/Riwayat_so') ?>" class="nav-link <?= ($title == 'Histori SO') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Histori</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Analist') ?>" class="nav-link <?= ($title == 'Marketing Analist') ? "active" : "" ?>">
          <i class="nav-icon fas fa-flask"></i>
          <p>
            Marketing Analist
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('leader/Permintaan') ?>" class="nav-link <?= ($title == 'Permintaan') ? "active" : "" ?>">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>
            Permintaan
            <?php if ($Permintaan == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Permintaan ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('leader/Pengiriman') ?>" class="nav-link <?= ($title == 'Pengiriman') ? "active" : "" ?>">
          <i class="nav-icon fas fa-truck"></i>
          <p>
            Pengiriman
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('leader/Mutasi') ?>" class="nav-link <?= ($title == 'Mutasi Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-copy"></i>
          <p>
            Mutasi Barang
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('leader/Retur') ?>" class="nav-link <?= ($title == 'Retur') ? "active" : "" ?>">
          <i class="nav-icon fas fa-exchange-alt"></i>
          <p>
            Retur
            <?php if ($Retur == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Retur ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('leader/Bap') ?>" class="nav-link <?= ($title == 'Bap') ? "active" : "" ?>">
          <i class="nav-icon fas fa-envelope"></i>
          <p>
            B.A.P
            <?php if ($Bap == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Bap ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-header">Laporan</li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Stok/stok_gudang') ?>" class="nav-link <?= ($title == 'Stok Gudang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-warehouse"></i>
          <p>
            Stok Gudang
          </p>
        </a>
      </li>
      <li class="nav-item <?= ($title == 'Stok Artikel' || $title == 'Stok Customer' || $title == 'Kartu Stok') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Stok Artikel' || $title == 'Stok Customer' || $title == 'Kartu Stok') ? "active" : "" ?>">
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>
            Stok Toko
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('leader/Stok') ?>" class="nav-link <?= ($title == 'Stok Artikel') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Artikel
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('leader/Stok/s_customer') ?>" class="nav-link <?= ($title == 'Stok Customer') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Customer
              </p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item <?= ($title == 'Penjualan Artikel' || $title == 'Penjualan Toko' || $title == 'Penjualan Customer' || $title == 'Penjualan Periode' || $title == 'Penjualan Area') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Penjualan Artikel' || $title == 'Penjualan Toko' || $title == 'Penjualan Customer' || $title == 'Penjualan Periode' || $title == 'Penjualan Area') ? "active" : "" ?>">
          <i class="nav-icon fas fa-cart-plus"></i>
          <p>
            Penjualan
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('leader/Penjualan/lap_artikel') ?>" class="nav-link <?= ($title == 'Penjualan Artikel') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Artikel
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('leader/Penjualan/lap_toko') ?>" class="nav-link <?= ($title == 'Penjualan Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Toko
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Penjualan/lap_periode') ?>" class="nav-link <?= ($title == 'Penjualan Periode') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Periode
              </p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-header">Akun</li>
      <li class="nav-item">
        <a href="<?= base_url('Profile') ?>" class="nav-link <?= ($title == 'Profile') ? "active" : "" ?>">
          <i class="nav-icon fas fa-user"></i>
          <p>
            Profil
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="javascript:void(0)" class="nav-link" onclick="logout()">
          <i class="nav-icon fas fa-sign-out-alt"></i>
          <p>
            Logout
          </p>
        </a>
      </li>
      <br>
      <br>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

<!-- Modern Sidebar Styles -->
<style>
  /* Modern Sidebar Styling */
  .modern-sidebar {
    background: linear-gradient(180deg, #1a3a52 0%, #2d5a7a 50%, #1a3a52 100%);
    box-shadow: 2px 0 20px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(100, 181, 246, 0.3) transparent;
    padding: 8px 0;
  }

  .modern-sidebar::-webkit-scrollbar {
    width: 6px;
  }

  .modern-sidebar::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 3px;
  }

  .modern-sidebar::-webkit-scrollbar-thumb {
    background: rgba(100, 181, 246, 0.4);
    border-radius: 3px;
  }

  .modern-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(100, 181, 246, 0.6);
  }

  /* Navigation Items */
  .modern-nav .nav-item {
    margin-bottom: 3px;
  }

  .modern-nav .nav-link {
    border-radius: 8px;
    margin: 2px 12px;
    padding: 10px 14px;
    color: rgba(235, 245, 255, 0.92);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    font-size: 14px;
    border-left: 3px solid transparent;
    position: relative;
    line-height: 1.5;
  }

  .modern-nav .nav-link:hover {
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff;
    border-left-color: #64b5f6;
    transform: translateX(2px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  }

  .modern-nav .nav-link.active {
    background: linear-gradient(90deg, rgba(100, 181, 246, 0.25) 0%, rgba(100, 181, 246, 0.15) 100%);
    color: #ffffff;
    border-left-color: #64b5f6;
    font-weight: 500;
    box-shadow: 0 2px 12px rgba(100, 181, 246, 0.3);
  }

  .modern-nav .nav-link .nav-icon {
    font-size: 16px;
    margin-right: 12px;
    color: #90caf9;
    transition: all 0.3s ease;
  }

  .modern-nav .nav-link.active .nav-icon,
  .modern-nav .nav-link:hover .nav-icon {
    color: #ffffff;
    transform: scale(1.1);
  }

  /* Treeview Items */
  .modern-nav .nav-treeview {
    background: rgba(0, 0, 0, 0.15);
    border-radius: 6px;
    margin: 4px 12px;
    padding: 6px 0;
  }

  .modern-nav .nav-treeview .nav-link {
    padding: 8px 12px 8px 40px;
    margin: 2px 8px;
    font-size: 13px;
  }

  .modern-nav .nav-treeview .nav-icon {
    font-size: 8px;
    margin-right: 10px;
  }

  /* Headers */
  .modern-nav .nav-header {
    color: #90caf9;
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    padding: 14px 20px 8px 20px;
    margin-top: 8px;
    border-bottom: 1px solid rgba(100, 181, 246, 0.2);
  }

  /* Angle Icon */
  .modern-nav .nav-link .right {
    transition: transform 0.3s ease;
  }

  .modern-nav .menu-open>.nav-link .right {
    transform: rotate(-90deg);
  }

  /* Badge Styling */
  .modern-nav .badge {
    font-size: 10px;
    padding: 3px 7px;
    border-radius: 10px;
    font-weight: 600;
  }

  /* Smooth Animations */
  .modern-nav .nav-treeview {
    animation: slideDown 0.3s ease-out;
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>