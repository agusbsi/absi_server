<style>
  #loading {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(255, 255, 255, 0.7);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .loader {
    position: relative;
    width: 200px;
    height: 200px;
  }

  .circle {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: conic-gradient(#3498db 0deg, #3498db 0deg, transparent 0deg);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .percentage {
    position: absolute;
    font-size: 2em;
    font-weight: bold;
    color: #ffc107;
  }

  .img-nodata {
    width: 100%;

  }
</style>
<section class="content">
  <div id="loading" style="display: none;">
    <div class="loader">
      <div class="circle">
        <div class="percentage" id="percentage">0%</div>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="card card-info ">
      <div class="card-header">
        <h3 class="card-title">
          <li class="fas fa-truck"></li> Data Pengiriman
        </h3>
        <div class="card-tools">
        </div>
        <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <form action="<?= base_url('adm_gudang/Pengiriman') ?>" method="post" id="form_cari">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Modul Export ke Easy</label> <br>
                <button type="button" data-toggle="modal" data-target="#modal-export-all" class="btn btn-warning btn-block btn-sm btn_export_all" title="Export ke Easy"><i class="fa fa-file-export"></i> Export Multiple PO</button>
              </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Kategori</label>
                <?php if (empty($kat)) { ?>
                  <input type="text" name="kategori" value="<?= !empty($kat) ? $kat : '' ?>" class="form-control form-control-sm" placeholder="Cari berdasarkan Nomor atau Nama Toko">
                <?php } else { ?>
                  <input type="text" class="form-control form-control-sm" value="<?= $kat ?>" readonly>
                <?php } ?>

              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Range Tanggal</label>
                <?php if (empty($tgl)) { ?>
                  <input type="text" name="tanggal" class="form-control form-control-sm" autocomplete="off" placeholder="Periode">
                <?php } else { ?>
                  <input type="text" class="form-control form-control-sm" value="<?= $tgl ?>" readonly>
                <?php } ?>
              </div>
            </div>
            <div class="col-md-2">
              <br>
              <?php if (!empty($tgl || $kat)) { ?>
                <a href="<?= base_url('adm_gudang/Pengiriman') ?>" class="btn btn-sm btn-danger mt-2"><i class="fas fa-times-circle"></i> Reset</a>
              <?php } else { ?>
                <button class="btn btn-info btn-sm mt-2" id="btn_cari"><i class="fas fa-search"></i> Cari Data</button>
              <?php } ?>
            </div>
          </div>
        </form>
        <hr>
        <!-- isi konten -->
        <table id="table_kirim" class="table table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th>No.</th>
              <th style="width: 15%;">Kode #</th>
              <th>Status</th>
              <th style="width: 30%;">Nama Toko</th>
              <th>Tanggal</th>
              <th style="width: 14%;">Menu</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            foreach ($list as $dd) :
              $no++;
            ?>
              <tr>
                <td><?= $no ?></td>
                <td><?= $dd->id ?></td>
                <td>
                  <?= status_pengiriman($dd->status) ?>
                </td>
                <td>
                  <b style="font-size:small"><?= $dd->nama_toko ?> </b><br>
                  <small><b>Leader :</b> <?= $dd->leader ? $dd->leader : 'Tidak ada' ?> </small>
                </td>
                <td>
                  <small><?= date("d F Y, H:i:s", strtotime($dd->created_at)) ?></small>
                </td>

                <td>

                  <a type="button" class="btn btn-primary btn-sm" href="<?= base_url('adm_gudang/pengiriman/detail_p/' . $dd->id) ?>" name="btn_detail" title="Detail"><i class="fa fa-eye" aria-hidden="true"></i> </a>
                  <button type="button" data-id="<?= $dd->id ?>" data-id_po="<?= $dd->id_permintaan ?>" data-toko="<?= $dd->nama_toko ?>" data-toggle="modal" data-target="#modal-export" class="btn btn-warning btn-sm btn_export" title="Export ke Easy"><i class="fa fa-file-export"></i> </button>
                  <a type="button" class="btn btn-default btn-sm <?= ($dd->status != "1") ? 'd-none' : ''; ?>" target="_blank" href="<?= base_url('adm_gudang/Pengiriman/detail_print/' . $dd->id) ?>" title="Print Surat Jalan"><i class="fa fa-print" aria-hidden="true"></i></a>

                </td>

              </tr>
            <?php endforeach; ?>

          </tbody>

        </table>
      </div>
      <!-- /.card-body -->

    </div>
    <!-- /.card -->
  </div>
</section>
<div class="modal fade" id="modal-export-all">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h4 class="modal-title">
          <li class="fa fa-excel"></li> Integrasi Data ke Easy Accounting
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formExport-all" method="post" action="<?= base_url('adm_gudang/Pengiriman/export_ea_all'); ?>">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="file">Gudang Tujuan</label>
                <select name="gudang" class="form-control form-control-sm select2" required>
                  <option value="">- Pilih Gudang -</option>
                  <?php
                  $pt = $this->session->userdata('pt');
                  if ($pt == "PASIFIK KREASI PRIMAJAYA") {
                    echo '<option value="PASIFIK"> GUDANG PASIFIK </option>';
                    echo '<option value="TOKO"> GUDANG TOKO </option>';
                  } else {
                    echo '<option value="VISTA"> GUDANG VISTA </option>';
                  } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="file">Tanggal</label>
                <input type="date" name="tanggal_all" class="form-control form-control-sm" required>
              </div>
              <br>
              <br>
              <hr>
              <div class="text-center">
                <strong>Jumlah Pengiriman yang dipilih : </strong> <br>
                <h1 id="selectedCount" class="headline text-warning" style="font-size: 80px; font-weight:bold">0</h1>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="file">List Pengiriman</label>
                <div class="input-group mb-1">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                  </div>
                  <input type="text" class="form-control form-control-sm " id="searchInput" placeholder="Cari Berdasarkan Nomor Kirim, Nama Toko...">
                </div>
                <div style="overflow-x: auto; max-height : 300px;">
                  <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                      <tr class="text-center">
                        <th>No</th>
                        <th>Nomor</th>
                        <th>
                          <input type="checkbox" id="cekAll">
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 0;
                      foreach ($list_po as $pr) {
                        $no++; ?>
                        <tr>
                          <td class="text-center"><?= $no ?></td>
                          <td>
                            <small>
                              <strong><?= $pr->id ?></strong> <br>
                              <?= $pr->nama_toko ?>
                            </small>
                          </td>
                          <td class="text-center">
                            <input type="checkbox" name="id_kirim_all[]" class="checkbox-item" value="<?= $pr->id ?>">
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <small>* Hanya menampilkan data pengiriman yang "sedang di kirim".</small>
            </div>
          </div>
      </div>
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
          <li class="fas fa-times-circle"></li> Close
        </button>
        <button type="submit" class="btn btn-primary btn-sm " id="export-button-all">
          <li class="fas fa-file-export"></li> Export
        </button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-export">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h4 class="modal-title">
          <li class="fa fa-excel"></li> Integrasi Data ke Easy Accounting
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formExport" method="post" action="<?= base_url('adm_gudang/Pengiriman/export_ea'); ?>">
          <div class="form-group">
            <label for="file">No. Transfer</label>
            <input type="text" name="no_transfer" class="form-control form-control-sm" placeholder="Gunakan no urut dr Easy Accounting..." required>
            <input type="hidden" name="id_kirim" id="id_kirim">
            <input type="hidden" name="id_po" id="id_po">
          </div>
          <div class="form-group">
            <label for="file">Tanggal</label>
            <input type="date" name="tanggal_exp" class="form-control form-control-sm" required>
          </div>
          <div class="form-group">
            <label for="file">Toko</label>
            <input type="text" name="toko" class="form-control form-control-sm nama_toko" readonly>
          </div>
      </div>
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
          <li class="fas fa-times-circle"></li> Close
        </button>
        <button type="submit" class="btn btn-primary btn-sm" id="export-button">
          <li class="fas fa-file-export"></li> Export
        </button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script>
  $(document).ready(function() {

    $('#table_kirim').DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
    });
  })
