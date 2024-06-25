     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
         <div class="col-12">
           <div class="card card-info">
             <div class="card-header">
               <h3 class="card-title">
                 <li class="fas fa-file"></li> Data Permintaan Barang
               </h3>
             </div>
             <div class="card-body">
               <table id="example1" class="table table-bordered table-striped">
                 <thead>
                   <tr class="text-center">
                     <th>#</th>
                     <th style="width: 13%;">Nomor PO</th>
                     <th style="width: 27%;">Nama Toko</th>
                     <th>Catatan MV</th>
                     <th>Tanggal</th>
                     <th style="width: 10%;">Menu</th>
                   </tr>
                 </thead>
                 <tbody>
                   <?php $no = 0;
                    foreach ($list_data as $dd) :
                      $no++ ?>
                     <tr>
                       <td class="text-center"><?= $no ?></td>
                       <td class="text-center"><small><strong><?= $dd->id ?></strong></small></td>
                       <td><small><?= $dd->nama_toko ?></small></td>
                       <td>
                         <small><?= $dd->keterangan ?></small>
                       </td>
                       <td class="text-center">
                         <small><?= date('d-M-Y', strtotime($dd->updated_at)) ?></small>
                       </td>
                       <td class="text-center">
                         <?php if (($dd->status == 2)) { ?>
                           <a type="button" class="btn btn-success btn-sm" href="<?= base_url('adm_gudang/permintaan/detail/' . $dd->id) ?>" name="btn_proses" title="proses"><i class="fas fa-paper-plane"></i></a>
                           <a type="button" href="<?= base_url('adm_gudang/permintaan/packing_list/' . $dd->id) ?>" target="_blank" class="btn btn-warning float-right btn-sm" style="margin-right: 2px;" title="Packing List ">
                             <i class="fas fa-print"></i></a>
                         <?php } else { ?>
                           <a type="button" class="btn btn-primary" href="<?= base_url('adm_gudang/permintaan/detail_p/' . $dd->id) ?>" name="btn_detail"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
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