<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SURAT PERINTAH PENGAMBILAN RETUR</title>
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css">
  <style>
    table,
    td,
    th {
      border: 1px solid black;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th {
      height: 5px;
    }

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
            <?php
            $pt = $this->session->userdata('pt');
            if ($pt == "VISTA MANDIRI GEMILANG") {
              $logo = "vista.png";
              $dok = "FM-12-01";
              $efektif = "01/09/2020";
            } else  if ($pt == "PASIFIK KREASI PRIMAJAYA") {
              $logo = "pkp.png";
              $dok = "FM-12-01";
              $efektif = "01/09/2020";
            } else  if ($pt == "MENTARI ADI PRATAMA") {
              $logo = "map.png";
              $dok = "FM-12-01";
              $efektif = "01/09/2020";
            } else {
              $logo = "mic.png";
              $dok = "FM-12-01";
              $efektif = "01/09/2020";
            }
            ?>
            <table>
              <tr>
                <td rowspan="4" class="text-center" style="width:15%;">
                  <img style="width: 60%" src="<?= base_url('assets/img/' . $logo) ?>" alt="User profile picture">
                </td>
                <td rowspan="2" class="text-center"><b>FORM</b></td>
                <td style="width:15%;">No Dok</td>
                <td style="width:20%;">: <?= $dok ?></td>
              </tr>
              <tr>
                <td style="width:15%;">Tgl Efektif</td>
                <td style="width:20%;">: <?= $efektif ?></td>
              </tr>

              <tr>
                <td rowspan="2" class="text-center"><b>SURAT PERINTAH PENGAMBILAN RETUR</b></td>
                <td style="width:15%;">Revisi</td>
                <td style="width:20%;">: 0</td>
              </tr>
              <tr>
                <td style="width:15%;">Hal</td>
                <td style="width:20%;">: page of </td>
              </tr>
            </table>
            <br>
            <br>
            <!-- header form konsinyasi -->
            <div class="row">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-3">
                    <strong>Tanggal</strong>
                  </div>
                  <div class="col-md-9">
                    : <?= date('d M Y', strtotime($r->created_at)) ?>
                  </div>
                  <div class="col-md-3">
                    <strong>Dari Toko</strong>
                  </div>
                  <div class="col-md-9">
                    : <?= $r->nama_toko ?>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="row">
                  <div class="col-md-6">
                    <strong>Target Date</strong>
                  </div>
                  <div class="col-md-6">
                    : <?= date('d M Y', strtotime($r->tgl_jemput)) ?>
                  </div>
                  <div class="col-md-6">
                    <strong>SPG Toko</strong> <br>
                    <strong>No telp.</strong>
                  </div>
                  <div class="col-md-6">
                    : <?= $r->spg ?> <br>
                    : <?= $r->no_telp ?>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-3">
                    <strong>Ke Toko / DC</strong>
                  </div>
                  <div class="col-md-9">
                    : GUDANG PREPEDAN
                  </div>
                  <div class="col-md-3">
                    <strong>No Retur</strong>
                  </div>
                  <div class="col-md-9">
                    : <?= $r->id ?>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="row">
                  <div class="col-md-6">
                    <strong>Leader</strong>
                  </div>
                  <div class="col-md-6">
                    : <?= $r->leader ?>
                  </div>
                  <div class="col-md-6">
                    <p><b>Tanggal Penarikan</b></p>
                  </div>
                  <div class="col-md-6">
                    <b>: ..........................</b>
                  </div>
                </div>
              </div>
            </div>

            <hr>
            <h5 class="text-center">- RETUR TUTUP TOKO -</h5>
            <hr>
            <!-- end header -->

            <!-- table list isi -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table style="border: 2px solid;">
                  <tbody>
                    <tr>
                      <td colspan="6" class="text-center"><b>LIST ASET</b></td>
                    </tr>
                    <tr class="text-center">
                      <th style="border: 2px solid; width: 4%;">No</th>
                      <th style="border: 2px solid; width: 17%;">Kode</th>
                      <th style="border: 2px solid; width: 35%;">Nama Aset</th>
                      <th style="border: 2px solid; width: 4%;">jumlah</th>
                      <th style="border: 2px solid;">Keterangan</th>
                    </tr>
                    <?php
                    $no = 0;
                    $total = 0;
                    foreach ($aset as $d) {
                      $no++;
                    ?>
                      <tr>
                        <td style="border: 2px solid" class="text-center"><?= $no ?></td>
                        <td style="border: 2px solid"><?= $d->kode ?></td>
                        <td style="border: 2px solid"><?= $d->aset ?></td>
                        <td style="border: 2px solid" class="text-center"><?= $d->qty ?> </td>
                        <td style="border: 2px solid">
                          <address><?= $d->keterangan ?></address>
                        </td>
                      </tr>
                    <?php
                      $total += $d->qty;
                    }
                    ?>
                    <tr>
                      <td colspan="3" class="text-right"><b>Total :</b></td>
                      <td class="text-center"><b><?= $total; ?></b></td>
                    </tr>
                  </tbody>

                </table>
              </div>
            </div>
            <!-- /.end table list isi -->
            <hr>
            <!-- table list isi -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table style="border: 2px solid;">

                  <tbody>
                    <tr>
                      <td colspan="6" class="text-center"><b>LIST ARTIKEL</b></td>
                    </tr>
                    <tr class="text-center">
                      <th style="border: 2px solid; width: 4%;">No</th>
                      <th style="border: 2px solid; width: 17%;">Kode Artikel#</th>
                      <th style="border: 2px solid; width: 35%;">Artikel</th>
                      <th style="border: 2px solid; width: 4%;">Satuan</th>
                      <th style="border: 2px solid; width: 4%;">Jumlah</th>
                      <th style="border: 2px solid;">Keterangan</th>
                    </tr>
                    <?php
                    $no = 0;
                    $total = 0;
                    foreach ($artikel as $d) {
                      $no++;
                    ?>
                      <tr>
                        <td style="border: 2px solid" class="text-center"><?= $no ?></td>
                        <td style="border: 2px solid"><?= $d->kode ?></td>
                        <td style="border: 2px solid"><?= $d->nama_produk ?></td>
                        <td style="border: 2px solid" class="text-center"><?= $d->satuan ?> </td>
                        <td style="border: 2px solid" class="text-center"><?= $d->qty ?> </td>
                        <td style="border: 2px solid">
                          <address><?= $d->keterangan ?></address>
                        </td>
                      </tr>
                    <?php
                      $total += $d->qty;
                    }
                    ?>
                    <tr>
                      <td colspan="4" class="text-right"><b>Total :</b></td>
                      <td class="text-center"><b><?= $total; ?></b></td>
                    </tr>
                  </tbody>

                </table>
              </div>
            </div>
            <!-- /.end table list isi -->
            <!-- footer untuk TTD  -->
            <hr style="border: 2px solid;">
            <div class="row">
              <div class="col-md-12">
                <div class="row text-center">
                  <div class="col-md-2">
                    Dibuat Oleh, <br>
                    <div class="signature-placeholder">
                      <?php if (!empty($r->ttd_spv)) { ?>
                        <img src="<?= base_url('assets/img/ttd/' . $r->ttd_spv) . '?t=' . time(); ?>">
                      <?php } ?>
                      <div class="signature-name"><?= $r->nama_spv ?></div>
                      <div class="signature-title">Supervisor</div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    Diverifikasi Oleh, <br>
                    <div class="area-signature">
                      <div class="signature-placeholder">
                        <?php if (!empty($r->ttd_mm)) { ?>
                          <img src="<?= base_url('assets/img/ttd/' . $r->ttd_mm) . '?t=' . time(); ?>">
                        <?php } ?>
                        <div class="signature-name"><?= $r->nama_mm ?></div>
                        <div class="signature-title">Manager Marketing</div>
                      </div>
                      <div class="signature-placeholder">
                        <?php if (!empty($r->ttd_mv)) { ?>
                          <img src="<?= base_url('assets/img/ttd/' . $r->ttd_mv) . '?t=' . time(); ?>">
                        <?php } ?>
                        <div class="signature-name"><?= $r->nama_mv ?></div>
                        <div class="signature-title">Marketing Verifikasi</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    Mengetahui, <br>
                    <div class="signature-placeholder">
                      <?php if (!empty($r->ttd_kgudang)) { ?>
                        <img src="<?= base_url('assets/img/ttd/' . $r->ttd_kgudang) . '?t=' . time(); ?>">
                      <?php } ?>
                      <div class="signature-name"><?= $r->nama_kg ?></div>
                      <div class="signature-title">Kepala Gudang</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    Diambil Oleh, <br>
                    <div class="signature-placeholder">
                      <div class="signature-name">.........................</div>
                      <div class="signature-title"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div>
        <!-- end print area -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
  <script>
    window.print();
  </script>
</body>

</html>