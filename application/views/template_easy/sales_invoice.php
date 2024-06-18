<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        Export Data Sales Invoice
      </div>
      <form action="<?= base_url('template/Sales_Invoice/export_ea') ?>" id="form_id" method="post">
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Berdasarkan</label>
                <select name="pilihan" id="parameter" class="form-control form-control-sm" required>
                  <option value="">- Pilih Parameter -</option>
                  <option value="customer"> Customer </option>
                  <option value="toko"> Toko </option>
                </select>
              </div>
            </div>
            <div id="group_big" class="col-md-4 d-none">
              <div class="form-group d-none" id="group_cust">
                <label for="">Nama Customer</label>
                <select name="id_cust" id="id_cust" class="form-control form-control-sm select2" required>
                  <option value="">- Pilih Customer -</option>
                  <?php
                  foreach ($cust as $t) :
                  ?>
                    <option value="<?= $t->id ?>"><?= $t->nama_cust ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group d-none" id="group_toko">
                <label for="">Nama Toko</label>
                <select name="id_toko" id="id_toko" class="form-control form-control-sm select2" required>
                  <option value="">- Pilih Toko -</option>
                  <?php
                  foreach ($list_toko as $tk) :
                  ?>
                    <option value="<?= $tk->id ?>"><?= $tk->nama_toko ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Range Tanggal Penjualan</label>
                <input type="text" name="tanggal" id="tanggal" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>
            <div class="col-md-2">
              <br>
              <button type="button" class="btn btn-info btn-sm mt-2 " id="btn_cari"><i class="fas fa-search"></i> Cari Data Penjualan</button>
            </div>
          </div>
          <hr>
          <div style="display: flex; justify-content:center">
            <div class="custom-loader" style="margin:30px; display:none;"></div>
          </div>
          <table class="table table-bordered table-striped ">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Kode</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">Qty</th>
                <th class="text-center" style="width: 12%;">Harga @</th>
                <th class="text-center">Satuan</th>
              </tr>
            </thead>
            <tbody id="body_hasil">
            </tbody>
          </table>

          <hr>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <small><strong>No. Faktur</strong></small>
                <input name="faktur" type="text" class="form-control form-control-sm faktur" required>
              </div>
              <div class="form-group">
                <small><strong>No. Pesanan</strong></small>
                <input name="pesanan" type="text" class="form-control form-control-sm pesanan">
              </div>
              <div class="form-group">
                <small><strong>Deskripsi</strong></small>
                <textarea name="deskripsi" id="deskripsi" class="form-control form-control-sm deskripsi" rows="3" required></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <small><strong>Kode Pelanggan</strong></small>
                <input name="kode_pelanggan" type="text" class="form-control form-control-sm kode_pelanggan" required>
              </div>
              <div class="form-group">
                <small><strong>pelanggan</strong></small>
                <input name="pelanggan" type="text" class="form-control form-control-sm pelanggan" required>
              </div>
              <div class="form-group">
                <small><strong>Tanggal Faktur</strong></small>
                <input type="date" name="tgl_faktur" class="form-control form-control-sm tgl_faktur">
              </div>
              <div class="form-group">
                <small><strong>Tanggal Kirim</strong></small>
                <input type="date" name="tgl_kirim" class="form-control form-control-sm tgl_kirim">
              </div>
            </div>
            <div class="col-md-4">
              <table class="table">
                <tr>
                  <td>
                    <small><strong>Sub Total</strong></small>
                  </td>
                  <td>
                    <input type="text" class="form-control form-control-sm subTotal" readonly>
                  </td>
                </tr>
                <tr>
                  <td>
                    <small>Diskon</small>
                  </td>
                  <td>
                    <input type="text" name="diskon" class="form-control form-control-sm diskon" value="0">
                  </td>
                </tr>
                <tr>
                  <td>
                    <small>Pajak 11%</small>
                  </td>
                  <td>
                    <input type="text" class="form-control form-control-sm pajak" readonly>
                  </td>
                </tr>
                <tr>
                  <td>
                    <small><strong>Jumlah</strong></small>
                  </td>
                  <td>
                    <input type="text" class="form-control form-control-sm jumlah" readonly>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" id="btn_simpan" class="btn btn-success btn-sm float-right"> <i class="fas fa-download"></i> Export </button>
          <a href="<?= base_url('template/Sales_Invoice') ?>" class="btn btn-danger btn-sm float-right mr-2"><i class="fas fa-times-circle"></i> Reset</a>
        </div>
      </form>
    </div>
  </div>
