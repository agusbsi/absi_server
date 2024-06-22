     <section class="content">
       <div class="container-fluid">
         <div class="card card-info">
           <div class="card-header">
             <h3 class="card-title">
               <li class="fas fa-cube"></li> Data Artikel
             </h3>
           </div>
           <div class="card-body">
             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr class="text-center">
                   <th rowspan="2">No</th>
                   <th rowspan="2">Artikel</th>
                   <th rowspan="2">Satuan</th>
                   <th colspan="3">HET</th>
                 </tr>
                 <tr class="text-center">
                   <th>Jawa</th>
                   <th>Indobarat</th>
                   <th>SP</th>
                 </tr>
               </thead>
               <tbody>
                 <?php
                  $no = 0;
                  foreach ($list_data as $dd) :
                    $no++; ?>
                   <tr>
                     <td class="text-center"><?= $no ?></td>
                     <td>
                       <small>
                         <strong><?= $dd->kode ?></strong> <br>
                         <?= $dd->nama_produk ?>
                       </small>
                     </td>
                     <td class="text-center"><?= $dd->satuan ?></td>
                     <td class="text-right">
                       Rp <?= number_format($dd->harga_jawa) ?>
                     </td>
                     <td class="text-right">
                       Rp <?= number_format($dd->harga_indobarat) ?>
                     </td>
                     <td class="text-right">
                       Rp <?= number_format($dd->sp) ?>
                     </td>
                   </tr>
                 <?php endforeach; ?>
               </tbody>
             </table>
           </div>
         </div>
       </div>
     </section>