     <section class="content">
       <div class="container-fluid">
         <div class="callout callout-info">
           <div class="row">
             <div class="col-md-8">
               <div class="form-group">
                 <label for="">Nama Area</label>
                 <input type="text" class="form-control form-control-sm" value="<?= $area->area ?>" readonly>
               </div>
             </div>
             <div class="col-md-4">
               <div class="form-group">
                 <label for="">Supervisor</label>
                 <input type="text" class="form-control form-control-sm" value="<?= $area->spv ?>" readonly>
               </div>
             </div>

           </div>
           <hr>
           <button type="button" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-edit"></i>
             Update
           </button>
           <br>
         </div>
         <div class="card">
           <div class="card-body">
             <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i>
               Tambah Toko
             </button>
             <br>
             <hr>
             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr class="text-center">
                   <th style="width:4% ">No</th>
                   <th>Nama Toko</th>
                   <th>Menu</th>
                 </tr>
               </thead>
               <tbody>
                 <?php
                  $no = 0;
                  foreach ($detail as $dd) :
                    $no++;
                  ?>
                   <tr>
                     <td class="text-center"><small><?= $no ?></small></td>
                     <td><small><?= $dd->nama_toko ?></small></td>
                     <td class="text-center">
                       <button data-id="<?= $dd->id ?>" data-id_area="<?= $dd->id_area ?>" class="btn btn-sm btn-danger btn_hapus" title="Hapus dari area">Hapus</button>
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
           <form id="areaForm" method="POST" action="<?= base_url('adm/Area/tambah_toko') ?>">
             <div class="modal-header bg-success">
               <h6 class="modal-title"> <i class="fas fa-map"></i> Form Tambah Area</h6>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body">
               <div class="form-group mb-1">
                 <label>Nama Area *</label>
                 <input type="hidden" name="id_area" class="form-control form-control-sm" value="<?= $area->id ?>" readonly>
                 <input type="text" name="area" class="form-control form-control-sm" autocomplete="off" value="<?= $area->area ?>" readonly>
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
                      foreach ($toko as $pr) :
                        $no++;
                      ?>
                       <tr>
                         <td><?= $no ?></td>
                         <td><small><?= $pr->nama_toko ?></small></td>
                         <td class="text-center">
                           <input type="checkbox" name="id_toko[]" class="checkbox-item" value="<?= $pr->id ?>">
                         </td>
                       </tr>
                     <?php endforeach ?>
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
     <div class="modal fade" id="modal-edit">
       <div class="modal-dialog modal-lg">
         <div class="modal-content ">
           <form method="POST" action="<?= base_url('adm/Area/update') ?>">
             <div class="modal-header bg-warning">
               <h6 class="modal-title"> <i class="fas fa-map"></i> Update Area</h6>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body">
               <div class="form-group mb-1">
                 <label>Nama Area *</label>
                 <input type="hidden" name="id" class="form-control form-control-sm" autocomplete="off" value="<?= $area->id ?>" required>
                 <input type="text" name="area" class="form-control form-control-sm" autocomplete="off" value="<?= $area->area ?>" required>
               </div>
               <div class="form-group mb-1">
                 <label>Supervisor *</label> </br>
                 <select class="form-control form-control-sm select2" name="spv" required>
                   <option value="">- Pilih Supervisor -</option>
                   <?php foreach ($spv as $d) : ?>
                     <option value="<?= $d->id ?>" <?= $area->id_spv == $d->id ? "selected" : "" ?>><?= $d->nama_user ?></option>
                   <?php endforeach ?>
                 </select>
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
         $('#pack').on('keyup', function() {
           var angka = $(this).val().replace(/[Rp.,]/g, '');
           var rupiah = formatRupiah(angka);
           $(this).val(rupiah);
         });

         function formatRupiah(angka) {
           var number_string = angka.toString().replace(/[^,\d]/g, ""),
             split = number_string.split(","),
             sisa = split[0].length % 3,
             rupiah = split[0].substr(0, sisa),
             ribuan = split[0].substr(sisa).match(/\d{3}/gi);

           if (ribuan) {
             separator = sisa ? "." : "";
             rupiah += separator + ribuan.join(".");
           }

           rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
           return "Rp " + rupiah;
         }

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
           var id_area = $(this).data('id_area');
           Swal.fire({
             title: 'Apakah anda yakin?',
             text: "Toko akan di hapus dari area ini ?",
             icon: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             cancelButtonText: 'Batal',
             confirmButtonText: 'Yakin'
           }).then((result) => {
             if (result.isConfirmed) {
               window.location.href = "<?= base_url('adm/Area/hapus_toko') ?>/" + id + "/" + id_area;
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