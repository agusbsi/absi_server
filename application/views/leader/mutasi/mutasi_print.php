<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Print Mutasi</title>
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css">
  <style>
    .area-signature {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 40%;
    }

    .signature-placeholder {
      position: relative;
      height: auto;
      min-height: 190px;
      text-align: center;
    }

    .signature-placeholder img {
      height: auto;
      max-width: 180px;
      position: absolute;
      top: 38%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .signature-name {
      position: absolute;
      bottom: 22%;
      left: 50%;
      transform: translateX(-50%);
      font-size: 12px;
      font-weight: bold;
      width: auto;
      white-space: nowrap;
    }

    .signature-title {
      position: absolute;
      bottom: 12%;
      left: 50%;
      transform: translateX(-50%);
      font-size: 12px;
      width: auto;
      white-space: nowrap;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div id="printableArea">
          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <div class="row">
              <div class="col-md-5">
                <table class="table " style="border: 3px solid;">
                  <thead>
                    <tr>
                      <th class="text-center ">
                        <h4><b><?= $this->session->userdata('pt'); ?></b></h4>
                      </th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-6">
                <table class="table  table-striped">
                  <thead>
                    <tr>
                      <th class="text-center">
                        <h4><b>Surat Jalan Mutasi Barang</b></h4>
                      </th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <!-- header form konsinyasi -->
            <div class="row">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-6 ">
                    <table class="table" style="border: 2px solid;">
                      <tr>
                        <th style="border: 2px solid;" class="text-center">Toko Asal :</th>
                      </tr>
                      <tr>
                        <td style="border: 2px solid">
                          <strong><?= $mutasi->asal ?></strong><br>
                          <small><?= $mutasi->alamat_asal ?></small>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <strong>spg :</strong> <small><?= $mutasi->spg_asal ?></small>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <strong>Telp : </strong> <small><?= $mutasi->telp_asal ?></small>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <table class="table " style="border: 2px solid;">
                      <tr>
                        <th style="border: 2px solid" class="text-center">Toko Tujuan :</th>
                      </tr>
                      <tr>
                        <td style="border: 2px solid">
                          <strong> <?= $mutasi->tujuan ?> </strong><br>
                          <small><?= $mutasi->alamat_tujuan ?></small>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <strong>spg :</strong> <small><?= $mutasi->spg_tujuan ?></small>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <strong>Telp : </strong> <small><?= $mutasi->telp_tujuan ?></small>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="row">
                  <div class="col-md-6">
                    <table class="table   text-center" style="border: 2px solid">

                      <tr>
                        <th> No Mutasi</th>
                      </tr>
                      <tr>
                        <th><strong><?= $mutasi->id ?> </strong></th>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <table class="table   text-center" style="border: 2px solid">
                      <tr>
                        <th>No Surat Jalan #</th>
                      </tr>
                      <tr>
                        <th><strong><?= $mutasi->id ?> </strong></th>
                      </tr>

                    </table>
                  </div>
                </div>
                <table class="table  text-center" style="border: 2px solid">
                  <tr>
                    <th>Tanggal :</th>
                    <th> ............................</th>
                  </tr>
                </table>
              </div>
            </div>
            <hr>
            <div class="col-12 table-responsive">
              <table class="table  " style="border: 2px solid;">
                <thead>
                  <tr class="text-center">
                    <th style="border: 2px solid; width: 5%;">No</th>
                    <th style="border: 2px solid; width: 20%;">Kode #</th>
                    <th style="border: 2px solid; width: 40%;">Artikel</th>
                    <th style="border: 2px solid; width: 10%;">Satuan</th>
                    <th style="border: 2px solid; width: 10%;">Qty</th>


                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  $total = 0;
                  foreach ($detail_mutasi as $d) {
                    $no++;
                  ?>
                    <tr>
                      <td style="border: 2px solid"><?= $no ?></td>
                      <td style="border: 2px solid"><?= $d->kode ?></td>
                      <td style="border: 2px solid"><?= $d->nama_produk ?></td>
                      <td style="border: 2px solid" class="text-center"><?= $d->satuan ?> </td>
                      <td style="border: 2px solid" class="text-right"><?= $d->qty ?></td>
                    </tr>
                  <?php
                    $total += $d->qty;
                  }
                  ?>
                <tfoot>
                  <tr>
                    <td style="border: 2px solid" colspan="4" class="text-right">Total :</td>
                    <td style="border: 2px solid" class="text-right"><strong><?= $total ?></strong></td>
                  </tr>
                </tfoot>
                </tbody>
              </table>
              <table class="table " style="border: 2px solid;">
                <tr>
                  <td style="border: 2px solid">
                    <strong>Catatan :</strong> <br>
                    <address>
                      <?= $mutasi->catatan_mv ?>
                    </address>
                  </td>
                </tr>
              </table>
            </div>
            <!-- footer untuk TTD  -->
            <hr style="border: 2px solid;">
            <div class="row">
              <div class="col-md-12">
                <div class="row text-center">
                  <div class="col-md-3 signature-container">
                    Dibuat Oleh, <br>
                    <div class="signature-placeholder">
                      <?php if (!empty($mutasi->ttd_leader)) { ?>
                        <img src="<?= base_url('assets/img/ttd/' . $mutasi->ttd_leader) . '?t=' . time(); ?>">
                      <?php } ?>
                      <div class="signature-name"><?= $mutasi->leader ?></div>
                      <div class="signature-title">Tim Leader</div>
                    </div>
                  </div>
                  <div class="col-md-5">
                    Disetujui oleh, <br>
                    <div class="area-signature">
                      <div class="signature-placeholder">
                        <?php if (!empty($mutasi->ttd_opr)) { ?>
                          <img src="<?= base_url('assets/img/ttd/' . $mutasi->ttd_opr) . '?t=' . time(); ?>">
                        <?php } ?>
                        <div class="signature-name"><?= $mutasi->nama_opr ? $mutasi->nama_opr : '.........................' ?></div>
                        <div class="signature-title">Manager Operasional</div>
                      </div>
                      <div class="signature-placeholder">
                        <?php if (!empty($mutasi->ttd_mm)) { ?>
                          <img src="<?= base_url('assets/img/ttd/' . $mutasi->ttd_mm) . '?t=' . time(); ?>">
                        <?php } ?>
                        <div class="signature-name"><?= $mutasi->nama_mm ? $mutasi->nama_mm : '.........................' ?></div>
                        <div class="signature-title">Manager Marketing</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    Dikirim oleh, <br>
                    <div class="signature-placeholder">
                      <div class="signature-name">.........................</div>
                      <div class="signature-title">Bagian Pengiriman</div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    Diterima oleh, <br>
                    <div class="signature-placeholder">
                      <div class="signature-name"><?= $mutasi->spg_tujuan ?></div>
                      <div class="signature-title">SPG</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    window.print();
  </script>
</body>

</html>