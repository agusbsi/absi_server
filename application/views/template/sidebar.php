<?php
$id = $this->session->userdata('id');
$Artikel = $this->db->query("SELECT id FROM tb_produk WHERE status = '2'")->num_rows();
$Toko = $this->db->query("SELECT id FROM tb_pengajuan_toko WHERE status = '3'")->num_rows();
$Retur = $this->db->query("SELECT id FROM tb_retur WHERE status = '1'")->num_rows();
$adjust = $this->db->query("SELECT id FROM tb_adjust_stok WHERE status = 4")->num_rows();
$sidebar_notifications = $Artikel + $Toko + $Retur + $adjust;
?>
<!-- Sidebar -->
<div class="adm-sidebar-intro">
    <div class="adm-status-row" aria-label="Ringkasan pekerjaan">
      <span><strong><?= (int) $sidebar_notifications ?></strong> perlu ditinjau</span>
    </div>

    <label class="adm-menu-search" for="admMenuSearch">
      <i class="fas fa-search" aria-hidden="true"></i>
      <input id="admMenuSearch" type="search" placeholder="Cari menu..." autocomplete="off" aria-label="Cari menu sidebar">
      <kbd>/</kbd>
    </label>
    <p class="adm-search-empty" role="status">Menu tidak ditemukan</p>
