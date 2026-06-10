<!-- Sidebar -->
<div class="sidebar mo-sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column mo-nav" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="<?= base_url('mng_ops/Dashboard') ?>" class="nav-link <?= ($title == 'Dashboard') ? "active" : "" ?>">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-header">Master Data</li>
      <li class="nav-item">
        <a href="<?= base_url('mng_ops/Dashboard/artikel') ?>" class="nav-link <?= ($title == 'Artikel') ? "active" : "" ?>">
          <i class="nav-icon fas fa-box"></i>
          <p>
            Artikel
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('mng_ops/Dashboard/customer') ?>" class="nav-link <?= ($title == 'Kelola Customer') ? "active" : "" ?>">
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
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('adm/Toko/pengajuanToko') ?>" class="nav-link <?= ($title == 'Pengajuan Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Pengajuan Toko
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
            <a href="<?= base_url('adm/Toko/toko_tutup') ?>" class="nav-link <?= ($title == 'List Toko Tutup') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Toko Tutup
              </p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('mng_ops/Dashboard/user') ?>" class="nav-link <?= ($title == 'user') ? "active" : "" ?>">
          <i class="nav-icon fas fa-users"></i>
          <p>
            Leader & SPG
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Stok/stok_gudang') ?>" class="nav-link <?= ($title == 'Stok Gudang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-warehouse"></i>
          <p>
            Stok Gudang
          </p>
        </a>
      </li>
      <li class="nav-header">Menu Utama</li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Permintaan') ?>" class="nav-link <?= ($title == 'Permintaan Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>
            Permintaan
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Pengiriman') ?>" class="nav-link <?= ($title == 'Pengiriman Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-truck"></i>
          <p>
            Pengiriman
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Retur') ?>" class="nav-link <?= ($title == 'Retur Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-exchange-alt"></i>
          <p>
            Retur
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Mutasi') ?>" class="nav-link <?= ($title == 'Mutasi Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-copy"></i>
          <p>
            Mutasi
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('sup/Bap') ?>" class="nav-link <?= ($title == 'Bap') ? "active" : "" ?>">
          <i class="nav-icon fas fa-envelope"></i>
          <p>B.A.P</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('sup/Penjualan') ?>" class="nav-link <?= ($title == 'Transaksi Penjualan') ? "active" : "" ?>">
          <i class="nav-icon fas fa-shopping-cart"></i>
          <p>
            Transaksi Penjualan
          </p>
        </a>
      </li>

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
        <a href="<?= base_url('mng_ops/Dashboard/adjust_stok') ?>" class="nav-link <?= ($title == 'Adjustment Stok') ? "active" : "" ?>">
          <i class="nav-icon fas fa-window-restore"></i>
          <p>
            Adjustment Stok
          </p>
        </a>
      </li>
      <li class="nav-header">Laporan</li>
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

<style>
  .mo-sidebar {
    background:
      radial-gradient(circle at top left, rgba(20, 184, 166, 0.18), transparent 34%),
      linear-gradient(180deg, #17202a 0%, #111827 52%, #0f172a 100%);
    padding: 10px 0 18px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(148, 163, 184, 0.45) transparent;
    scroll-behavior: smooth;
  }

  .mo-sidebar::-webkit-scrollbar {
    width: 6px;
  }

  .mo-sidebar::-webkit-scrollbar-track {
    background: transparent;
  }

  .mo-sidebar::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.38);
    border-radius: 999px;
  }

  .mo-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.62);
  }

  .mo-nav {
    gap: 2px;
  }

  .mo-nav .nav-header {
    color: rgba(203, 213, 225, 0.78);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.08em;
    margin: 16px 14px 7px;
    padding: 0 4px 8px;
    text-transform: uppercase;
    border-bottom: 1px solid rgba(148, 163, 184, 0.14);
  }

  .mo-nav .nav-header:first-of-type {
    margin-top: 6px;
  }

  .mo-nav .nav-item {
    margin: 1px 0;
  }

  .mo-nav .nav-link {
    position: relative;
    display: flex;
    align-items: center;
    min-height: 42px;
    margin: 2px 10px;
    padding: 10px 12px;
    color: rgba(226, 232, 240, 0.88);
    border-radius: 8px;
    border: 1px solid transparent;
    transition: background-color 220ms ease, border-color 220ms ease, color 220ms ease, transform 220ms ease, box-shadow 220ms ease;
  }

  .mo-nav .nav-link::before {
    content: "";
    position: absolute;
    left: 6px;
    top: 10px;
    bottom: 10px;
    width: 3px;
    border-radius: 99px;
    background: transparent;
    transition: background-color 220ms ease, transform 220ms ease;
    transform: scaleY(0.45);
  }

  .mo-nav .nav-link:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.075);
    border-color: rgba(148, 163, 184, 0.14);
    transform: translateX(3px);
  }

  .mo-nav .nav-link:hover::before {
    background: rgba(20, 184, 166, 0.72);
    transform: scaleY(1);
  }

  .mo-nav .nav-link.active,
  .mo-nav .menu-open > .nav-link {
    color: #ffffff;
    background: rgba(20, 184, 166, 0.16);
    border-color: rgba(45, 212, 191, 0.22);
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.18);
  }

  .mo-nav .nav-link.active::before,
  .mo-nav .menu-open > .nav-link::before {
    background: #2dd4bf;
    transform: scaleY(1);
  }

  .mo-nav .nav-link .nav-icon {
    width: 28px;
    margin: 0 11px 0 0;
    color: rgba(125, 211, 252, 0.82);
    font-size: 15px;
    text-align: center;
    transition: color 220ms ease, transform 220ms ease;
  }

  .mo-nav .nav-link:hover .nav-icon,
  .mo-nav .nav-link.active .nav-icon,
  .mo-nav .menu-open > .nav-link .nav-icon {
    color: #5eead4;
    transform: translateY(-1px);
  }

  .mo-nav .nav-link p {
    display: flex;
    align-items: center;
    flex: 1;
    min-width: 0;
    margin: 0;
    gap: 8px;
    font-size: 14px;
    line-height: 1.25;
    white-space: normal;
  }

  .mo-nav .right {
    margin-left: auto;
  }

  .mo-nav .nav-link .fa-angle-left {
    color: rgba(203, 213, 225, 0.72);
    transition: transform 240ms ease, color 220ms ease;
  }

  .mo-nav .menu-open > .nav-link .fa-angle-left {
    color: #99f6e4;
    transform: rotate(-90deg);
  }

  .mo-nav .badge {
    min-width: 22px;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 7px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
    animation: moBadgePulse 2.4s ease-in-out infinite;
  }

  .mo-nav .nav-treeview {
    margin: 2px 10px 7px 26px;
    padding: 4px 0 4px 9px;
    border-left: 1px solid rgba(148, 163, 184, 0.16);
    animation: moTreeIn 220ms ease;
  }

  .mo-nav .nav-treeview .nav-link {
    min-height: 36px;
    margin: 1px 0 1px 8px;
    padding: 8px 10px;
    color: rgba(203, 213, 225, 0.86);
    background: transparent;
    box-shadow: none;
  }

  .mo-nav .nav-treeview .nav-link::before {
    left: -12px;
    top: 15px;
    bottom: auto;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(148, 163, 184, 0.38);
    transform: none;
  }

  .mo-nav .nav-treeview .nav-link.active::before,
  .mo-nav .nav-treeview .nav-link:hover::before {
    background: #2dd4bf;
  }

  .mo-nav .nav-treeview .nav-icon {
    display: none;
  }

  .mo-nav .nav-treeview .nav-link p {
    font-size: 13px;
  }

  @keyframes moTreeIn {
    from {
      opacity: 0;
      transform: translateY(-4px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes moBadgePulse {
    0%,
    100% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.06);
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .mo-sidebar,
    .mo-nav .nav-link,
    .mo-nav .nav-link::before,
    .mo-nav .nav-link .nav-icon,
    .mo-nav .nav-link .fa-angle-left,
    .mo-nav .badge,
    .mo-nav .nav-treeview {
      animation: none;
      scroll-behavior: auto;
      transition: none;
    }
  }

  @media (max-width: 767.98px) {
    .mo-nav .nav-link {
      margin-left: 8px;
      margin-right: 8px;
      padding-right: 10px;
    }

    .mo-nav .nav-treeview {
      margin-left: 22px;
      margin-right: 8px;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.querySelector('.mo-sidebar');
    var activeLink = document.querySelector('.mo-nav .nav-link.active');

    if (sidebar && activeLink) {
      window.setTimeout(function() {
        sidebar.scrollTo({
          top: Math.max(0, activeLink.offsetTop - 96),
          behavior: 'smooth'
        });
      }, 260);
    }

    document.querySelectorAll('.mo-nav .nav-item > .nav-link[href="#"]').forEach(function(link) {
      link.addEventListener('click', function() {
        var item = link.closest('.nav-item');

        window.setTimeout(function() {
          if (sidebar && item && item.classList.contains('menu-open')) {
            sidebar.scrollTo({
              top: Math.max(0, item.offsetTop - 72),
              behavior: 'smooth'
            });
          }
        }, 180);
      });
    });
  });
</script>
