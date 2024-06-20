 <!-- Main content -->
 <section class="content">
   <div class="container-fluid">
     <div class="row">
       <div class="col-12">
         <div class="card card-info">
           <div class="card-header">
             <h3 class="card-title">
               <li class="fas fa-cube"></li> Data Permintaan
             </h3>
           </div>
           <div class="card-body">
             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr class="text-center">
                   <th style="width: 2%">#</th>
                   <th>Nomor PO</th>
                   <th>Status</th>
                   <th>Toko</th>
                   <th>Tgl Update</th>
                   <th>Menu</th>
                 </tr>
               </thead>
               <tbody>
                 <?php
                  $no = 0;
                  foreach ($list as $data) :
                    $no++; ?>
                   <tr>
                     <td class="text-center"><?= $no ?></td>
                     <td class="text-center"><?= $data->id ?></td>
                     <td class="text-center">
                       <?php
                        status_permintaan($data->status);
                        ?>
                     </td>
                     <td><?= $data->nama_toko ?></td>
                     <td class="text-center"><?= date('d-M-Y H:m:s', strtotime($data->created_at)) ?></td>
                     <td class="text-center">
                       <?php
                        if ($data->status == 1) {
                        ?>
                         <a class="btn btn-success btn-sm" href="<?= base_url('sup/permintaan/terima/' . $data->id) ?>"><i class="fas fa-paper-plane"></i> Proses</a>
                       <?php
                        } else {
                        ?>
                         <a class="btn btn-primary btn-sm" href="<?= base_url('sup/permintaan/detail/' . $data->id) ?>"><i class="fas fa-eye"></i> Detail</a>
                       <?php }
                        ?>
                     </td>
                   </tr>
                 <?php endforeach; ?>
               </tbody>
             </table>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>