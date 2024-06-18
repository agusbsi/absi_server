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
<section class="content">
  <div class="container-fluid">
    <div id="printableArea">
      <div class="row">
        <div class="col-md-12">
          <div class="callout callout-info">
            <h5><i class="fas fa-store"></i> <strong><?= $SO->nama_toko; ?></strong></h5>
          </div>
          <div class="callout callout-info">

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">No SO :</label>
                  <input type="text" value="<?= $SO->id; ?>" class="form-control form-control-sm" readonly>
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

          <!-- Main content -->
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
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th class="text-center" rowspan="2"><small><b>No</b></small></th>
                      <th class="text-center" rowspan="2"><small><b>Kode Artikel</b></small></th>
                      <th class="text-center" rowspan="2"><small><b>Stok Awal</b></small></th>
                      <th colspan="2" class="text-center">Barang Masuk</th>
                      <th colspan="3" class="text-center">Barang Keluar</th>
                      <th class="text-center" rowspan="2"><small><b>Stok Akhir</b></small></th>
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
                  </thead>
                  <tbody>
                    <?php
                    $no = 0;
                    $t_awal = 0;
                    $t_awal_update = 0;
                    $terima = 0;
                    $mutasiMasuk = 0;
                    $retur = 0;
                    $jual = 0;
                    $mutasi = 0;
                    $hasil = 0;
                    $hasil_akhir = 0;
                    $hasil_akhir_update = 0;
                    $t_selisih = 0;
                    $t_selisih_update = 0;
                    $nextJual = 0;
                    foreach ($detail_so as $d) {
                      $no++;
                      $akhir = $d->qty_awal + $d->jml_terima + $d->mutasi_masuk  - $d->jml_retur - $d->jml_jual - $d->mutasi_keluar;
                      $awal = $d->qty_awal - $d->jml_terima - $d->mutasi_masuk  + $d->jml_retur + $d->jml_jual + $d->mutasi_keluar;
                      $selisih = ($d->hasil_so + $d->qty_jual) - $akhir;
                      $selisih_update = ($d->hasil_so + $d->qty_jual) - $d->qty_awal;
                    ?>
                      <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td>
                          <small>
                            <strong><?= $d->kode ?></strong>
                          </small>
                        </td>
                        <td class="text-center"><strong><?= DATE_FORMAT(new DateTime($SO->created_at), 'Y-m') <= '2024-05' ? $d->qty_awal : $awal ?></strong></td>
                        <td class="text-center"><?= $d->jml_terima  ?></td>
                        <td class="text-center"><?= $d->mutasi_masuk ?></td>
                        <td class="text-center"><?= $d->jml_retur ?></td>
                        <td class="text-center"><?= $d->jml_jual ?></td>
                        <td class="text-center"><?= $d->mutasi_keluar ?></td>
                        <td class="text-center"><strong><?= DATE_FORMAT(new DateTime($SO->created_at), 'Y-m') <= '2024-05' ? $akhir : $d->qty_awal ?></strong></td>
                        <td class="text-center"><strong><?= $d->hasil_so ?></strong></td>
                        <td class="text-center"><small><?= $d->qty_jual ?></small></td>
                        <?php if (DATE_FORMAT(new DateTime($SO->created_at), 'Y-m') <= '2024-05') { ?>
                          <td class="text-center"><strong><span class="btn btn-sm btn-<?= ($selisih < 0) ? 'danger' : '' ?>"><?= $selisih ?></span></strong> </td>
                        <?php } else { ?>
                          <td class="text-center"><strong><span class="btn btn-sm btn-<?= ($selisih_update < 0) ? 'danger' : '' ?>"><?= $selisih_update ?></span></strong> </td>
                        <?php } ?>
                      </tr>
                    <?php
                      $terima += $d->jml_terima;
                      $mutasiMasuk += $d->mutasi_masuk;
                      $jual += $d->jml_jual;
                      $retur += $d->jml_retur;
                      $mutasi += $d->mutasi_keluar;
                      $hasil += $d->hasil_so;
                      $t_awal += $d->qty_awal;
                      $t_awal_update += $awal;
                      $hasil_akhir += $akhir;
                      $hasil_akhir_update += $d->qty_awal;
                      $t_selisih += $selisih;
                      $t_selisih_update += $selisih_update;
                      $nextJual += $d->qty_jual;
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>

                      <td colspan="2" align="right"> <strong>Total :</strong> </td>
                      <td class="text-center"><strong><?= number_format(DATE_FORMAT(new DateTime($SO->created_at), 'Y-m') <= '2024-05' ? $t_awal : $t_awal_update); ?></strong></td>
                      <td class="text-center"><strong><?= number_format($terima); ?></strong></td>
                      <td class="text-center"><strong><?= number_format($mutasiMasuk); ?></strong></td>
                      <td class="text-center"><strong><?= number_format($retur); ?></strong></td>
                      <td class="text-center"><strong><?= number_format($jual); ?></strong></td>
                      <td class="text-center"><strong><?= number_format($mutasi); ?></strong></td>
                      <td class="text-center"><strong><?= number_format(DATE_FORMAT(new DateTime($SO->created_at), 'Y-m') <= '2024-05' ? $hasil_akhir : $hasil_akhir_update); ?></strong></td>
                      <td class="text-center"><strong><?= number_format($hasil); ?></strong></td>
                      <td class="text-center"><strong><?= number_format($nextJual); ?></strong></td>
                      <?php if (DATE_FORMAT(new DateTime($SO->created_at), 'Y-m') <= '2024-05') { ?>
                        <td class="text-center"><strong><span class="btn btn-sm btn-<?= ($t_selisih < 0) ? 'danger' : '' ?>"><?= number_format($t_selisih); ?></span></strong></td>
                      <?php } else { ?>
                        <td class="text-center"><strong><span class="btn btn-sm btn-<?= ($t_selisih_update < 0) ? 'danger' : '' ?>"><?= number_format($t_selisih_update); ?></span></strong></td>
                      <?php } ?>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-4">
                <p class="lead">Catatan SPG:</p>
                <textarea class="form-control" readonly>
                      <?= $SO->catatan ?>
                    </textarea>
              </div>
              <!-- /.col -->
              <div class="col-8">
              </div>
              <!-- /.col -->
            </div>
            <hr>
            <b>Note : </b> Kolom Penjualan <b> tgl 01 s/d <?= date('d-m-y', strtotime($SO->tgl_so)) ?></b> akan terisi otomatis setelah spg menginput data penjualan terbaru.
            <hr>
            <div class="row no-print">
              <div class="col-12">
                <a href="<?= base_url('sup/So/detail/' . $SO->id_toko) ?>" class="btn btn-warning btn-sm <?= $this->session->userdata('role') != 1 ? "d-none" : "" ?> float-right" style="margin-right: 5px;"><i class="fas fa-edit"></i> Edit </a>
                <a href="<?= base_url('sup/So/unduh_so/' . $SO->id) ?>" class="btn btn-success btn-sm float-right mr-2 "><i class="fa fa-download"></i> Unduh Excel</a>
                <button onclick="goBack()" class="btn btn-danger btn-sm float-right mr-2"> <i class="fas fa-times-circle"></i> Kembali</button>
              </div>
            </div>
          </div>
        </div>
        <!-- end print area -->

        <!-- /.invoice -->
      </div><!-- /.col -->

    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>


<script>
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