     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
         <div class="row">
           <div class="col-12">

             <!-- /.card -->

             <div class="card card-info">
               <div class="card-header">
                 <h3 class="card-title">
                   <li class="fas fa-file"></li> Data Permintaan Barang
                 </h3>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                 <table id="example1" class="table table-bordered table-striped">
                   <thead>
                     <tr class="text-center">
                       <th>No</th>
                       <th style="width: 15%;">ID PO</th>
                       <th>Status</th>
                       <th>Nama Toko</th>
                       <th>Tanggal</th>
                       <th>Menu</th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php $no = 0;
                      foreach ($list_data as $dd) :
                        $no++ ?>
                       <tr class="text-center">
                         <td><?= $no ?></td>
                         <td><?= $dd->id ?></td>
                         <td>
                           <?= status_permintaan($dd->status); ?>
                         </td>
                         <td><?= $dd->nama_toko ?></td>

                         <td><?= date('d-M-Y H:m:s', strtotime($dd->created_at)) ?></td>
                         <td>
                           <?php
                            if ($dd->status == 0) { ?>
                             <a type="button" class="btn btn-success btn-sm" href="<?= base_url('leader/permintaan/terima/' . $dd->id) ?>" name="btn_detail"><i class="fa fa-paper-plane" aria-hidden="true"></i> Proses</a>
                           <?php } else { ?>
                             <a type="button" class="btn btn-primary btn-sm" href="<?= base_url('leader/permintaan/detail/' . $dd->id) ?>" name="btn_detail"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
                           <?php } ?>
                         </td>
                       </tr>
                     <?php endforeach; ?>
                   </tbody>
                 </table>
               </div>
               <!-- /.card-body -->
             </div>
             <!-- /.card -->
           </div>
           <!-- /.col -->
         </div>
         <!-- /.row -->
       </div>
       <!-- /.container-fluid -->
     </section>