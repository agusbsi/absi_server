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
    }
</style>
<div id="loading" style="display: flex;">
    <div class="loader">
        <div class="loader-icon">
            <div class="circle"></div>
            <div class="progress-circle">
                <div class="percentage" id="percentage">0%</div>
            </div>
        </div>
        <div class="loading-text">
            <span id="loadingText">Memuat Data Artikel</span><span class="loading-dots"><span>.</span><span>.</span><span>.</span></span>
        </div>
        <div class="loading-subtext" id="loadingSubtext">
            Mohon tunggu, sedang memproses data...
        </div>
        <div class="progress-info">
            <div class="progress-stage" id="progressStage">Mengambil data dari server...</div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Artikel</span>
                                <span class="info-box-number">
                                    <?= isset($summary->total_artikel) ? number_format($summary->total_artikel) : '0' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cubes"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Stok</span>
                                <span class="info-box-number"><?= isset($summary->total_stok) ? number_format($summary->total_stok) : '0' ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-chart-line"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Penjualan (<?= $periode ?>)</span>
                                <span class="info-box-number"><?= isset($summary->total_jual) ? number_format($summary->total_jual) : '0' ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-box-open"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Stok Akhir</span>
                                <span class="info-box-number"><?= isset($summary->total_stok_akhir) ? number_format($summary->total_stok_akhir) : '0' ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> <i class="fas fa-boxes"></i> Detail Artikel per Customer</h3>
                        <div class="card-tools">
                            <a href="<?= base_url('adm/Stok/s_customer') ?>" type="button" class="btn btn-tool remove">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <input type="hidden" id="customer_name" value="<?= isset($customer->nama_cust) ? $customer->nama_cust : "KOSONG" ?>">
                        <div id="printableArea">
                            <div class="text-center">
                                <h5>Laporan Stok Artikel per Customer</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 text-left">
                                        <strong>Customer:</strong> <?= isset($customer->nama_cust) ? $customer->nama_cust : 'DATA KOSONG' ?><br>
                                        <strong>Alamat:</strong> <?= isset($customer->alamat_cust) ? $customer->alamat_cust : '-' ?>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong>Periode Penjualan:</strong> <?= $periode ?><br>
                                        <strong>Tanggal Cetak:</strong> <?= date('d M Y') ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <table class="table table-bordered table-striped table-sm">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width:3%" class="text-center">#</th>
                                        <th>Artikel</th>
                                        <th class="text-center">Stok Saat Ini</th>
                                        <th class="text-center">Stok Akhir</th>
                                        <th class="text-center">Penjualan</th>
                                        <th class="text-center">Rasio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (is_array($list_data) && count($list_data) > 0) {
                                        $no = 0;
                                        foreach ($list_data as $dd) :
                                            $no++;
                                    ?>
                                            <tr>
                                                <td class="text-center"><?= $no ?></td>
                                                <td>
                                                    <strong><?= $dd->kode ?></strong><br>
                                                    <small><?= $dd->artikel ?></small><br>
                                                    <span class="badge badge-secondary"><?= $dd->satuan ?></span>
                                                </td>
                                                <td class="text-right"><?= number_format($dd->t_stok) ?></td>
                                                <td class="text-right"><?= number_format($dd->t_akhir) ?></td>
                                                <td class="text-right"><?= number_format($dd->t_jual) ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    $rasio = $dd->t_jual > 0 ? round($dd->t_akhir / $dd->t_jual, 2) : 0;
                                                    $badge_class = $rasio > 3 ? 'badge-danger' : ($rasio > 1 ? 'badge-warning' : 'badge-success');
                                                    ?>
                                                    <span class="badge <?= $badge_class ?>"><?= number_format($rasio, 2) ?></span>
                                                </td>
                                            </tr>
                                        <?php
                                        endforeach;
                                        ?>
                                        <tr class="bg-light font-weight-bold">
                                            <td colspan="2" class="text-right">Total Keseluruhan</td>
                                            <td class="text-right"><?= number_format($summary->total_stok) ?></td>
                                            <td class="text-right"><?= number_format($summary->total_stok_akhir) ?></td>
                                            <td class="text-right"><?= number_format($summary->total_jual) ?></td>
                                            <td class="text-center">-</td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data artikel</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="no-print">
                            <a type="button" onclick="printDiv('printableArea')" target="_blank" class="btn btn-default float-right btn-sm" style="margin-right: 5px;">
                                <i class="fas fa-print"></i> Print
                            </a>
                            <button class="btn btn-warning btn-sm float-right mr-1" onclick="downloadExcel()"><i class="fas fa-file-excel"></i> Unduh</button>
                            <a href="<?= base_url('adm/Stok/s_customer') ?>" class="btn btn-danger btn-sm float-right mr-1 "> <i class="fa fa-times-circle"></i> Close</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    function downloadExcel() {
        var wb = XLSX.utils.book_new();
        var sheetData = [];
        var header = ["#", "Kode Artikel", "Nama Artikel", "Satuan", "Stok Saat Ini", "Stok Akhir", "Penjualan", "Rasio"];
        sheetData.push(header);

        // Select the table body
        var table = document.querySelector("#printableArea table tbody");

        // Loop through table rows and collect data
        var rows = table.getElementsByTagName("tr");
        for (var i = 0; i < rows.length - 1; i++) { // -1 to exclude total row
            var row = [];
            var cells = rows[i].getElementsByTagName("td");
            // First cell is number
            row.push(cells[0].textContent.trim());
            // Second cell contains kode, artikel, and satuan - need to parse
            var artikelCell = cells[1];
            var kode = artikelCell.querySelector('strong') ? artikelCell.querySelector('strong').textContent.trim() : '';
            var small = artikelCell.querySelector('small') ? artikelCell.querySelector('small').textContent.trim() : '';
            var satuan = artikelCell.querySelector('.badge') ? artikelCell.querySelector('.badge').textContent.trim() : '';
            row.push(kode);
            row.push(small);
            row.push(satuan);
            // Remaining cells are numeric
            for (var j = 2; j < cells.length; j++) {
                var cellValue = cells[j].textContent.trim();
                var numericValue = parseFloat(cellValue.replace(/[^0-9.-]+/g, ''));
                row.push(isNaN(numericValue) ? cellValue : numericValue);
            }
            sheetData.push(row);
        }

        // Add total row
        var totalRow = ["", "", "", "TOTAL",
            <?= isset($summary->total_stok) ? $summary->total_stok : 0 ?>,
            <?= isset($summary->total_stok_akhir) ? $summary->total_stok_akhir : 0 ?>,
            <?= isset($summary->total_jual) ? $summary->total_jual : 0 ?>,
            "-"
        ];
        sheetData.push(totalRow);

        // Create worksheet from the data
        var ws = XLSX.utils.aoa_to_sheet(sheetData);

        // Get the customer name
        var customerName = document.getElementById('customer_name').value;

        // Append the worksheet to the workbook
        XLSX.utils.book_append_sheet(wb, ws, 'Artikel per Customer');

        // Define the filename
        var filename = 'Detail_Artikel_' + customerName + '_' + '<?= date('dMY') ?>' + '.xlsx';
        XLSX.writeFile(wb, filename);
    }

    // Loading animation
    document.addEventListener('DOMContentLoaded', function() {
        let progress = 0;
        const loadingEl = document.getElementById('loading');
        const percentageEl = document.getElementById('percentage');
        const progressStageEl = document.getElementById('progressStage');
        const progressCircle = document.querySelector('.progress-circle');

        const stages = [
            'Mengambil data dari server...',
            'Memproses data artikel...',
            'Menghitung stok dan penjualan...',
            'Menghitung rasio...',
            'Menyelesaikan...'
        ];

        let currentStage = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 90) progress = 90;

            percentageEl.textContent = Math.round(progress) + '%';
            progressCircle.style.background = `conic-gradient(#17a2b8 ${progress * 3.6}deg, transparent 0deg)`;

            if (progress > (currentStage + 1) * 18 && currentStage < stages.length - 1) {
                currentStage++;
                progressStageEl.textContent = stages[currentStage];
            }
        }, 100);

        window.addEventListener('load', function() {
            setTimeout(() => {
                clearInterval(interval);
                progress = 100;
                percentageEl.textContent = '100%';
                progressCircle.style.background = `conic-gradient(#28a745 360deg, transparent 0deg)`;
                progressStageEl.textContent = 'Selesai!';

                setTimeout(() => {
                    loadingEl.style.display = 'none';
                }, 300);
            }, 500);
        });
    });
</script>