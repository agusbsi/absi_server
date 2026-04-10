     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
         <div class="row">
           <div class="col-12">
              <!-- Filter Section -->
                 <div class="card card-secondary">
                   <div class="card-header">
                     <h3 class="card-title">Filter Periode (Data akan ditampilkan untuk bulan sebelumnya)</h3>
                   </div>
                   <div class="card-body">
                     <form id="filterForm" method="GET" action="<?= base_url('sup/So/riwayat_so') ?>" class="form-inline w-100 justify-content-end">
                       <div class="form-group mr-2">
                         <label for="bulan" class="mr-2">Periode :</label>
                         <select id="bulan" name="bulan" class="form-control form-control-sm">
                           <option value="01" <?= $bulan == '01' ? 'selected' : '' ?>>Januari</option>
                           <option value="02" <?= $bulan == '02' ? 'selected' : '' ?>>Februari</option>
                           <option value="03" <?= $bulan == '03' ? 'selected' : '' ?>>Maret</option>
                           <option value="04" <?= $bulan == '04' ? 'selected' : '' ?>>April</option>
                           <option value="05" <?= $bulan == '05' ? 'selected' : '' ?>>Mei</option>
                           <option value="06" <?= $bulan == '06' ? 'selected' : '' ?>>Juni</option>
                           <option value="07" <?= $bulan == '07' ? 'selected' : '' ?>>Juli</option>
                           <option value="08" <?= $bulan == '08' ? 'selected' : '' ?>>Agustus</option>
                           <option value="09" <?= $bulan == '09' ? 'selected' : '' ?>>September</option>
                           <option value="10" <?= $bulan == '10' ? 'selected' : '' ?>>Oktober</option>
                           <option value="11" <?= $bulan == '11' ? 'selected' : '' ?>>November</option>
                           <option value="12" <?= $bulan == '12' ? 'selected' : '' ?>>Desember</option>
                         </select>
                       </div>

                       <div class="form-group mr-2">
                         <label for="tahun" class="mr-2">Tahun:</label>
                         <select id="tahun" name="tahun" class="form-control form-control-sm">
                           <?php 
                           $currentYear = date('Y');
                           for ($i = 2024; $i <= $currentYear; $i++) : 
                           ?>
                             <option value="<?= $i ?>" <?= $tahun == $i ? 'selected' : '' ?>><?= $i ?></option>
                           <?php endfor; ?>
                         </select>
                       </div>

                       <button type="submit" class="btn btn-primary btn-sm">
                         <i class="fas fa-search"></i> Cari
                       </button>
                     </form>
                   </div>
                 </div>
             <div class="card card-info">
               
               <div class="card-body">
                 <!-- Info Status Section -->
                 <div class="row mb-3">
                   <div class="col-12">
                     <div class="alert alert-info alert-dismissible fade show" role="alert">
                       <small>
                         <strong>Belum Terkunci:</strong> Data masih draft, belum valid, bisa berubah dari SPG | 
                         <strong>Terkunci:</strong> Sudah verifikasi MV/OPR, valid & final
                       </small>
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                       </button>
                     </div>
                   </div>
                 </div>

                 <!-- Summary Section -->
                 <div class="row mt-3">
                   <div class="col-md-3">
                     <div class="info-box bg-info">
                       <span class="info-box-icon"><i class="far fa-calendar"></i></span>
                       <div class="info-box-content">
                         <span class="info-box-text">Periode</span>
                         <span class="info-box-number" id="summaryPeriode"><?= isset($summary) ? $summary['periode'] : '-' ?></span>
                       </div>
                     </div>
                   </div>
                   <div class="col-md-3">
                     <div class="info-box bg-success">
                       <span class="info-box-icon"><i class="fas fa-store"></i></span>
                       <div class="info-box-content">
                         <span class="info-box-text">Total Toko</span>
                         <span class="info-box-number" id="summaryTotalToko"><?= isset($summary) ? $summary['total_toko'] : '0' ?></span>
                       </div>
                     </div>
                   </div>
                   <div class="col-md-3">
                     <div class="info-box bg-danger">
                       <span class="info-box-icon"><i class="fas fa-lock"></i></span>
                       <div class="info-box-content">
                         <span class="info-box-text">Laporan Terkunci</span>
                         <span class="info-box-number" id="summaryLocked"><?= isset($summary) ? $summary['locked'] : '0' ?></span>
                       </div>
                     </div>
                   </div>
                   <div class="col-md-3">
                     <div class="info-box bg-warning">
                       <span class="info-box-icon"><i class="fas fa-lock-open"></i></span>
                       <div class="info-box-content">
                         <span class="info-box-text">Laporan Belum Terkunci</span>
                         <span class="info-box-number" id="summaryUnlocked"><?= isset($summary) ? $summary['unlocked'] : '0' ?></span>
                       </div>
                     </div>
                   </div>
                 </div>

                 <!-- Data Table -->
                 <div class="mt-4">
                   <table id="example1" class="table table-bordered table-striped">
                     <thead>
                       <tr class="text-center">
                         <th style="width: 5%">No</th>
                         <th>Nama Toko</th>
                         <th>Nomor SO</th>
                         <th>Tgl SO</th>
                         <th>Dibuat</th>
                         <th>Status</th>
                         <th style="width: 12%">Menu</th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php
                        $no = 0;
                        if (isset($list_so) && count($list_so) > 0) :
                          foreach ($list_so as $s) :
                            $no++; 
                            $status_label = $s->status_kunci != 0 ? 'Terkunci' : 'Belum Terkunci';
                            $status_badge = $s->status_kunci != 0 ? 'badge-danger' : 'badge-warning';
                            ?>
                           <tr>
                             <td class="text-center"><?= $no ?></td>
                             <td><?= $s->nama_toko ?></td>
                             <td class="text-center">
                               <span class="badge badge-sm badge-info"><?= $s->id ?></span>
                             </td>
                             <td class="text-center"><?= date('d M Y', strtotime($s->created_at)) ?></td>
                             <td class="text-center"><?= date('d M Y', strtotime($s->dibuat)) ?></td>
                             <td class="text-center">
                               <span class="badge badge-sm <?= $status_badge ?>"><?= $status_label ?></span>
                             </td>
                             <td class="text-center">
                               <a href="<?= base_url('sup/So/riwayat_so_toko/' . $s->id_toko . '/' . $s->id) ?>" class="btn btn-sm btn-info">
                                 Lihat <i class="fas fa-arrow-circle-right"></i>
                               </a>
                             </td>
                           </tr>
                         <?php endforeach;
                        else : ?>
                          <tr>
                            <td colspan="7" class="text-center">
                              <span></span>
                            </td>
                          </tr>
                        <?php endif; ?>
                       </tbody>
                     </table>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </section>

     <script>
       $(document).ready(function() {
         // Cek apakah form telah disubmit (dari server side)
         var isFormSubmitted = <?= isset($_GET['bulan']) ? 'true' : 'false' ?>;
         
         // Hanya tampilkan modal jika form sudah disubmit dan data kosong
         if (isFormSubmitted) {
           var tableBody = $('#example1 tbody');
           var isEmpty = tableBody.find('tr td[colspan="7"]').length > 0;
           
           if (isEmpty) {
             Swal.fire({
               title: 'Data Kosong',
               text: 'Tidak ada data untuk periode yang dipilih. Silakan pilih periode lainnya.',
               icon: 'info',
               confirmButtonText: 'OK',
               confirmButtonColor: '#3085d6'
             });
           }
         }
       });
     </script>