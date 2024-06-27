     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
         <div class="row">
           <div class="col-12">

             <!-- /.card -->

             <div class="card card-info">
               <div class="card-header">
                 <h3 class="card-title">
                   <li class="fas fa-hospital"></li> Data Customer
                 </h3>
               </div>
               <!-- /.card-header -->
               <div class="card-body">

                 <table id="example1" class="table table-bordered table-striped">
                   <thead>
                     <tr class="text-center">
                       <th style="width: 2%">No</th>
                       <th>Customer</th>
                       <th>Telp</th>
                       <th>Toko</th>
                       <th style="width: 10%">Menu</th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php
                      $no = 0;
                      foreach ($customer as $dd) :
                        $no++; ?>
                       <tr>
                         <td class="text-center"><?= $no ?></td>
                         <td>
                           <small>
                             <strong><?= $dd->nama_cust ?></strong> <br>
                             Alamat : <br> <?= $dd->alamat_cust ?>
                           </small>
                         </td>
                         <td class="text-center"><?= $dd->telp ?></td>
                         <td class="text-center"><?= $dd->total_toko ?></td>
                         <td class="text-center"><a href="<?= base_url('spv/Customer/detail/' . $dd->id) ?>" class="btn btn-info btn-sm">Detail</a></td>
                       </tr>
                     <?php endforeach; ?>
                   </tbody>
                   <tfoot>
                     <tr>
                       <th colspan="5"></th>
                     </tr>
                   </tfoot>
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