</div>
<div class="sidebar adm-sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-1" aria-label="Menu administrasi">
    <ul class="nav nav-pills nav-sidebar flex-column adm-nav" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="<?= base_url('adm/Dashboard') ?>" class="nav-link <?= ($title == 'Dashboard') ? "active" : "" ?>">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-header">Master Data</li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Customer') ?>" class="nav-link <?= ($title == 'Kelola Customer') ? "active" : "" ?>">
          <i class="nav-icon fas fa-building"></i>
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
            <a href="<?= base_url('adm/Toko/pengajuanToko') ?>" class="nav-link <?= ($title == 'Pengajuan Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Pengajuan Toko
                <?php if ($Toko == 0) { ?>
                <?php } else { ?>
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
            <a href="<?= base_url('adm/Toko/toko_tutup') ?>" class="nav-link <?= ($title == 'List Toko Tutup') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Toko Tutup
              </p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Area') ?>" class="nav-link <?= ($title == 'Area') ? "active" : "" ?>">
          <i class="nav-icon fas fa-map-marked-alt"></i>
          <p>
            Area
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Produk') ?>" class="nav-link <?= ($title == 'Produk') ? "active" : "" ?>">
          <i class="nav-icon fas fa-box"></i>
          <p>
            Artikel
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
      <li class="nav-item">
        <a href="<?= base_url('hrd/Aset') ?>" class="nav-link <?= ($title == 'Kelola Aset') ? "active" : "" ?>">
          <i class="nav-icon fas fa-cubes"></i>
          <p>
            Aset
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('hrd/User') ?>" class="nav-link <?= ($title == 'Kelola User') ? "active" : "" ?>">
          <i class="nav-icon fas fa-users-cog"></i>
          <p>
            User
          </p>
        </a>
      </li>
      <li class="nav-header">Menu Utama</li>
      <li class="nav-item <?= ($title == 'Management Aset' || $title == 'Histori Aset' || $title == 'Detail Aset') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Management Aset' || $title == 'Histori Aset' || $title == 'Detail Aset') ? "active" : "" ?>">
          <i class="nav-icon fas fa-boxes"></i>
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
          <i class="nav-icon fas fa-clipboard-check"></i>
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
        <a href="<?= base_url('sup/Penjualan') ?>" class="nav-link <?= ($title == 'Transaksi Penjualan') ? "active" : "" ?>">
          <i class="nav-icon fas fa-shopping-cart"></i>
          <p>
            Transaksi Penjualan
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Analist') ?>" class="nav-link <?= ($title == 'Marketing Analist') ? "active" : "" ?>">
          <i class="nav-icon fas fa-chart-line"></i>
          <p>
            Marketing Analist
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Stok/adjust_stok') ?>" class="nav-link <?= ($title == 'Adjustment Stok') ? "active" : "" ?>">
          <i class="nav-icon fas fa-sliders-h"></i>
          <p>
            Adjustment Stok
            <?php if ($adjust != 0) { ?>
              <span class="right badge badge-danger"><?= $adjust ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-header">Laporan</li>
      <li class="nav-item <?= ($title == 'Stok Artikel' || $title == 'Laporan Stok Customer' || $title == 'Kartu Stok' || $title == 'Stok per Toko') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Stok Artikel' || $title == 'Laporan Stok Customer' || $title == 'Kartu Stok') ? "active" : "" ?>">
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
            <a href="<?= base_url('adm/Stok/s_customer') ?>" class="nav-link <?= ($title == 'Laporan Stok Customer') ? "active" : "" ?>">
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
      <!-- <li class="nav-header">Keuangan</li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Keuangan/omset') ?>" class="nav-link <?= ($title == 'Omset') ? "active" : "" ?>">
          <i class="nav-icon fas fa-money-bill-wave"></i>
          <p>
            Omset
          </p>
        </a>
      </li> -->
      <br>
      <br>
    </ul>
  </nav>
</div>

<style>
  .main-sidebar {
    display: flex;
    flex-direction: column;
    background: #111827;
  }

  .adm-brand.brand-link {
    position: relative;
    display: flex;
    align-items: center;
    height: 66px;
    gap: 10px;
    padding: 10px 13px;
    overflow: hidden;
    flex: 0 0 auto;
    background: linear-gradient(135deg, #172331 0%, #111827 65%, #0f2e32 100%);
    border-bottom: 1px solid rgba(148, 163, 184, .13);
    box-shadow: 0 10px 26px rgba(2, 6, 23, .14);
  }

  .adm-brand-monogram {
    position: relative;
    z-index: 1;
    display: grid;
    width: 46px;
    height: 46px;
    flex: 0 0 46px;
    place-items: center;
    overflow: hidden;
    border: 1px solid rgba(94, 234, 212, .30);
    border-radius: 12px;
    background: linear-gradient(145deg, #153642, #0c202a 72%);
    box-shadow: 0 8px 20px rgba(2, 6, 23, .30), inset 0 1px 0 rgba(255, 255, 255, .10);
    transition: transform 260ms cubic-bezier(.34, 1.56, .64, 1), box-shadow 240ms ease;
  }

  .adm-brand-monogram::before {
    position: absolute;
    top: -18px;
    right: -16px;
    width: 42px;
    height: 42px;
    content: "";
    border-radius: 50%;
    background: rgba(45, 212, 191, .18);
    filter: blur(1px);
  }

  .adm-brand-monogram::after {
    position: absolute;
    right: 5px;
    bottom: 5px;
    width: 5px;
    height: 5px;
    content: "";
    border-radius: 50%;
    background: #5eead4;
    box-shadow: 0 0 0 3px rgba(94, 234, 212, .10), 0 0 10px rgba(45, 212, 191, .55);
  }

  .adm-brand-monogram svg {
    position: relative;
    z-index: 1;
    width: 36px;
    height: 36px;
    overflow: visible;
  }

  .adm-logo-box { fill: #99f6e4; }
  .adm-logo-side { fill: #2dd4bf; }
  .adm-logo-face { fill: #0f9f92; }
  .adm-logo-pulse { fill: none; stroke: #e6fffb; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; }

  .adm-brand:hover .adm-brand-monogram {
    transform: translateY(-2px) scale(1.035);
    box-shadow: 0 12px 28px rgba(13, 148, 136, .38), inset 0 1px 0 rgba(255, 255, 255, .32);
  }

  .adm-brand-copy {
    position: relative;
    z-index: 1;
    display: flex;
    min-width: 0;
    flex-direction: column;
    align-items: flex-start;
    line-height: 1;
  }

  .adm-brand-copy strong {
    display: flex;
    align-items: center;
    gap: 7px;
    color: #f8fafc;
    font-size: 23px;
    font-weight: 850;
    line-height: 1.08;
    letter-spacing: 0;
    text-shadow: 0 4px 14px rgba(2, 6, 23, .28);
  }

  .adm-brand-name {
    color: #f8fafc;
    font-size: 22px;
    font-weight: 850;
    letter-spacing: .08em;
  }

  .adm-brand-tag {
    padding: 3px 5px 2px;
    color: #5eead4;
    background: rgba(45, 212, 191, .10);
    border: 1px solid rgba(94, 234, 212, .16);
    border-radius: 4px;
    font-size: 7px;
    font-weight: 800;
    letter-spacing: .09em;
    text-transform: uppercase;
  }

  .adm-brand-copy small {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 3px;
    color: #94a3b8;
    font-size: 9px;
    font-weight: 600;
    letter-spacing: .10em;
    text-transform: uppercase;
  }

  .adm-brand-copy small i {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: #2dd4bf;
    box-shadow: 0 0 0 3px rgba(45, 212, 191, .10);
  }

  .adm-brand-shine {
    position: absolute;
    top: -45px;
    right: -35px;
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(45, 212, 191, .13), transparent 67%);
    pointer-events: none;
  }

  .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .adm-brand {
    justify-content: center;
    padding-right: 8px;
    padding-left: 8px;
  }

  .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .adm-brand-monogram {
    width: 38px;
    height: 38px;
    flex-basis: 38px;
  }

  .adm-sidebar {
    background:
      radial-gradient(circle at top left, rgba(20, 184, 166, 0.18), transparent 34%),
      linear-gradient(180deg, #17202a 0%, #111827 52%, #0f172a 100%);
    padding: 10px 0 18px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(148, 163, 184, 0.45) transparent;
    scroll-behavior: smooth;
  }

  .adm-sidebar::-webkit-scrollbar {
    width: 6px;
  }

  .adm-sidebar::-webkit-scrollbar-track {
    background: transparent;
  }

  .adm-sidebar::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.38);
    border-radius: 999px;
  }

  .adm-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.62);
  }

  .adm-sidebar-intro {
    position: relative;
    z-index: 20;
    flex: 0 0 auto;
    padding: 4px 10px 8px;
    background: linear-gradient(180deg, #0e1723 0%, #0e1723 86%, rgba(14, 23, 35, 0) 100%);
  }

  .adm-user-card {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 11px;
    color: #f8fafc;
    background: linear-gradient(135deg, rgba(255, 255, 255, .10), rgba(255, 255, 255, .045));
    border: 1px solid rgba(255, 255, 255, .11);
    border-radius: 14px;
    box-shadow: 0 12px 30px rgba(2, 6, 23, .16);
    transition: transform 220ms ease, border-color 220ms ease, background 220ms ease;
  }

  .adm-user-card:hover {
    color: #fff;
    text-decoration: none;
    transform: translateY(-2px);
    border-color: rgba(94, 234, 212, .30);
    background: linear-gradient(135deg, rgba(20, 184, 166, .18), rgba(255, 255, 255, .06));
  }

  .adm-avatar-wrap { position: relative; flex: 0 0 auto; }
  .adm-avatar {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid rgba(255, 255, 255, .72);
    box-shadow: 0 5px 14px rgba(2, 6, 23, .28);
  }
  .adm-online-dot {
    position: absolute;
    right: -2px;
    bottom: -1px;
    width: 11px;
    height: 11px;
    border: 2px solid #16212b;
    border-radius: 50%;
    background: #34d399;
    box-shadow: 0 0 0 3px rgba(52, 211, 153, .12);
  }
  .adm-user-copy { display: flex; flex: 1; min-width: 0; flex-direction: column; }
  .adm-user-copy strong { overflow: hidden; font-size: 13px; line-height: 1.3; text-overflow: ellipsis; white-space: nowrap; }
  .adm-user-copy small { overflow: hidden; color: #94a3b8; font-size: 11px; text-overflow: ellipsis; white-space: nowrap; }
  .adm-user-arrow { color: #64748b; font-size: 10px; transition: transform 220ms ease, color 220ms ease; }
  .adm-user-card:hover .adm-user-arrow { color: #5eead4; transform: translateX(2px); }

  .adm-status-row {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding: 9px 3px 8px;
    color: #94a3b8;
    font-size: 10px;
  }
  .adm-status-row strong { color: #fbbf24; font-size: 11px; }
  .adm-status-pill { display: inline-flex; align-items: center; gap: 5px; }
  .adm-status-pill i { width: 6px; height: 6px; border-radius: 50%; background: #34d399; animation: admOnlinePulse 2s ease-out infinite; }

  .adm-menu-search {
    display: flex;
    align-items: center;
    min-height: 38px;
    gap: 9px;
    margin: 1px 0 0;
    padding: 0 10px;
    color: #64748b;
    background: rgba(15, 23, 42, .58);
    border: 1px solid rgba(148, 163, 184, .15);
    border-radius: 10px;
    transition: border-color 180ms ease, box-shadow 180ms ease, background 180ms ease;
  }
  .adm-menu-search:focus-within { color: #5eead4; background: rgba(15, 23, 42, .86); border-color: rgba(45, 212, 191, .48); box-shadow: 0 0 0 3px rgba(20, 184, 166, .10); }
  .adm-menu-search input { flex: 1; min-width: 0; padding: 0; color: #e2e8f0; background: transparent; border: 0; outline: 0; font-size: 12px; }
  .adm-menu-search input::placeholder { color: #64748b; }
  .adm-menu-search kbd { padding: 1px 6px; color: #94a3b8; background: rgba(148, 163, 184, .10); border: 1px solid rgba(148, 163, 184, .15); border-radius: 5px; font: 10px/16px inherit; }
  .adm-search-empty { display: none; margin: 16px 4px 6px; color: #94a3b8; font-size: 12px; text-align: center; }
  .adm-sidebar.is-searching .nav-treeview { display: block !important; }
  .adm-nav .nav-item.adm-filtered,
  .adm-nav .nav-header.adm-filtered { display: none !important; }

  .adm-nav {
    gap: 2px;
  }

  .adm-nav .nav-header {
    color: rgba(203, 213, 225, 0.78);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.08em;
    margin: 16px 14px 7px;
    padding: 0 4px 8px;
    text-transform: uppercase;
    border-bottom: 1px solid rgba(148, 163, 184, 0.14);
  }

  .adm-nav .nav-header:first-of-type {
    margin-top: 6px;
  }

  .adm-nav .nav-item {
    margin: 1px 0;
  }

  .adm-nav .nav-link {
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

  .adm-nav .nav-link::before {
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

  .adm-nav .nav-link:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.075);
    border-color: rgba(148, 163, 184, 0.14);
    transform: translateX(3px);
  }

  .adm-nav .nav-link:hover::before {
    background: rgba(20, 184, 166, 0.72);
    transform: scaleY(1);
  }

  .adm-nav .nav-link.active,
  .adm-nav .menu-open > .nav-link {
    color: #ffffff;
    background: rgba(20, 184, 166, 0.16);
    border-color: rgba(45, 212, 191, 0.22);
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.18);
  }

  .adm-nav .nav-link.active::before,
  .adm-nav .menu-open > .nav-link::before {
    background: #2dd4bf;
    transform: scaleY(1);
  }

  .adm-nav .nav-link .nav-icon {
    width: 28px;
    margin: 0 11px 0 0;
    color: rgba(125, 211, 252, 0.82);
    font-size: 15px;
    text-align: center;
    transition: color 220ms ease, transform 220ms ease;
  }

  .adm-nav .nav-link:hover .nav-icon,
  .adm-nav .nav-link.active .nav-icon,
  .adm-nav .menu-open > .nav-link .nav-icon {
    color: #5eead4;
    transform: translateY(-1px);
  }

  .adm-nav .nav-link p {
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

  .adm-nav .right {
    margin-left: auto;
  }

  .adm-nav .nav-link .fa-angle-left {
    color: rgba(203, 213, 225, 0.72);
    transition: transform 240ms ease, color 220ms ease;
  }

  .adm-nav .menu-open > .nav-link .fa-angle-left {
    color: #99f6e4;
    transform: rotate(-90deg);
  }

  .adm-nav .badge {
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
    animation: admBadgePulse 2.4s ease-in-out infinite;
  }

  .adm-nav .nav-treeview {
    margin: 2px 10px 7px 26px;
    padding: 4px 0 4px 9px;
    border-left: 1px solid rgba(148, 163, 184, 0.16);
    animation: admTreeIn 220ms ease;
  }

  .adm-nav .nav-treeview .nav-link {
    min-height: 36px;
    margin: 1px 0 1px 8px;
    padding: 8px 10px;
    color: rgba(203, 213, 225, 0.86);
    background: transparent;
    box-shadow: none;
  }

  .adm-nav .nav-treeview .nav-link::before {
    left: -12px;
    top: 15px;
    bottom: auto;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(148, 163, 184, 0.38);
    transform: none;
  }

  .adm-nav .nav-treeview .nav-link.active::before,
  .adm-nav .nav-treeview .nav-link:hover::before {
    background: #2dd4bf;
  }

  .adm-nav .nav-treeview .nav-icon {
    display: none;
  }

  .adm-nav .nav-treeview .nav-link p {
    font-size: 13px;
  }

  @keyframes admTreeIn {
    from {
      opacity: 0;
      transform: translateY(-4px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes admBadgePulse {
    0%,
    100% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.06);
    }
  }

  @keyframes admOnlinePulse {
    0% { box-shadow: 0 0 0 0 rgba(52, 211, 153, .45); }
    70%, 100% { box-shadow: 0 0 0 6px rgba(52, 211, 153, 0); }
  }

  /* Floating rounded navigation */
  .adm-brand.brand-link {
    height: 70px;
    padding: 12px 14px;
    background: rgba(14, 23, 35, .96);
    border-bottom-color: rgba(148, 163, 184, .10);
    box-shadow: none;
  }

  .adm-sidebar {
    height: auto !important;
    min-height: 0;
    flex: 1 1 auto;
    padding: 10px 7px 20px;
    background:
      radial-gradient(circle at 82% 5%, rgba(45, 212, 191, .11), transparent 17rem),
      linear-gradient(180deg, #0e1723 0%, #101927 48%, #0c1520 100%);
  }

  .adm-sidebar-intro { padding: 1px 5px 11px; }

  .adm-user-card {
    gap: 10px;
    padding: 10px;
    background: rgba(255, 255, 255, .055);
    border-color: rgba(255, 255, 255, .08);
    border-radius: 15px;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .035);
  }

  .adm-avatar { width: 38px; height: 38px; border-radius: 11px; }

  .adm-status-row {
    margin: 7px 2px 6px;
    padding: 0 2px;
  }

  .adm-menu-search {
    min-height: 40px;
    background: rgba(4, 10, 18, .34);
    border-color: rgba(148, 163, 184, .12);
    border-radius: 12px;
    box-shadow: inset 0 1px 3px rgba(2, 6, 23, .15);
  }

  .adm-nav { gap: 3px; padding: 0 2px; }

  .adm-nav .nav-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 18px 9px 7px;
    padding: 0;
    color: #64748b;
    border: 0;
    font-size: 9px;
    letter-spacing: .14em;
  }

  .adm-nav .nav-header::after {
    height: 1px;
    flex: 1;
    content: "";
    background: linear-gradient(90deg, rgba(148, 163, 184, .17), transparent);
  }

  .adm-nav .nav-item { margin: 0; }

  .adm-nav .nav-link {
    min-height: 46px;
    margin: 2px 0;
    padding: 7px 9px;
    color: #aebaca;
    border: 0;
    border-radius: 13px;
  }

  .adm-nav .nav-link::before { display: none; }

  .adm-nav .nav-link .nav-icon {
    display: inline-grid;
    width: 32px;
    height: 32px;
    flex: 0 0 32px;
    margin: 0 10px 0 0;
    place-items: center;
    color: #8291a5;
    background: rgba(255, 255, 255, .045);
    border: 1px solid rgba(255, 255, 255, .055);
    border-radius: 10px;
    font-size: 13px;
    transition: color 220ms ease, transform 220ms ease, background 220ms ease, box-shadow 220ms ease;
  }

  .adm-nav .nav-link:hover {
    color: #f8fafc;
    background: rgba(255, 255, 255, .055);
    transform: translateX(2px);
  }

  .adm-nav .nav-link:hover .nav-icon {
    color: #c8fff7;
    background: rgba(45, 212, 191, .09);
    border-color: rgba(45, 212, 191, .12);
  }

  .adm-nav .nav-link.active,
  .adm-nav .menu-open > .nav-link {
    color: #ecfdfb;
    background: linear-gradient(105deg, rgba(15, 159, 146, .25), rgba(15, 159, 146, .10));
    border: 1px solid rgba(94, 234, 212, .15);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .06), 0 7px 18px rgba(2, 6, 23, .13);
  }

  .adm-nav .nav-link.active .nav-icon,
  .adm-nav .menu-open > .nav-link .nav-icon {
    color: #062b29;
    background: linear-gradient(145deg, #76eadc, #2dd4bf);
    border-color: rgba(153, 246, 228, .55);
    box-shadow: 0 5px 13px rgba(20, 184, 166, .22);
  }

  .adm-nav .nav-link p { font-size: 13px; font-weight: 550; letter-spacing: -.005em; }
  .adm-nav .badge { height: 19px; min-width: 19px; padding: 0 6px; border: 2px solid rgba(14, 23, 35, .8); box-shadow: none; }

  .adm-nav .nav-treeview {
    margin: 4px 0 7px 21px;
    padding: 5px 5px 5px 14px;
    background: rgba(2, 6, 23, .17);
    border: 0;
    border-radius: 0 0 13px 13px;
  }

  .adm-nav .nav-treeview .nav-link {
    min-height: 36px;
    margin: 1px 0;
    padding: 7px 9px 7px 22px;
    border-radius: 9px;
  }

  .adm-nav .nav-treeview .nav-link::before {
    display: block;
    left: 8px;
    width: 5px;
    height: 5px;
    background: #526174;
  }

  .adm-nav .nav-treeview .nav-link.active {
    color: #ccfbf1;
    background: rgba(45, 212, 191, .09);
    border-color: transparent;
    box-shadow: none;
  }

  .adm-nav .nav-treeview .nav-link.active::before { box-shadow: 0 0 0 4px rgba(45, 212, 191, .10); }

  @media (min-width: 992px) {
    .main-sidebar:hover .adm-sidebar,
    .main-sidebar:not(:hover) .adm-sidebar { border-radius: 0 0 11px 11px; }

    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .adm-sidebar { padding-right: 5px; padding-left: 5px; }
    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .adm-nav .nav-link { justify-content: center; padding-right: 6px; padding-left: 6px; }
    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .adm-nav .nav-icon { margin-right: 0; }
    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .adm-sidebar-intro { display: none; }
  }

  @media (prefers-reduced-motion: reduce) {
    .adm-sidebar,
    .adm-nav .nav-link,
    .adm-nav .nav-link::before,
    .adm-nav .nav-link .nav-icon,
    .adm-nav .nav-link .fa-angle-left,
    .adm-nav .badge,
    .adm-nav .nav-treeview,
    .adm-status-pill i,
    .adm-user-card,
    .adm-user-arrow,
    .adm-brand-monogram {
      animation: none;
      scroll-behavior: auto;
      transition: none;
    }
  }

  @media (max-width: 767.98px) {
    .adm-nav .nav-link {
      margin-left: 8px;
      margin-right: 8px;
      padding-right: 10px;
    }

    .adm-nav .nav-treeview {
      margin-left: 22px;
      margin-right: 8px;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.querySelector('.adm-sidebar');
    var nav = document.querySelector('.adm-nav');
    var searchInput = document.getElementById('admMenuSearch');
    var emptyState = document.querySelector('.adm-search-empty');
    var activeLinks = document.querySelectorAll('.adm-nav .nav-link.active');
    var activeLink = activeLinks.length ? activeLinks[activeLinks.length - 1] : null;

    if (activeLink) {
      activeLink.setAttribute('aria-current', 'page');
    }

    function filterMenu() {
      if (!nav || !searchInput) return;

      var keyword = searchInput.value.toLocaleLowerCase('id-ID').trim();
      var topLevelItems = Array.prototype.filter.call(nav.children, function(child) {
        return child.classList.contains('nav-item');
      });

      sidebar.classList.toggle('is-searching', keyword.length > 0);
      topLevelItems.forEach(function(item) {
        var label = (item.textContent || '').replace(/\s+/g, ' ').toLocaleLowerCase('id-ID');
        item.classList.toggle('adm-filtered', keyword.length > 0 && label.indexOf(keyword) === -1);
      });

      var headers = nav.querySelectorAll(':scope > .nav-header');
      Array.prototype.forEach.call(headers, function(header) {
        var sibling = header.nextElementSibling;
        var hasVisibleItem = false;
        while (sibling && !sibling.classList.contains('nav-header')) {
          if (sibling.classList.contains('nav-item') && !sibling.classList.contains('adm-filtered')) hasVisibleItem = true;
          sibling = sibling.nextElementSibling;
        }
        header.classList.toggle('adm-filtered', keyword.length > 0 && !hasVisibleItem);
      });

      var hasResult = topLevelItems.some(function(item) { return !item.classList.contains('adm-filtered'); });
      if (emptyState) emptyState.style.display = keyword.length > 0 && !hasResult ? 'block' : 'none';
    }

    if (searchInput) {
      searchInput.addEventListener('input', filterMenu);
      searchInput.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
          searchInput.value = '';
          filterMenu();
          searchInput.blur();
        }
      });

      document.addEventListener('keydown', function(event) {
        var target = event.target;
        var isTyping = target && (target.tagName === 'INPUT' || target.tagName === 'TEXTAREA' || target.isContentEditable);
        if (event.key === '/' && !isTyping) {
          event.preventDefault();
          searchInput.focus();
        }
      });
    }

    function scrollMenuIntoView(element, offset) {
      if (!sidebar || !element) {
        return;
      }

      // AdminLTE membungkus sidebar dengan OverlayScrollbars setelah window load.
      // Karena itu, gunakan viewport plugin jika sudah tersedia.
      var scrollContainer = sidebar.querySelector('.os-viewport') || sidebar;
      var containerRect = scrollContainer.getBoundingClientRect();
      var elementRect = element.getBoundingClientRect();

      scrollContainer.scrollTo({
        top: Math.max(0, scrollContainer.scrollTop + elementRect.top - containerRect.top - offset),
        behavior: 'smooth'
      });
    }

    if (sidebar && activeLink) {
      window.addEventListener('load', function() {
        window.setTimeout(function() {
          scrollMenuIntoView(activeLink, 16);
        }, 350);
      });
    }

    document.querySelectorAll('.adm-nav .nav-item > .nav-link[href="#"]').forEach(function(link) {
      link.addEventListener('click', function() {
        var item = link.closest('.nav-item');

        window.setTimeout(function() {
          if (sidebar && item && item.classList.contains('menu-open')) {
            scrollMenuIntoView(item, 16);
          }
        }, 180);
      });
    });
  });
</script>
