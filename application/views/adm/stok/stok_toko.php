<style>
  #loading {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.85);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(5px);
  }

  .loader {
    position: relative;
    width: 320px;
    padding: 40px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
    text-align: center;
  }

  .loader-icon {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
  }

  .circle {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 8px solid #e0e0e0;
    border-top: 8px solid #17a2b8;
    border-right: 8px solid #28a745;
    animation: rotate 1.5s linear infinite;
  }

  @keyframes rotate {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .progress-circle {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: conic-gradient(#17a2b8 0deg, #17a2b8 0deg, transparent 0deg);
    display: flex;
    justify-content: center;
    align-items: center;
    transition: background 0.3s ease;
  }

  .percentage {
    font-size: 1.5em;
    font-weight: bold;
    color: #fff;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
  }

  .loading-text {
    margin-top: 15px;
    font-size: 18px;
    font-weight: 600;
    color: #333;
    animation: pulse 1.5s ease-in-out infinite;
  }

  .loading-subtext {
    margin-top: 10px;
    font-size: 13px;
    color: #666;
    line-height: 1.4;
  }

  .loading-dots {
    display: inline-block;
  }

  .loading-dots span {
    animation: blink 1.4s infinite;
    animation-fill-mode: both;
  }

  .loading-dots span:nth-child(2) {
    animation-delay: 0.2s;
  }

  .loading-dots span:nth-child(3) {
    animation-delay: 0.4s;
  }

  @keyframes blink {

    0%,
    80%,
    100% {
      opacity: 0;
    }

    40% {
      opacity: 1;
    }
  }

  @keyframes pulse {

    0%,
    100% {
      opacity: 1;
    }

    50% {
      opacity: 0.7;
    }
  }

  .progress-info {
    margin-top: 15px;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #17a2b8;
  }

  .progress-stage {
    font-size: 12px;
    color: #17a2b8;
    font-weight: 600;
    margin-bottom: 5px;
  }

  .img-nodata {
    width: 100%;

  }
</style>
<style>
  .store-stock-page{--ss-primary:#0f766e;--ss-dark:#134e4a;--ss-muted:#64748b;--ss-border:#e2e8f0}
  .store-hero{position:relative;overflow:hidden;padding:28px;margin-bottom:20px;color:#fff;border-radius:18px;background:linear-gradient(125deg,#134e4a 0%,#0f766e 55%,#06b6d4 100%);box-shadow:0 14px 35px rgba(15,118,110,.18)}
  .store-hero:after{content:'';position:absolute;width:220px;height:220px;right:-65px;top:-95px;border:35px solid rgba(255,255,255,.08);border-radius:50%}
  .store-hero-content{position:relative;z-index:1}.store-hero-icon{width:52px;height:52px;display:flex;align-items:center;justify-content:center;flex:0 0 52px;margin-right:16px;border-radius:14px;background:rgba(255,255,255,.14);font-size:1.35rem}
  .store-hero h1{margin:0 0 7px;font-size:1.55rem;font-weight:700}.store-hero p{margin:0;color:rgba(255,255,255,.82)}
  .active-data-note{display:flex;align-items:flex-start;padding:13px 15px;margin-top:20px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);border-radius:12px;font-size:.84rem}.active-data-note i{margin:3px 10px 0 0;color:#86efac}
  .store-stock-page .cari.card,.store-stock-page .hasil.card{overflow:hidden;border:0;border-radius:16px;box-shadow:0 8px 28px rgba(15,23,42,.07)}
  .store-stock-page .cari.card>.card-header{display:none}.store-stock-page .cari.card>.card-body{padding:24px}.filter-title{color:var(--ss-dark);font-size:1rem;font-weight:700}.filter-subtitle{color:var(--ss-muted);font-size:.82rem}
  .store-stock-page label{color:#334155;font-size:.75rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase}.store-stock-page .form-control,.store-stock-page .select2-container .select2-selection--single{min-height:42px;border-color:var(--ss-border);border-radius:9px}
  .store-stock-page .btn-cari{width:100%;min-height:42px;padding:8px 16px;border:0;border-radius:9px;background:var(--ss-primary);box-shadow:0 6px 15px rgba(15,118,110,.22);font-weight:600}
  .result-heading{padding:20px 22px;border-bottom:1px solid var(--ss-border)}.active-badge{display:inline-flex;align-items:center;padding:6px 10px;color:#166534;background:#dcfce7;border-radius:999px;font-size:.72rem;font-weight:700}.active-badge:before{content:'';width:7px;height:7px;margin-right:7px;background:#22c55e;border-radius:50%}
  .summary-card{height:100%;padding:16px 17px;background:#fff;border:1px solid var(--ss-border);border-radius:13px}.summary-icon{width:38px;height:38px;display:flex;align-items:center;justify-content:center;margin-right:12px;color:var(--ss-primary);background:#f0fdfa;border-radius:10px}.summary-label{color:var(--ss-muted);font-size:.7rem;text-transform:uppercase;letter-spacing:.05em}.summary-value{color:#0f172a;font-size:1.08rem;font-weight:700}
  .store-stock-page .hasil .card-body{padding:0}.store-stock-page #printableArea>.text-center,.store-stock-page #printableArea>hr{display:none}.store-stock-page #toko{margin:0;padding:16px 22px 4px;text-align:left!important;font-weight:700}.store-stock-page #artikel{margin:0;padding:0 22px 16px;text-align:left!important;color:var(--ss-muted);border-bottom:1px solid var(--ss-border)}
  .store-stock-page .hasil table{margin:0}.store-stock-page .hasil thead th{padding:13px 12px;border:0;background:#f8fafc;color:#475569;font-size:.72rem;letter-spacing:.04em;text-transform:uppercase;white-space:nowrap}.store-stock-page .hasil tbody td{padding:13px 12px;border-color:#eef2f7;vertical-align:middle}.store-stock-page .hasil tbody tr:hover{background:#f8fffe}.store-stock-page .hasil .card-footer{padding:14px 18px;background:#fff;border-top:1px solid var(--ss-border)}
  .store-stock-page .no-data{max-width:520px;margin:25px auto;text-align:center}.store-stock-page .no-data img{max-width:350px}
  @media(max-width:767.98px){.store-hero{padding:22px 18px;border-radius:14px}.store-hero h1{font-size:1.3rem}.store-stock-page .cari.card>.card-body{padding:18px}.summary-card{height:auto;margin-bottom:10px}.store-stock-page .hasil .card-body{overflow-x:auto}}
</style>
<section class="content store-stock-page">
  <div class="container-fluid">
    <div class="store-hero cari"><div class="store-hero-content"><div class="d-flex align-items-center"><div class="store-hero-icon"><i class="fas fa-store"></i></div><div><h1>Laporan Stok per Toko</h1><p>Lihat komposisi dan posisi stok artikel pada setiap toko secara lebih terarah.</p></div></div><div class="active-data-note"><i class="fas fa-check-circle"></i><div><strong>Data operasional aktif.</strong> Laporan bersumber dari stok dan hanya menampilkan artikel aktif pada toko yang sedang aktif beroperasi.</div></div></div></div>
    <div class="card card-info card-outline cari">
      <div class="card-header">
        <h3 class="card-title">
          <li class="fas fa-cubes"></li> Laporan stok per toko
        </h3>
      </div>
      <div class="card-body">
        <div class="mb-4"><div class="filter-title"><i class="fas fa-sliders-h mr-2 text-info"></i>Filter laporan</div><div class="filter-subtitle mt-1">Pilih toko, artikel, dan tanggal posisi stok yang ingin dilihat.</div></div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="id_toko">Toko</label>
              <select name="id_toko" class="form-control form-control-sm select2" id="id_toko" required>
                <option value="">- Pilih Toko -</option>
                <?php foreach ($toko as $t) : ?>
                  <option value="<?= $t->id ?>"><?= htmlspecialchars($t->nama_toko) ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="id_artikel">Artikel</label>
              <select name="id_artikel" class="form-control form-control-sm select2" id="id_artikel" required>
                <option value="all">Semua Artikel</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="tanggal">Posisi Stok per Tanggal</label>
              <div class="input-group">
                <input type="date" name="tanggal" id="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>">
              </div>
            </div>
          </div>
          <div class="col-md-1 pt-3">
            <button class="btn btn-info btn-cari mt-3" id="searchBtn">
              <i class="fas fa-search"></i> Cari
            </button>
          </div>
        </div>
      </div>
    </div>
    <div id="loading" style="display: none;">
      <div class="loader">
        <div class="loader-icon">
          <div class="circle"></div>
          <div class="progress-circle">
            <div class="percentage" id="percentage">0%</div>
          </div>
        </div>
        <div class="loading-text">
          <span id="loadingText">Memuat Data</span><span class="loading-dots"><span>.</span><span>.</span><span>.</span></span>
        </div>
        <div class="loading-subtext" id="loadingSubtext">
          Mohon tunggu, sedang mengambil data dari server
        </div>
        <div class="progress-info">
          <div class="progress-stage" id="progressStage">Menginisialisasi...</div>
        </div>
      </div>
    </div>
    <div class="no-data">
      <img src="<?= base_url('assets/img/nodata.png') ?>" alt="no-data" class="img-nodata">
      <h5 class="font-weight-bold text-dark mt-3">Laporan siap ditampilkan</h5>
      <p class="text-muted">Pilih toko dan tanggal untuk melihat posisi stok.</p>
    </div>
    <div class="card hasil d-none">
      <div class="result-heading">
        <div class="d-flex flex-wrap justify-content-between align-items-center"><div><h5 class="mb-1 font-weight-bold">Hasil Laporan Stok Toko</h5><div class="text-muted small">Ringkasan posisi stok berdasarkan filter yang dipilih</div></div><span class="active-badge mt-2 mt-md-0">Data aktif</span></div>
        <div class="row mt-3">
          <div class="col-md-4"><div class="summary-card d-flex align-items-center"><div class="summary-icon"><i class="fas fa-box"></i></div><div><div class="summary-label">Jumlah artikel</div><div class="summary-value" id="totalArtikel">0</div></div></div></div>
          <div class="col-md-4"><div class="summary-card d-flex align-items-center"><div class="summary-icon"><i class="fas fa-layer-group"></i></div><div><div class="summary-label">Total stok</div><div class="summary-value" id="summaryTotalStok">0</div></div></div></div>
          <div class="col-md-4"><div class="summary-card d-flex align-items-center"><div class="summary-icon"><i class="far fa-calendar-check"></i></div><div><div class="summary-label">Posisi tanggal</div><div class="summary-value" id="summaryTanggal">-</div></div></div></div>
        </div>
      </div>
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
                <th>Nama Toko</th>
              </tr>
            </thead>
            <tbody id="dataTableBody">
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
        <a type="button" onclick="printDiv('printableArea')" target="_blank" class="btn btn-default btn-sm float-right mr-3 ml-2">
          <i class="fas fa-print"></i> Cetak </a>
        <button class="btn btn-success btn-sm float-right" id="downloadExcelBtn"><i class="fas fa-file-excel"></i> Unduh Excel</button>
        <a href="<?= base_url('adm/Stok/s_toko') ?>" class="btn btn-light btn-sm float-right mr-1"><i class="fas fa-redo"></i> Filter Ulang</a>
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
    var header = ["No", "Kode", "Artikel", "Satuan", "Stok", "Tanggal", "Nama Toko"];
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

  document.getElementById('searchBtn').addEventListener('click', async function() {
    var idToko = document.getElementById('id_toko').value;
    var idArtikel = document.getElementById('id_artikel').value;
    var tanggal = document.getElementById('tanggal').value;
    const url = '<?= base_url('adm/Stok') ?>';
    if (validateForm()) {
      document.getElementById('loading').style.display = 'flex';
      document.getElementById('percentage').innerHTML = '<i class="fas fa-database"></i>';
      document.getElementById('progressStage').textContent = 'Mengambil data stok toko...';
      document.getElementById('loadingSubtext').textContent = 'Menghitung stok terakhir dari artikel dan toko aktif';
      try {
        const response = await fetch(`${url}/cari_stoktoko?id_toko=${encodeURIComponent(idToko)}&id_artikel=${encodeURIComponent(idArtikel)}&tanggal=${encodeURIComponent(tanggal)}`);
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        const data = await response.json();
        if (data.tabel_data && data.tabel_data.length > 0) updateUI(data);
        else Swal.fire('TIDAK ADA DATA', 'Data tidak ditemukan, silakan ubah filter pencarian.', 'info');
      } catch (error) {
        console.error('Error fetching data:', error);
        Swal.fire('GAGAL MEMUAT DATA', 'Terjadi kesalahan saat mengambil data stok.', 'error');
      } finally {
        document.getElementById('loading').style.display = 'none';
      }
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
      row.innerHTML = `
            <td class="text-center"><small>${index + 1}</small></td>
            <td><small>${item.kode}</small></td>
            <td><small>${item.nama_produk}</small></td>
            <td><small>${item.satuan}</small></td>
            <td class="text-center"> ${item.stok}</td>
            <td class="text-center">${data.tanggal}</td>
            <td class="text-center text-sm">${data.toko}</td>
        `;
      tableBody.appendChild(row);
      var qty = Number(item.stok);
      if (!isNaN(qty)) {
        totalstok += qty;
      }
    });

    var totalRow = document.createElement('tr');
    totalRow.innerHTML = `
    <td colspan="4" class="text-right"><strong>Total : </strong></td>
    <td class="text-center font-weight-bold">${totalstok.toLocaleString('id-ID')}</td>`;
    tableBody.appendChild(totalRow);
    document.getElementById('summaryTotalStok').textContent = totalstok.toLocaleString('id-ID');
    document.getElementById('totalArtikel').textContent = data.tabel_data.length.toLocaleString('id-ID');
    document.getElementById('summaryTanggal').textContent = data.tanggal;
  }

  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan Stok per Toko</title><style>body{font-family:Arial,sans-serif;padding:24px;color:#222}table{width:100%;border-collapse:collapse;margin-top:16px}th,td{padding:8px;border:1px solid #ddd}th{background:#f3f4f6}.text-center{text-align:center}.text-right{text-align:right}</style></head><body>' + printContents + '</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
  }
</script>