</section>
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
      $("#body_hasil").html('');
      $(".subTotal").val('');
      $(".pajak").val('');
      $(".jumlah").val('');
    });

    $("#btn_cari").click(function() {
      var parameter = $("#parameter").val();
      var id_cust = $("#id_cust").val();
      var id_toko = $("#id_toko").val();
      var tgl = $("#tanggal").val();
      var tglArray = tgl.split(" - ");
      var tgl_awal = tglArray[0];
      var tgl_akhir = tglArray[1];

      if (parameter == "") {
        Swal.fire(
          'oops',
          'Silahkan pilih pencarian berdasarkan Customer / toko .',
          'info'
        );
      } else if (parameter == "customer") {
        if (tgl == "" || id_cust == "") {
          Swal.fire(
            'oops',
            'Silahkan pilih Customer  & range tanggal penjualan !',
            'info'
          );
        } else {
          $(".custom-loader").show();
          $.ajax({
            url: "<?php echo base_url('template/Sales_Invoice/list_jual_cust'); ?>",
            type: "GET",
            dataType: "json",
            data: {
              id_cust: id_cust,
              tgl_awal: tgl_awal,
              tgl_akhir: tgl_akhir
            },
            success: function(data) {
              $(".custom-loader").hide();
              var html = '';
              var totalQty = 0;
              var totalSubTotal = 0;
              var number = 1;
              $(".pelanggan").val(data[0].nama_cust);
              $(".kode_pelanggan").val(data[0].kode_customer);
              $.each(data, function(i, item) {
                var subtotal = parseInt(item.harga * item.total_qty);
                html += '<tr>';
                html += '<td class="text-center">' + number++ + '</td>';
                html += '<td> <small><strong><input type="hidden" name="kode[]" value="' + item.kode + '">' + item.kode + '</strong></small></td>';
                html += '<td> <small>' + item.nama_produk + '</small></td>';
                html += '<td class="text-center"><input type="hidden" class="qty" name="qty[]" value="' + item.total_qty + '">' + item.total_qty + '</td>';
                html += '<td class="text-right"><input type="text" name="harga[]" value="' + formatRupiah(item.harga_satuan) + '" class ="form-control form-control-sm harga"></td>';
                html += '<td class="text-center"><input type="hidden" name="satuan[]" value="' + item.satuan + '">' + item.satuan + '</td>';
                html += '</tr>';
                totalQty += parseInt(item.total_qty);
                totalSubTotal += subtotal;
              });
              html += '<tr>';
              html += '<td colspan="3" class="text-right">Sub Total :</td>';
              html += '<td class="text-center">' + formatRupiah(totalQty) + '</td>';
              html += '<td class="text-right sub_total">' + formatRupiah(totalSubTotal) + '</td>';
              html += '<td class="text-center"></td>';
              html += '</tr>';
              $("#body_hasil").html(html);
              $(".subTotal").val(formatRupiah(totalSubTotal));
              $(".diskon").val('0');
              $(".jumlah").val(formatRupiah(totalSubTotal));
              $(".pajak").val(formatRupiah(totalSubTotal * 11 / 100));

              if (data.length === 0) {
                $(".custom-loader").hide();
                Swal.fire(
                  'TIDAK ADA TRANSAKSI',
                  'Data tidak ditemukan',
                  'info'
                );
              }
            },
            error: function(xhr, status, error) {
              $(".custom-loader").hide();
              console.log(xhr.responseText);
            }
          });
        }
      } else {
        if (tgl == "" || id_toko == "") {
          Swal.fire(
            'oops',
            'Silahkan pilih toko  & range tanggal penjualan !',
            'info'
          );
        } else {
          $(".custom-loader").show();
          $.ajax({
            url: "<?php echo base_url('template/Sales_Invoice/list_jual'); ?>",
            type: "GET",
            dataType: "json",
            data: {
              id_toko: id_toko,
              tgl_awal: tgl_awal,
              tgl_akhir: tgl_akhir
            },
            success: function(data) {
              $(".custom-loader").hide();
              var html = '';
              var totalQty = 0;
              var totalSubTotal = 0;
              var number = 1;
              $(".pelanggan").val(data[0].nama_cust);
              $(".kode_pelanggan").val(data[0].kode_customer);
              $.each(data, function(i, item) {
                var subtotal = parseInt(item.harga * item.total_qty);
                html += '<tr>';
                html += '<td class="text-center">' + number++ + '</td>';
                html += '<td> <small><strong><input type="hidden" name="kode[]" value="' + item.kode + '">' + item.kode + '</strong></small></td>';
                html += '<td> <small>' + item.nama_produk + '</small></td>';
                html += '<td class="text-center"><input type="hidden" class="qty" name="qty[]" value="' + item.total_qty + '">' + item.total_qty + '</td>';
                html += '<td class="text-right"><input type="text" name="harga[]" value="' + formatRupiah(item.harga_satuan) + '" class ="form-control form-control-sm harga"></td>';
                html += '<td class="text-center"><input type="hidden" name="satuan[]" value="' + item.satuan + '">' + item.satuan + '</td>';
                html += '</tr>';
                totalQty += parseInt(item.total_qty);
                totalSubTotal += subtotal;
              });
              html += '<tr>';
              html += '<td colspan="3" class="text-right">Sub Total :</td>';
              html += '<td class="text-center">' + formatRupiah(totalQty) + '</td>';
              html += '<td class="text-right sub_total">' + formatRupiah(totalSubTotal) + '</td>';
              html += '<td class="text-center"></td>';
              html += '</tr>';
              $("#body_hasil").html(html);
              $(".subTotal").val(formatRupiah(totalSubTotal));
              $(".diskon").val('0');
              $(".jumlah").val(formatRupiah(totalSubTotal));
              $(".pajak").val(formatRupiah(totalSubTotal * 11 / 100));

              if (data.length === 0) {
                $(".custom-loader").hide();
                Swal.fire(
                  'TIDAK ADA TRANSAKSI',
                  'Data tidak ditemukan',
                  'info'
                );
              }
            },
            error: function(xhr, status, error) {
              $(".custom-loader").hide();
              console.log(xhr.responseText);
            }
          });
        }

      }
      $(document).on('input', '.harga, .jumlah_qty', function() {
        var totalSubTotal = 0;
        $('.harga').each(function(index) { // Mendefinisikan variabel index di dalam fungsi each()
          var hargaString = $(this).val().replace(/\./g, '');
          var harga = parseFloat(hargaString.replace(',', '.'));
          if (isNaN(harga)) {
            harga = 0;
          }
          var qty = parseFloat($('.qty').eq(index).val()); // Menggunakan index untuk mendapatkan nilai qty
          if (isNaN(qty)) {
            qty = 0;
          }
          var subtotal = harga * qty; // Menghitung subtotal
          totalSubTotal += subtotal;
          $(this).val(formatRupiah(harga));
        });

        // Set nilai subtotal total
        $('.sub_total').text(formatRupiah(totalSubTotal));
        $(".subTotal").val(formatRupiah(totalSubTotal));
        $(".jumlah").val(formatRupiah(totalSubTotal));
        $(".pajak").val(formatRupiah(totalSubTotal * 0.11));
      });

    });
    // diskon diketik
    $('.diskon').on('input', function() {
      var diskonString = $(this).val().replace(/\./g, '');
      var diskon = parseFloat(diskonString.replace(',', '.'));
      if (isNaN(diskon)) {
        diskon = 0;
      }
      if (diskon < 0) {
        diskon = 0;
      }
      $(this).val(formatRupiah(diskon));
      var subTotal = parseFloat($('.subTotal').val().replace(/\./g, '').replace(',', '.'));
      var jumlah = subTotal - diskon;
      var pajak = jumlah * 0.11;
      $('.jumlah').val(formatRupiah(jumlah));
      $('.pajak').val(formatRupiah(pajak));
    });
    // Fungsi untuk mengubah angka menjadi format rupiah
    function formatRupiah(angka) {
      var numberString = angka.toString();
      var split = numberString.split(',');
      var sisa = split[0].length % 3;
      var rupiah = split[0].substr(0, sisa);
      var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return rupiah;
    }

    // proses simpan
    $("#btn_simpan").click(function(e) {
      e.preventDefault();
      var faktur = $(".faktur").val();
      var tgl_faktur = $(".tgl_faktur").val();
      var tgl_kirim = $(".tgl_kirim").val();
      var kode_cust = $(".kode_pelanggan").val();
      if (kode_cust.trim() === "") {
        alert("Kode Pelanggan kosong, silahkan update dulu.!");
        return;
      }
      if (faktur.trim() === "" || tgl_faktur.trim() === "" || tgl_kirim.trim() === "") {
        alert("Harap Lengkapi semua datanya");
        return;
      }
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data sudah terinput dengan benar?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Yakin'
      }).then((result) => {
        if (result.isConfirmed) {
          document.querySelector('form').submit();
        }
      });
    });


    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy-mm-dd', {
      'placeholder': 'yyyy-mm-dd'
    });
    $('[data-mask]').inputmask('yyyy-mm-dd');
    // ketika parameter di pilih
    $("#parameter").change(function() {
      var param = $(this).val();
      if (param === 'customer') {
        // hapus class d-none di id group_toko
        $("#group_big").removeClass('d-none');
        $("#group_cust").removeClass('d-none');
        $("#group_toko").addClass('d-none');
        $("#body_hasil").html('');
        $(".subTotal").val('');
        $(".diskon").val('0');
        $(".pajak").val('');
        $(".jumlah").val('');
      } else if (param === 'toko') {
        $("#group_big").removeClass('d-none');
        $("#group_toko").removeClass('d-none');
        $("#group_cust").addClass('d-none');
        $("#body_hasil").html('');
        $(".subTotal").val('');
        $(".pajak").val('');
        $(".diskon").val('0');
        $(".jumlah").val('');
      } else {
        $("#group_big").addClass('d-none');
        $("#group_toko").addClass('d-none');
        $("#group_cust").addClass('d-none');
        $("#body_hasil").html('');
        $(".subTotal").val('');
        $(".diskon").val('0');
        $(".pajak").val('');
        $(".jumlah").val('');
      }
    });
    // ketika customer di ganti
    $("#id_cust").change(function() {
      $("#body_hasil").html('');
      $(".subTotal").val('');
      $(".pajak").val('');
      $(".diskon").val('0');
      $(".jumlah").val('');
    });
    // ketika customer di ganti
    $("#id_toko").change(function() {
      $("#body_hasil").html('');
      $(".subTotal").val('');
      $(".pajak").val('');
      $(".diskon").val('0');
      $(".jumlah").val('');
    });

  });
</script>
<style>
  .custom-loader {
    --r1: 154%;
    --r2: 68.5%;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background:
      radial-gradient(var(--r1) var(--r2) at top, #0000 79.5%, #17A2B8 80%),
      radial-gradient(var(--r1) var(--r2) at bottom, #17A2B8 79.5%, #0000 80%),
      radial-gradient(var(--r1) var(--r2) at top, #0000 79.5%, #17A2B8 80%),
      #E4E4ED;
    background-size: 50.5% 220%;
    background-position: -100% 0%, 0% 0%, 100% 0%;
    background-repeat: no-repeat;
    animation: p9 2s infinite linear;
  }

  @keyframes p9 {
    33% {
      background-position: 0% 33%, 100% 33%, 200% 33%
    }

    66% {
      background-position: -100% 66%, 0% 66%, 100% 66%
    }

    100% {
      background-position: 0% 100%, 100% 100%, 200% 100%
    }
  }
</style>