<section class="content">
  <div class="container-fluid">
    <?php if ($cek_status->status == 0) { ?>
      <div class="overlay-wrapper">
        <div class="overlay">
          <i class="fas fa-3x fa-sync-alt fa-spin"></i>
          <div class="text-bold pt-2">TOKO NON-AKTIF !</div>
        </div>
      </div>
    <?php } else if ($cek_status->status == 2) { ?>
      <div class="overlay-wrapper">
        <div class="overlay">
          <i class="fas fa-3x fa-sync-alt fa-spin"></i>
          <div class="text-bold pt-2">Data Toko Menunggu Approve Manager Marketing !</div>
        </div>
      </div>
    <?php } else if ($cek_status->status == 3) { ?>
      <div class="overlay-wrapper">
        <div class="overlay">
          <i class="fas fa-3x fa-sync-alt fa-spin"></i>
          <div class="text-bold pt-2">Data Toko Menunggu Pemeriksaan Audit !</div>
        </div>
      </div>
    <?php } else if ($cek_status->status == 4) { ?>
      <div class="overlay-wrapper">
        <div class="overlay">
          <i class="fas fa-3x fa-sync-alt fa-spin"></i>
          <div class="text-bold pt-2">Data Toko Menunggu Approve Direksi !</div>
        </div>
      </div>
    <?php } ?>
    <div class="row">
      <div class="col-md-5">
        <!-- Profile Image -->
        <div class="card card-info">
          <div class="card-header">
            Toko
          </div>
          <div class="card-body">
            <div class="text-center">
              <?php if ($toko->foto_toko == "") {
              ?>
                <img style="width: 150px;" class="img-responsive img-rounded" src="<?php echo base_url() ?>assets/img/toko/hicoop.png" alt="User profile picture">
              <?php
              } else { ?>
                <img style="width: 150px;" class=" img-responsive img-rounded" src="<?php echo base_url('assets/img/toko/' . $toko->foto_toko) ?>" alt="User profile picture">
              <?php } ?>
            </div>
            <h3 class="profile-username text-center"><strong><?= $toko->nama_toko ?></strong></h3>
            <p class="text-muted text-center">[ ID : <?= $toko->id ?> ]</p>
            <table class="table table-sm">
              <tbody>
                <tr>
                  <td><b>Provinsi</b></td>
                  <td>
                    : <?= $toko->provinsi ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Kabupaten</b></td>
                  <td>
                    : <?= $toko->kabupaten ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Kecamatan</b></td>
                  <td>
                    : <?= $toko->kecamatan ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Alamat</b></td>
                  <td>
                    : <?= $toko->alamat ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <div class="col-md-7">
        <!-- Profile Image -->
        <div class="card card-info">
          <div class="card-header">
            Detail
          </div>
          <div class="card-body">
            <table class="table table-sm">
              <tbody>
                <tr>
                  <td><b>Jenis Toko</b></td>
                  <td>
                    : <?= jenis_toko($toko->jenis_toko) ?>
                  </td>
                </tr>
                <tr>
                  <td><b>PIC & Telp</b></td>
                  <td>
                    : <?= $toko->nama_pic ?> | <?= $toko->telp ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Margin</b></td>
                  <td>
                    : <?= $toko->diskon ?> %
                  </td>
                </tr>
                <tr>
                  <td><b>Jenis Harga</b></td>
                  <td>
                    : <?= status_het($toko->het) ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Batas PO</b></td>
                  <td>
                    : <?= $toko->status_ssr == 1 ? '<span class = "badge badge-success"> Aktif </span>  <small> ( PO barang di batasi dengan SSR ) </small>' : '<span class = "badge badge-danger"> Tidak Aktif </span> <small> ( PO barang Tidak di batasi ) </samll>' ?>
                  </td>
                </tr>
                <tr>
                  <td><b>SSR</b></td>
                  <td>
                    : <?= $toko->ssr ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Max Po</b></td>
                  <td>
                    : <?= $toko->max_po ?> %
                  </td>
                </tr>
                <tr>
                  <td><b>Di buat</b></td>
                  <td>
                    : <?= $toko->created_at ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <div class="card card-info">
          <div class="card-header">
            Pengguna Sistem
          </div>
          <div class="card-body">
            <table class="table table-sm">
              <tbody>
                <tr>
                  <td><b>Spg</b></td>
                  <td>
                    : <?= empty($toko->spg) ? "Belum di kaitkan " : $toko->spg ?>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">
          <li class="fas fa-box"></li> Data Stok Artikel
        </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <?php
          if ($cek_status->status == 2) { ?>
            <div class="overlay-wrapper">
              <div class="overlay">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                <div class="text-bold pt-2">Menunggu Approve ...</div>
              </div>
            </div>
          <?php } ?>
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th>Artikel</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Harga</th>
                <th style="width:5px">Diskon (%)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                $no = 0;
                $total = 0;
                foreach ($stok_produk as $stok) {
                  $no++;
                ?>

                  <td class="text-center"><?= $no ?></td>
                  <td>
                    <small>
                      <strong><?= $stok->kode ?></strong> <br>
                      <?= $stok->nama_produk ?>
                    </small>
                  </td>
                  <td class="text-center"><?= $stok->satuan ?></td>
                  <td class="text-center">
                    <?php
                    if ($stok->status == 2) {
                      echo "<span class='badge badge-warning' >belum di approve </span>";
                    } else {
                      echo $stok->qty;
                    }
                    ?>
                  </td>
                  <td class="text-right">
                    <?php
                    if ($stok->status == 2) {
                      echo "<span class='badge badge-warning' >belum di approve </span>";
                    } else {
                      if ($toko->het == 1) {
                        echo "Rp. ";
                        echo number_format($stok->harga_jawa);
                        echo " ,-";
                      } else {
                        echo "Rp. ";
                        echo number_format($stok->harga_indobarat);
                        echo " ,-";
                      }
                    }
                    ?>
                  </td>
                  <td class="text-center">
                    <?= $stok->diskon ?>
                  </td>
              </tr>
            <?php
                  $total += $stok->qty;
                } ?>

            </tbody>
            <tfoot>
              <tr>
                <td colspan="6"></td>
              </tr>
              <tr>
                <td colspan="6" class="text-center"> <strong>Total :</strong> <b><?= $total; ?></b></td>


              </tr>

            </tfoot>
          </table>

        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <i class="fas fa-bullhorn"></i> Data ini merupakan jumlah stok yang dimiliki toko : <b><?= $toko->nama_toko ?></b> .
      </div>
    </div>
  </div>
</section>