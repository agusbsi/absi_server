 <!-- Main content -->
 <section class="content">
   <div class="container-fluid">
     <div class="col-12">
       <div class="card card-info">
         <div class="card-header">
           <h3 class="card-title">
             <li class="fas fa-envelope"></li> Data B.A.P
           </h3>
         </div>
         <div class="card-body">
           <table id="example1" class="table table-bordered table-striped">
             <thead>
               <tr class="text-center">
                 <th>No</th>
                 <th style="width: 16%;">ID Kirim</th>
                 <th>Nama Toko</th>
                 <th>Status</th>
                 <th>Tanggal</th>
                 <th>Menu</th>
               </tr>
             </thead>
             <tbody>
               <?php $no = 0;
                foreach ($list_data as $dd):
                  $no++ ?>
                 <tr>
                   <td><?= $no ?></td>
                   <td>
                     <?= $dd->id_kirim ?>
                   </td>
                   <td>
                     <small>
                       <strong><?= $dd->nama_toko ?></strong> <br>
                       <small><?= $dd->spg ?></small>
                     </small>
                   </td>
                   <td><?= status_bap($dd->status); ?></td>
                   <td><?= date('d F Y', strtotime($dd->created_at)) ?></td>
                   <td>
                     <?php
                      if ($dd->status == 1 && $this->session->userdata('role') == 6) { ?>
                       <a type="button" class="btn btn-success btn-sm" href="<?= base_url('sup/Bap/detail_p/' . $dd->id) ?>" name="btn_detail"> Proses <i class="fa fa-arrow-right"></i></a>
                     <?php } else { ?>
                       <a type="button" class="btn btn-primary btn-sm" href="<?= base_url('sup/Bap/detail_p/' . $dd->id) ?>" name="btn_detail"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
                     <?php } ?>
                   </td>
                 </tr>
               <?php endforeach; ?>
             </tbody>
           </table>
         </div>
       </div>
     </div>
   </div>
 </section>