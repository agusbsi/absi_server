     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
         <div class="col-12">
           <div class="card card-info">
             <div class="card-header">
               <h3 class="card-title">
                 <li class="fas fa-file"></li> Data Permintaan Artikel
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
                    foreach ($list as $dd) :
                      $no++ ?>
                     <tr>
                       <td class="text-center"><?= $no ?></td>
                       <td class="text-center"><small><strong><?= $dd->id ?></strong></small></td>
                       <td>
                         <small>
                           <strong><?= $dd->nama_toko ?></strong><br>
                           <strong>Leader : </strong><?= $dd->leader ?>
                         </small>
                       </td>
                       <td>
                         <small><?= $dd->keterangan ?></small>
                       </td>
                       <td class="text-center">
                         <small><?= date('d-M-Y', strtotime($dd->updated_at)) ?></small>
                       </td>
                       <td class="text-center">
                         <div class="btn-group">
                           <button type="button" class="btn btn-outline-success btn-sm"> Proses</button>
                           <button type="button" class="btn btn-success btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                             <span class="sr-only">Toggle Dropdown</span>
                           </button>
                           <div class="dropdown-menu" role="menu">
                             <a class="dropdown-item" href="<?= base_url('adm_gudang/permintaan/detail/' . $dd->id) ?>" title="Buat DO">Buat DO</a>
                             <div class="dropdown-divider"></div>
                             <a class="dropdown-item" href="<?= base_url('adm_gudang/permintaan/packing_list/' . $dd->id) ?>" target="_blank" title="Packing List">Packing List</a>
                           </div>
                         </div>
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