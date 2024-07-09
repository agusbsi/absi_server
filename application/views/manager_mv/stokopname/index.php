     <section class="content">
       <div class="container-fluid">
         <div class="col-12">
           <div class="callout callout-info">
             <div class="row">
               <div class="col-md-6">
                 <div class="form-group">
                   <strong>Stok Opname Bulan ini.</strong>
                   <h4 class="mt-2">Periode : <?= date('F Y', strtotime('-1 month')) ?></h4>
                 </div>
               </div>
               <div class="col-md-2">
                 <div class="form-group text-center">
                   <label for="">TOTAL TOKO</label>
                   <h4><strong><?= $t_toko ?></strong></h4>
                 </div>
               </div>
               <div class="col-md-2">
                 <div class="form-group text-center">
                   <label for="">SUDAH SO</label>
                   <h4><strong><?= $t_so ?></strong></h4>
                 </div>
               </div>
               <div class="col-md-2">
                 <div class="form-group text-center">
                   <label for="">BELUM SO</label>
                   <h4><strong><?= $t_bso ?></strong></h4>
                 </div>
               </div>
             </div>
           </div>
           <div class="card card-info">
             <div class="card-header">
               <h3 class="card-title">
                 <li class="fas fa-file-alt"></li> Data Stok Opname Toko
               </h3>
               <div class="card-tools">
                 <a href="<?= base_url('sup/So') ?>" class="btn btn-tool">
                   <i class="fas fa-times"></i>
                 </a>
               </div>
             </div>
             <div class="card-body">
               <table id="example1" class="table table-bordered table-striped">
                 <thead>
                   <tr class="text-center">
                     <th>No</th>
                     <th>Nama Toko</th>
                     <th>Status SO</th>
                     <th>Tgl max SO</th>
                     <th>Tgl SO</th>
                     <th>Dibuat</th>
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
                           <?php if ($dd->nama_user == "") {
                              echo "<span class='badge badge-danger'> ( Belum dikaitkan )</span>";
                            } else {
                              echo $dd->nama_user;
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
                       <td class="text-center">
                         <?php if ($dd->tgl_so == null) { ?>
                           - Kosong -
                         <?php } else { ?>
                           <?= $dd->tgl_so ?>
                         <?php } ?>
                       </td>
                       <td class="text-center">
                         <?php if ($dd->status_so == 0) {
                            echo "<span class='badge badge-danger'> Belum SO </span>";
                          } else {
                          ?>
                           <?= date('d M Y', strtotime($dd->tanggal_so)) ?>
                         <?php } ?>
                         <input type="hidden" name="id_toko" value="<?= $dd->id ?>">
                       </td>
                       <td class="text-center">
                         <?php if ($dd->status_so == 0) {
                            echo "<span class='badge badge-danger'> Belum SO </span>";
                          } else {
                          ?>
                           <?= date('d M Y', strtotime($dd->tgl_buat)) ?>
                         <?php } ?>
                       </td>
                       <td class="text-center">
                         <a href="<?= base_url('sup/So/pdf/' . $dd->id) ?>" target="_blank" class="btn btn-warning btn-sm <?= ($dd->nama_user == "") ? 'd-none' : ''; ?> <?= ($dd->status_so == "1") ? 'd-none' : ''; ?>"><i class="fas fa-file-pdf"></i> Format SO</a>
                         <a href="<?= base_url('sup/So/riwayat_so_toko/' . $dd->id . '/' . $dd->id_so) ?>" class="btn btn-primary btn-sm <?= ($dd->nama_user == "") ? 'd-none' : ''; ?> <?= ($dd->status_so == "0") ? 'd-none' : ''; ?>">Lihat <i class="fas fa-arrow-circle-right"></i></a>
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