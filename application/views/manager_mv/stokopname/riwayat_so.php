     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
         <div class="row">
           <div class="col-12">
             <div class="card card-info">
               <div class="card-header">
                 <h3 class="card-title">
                   <li class="fas fa-file-alt"></li> Riwayat Stok Opname Toko
                 </h3>
                 <div class="card-tools">
                   <a href="<?= base_url('sup/So') ?>" class="btn btn-tool">
                     <i class="fas fa-times"></i>
                   </a>
                 </div>
               </div>
               <div class="card-body">
                 <table id="example1" class="table table-bordered table-striped">
                   <thead>
                     <tr class="text-center">
                       <th>No</th>
                       <th>Nama Toko</th>
                       <th>Periode</th>
                       <th>Tgl SO</th>
                       <th>Dibuat</th>
                       <th>Menu</th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php
                      $no = 0;
                      foreach ($list_so as $s) :
                        $no++; ?>
                       <tr>
                         <td class="text-center"><?= $no ?></td>
                         <td><?= $s->nama_toko ?></td>
                         <td class="text-center">
                           <span class="badge badge-sm badge-warning"><?= $s->periode ?></span>
                         </td>
                         <td class="text-center"><?= date('d M Y', strtotime($s->tgl_so)) ?></td>
                         <td class="text-center"><?= date('d M Y', strtotime($s->dibuat)) ?></td>
                         <td class="text-center">
                           <a href="<?= base_url('sup/So/riwayat_so_toko/' . $s->id_toko . '/' . $s->id) ?>" class="btn btn-sm btn-info mr-3">Lihat <i class="fas fa-arrow-circle-right"></i> </a>
                         </td>
                       </tr>
                     <?php endforeach ?>
                   </tbody>
                 </table>
               </div>
             </div>
           </div>
         </div>
       </div>
     </section>