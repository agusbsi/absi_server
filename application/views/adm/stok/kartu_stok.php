<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    background: #f8f9fa;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
  }

  .content {
    padding: 15px 0;
  }

  .modern-card {
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 15px;
    border: 1px solid #e0e0e0;
  }

  .card-header-modern {
    padding: 15px 20px;
    background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
    border-radius: 8px 8px 0 0;
  }

  .card-header-modern h3 {
    color: #ffffff;
    font-size: 18px;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .card-body-modern {
    padding: 20px;
  }

  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 15px;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .form-label {
    font-size: 13px;
    font-weight: 600;
    color: #2d3748;
  }

  .form-section {
    background: #f8f9fa;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    padding: 15px;
    margin-bottom: 15px;
  }

  .section-title {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 2px solid #5e72e4;
  }

  .modern-select,
  .modern-input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #cbd5e0;
    border-radius: 6px;
    font-size: 14px;
    background: #ffffff;
    color: #2d3748;
    transition: all 0.2s;
  }

  .modern-select:focus,
  .modern-input:focus {
    outline: none;
    border-color: #5e72e4;
    box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.1);
  }

  .modern-select:disabled {
    background: #e2e8f0;
    cursor: not-allowed;
  }

  .date-range-wrapper {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 12px;
    align-items: end;
  }

  .date-input-wrapper {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .date-label {
    font-size: 12px;
    font-weight: 500;
    color: #4a5568;
  }

  .date-separator {
    font-weight: 600;
    color: #a0aec0;
    padding-bottom: 10px;
  }

  .modern-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    font-size: 14px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
  }

  .btn-primary-modern {
    background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
    color: #ffffff;
  }

  .btn-primary-modern:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(94, 114, 228, 0.4);
  }

  .btn-success-modern {
    background: #10b981;
    color: #ffffff;
  }

  .btn-success-modern:hover {
    background: #059669;
  }

  .btn-danger-modern {
    background: #ef4444;
    color: #ffffff;
  }

  .btn-danger-modern:hover {
    background: #dc2626;
  }

  #loading {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .loader {
    background: #ffffff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    text-align: center;
  }

  .spinner {
    width: 50px;
    height: 50px;
    margin: 0 auto 15px;
    border: 3px solid #e2e8f0;
    border-top-color: #5e72e4;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }

  .loading-text {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 5px;
  }

  .loading-subtext {
    font-size: 13px;
    color: #718096;
  }

  .empty-state {
    text-align: center;
    padding: 40px 20px;
  }

  .empty-state img {
    max-width: 250px;
    margin-bottom: 20px;
    opacity: 0.6;
  }

  .empty-state h4 {
    color: #2d3748;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .empty-state p {
    color: #718096;
    font-size: 14px;
    line-height: 1.5;
  }

  .report-header {
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e2e8f0;
  }

  .report-title {
    font-size: 20px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 15px;
  }

  .report-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .info-badge {
    display: inline-block;
    padding: 6px 12px;
    background: #f7fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #4a5568;
  }

  .saldo-card {
    background: #f7fafc;
    padding: 12px 16px;
    border-radius: 6px;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #e2e8f0;
  }

  .saldo-label {
    font-weight: 600;
    color: #4a5568;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .saldo-value {
    font-size: 20px;
    font-weight: 700;
    color: #5e72e4;
  }

  .result-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    background: #ffffff;
    border: 1px solid #cbd5e0;
  }

  .result-table thead {
    background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
  }

  .result-table thead th {
    color: #ffffff;
    padding: 10px 8px;
    font-weight: 600;
    text-align: center;
    font-size: 11px;
    text-transform: uppercase;
    border: 1px solid rgba(255, 255, 255, 0.2);
  }

  .result-table tbody td {
    padding: 8px;
    border: 1px solid #e2e8f0;
    color: #4a5568;
    text-align: center;
    vertical-align: middle;
  }

  .result-table tbody tr:hover {
    background: #f7fafc;
  }

  .td-left {
    text-align: left !important;
  }

  .td-right {
    text-align: right !important;
  }

  .stock-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 12px;
    display: inline-block;
  }

  .stock-in {
    background: #d1fae5;
    color: #065f46;
  }

  .stock-out {
    background: #fee2e2;
    color: #991b1b;
  }

  .action-buttons {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    flex-wrap: wrap;
  }

  @media print {
    @page {
      size: A4;
      margin: 1cm;
    }

    body {
      background: white;
      margin: 0;
      padding: 0;
    }

    .cari,
    .action-buttons,
    .no-data,
    .card-header-modern {
      display: none !important;
    }

    .modern-card {
      box-shadow: none;
      border: none;
      page-break-inside: avoid;
      margin: 0;
    }

    .card-body-modern {
      padding: 15px;
    }

    .report-header {
      border-bottom: 2px solid #000;
      margin-bottom: 15px;
      padding-bottom: 10px;
    }

    .report-title {
      color: #000 !important;
      font-size: 18px;
      font-weight: bold;
    }

    .info-badge {
      border: 1px solid #000;
      background: white;
      color: #000 !important;
      display: block;
      margin: 5px 0;
    }

    .saldo-card {
      border: 2px solid #000;
      background: white;
      padding: 10px;
      margin: 10px 0;
    }

    .saldo-label,
    .saldo-value {
      color: #000 !important;
      font-weight: bold;
    }

    .result-table {
      border: 2px solid #000 !important;
      width: 100%;
      margin: 10px 0;
    }

    .result-table thead {
      background: #000 !important;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .result-table thead th {
      border: 1px solid #000 !important;
      color: #ffffff !important;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
      padding: 8px 4px;
      font-size: 10px;
      font-weight: bold;
    }

    .result-table tbody td {
      border: 1px solid #000 !important;
      color: #000 !important;
      padding: 6px 4px;
      font-size: 10px;
    }

    .result-table tbody tr:hover {
      background: white !important;
    }

    .stock-badge {
      background: white !important;
      color: #000 !important;
      border: 1px solid #000;
      padding: 2px 6px;
      font-weight: bold;
    }
  }

  @media (max-width: 768px) {
    .form-row {
      grid-template-columns: 1fr;
    }

    .date-range-wrapper {
      grid-template-columns: 1fr;
    }

    .date-separator {
      display: none;
    }

    .action-buttons {
      flex-direction: column;
    }

    .modern-btn {
      width: 100%;
      justify-content: center;
    }
  }
