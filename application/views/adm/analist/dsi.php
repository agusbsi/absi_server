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

  @media print {
    body {
      margin: 0;
      padding: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f4f4f4;
    }

    /* Hide everything except the printable area */
    body * {
      visibility: hidden;
    }

    #printableArea,
    #printableArea * {
      visibility: visible;
    }

    #printableArea {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
    }
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="card card-info card-outline cari">
      <div class="card-header">
        <h3 class="card-title">
          <li class="fas fa-chart-line"></li> Days Sales of Inventory (DSI)
        </h3>
        <div class="card-tools">
          <span class="badge badge-info">Analisis Inventori</span>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <label for="id_toko">
                <i class="fas fa-store"></i> Pilih Toko <span class="text-danger">*</span>
              </label>
              <select name="id_toko" class="form-control form-control-sm select2" id="id_toko" required>
                <option value="">-- Pilih Toko --</option>
                <?php foreach ($toko as $t) : ?>
                  <option value="<?= $t->id ?>"><?= $t->nama_toko ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="periode">
                <i class="fas fa-calendar-alt"></i> Bulan <span class="text-danger">*</span>
              </label>
              <select name="periode" class="form-control form-control-sm select2" id="periode" required>
                <option value="">-- Pilih Bulan --</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="tahun">
                <i class="fas fa-calendar"></i> Tahun <span class="text-danger">*</span>
              </label>
              <select name="tahun" class="form-control form-control-sm select2" id="tahun" required>
                <option value="">-- Pilih Tahun --</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label>&nbsp;</label>
              <button class="btn btn-info btn-block" id="searchBtn">
                <i class="fas fa-search"></i> Cari
              </button>
            </div>
          </div>
        </div>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <i class="fas fa-info-circle"></i> <strong>Informasi:</strong> DSI menunjukkan berapa hari rata-rata produk tersimpan di inventori sebelum terjual.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
    </div>
    <div id="loading" style="display: none;">
      <div class="loader">
        <div class="circle">
          <div class="percentage" id="percentage">0%</div>
        </div>
      </div>
    </div>
    <div class="no-data">
      <img src="<?= base_url('assets/img/nodata.png') ?>" alt="no-data" class="img-nodata">
    </div>
    <div class="card card-success card-outline hasil d-none">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-table"></i> Hasil Analisis DSI</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div id="printableArea">
          <div class="text-center mb-3">
            <h5><strong>Laporan Days Sales of Inventory (DSI)</strong></h5>
            <p class="mb-1" id="toko"></p>
            <p class="text-muted mb-0">Periode: <label id="lap_periode" class="font-weight-bold text-info"></label></p>
          </div>
          <hr>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" class="form-control form-control-sm " id="searchInput" placeholder="Cari berdasarkan kode atau nama artikel...">
          </div>
          <table id="myTable" class="table table-bordered table-striped table-hover mt-3">
            <thead class="thead-light">
              <tr class="text-center">
                <th width="5%">No</th>
                <th width="12%">Kode</th>
                <th>Artikel</th>
                <th width="10%">Terjual</th>
                <th width="10%">Stok Akhir</th>
                <th width="10%">
                  DSI <br>
                  <small class="text-muted">(Score)</small>
                </th>
              </tr>
            </thead>
            <tbody id="dataTableBody">
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-warning" id="downloadExcelBtn">
          <i class="fas fa-file-excel"></i> Download Excel
        </button>
        <button type="button" onclick="printDiv('printableArea')" class="btn btn-secondary">
          <i class="fas fa-print"></i> Print
        </button>
        <a href="<?= base_url('adm/Analist/dsi') ?>" class="btn btn-danger float-right">
          <i class="fa fa-redo"></i> Reset
        </a>
      </div>
    </div>
  </div>
</section>

<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

