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
          <li class="fas fa-cart-plus"></li> Laporan Penjualan per Artikel
        </h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Artikel :</label>
              <select name="id_artikel" class="form-control form-control-sm select2" id="id_artikel" required>
                <option value="">- Pilih Artikel -</option>
                <option value="all"> Semua Artikel</option>
                <?php foreach ($artikel as $t) : ?>
                  <option value="<?= $t->id ?>">[ <?= $t->kode ?> ] <?= $t->nama_produk ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Tgl Awal :</label>
              <div class="input-group">
                <input type="date" name="tgl_awal" id="tgl_awal" class="form-control form-control-sm " required>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Tgl Akhir :</label>
              <div class="input-group">
                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control form-control-sm" required>
              </div>
            </div>
          </div>
          <div class="col-md-2 p-3">
            <button class="btn btn-info btn-sm btn-cari mt-3" id="searchBtn">
              <li class="fas fa-search"></li> Cari Data
            </button>
          </div>
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
      <div class="card-body">
        <div id="printableArea">
          <div class="text-center"> <strong>- Laporan Penjualan Per Artikel -</strong></div>
          <hr>
          <div class="text-center"><strong class="text-center" id="kode"></strong></div>
          <p class="text-center" id="artikel"></p>
          <p class="text-center"> Periode :</p>
          <div class="text-center"><label id="lap_awal" class="mr-2 text-center"></label> s/d <label class="text-center ml-2" id="lap_akhir"></label>
          </div>
          <table class="table table-bordered mt-4">
            <thead>
              <thead>
                <tr class="text-center" id="tableHeader">
                </tr>
              </thead>
            <tbody id="dataTableBody">
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
        <a type="button" onclick="printDiv('printableArea')" target="_blank" class="btn btn-default btn-sm float-right mr-3 ml-2">
          <i class="fas fa-print"></i> Print </a>
        <button class="btn btn-warning btn-sm float-right" id="downloadExcelBtn"><i class="fas fa-file-excel"></i> Unduh</button>
        <a href="<?= base_url('adm/Penjualan/lap_artikel') ?>" class="btn btn-danger btn-sm float-right mr-1"><i class="fa fa-times-circle"></i> close</a>

      </div>
    </div>
  </div>
  </div>
</section>

<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

