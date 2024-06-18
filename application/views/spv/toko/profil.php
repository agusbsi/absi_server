<!-- Main content -->
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
  </div>
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
                <td><b>SSR</b></td>
                <td>
                  : <?= $toko->ssr ?> x rata-rata penjualan 3 bulan terakhir.
                </td>
              </tr>
              <tr>
                <td><b>Batas PO</b></td>
                <td>
                  : <?= $toko->status_ssr == 1 ? '<span class = "badge badge-success"> Aktif </span>  <small> ( PO barang di batasi dengan SSR ) </small>' : '<span class = "badge badge-danger"> Tidak Aktif </span> <small> ( PO barang Tidak di batasi ) </samll>' ?>
                </td>
              </tr>
              <tr>
                <td><b>Jenis Harga</b></td>
                <td>
                  : <?= status_het($toko->het) ?>
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
                <td><b>Team Leader</b></td>
                <td>
                  : <?= empty($leader_toko) ? "Belum di kaitkan " : $leader_toko->nama_user ?>
                </td>
              </tr>
              <tr>
                <td><b>Spg</b></td>
                <td>
                  : <?= empty($spg) ? "Belum di kaitkan " : $spg->nama_user ?>
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

      <div class="card-tools">
        <li class="fas fa-clock"></li> Update data terakhir : <?= (isset($last_update)) ? $last_update : "" ?>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <button type="button" class="btn btn-success btn-sm float-right mr-2 btn_tambah <?= ($cek_status->status == 2) ? 'd-none' : '' ?>" data-id_toko="<?= $toko->id ?>" data-toggle="modal" data-target="#modal-tambah-produk"><i class="fa fa-plus"></i> Tambah Produk</button>
      <button type="button" class="btn btn-default btn-sm btn-sm">Toko ini berlaku untuk harga : <?= status_het($toko->het) ?></button>
      <hr>
      <div class="tab-content">
        <table id="table_stok" class="table table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>Kode</th>
              <th style="width:30%">Artikel</th>
              <th>Satuan</th>
              <th>Stok</th>
              <th>Harga</th>
              <th style="width:5px">menu</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php
              $no = 0;
              $total = 0;
              foreach ($stok_produk as $stok) {
                $no++
              ?>
                <td><?= $no ?></td>

                <td>
                  <small><?= $stok->kode ?></small>
                </td>
                <td>
                  <small><?= $stok->nama_produk ?></small>
                </td>
                <td class="text-center">
                  <small><?= $stok->satuan ?></small>
                </td>
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
                  <?php
                  if ($stok->qty == 0) {
                  ?>
                    <a href="<?= base_url('spv/Toko/hapus_item/' . $stok->id) ?>" class="text-danger"><i class="fas fa-trash"></i></a>
                  <?php } else { ?>
                    -
                  <?php } ?>
                </td>
            </tr>
          <?php
                $total += $stok->qty;
              } ?>

          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-right"> <strong>Total :</strong> </td>
              <td class="text-center"><b><?php
                                          if ($cek_status_stok > 0) {
                                            echo "<span class='badge badge-warning' >belum di approve </span>";
                                          } else {
                                            echo $total;
                                          }
                                          ?></b></td>
              <td></td>
              <td></td>
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

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<!-- Modal Tambah Produk -->
<div class="modal fade" id="modal-tambah-produk" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="modal-supervisor">Tambah Artikel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-8">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" class="form-control form-control-sm " id="searchInput" placeholder="Cari artikel...">
          </div>
        </div>
        <form action="<?= base_url('spv/toko/tambah_artikel') ?>" role="form" method="post">
          <div style="overflow-x: auto; max-height : 300px;">
            <table id="myTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Artikel</th>
                  <th>
                    <input type="checkbox" id="cekAll">
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($list_produk as $pr) {
                  $no++; ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><small><?= $pr->kode ?></small></td>
                    <td><small><?= $pr->nama_produk ?></small></td>
                    <td>
                      <input type="checkbox" name="id_produk[]" class="checkbox-item" value="<?= $pr->id ?>">
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <span class="badge badge-warning">Catatan :</span>
          <address>
            Penambahan artikel ini akan aktif setelah di approve dari manager marketing.
          </address>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="id_toko" value="<?= $toko->id ?>">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Tambah Data</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- end modal tambah produk -->

<!-- jQuery -->
<script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/app/js/alert.js"></script>
<script>
  $(document).ready(function() {

    $('#table_stok').DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
    });
    $("#cekAll").click(function() {
      $(".checkbox-item").prop('checked', $(this).prop('checked'));
    });

    $(".checkbox-item").change(function() {
      if (!$(this).prop("checked")) {
        $("#cekAll").prop("checked", false);
      }
    });
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


  })
</script>