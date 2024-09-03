<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FORM PENILAIAN OUTLET</title>
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css">
  <style>
    table,
    th,
    th {
      border: 1px solid black;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    tbody .bawah-10 {
      height: 100px;
    }

    tbody .bawah-5 {
      height: 50px;
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
    <?php
    $pt = $this->session->userdata('pt');
    if ($pt == "VISTA MANDIRI GEMILANG") {
      $logo = "vista.png";
    } else  if ($pt == "PASIFIK KREASI PRIMAJAYA") {
      $logo = "pkp.png";
    } else  if ($pt == "MENTARI ADI PRATAMA") {
      $logo = "map.png";
    } else {
      $logo = "mic.png";
    }
    ?>
    <table>
      <thead>
        <tr>
          <th rowspan="4" class="text-center" style="width:15%;">
            <img style="width: 60%" src="<?= base_url('assets/img/' . $logo) ?>" alt="User profile picture">
          </th>
          <th colspan="4" class="text-center">PT <?= $pt ?></th>
          <th colspan="2" class="text-center"><strong>FPO1</strong></th>
        </tr>
        <tr>
          <th colspan="4" rowspan="2" class="text-center">
            <h3>FORM PENILAIAN OUTLET</h3>
          </th>
          <th>Tanggal</th>
          <th>: <?= date('d M Y', strtotime($r->created_at)) ?></th>
        </tr>
        <tr>
          <th>No FPO</th>
          <th>: <?= $r->nomor ?></th>
        </tr>
      </thead>
      <tbody>
        <tr class="text-center bawah-10">
          <td colspan="7"><strong>- BUKA TOKO -</strong></td>
        </tr>
        <tr>
          <td></td>
          <td><strong>Nama Toko</strong></td>
          <td colspan="3">
            <input type="text" class="form-control form-control-sm" value="<?= $r->nama_toko ?>" readonly>
          </td>
        </tr>
        <tr>
          <td></td>
          <td><strong>Lokasi</strong></td>
          <td colspan="3">
            <textarea class="form-control form-control-sm" readonly><?= $r->alamat ?></textarea>
          </td>
        </tr>
        <tr>
          <td></td>
          <td><strong>Sistem</strong></td>
          <td colspan="3"><input type="text" class="form-control form-control-sm" value="Konsinyasi" readonly></td>
        </tr>
        <tr class="bawah-10">
          <td></td>
          <td><strong>Potensi Sales</strong></td>
          <td>
            <div class="text-center">
              <input type="text" class="form-control form-control-sm" value="Rp <?= number_format($r->s_rider) ?>" readonly>
              <small>( Rider )</small>
            </div>
          </td>
          <td>
            <div class="text-center">
              <input type="text" class="form-control form-control-sm" value="Rp <?= number_format($r->s_gtman) ?>" readonly>
              <small>( GT-Men )</small>
            </div>
          </td>
          <td>
            <div class="text-center">
              <input type="text" class="form-control form-control-sm" value="Rp <?= number_format($r->s_crocodile) ?>" readonly>
              <small>( Crocodile )</small>
            </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td><strong>Target Sales</strong></td>
          <td><input type="text" class="form-control form-control-sm" value="Rp <?= number_format($r->target) ?>" readonly></td>
        </tr>
        <tr>
          <td></td>
          <td><strong>SPG</strong></td>
          <td>
            <input type="text" class="form-control form-control-sm" value="<?= $r->spg ? $r->spg : 'Tidak ada SPG' ?>" readonly>
          </td>
        </tr>
        <tr>
          <td></td>
          <td><strong>Margin (%)</strong></td>
          <td><input type="text" class="form-control form-control-sm" value="<?= $r->diskon ?> %" readonly></td>
        </tr>
        <tr>
          <td></td>
          <td><strong>Listing Fee</strong></td>
          <td><input type="text" class="form-control form-control-sm" value="Rp <?= number_format($r->listing) ?>" readonly></td>
        </tr>
        <tr>
          <td></td>
          <td><strong>Etc Fee</strong></td>
          <td><input type="text" class="form-control form-control-sm" value="Rp <?= number_format($r->etc) ?>" readonly></td>
        </tr>
        <tr>
          <td></td>
          <td><strong>Sewa Rak</strong></td>
          <td><input type="text" class="form-control form-control-sm" value="Rp <?= number_format($r->sewa_rak) ?>" readonly></td>
        </tr>
        <tr>
          <td></td>
          <td><strong>Limit Credit</strong></td>
          <td><input type="text" class="form-control form-control-sm" value="Rp <?= number_format($r->limit_toko) ?>" readonly></td>
        </tr>
        <tr>
          <td></td>
          <td><strong>Waktu Realisasi</strong></td>
          <td><input type="text" class="form-control form-control-sm" value="<?= $r->realisasi == null ? '-' :  date('d M Y', strtotime($r->realisasi)) ?>" readonly></td>
        </tr>
        <tr>
          <td></td>
          <td><strong>Catatan</strong></td>
          <td colspan="3">
            <textarea class="form-control form-control-sm" readonly><?= $catatan ?></textarea>
          </td>
        </tr>
        <tr>
          <td colspan="7">
            <div class="col-md-12 mt-5">
              <div class="row text-center">
                <div class="col-md-3">
                  Diajukan Oleh, <br>
                  <div class="signature-placeholder">
                    <?php if (!empty($r->ttd_spv)) { ?>
                      <img src="<?= base_url('assets/img/ttd/' . $r->ttd_spv) . '?t=' . time(); ?>">
                    <?php } ?>
                    <div class="signature-name"><?= $r->nama_spv ?></div>
                    <div class="signature-title">Supervisor</div>
                  </div>
                </div>
                <div class="col-md-6">
                  Diverifikasi Oleh, <br>
                  <div class="area-signature">
                    <div class="signature-placeholder">
                      <?php if (!empty($r->ttd_mm)) { ?>
                        <img src="<?= base_url('assets/img/ttd/' . $r->ttd_mm) . '?t=' . time(); ?>">
                      <?php } ?>
                      <div class="signature-name"><?= $r->nama_mm ?></div>
                      <div class="signature-title">Manager Marketing</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  Diketahui Oleh, <br>
                  <div class="signature-placeholder">
                    <?php if (!empty($r->ttd_dir)) { ?>
                      <img src="<?= base_url('assets/img/ttd/' . $r->ttd_dir) . '?t=' . time(); ?>">
                    <?php } ?>
                    <div class="signature-name"><?= $r->nama_dir ?></div>
                    <div class="signature-title">Direksi</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group mt-5" style="margin-left: 50px;">
              <strong>Tembusan : </strong> <br>
              AR Finance, Accounting, Arsip Marketing
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <hr>
    <strong style="margin-left: 50px;">Lampiran :</strong>
    <div class="row">
      <div class="col-md-6">
        <div class="position-relative p-3">
          <?php if (empty($r->foto_toko)) { ?>
            <p class="text-center">Foto Toko Kosong</p>
          <?php } else { ?>
            <img src="<?= base_url('assets/img/toko/' . $r->foto_toko) ?>" style="height: 250px; width: auto;" alt="Photo 2" class="img-fluid">
            <div class="ribbon-wrapper ribbon-lg">
              <div class="ribbon bg-warning">
                Foto Toko
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-md-6">
        <div class="position-relative p-3">
          <?php if (empty($r->foto_pic)) { ?>
            <p class="text-center">Foto PIC Toko Kosong</p>
          <?php } else { ?>
            <img src="<?= base_url('assets/img/toko/' . $r->foto_pic) ?>" style="height: 250px; width: auto;" alt="Photo 2" class="img-fluid">
            <div class="ribbon-wrapper ribbon-lg">
              <div class="ribbon bg-primary">
                PIC Toko
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <script>
    window.print();
  </script>
</body>

</html>