</style>
<section class="content">
  <div class="container-fluid">
    <!-- Form Card -->
    <div class="modern-card cari">
      <div class="card-header-modern">
        <h3>
          <i class="fas fa-clipboard-list"></i>
          Laporan Kartu Stok
        </h3>
      </div>
      <div class="card-body-modern">
        <!-- Pilih Toko & Produk -->
        <div class="form-section">
          <div class="section-title">Filter Laporan</div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Pilih Toko</label>
              <select name="id_toko" class="modern-select select2" id="id_toko" required>
                <option value="">-- Pilih Toko --</option>
                <?php foreach ($toko as $t) : ?>
                  <option value="<?= $t->id ?>"><?= $t->nama_toko ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Pilih Produk</label>
              <select name="id_artikel" class="modern-select select2" id="id_artikel" required disabled>
                <option value="">-- Pilih toko terlebih dahulu --</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Periode Tanggal -->
        <div class="form-section">
          <div class="section-title">Periode Tanggal</div>
          <div class="date-range-wrapper">
            <div class="date-input-wrapper">
              <label class="date-label">Tanggal Awal</label>
              <input type="date" name="tgl_awal" id="tgl_awal" class="modern-input" required>
            </div>
            <span class="date-separator">—</span>
            <div class="date-input-wrapper">
              <label class="date-label">Tanggal Akhir</label>
              <input type="date" name="tgl_akhir" id="tgl_akhir" class="modern-input" required>
            </div>
          </div>
        </div>

        <!-- Action Button -->
        <div style="text-align: right;">
          <button class="modern-btn btn-primary-modern" id="searchBtn">
            <i class="fas fa-search"></i>
            <span>Tampilkan Laporan</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div id="loading" style="display: none;">
      <div class="loader">
        <div class="spinner"></div>
        <div class="loading-text">Memproses Data</div>
        <div class="loading-subtext">Mohon tunggu...</div>
      </div>
    </div>

    <!-- Empty State -->
    <div class="empty-state no-data">
      <img src="<?= base_url('assets/img/nodata.png') ?>" alt="no-data">
      <h4>Belum Ada Data</h4>
      <p>Lengkapi form untuk menampilkan laporan kartu stok</p>
    </div>

    <!-- Results Card -->
    <div class="modern-card hasil d-none">
      <div class="card-body-modern">
        <div id="printableArea">
          <!-- Report Header -->
          <div class="report-header">
            <h2 class="report-title">Laporan Kartu Stok</h2>
            <div class="report-info">
              <div class="info-badge" id="toko"></div>
              <div class="info-badge" id="artikel"></div>
              <div class="info-badge">
                <i class="fas fa-calendar-alt" style="margin-right: 6px;"></i>
                Periode: <span id="lap_awal"></span> s/d <span id="lap_akhir"></span>
              </div>
            </div>
          </div>

          <!-- Saldo Awal -->
          <div class="saldo-card">
            <span class="saldo-label">
              <i class="fas fa-box-open"></i>
              Saldo Awal
            </span>
            <span class="saldo-value" id="s_awal">0</span>
          </div>

          <!-- Table -->
          <div style="overflow-x: auto; margin-bottom: 15px;">
            <table class="result-table">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>No. Dokumen</th>
                  <th>Transaksi</th>
                  <th>Pembuat</th>
                  <th>Masuk</th>
                  <th>Keluar</th>
                  <th>Sisa</th>
                </tr>
              </thead>
              <tbody id="dataTableBody">
              </tbody>
            </table>
          </div>

          <!-- Saldo Akhir -->
          <div class="saldo-card">
            <span class="saldo-label">
              <i class="fas fa-check-circle"></i>
              Saldo Akhir
            </span>
            <span class="saldo-value" style="color: #10b981;" id="s_akhir">0</span>
          </div>
        </div>
      </div>
      <div class="card-body-modern" style="border-top: 1px solid #e2e8f0; padding-top: 15px;">
        <div class="action-buttons">
          <button class="modern-btn btn-danger-modern" onclick="location.href='<?= base_url('adm/Stok/kartu_stok') ?>'">
            <i class="fa fa-times-circle"></i>
            <span>Tutup</span>
          </button>
          <button class="modern-btn btn-success-modern" id="downloadExcelBtn">
            <i class="fas fa-file-excel"></i>
            <span>Unduh Excel</span>
          </button>
          <button class="modern-btn btn-primary-modern" onclick="printDiv('printableArea')">
            <i class="fas fa-print"></i>
            <span>Cetak</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

