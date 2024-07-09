<?php
$Permintaan = $this->db->query("SELECT id FROM tb_permintaan WHERE status = '1'")->num_rows();
$Selisih = $this->db->query("SELECT id FROM tb_pengiriman WHERE status = '3'")->num_rows();
$Pengiriman = $this->db->query("SELECT id FROM tb_pengiriman WHERE status = '0'")->num_rows();
$Retur = $this->db->query("SELECT id FROM tb_retur WHERE status = '1'")->num_rows();
$TokoTutup = $this->db->query("SELECT id FROM tb_retur WHERE status = '10'")->num_rows();
$Mutasi = $this->db->query("SELECT id FROM tb_mutasi WHERE status = '0'")->num_rows();
$Bap = $this->db->query("SELECT * FROM tb_bap 
  JOIN tb_toko ON tb_bap.id_toko = tb_toko.id 
  JOIN tb_user ON tb_user.id = tb_toko.id_leader 
  WHERE tb_bap.status = '1' ")->num_rows();
?>
<!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="<?= base_url('sup/dashboard') ?>" class="nav-link <?= ($title == 'Dashboard') ? "active" : "" ?>">
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
      <li class="nav-item <?= ($title == 'Toko' || $title == 'List Toko Tutup') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Toko' || $title == 'List Toko Tutup') ? "active" : "" ?>">
          <i class="nav-icon fas fa-store"></i>
          <p>
            Toko
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('adm/toko') ?>" class="nav-link <?= ($title == 'Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Toko Aktif</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('sup/Toko/toko_tutup') ?>" class="nav-link <?= ($title == 'List Toko Tutup') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Toko Tutup
                <?php if ($TokoTutup == 0) { ?>
                <?php } else { ?>
                  <span class="right badge badge-danger"><?= $TokoTutup ?></span>
                <?php } ?>
              </p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Produk') ?>" class="nav-link <?= ($title == 'Produk') ? "active" : "" ?>">
          <i class="nav-icon fas fa-box"></i>
          <p>
            Artikel
          </p>
        </a>
      </li>
      <li class="nav-header">Menu Utama</li>

      <li class="nav-item">
        <a href="<?= base_url('sup/permintaan') ?>" class="nav-link <?= ($title == 'Permintaan Barang') ? "active" : "" ?>">
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
        <a href="<?= base_url('sup/Pengiriman') ?>" class="nav-link <?= ($title == 'Pengiriman Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-truck"></i>
          <p>
            Pengiriman
            <?php if ($Pengiriman == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Pengiriman ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('sup/Penjualan') ?>" class="nav-link <?= ($title == 'Transaksi Penjualan') ? "active" : "" ?>">
          <i class="nav-icon fas fa-shopping-cart"></i>
          <p>
            Penjualan
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('sup/retur') ?>" class="nav-link <?= ($title == 'Retur Barang') ? "active" : "" ?>">
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
        <a href="<?= base_url('sup/Bap') ?>" class="nav-link <?= ($title == 'Bap') ? "active" : "" ?>">
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
      <li class="nav-item">
        <a href="<?= base_url('sup/Mutasi') ?>" class="nav-link <?= ($title == 'Mutasi Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-copy"></i>
          <p>
            Mutasi Barang
            <?php if ($Mutasi == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Mutasi ?></span>
            <?php } ?>
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
      <li class="nav-item <?= ($title == 'Stok Artikel' || $title == 'Stok Customer' || $title == 'Kartu Stok') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Stok Artikel' || $title == 'Stok Customer' || $title == 'Kartu Stok') ? "active" : "" ?>">
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>
            Stok
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
            <a href="<?= base_url('adm/Stok/kartu_stok') ?>" class="nav-link <?= ($title == 'Kartu Stok') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Kartu Stok
              </p>
            </a>
          </li>

        </ul>
      </li>
      <li class="nav-item <?= ($title == 'Penjualan Artikel' || $title == 'Penjualan Toko' || $title == 'Penjualan Customer' || $title == 'Penjualan Periode') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Penjualan Artikel' || $title == 'Penjualan Toko' || $title == 'Penjualan Customer' || $title == 'Penjualan Periode') ? "active" : "" ?>">
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
            <a href="<?= base_url('adm/Penjualan/lap_periode') ?>" class="nav-link <?= ($title == 'Penjualan Periode') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Periode
              </p>
            </a>
          </li>

        </ul>
      </li>
      <li class="nav-header">Integrasi Easy Accounting</li>
      <li class="nav-item">
        <a href="<?= base_url('template/Sales_Invoice') ?>" class="nav-link <?= ($title == 'Sales Invoice') ? "active" : "" ?>">
          <i class="nav-icon fas fa-shopping-cart"></i>
          <p>
            Sales Invoice
          </p>
        </a>
      </li>
      <li class="nav-header">Akun</li>
      <li class="nav-item">
        <a href="<?= base_url('profile') ?>" class="nav-link <?= ($title == 'Profile') ? "active" : "" ?>">
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