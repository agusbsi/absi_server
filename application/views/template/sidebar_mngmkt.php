<?php
$id = $this->session->userdata('id');
$Artikel = $this->db->query("SELECT id FROM tb_stok WHERE status = '2'")->num_rows();
$Toko = $this->db->query("SELECT id FROM tb_pengajuan_toko WHERE status = '0'")->num_rows();
$Retur = $this->db->query("SELECT id FROM tb_retur WHERE status = '1'")->num_rows();
?>
<!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="<?= base_url('mng_mkt/Dashboard') ?>" class="nav-link <?= ($title == 'Dashboard') ? "active" : "" ?>">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-header">Master Data</li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Customer') ?>" class="nav-link <?= ($title == 'Kelola Customer') ? "active" : "" ?>">
          <i class="nav-icon fas fa-hotel"></i>
          <p>
            Customer
          </p>
        </a>
      </li>
      <li class="nav-item <?= ($title == 'Toko' || $title == 'List Toko Tutup' || $title == 'Pengajuan Toko') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Toko' || $title == 'List Toko Tutup' || $title == 'Pengajuan Toko') ? "active" : "" ?>">
          <i class="nav-icon fas fa-store"></i>
          <p>
            Toko
            <i class="right fas fa-angle-left"></i>
            <?php if ($Toko != 0) { ?>
              <span class="right badge badge-danger"><?= $Toko ?></span>
            <?php } ?>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('mng_mkt/Toko/pengajuanToko') ?>" class="nav-link <?= ($title == 'Pengajuan Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Pengajuan Toko
                <?php if ($Toko != 0) { ?>
                  <span class="right badge badge-danger"><?= $Toko ?></span>
                <?php } ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/toko') ?>" class="nav-link <?= ($title == 'Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Toko Aktif</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('mng_mkt/Toko/toko_tutup') ?>" class="nav-link <?= ($title == 'List Toko Tutup') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Toko Tutup
              </p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Area') ?>" class="nav-link <?= ($title == 'Area') ? "active" : "" ?>">
          <i class="nav-icon fas fa-map"></i>
          <p>
            Area
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('mng_mkt/user') ?>" class="nav-link <?= ($title == 'User') ? "active" : "" ?>">
          <i class="nav-icon fas fa-user"></i>
          <p>
            User
          </p>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a href="<?= base_url('mng_mkt/promo') ?>" class="nav-link <?= ($title == 'Management Promo') ? "active" : "" ?>">
          <i class="nav-icon fas fa-percent"></i>
          <p>
            Promo
          </p>
        </a>
      </li> -->
      <li class="nav-header">Menu Utama</li>
      <li class="nav-item">
        <a href="<?= base_url('mng_mkt/Artikel') ?>" class="nav-link <?= ($title == 'Artikel Baru') ? "active" : "" ?>">
          <i class="nav-icon fas fa-box"></i>
          <p>
            Pengajuan Artikel
            <?php if ($Artikel == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Artikel ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('mng_mkt/Retur/retur') ?>" class="nav-link <?= ($title == 'Retur Barang') ? "active" : "" ?>">
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
        <a href="<?= base_url('adm/Analist') ?>" class="nav-link <?= ($title == 'Marketing Analist') ? "active" : "" ?>">
          <i class="nav-icon fas fa-flask"></i>
          <p>
            Marketing Analist
          </p>
        </a>
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

      <li class="nav-header">Laporan</li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Stok/stok_gudang') ?>" class="nav-link <?= ($title == 'Stok Gudang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-warehouse"></i>
          <p>
            Stok Gudang
          </p>
        </a>
      </li>
      <li class="nav-item <?= ($title == 'Stok Artikel' || $title == 'Stok Customer' || $title == 'Kartu Stok' || $title == 'Stok per Toko') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Stok Artikel' || $title == 'Stok Customer' || $title == 'Kartu Stok') ? "active" : "" ?>">
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>
            Stok Toko
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('adm/Stok') ?>" class="nav-link <?= ($title == 'Stok Artikel') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Artikel
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Stok/s_customer') ?>" class="nav-link <?= ($title == 'Stok Customer') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Customer
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Stok/s_toko') ?>" class="nav-link <?= ($title == 'Stok per Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Toko
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Stok/kartu_stok') ?>" class="nav-link <?= ($title == 'Kartu Stok') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Kartu Stok
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
            <a href="<?= base_url('adm/Penjualan/lap_artikel') ?>" class="nav-link <?= ($title == 'Penjualan Artikel') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Artikel
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Penjualan/lap_toko') ?>" class="nav-link <?= ($title == 'Penjualan Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Toko
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Penjualan/lap_cust') ?>" class="nav-link <?= ($title == 'Penjualan Customer') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Customer
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Penjualan/lap_area') ?>" class="nav-link <?= ($title == 'Penjualan Area') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Area
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
</div>