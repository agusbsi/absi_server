<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <form>
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">
                <li class="fas fa-check-circle"></li> Penerimaan Barang
              </h3>
              <input type="hidden" name="id_terima" value="<?= $terima->id ?>">
              <div class="card-tools">
                <a href="<?= base_url('spg/Penerimaan') ?>" type="button" class="btn btn-tool">
                  <i class="fas fa-times"></i>
                </a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">No Kirim</label>
                    <input type="text" class="form-control form-control-sm" value="<?= $terima->id ?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">No PO</label>
                    <input type="text" class="form-control form-control-sm" value="<?= $terima->id_permintaan ?>" readonly>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="">Keterangan</label>
                <textarea class="form-control form-control-sm" readonly><?= $terima->keterangan ?></textarea>
              </div>
              <hr>
              List Artikel
              <hr>
              <!-- isi detail list -->
              <table class="table table-bordered table-striped table responsive">
                <thead>
                  <tr class="text-center">
                    <th rowspan="2" style="width: 10%;">No</th>
                    <th rowspan="2" style="width: 45%;">Artikel</th>
                    <th colspan="2">Jumlah</th>
                  </tr>
                  <tr class="text-center">
                    <th>Kirim</th>
                    <th>Terima</th>
                  </tr>
                </thead>
                <?php
                $no = 0;
                foreach ($detail as $d) :
                  $no++ ?>
                  <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td>
                      <small>
                        <strong><?= $d->kode ?></strong> <br>
                        <?= $d->nama_produk ?>
                      </small>
                    </td>
                    <td class="text-center"><?= $d->qty ?></td>
                    <td class="text-center">
                      <?php if ($d->qty != $d->qty_diterima) { ?>
                        <span class="badge badge-sm badge-danger pl-3 pr-3"><?= $d->qty_diterima ?></span>
                      <?php } else { ?>
                        <?= $d->qty_diterima ?>
                      <?php } ?>
                    </td>
                  </tr>
                <?php endforeach ?>
              </table>
              <!-- end detail -->
              <hr>
              <?php if ($terima->status == 3) { ?>
                <i class="fas fa-info text-danger"></i> : <small>Jumlah artikel yang di input tidak sesuai dengan Sistem.</small> <br> <br>
                <small> <span class="btn btn-warning">Segera Buat BAP dan laporkan dengan jelas. !</span></small>
              <?php } else { ?>
                Catatan :
                <textarea class="form-control w-50" id="" cols="20" rows="3" value="<?= $terima->catatan_spg ?>" readonly></textarea>
              <?php } ?>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="#" class="btn btn-warning btn-sm float-right <?= ($terima->status == 3) ? '' : 'd-none' ?>" data-toggle="modal" data-target=".bap"><i class="fas fa-file"></i> Buat BAP</a>
              <a href="<?= base_url('spg/Penerimaan') ?>" type="button" class="btn btn-danger btn-sm float-right mr-2"><i class="fa fa-step-backward" aria-hidden="true"></i> Kembali</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<!-- modal -->
