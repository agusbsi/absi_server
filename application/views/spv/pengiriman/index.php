     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
         <div class="card card-info">
           <div class="card-header">
             <h3 class="card-title">
               <li class="fas fa-truck"></li> Pengiriman
             </h3>
           </div>
           <!-- /.card-header -->
           <div class="card-body">

             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th style="width: 2%">#</th>
                   <th>Nomor</th>
                   <th>No PO</th>
                   <th>Toko</th>
                   <th class="text-center">Tanggal</th>
                   <th class="text-center">Status</th>
                   <th class="text-center">Menu</th>
                 </tr>
               </thead>
               <tbody>
                 <tr>
                   <?php if (!empty($list_data)) { ?>
                     <?php $no = 1; ?>
                     <?php foreach ($list_data as $dd) : ?>
                       <td class="text-center"><?= $no ?></td>
                       <td class="text-center"><?= $dd->id ?></td>
                       <td><?= $dd->id_permintaan ?></td>
                       <td>
                         <small>
                           <?= $dd->nama_toko ?> <br>
                           <div class="badge badge-warning badge-sm"><?= $dd->spg ? $dd->spg : "-" ?></div>
                         </small>
                       </td>
                       <td class="text-center"><?= date('d-m-Y H:m:s', strtotime($dd->created_at)) ?></td>
                       <td class="text-center"><?= status_pengiriman($dd->status) ?></td>
                       <td><a href="<?= base_url('spv/Pengiriman/detail/' . $dd->id) ?>" class="btn btn-info btn-sm">Detail</a></td>
                 </tr>
                 <?php $no++; ?>
               <?php endforeach; ?>
             <?php } else { ?>
               <td colspan="7" align="center"><strong>Data Kosong</strong></td>
             <?php } ?>
               </tbody>
             </table>

           </div>
           <!-- /.card-body -->
         </div>
       </div>
       <!-- /.container-fluid -->
     </section>