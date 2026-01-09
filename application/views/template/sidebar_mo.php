<!-- Sidebar -->
<div class="sidebar modern-sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column modern-nav" data-widget="treeview" role="menu" data-accordion="false">
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
    background: linear-gradient(90deg, rgba(100, 181, 246, 0.18) 0%, rgba(100, 181, 246, 0.1) 100%);
    color: #ffffff;
    border-left-color: #64b5f6;
    transform: translateX(2px);
    box-shadow: 0 2px 10px rgba(100, 181, 246, 0.25);
  }

  .modern-nav .nav-link.active {
    background: linear-gradient(90deg, rgba(100, 181, 246, 0.3) 0%, rgba(41, 182, 246, 0.18) 100%);
    color: #ffffff;
    border-left-color: #64b5f6;
    box-shadow: 0 3px 12px rgba(100, 181, 246, 0.3), inset 0 0 0 1px rgba(100, 181, 246, 0.25);
    font-weight: 600;
  }

  .modern-nav .nav-link .nav-icon {
    width: 26px;
    margin-right: 12px;
    font-size: 16px;
    text-align: center;
    flex-shrink: 0;
  }

  /* Header Sections */
  .modern-nav .nav-header {
    color: rgba(100, 181, 246, 0.75);
    padding: 16px 18px 8px 18px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-top: 10px;
    border-bottom: 1px solid rgba(100, 181, 246, 0.2);
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
  }

  .modern-nav .nav-header:first-child {
    margin-top: 0;
  }

  /* Badge Styling */
  .modern-nav .badge {
    padding: 4px 8px;
    font-size: 10px;
    border-radius: 10px;
    font-weight: 600;
    animation: pulse 2s infinite;
    margin-left: 4px;
  }

  @keyframes pulse {

    0%,
    100% {
      opacity: 1;
    }

    50% {
      opacity: 0.7;
    }
  }

  /* Treeview Styling */
  .modern-nav .nav-treeview {
    padding-left: 0;
    margin-top: 4px;
    margin-bottom: 4px;
  }

  .modern-nav .nav-treeview .nav-link {
    padding: 8px 14px 8px 48px;
    font-size: 13px;
    margin: 2px 12px;
    border-radius: 6px;
  }

  .modern-nav .nav-treeview .nav-icon {
    font-size: 11px;
    width: 20px;
  }

  .modern-nav .menu-open>.nav-link {
    background: linear-gradient(90deg, rgba(100, 181, 246, 0.15) 0%, rgba(100, 181, 246, 0.08) 100%);
    border-left-color: rgba(100, 181, 246, 0.5);
  }

  .modern-nav .nav-link>.right {
    transition: transform 0.3s ease;
    margin-left: auto;
  }

  .modern-nav .menu-open>.nav-link>.right {
    transform: rotate(-90deg);
  }


  /* Icons Enhancement */
  .modern-nav .nav-link i {
    transition: transform 0.2s ease;
  }

  .modern-nav .nav-link:hover i.nav-icon {
    transform: scale(1.08);
  }

  /* Smooth Scrolling */
  .modern-sidebar {
    scroll-behavior: smooth;
  }

  /* Active Item Highlight Animation */
  @keyframes activeSlide {
    from {
      opacity: 0;
      transform: translateX(-10px);
    }

    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  .modern-nav .nav-link.active {
    animation: activeSlide 0.3s ease;
  }

  /* Spacing between nav items */
  .modern-nav .nav-item>.nav-link>p {
    margin-bottom: 0;
    display: flex;
    align-items: center;
    flex: 1;
    justify-content: space-between;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .modern-nav .nav-link {
      margin: 2px 8px;
      padding: 8px 12px;
    }

    .modern-nav .nav-treeview .nav-link {
      padding-left: 40px;
    }
  }
</style>

<!-- Auto-scroll to Active Menu Script -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Find the active menu item
    const activeLink = document.querySelector('.modern-nav .nav-link.active');

    if (activeLink) {
      // Delay to ensure sidebar is fully rendered and AdminLTE treeview is initialized
      setTimeout(function() {
        // Get sidebar element
        const sidebar = document.querySelector('.modern-sidebar');

        if (sidebar && activeLink) {
          // Get the active link position
          const linkPosition = activeLink.offsetTop;

          // Scroll to make the active item visible at the top of the sidebar
          // with a small offset (80px from top) so user can see it clearly
          const scrollPosition = linkPosition - 80;

          sidebar.scrollTo({
            top: Math.max(0, scrollPosition),
            behavior: 'smooth'
          });
        }
      }, 300);
    }

    // Handle treeview toggle animation
    const treeviewToggles = document.querySelectorAll('.modern-nav [data-widget="treeview"] > .nav-link');
    treeviewToggles.forEach(function(toggle) {
      toggle.addEventListener('click', function(e) {
        const parent = this.parentElement;
        const isOpen = parent.classList.contains('menu-open');

        if (!isOpen) {
          // Scroll to show the opened menu
          setTimeout(function() {
            const sidebar = document.querySelector('.modern-sidebar');
            if (sidebar) {
              const parentPosition = parent.offsetTop;
              sidebar.scrollTo({
                top: Math.max(0, parentPosition - 80),
                behavior: 'smooth'
              });
            }
          }, 100);
        }
      });
    });
  });
</script>