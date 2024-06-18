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
                     <tr>
                       <th style="width: 2%">No</th>
                       <th>Kode</th>
                       <th>Customer</th>
                       <th>Telephone</th>
                       <th>Jml Toko</th>
                       <th style="width: 10%">Menu</th>
                     </tr>
                   </thead>
                   <tbody>
                     <tr>
                       <?php if (!empty($customer)) { ?>
                         <?php $no = 1; ?>
                         <?php foreach ($customer as $dd) : ?>
                           <td><?= $no ?></td>
                           <td>
                             <small><?= $dd->kode_customer ?></small>
                           </td>
                           <td>
                             <small><strong><?= $dd->nama_cust ?></strong>
                               <br>
                               Alamat : <?= $dd->alamat_cust ?>
                             </small>
                           </td>
                           <td><?= $dd->telp ?></td>
                           <td><?= $dd->total_toko ?></td>
                           <td><a href="<?= base_url('sup/Customer/detail/' . $dd->id) ?>" class="btn btn-info btn-sm">Detail</a></td>
                     </tr>
                     <?php $no++; ?>
                   <?php endforeach; ?>
                 <?php } else { ?>
                   <td colspan="5" align="center"><strong>Data Kosong</strong></td>
                 <?php } ?>
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