</script>
<script>
  document.getElementById('export-button').addEventListener('click', function(event) {
    event.preventDefault(); // Menghentikan eksekusi default (submit) dari tombol
    var noTransfer = $('[name="no_transfer"]').val();
    var tanggal = $('[name="tanggal_exp"]').val();
    if (noTransfer == "" || tanggal == "") { // Menggunakan operator || (atau) agar salah satu dari kedua input tidak boleh kosong
      alert('No Transfer & Tanggal tidak boleh kosong');
    } else {
      // Jalankan submit di sini
      document.getElementById('formExport').submit(); // Ganti 'form-id' dengan ID formulir Anda
      alert('Berhasil Export Data');
      $('#modal-export').modal('hide');
      $('[name="no_transfer"]').val('');
      $('[name="tanggal_exp"]').val('');
    }

  });
</script>
<script>
  document.getElementById('export-button-all').addEventListener('click', function(event) {
    event.preventDefault(); // Menghentikan eksekusi default (submit) dari tombol
    const checkedCount = document.querySelectorAll('.checkbox-item:checked').length;
    const checkboxes = document.querySelectorAll('.checkbox-item');
    var gudang = $('[name="gudang"]').val();
    var tanggal = $('[name="tanggal_all"]').val();
    if (gudang == "" || tanggal == "") {
      Swal.fire(
        'BELUM LENGKAP',
        'Gudang Dan Tanggal tidak boleh kosong.',
        'info'
      );
    } else if (checkedCount === 0) {
      Swal.fire(
        'BELUM LENGKAP',
        'Minimal 1 Nomor harus terpilih.',
        'info'
      );
    } else {
      document.getElementById('formExport-all').submit();
      alert('Berhasil Export Data');
      $('#modal-export-all').modal('hide');
      $('[name="tanggal_all"]').val('');
      $('[name="gudang"]').val('').trigger('change');
      checkboxes.forEach((checkbox) => {
        checkbox.checked = false;
      });
      const count = document.querySelectorAll('.checkbox-item:checked').length;
      selectedCount.textContent = count;
    }

  });
