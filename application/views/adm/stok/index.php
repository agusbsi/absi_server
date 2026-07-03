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
    .stock-page { --sp-primary:#2563eb; --sp-dark:#172554; --sp-muted:#64748b; --sp-border:#e2e8f0; }
    .stock-hero { position:relative; overflow:hidden; padding:28px; margin-bottom:20px; color:#fff; border-radius:18px; background:linear-gradient(125deg,#172554 0%,#1d4ed8 58%,#0ea5e9 100%); box-shadow:0 14px 35px rgba(30,64,175,.18); }
    .stock-hero:after { content:''; position:absolute; width:220px; height:220px; right:-65px; top:-95px; border:35px solid rgba(255,255,255,.08); border-radius:50%; }
    .stock-hero-content { position:relative; z-index:1; }
    .stock-hero-icon { width:52px; height:52px; display:flex; align-items:center; justify-content:center; flex:0 0 52px; margin-right:16px; border-radius:14px; background:rgba(255,255,255,.14); font-size:1.35rem; }
    .stock-hero h1 { margin:0 0 7px; font-size:1.55rem; font-weight:700; }
    .stock-hero p { margin:0; color:rgba(255,255,255,.82); }
    .active-data-note { display:flex; align-items:flex-start; padding:13px 15px; margin-top:20px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.18); border-radius:12px; font-size:.84rem; }
    .active-data-note i { margin:3px 10px 0 0; color:#86efac; }
    .stock-page .cari.card, .stock-page .hasil.card { border:0; border-radius:16px; box-shadow:0 8px 28px rgba(15,23,42,.07); overflow:hidden; }
    .stock-page .cari.card > .card-header { display:none; }
    .stock-page .cari.card > .card-body { padding:24px; }
    .stock-page .cari .alert { padding:0 0 18px !important; margin-bottom:22px !important; color:#475569 !important; background:transparent !important; border-bottom:1px solid var(--sp-border) !important; border-radius:0 !important; box-shadow:none !important; }
    .stock-page .cari .alert h6 { display:none; }
    .stock-page .cari .alert .fa-info-circle { color:#2563eb !important; font-size:1.35rem; }
    .stock-page label { color:#334155; font-size:.75rem; font-weight:700; letter-spacing:.04em; text-transform:uppercase; }
    .stock-page .form-control, .stock-page .select2-container .select2-selection--single { min-height:42px; border-color:var(--sp-border); border-radius:9px; }
    .stock-page .btn-cari { min-height:42px; width:100%; padding:8px 16px; border:0; border-radius:9px; background:var(--sp-primary); box-shadow:0 6px 15px rgba(37,99,235,.22); font-weight:600; }
    .result-heading { padding:20px 22px; border-bottom:1px solid var(--sp-border); }
    .active-badge { display:inline-flex; align-items:center; padding:6px 10px; color:#166534; background:#dcfce7; border-radius:999px; font-size:.72rem; font-weight:700; }
    .active-badge:before { content:''; width:7px; height:7px; margin-right:7px; background:#22c55e; border-radius:50%; }
    .summary-card { height:100%; padding:16px 17px; background:#fff; border:1px solid var(--sp-border); border-radius:13px; }
    .summary-icon { width:38px; height:38px; display:flex; align-items:center; justify-content:center; margin-right:12px; color:var(--sp-primary); background:#eff6ff; border-radius:10px; }
    .summary-label { color:var(--sp-muted); font-size:.7rem; text-transform:uppercase; letter-spacing:.05em; }
    .summary-value { color:#0f172a; font-size:1.12rem; font-weight:700; }
    .stock-page .hasil .card-body { padding:0; }
    .stock-page #printableArea > .text-center, .stock-page #printableArea > hr { display:none; }
    .stock-page #artikel { margin:0; padding:16px 22px; text-align:left !important; border-bottom:1px solid var(--sp-border); }
    .stock-page .hasil table { margin:0; }
    .stock-page .hasil thead th { padding:13px 12px; border:0; background:#f8fafc; color:#475569; font-size:.72rem; letter-spacing:.04em; text-transform:uppercase; white-space:nowrap; }
    .stock-page .hasil tbody td { padding:13px 12px; border-color:#eef2f7; vertical-align:middle; }
    .stock-page .hasil tbody tr:hover { background:#f8fbff; }
    .stock-page .hasil tfoot td { padding:14px 12px; background:#f1f5f9 !important; border:0; }
    .stock-page .hasil .card-footer { padding:14px 18px; background:#fff; border-top:1px solid var(--sp-border); }
    .stock-page .no-data { max-width:520px; margin:25px auto; text-align:center; }
    .stock-page .no-data img { max-width:350px; }
    @media(max-width:767.98px){ .stock-hero{padding:22px 18px;border-radius:14px}.stock-hero h1{font-size:1.3rem}.stock-page .cari.card>.card-body{padding:18px}.summary-card{height:auto;margin-bottom:10px}.stock-page .hasil .card-body{overflow-x:auto} }
</style>
<section class="content stock-page">
    <div class="container-fluid">
        <div class="stock-hero cari">
            <div class="stock-hero-content">
                <div class="d-flex align-items-center">
                    <div class="stock-hero-icon"><i class="fas fa-boxes"></i></div>
                    <div><h1>Laporan Stok per Artikel</h1><p>Pantau posisi stok terakhir setiap artikel dari seluruh jaringan toko dalam satu tampilan.</p></div>
                </div>
              
            </div>
        </div>
        <div class="card card-info card-outline cari">
            <div class="card-header">
                <h3 class="card-title">
                    <li class="fas fa-cubes"></li> Laporan stok Artikel
                </h3>
            </div>
            <div class="card-body">
                <!-- Modern Info Banner -->
                <div class="alert alert-info border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px;">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-info-circle fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 font-weight-bold">📊 Informasi Laporan Stok</h6>
                            <p class="mb-0 small opacity-90">
                                Data stok artikel ini hanya menampilkan dari <strong>toko yang masih aktif beroperasi</strong>.
                                Stok dari toko yang sudah tutup tidak dimasukkan dalam perhitungan untuk memastikan akurasi data real-time.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_artikel">Artikel</label>
                            <select name="id_artikel" class="form-control form-control-sm select2" id="id_artikel" required>
                                <option value="">- Pilih Artikel -</option>
                                <option value="all"> Semua Artikel </option>
                                <?php foreach ($artikel as $t) : ?>
                                    <option value="<?= $t->id ?>"><?= $t->kode ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cakupan_toko">Cakupan Toko</label>
                            <input type="text" id="cakupan_toko" class="form-control" value="Semua Toko Aktif" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal">Posisi Stok per Tanggal</label>
                            <div class="input-group">
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required min="2024-12-31" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1 pt-3">
                        <button class="btn btn-primary btn-cari mt-3" id="searchBtn">
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
                        <div class="percentage" id="percentage"><i class="fas fa-database"></i></div>
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
            <p class="text-muted">Pilih artikel dan tanggal untuk melihat posisi stok.</p>
        </div>
        <div class="card hasil d-none">
            <div class="result-heading">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div><h5 class="mb-1 font-weight-bold">Hasil Laporan Stok</h5><div class="text-muted small">Ringkasan posisi stok berdasarkan filter yang dipilih</div></div>
                    <span class="active-badge mt-2 mt-md-0">Artikel &amp; toko aktif</span>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4"><div class="summary-card d-flex align-items-center"><div class="summary-icon"><i class="fas fa-box"></i></div><div><div class="summary-label">Jumlah artikel</div><div class="summary-value" id="totalArtikel">0</div></div></div></div>
                    <div class="col-md-4"><div class="summary-card d-flex align-items-center"><div class="summary-icon"><i class="fas fa-layer-group"></i></div><div><div class="summary-label">Total stok</div><div class="summary-value" id="summaryTotalStok">0</div></div></div></div>
                    <div class="col-md-4"><div class="summary-card d-flex align-items-center"><div class="summary-icon"><i class="far fa-calendar-check"></i></div><div><div class="summary-label">Posisi tanggal</div><div class="summary-value" id="summaryTanggal">-</div></div></div></div>
                </div>
            </div>
            <div class="card-body">
                <div id="printableArea">
                    <div class="text-center"> <strong>- Laporan stok Artikel -</strong></div>
                    <hr>
                    <p class="text-center" id="artikel"></p>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Kode</th>
                                <th>Deskripsi</th>
                                <th>Stok</th>
                                <th>Tanggal</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tbody id="dataTableBody">
                        </tbody>
                        <tfoot>
                            <tr class="bg-light font-weight-bold">
                                <td colspan="3" class="text-right">Grand Total</td>
                                <td class="text-center" id="grandTotalStok">0</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a type="button" onclick="printDiv('printableArea')" target="_blank" class="btn btn-default btn-sm float-right mr-3 ml-2">
                    <i class="fas fa-print"></i> Cetak </a>
                <button class="btn btn-success btn-sm float-right" id="downloadExcelBtn"><i class="fas fa-file-excel"></i> Unduh Excel</button>
                <a href="<?= base_url('adm/Stok') ?>" class="btn btn-light btn-sm float-right mr-1"><i class="fas fa-redo"></i> Filter Ulang</a>
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
        var header = ["No", "Kode", "Deskripsi", "Stok", "Tanggal"];
        var sheetData = [];
        var artikel = document.getElementById('artikel').innerHTML;
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
        var filename = 'Laporan_stok_' + artikel + '.xlsx';
        XLSX.writeFile(wb, filename);
    }

    document.getElementById('searchBtn').addEventListener('click', async function() {
        var idartikel = document.getElementById('id_artikel').value;
        var tanggal = document.getElementById('tanggal').value;
        const url = '<?= base_url('adm/Stok') ?>';
        if (validateForm()) {
            const loading = document.getElementById('loading');
            const progressStage = document.getElementById('progressStage');
            const loadingSubtext = document.getElementById('loadingSubtext');

            loading.style.display = 'flex';
            progressStage.textContent = 'Mengambil data stok...';
            loadingSubtext.textContent = 'Server sedang menghitung stok terakhir dari seluruh toko aktif';

            try {
                const response = await fetch(`${url}/cari_stokartikel?id_artikel=${idartikel}&tanggal=${tanggal}`);
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                progressStage.textContent = 'Menampilkan hasil...';
                const data = await response.json();

                if (data.tabel_data && data.tabel_data.length > 0) {
                    updateUI(data);
                } else {
                    Swal.fire('TIDAK ADA DATA', 'Data tidak ditemukan, silahkan cari kembali', 'info');
                }
            } catch (error) {
                console.error('Error fetching data:', error);
                Swal.fire('GAGAL MEMUAT DATA', 'Terjadi kesalahan saat mengambil data stok.', 'error');
            } finally {
                loading.style.display = 'none';
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
        $('#artikel').html(data.artikel);
        $('.cari').addClass('d-none');
        $('.no-data').addClass('d-none');
        $('.hasil').removeClass('d-none');
        // Update the table
        var tableBody = document.getElementById('dataTableBody');
        var tanggal = document.getElementById('tanggal').value;
        var totalstok = 0;
        tableBody.innerHTML = '';
        data.tabel_data.forEach((item, index) => {
            var row = document.createElement('tr');
            row.innerHTML = `
            <td class="text-center"><small>${index + 1}</small></td>
            <td><small>${item.kode}</small></td>
            <td><small>${item.deskripsi}</small></td>
            <td class="text-center"> ${item.stok}</td>
            <td class="text-center">${data.tanggal}</td>
            <td class="text-center">
               <a class="btn btn-sm btn-primary" href="<?= base_url() ?>adm/Stok/detail/${item.id}/${tanggal}">Detail</a>
            </td>`;
            tableBody.appendChild(row);
            var qty = Number(item.stok);
            if (!isNaN(qty)) {
                totalstok += qty;
            }
        });
        var totalFormatted = totalstok.toLocaleString('id-ID');
        document.getElementById('grandTotalStok').textContent = totalFormatted;
        document.getElementById('summaryTotalStok').textContent = totalFormatted;
        document.getElementById('totalArtikel').textContent = data.tabel_data.length.toLocaleString('id-ID');
        document.getElementById('summaryTanggal').textContent = data.tanggal;
    }

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