<div class="modal fade bap" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="<?= base_url('spg/Penerimaan/simpan_bap') ?>" method="post">
      <div class="modal-content">

        <div class="modal-header">
          <h3 class="card-title">
            <li class="fas fa-check-circle"></li> Berita Acara Penerimaan
          </h3>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          No Kirim : <?= $terima->id ?>
          <hr>
          <small><i class="fas fa-info"></i> <span class="badge badge-danger">Info ! </span></small> <br>
          <small>Form BAP ini dibuat ketika penerimaan barang tidak sesuai dengan sistem, pastikan anda memberikan laporan yang jelas dan detail.!</small>
          <hr>
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="">Kategori Kasus :</label>
                <input type="hidden" name="id_kirim" value="<?= $terima->id ?>">
                <select name="kategori" class="form-control select2bs4" id="kasus" required>
                  <option value="">- Pilih Kasus -</option>
                  <option value="1">Update Penerimaan Artikel</option>
                  <option value="2">Artikel Hilang</option>
                  <option value="3">Artikel Tambahan</option>
                </select>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group kasus_1 d-none">
                <label for="">Pilih Artikel yang akan di update :</label>
                <select name="artikel_update" class="form-control select2bs4" id="artikel_update">
                  <option value="">- Pilih Artikel -</option>
                  <?php foreach ($detail as $dd) : ?>
                    <option value="<?= $dd->id_produk ?>"><?= $dd->kode ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group kasus_2 d-none">
                <label for="">Pilih Artikel yang Hilang :</label>
                <select name="artikel_hilang" class="form-control select2bs4" id="artikel_hilang">
                  <option value="">- Pilih Artikel -</option>
                  <?php foreach ($detail as $dd) : ?>
                    <option value="<?= $dd->id_produk ?>"><?= $dd->kode ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group kasus_3 d-none">
                <label for="">Pilih Artikel Tambahan :</label>
                <select name="artikel_tambahan" class="form-control select2bs4" id="artikel_tambahan">
                  <option value="">- Pilih Artikel -</option>
                  <?php foreach ($artikel_new as $dd) : ?>
                    <option value="<?= $dd->id_produk ?>"><?= $dd->kode ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="">.</label>
                <br>
                <input type="hidden" name="kode_produk">
                <input type="hidden" name="nama_produk">
                <input type="hidden" name="satuan">
                <input type="hidden" name="qty_diterima">
                <button disabled type="button" class="btn btn-primary btn-block btn-sm d-none" id="pilih"><i class="fas fa-plus"></i> </button>
                <button disabled type="button" class="btn btn-primary btn-block btn-sm d-none" id="pilih_hilang"><i class="fas fa-plus"></i> </button>
                <button disabled type="button" class="btn btn-primary btn-block btn-sm d-none" id="pilih_tambah"><i class="fas fa-plus"></i> </button>
              </div>
            </div>
          </div>
          <hr>
          <div class="keranjang table-responsive d-none">
            <table class="table table-bordered table-striped d-none" id="keranjang">
              <thead>
                <tr>
                  <th>Kode Artikel #</th>
                  <th>Satuan</th>
                  <th style="width:18%">Qty Diterima</th>
                  <th style="width:18%">Qty Update</th>
                  <th style="width:10%">Menu</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            <table class="table table-bordered table-striped d-none" id="list_hilang">
              <thead>
                <tr>
                  <th>Kode Artikel #</th>
                  <th>Satuan</th>
                  <th style="width:18%">Qty Diterima</th>
                  <th style="width:10%">Menu</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            <table class="table table-bordered table-striped d-none" id="list_tambah">
              <thead>
                <tr>
                  <th>Kode Artikel #</th>
                  <th>Nama Artikel</th>
                  <th>Satuan</th>
                  <th style="width:18%">Qty Diterima</th>
                  <th style="width:10%">Menu</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            <hr>
            <div class="form-group">
              <label for="catatan">Catatan </label>
              <textarea name="catatan" id="" class="form-control" cols="1" rows="3" placeholder="Laporkan dengan jelas dan detail..." required></textarea>
            </div>
            <hr>
            <span class="badge badge-warning badge-sm"># Info :</span> <small>Pengajuan B.A.P ini akan diteruskan ke tim Leader dan Marketing verifikasi, setelah semua di setujui akan update data secara otomatis.!</small>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button disabled type="submit" class="btn btn-success" id="simpan">Proses</button>
          </div>
        </div>
    </form>
  </div>
