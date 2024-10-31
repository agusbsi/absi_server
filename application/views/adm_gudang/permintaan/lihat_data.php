     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
         <div class="col-12">
           <div class="card card-info">
             <div class="card-header">
               <h3 class="card-title">
                 <li class="fas fa-file"></li> Permintaan (PO)
               </h3>
             </div>
             <div class="card-body">
               <div class="row">
                 <div class="col-md-6">
                   <div class="form-group">
                     <label for="">Integrasi Easy</label>
                     <div class="row">
                       <div class="col-md-6">
                         <button type="button" data-toggle="modal" data-target="#modal-export-packing" class="btn btn-warning btn-block btn-sm btn_export_packing" title="Export packing"><i class="fa fa-file-export"></i> Export Packing List</button>
                       </div>
                       <div class="col-md-6">
                         <button type="button" data-toggle="modal" data-target="#modal-export-all" class="btn btn-warning btn-block btn-sm btn_export_all" title="Export DO"><i class="fa fa-file-export"></i> Export BPB (on Progress)</button>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
               <hr>
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
     <div class="modal fade" id="modal-export-packing">
       <div class="modal-dialog modal-xl">
         <div class="modal-content">
           <div class="modal-header bg-warning">
             <h4 class="modal-title">
               <li class="fa fa-excel"></li> Integrasi Data ke Easy Accounting
             </h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           <div class="modal-body">
             <form id="formExport-packing" method="post" action="<?= base_url('adm_gudang/Permintaan/export_ea_all'); ?>">
               <div class="row">
                 <div class="col-md-4">
                   <div class="form-group">
                     <label for="file">Tanggal</label>
                     <input type="date" name="tanggal_all" class="form-control form-control-sm" required>
                   </div>
                   <br>
                   <br>
                   <hr>
                   <div class="text-center">
                     <strong>Jumlah PO yang dipilih : </strong> <br>
                     <h1 id="selectedCount" class="headline text-warning" style="font-size: 80px; font-weight:bold">0</h1>
                   </div>
                 </div>
                 <div class="col-md-8">
                   <div class="form-group">
                     <label for="file">List Permintaan (PO)</label>
                     <div class="input-group mb-1">
                       <div class="input-group-prepend">
                         <span class="input-group-text"><i class="fas fa-search"></i></span>
                       </div>
                       <input type="search" class="form-control form-control-sm " id="searchInput" placeholder="Cari Berdasarkan Nomor PO, Nama Toko...">
                     </div>
                     <div style="overflow-x: auto; max-height : 300px;">
                       <table id="myTable" class="table table-bordered table-striped">
                         <thead>
                           <tr class="text-center">
                             <th>No</th>
                             <th>Nomor</th>
                             <th>
                               <input type="checkbox" id="cekAll">
                             </th>
                           </tr>
                         </thead>
                         <tbody>
                           <?php
                            $no = 0;
                            foreach ($list as $pr) {
                              $no++; ?>
                             <tr>
                               <td class="text-center"><?= $no ?></td>
                               <td>
                                 <small>
                                   <strong><?= $pr->id ?></strong> <br>
                                   <?= $pr->nama_toko ?>
                                 </small>
                               </td>
                               <td class="text-center">
                                 <input type="checkbox" name="id_po_all[]" class="checkbox-item" value="<?= $pr->id ?>">
                               </td>
                             </tr>
                           <?php } ?>
                         </tbody>
                       </table>
                     </div>
                   </div>
                 </div>
               </div>
           </div>
           <div class="modal-footer justify-content-end">
             <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
               <li class="fas fa-times-circle"></li> Close
             </button>
             <button type="submit" class="btn btn-primary btn-sm " id="export-button-packing">
               <li class="fas fa-file-export"></li> Export
             </button>
           </div>
           </form>
         </div>
         <!-- /.modal-content -->
       </div>
       <!-- /.modal-dialog -->
     </div>
     <script>
       $(document).ready(function() {
         const form = document.getElementById('formExport-packing');
         const checkboxes = document.querySelectorAll('.checkbox-item');
         const selectedCount = document.getElementById('selectedCount');
         const cekAll = document.getElementById('cekAll');

         function updateCount() {
           const count = document.querySelectorAll('.checkbox-item:checked').length;
           selectedCount.textContent = count;
         }

         checkboxes.forEach(checkbox => {
           checkbox.addEventListener('change', updateCount);
         });

         cekAll.addEventListener('change', function() {
           checkboxes.forEach(checkbox => {
             checkbox.checked = cekAll.checked;
           });
           updateCount();
         });
         updateCount();

         // Fungsi untuk melakukan pencarian
         function searchTable() {
           var input, filter, table, tr, td, i, txtValue;
           input = document.getElementById("searchInput");
           filter = input.value.toUpperCase();
           table = document.getElementById("myTable");
           tr = table.getElementsByTagName("tr");
           for (i = 0; i < tr.length; i++) {
             td = tr[i].getElementsByTagName("td");
             for (var j = 0; j < td.length; j++) {
               txtValue = td[j].textContent || td[j].innerText;
               if (txtValue.toUpperCase().indexOf(filter) > -1) {
                 tr[i].style.display = "";
                 break; // keluar dari loop jika sudah ada satu td yang cocok
               } else {
                 tr[i].style.display = "none";
               }
             }
           }
         }
         document.getElementById("searchInput").addEventListener("input", searchTable);
       });
     </script>
     <script>
       document.getElementById('export-button-packing').addEventListener('click', function(event) {
         event.preventDefault(); // Menghentikan eksekusi default (submit) dari tombol
         const checkedCount = document.querySelectorAll('.checkbox-item:checked').length;
         const checkboxes = document.querySelectorAll('.checkbox-item');
         var tanggal = $('[name="tanggal_all"]').val();
         if (tanggal == "") {
           Swal.fire(
             'BELUM LENGKAP',
             'Tanggal tidak boleh kosong.',
             'info'
           );
         } else if (checkedCount === 0) {
           Swal.fire(
             'BELUM LENGKAP',
             'Minimal 1 Nomor harus terpilih.',
             'info'
           );
         } else {
           document.getElementById('formExport-packing').submit();
           alert('Berhasil Export Data');
           $('#modal-export-packing').modal('hide');
           $('[name="tanggal_all"]').val('');
           checkboxes.forEach((checkbox) => {
             checkbox.checked = false;
           });
           const count = document.querySelectorAll('.checkbox-item:checked').length;
           selectedCount.textContent = count;
         }

       });
     </script>