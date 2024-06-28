     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
         <div class="row">
           <div class="col-12">
             <div class="card card-info">
               <div class="card-header">
                 <h3 class="card-title">
                   <li class="fas fa-file-alt"></li> Data Stok Opname Toko
                 </h3>
               </div>
               <div class="card-body">
                 <table id="example1" class="table table-bordered table-striped">
                   <thead>
                     <tr class="text-center">
                       <th style="width:3%">No</th>
                       <th>Nama Toko</th>
                       <th>status</th>
                       <th>Tgl SO</th>
                       <th>Menu</th>
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
                             <strong><?= $dd->nama_toko ?></strong> <br>
                             spg :
                             <?php if ($dd->spg == "") {
                                echo "<span class='badge badge-danger'> ( Belum dikaitkan )</span>";
                              } else {
                                echo "<span class='badge badge-warning'> (";
                                echo $dd->spg;
                                echo " )</span>";
                              }
                              ?>
                           </small>
                         </td>
                         <td class="text-center">
                           <?php if ($dd->status_so == 0) {
                              echo "<span class='badge badge-danger'> Belum SO </span>";
                            } else if (($dd->status_so == 1)) {
                              echo "<span class='badge badge-success'> Sudah SO </span>";
                            }
                            ?>
                         </td>
                         <td class="text-center"><?= date('d-M-Y H:i:s', strtotime($dd->date_so))  ?></td>
                         <td class="text-center">
                           <a href="<?= base_url('leader/so/pdf/' . $dd->id) ?>" target="_blank" class="btn btn-warning btn-sm <?= ($dd->spg == "") ? 'd-none' : ''; ?> <?= ($dd->status_so == "1") ? 'd-none' : ''; ?>"><i class="fas fa-file-pdf"></i> Format SO</a>
                           <a href="<?= base_url('sup/So/riwayat_so_toko/' . $dd->id . '/' . $dd->id_so) ?>" class="btn btn-success btn-sm <?= ($dd->spg == "") ? 'd-none' : ''; ?> <?= ($dd->status_so == "0") ? 'd-none' : ''; ?>"><i class="fas fa-eye"></i> Hasil SO</a>
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