<script>
  // Initialize Select2
  $(document).ready(function() {
    $('.select2').select2({
      theme: 'bootstrap4',
      width: '100%'
    });

    // Populate year dropdown (last 5 years to current year + 1)
    const currentYear = new Date().getFullYear();
    const yearSelect = $('#tahun');
    for (let year = currentYear; year >= currentYear - 2; year--) {
      yearSelect.append(new Option(year, year));
    }

    // Set current month and year as default
    const currentMonth = new Date().getMonth() + 1;
    $('#periode').val(currentMonth.toString().padStart(2, '0')).trigger('change');
    $('#tahun').val(currentYear).trigger('change');
  });

  function validateForm() {
    let isValid = true;
    $('.cari').find('input[required], select[required], textarea[required]').each(function() {
      if ($(this).val() === '') {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    return isValid;
  }

  document.getElementById('downloadExcelBtn').addEventListener('click', function() {
    downloadExcel();
  });

  function downloadExcel() {
    var wb = XLSX.utils.book_new();
    var header = ["No", "Kode", "Artikel", "Terjual", "Stok Akhir", "DSI"];
    var sheetData = [];

    var toko = document.getElementById('toko').textContent.trim();
    var periode = document.getElementById('lap_periode').textContent.trim();

    sheetData.push(["", "", "Days Sales of Inventory (DSI)", "", "", ""]);
    sheetData.push(["", "", toko, "", "", ""]);
    sheetData.push(["", "", "Periode: " + periode, "", "", ""]);
    sheetData.push([]);
    sheetData.push(header);

    var table = document.getElementById('dataTableBody');
    for (var i = 0; i < table.rows.length; i++) {
      var row = [];
      for (var j = 0; j < table.rows[i].cells.length; j++) {
        var cellValue = table.rows[i].cells[j].textContent.trim();
        if (header[j] === "Terjual" || header[j] === "Stok Akhir" || header[j] === "DSI") {
          var numericValue = parseFloat(cellValue.replace(/[^0-9.-]+/g, ''));
          row.push(isNaN(numericValue) ? cellValue : numericValue);
        } else {
          row.push(cellValue);
        }
      }
      sheetData.push(row);
    }

    var ws = XLSX.utils.aoa_to_sheet(sheetData);
    XLSX.utils.book_append_sheet(wb, ws, 'DSI');

    var filename = 'DSI_' + toko.replace(/\s+/g, '_') + '_' + periode.replace(/\s+/g, '_') + '.xlsx';
    XLSX.writeFile(wb, filename);
  }

  document.getElementById('searchBtn').addEventListener('click', function() {
    var idToko = document.getElementById('id_toko').value;
    var periode = document.getElementById('periode').value;
    var tahun = document.getElementById('tahun').value;
    const url = '<?= base_url('adm/Analist') ?>';

    if (!validateForm()) {
      Swal.fire({
        icon: 'warning',
        title: 'Data Belum Lengkap',
        text: 'Silakan pilih toko, bulan, dan tahun terlebih dahulu.',
        confirmButtonColor: '#3085d6'
      });
      return;
    }

    // Calculate date range for selected month and year
    const tglAwal = tahun + '-' + periode + '-01';
    const lastDay = new Date(tahun, parseInt(periode), 0).getDate();
    const tglAkhir = tahun + '-' + periode + '-' + lastDay;

    document.getElementById('loading').style.display = 'flex';
    var percentageElement = document.getElementById('percentage');
    percentageElement.textContent = '0%';
    var circle = document.querySelector('.circle');

    var percentage = 0;
    var intervalTime = 30;
    var interval = setInterval(() => {
      if (percentage < 90) {
        percentage += 2;
        percentageElement.textContent = Math.round(percentage) + '%';
        var angle = percentage * 3.6;
        circle.style.background = `conic-gradient(
          #3498db 0deg,
          #3498db ${angle}deg,
          transparent ${angle}deg,
          transparent 360deg
        )`;
      }
    }, intervalTime);

    fetch(`${url}/cari_dsi?id_toko=${idToko}&tgl_awal=${tglAwal}&tgl_akhir=${tglAkhir}`)
      .then(response => response.json())
      .then(data => {
        clearInterval(interval);

        // Complete the loading animation
        percentage = 100;
        percentageElement.textContent = '100%';
        circle.style.background = `conic-gradient(
          #3498db 0deg,
          #3498db 360deg,
          transparent 360deg,
          transparent 360deg
        )`;

        setTimeout(() => {
          document.getElementById('loading').style.display = 'none';

          if (data.tabel_data && data.tabel_data.length > 0) {
            updateUI(data, periode, tahun);
          } else {
            Swal.fire({
              icon: 'info',
              title: 'Data Tidak Ditemukan',
              text: 'Tidak ada data untuk toko dan periode yang dipilih.',
              confirmButtonColor: '#3085d6'
            });
          }
        }, 300);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
        clearInterval(interval);
        document.getElementById('loading').style.display = 'none';
        Swal.fire({
          icon: 'error',
          title: 'Terjadi Kesalahan',
          text: 'Gagal mengambil data. Silakan coba lagi.',
          confirmButtonColor: '#d33'
        });
      });
  });

  function updateUI(data, periode, tahun) {
    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
      "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    const monthName = monthNames[parseInt(periode) - 1];

    $('#toko').html('<i class="fas fa-store"></i> ' + data.toko);
    $('#lap_periode').html(monthName + ' ' + tahun);

    $('.cari').addClass('d-none');
    $('.no-data').addClass('d-none');
    $('.hasil').removeClass('d-none');

    var tableBody = document.getElementById('dataTableBody');
    var totalQty = 0;
    var totalstok = 0;
    tableBody.innerHTML = '';

    data.tabel_data.forEach((item, index) => {
      var jual = parseInt(item.jual) || 0;
      var stok_akhir = parseInt(item.stok_akhir) || 0;
      var dsiValue = jual != 0 ? (stok_akhir / (jual / data.bln)).toFixed(1) : '-';
      var dsiColor = jual != 0 && dsiValue > 4 ? 'red' : 'inherit';
      var dsiClass = jual != 0 && dsiValue > 4 ? 'font-weight-bold' : '';

      var row = document.createElement('tr');
      row.innerHTML = `
        <td class="text-center"><small>${index + 1}</small></td>
        <td><small class="${jual == 0 ? 'text-danger' : ''}">${item.kode}</small></td>
        <td><small class="${jual == 0 ? 'text-danger' : ''}">${item.nama}</small></td>
        <td class="text-center ${jual == 0 ? 'text-danger' : ''}">${jual}</td>
        <td class="text-center">${stok_akhir}</td>
        <td class="text-center ${dsiClass}" style="color: ${dsiColor}">
          ${dsiValue}
        </td>
      `;
      tableBody.appendChild(row);

      totalQty += jual;
      totalstok += stok_akhir;
    });

    var totalRow = document.createElement('tr');
    totalRow.className = 'table-info font-weight-bold';
    totalRow.innerHTML = `
      <td colspan="3" class="text-right"><strong>Total:</strong></td>
      <td class="text-center"><strong>${totalQty}</strong></td>
      <td class="text-center"><strong>${totalstok}</strong></td>
      <td></td>
    `;
    tableBody.appendChild(totalRow);
  }

  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Print DSI Report</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f4f4f4; font-weight: bold; }');
    printWindow.document.write('.text-center { text-align: center; }');
    printWindow.document.write('h5 { margin: 10px 0; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<div id="printableArea">');
    printWindow.document.write(printContents);
    printWindow.document.write('</div>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    setTimeout(function() {
      printWindow.print();
      printWindow.close();
    }, 500);
  }

  function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td");
      var found = false;
      for (var j = 0; j < td.length; j++) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          found = true;
          break;
        }
      }
      if (found) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }

  document.getElementById("searchInput").addEventListener("input", searchTable);
</script>