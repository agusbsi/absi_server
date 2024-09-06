 <section class="content">
   <div class="container-fluid">
     <div class="row">
       <div class="col-md-3">
         <div class="card card-info card-outline">
           <div class="card-body box-profile">
             <div class="text-center">
               <?php if ($toko->foto_toko == "") {
                ?>
                 <img style="width: 100%;" class="profile-user-img img-responsive img-rounded" src="<?php echo base_url() ?>assets/img/toko/hicoop.png" alt="User profile picture">
               <?php
                } else { ?>
                 <img style="width: 100%;" class="profile-user-img img-responsive img-rounded" src="<?php echo base_url('assets/img/toko/' . $toko->foto_toko) ?>" alt="User profile picture">
               <?php } ?>
             </div>
             <h3 class="profile-username text-center"><strong><?= $toko->nama_toko ?></strong></h3>
             <div class="card-body">
               <strong><i class="fa fa-phone"></i> Telp</strong>
               <p class="text-muted"><?= $toko->telp ?></p>
               <hr>
               <strong><i class="fa fa-map"></i> Alamat</strong>
               <address><small class="text-muted"><?= $toko->alamat ?></small></address>
               <hr>
             </div>
           </div>
         </div>
       </div>
       <div class="col-md-9">
         <div class="card card-info">
           <div class="card-header">
             <h3 class="card-title">
               <li class="fas fa-box"></li> Stok Artikel
             </h3>
           </div>
           <div class="card-body">
             <div class="tab-content">
               <table id="example1" class="table table-bordered table-striped">
                 <thead>
                   <tr>
                     <th class="text-center">No</th>
                     <th>Artikel</th>
                     <th class="text-center">Stok</th>
                   </tr>
                 </thead>
                 <tbody>
                   <tr>
                     <?php
                      $no = 0;
                      $total = 0;
                      foreach ($stok_produk as $stok) {
                        $no++
                      ?>
                       <td class="text-center"><?= $no ?></td>
                       <td>
                         <small>
                           <strong><?= $stok->kode ?></strong> <br>
                           <?= $stok->nama_produk ?> | <?= $stok->satuan ?>
                         </small>
                       </td>
                       <td class="text-center"><?= $stok->qty ?></td>
                   </tr>
                 <?php
                        $total += $stok->qty;
                      } ?>

                 </tbody>
                 <tfoot>
                   <tr>
                     <td colspan="3" class="text-center"> <strong>Total :</strong> <b><?= $total; ?></b></td>
                   </tr>
                 </tfoot>
               </table>
             </div>
           </div>
           <div class="card-footer text-right">
             <a href="<?= base_url('spg/Dashboard') ?>" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left"></i> Dashboard</a>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>