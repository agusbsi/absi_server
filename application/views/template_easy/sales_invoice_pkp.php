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
<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        Export Data Sales Invoice -
      </div>
      <form action="<?= base_url('template/Sales_Invoice/export_pkp') ?>" id="form_id" method="post">
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Berdasarkan</label>
                <select name="pilihan" id="parameter" class="form-control form-control-sm select2" required>
                  <option value="">- Pilih Parameter -</option>
                  <option value="customer"> Customer </option>
                  <option value="toko"> Toko </option>
                </select>
              </div>
            </div>
            <div id="group_big" class="col-md-4 d-none">
              <div class="form-group d-none" id="group_cust">
                <label for="">Nama Customer / Group</label>
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
              <button type="button" class="btn btn-info btn-sm mt-2 " id="btn_cari"><i class="fas fa-search"></i> Cari Data</button>
            </div>
          </div>
          <hr>
          <div style="display: flex; justify-content:center">
            <div class="custom-loader" style="margin:30px; display:none;"></div>
          </div>
          <table class="table table-bordered table-striped ">
            <tbody id="body_hasil">
            </tbody>
          </table>

          <hr>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <small><strong>No. Faktur</strong></small>
                <input name="faktur" id="faktur" type="text" class="form-control form-control-sm faktur" required>
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
                <input name="kode_pelanggan" id="kode_p" type="text" class="form-control form-control-sm kode_pelanggan" required>
              </div>
              <div class="form-group">
                <small><strong>pelanggan</strong></small>
                <input name="pelanggan" id="pelanggan" type="text" class="form-control form-control-sm pelanggan" required>
              </div>
              <div class="form-group">
                <small><strong>Tanggal Faktur</strong></small>
                <input type="date" name="tgl_faktur" id="tgl_faktur" class="form-control form-control-sm tgl_faktur">
              </div>
              <div class="form-group">
                <small><strong>Tanggal Kirim</strong></small>
                <input type="date" name="tgl_kirim" id="tgl_kirim" class="form-control form-control-sm tgl_kirim">
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
                    <input type="text" name="diskon" id="diskon" class="form-control form-control-sm diskon" value="0">
                    <input type="hidden" id="pengguna" value="<?= $this->session->userdata('nama_user') ?>">
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
          <button type="button" id="downloadExcelBtn" class="btn btn-success btn-sm float-right"> <i class="fas fa-download"></i> Export </button>
          <a href="<?= base_url('template/Sales_Invoice') ?>" class="btn btn-danger btn-sm float-right mr-2"><i class="fas fa-times-circle"></i> Reset</a>
        </div>
      </form>
    </div>
  </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
  document.getElementById('downloadExcelBtn').addEventListener('click', function() {
    var faktur = $(".faktur").val();
    var tgl_faktur = $(".tgl_faktur").val();
    var tgl_kirim = $(".tgl_kirim").val();
    var kode_cust = $(".kode_pelanggan").val();
    if (kode_cust.trim() === "") {
      Swal.fire(
        'oops',
        'Kode Pelanggan kosong, silahkan update dulu.',
        'info'
      );
      return;
    }
    if (faktur.trim() === "" || tgl_faktur.trim() === "" || tgl_kirim.trim() === "") {
      Swal.fire(
        'oops',
        'Faktur dan tanggal tidak boleh kosong.',
        'info'
      );
      return;
    } else {
      downloadExcel();
    }

  });

  function downloadExcel() {
    var wb = XLSX.utils.book_new();

    // Menyusun header kolom
    var header = [
      "No. Faktur", "No. Pelanggan", "Tanggal", "Akun Piutang", "Deskripsi", "Nilai Tukar", "Nilai Pajak",
      "Diskon", "Prosentase Diskon", "Pengguna", "Syarat", "Kirim Ke", "Kirim Melalui", "Tgl. Kirim",
      "Penjual", "FOB", "Rancangan", "Seri Pajak 1", "Seri Pajak 2", "Tgl. Faktur Pajak", "Termasuk Pajak",
      "No. Barang", "Qty", "Harga Satuan", "Kode Pajak", "Diskon Brg", "Satuan", "Departemen", "Proyek", "Gudang"
    ];
    var sheetData = [header]; // header harus ditambahkan sebagai baris pertama

    // Ambil nilai faktur dari input
    var faktur = document.getElementById('faktur').value;
    var kode_p = document.getElementById('kode_p').value;
    var tgl_faktur = formatTanggal(document.getElementById('tgl_faktur').value);
    var tgl_kirim = formatTanggal(document.getElementById('tgl_kirim').value);
    var deskripsi = document.getElementById('deskripsi').value;
    var diskon = document.getElementById('diskon').value;
    var pengguna = document.getElementById('pengguna').value;
    var pelanggan = document.getElementById('pelanggan').value;

    // Ambil data dari tabel
    var tableRows = document.querySelectorAll('#body_hasil tr:not(:last-child)'); // Ambil semua baris kecuali baris total

    tableRows.forEach(function(row) {
      var cells = row.cells;
      var rowData = [];
      // Cek apakah baris mengandung teks yang harus dilewati
      var shouldSkip = false;
      for (var j = 0; j < cells.length; j++) {
        var cellContent = cells[j].textContent.trim().toLowerCase();
        if (cellContent.includes('toko :') || cellContent === 'total:' || cellContent === 'grand total :') {
          shouldSkip = true;
          break;
        }
        if (cellContent.includes('No :') || cellContent === 'kode' || cellContent === 'Artikel') {
          shouldSkip = true;
          break;
        }
      }
      if (shouldSkip) {
        return;
      }
      // Loop untuk setiap header kolom
      for (var k = 0; k < header.length; k++) {
        var cellValue = "";
        try {
          switch (header[k]) {
            case "No. Faktur":
              rowData.push(faktur);
              break;
            case "No. Pelanggan":
              rowData.push(kode_p);
              break;
            case "Tanggal":
              rowData.push(tgl_faktur);
              break;
            case "Akun Piutang":
              rowData.push("1102");
              break;
            case "Deskripsi":
              rowData.push(deskripsi);
              break;
            case "Nilai Tukar":
            case "Nilai Pajak":
              rowData.push("1");
              break;
            case "Diskon":
              rowData.push(diskon ? diskon.value.trim().replace(/\./g, '').replace(',', '.') : 0);
              break;
            case "Pengguna":
              rowData.push(pengguna);
              break;
            case "Syarat":
              rowData.push("Net 30");
              break;
            case "Kirim Ke":
              rowData.push(pelanggan);
              break;
            case "Kirim Melalui":
              rowData.push("");
              break;
            case "Tgl. Kirim":
              rowData.push(tgl_kirim);
              break;
            case "Penjual":
            case "FOB":
              rowData.push("");
              break;
            case "Rancangan":
              rowData.push("Sales Invoice");
              break;
            case "Seri Pajak 1":
            case "Seri Pajak 2":
            case "Tgl. Faktur Pajak":
              rowData.push("");
              break;
            case "Termasuk Pajak":
              rowData.push("Yes");
              break;
            case "No. Barang":
              var noBarangCell = cells[1];
              rowData.push(noBarangCell ? noBarangCell.textContent.trim() : '');
              break;
            case "Qty":
              var qtyCell = cells[3];
              rowData.push(qtyCell ? parseFloat(qtyCell.textContent.trim()) : '');
              break;
            case "Harga Satuan":
              var hargaCell = cells[4];
              var hargaValue = hargaCell ? parseFloat(hargaCell.querySelector('input').value.trim().replace(/\./g, '').replace(',', '.')) : 0;
              rowData.push(hargaValue);
              break;
            case "Kode Pajak":
              rowData.push("T");
              break;
            case "Diskon Brg":
              rowData.push("0");
              break;
            case "Satuan":
              var satuanCell = cells[5];
              var satuanValue = satuanCell ? satuanCell.textContent.trim() : '';
              rowData.push(satuanValue);
              break;

            case "Departemen":
              rowData.push("Non Department");
              break;
            case "Proyek":
              rowData.push("Non Project");
              break;
            case "Gudang":
              var gudangCell = cells[5];
              var gudangCell = gudangCell ? gudangCell.querySelector('input[name="gudang[]"]').value.trim() : '';
              rowData.push(gudangCell);
              break;
            default:
              rowData.push("");
              break;
          }
        } catch (error) {
          console.error('Error processing cell:', error);
          rowData.push("");
        }
      }

      sheetData.push(rowData);
    });

    // Pastikan setiap baris memiliki panjang yang sesuai
    for (var i = 1; i < sheetData.length; i++) {
      while (sheetData[i].length < header.length) {
        sheetData[i].push("");
      }
    }

    var ws = XLSX.utils.aoa_to_sheet(sheetData);
    var sheetName = "SI";
    XLSX.utils.book_append_sheet(wb, ws, sheetName);

    var filename = faktur + '.xlsx';
    XLSX.writeFile(wb, filename);
  }

  function formatTanggal(inputDate) {
    if (!inputDate) return "";

    var parts = inputDate.split('-');
    if (parts.length === 3) {
      return parts[2] + '/' + parts[1] + '/' + parts[0];
    } else {
      return inputDate;
    }
  }
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
            url: "<?php echo base_url('template/Sales_Invoice/cari_group'); ?>",
            type: "GET",
            dataType: "json",
            data: {
              id_cust: id_cust,
              tgl_awal: tgl_awal,
              tgl_akhir: tgl_akhir
            },
            success: function(data) {
              if (data.tabel_data != "") {
                updateUI(data);
                $(".custom-loader").hide();
              } else {
                Swal.fire(
                  'TIDAK ADA DATA',
                  'Data tidak ditemukan, silahkan cari kembali',
                  'info'
                );
                $(".custom-loader").hide();
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
              if (data != "") {
                $(".custom-loader").hide();
                var html = '';
                var totalQty = 0;
                var totalSubTotal = 0;
                var number = 1;
                $(".pelanggan").val(data[0].nama_cust);
                $(".kode_pelanggan").val(data[0].kode_customer);
                $.each(data, function(i, item) {
                  var subtotal = parseInt(item.harga_satuan * item.total_qty);
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
              } else {
                Swal.fire(
                  'TIDAK ADA DATA',
                  'Data tidak ditemukan, silahkan cari kembali',
                  'info'
                );
                $(".custom-loader").hide();
              }

            },
            error: function(xhr, status, error) {
              $(".custom-loader").hide();
              console.log(xhr.responseText);
            }
          });
        }
      }
      $(document).on('input', '.harga', function() {
        var grandTotal = 0;
        $('.harga').each(function() {
          var row = $(this).closest('tr');
          var hrgString = $(this).val().replace(/\./g, '').replace(',', '.');
          var hrg2 = parseFloat(hrgString);
          if (isNaN(hrg2) || hrg2 < 0) {
            hrg2 = 0;
          }
          var qty = parseInt(row.find('.qty').val());
          var subtotal = hrg2 * qty;
          grandTotal += subtotal;
          $(this).val(formatRupiah(hrg2));
        });
        $('.sub_total').text(formatRupiah(grandTotal));
        $('.subTotal').val(formatRupiah(grandTotal));
        $('.jumlah').val(formatRupiah(grandTotal));
        $('.diskon').val('0');
        $('.pajak').val(formatRupiah(grandTotal * 11 / 100));
      });

    });
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
<script>
  function updateUI(data) {
    $(".pelanggan").val(data.nama_cust);
    $(".kode_pelanggan").val(data.kode_cust);
    var tableBody = document.getElementById('body_hasil');
    var grandTotalQty = 0;
    var grandTotalHarga = 0;
    tableBody.innerHTML = '';
    var no_toko = 1;
    for (var toko in data.tabel_data) {
      if (data.tabel_data.hasOwnProperty(toko)) {
        var tokoClass = toko.replace(/[^a-zA-Z0-9]/g, '-');
        var tokoHeader = document.createElement('tr');
        tokoHeader.innerHTML = `
        <td colspan="6" class="text-center"><strong>Toko : ${toko}</strong></td>
      `;
        tableBody.appendChild(tokoHeader);
        var columnHeader = document.createElement('tr');
        columnHeader.className = 'text-center';
        columnHeader.innerHTML = `
        <th>No</th>
        <th>Kode</th>
        <th>Artikel</th>
        <th>Terjual</th>
        <th style="width: 15%">Harga@</th>
        <th>Satuan</th>
      `;
        tableBody.appendChild(columnHeader);
        var tokoTotalQty = 0;
        var tokoTotalharga = 0;
        data.tabel_data[toko].forEach((item, index) => {
          var row = document.createElement('tr');
          row.innerHTML = `
          <td class="text-center">${index + 1}</td>
          <td>
          <input type="hidden"  name="kode[]" value="${item.kode}">
          ${item.kode}</td>
          <td>${item.nama_produk}</td>
          <td class="text-center">
            <input type="hidden" class="qty" name="qty[]" value="${item.total}">
            ${item.total}
          </td>
          <td class="text-center">
            <input type="text" name="harga[]" class="form-control form-control-sm hargaproduk toko-${tokoClass}" value="${formatRupiah(item.harga)}">
          </td>
          <td class="text-center"><input type="hidden" name="satuan[]" value="${item.satuan}">
          <input type="hidden" name="gudang[]" value="${item.gudang}">
          ${item.satuan}</td>
        `;
          tableBody.appendChild(row);
          var qty = parseInt(item.total, 10);
          var harga = parseFloat(item.harga);
          if (!isNaN(qty)) {
            tokoTotalQty += qty;
          }
          if (!isNaN(harga) && !isNaN(qty)) {
            tokoTotalharga += harga * qty;
          }
          var inputHarga = row.querySelector('.hargaproduk');
          inputHarga.addEventListener('input', function() {
            var hrg = $(this).val().replace(/\./g, '');
            var newHarga = parseFloat(hrg.replace(',', '.'));
            if (!isNaN(newHarga)) {
              var currentQty = parseInt(item.total, 10);
              if (!isNaN(currentQty)) {
                tokoTotalharga += (newHarga - harga) * currentQty;
                item.harga = newHarga;
                harga = newHarga;
                var totalHargaElem = tableBody.querySelector(`.totalHargaToko-${tokoClass}`);
                if (totalHargaElem) {
                  totalHargaElem.textContent = formatRupiah(tokoTotalharga);
                }
                updateGrandTotal();
              }
            }
            var hrgString = $(this).val().replace(/\./g, '');
            var hrg = parseFloat(hrgString.replace(',', '.'));
            if (isNaN(hrg)) {
              hrg = 0;
            }
            if (hrg < 0) {
              hrg = 0;
            }
            $(this).val(formatRupiah(hrg));
          });
        });
        var tokoTotalRow = document.createElement('tr');
        tokoTotalRow.innerHTML = `
        <td colspan="3" class="text-right"><strong>Total:</strong></td>
        <td class="text-center"><strong>${tokoTotalQty}</strong></td>
        <td class="text-center"><strong class="totalHargaToko-${tokoClass}">${formatRupiah(tokoTotalharga)}</strong></td>
        <td></td>
      `;
        tableBody.appendChild(tokoTotalRow);
        grandTotalQty += tokoTotalQty;
        grandTotalHarga += tokoTotalharga;
        no_toko++;
      }
    }
    var grandTotalRow = document.createElement('tr');
    grandTotalRow.innerHTML = `
    <td colspan="3" class="text-right"><strong>Grand Total :</strong></td>
    <td class="text-center"><strong>${grandTotalQty}</strong></td>
    <td class="text-center"><strong class="grandTotal">${formatRupiah(grandTotalHarga)}</strong></td>
    <td></td>
  `;
    tableBody.appendChild(grandTotalRow);
    $(".subTotal").val(formatRupiah(grandTotalHarga));
    $(".diskon").val('0');
    $(".jumlah").val(formatRupiah(grandTotalHarga));
    $(".pajak").val(formatRupiah(grandTotalHarga * 11 / 100));

    function updateGrandTotal() {
      grandTotalHarga = 0;
      for (var toko in data.tabel_data) {
        if (data.tabel_data.hasOwnProperty(toko)) {
          var tokoClass = toko.replace(/[^a-zA-Z0-9]/g, '-');
          var tokoTotalharga = 0;
          data.tabel_data[toko].forEach((item) => {
            var harga = parseFloat(item.harga);
            var qty = parseInt(item.total, 10);
            if (!isNaN(harga) && !isNaN(qty)) {
              tokoTotalharga += harga * qty;
            }
          });
          grandTotalHarga += tokoTotalharga;
          var totalHargaElem = tableBody.querySelector(`.totalHargaToko-${tokoClass}`);
          if (totalHargaElem) {
            totalHargaElem.textContent = formatRupiah(tokoTotalharga);
          }
        }
      }
      var grandTotalElem = tableBody.querySelector('.grandTotal');
      if (grandTotalElem) {
        grandTotalElem.textContent = formatRupiah(grandTotalHarga);
      }
      $(".subTotal").val(formatRupiah(grandTotalHarga));
      $(".jumlah").val(formatRupiah(grandTotalHarga));
      $(".pajak").val(formatRupiah(grandTotalHarga * 11 / 100));
    }
  }

  function formatRupiah(angka) {
    var numberString = angka.toString().replace(/\./g, ''); // Hapus semua titik (.) yang ada
    var split = numberString.split(',');
    var sisa = split[0].length % 3;
    var rupiah = split[0].substr(0, sisa);
    var ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);
    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] !== undefined ? rupiah + ',' + split[1].substr(0, 2) : rupiah;
    return rupiah;
  }
</script>