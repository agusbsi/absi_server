     <section class="content">
       <div class="container-fluid">
         <div class="row">
           <div class="col-12">
             <div class="card card-info">
               <div class="card-header">
                 <h3 class="card-title">
                   <li class="fas fa-truck"></li> Data Pengiriman Barang
                 </h3>
               </div>
               <div class="card-body">
                 <table id="example1" class="table table-bordered table-striped">
                   <thead>
                     <tr class="text-center">
                       <th>#</th>
                       <th style="width: 15%;">Nomor</th>
                       <th>Status</th>
                       <th>Nama Toko</th>
                       <th>Tanggal Kirim</th>
                       <th>Menu</th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php $no = 0;
                      foreach ($list_data as $dd) :
                        $no++ ?>
                       <tr>
                         <td class="text-center"><?= $no ?></td>
                         <td class="text-center"><small><?= $dd->id ?></small></td>
                         <td class="text-center">
                           <?= status_pengiriman($dd->status); ?>
                         </td>
                         <td><small><?= $dd->nama_toko ?></small></td>
                         <td class="text-center"><small><?= date('d-M-Y', strtotime($dd->created_at)) ?></small></td>
                         <td class="text-center">
                           <a type="button" class="btn btn-primary btn-sm" href="<?= base_url('leader/Pengiriman/detail/' . $dd->id) ?>" name="btn_detail"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
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