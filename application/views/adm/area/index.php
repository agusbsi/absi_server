     <section class="content">
       <div class="container-fluid">
         <div class="card card-info">
           <div class="card-header">
             <h3 class="card-title">
               <li class="fas fa-map"></li> Data Area
             </h3>
           </div>
           <div class="card-body">
             <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i>
               Tambah Area
             </button>
             <br>
             <hr>
             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr class="text-center">
                   <th style="width:3% ">No</th>
                   <th>Area</th>
                   <th>Supervisor</th>
                   <th>Total Toko</th>
                   <th>Menu</th>
                 </tr>
               </thead>
               <tbody>

                 <?php
                  $no = 0;
                  foreach ($list as $dd) :
                    $no++;
                  ?>
                   <tr class="text-center">
                     <td><small><?= $no ?></small></td>
                     <td><small><?= $dd->area ?></small></td>
                     <td><small><?= $dd->spv ? $dd->spv : 'kosong'  ?></small></td>
                     <td><small><?= $dd->t_toko ?></small></td>
                     <td>
                       <a href="<?= base_url('adm/Area/detail/' . $dd->id) ?>" class="btn btn-sm btn-info" title="Lihat"><i class="fas fa-eye"></i></a>
                       <button data-id="<?= $dd->id ?>" class="btn btn-sm btn-danger btn_hapus" title="Hapus"><i class="fas fa-trash"></i></button>
                     </td>
                   </tr>
                 <?php endforeach; ?>
               </tbody>
             </table>
           </div>
         </div>
       </div>
     </section>
     <div class="modal fade" id="modal-tambah">
       <div class="modal-dialog modal-lg">
         <div class="modal-content ">
           <form id="areaForm" method="POST" action="<?= base_url('adm/Area/tambah') ?>">
             <div class="modal-header bg-success">
               <h6 class="modal-title"> <i class="fas fa-map"></i> Form Tambah Area</h6>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body">
               <div class="form-group mb-1">
                 <label>Nama Area *</label>
                 <input type="text" name="area" class="form-control form-control-sm" autocomplete="off" placeholder="...." required="">
               </div>
               <div class="form-group mb-1">
                 <label>Supervisor *</label> </br>
                 <select class="form-control form-control-sm select2" name="spv" required>
                   <option value="">- Pilih Supervisor -</option>
                   <?php foreach ($spv as $d) : ?>
                     <option value="<?= $d->id ?>"><?= $d->nama_user ?></option>
                   <?php endforeach ?>
                 </select>
               </div>
               <div class="form-group mb-1">
                 <label>Pilih Toko *</label>
               </div>
               <input type="text" class="form-control form-control-sm mb-1" id="searchInput" placeholder="Cari berdasarkan Nama Toko...">
               <div style="overflow-x: auto; max-height : 200px;">
                 <table id="myTable" class="table table-bordered table-striped">
                   <thead>
                     <tr class="text-center bg-success">
                       <th>No</th>
                       <th>Nama Toko</th>
                       <th>
                         <input type="checkbox" id="cekAll">
                       </th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php
                      $no = 0;
                      foreach ($toko as $pr) {
                        $no++;
                      ?>
                       <tr>
                         <td class="text-center"><?= $no ?></td>
                         <td><small><?= $pr->nama_toko ?></small></td>
                         <td class="text-center">
                           <input type="checkbox" name="id_toko[]" class="checkbox-item" value="<?= $pr->id ?>">
                         </td>
                       </tr>
                     <?php } ?>
                   </tbody>
                 </table>
               </div>
               <div>
                 Jumlah toko yang dipilih: <span id="selectedCount">0</span>
               </div>
             </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                 <i class="fas fa-times-circle"></i> Cancel
               </button>
               <button type="submit" class="btn btn-success btn-sm">
                 <i class="fas fa-save"></i> Simpan
               </button>
             </div>
           </form>
         </div>
       </div>
     </div>
     <script>
       $(document).ready(function() {
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
         $('.btn_hapus').click(function(e) {
           var id = $(this).data('id');
           Swal.fire({
             title: 'Apakah anda yakin?',
             text: "Data Area akan dihapus dari database.",
             icon: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             cancelButtonText: 'Batal',
             confirmButtonText: 'Yakin'
           }).then((result) => {
             if (result.isConfirmed) {
               window.location.href = "<?= base_url('adm/Area/hapus') ?>/" + id;
             }
           })
         });
       });
     </script>
     <script>
       document.addEventListener('DOMContentLoaded', function() {
         const form = document.getElementById('areaForm');
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

         // Initial count update
         updateCount();

         form.addEventListener('submit', function(event) {
           const checkedCount = document.querySelectorAll('.checkbox-item:checked').length;
           if (checkedCount === 0) {
             Swal.fire(
               'BELUM LENGKAP',
               'Minimal 1 toko harus terpilih.',
               'info'
             );
             event.preventDefault();
           }
         });
       });
     </script>