 <!-- Sidebar -->
 <div class="sidebar">
   <!-- Sidebar Menu -->
   <nav class="mt-2">
     <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
       <li class="nav-item">
         <a href="<?= base_url('spv/Dashboard') ?>" class="nav-link <?= ($title == 'Dashboard') ? "active" : "" ?>">
           <i class="nav-icon fas fa-tachometer-alt"></i>
           <p>
             Dashboard
           </p>
         </a>
       </li>
       <li class="nav-header">Master Data</li>
       <li class="nav-item <?= ($title == 'Kelola Toko' || $title == 'List Toko Tutup' || $title == 'Pengajuan Toko') ? "menu-open" : "" ?>">
         <a href="#" class="nav-link <?= ($title == 'Kelola Toko' || $title == 'List Toko Tutup' || $title == 'Pengajuan Toko') ? "active" : "" ?>">
           <i class="nav-icon fas fa-store"></i>
           <p>
             Toko / Cabang
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
         <a href="<?= base_url('spv/Customer') ?>" class="nav-link <?= ($title == 'Kelola Customer') ? "active" : "" ?>">
           <i class="nav-icon fas fa-hotel"></i>
           <p>
             Customer
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

       <li class="nav-header">Laporan</li>
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
             <a href="<?= base_url('spv/Stok') ?>" class="nav-link <?= ($title == 'Stok Artikel') ? "active" : "" ?>">
               <i class="far fa-circle nav-icon"></i>
               <p>
                 Per Artikel
               </p>
             </a>
           </li>
           <li class="nav-item">
             <a href="<?= base_url('spv/Stok/s_customer') ?>" class="nav-link <?= ($title == 'Stok Customer') ? "active" : "" ?>">
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