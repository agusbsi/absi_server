<style>
  table {
    width: 100%;
    border-collapse: collapse;
  }

  th {
    border: 1px solid black;
    padding: 8px;
    text-align: center;
  }
</style>
<form id="resetSOForm" action="<?= base_url('sup/So/reset_so') ?>" method="POST" style="display:none;">
  <input type="hidden" name="id_so" value="<?= $SO->id ?>">
</form>
<form id="adjust_form" action="<?= base_url('mng_ops/Dashboard/adjust_save') ?>" method="POST" enctype="multipart/form-data">
  <section class="content">
    <div class="container-fluid">
      <div id="printableArea">
        <div class="row">
          <div class="col-md-12">
            <div class="callout callout-info">
              <h5>
                <i class="fas fa-store"></i> <strong><?= $SO->nama_toko; ?></strong>
                <span class="float-right">
                  <?php if ($SO->status_kunci == 1) { ?>
                    <span class="badge badge-danger"><i class="fas fa-lock"></i> Terkunci</span>
                  <?php } else { ?>
                    <span class="badge badge-warning"><i class="fas fa-unlock"></i> Belum Terkunci</span>
                  <?php } ?>
                </span>
              </h5>
            </div>
            <div class="callout callout-info">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">No SO :</label>
                    <input type="text" name="no_so" value="<?= $SO->id; ?>" class="form-control form-control-sm" readonly>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Periode :</label>
                    <input type="text" value="<?= date('F Y', strtotime('-1 month', strtotime($SO->tgl_so))) ?>" class="form-control form-control-sm" readonly>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Tanggal SO :</label>
                    <input type="text" value="<?= date('d F Y', strtotime($SO->tgl_so)) ?>" class="form-control form-control-sm" readonly>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Dibuat :</label>
                    <input type="text" value="<?= date('d F Y  H:i:s', strtotime($SO->created_at)) ?>" class="form-control form-control-sm" readonly>
                  </div>
                </div>
              </div>
            </div>
            <?php if (!empty($adjust)) { ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-info"></i>
                Laporan SO ini sudah pernah di Adjust dengan nomor : <strong><?= $adjust ? $adjust->nomor : "-" ?></strong>
              </div>
            <?php } ?>
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <h4>
                  <li class="fas fa-file-alt"></li> Hasil Stok Opname
                </h4>
              </div>
              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <?php
                  // Ambil bulan kemarin dari tanggal SO
                  $bln_kemarin = date('Y-m', strtotime('-1 month', strtotime($SO->tgl_so)));
                  $bulan_awal = date('01 M Y', strtotime($bln_kemarin));
                  $bulan_akhir = date('t M Y', strtotime($bln_kemarin));
                  ?>

                  <table class="table table-striped">
                    <thead>
                      <?php if ($SO->status_kunci == 1) { ?>
                        <!-- Tampilan untuk SO yang terkunci -->
                        <tr>
                          <th class="text-center" rowspan="2"><small><b>No</b></small></th>
                          <th class="text-center" rowspan="2"><small><b>Kode Artikel</b></small></th>
                          <th class="text-center" rowspan="2"><small><b>Stok Awal</b></small></th>
                          <th colspan="2" class="text-center">Barang Masuk</th>
                          <th colspan="3" class="text-center">Barang Keluar</th>
                          <th class="text-center" rowspan="2"><small><b>Stok Akhir</b></small></th>
                          <th class="text-center" rowspan="2"><small><b>( SO SPG ) <br> Stok Fisik</b></small></th>
                          <th class="text-center" rowspan="2"><small><b>Penjualan Lanjutan</b></small></th>
                          <th class="text-center" rowspan="2"><small><b>Selisih</b></small></th>
                        </tr>
                        <tr>
                          <th><small><b>PO Masuk</b></small></th>
                          <th><small><b>Mutasi Masuk</b></small></th>
                          <th><small><b>Retur</b></small></th>
                          <th><small><b>Penjualan</b></small></th>
                          <th><small><b>Mutasi Keluar</b></small></th>
                        </tr>
                      <?php } else { ?>
                        <!-- Tampilan untuk SO yang belum terkunci -->
                        <tr>
                          <th class="text-center" rowspan="2"><small><b>No</b></small></th>
                          <th class="text-center" rowspan="2"><small><b>Kode Artikel</b></small></th>
                          <th class="text-center" rowspan="2"><small><b>Stok Awal</b> </br>
                              <?= $bulan_awal ?></small></th>
                          <th colspan="2" class="text-center">Barang Masuk</th>
                          <th colspan="3" class="text-center">Barang Keluar</th>
                          <th class="text-center" rowspan="2"><small><b>Stok Akhir</b></br>
                              <?= $bulan_akhir ?></small></th>
                          <th class="text-center" rowspan="2"><small><b>( SO SPG ) <br> Stok Fisik</b></small></th>
                          <th class="text-center" rowspan="2"><small><b>Penjualan <br> (<?= date('M-Y', strtotime($SO->tgl_so)) ?>) <br> 01 s/d <?= date('d', strtotime($SO->tgl_so)) ?></b></small></th>
                          <th class="text-center" rowspan="2"><small><b>Selisih</b></small></th>
                        </tr>
                        <tr>
                          <th><small><b>PO Masuk</b></small></th>
                          <th><small><b>Mutasi Masuk</b></small></th>
                          <th><small><b>Retur</b></small></th>
                          <th><small><b>Penjualan</b></small></th>
                          <th><small><b>Mutasi Keluar</b></small></th>
                        </tr>
                      <?php } ?>
                    </thead>
                    <tbody>
                      <?php if ($SO->status_kunci == 1) { ?>
                        <!-- Data untuk SO terkunci (dari tb_so_detail) -->
                        <?php
                        $no = 0;
                        $t_awal = 0;
                        $t_po = 0;
                        $t_mutasi_masuk = 0;
                        $t_retur = 0;
                        $t_jual = 0;
                        $t_mutasi_keluar = 0;
                        $t_stok_akhir = 0;
                        $t_hasil_so = 0;
                        $t_jual_lanjut = 0;
                        $t_selisih = 0;

                        foreach ($detail_so as $d) {
                          $no++;
                          $stok_akhir = $d->qty_awal + $d->jml_terima + $d->mutasi_masuk - $d->jml_retur - $d->jml_jual - $d->mutasi_keluar;
                          $selisih = ($d->hasil_so + $d->qty_jual) - $stok_akhir;
                        ?>
                          <tr>
                            <td class="text-center"><?= $no ?></td>
                            <td>
                              <small>
                                <strong><?= $d->kode ?></strong>
                                <input type="hidden" name="id_produk[]" value="<?= $d->id_produk ?>">
                                <input type="hidden" name="qty_awal[]" value="<?= $d->qty_awal ?>">
                                <input type="hidden" name="po[]" value="<?= $d->jml_terima ?>">
                                <input type="hidden" name="mutasi_masuk[]" value="<?= $d->mutasi_masuk ?>">
                                <input type="hidden" name="retur[]" value="<?= $d->jml_retur ?>">
                                <input type="hidden" name="penjualan[]" value="<?= $d->jml_jual ?>">
                                <input type="hidden" name="mutasi_keluar[]" value="<?= $d->mutasi_keluar ?>">
                                <input type="hidden" name="stok_akhir[]" value="<?= $stok_akhir ?>">
                                <input type="hidden" name="hasil_so[]" value="<?= $d->hasil_so ?>">
                                <input type="hidden" name="penjualan_lanjutan[]" value="<?= $d->qty_jual ?>">
                              </small>
                            </td>
                            <td class="text-center"><strong><?= $d->qty_awal ?></strong></td>
                            <td class="text-center"><?= $d->jml_terima ?></td>
                            <td class="text-center"><?= $d->mutasi_masuk ?></td>
                            <td class="text-center"><?= $d->jml_retur ?></td>
                            <td class="text-center"><?= $d->jml_jual ?></td>
                            <td class="text-center"><?= $d->mutasi_keluar ?></td>
                            <td class="text-center"><strong><?= $stok_akhir ?></strong></td>
                            <td class="text-center"><strong><?= $d->hasil_so ?></strong></td>
                            <td class="text-center"><small><?= $d->qty_jual ?></small></td>
                            <td class="text-center">
                              <strong>
                                <span class="btn btn-sm btn-<?= ($selisih < 0 ? 'danger' : 'success') ?>">
                                  <?= $selisih ?>
                                </span>
                              </strong>
                            </td>
                          </tr>
                        <?php
                          $t_awal += $d->qty_awal;
                          $t_po += $d->jml_terima;
                          $t_mutasi_masuk += $d->mutasi_masuk;
                          $t_retur += $d->jml_retur;
                          $t_jual += $d->jml_jual;
                          $t_mutasi_keluar += $d->mutasi_keluar;
                          $t_stok_akhir += $stok_akhir;
                          $t_hasil_so += $d->hasil_so;
                          $t_jual_lanjut += $d->qty_jual;
                          $t_selisih += $selisih;
                        }
                        ?>
                      <?php } else { ?>
                        <!-- Data untuk SO belum terkunci (dengan perhitungan kompleks) -->
                        <?php
                        $no = 0;
                        $t_awal = 0;
                        $terima = 0;
                        $mutasiMasuk = 0;
                        $retur = 0;
                        $jual = 0;
                        $mutasi = 0;
                        $hasil = 0;
                        $t_akhir = 0;
                        $t_selisih = 0;
                        $nextJual = 0;

                        // Ambil bulan & tahun dari SO
                        $tgl_so_sekarang = $SO->created_at;
                        $bulan_kemarin = date('F Y', strtotime($tgl_so_sekarang . ' -1 month')); // Ambil bulan sebelumnya

                        foreach ($detail_so as $d) {
                          $no++;

                          // Helper untuk akses property yang aman
                          $qty_awal = isset($d->qty_awal) ? $d->qty_awal : 0;
                          $jml_terima = isset($d->jml_terima) ? $d->jml_terima : 0;
                          $mutasi_masuk = isset($d->mutasi_masuk) ? $d->mutasi_masuk : 0;
                          $jml_retur = isset($d->jml_retur) ? $d->jml_retur : 0;
                          $jml_jual = isset($d->jml_jual) ? $d->jml_jual : 0;
                          $mutasi_keluar = isset($d->mutasi_keluar) ? $d->mutasi_keluar : 0;
                          $hasil_so = isset($d->hasil_so) ? $d->hasil_so : 0;
                          $qty_jual = isset($d->qty_jual) ? $d->qty_jual : 0;
                          $hasil_so_kemarin = isset($d->hasil_so_kemarin) ? $d->hasil_so_kemarin : 0;
                          $qty_jual_kemarin = isset($d->qty_jual_kemarin) ? $d->qty_jual_kemarin : 0;
                          $stok_adjust = isset($d->stok_adjust) ? $d->stok_adjust : 0;
                          $jml_terima_kemarin = isset($d->jml_terima_kemarin) ? $d->jml_terima_kemarin : 0;
                          $mutasi_masuk_kemarin = isset($d->mutasi_masuk_kemarin) ? $d->mutasi_masuk_kemarin : 0;
                          $jml_jual_kemarin = isset($d->jml_jual_kemarin) ? $d->jml_jual_kemarin : 0;
                          $jml_retur_kemarin = isset($d->jml_retur_kemarin) ? $d->jml_retur_kemarin : 0;
                          $mutasi_keluar_kemarin = isset($d->mutasi_keluar_kemarin) ? $d->mutasi_keluar_kemarin : 0;
                          $qty_awal_kemarin = isset($d->qty_awal_kemarin) ? $d->qty_awal_kemarin : 0;

                          // Cek apakah bulan kemarin adalah January 2025
                          $isDec2024 = ($bulan_kemarin == "December 2024");

                          if ($isDec2024) {
                            $stok_awal_fix = $qty_awal;
                          } else {
                            if ($toko_adjust === "true") {
                              if ($cek_adjustmen === "true") {
                                $stok_awal_fix = $stok_adjust;
                              } else {
                                $stok_awal_fix = $stok_adjust + $jml_terima_kemarin + $mutasi_masuk_kemarin - $jml_jual_kemarin - $jml_retur_kemarin - $mutasi_keluar_kemarin;
                              }
                            } else {
                              $stok_awal_fix = $qty_awal_kemarin;
                            }
                          }

                          // Hitung stok akhir
                          $stok_akhir = $stok_awal_fix + $jml_terima + $mutasi_masuk - $jml_retur - $jml_jual - $mutasi_keluar;

                          // Hitung selisih
                          $selisih = ($hasil_so + $qty_jual) - $stok_akhir;
                          $selisih_kemarin = ($hasil_so_kemarin + $qty_jual_kemarin) - $stok_akhir;
                        ?>
                          <tr>
                            <td class="text-center"><?= $no ?></td>
                            <td>
                              <small>
                                <strong><?= $d->kode ?></strong>
                                <input type="hidden" name="id_produk[]" value="<?= $d->id_produk ?>">
                                <input type="hidden" name="qty_awal[]" value="<?= $stok_awal_fix ?>">
                                <input type="hidden" name="po[]" value="<?= $jml_terima ?>">
                                <input type="hidden" name="mutasi_masuk[]" value="<?= $mutasi_masuk ?>">
                                <input type="hidden" name="retur[]" value="<?= $jml_retur ?>">
                                <input type="hidden" name="penjualan[]" value="<?= $jml_jual ?>">
                                <input type="hidden" name="mutasi_keluar[]" value="<?= $mutasi_keluar ?>">
                                <input type="hidden" name="stok_akhir[]" value="<?= $stok_akhir ?>">
                                <input type="hidden" name="hasil_so[]" value="<?= $hasil_so ?>">
                                <input type="hidden" name="penjualan_lanjutan[]" value="<?= $qty_jual ?>">
                              </small>
                            </td>
                            <td class="text-center"><strong><?= $stok_awal_fix ?></strong></td>
                            <td class="text-center"><?= $jml_terima ?></td>
                            <td class="text-center"><?= $mutasi_masuk ?></td>
                            <td class="text-center"><?= $jml_retur ?></td>
                            <td class="text-center"><?= $jml_jual ?></td>
                            <td class="text-center"><?= $mutasi_keluar ?></td>
                            <td class="text-center"><strong><?= $stok_akhir ?></strong></td>
                            <td class="text-center"><strong><?= $hasil_so ?></strong></td>
                            <td class="text-center"><small><?= $qty_jual ?></small></td>
                            <td class="text-center">
                              <strong>
                                <span class="btn btn-sm btn-<?= ($selisih < 0 ? 'danger' : 'success') ?>">
                                  <?= $selisih ?>
                                </span>
                              </strong>

                            </td>
                          </tr>
                        <?php
                          // Akumulasi total
                          $terima += $jml_terima;
                          $mutasiMasuk += $mutasi_masuk;
                          $jual += $jml_jual;
                          $retur += $jml_retur;
                          $mutasi += $mutasi_keluar;
                          $hasil += $hasil_so;
                          $t_awal += $stok_awal_fix;
                          $t_akhir += $stok_akhir;
                          $t_selisih += $selisih;
                          $nextJual += $qty_jual;
                        }
                        ?>
                      <?php } ?>
                    </tbody>


                    <tfoot>
                      <?php if ($SO->status_kunci == 1) { ?>
                        <!-- Total untuk SO terkunci -->
                        <tr>
                          <td colspan="2" align="right"> <strong>Total :</strong> </td>
                          <td class="text-center"><strong><?= number_format($t_awal) ?></strong></td>
                          <td class="text-center"><strong><?= number_format($t_po) ?></strong></td>
                          <td class="text-center"><strong><?= number_format($t_mutasi_masuk) ?></strong></td>
                          <td class="text-center"><strong><?= number_format($t_retur) ?></strong></td>
                          <td class="text-center"><strong><?= number_format($t_jual) ?></strong></td>
                          <td class="text-center"><strong><?= number_format($t_mutasi_keluar) ?></strong></td>
                          <td class="text-center"><strong><?= number_format($t_stok_akhir) ?></strong></td>
                          <td class="text-center"><strong><?= number_format($t_hasil_so) ?></strong></td>
                          <td class="text-center"><strong><?= number_format($t_jual_lanjut) ?></strong></td>
                          <td class="text-center"><strong><span class="btn btn-sm btn-<?= ($t_selisih < 0) ? 'danger' : '' ?>"><?= number_format($t_selisih); ?></span></strong></td>
                        </tr>
                      <?php } else { ?>
                        <!-- Total untuk SO belum terkunci -->
                        <tr>
                          <td colspan="2" align="right"> <strong>Total :</strong> </td>
                          <td class="text-center"><strong><?= number_format($t_awal) ?></strong></td>
                          <td class="text-center"><strong><?= number_format($terima); ?></strong></td>
                          <td class="text-center"><strong><?= number_format($mutasiMasuk); ?></strong></td>
                          <td class="text-center"><strong><?= number_format($retur); ?></strong></td>
                          <td class="text-center"><strong><?= number_format($jual); ?></strong></td>
                          <td class="text-center"><strong><?= number_format($mutasi); ?></strong></td>
                          <td class="text-center"><strong><?= number_format($t_akhir); ?></strong></td>
                          <td class="text-center"><strong><?= number_format($hasil); ?></strong></td>
                          <td class="text-center"><strong><?= number_format($nextJual); ?></strong></td>
                          <td class="text-center"><strong><span class="btn btn-sm btn-<?= ($t_selisih < 0) ? 'danger' : '' ?>"><?= number_format($t_selisih); ?></span></strong></td>
                        </tr>
                      <?php } ?>
                    </tfoot>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <label for="">Catatan SPG :</label>
              <textarea class="form-control form-control-sm" readonly><?= $SO->catatan ?></textarea>
              <hr>
              <b>Info : </b> <br> Kolom Penjualan <small>( <strong><?= date('M Y', strtotime($SO->tgl_so)) ?>, tgl : 01 s/d <?= date('d', strtotime($SO->tgl_so)) ?></strong> )</small> akan terisi otomatis setelah spg menginput data penjualan terbaru.
              <hr>
              <div class="row no-print">
                <div class="col-12">
                  <?php
                  $role = $this->session->userdata('role');
                  if ($role == 14 || $role == 1) { ?>
                    <?php if ($SO->status_kunci != 1) { ?>
                      <button type="button" class="btn btn-warning btn-sm float-right mr-2" data-toggle="modal" data-target="#modalLockSO"><i class="fas fa-lock"></i> Kunci Laporan</button>
                    <?php } else { ?>
                      <button type="button" class="btn btn-success btn-sm float-right mr-2" disabled><i class="fas fa-lock"></i> Laporan Terkunci</button>
                    <?php } ?>
                    <button type="button" class="btn btn-info btn-sm float-right mr-2 " data-toggle="modal" data-target="#exampleModalCenter" <?= (date('m', strtotime($SO->created_at)) != date('m')) ? 'disabled' : '' ?>><i class="fa fa-paper-plane"></i> Adjust Stok</button>
                    <a href="#" class="btn btn-warning btn-sm float-right mr-2" id="btn_resetSO" data-so="<?= $SO->id ?>" <?= date('m', strtotime($SO->created_at)) == date('m') ? '' : 'disabled' ?>><i class="fa fa-share"></i> Reset & SO ulang</a>
                  <?php } ?>
                  <!-- <a href="<?= base_url('sup/So/unduh_so/' . $SO->id) ?>" class="btn btn-success btn-sm float-right mr-2 "><i class="fa fa-download"></i> Unduh Excel</a> -->
                  <button onclick="goBack()" class="btn btn-danger btn-sm float-right mr-2"> <i class="fas fa-arrow-left"></i> Kembali</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form action="upload_handler.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header bg-info">
            <h5 class="modal-title" id="exampleModalLongTitle">
              <li class="fas fa-window-restore"></li> Adjustment Stok Toko
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <li><small>Proses ini membutuhkan verifikasi dari Manager OPR & Direksi.</small></li>
            <li><small>Proses ini hanya bisa di lakukan sekali untuk satu nomor SO.</small></li>
            <li><small>Ketika proses sudah di verifikasi maka akan memperbarui stok sistem sesuai dengan hasil SO SPG berdasarkan tanggal SO.</small></li>
            <li><small>Jika pengajuan ini tidak di verifikasi selama 2 hari, maka sistem akan membatalkan secara otomatis.</small></li>
            <hr>
            <div class="form-group">
              <strong>Catatan : *</strong>
              <textarea name="catatan" class="form-control form-control-sm" placeholder="Catatan anda..." required></textarea>
              <input type="hidden" name="toko" value="<?= $SO->nama_toko; ?>">
            </div>
            <div class="form-group">
              <strong>Upload Berkas : *</strong>
              <input type="file" name="bukti" class="form-control form-control-sm" accept=".pdf,image/*" required>
              <small class="form-text text-muted">Hanya file gambar (jpg, png) atau PDF yang diperbolehkan.</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-info btn-sm">Ya, Lanjutkan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Lock SO -->
  <div class="modal fade" id="modalLockSO" tabindex="-1" role="dialog" aria-labelledby="modalLockSOTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-left-danger">
        <div class="modal-header bg-danger">
          <h5 class="modal-title" id="modalLockSOTitle">
            <i class="fas fa-lock"></i> Kunci Laporan Stok Opname
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="lockSOForm" action="<?= base_url('mng_ops/Dashboard/lock_so') ?>" method="POST">
          <div class="modal-body">
            <div class="alert alert-danger alert-dismissible">
              <i class="icon fas fa-exclamation-triangle"></i>
              <strong>Perhatian!</strong> Proses ini tidak dapat dibatalkan.
            </div>
            
            <div class="info-box bg-light">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Informasi Penguncian Laporan SO</strong></span>
              </div>
            </div>

            <div style="margin-top: 15px;">
              <p><strong><i class="fas fa-check-circle text-danger"></i> Saat laporan ini dikunci:</strong></p>
              <ul style="margin-left: 20px;">
                <li>Data Stok Opname akan disimpan secara <strong>PERMANEN dan FINAL</strong></li>
                <li>SPG <strong>tidak lagi dapat memperbarui</strong> data laporan ini</li>
                <li>Data yang sudah ada adalah hasil validasi terakhir dari pihak management</li>
                <li>Perubahan stok akan tercatat dalam sistem inventory secara resmi</li>
                <li>Laporan ini akan menjadi dokumen audit yang valid</li>
              </ul>
            </div>

            <div style="margin-top: 15px; padding: 10px; background-color: #f8f9fa; border-left: 4px solid #dc3545;">
              <p style="margin: 0;"><strong><i class="fas fa-info-circle text-danger"></i> Catatan:</strong></p>
              <p style="margin: 5px 0 0 0; font-size: 13px;">Jika masih ada koreksi data, lakukan sekarang sebelum melakukan penguncian laporan.</p>
            </div>

            <input type="hidden" name="id_so" value="<?= $SO->id ?>">
          </div>

          <div class="modal-footer border-top">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              <i class="fas fa-times"></i> Batal
            </button>
            <button type="submit" class="btn btn-danger">
              <i class="fas fa-lock"></i> Ya, Kunci Laporan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</form>
