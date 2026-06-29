<?php
$id = $this->session->userdata('id');
$id_toko = $this->session->userdata('id_toko');
$Penerimaan = $this->db->query("SELECT * FROM tb_pengiriman WHERE status = '1' AND id_toko ='$id_toko'")->num_rows();
$Mutasi = $this->db->query("SELECT * FROM tb_mutasi WHERE status = '1' AND id_toko_tujuan ='$id_toko'")->num_rows();
$bap = $this->db->query("SELECT * FROM tb_pengiriman WHERE status = '3' AND id_toko ='$id_toko' AND id NOT IN(SELECT id_kirim FROM tb_bap WHERE status != '4')")->num_rows();
?>
<!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-header">Menu Utama</li>
      <li class="nav-item">
        <a href="<?= base_url('spg/dashboard') ?>" class="nav-link <?= ($title == 'Dashboard') ? "active" : "" ?>">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('spg/Dashboard/toko_spg') ?>" class="nav-link <?= ($title == 'Toko spg') ? "active" : "" ?>">
          <i class="nav-icon fas fa-store"></i>
          <p>
            Toko Anda
          </p>
        </a>
      </li>
      <li class="nav-header">Transaksi</li>
      <li class="nav-item">
        <a href="<?= base_url('spg/permintaan') ?>" class="nav-link <?= ($title == 'Permintaan Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>
            Permintaan Artikel
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('spg/Penerimaan') ?>" class="nav-link <?= ($title == 'Penerimaan Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-check-circle"></i>
          <p>
            Penerimaan Artikel
            <?php if ($Penerimaan == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Penerimaan ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('spg/penjualan') ?>" class="nav-link <?= ($title == 'Penjualan') ? "active" : "" ?>">
          <i class="nav-icon fas fa-cart-plus"></i>
          <p>
            Penjualan
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('spg/retur') ?>" class="nav-link <?= ($title == 'Retur Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-exchange-alt"></i>
          <p>
            Retur
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('spg/Mutasi') ?>" class="nav-link <?= ($title == 'Mutasi Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-copy"></i>
          <p>
            Terima Mutasi
            <?php if ($Mutasi == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Mutasi ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('spg/Bap/selisih') ?>" class="nav-link <?= ($title == 'Selisih') ? "active" : "" ?>">
          <i class="nav-icon fas fa-not-equal"></i>
          <p>
            Selisih Data
            <?php if ($bap == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $bap ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('spg/Bap') ?>" class="nav-link <?= ($title == 'Bap') ? "active" : "" ?>">
          <i class="nav-icon fas fa-envelope"></i>
          <p>
            BAP

          </p>
        </a>
      </li>
      <li class="nav-header">Kelola</li>
      <li class="nav-item">
        <a href="<?= base_url('spg/Aset') ?>" class="nav-link <?= ($title == 'Aset') ? "active" : "" ?>">
          <i class="nav-icon fas fa-clinic-medical"></i>
          <p>
            Update Aset
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('spg/Stok_opname') ?>" class="nav-link <?= ($title == 'Stok Opname') ? "active" : "" ?>">
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>
            Stok Opname
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

<!-- Bottom navigation khusus tampilan mobile -->
<style>
  .spg-bottom-nav {
    display: none;
  }

  @media (max-width: 767.98px) {
    .content-wrapper {
      padding-bottom: calc(82px + env(safe-area-inset-bottom));
    }

    .spg-bottom-nav {
      position: fixed;
      right: 0;
      bottom: calc(8px + env(safe-area-inset-bottom));
      left: 0;
      z-index: 1040;
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      align-items: end;
      width: calc(100% - 40px);
      max-width: 330px;
      height: 58px;
      margin: 0 auto;
      padding: 0 6px;
      background: rgba(255, 255, 255, .97);
      border: 1px solid rgba(15, 23, 42, .08);
      border-radius: 18px;
      box-shadow: 0 8px 24px rgba(15, 23, 42, .16);
      -webkit-backdrop-filter: blur(12px);
      backdrop-filter: blur(12px);
    }

    .spg-bottom-nav__item {
      position: relative;
      display: flex;
      min-width: 0;
      height: 54px;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 3px;
      color: #8a94a6;
      font-size: 10px;
      font-weight: 600;
      line-height: 1;
      text-decoration: none !important;
      transition: color .2s ease, transform .2s ease;
      -webkit-tap-highlight-color: transparent;
    }

    .spg-bottom-nav__item > i {
      font-size: 17px;
    }

    .spg-bottom-nav__item:hover,
    .spg-bottom-nav__item:focus,
    .spg-bottom-nav__item.active {
      color: #1677ff;
    }

    .spg-bottom-nav__item.active::after {
      position: absolute;
      bottom: 2px;
      width: 4px;
      height: 4px;
      content: '';
      background: #1677ff;
      border-radius: 50%;
    }

    .spg-bottom-nav__item--store {
      align-self: start;
      height: 73px;
      margin-top: -23px;
      color: #526070;
    }

    .spg-bottom-nav__store-icon {
      display: flex;
      width: 50px;
      height: 50px;
      align-items: center;
      justify-content: center;
      color: #fff;
      background: linear-gradient(135deg, #1677ff 0%, #00b8d9 100%);
      border: 4px solid #fff;
      border-radius: 50%;
      box-shadow: 0 6px 16px rgba(22, 119, 255, .32);
      transition: transform .2s ease, box-shadow .2s ease;
    }

    .spg-bottom-nav__store-icon i {
      font-size: 18px;
    }

    .spg-bottom-nav__item--store:hover .spg-bottom-nav__store-icon,
    .spg-bottom-nav__item--store:focus .spg-bottom-nav__store-icon,
    .spg-bottom-nav__item--store.active .spg-bottom-nav__store-icon {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(22, 119, 255, .42);
    }

    .spg-bottom-nav__item--store.active::after {
      display: none;
    }

    .spg-bottom-nav__item--store.active .spg-bottom-nav__label {
      color: #1677ff;
    }
  }
</style>

<nav class="spg-bottom-nav no-print" aria-label="Navigasi utama SPG">
  <a
    href="<?= base_url('spg/dashboard') ?>"
    class="spg-bottom-nav__item <?= ($title == 'Dashboard') ? 'active' : '' ?>"
    <?= ($title == 'Dashboard') ? 'aria-current="page"' : '' ?>>
    <i class="fas fa-home" aria-hidden="true"></i>
    <span class="spg-bottom-nav__label">Home</span>
  </a>

  <a
    href="<?= base_url('spg/Dashboard/toko_spg') ?>"
    class="spg-bottom-nav__item spg-bottom-nav__item--store <?= ($title == 'Toko spg') ? 'active' : '' ?>"
    <?= ($title == 'Toko spg') ? 'aria-current="page"' : '' ?>>
    <span class="spg-bottom-nav__store-icon">
      <i class="fas fa-store" aria-hidden="true"></i>
    </span>
    <span class="spg-bottom-nav__label">Toko</span>
  </a>

  <a
    href="<?= base_url('profile') ?>"
    class="spg-bottom-nav__item <?= ($title == 'Profile') ? 'active' : '' ?>"
    <?= ($title == 'Profile') ? 'aria-current="page"' : '' ?>>
    <i class="fas fa-user" aria-hidden="true"></i>
    <span class="spg-bottom-nav__label">Profil</span>
  </a>
</nav>