</script>

<script>
  $('.btn_export').on('click', function() {
    // get data from button edit
    const id = $(this).data('id');
    const id_po = $(this).data('id_po');
    const toko = $(this).data('toko');
    // Set data to Form Edit
    $('#id_kirim').val(id);
    $('#id_po').val(id_po);
    $('.nama_toko').val(toko);
    // Call Modal Edit
    $('#modal-export').modal('show');
  });
</script>
<script>
  $(document).ready(function() {
    $('input[name="tanggal"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
        cancelLabel: 'Clear'
      }
    });

    $('input[name="tanggal"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('input[name="tanggal"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
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
  document.getElementById('btn_cari').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent form submission

    var loadingElement = document.getElementById('loading');
    loadingElement.style.display = 'flex';
    var percentageElement = document.getElementById('percentage');
    var circle = document.querySelector('.circle');
    var percentage = 0;
    var intervalTime = 50; // Update every 50ms
    var intervalDuration = 500; // 2 seconds

    var interval = setInterval(() => {
      if (percentage < 100) {
        percentage += 5;
        percentageElement.textContent = Math.round(percentage) + '%';
        var angle = percentage * 3.6;
        circle.style.background = `conic-gradient(
                #3498db 0deg,
                #3498db ${angle}deg,
                transparent ${angle}deg,
                transparent 360deg
            )`;
      } else {
        clearInterval(interval);
        setTimeout(() => {
          document.getElementById('form_cari').submit();
        }, intervalDuration);
      }
    }, intervalTime);
  });
</script>
<script>
  $(document).ready(function() {
    const form = document.getElementById('formExport-all');
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


  });
</script>