<script>
  $(document).ready(function() {
    // Excel download handler
    $(document).on('click', '#downloadExcelBtn', function() {
      downloadExcel();
    });

    // When store is selected, load products for that store
    $('#id_toko').on('change', function() {
      const idToko = $(this).val();
      const artikelSelect = $('#id_artikel');

      if (idToko) {
        // Enable artikel select
        artikelSelect.prop('disabled', false);
        artikelSelect.html('<option value="">-- Memuat produk... --</option>');

        // Fetch products for selected store
        $.ajax({
          url: '<?= base_url('adm/Stok/get_produk_by_toko') ?>',
          type: 'GET',
          data: {
            id_toko: idToko
          },
          dataType: 'json',
          success: function(response) {
            let options = '<option value="">-- Pilih Produk --</option>';
            if (response.length > 0) {
              response.forEach(function(item) {
                options += `<option value="${item.id}">${item.kode} | ${item.nama_produk}</option>`;
              });
            } else {
              options = '<option value="">-- Tidak ada produk di toko ini --</option>';
            }
            artikelSelect.html(options);
          },
          error: function() {
            artikelSelect.html('<option value="">-- Gagal memuat produk --</option>');
          }
        });
      } else {
        // Reset artikel select
        artikelSelect.prop('disabled', true);
        artikelSelect.html('<option value="">-- Pilih toko terlebih dahulu --</option>');
      }
    });
  });

  function validateForm() {
    let isValid = true;
    $('.cari').find('input[required], select[required]').each(function() {
      if ($(this).val() === '') {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    return isValid;
  }

  function downloadExcel() {
    var wb = XLSX.utils.book_new();
    var header = ["Tanggal", "No.Dok", "Transaksi", "Pembuat", "Masuk", "Keluar", "Sisa"];
    var sheetData = [];
    sheetData.push(header);
    var table = document.getElementById('dataTableBody');
    for (var i = 0; i < table.rows.length; i++) {
      var row = [];
      for (var j = 0; j < table.rows[i].cells.length; j++) {
        var cellValue = table.rows[i].cells[j].textContent.trim();
        if (header[j] === "Masuk" || header[j] === "Keluar" || header[j] === "Sisa") {
          var numericValue = parseFloat(cellValue.replace(/[^0-9.-]+/g, ''));
          row.push(isNaN(numericValue) ? cellValue : numericValue);
        } else {
          row.push(cellValue);
        }
      }
      sheetData.push(row);
    }
    var ws = XLSX.utils.aoa_to_sheet(sheetData);
    XLSX.utils.book_append_sheet(wb, ws, 'Laporan Kartu Stok');
    var filename = 'Laporan_kartu_stok.xlsx';
    XLSX.writeFile(wb, filename);
  }

  document.getElementById('searchBtn').addEventListener('click', function() {
    var idToko = document.getElementById('id_toko').value;
    var idArtikel = document.getElementById('id_artikel').value;
    var tglAwal = document.getElementById('tgl_awal').value;
    var tglAkhir = document.getElementById('tgl_akhir').value;
    const url = '<?= base_url('adm/Stok') ?>';

    if (validateForm()) {
      document.getElementById('loading').style.display = 'flex';

      fetch(`${url}/cari_kartu?id_toko=${idToko}&id_artikel=${idArtikel}&tgl_awal=${tglAwal}&tgl_akhir=${tglAkhir}`)
        .then(response => response.json())
        .then(data => {
          setTimeout(() => {
            document.getElementById('loading').style.display = 'none';
            if (data.tabel_data && data.tabel_data.length > 0) {
              updateUI(data);
            } else {
              Swal.fire({
                icon: 'info',
                title: 'Tidak Ada Data',
                text: 'Data tidak ditemukan untuk periode yang dipilih',
                confirmButtonColor: '#4F46E5'
              });
            }
          }, 800);
        })
        .catch(error => {
          console.error('Error fetching data:', error);
          document.getElementById('loading').style.display = 'none';
          Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Gagal memuat data, silakan coba lagi',
            confirmButtonColor: '#EF4444'
          });
        });
    } else {
      Swal.fire({
        icon: 'warning',
        title: 'Form Belum Lengkap',
        text: 'Mohon lengkapi semua field yang diperlukan',
        confirmButtonColor: '#4F46E5'
      });
    }
  });

  function updateUI(data) {
    $('#artikel').html(data.artikel);
    $('#toko').html(data.toko);
    $('#lap_awal').html(data.awal);
    $('#lap_akhir').html(data.akhir);
    $('.cari').addClass('d-none');
    $('.no-data').addClass('d-none');
    $('.hasil').removeClass('d-none');

    function formatDate(dateString) {
      const date = new Date(dateString);
      const options = {
        year: 'numeric',
        month: 'long',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      };
      let formattedDate = new Intl.DateTimeFormat('id-ID', options).format(date);
      return formattedDate;
    }

    var tableBody = document.getElementById('dataTableBody');
    tableBody.innerHTML = '';
    data.tabel_data.forEach((item, index) => {
      var formattedDate = formatDate(item.tanggal);
      var row = document.createElement('tr');

      const masukClass = item.masuk !== '-' ? 'stock-in' : '';
      const keluarClass = item.keluar !== '-' ? 'stock-out' : '';

      row.innerHTML = `
        <td>${formattedDate}</td>
        <td style="text-align: center;">${item.no_doc}</td>
        <td>${item.keterangan}</td>
        <td>${item.pembuat}</td>
        <td style="text-align: center;">
          ${item.masuk !== '-' ? '<span class="stock-badge stock-in">' + item.masuk + '</span>' : '-'}
        </td>
        <td style="text-align: center;">
          ${item.keluar !== '-' ? '<span class="stock-badge stock-out">' + item.keluar + '</span>' : '-'}
        </td>
        <td style="text-align: center; font-weight: 600;">${item.sisa}</td>
      `;
      tableBody.appendChild(row);
    });

    if (data.tabel_data.length > 0) {
      $('#s_awal').html(data.s_awal);
      $('#s_akhir').html(data.s_akhir);
    }
  }

  function printDiv(divName) {
    var printWindow = window.open('', '_blank');
    var printContent = document.getElementById(divName).innerHTML;

    printWindow.document.write(`
      <!DOCTYPE html>
      <html>
      <head>
        <title>Laporan Kartu Stok</title>
        <style>
          @page {
            size: A4;
            margin: 1cm;
          }
          body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 15px;
          }
          .report-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #000;
          }
          .report-title {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 15px;
          }
          .report-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
          }
          .info-badge {
            display: block;
            padding: 6px 12px;
            background: white;
            border: 1px solid #000;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            color: #000;
            margin: 5px 0;
          }
          .saldo-card {
            background: white;
            padding: 12px 16px;
            border-radius: 4px;
            margin: 15px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid #000;
          }
          .saldo-label {
            font-weight: bold;
            color: #000;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
          }
          .saldo-value {
            font-size: 18px;
            font-weight: bold;
            color: #000;
          }
          .result-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            background: #ffffff;
            border: 2px solid #000;
            margin: 15px 0;
          }
          .result-table thead {
            background: #000;
          }
          .result-table thead th {
            color: #ffffff;
            padding: 8px 4px;
            font-weight: bold;
            text-align: center;
            font-size: 10px;
            text-transform: uppercase;
            border: 1px solid #000;
          }
          .result-table tbody td {
            padding: 6px 4px;
            border: 1px solid #000;
            color: #000;
            text-align: center;
            vertical-align: middle;
          }
          .stock-badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 11px;
            display: inline-block;
            background: white;
            color: #000;
            border: 1px solid #000;
          }
        </style>
      </head>
      <body>
        ${printContent}
      </body>
      </html>
    `);

    printWindow.document.close();
    printWindow.focus();

    setTimeout(function() {
      printWindow.print();
      printWindow.close();
    }, 250);
  }
</script>