<script>
  function validateForm() {
    let isValid = true;
    // Get all required input fields
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


  function downloadExcel(tipe) {
    var wb = XLSX.utils.book_new();
    var sheetData = [];

    // Sesuaikan header berdasarkan tipe
    var header;
    if (tipe === 'toko') {
      header = ["No", "Nama Toko", "Qty"];
    } else {
      header = ["No", "Kode", "Artikel", "Qty"];
    }

    sheetData.push(header);

    var table = document.getElementById('dataTableBody');
    for (var i = 0; i < table.rows.length; i++) {
      var row = [];
      for (var j = 0; j < table.rows[i].cells.length; j++) {
        var cellValue = table.rows[i].cells[j].textContent.trim();

        // Pastikan format Qty diubah menjadi angka
        if (header[j] === "Qty") {
          var numericValue = parseFloat(cellValue.replace(/[^0-9.-]+/g, ''));
          row.push(isNaN(numericValue) ? cellValue : numericValue);
        } else {
          row.push(cellValue);
        }
      }
      sheetData.push(row);
    }

    var ws = XLSX.utils.aoa_to_sheet(sheetData);
    XLSX.utils.book_append_sheet(wb, ws, 'Data Penjualan');

    // Tentukan nama file berdasarkan tipe
    var filename = tipe === 'toko' ? 'Laporan_jual_artikel.xlsx' : 'Laporan_jual_semua_artikel.xlsx';
    XLSX.writeFile(wb, filename);
  }


  document.getElementById('searchBtn').addEventListener('click', function() {
    var idArtikel = document.getElementById('id_artikel').value;
    var tglAwal = document.getElementById('tgl_awal').value;
    var tglAkhir = document.getElementById('tgl_akhir').value;
    const url = '<?= base_url('adm/Penjualan') ?>';
    if (validateForm()) {
      document.getElementById('loading').style.display = 'flex';
      // Reset the percentage
      var percentageElement = document.getElementById('percentage');
      percentageElement.textContent = '0%';
      var circle = document.querySelector('.circle');
      // Simulate loading data with setInterval
      var percentage = 0;
      var intervalTime = 50; // update every 50ms
      var interval = setInterval(() => {
        if (percentage < 100) {
          percentage += 1;
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
        }
      }, intervalTime);

      fetch(`${url}/cari_artikel?id_artikel=${idArtikel}&tgl_awal=${tglAwal}&tgl_akhir=${tglAkhir}`)
        .then(response => response.json())
        .then(data => {
          // Additional duration after data is fetched
          var additionalDuration = 2000; // 3 seconds
          var additionalIntervalTime = intervalTime; // same interval time
          var additionalIntervals = additionalDuration / additionalIntervalTime;
          var remainingIntervals = 0;

          var additionalInterval = setInterval(() => {
            remainingIntervals++;
            percentage = Math.min(100, percentage + (1 / additionalIntervals) * 100);
            if (remainingIntervals <= additionalIntervals && percentage <= 100) {
              percentageElement.textContent = Math.round(percentage) + '%';
              var angle = percentage * 3.6;
              circle.style.background = `conic-gradient(
                            #3498db 0deg,
                            #3498db ${angle}deg,
                            transparent ${angle}deg,
                            transparent 360deg
                        )`;
            } else {
              clearInterval(additionalInterval);
              percentageElement.textContent = '100%';
              circle.style.background = `conic-gradient(
                            #3498db 0deg,
                            #3498db 360deg,
                            transparent 360deg,
                            transparent 360deg
                        )`;
              setTimeout(() => {
                // Hide the loading animation
                document.getElementById('loading').style.display = 'none';
                if (data.tabel_data != "") {
                  updateUI(data);
                } else {
                  Swal.fire(
                    'TIDAK ADA DATA',
                    'Data tidak ditemukan, silahkan cari kembali',
                    'info'
                  );
                }

              }, 500);
            }
          }, additionalIntervalTime);
        })
        .catch(error => {
          console.error('Error fetching data:', error);
          clearInterval(interval);
          document.getElementById('loading').style.display = 'none';
        });
    } else {
      Swal.fire(
        'BELUM LENGKAP',
        'Lengkapi semua kolom.',
        'info'
      );
    }
  });

  function updateUI(data) {
    $('#kode').html(data.kode);
    $('#artikel').html(data.artikel);
    $('#lap_awal').html(data.awal);
    $('#lap_akhir').html(data.akhir);
    $('.cari').addClass('d-none');
    $('.no-data').addClass('d-none');
    $('.hasil').removeClass('d-none');
    // Update the table
    var tableBody = document.getElementById('dataTableBody');
    var totalQty = 0;
    tableBody.innerHTML = '';
    const tableHeader = document.getElementById('tableHeader');
    let headerContent;

    if (data.tipe === 'toko') {
      headerContent = `
    <th>No</th>
    <th>Nama Toko</th>
    <th>Terjual</th>
  `;
    } else {
      headerContent = `
    <th>No</th>
    <th>Kode</th>
    <th>Artikel</th>
    <th>Terjual</th>
  `;
    }

    tableHeader.innerHTML = headerContent;
    data.tabel_data.forEach((item, index) => {
      var row = document.createElement('tr');
      if (data.tipe === 'toko') {
        row.innerHTML = `
            <td class="text-center">${index + 1}</td>
            <td>${item.nama_toko}</td>
            <td class="text-center">${item.total}</td>
        `;
      } else {
        row.innerHTML = `
            <td class="text-center ${ item.total == 0 ? 'text-danger' : ''}">${index + 1}</td>
            <td><small class="${ item.total == 0 ? 'text-danger' : ''}"><strong>${item.kode}</strong></small></td>
            <td><small class="${ item.total == 0 ? 'text-danger' : ''}">${item.nama_produk}</small></td>
            <td class="text-center ${ item.total == 0 ? 'text-danger' : ''}">${item.total}</td>
        `;
      }

      tableBody.appendChild(row);
      var qty = parseInt(item.total, 10);
      if (!isNaN(qty)) {
        totalQty += qty;
      }
    });

    var totalRow = document.createElement('tr');
    if (data.tipe === 'toko') {
      totalRow.innerHTML = `
          <td colspan="2" class="text-right"><strong>Total Qty:</strong></td>
          <td class="text-center">${totalQty}</td>
      `;
    } else {
      totalRow.innerHTML = `
          <td colspan="3" class="text-right"><strong>Total Qty:</strong></td>
          <td class="text-center">${totalQty}</td>
      `;
    }

    tableBody.appendChild(totalRow);
    document.getElementById('downloadExcelBtn').addEventListener('click', function() {
      var tipe = data.tipe;
      downloadExcel(tipe);
    });
  }

  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Print Page</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f4f4f4; }');
    printWindow.document.write('@media print { body * { visibility: hidden; } #printableArea, #printableArea * { visibility: visible; } #printableArea { position: absolute; left: 0; top: 0; width: 100%; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<div id="printableArea">');
    printWindow.document.write(printContents);
    printWindow.document.write('</div>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    // Menambahkan jeda sebelum memulai pencetakan
    setTimeout(function() {
      printWindow.print();
      printWindow.close();
    }, 500); // Penundaan 500ms untuk memastikan konten sudah terload
  }
</script>