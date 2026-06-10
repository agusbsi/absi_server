 <!-- Sidebar -->
 <div class="sidebar spv-sidebar">
   <!-- Sidebar Menu -->
   <nav class="mt-2">
     <ul class="nav nav-pills nav-sidebar flex-column spv-nav" data-widget="treeview" role="menu" data-accordion="false">
       <li class="nav-item">
         <a href="<?= base_url('spv/Dashboard') ?>" class="nav-link <?= ($title == 'Dashboard') ? "active" : "" ?>">
           <i class="nav-icon fas fa-tachometer-alt"></i>
           <p>
             Dashboard
           </p>
         </a>
       </li>
       <li class="nav-header">Master Data</li>
       <li class="nav-item">
         <a href="<?= base_url('spv/Customer') ?>" class="nav-link <?= ($title == 'Kelola Customer') ? "active" : "" ?>">
           <i class="nav-icon fas fa-hotel"></i>
           <p>
             Customer
           </p>
         </a>
       </li>
       <li class="nav-item <?= ($title == 'Kelola Toko' || $title == 'List Toko Tutup' || $title == 'Pengajuan Toko') ? "menu-open" : "" ?>">
         <a href="#" class="nav-link <?= ($title == 'Kelola Toko' || $title == 'List Toko Tutup' || $title == 'Pengajuan Toko') ? "active" : "" ?>">
           <i class="nav-icon fas fa-store"></i>
           <p>
             Toko
             <i class="right fas fa-angle-left"></i>
           </p>
         </a>
         <ul class="nav nav-treeview">
           <li class="nav-item">
             <a href="<?= base_url('spv/Toko/pengajuanToko') ?>" class="nav-link <?= ($title == 'Pengajuan Toko') ? "active" : "" ?>">
               <i class="far fa-circle nav-icon"></i>
               <p>Pengajuan Toko</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="<?= base_url('spv/Toko') ?>" class="nav-link <?= ($title == 'Kelola Toko') ? "active" : "" ?>">
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
         <a href="<?= base_url('adm/Stok/stok_gudang') ?>" class="nav-link <?= ($title == 'Stok Gudang') ? "active" : "" ?>">
           <i class="nav-icon fas fa-warehouse"></i>
           <p>
             Stok Gudang
           </p>
         </a>
       </li>
       <li class="nav-item">
         <a href="<?= base_url('spv/User') ?>" class="nav-link <?= ($title == 'Kelola User') ? "active" : "" ?>">
           <i class="nav-icon fas fa-users"></i>
           <p>
             Team Leader
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
       <li class="nav-header">Laporan</li>
       <li class="nav-item <?= ($title == 'Stok Artikel' || $title == 'Laporan Stok Customer' || $title == 'Kartu Stok') ? "menu-open" : "" ?>">
         <a href="#" class="nav-link <?= ($title == 'Stok Artikel' || $title == 'Laporan Stok Customer' || $title == 'Kartu Stok') ? "active" : "" ?>">
           <i class="nav-icon fas fa-chart-pie"></i>
           <p>
             Stok
             <i class="right fas fa-angle-left"></i>
           </p>
         </a>
         <ul class="nav nav-treeview">
           <li class="nav-item">
             <a href="<?= base_url('spv/Stok') ?>" class="nav-link <?= ($title == 'Stok Artikel') ? "active" : "" ?>">
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
             <a href="<?= base_url('spv/Penjualan/lap_artikel') ?>" class="nav-link <?= ($title == 'Penjualan Artikel') ? "active" : "" ?>">
               <i class="far fa-circle nav-icon"></i>
               <p>
                 Per Artikel
               </p>
             </a>
           </li>
           <li class="nav-item">
             <a href="<?= base_url('spv/Penjualan/lap_toko') ?>" class="nav-link <?= ($title == 'Penjualan Toko') ? "active" : "" ?>">
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
       <li class="nav-item">
         <a href="<?= base_url('spv/Permintaan') ?>" class="nav-link <?= ($title == 'Permintaan') ? "active" : "" ?>">
           <i class="nav-icon fas fa-file-alt"></i>
           <p>
             Permintaan
           </p>
         </a>
       </li>
       <li class="nav-item">
         <a href="<?= base_url('spv/Pengiriman') ?>" class="nav-link <?= ($title == 'Pengiriman') ? "active" : "" ?>">
           <i class="nav-icon fas fa-truck"></i>
           <p>
             Pengiriman
           </p>
         </a>
       </li>
       <li class="nav-item">
         <a href="<?= base_url('spv/Retur') ?>" class="nav-link <?= ($title == 'Retur') ? "active" : "" ?>">
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

 <style>
   .spv-sidebar {
     background:
       radial-gradient(circle at top left, rgba(20, 184, 166, 0.18), transparent 34%),
       linear-gradient(180deg, #17202a 0%, #111827 52%, #0f172a 100%);
     padding: 10px 0 18px;
     overflow-y: auto;
     scrollbar-width: thin;
     scrollbar-color: rgba(148, 163, 184, 0.45) transparent;
     scroll-behavior: smooth;
   }

   .spv-sidebar::-webkit-scrollbar {
     width: 6px;
   }

   .spv-sidebar::-webkit-scrollbar-track {
     background: transparent;
   }

   .spv-sidebar::-webkit-scrollbar-thumb {
     background: rgba(148, 163, 184, 0.38);
     border-radius: 999px;
   }

   .spv-sidebar::-webkit-scrollbar-thumb:hover {
     background: rgba(148, 163, 184, 0.62);
   }

   .spv-nav {
     gap: 2px;
   }

   .spv-nav .nav-header {
     color: rgba(203, 213, 225, 0.78);
     font-size: 11px;
     font-weight: 700;
     letter-spacing: 0.08em;
     margin: 16px 14px 7px;
     padding: 0 4px 8px;
     text-transform: uppercase;
     border-bottom: 1px solid rgba(148, 163, 184, 0.14);
   }

   .spv-nav .nav-header:first-of-type {
     margin-top: 6px;
   }

   .spv-nav .nav-item {
     margin: 1px 0;
   }

   .spv-nav .nav-link {
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

   .spv-nav .nav-link::before {
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

   .spv-nav .nav-link:hover {
     color: #ffffff;
     background: rgba(255, 255, 255, 0.075);
     border-color: rgba(148, 163, 184, 0.14);
     transform: translateX(3px);
   }

   .spv-nav .nav-link:hover::before {
     background: rgba(20, 184, 166, 0.72);
     transform: scaleY(1);
   }

   .spv-nav .nav-link.active,
   .spv-nav .menu-open > .nav-link {
     color: #ffffff;
     background: rgba(20, 184, 166, 0.16);
     border-color: rgba(45, 212, 191, 0.22);
     box-shadow: 0 10px 24px rgba(15, 23, 42, 0.18);
   }

   .spv-nav .nav-link.active::before,
   .spv-nav .menu-open > .nav-link::before {
     background: #2dd4bf;
     transform: scaleY(1);
   }

   .spv-nav .nav-link .nav-icon {
     width: 28px;
     margin: 0 11px 0 0;
     color: rgba(125, 211, 252, 0.82);
     font-size: 15px;
     text-align: center;
     transition: color 220ms ease, transform 220ms ease;
   }

   .spv-nav .nav-link:hover .nav-icon,
   .spv-nav .nav-link.active .nav-icon,
   .spv-nav .menu-open > .nav-link .nav-icon {
     color: #5eead4;
     transform: translateY(-1px);
   }

   .spv-nav .nav-link p {
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

   .spv-nav .right {
     margin-left: auto;
   }

   .spv-nav .nav-link .fa-angle-left {
     color: rgba(203, 213, 225, 0.72);
     transition: transform 240ms ease, color 220ms ease;
   }

   .spv-nav .menu-open > .nav-link .fa-angle-left {
     color: #99f6e4;
     transform: rotate(-90deg);
   }

   .spv-nav .badge {
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
     animation: spvBadgePulse 2.4s ease-in-out infinite;
   }

   .spv-nav .nav-treeview {
     margin: 2px 10px 7px 26px;
     padding: 4px 0 4px 9px;
     border-left: 1px solid rgba(148, 163, 184, 0.16);
     animation: spvTreeIn 220ms ease;
   }

   .spv-nav .nav-treeview .nav-link {
     min-height: 36px;
     margin: 1px 0 1px 8px;
     padding: 8px 10px;
     color: rgba(203, 213, 225, 0.86);
     background: transparent;
     box-shadow: none;
   }

   .spv-nav .nav-treeview .nav-link::before {
     left: -12px;
     top: 15px;
     bottom: auto;
     width: 6px;
     height: 6px;
     border-radius: 50%;
     background: rgba(148, 163, 184, 0.38);
     transform: none;
   }

   .spv-nav .nav-treeview .nav-link.active::before,
   .spv-nav .nav-treeview .nav-link:hover::before {
     background: #2dd4bf;
   }

   .spv-nav .nav-treeview .nav-icon {
     display: none;
   }

   .spv-nav .nav-treeview .nav-link p {
     font-size: 13px;
   }

   @keyframes spvTreeIn {
     from {
       opacity: 0;
       transform: translateY(-4px);
     }

     to {
       opacity: 1;
       transform: translateY(0);
     }
   }

   @keyframes spvBadgePulse {
     0%,
     100% {
       transform: scale(1);
     }

     50% {
       transform: scale(1.06);
     }
   }

   @media (prefers-reduced-motion: reduce) {
     .spv-sidebar,
     .spv-nav .nav-link,
     .spv-nav .nav-link::before,
     .spv-nav .nav-link .nav-icon,
     .spv-nav .nav-link .fa-angle-left,
     .spv-nav .badge,
     .spv-nav .nav-treeview {
       animation: none;
       scroll-behavior: auto;
       transition: none;
     }
   }

   @media (max-width: 767.98px) {
     .spv-nav .nav-link {
       margin-left: 8px;
       margin-right: 8px;
       padding-right: 10px;
     }

     .spv-nav .nav-treeview {
       margin-left: 22px;
       margin-right: 8px;
     }
   }
 </style>

 <script>
   document.addEventListener('DOMContentLoaded', function() {
     var sidebar = document.querySelector('.spv-sidebar');
     var activeLink = document.querySelector('.spv-nav .nav-link.active');

     if (sidebar && activeLink) {
       window.setTimeout(function() {
         sidebar.scrollTo({
           top: Math.max(0, activeLink.offsetTop - 96),
           behavior: 'smooth'
         });
       }, 260);
     }

     document.querySelectorAll('.spv-nav .nav-item > .nav-link[href="#"]').forEach(function(link) {
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
