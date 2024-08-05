 <section class="content">
   <div class="container-fluid">
     <div class="card card-warning">
       <div class="card-header">
         <h3 class="card-title">
           <li class="fas fa-exclamation-triangle"></li> Data Selisih Penerimaan
         </h3>
       </div>
       <div class="card-body">
         <table id="example1" class="table table-bordered table-striped">
           <thead>
             <tr class="text-center">
               <th>No</th>
               <th style="width:15%">Nomor Kirim</th>
               <th style="width:15%">Nomor PO</th>
               <th>Toko</th>
               <th>Tgl</th>
               <th>Menu</th>
             </tr>
           </thead>
           <tbody>
             <?php
              $no = 0;
              foreach ($selisih as $data) :
                $no++; ?>
               <tr>
                 <td><?= $no ?></td>
                 <td class="text-center">
                   <small><strong><?= $data->id ?></strong></small>
                 </td>
                 <td class="text-center">
                   <small><strong><?= $data->id_permintaan ?></strong></small>
                 </td>
                 <td>
                   <small>
                     <strong><?= $data->nama_toko ?></strong> <br>
                     <?= $data->nama_user ?>
                   </small>
                 </td>
                 <td><?= date('d M Y', strtotime($data->created_at)) ?></td>
                 <td class="text-center">
                   <a href="<?= base_url('sup/selisih/detail/' . $data->id) ?>" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>
                 </td>
               </tr>
             <?php endforeach; ?>
             </tr>
           </tbody>
         </table>
       </div>
     </div>
   </div>
 </section>