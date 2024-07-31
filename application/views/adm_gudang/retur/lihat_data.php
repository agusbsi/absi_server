<!-- Main content -->
<section class="content">
  <div class="card card-info ">
    <div class="card-header">
      <h3 class="card-title">
        <li class="fas fa-exchange-alt"></li> Data Retur Barang
      </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th>#</th>
            <th>Nomor</th>
            <th style="width: 26%;">Nama Toko</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Menu</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php
            $no = 0;
            foreach ($list_data as $dd) :
              $no++;
            ?>
              <td><?= $no ?></td>
              <td><small><strong><?= $dd->id ?></strong></small></td>
              <td>
                <small>
                  <strong><?= $dd->nama_toko ?></strong> <br>
                  <address><?= $dd->alamat ?></address>
                </small>
              </td>
              <td><?= status_retur($dd->status) ?></td>
              <td>
                <small>
                  Dibuat : <?= date('d M Y', strtotime($dd->created_at)) ?> <br>
                  Penjemputan : <?= date('d M Y', strtotime($dd->tgl_jemput)) ?>
                </small>
              </td>
              <td class="text-center">

                <?php
                if ($dd->status == 4 or $dd->status == 15) {
                ?>
                  <a href="<?= base_url('adm_gudang/Retur/detail/' . $dd->id) ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail</a>
                <?php } else { ?>
                  <div class="btn-group">
                    <button type="button" class="btn btn-outline-success btn-sm"> Proses</button>
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="#" onclick="getCatatan('<?php echo $dd->id; ?>')">Lihat Catatan</a>
                      <div class="dropdown-divider"></div>
                      <?php
                      if ($dd->status == 13 or $dd->status == 14) {
                      ?>
                        <a class="dropdown-item" target="_blank" href="<?= base_url('adm_gudang/Retur/sppr_toko/' . $dd->id) ?>">Cetak SPPR</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= base_url('adm_gudang/Retur/terima_toko/' . $dd->id) ?>">Terima Barang</a>
                      <?php } else { ?>
                        <a class="dropdown-item" target="_blank" href="<?= base_url('adm_gudang/Retur/sppr/' . $dd->id) ?>">Cetak SPPR</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= base_url('adm_gudang/Retur/terima/' . $dd->id) ?>">Terima Barang</a>
                      <?php } ?>
                    </div>
                  </div>
                <?php } ?>
              </td>

          </tr>
        <?php endforeach; ?>

        </tbody>

      </table>
    </div>
    <!-- /.card-body -->

  </div>
</section>

