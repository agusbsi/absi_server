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
  <div class="container-fluid">
    <div class="card card-info card-outline cari">
      <div class="card-header">
        <h3 class="card-title">
          <li class="fas fa-cubes"></li> Laporan stok per toko
        </h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Toko :</label>
              <select name="id_toko" class="form-control form-control-sm select2" id="id_toko" required>
                <option value="">- Pilih Toko -</option>
                <?php foreach ($toko as $t) : ?>
                  <option value="<?= $t->id ?>"><?= $t->nama_toko ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Artikel :</label>
              <select name="id_artikel" class="form-control form-control-sm select2" id="id_artikel" required>
                <option value=""> Semua Artikel </option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Tanggal :</label>
              <div class="input-group">
                <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm " required>
              </div>
            </div>
          </div>
          <div class="col-md-1 pt-3">
            <button class="btn btn-info btn-sm btn-cari mt-3" id="searchBtn">
              <li class="fas fa-search"></li> Cari
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
          <div class="text-center"> <strong>- Laporan stok per toko -</strong></div>
          <hr>
          <p class="text-center" id="toko"></p>
          <p class="text-center" id="artikel"></p>
          <table class="table table-bordered">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th>Kode</th>
                <th>Artikel</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Tanggal</th>
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
        <a href="<?= base_url('adm/Stok/s_toko') ?>" class="btn btn-danger btn-sm float-right mr-1"><i class="fa fa-times-circle"></i> close</a>
      </div>
    </div>
  </div>
  </div>
</section>

<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

<script>
  $('#id_toko').on('change', function() {
    var toko = $(this).val();
    if (toko) {
      $.ajax({
        url: "<?php echo base_url('adm/Stok/list_ajax_artikel'); ?>/" + toko,
        dataType: 'json',
        success: function(data) {
          $('#id_artikel').empty();
          $('#id_artikel').append('<option value="all"> Semua Artikel </option>');
          $.each(data, function(index, item) {
            var optionText = $('<div>').text(item.kode + ' [' + item.nama_produk + ']').html();
            $('#id_artikel').append('<option value="' + item.id + '">' + optionText + '</option>');
          });
        }
      });
    }
  });


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
    var header = ["No", "Kode", "Artikel", "Satuan", "Stok", "Tanggal"];
    var sheetData = [];
    var toko = document.getElementById('toko').innerHTML;
    sheetData.push(header);
    var table = document.getElementById('dataTableBody');
    for (var i = 0; i < table.rows.length; i++) {
      var row = [];
      for (var j = 0; j < table.rows[i].cells.length; j++) {
        var cellValue = table.rows[i].cells[j].textContent.trim();
        if (header[j] === "Stok") {
          var numericValue = parseFloat(cellValue.replace(/[^0-9.-]+/g, ''));
          row.push(isNaN(numericValue) ? cellValue : numericValue);
        } else {
          row.push(cellValue);
        }
      }
      sheetData.push(row);
    }
    var ws = XLSX.utils.aoa_to_sheet(sheetData);
    XLSX.utils.book_append_sheet(wb, ws, 'Stok Artikel');
    var filename = 'Laporan_stok_' + toko + '.xlsx';
    XLSX.writeFile(wb, filename);
  }

  document.getElementById('searchBtn').addEventListener('click', function() {
    var idToko = document.getElementById('id_toko').value;
    var idArtikel = document.getElementById('id_artikel').value;
    var tanggal = document.getElementById('tanggal').value;
    const url = '<?= base_url('adm/Stok') ?>';
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

      fetch(`${url}/cari_stoktoko?id_toko=${idToko}&id_artikel=${idArtikel}&tanggal=${tanggal}`)
        .then(response => response.json())
        .then(data => {
          var additionalDuration = 2000;
          var additionalIntervalTime = intervalTime;
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
    $('#toko').html(data.toko);
    $('#artikel').html(data.artikel);
    $('.cari').addClass('d-none');
    $('.no-data').addClass('d-none');
    $('.hasil').removeClass('d-none');
    // Update the table
    var tableBody = document.getElementById('dataTableBody');
    var totalstok = 0;
    tableBody.innerHTML = '';
    data.tabel_data.forEach((item, index) => {
      var row = document.createElement('tr');
      var stok = parseInt(item.stok_awal) - parseInt(item.jual) - parseInt(item.retur) - parseInt(item.mutasi_keluar) + parseInt(item.mutasi_masuk) + parseInt(item.terima);
      row.innerHTML = `
            <td class="text-center"><small>${index + 1}</small></td>
            <td><small>${item.kode}</small></td>
            <td><small>${item.nama_produk}</small></td>
            <td><small>${item.satuan}</small></td>
            <td class="text-center"> ${stok}</td>
            <td class="text-center">${data.tanggal}</td>
        `;
      tableBody.appendChild(row);
      var qty = parseInt(stok, 10);
      if (!isNaN(qty)) {
        totalstok += qty;
      }
    });

    var totalRow = document.createElement('tr');
    totalRow.innerHTML = `
    <td colspan="4" class="text-right"><strong>Total : </strong></td>
    <td class="text-center">${totalstok}</td>`;
    tableBody.appendChild(totalRow);
  }

  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  }
</script>