</div>
</div>
<!-- end modal -->
<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    // data array
    var tampung_array = [];


    // table
    $('#table_terima').DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
    });
    // end tabel


    // ketika kasus di pilih
    $('#kasus').change(function() {
      if (tampung_array != '') {
        Swal.fire(
          'Peringatan !',
          'List Artikel yang di tambahkan masih tersimpan, Refresh halaman ini !',
          'info'
        )
        $(this).val('');
      }
      var data = $(this).val();
      if (data == "1") {
        $(".kasus_1").removeClass("d-none");
        $("#pilih").removeClass("d-none");
        $("#pilih_hilang").addClass("d-none");
        $("#pilih_tambah").addClass("d-none");
        $(".kasus_2").addClass("d-none");
        $(".kasus_3").addClass("d-none");
      } else if (data == "2") {
        $(".kasus_2").removeClass("d-none");
        $("#pilih_hilang").removeClass("d-none");
        $("#pilih_tambah").addClass("d-none");
        $("#pilih").addClass("d-none");
        $(".kasus_1").addClass("d-none");
        $(".kasus_3").addClass("d-none");
      } else if (data == "3") {
        $(".kasus_3").removeClass("d-none");
        $("#pilih_tambah").removeClass("d-none");
        $("#pilih").addClass("d-none");
        $("#pilih_hilang").addClass("d-none");
        $(".kasus_1").addClass("d-none");
        $(".kasus_2").addClass("d-none");
      } else {
        $("#pilih").addClass("d-none");
        $("#pilih_hilang").addClass("d-none");
        $("#pilih_tambah").addClass("d-none");
        $(".kasus_1").addClass("d-none");
        $(".kasus_2").addClass("d-none");
        $(".kasus_3").addClass("d-none");
      }
    });

    // ketika plih produk
    $('#artikel_update').on('change', function() {
      for (var i = 0; i < tampung_array.length; i++) {
        if ($(this).val() == tampung_array[i]) {
          Swal.fire(
            'Peringatan !',
            'Artikel sudah ada di list Pilihan !',
            'info'
          )
          $(this).val('');
        }
      }
      // menampilkan detail permintaan
      var id = $(this).val();
      var id_terima = $('input[name="id_terima"]').val();
      $.ajax({
        type: 'get',
        url: '<?php echo base_url() ?>spg/Penerimaan/list_selisih/' + id,
        async: true,
        data: {
          id: id,
          id_terima: id_terima
        },
        dataType: 'json',
        success: function(data) {
          $('input[name="kode_produk"]').val(data.kode);
          $('input[name="qty_diterima"]').val(data.qty_diterima);
          $('input[name="satuan"]').val(data.satuan);
          $('button#pilih').prop('disabled', false)
        }

      });
      // end detail permintaan
    });
    // ketika plih produk
    $('#artikel_hilang').on('change', function() {

      for (var i = 0; i < tampung_array.length; i++) {
        if ($(this).val() == tampung_array[i]) {
          Swal.fire(
            'Peringatan !',
            'Artikel sudah ada di list Pilihan !',
            'info'
          )
          $(this).val('');
        }
      }
      // menampilkan detail permintaan
      var id = $(this).val();
      var id_terima = $('input[name="id_terima"]').val();
      $.ajax({
        type: 'get',
        url: '<?php echo base_url() ?>spg/Penerimaan/list_selisih/' + id,
        async: true,
        data: {
          id: id,
          id_terima: id_terima
        },
        dataType: 'json',
        success: function(data) {
          $('input[name="kode_produk"]').val(data.kode);
          $('input[name="qty_diterima"]').val(data.qty_diterima);
          $('input[name="satuan"]').val(data.satuan);
          $('button#pilih_hilang').prop('disabled', false)
        }

      });
      // end detail permintaan
    });
    // ketika plih produk
    $('#artikel_tambahan').on('change', function() {
      console.log(tampung_array);
      for (var i = 0; i < tampung_array.length; i++) {
        if ($(this).val() == tampung_array[i]) {
          Swal.fire(
            'Peringatan !',
            'Artikel sudah ada di list Pilihan !',
            'info'
          )
          $(this).val('');
        }
      }
      // menampilkan detail permintaan
      var id = $(this).val();
      $.ajax({
        type: 'get',
        url: '<?php echo base_url() ?>spg/Penerimaan/artikel_tambahan/' + id,
        async: true,
        data: {
          id: id
        },
        dataType: 'json',
        success: function(data) {
          $('input[name="kode_produk"]').val(data.kode);
          $('input[name="nama_produk"]').val(data.nama_produk);
          $('input[name="satuan"]').val(data.satuan);
          $('button#pilih_tambah').prop('disabled', false)
        }

      });
      // end detail permintaan
    });

    // ketika tombol pilih di klik
    $(document).on('click', '#pilih', function(e) {

      const keranjang_update = {
        id_produk: $('select[name="artikel_update"]').val(),
        kode_produk: $('input[name="kode_produk"]').val(),
        satuan: $('input[name="satuan"]').val(),
        qty: $('input[name="qty_diterima"]').val(),
        keranjang: $('input[name="id_produk_hidden[]"]').val(),
      }
      $.ajax({
        url: '<?php echo base_url() ?>spg/penerimaan/keranjang',
        type: 'POST',
        data: keranjang_update,
        success: function(data) {
          tampung_array.push(keranjang_update.id_produk);
          $('.keranjang').removeClass('d-none');
          $('#keranjang').removeClass('d-none');
          $('#list_hilang').addClass('d-none');
          $('#list_tambah').addClass('d-none');
          $('table#keranjang tbody').append(data)
          $('button#pilih').prop('disabled', true);
          $('button#simpan').prop('disabled', false);
        }
      })
    });
    // ketika tombol pilih hilang di klik
    $(document).on('click', '#pilih_hilang', function(e) {

      const keranjang_update = {
        id_produk: $('select[name="artikel_hilang"]').val(),
        kode_produk: $('input[name="kode_produk"]').val(),
        satuan: $('input[name="satuan"]').val(),
        qty: $('input[name="qty_diterima"]').val(),
        keranjang: $('input[name="id_produk_hidden[]"]').val(),
      }
      $.ajax({
        url: '<?php echo base_url() ?>spg/penerimaan/list_hilang',
        type: 'POST',
        data: keranjang_update,
        success: function(data) {
          tampung_array.push(keranjang_update.id_produk);
          $('.keranjang').removeClass('d-none');
          $('#list_hilang').removeClass('d-none');
          $('#keranjang').addClass('d-none');
          $('#list_tambah').addClass('d-none');
          $('table#list_hilang tbody').append(data)
          $('button#pilih_hilang').prop('disabled', true);
          $('button#simpan').prop('disabled', false);
        }
      })
    });
    // ketika tombol pilih hilang di klik
    $(document).on('click', '#pilih_tambah', function(e) {
      const keranjang_update = {
        id_produk: $('select[name="artikel_tambahan"]').val(),
        kode_produk: $('input[name="kode_produk"]').val(),
        nama_produk: $('input[name="nama_produk"]').val(),
        satuan: $('input[name="satuan"]').val(),
        keranjang: $('input[name="id_produk_hidden[]"]').val(),
      }
      $.ajax({
        url: '<?php echo base_url() ?>spg/penerimaan/list_tambah',
        type: 'POST',
        data: keranjang_update,
        success: function(data) {
          tampung_array.push(keranjang_update.id_produk);
          $('.keranjang').removeClass('d-none');
          $('#list_tambah').removeClass('d-none');
          $('#keranjang').addClass('d-none');
          $('#list_hilang').addClass('d-none');
          $('table#list_tambah tbody').append(data)
          $('button#pilih_tambah').prop('disabled', true);
          $('button#simpan').prop('disabled', false);
        }
      })
    });


    // fungsi hapus
    $(document).on('click', '#tombol-hapus', function() {
      $(this).closest('.row-keranjang').remove()
      if ($('tbody').children().length == 0) $('tfoot').hide()
    })
    // fungsi hapus
    $(document).on('click', '#btn_hilang', function() {
      $(this).closest('.row-list_hilang').remove()
      if ($('tbody').children().length == 0) $('tfoot').hide()
    })
    // fungsi hapus
    $(document).on('click', '#btn_tambah', function() {
      $(this).closest('.row-list_tambah').remove()
      if ($('tbody').children().length == 0) $('tfoot').hide()
    })

  });
</script>