<div class="modal fade" id="modalHistori" tabindex="-1" role="dialog" aria-labelledby="modalHistoriTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHistoriTitle">Histori Pengajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="timeline">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<!-- modal terima -->
<div class="modal fade" id="terima" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form id="terima-form" action="<?= base_url('adm_gudang/Retur/terimBarang') ?>" method="post">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="exampleModalLabel">Detail Terima Barang Retur</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
          <div class="row">
            <div class="col-md-3">
              No Retur : <strong><span class="text-danger" id="no_pengajuan"></span></strong>
            </div>
            <div class="col-md-3">
              Nama Toko : <strong><span class="text-danger" id="toko"></span></strong>
            </div>
          </div>
          <hr>
          <b># List Aset :</b>
          <table class="table responsive">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Kode Aset</th>
                <th>Aset</th>
                <th>Qty Retur</th>
                <th>Kondisi</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody id="list_aset"></tbody>
          </table>
          <hr>
          <b># List Artikel :</b>
          <table class="table responsive">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Kode Artikel</th>
                <th>Deskripsi</th>
                <th style="width: 15%;">Qty Retur</th>
                <th style="width: 15%;">Qty Input</th>
                <th style="width: 15%;">Qty Terima</th>
              </tr>
            </thead>
            <tbody id="list_artikel"></tbody>
          </table>
          <hr>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Catatan SPV:</label><br />
                <textarea name="catatan" id="hasil_catatan" class="form-control" rows="3" cols="100%" readonly></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Catatan MV:</label><br />
                <textarea name="catatan" id="catatan_mv" class="form-control" rows="3" cols="100%" readonly></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Catatan MM:</label><br />
                <input type="hidden" name="id_retur" id="no_retur">
                <input type="hidden" name="id_toko" id="id_toko">
                <textarea name="catatan_mm" id="catatan_mm" class="form-control" rows="3" cols="100%" readonly></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success btn-sm d-none" id="btn_approve">Simpan Penerimaan</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="exampleModalLabel">Detail Terima Barang Retur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
        <div class="row">
          <div class="col-md-3">
            No Retur : <strong><span class="text-danger" id="no_pengajuanDetail"></span></strong>
          </div>
          <div class="col-md-3">
            Nama Toko : <strong><span class="text-danger" id="tokoDetail"></span></strong>
          </div>
        </div>
        <hr>
        <b># List Artikel :</b>
        <table class="table responsive">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th>Kode Artikel</th>
              <th>Deskripsi</th>
              <th style="width: 15%;">Qty Retur</th>
              <th style="width: 15%;">Qty Terima</th>
            </tr>
          </thead>
          <tbody id="list_artikelDetail"></tbody>
        </table>
        <hr>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Catatan SPV:</label><br />
              <textarea name="catatan" id="hasil_catatanDetail" class="form-control" rows="3" cols="100%" readonly></textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Catatan MV:</label><br />
              <textarea name="catatan" id="catatan_mvDetail" class="form-control" rows="3" cols="100%" readonly></textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Catatan MM:</label><br />
              <textarea name="catatan_mm" id="catatan_mmDetail" class="form-control" rows="3" cols="100%" readonly></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script>
  function getCatatan(id) {
    $.ajax({
      url: '<?= base_url('adm_gudang/Retur/getCatatan/') ?>' + id, // Ganti url dengan endpoint Anda
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.status === 'success') {
          // Bersihkan konten timeline sebelum menambahkan data baru
          $('.timeline').empty();

          // Iterasi data histori dan tambahkan ke dalam timeline
          $.each(response.data, function(index, item) {
            var timelineItem = `
                <div>
                  <i class="fas bg-blue">${index + 1}</i>
                  <div class="timeline-item">
                    <span class="time"></span>
                    <p class="timeline-header"><small>${item.aksi} <strong>${item.pembuat}</strong></small></p>
                    <div class="timeline-body">
                      <small>
                        ${item.tanggal} <br>
                        Catatan :<br>
                        ${item.catatan_h}
                      </small>
                    </div>
                  </div>
                </div>
              `;
            $('.timeline').append(timelineItem);
          });

          // Tampilkan modal
          $('#modalHistori').modal('show');
        } else {
          // Tampilkan pesan error jika terjadi kesalahan
          alert('Catatan Tidak Ditemukan.');
        }
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        alert('Terjadi kesalahan saat mengambil data histori.');
      }
    });
  }

  function getterima(id, toko) {
    // Menggunakan Ajax untuk mengambil data artikel dari server
    $.ajax({
      url: '<?= base_url('adm_gudang/Retur/getdataRetur') ?>', // Ganti dengan URL ke fungsi controller yang mengambil data artikel
      type: 'GET',
      data: {
        id_retur: id
      },
      success: function(data) {
        // Mengupdate nilai-nilai pada modal
        $("#hasil_catatan").val(data.catatan);
        $("#catatan_mv").val(data.catatan_mv);
        $("#catatan_mm").val(data.catatan_mm);
        $("#no_retur").val(id);
        $("#id_toko").val(data.id_toko);
        $("#no_pengajuan").text(id);
        $("#toko").text(toko);
        $("#tgl_tarik").text(data.tgl_tarik);

        // Dapatkan elemen textarea
        var catatan_mm = document.getElementById('catatan_mm');

        if (data.status == 13 || data.status == 14) {
          $("#btn_approve").removeClass('d-none');
        } else {
          $("#btn_approve").addClass('d-none');
        }

        if (data.artikel.length > 0) {
          var artikelHtml = '';
          var totalQty = 0; // Variabel untuk menyimpan total qty
          var terimaQty = 0; // Variabel untuk menyimpan total qty_terima

          $.each(data.artikel, function(i, item) {
            artikelHtml += '<tr>';
            artikelHtml += '<td class="text-center">' + (i + 1) + '</td>';
            artikelHtml += '<td>' + item.kode + '</td>';
            artikelHtml += '<td>' + item.nama_produk + '</td>';
            artikelHtml += '<td>' + item.qty + '</td>';
            artikelHtml += '<td> <input type="number" name="qty_terima[]" class="form-control form-control-sm qty-input" value="' + item.qty_terima + '" required></td>';
            artikelHtml += '<td> <input type="number"  class="form-control form-control-sm " value="' + item.qty_terima + '" readonly></td>';
            artikelHtml += '<td><input type="hidden" name="id_produk[]" value="' + item.id_produk + '" required></td>';
            artikelHtml += '</tr>';

            var itemQty = parseInt(item.qty); // Ambil qty dari item saat ini
            var itemTerima = parseInt(item.qty_terima); // Ambil qty dari item saat ini
            totalQty += itemQty; // Menambahkan qty ke totalQty
            terimaQty += itemTerima;
          });

          // Tambahkan event listener pada input qty_terima
          $(document).on('input', '.qty-input', function() {
            terimaQty = 0;

            // Loop melalui setiap input qty_terima
            $('.qty-input').each(function() {
              var qty = parseInt($(this).val());
              var itemQty = isNaN(qty) ? 0 : qty; // Menggunakan 0 jika qty bukan angka

              terimaQty += itemQty;
            });

            // Tampilkan totalQty di dalam elemen dengan id "totalQty"
            $("#totalQty").text(totalQty);
            $("#terimaQty").text(terimaQty);
          });

          // Menambahkan baris total qty
          artikelHtml += '<tr>';
          artikelHtml += '<td colspan="3" class="text-right"><strong>Total Qty:</strong></td>';
          artikelHtml += '<td><strong><span id="totalQty">' + totalQty + '</span></strong></td>';
          artikelHtml += '<td><strong><span ></span></strong></td>';
          artikelHtml += '<td><strong><span id="terimaQty">' + terimaQty + '</span></strong></td>';
          artikelHtml += '</tr>';

          $("#list_artikel").html(artikelHtml);
        } else {
          $("#list_artikel").html('<tr><td colspan="4" class="text-center"><strong>Artikel Kosong</strong></td></tr>');
        }

        // list aset
        if (data.aset.length > 0) {
          var asetHtml = '';

          $.each(data.aset, function(i, item) {
            asetHtml += '<tr>';
            asetHtml += '<td class="text-center">' + (i + 1) + '</td>';
            asetHtml += '<td>' + item.id_aset + '</td>';
            asetHtml += '<td>' + item.nama_aset + '</td>';
            asetHtml += '<td>' + item.qty + '</td>';
            asetHtml += '<td>' + item.kondisi + '</td>';
            asetHtml += '<td>' + item.keterangan + '</td>';
            asetHtml += '</tr>';
          });

          $("#list_aset").html(asetHtml);
        } else {
          $("#list_aset").html('<tr><td colspan="6" class="text-center"><strong>Aset Kosong</strong></td></tr>');
        }
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });

  }

  function getdetail(id, toko) {
    // Menggunakan Ajax untuk mengambil data artikel dari server
    $.ajax({
      url: '<?= base_url('adm_gudang/Retur/getdataRetur') ?>',
      type: 'GET',
      data: {
        id_retur: id
      },
      success: function(data) {
        // Mengupdate nilai-nilai pada modal
        $("#hasil_catatanDetail").val(data.catatan);
        $("#catatan_mvDetail").val(data.catatan_mv);
        $("#catatan_mmDetail").val(data.catatan_mm);
        $("#no_pengajuanDetail").text(id);
        $("#tokoDetail").text(toko);
        var catatan_mm = document.getElementById('catatan_mmDetail');
        if (data.artikel.length > 0) {
          var artikelHtml = '';
          var totalQty = 0;
          var terimaQty = 0;
          $.each(data.artikel, function(i, item) {
            artikelHtml += '<tr>';
            artikelHtml += '<td class="text-center">' + (i + 1) + '</td>';
            artikelHtml += '<td>' + item.kode + '</td>';
            artikelHtml += '<td>' + item.nama_produk + '</td>';
            artikelHtml += '<td>' + item.qty + '</td>';
            artikelHtml += '<td> <input type="number"  class="form-control form-control-sm " value="' + item.qty_terima + '" readonly></td>';
            artikelHtml += '<td><input type="hidden" name="id_produk[]" value="' + item.id_produk + '" required></td>';
            artikelHtml += '</tr>';
            var itemQty = parseInt(item.qty);
            var itemTerima = parseInt(item.qty_terima);
            totalQty += itemQty;
            terimaQty += itemTerima;
          });
          $(document).on('input', '.qty-input', function() {
            terimaQty = 0;
            $('.qty-input').each(function() {
              var qty = parseInt($(this).val());
              var itemQty = isNaN(qty) ? 0 : qty;
              terimaQty += itemQty;
            });
            $("#totalQty").text(totalQty);
            $("#terimaQty").text(terimaQty);
          });
          artikelHtml += '<tr>';
          artikelHtml += '<td colspan="3" class="text-right"><strong>Total Qty:</strong></td>';
          artikelHtml += '<td><strong><span id="totalQty">' + totalQty + '</span></strong></td>';
          artikelHtml += '<td><strong><span id="terimaQty">' + terimaQty + '</span></strong></td>';
          artikelHtml += '</tr>';

          $("#list_artikelDetail").html(artikelHtml);
        } else {
          $("#list_artikelDetail").html('<tr><td colspan="4" class="text-center"><strong>Artikel Kosong</strong></td></tr>');
        }
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });

  }
</script>

<script type="text/javascript">
  const role = "<?= $this->session->userdata('role') ?>";
  if (role != 5) {
    $(".btnHide").addClass('disabled');
  }
</script>