<script>
  $('#btn_resetSO').click(function(e) {
    e.preventDefault();

    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Data SO akan di reset dan SPG bisa update SO kembali.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        // Submit form secara aman
        document.getElementById('resetSOForm').submit();
      }
    });
  });

  // Handle Lock SO Form Submission
  $('#lockSOForm').on('submit', function(e) {
    e.preventDefault();
    
    // Kumpulkan semua hidden inputs dari table
    var tableInputs = $('#adjust_form').find('input[type="hidden"][name*="[]"]');
    var hasData = false;
    var dataProduk = [];
    
    // Cek apakah ada data dari table
    tableInputs.each(function() {
      if ($(this).attr('name').includes('id_produk')) {
        hasData = true;
      }
    });
    
    if (!hasData) {
      Swal.fire({
        icon: 'error',
        title: 'Data Tidak Lengkap',
        text: 'Data produk tidak ditemukan. Mohon refresh halaman.',
      });
      return false;
    }
    
    // Kumpulkan data produk dari hidden inputs
    var idProduk = $('#adjust_form').find('input[name="id_produk[]"]');
    for (var i = 0; i < idProduk.length; i++) {
      dataProduk.push({
        id_produk: $('#adjust_form').find('input[name="id_produk[]"]').eq(i).val(),
        qty_awal: $('#adjust_form').find('input[name="qty_awal[]"]').eq(i).val(),
        po: $('#adjust_form').find('input[name="po[]"]').eq(i).val(),
        mutasi_masuk: $('#adjust_form').find('input[name="mutasi_masuk[]"]').eq(i).val(),
        retur: $('#adjust_form').find('input[name="retur[]"]').eq(i).val(),
        penjualan: $('#adjust_form').find('input[name="penjualan[]"]').eq(i).val(),
        mutasi_keluar: $('#adjust_form').find('input[name="mutasi_keluar[]"]').eq(i).val(),
        stok_akhir: $('#adjust_form').find('input[name="stok_akhir[]"]').eq(i).val(),
        hasil_so: $('#adjust_form').find('input[name="hasil_so[]"]').eq(i).val(),
        penjualan_lanjutan: $('#adjust_form').find('input[name="penjualan_lanjutan[]"]').eq(i).val()
      });
    }
    
    Swal.fire({
      title: 'Konfirmasi Penguncian Laporan',
      html: '<p>Anda yakin ingin mengunci laporan SO ini?</p><p><strong>Tindakan ini permanen dan tidak dapat dibatalkan.</strong></p>',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      cancelButtonText: 'Batal',
      confirmButtonText: '<i class="fas fa-lock"></i> Ya, Kunci Sekarang'
    }).then((result) => {
      if (result.isConfirmed) {
        // Tambahkan hidden field dengan JSON data
        var form = $('#lockSOForm');
        
        // Hapus field data_produk jika sudah ada
        form.find('input[name="data_produk"]').remove();
        
        // Tambahkan hidden field dengan JSON
        form.append('<input type="hidden" name="data_produk" value=\'' + JSON.stringify(dataProduk) + '\'>');
        
        // Show loading
        Swal.fire({
          title: 'Memproses...',
          html: 'Laporan sedang dikunci. Mohon tunggu...',
          icon: 'info',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading()
          }
        });
        
        // Submit the form
        form[0].submit();
      }
    });
  });

  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  }
</script>
<script>
  function goBack() {
    window.history.back();
  }
</script>