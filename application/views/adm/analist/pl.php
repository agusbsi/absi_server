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
          <li class="fas fa-search"></li> Potential Lost
        </h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Toko :</label>
              <input type="text" class="form-control form-control-sm" value="Semua Toko" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Periode SO :</label>
              <div class="form-group">
                <select name="periode" id="periode" class="form-control form-control-sm select2" required>
                <option value="">Pilih Periode</option>
                  <?php foreach ($periode as $p):?>
                    <option value="<?= $p->periode ?>"><?= date('M Y', strtotime('-1 month', strtotime($p->periode . '-01'))) ?></option>
                  <?php endforeach ?>
                </select>
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
          <div class="text-center"> <strong>- Analisa Potensi Kehilangan -</strong>
          </div>
          <hr>
          <p class="text-center"> ( Semua Toko )</p>
          <p class="text-center"> Periode :</p>
          <div class="text-center"><label id="periode_hasil" class="mr-2 text-center"></label>
          </div>
          <table id="myTable" class="table table-bordered mt-4">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th>Nama Toko</th>
                <th>Stok Akhir</th>
                <th>SO SPG</th>
                <th>Selisih</th>
                <th>( % )</th>
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
        <a href="<?= base_url('adm/Analist/pl') ?>" class="btn btn-danger btn-sm float-right mr-1"><i class="fa fa-times-circle"></i> close</a>
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
  document.getElementById('downloadExcelBtn').addEventListener('click', function() {
    downloadExcel();
  });

  function downloadExcel() {
    var wb = XLSX.utils.book_new();
    var header = ["No", "Nama Toko", "Stok Akhir", "SO SPG", "Selisih", "( % )"];
    var sheetData = [];

    // Ambil nilai toko dan periode dari HTML
    var toko = 'Semua Toko';
    var periode = document.getElementById('periode_hasil').textContent.trim();

    // Tambahkan baris pertama untuk nama toko dan periode
    sheetData.push([toko]);
    sheetData.push(["Periode :", periode]);

    // Tambahkan header kolom
    sheetData.push(header);

    // Ambil data dari tabel
    var table = document.getElementById('dataTableBody');
    for (var i = 0; i < table.rows.length; i++) {
      var row = [];
      for (var j = 0; j < table.rows[i].cells.length; j++) {
        var cellValue = table.rows[i].cells[j].textContent.trim();
        if (header[j] === "Stok Akhir" || header[j] === "SO SPG" || header[j] === "Selisih" || header[j] === "( % )") {
          var numericValue = parseFloat(cellValue.replace(/[^0-9.-]+/g, ''));
          row.push(isNaN(numericValue) ? cellValue : numericValue);
        } else {
          row.push(cellValue);
        }
      }
      sheetData.push(row);
    }

    // Buat worksheet dan tambahkan ke workbook
    var ws = XLSX.utils.aoa_to_sheet(sheetData);
    XLSX.utils.book_append_sheet(wb, ws, 'PL');

    // Simpan file Excel dengan nama sesuai toko
    var filename = periode + '.xlsx';
    XLSX.writeFile(wb, filename);
  }


  document.getElementById('searchBtn').addEventListener('click', function() {
    var periode = document.getElementById('periode').value;
    const url = '<?= base_url('adm/Analist') ?>';
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

      fetch(`${url}/cari_pl?periode=${periode}`)
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
    $('#periode_hasil').html(data.periode);
    $('.cari').addClass('d-none');
    $('.no-data').addClass('d-none');
    $('.hasil').removeClass('d-none');
    // Update the table
    var tableBody = document.getElementById('dataTableBody');
    var t_akhir = 0;
    var t_spg = 0;
    
    tableBody.innerHTML = '';
    data.tabel_data.forEach((item, index) => {
      var row = document.createElement('tr');
      let selisih = parseInt(item.so_spg - item.akhir);
      row.innerHTML = `
      <td class="text-center"><small>${index + 1}</small></td>
      <td><small>${item.nama_toko}</small></td>
      <td class="text-center">${item.akhir == 0 ? '-' : formatRibuan(parseInt(item.akhir,10))}</td>
      <td class="text-center">${item.so_spg == 0 ? '-' : formatRibuan(parseInt(item.so_spg,10))}</td> 
      <td class="text-center ${selisih < 0 ? 'text-danger' : 'text-success'}">${selisih > 0 ? '+' + selisih : selisih}</td>
      <td class="text-center ${(selisih / item.akhir * 100) < 0 ? 'text-danger':'text-success'}">${ item.akhir == 0 ? '-':
        ((selisih / item.akhir * 100) > 0 ?
            `+${(selisih / item.akhir * 100).toFixed(1)} %` :
            `${(selisih / item.akhir * 100).toFixed(1)} %`)}
      </td>`;

      tableBody.appendChild(row);
      var awal = parseInt(item.akhir, 10);
      if (!isNaN(awal)) {
        t_akhir += awal;
      }
      var spg = parseInt(item.so_spg, 10);
      if (!isNaN(spg)) {
        t_spg += spg;
      }
    });

    var totalRow = document.createElement('tr');
    let persen = (parseInt(t_spg - t_akhir) / t_akhir * 100).toFixed(2);
    totalRow.innerHTML = `
    <td colspan="2" class="text-right"><strong>Total : </strong></td>
    <td class="text-center">${formatRibuan(t_akhir)}</td>
    <td class="text-center">${formatRibuan(t_spg)}</td>
    <td class="text-center">${formatRibuan(parseInt(t_spg - t_akhir))}</td>
    <td class="text-center ${persen > 0 ? 'text-success':'text-danger'}">${persen > 0 ? '+' + persen : persen} %</td>
`;
    tableBody.appendChild(totalRow);
  }
  function formatRibuan(angka) {
      if (typeof angka !== 'number') {
          return angka; // Kembalikan nilai asli jika bukan angka
      }
      return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
</script>