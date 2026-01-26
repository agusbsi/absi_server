<style>
    .info-box-text {
        font-size: 12px;
    }

    .info-rasio {
        background-color: #f8f9fa;
        border-left: 3px solid #17a2b8;
        padding: 10px 15px;
        margin-bottom: 15px;
        font-size: 13px;
    }

    @media print {

        .no-print,
        .info-rasio {
            display: none !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }

        .card-header {
            display: none !important;
        }
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Stok per Toko - <?= !empty($customer->nama_cust) ? $customer->nama_cust : "KOSONG" ?></h3>
                        <div class="card-tools">
                            <a href="<?= base_url('adm/Stok/s_customer') ?>" class="btn btn-tool">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="toko" value="<?= !empty($customer->nama_cust) ? $customer->nama_cust : "KOSONG" ?>">
                        <input type="hidden" id="periode" value="<?= (new DateTime('first day of -1 month'))->format('F Y') ?>">

                        <!-- Info Rasio -->
                        <div class="info-rasio no-print">
                            <strong>Perhitungan Rasio:</strong> Stok Akhir <?= (new DateTime('first day of -1 month'))->format('M Y') ?> ÷ Penjualan <?= (new DateTime('first day of -1 month'))->format('M Y') ?> |
                            <span class="text-success">0-2: Optimal</span>,
                            <span class="text-warning">2-4: Perhatian</span>,
                            <span class="text-danger">&gt;4: Berlebih</span>
                        </div>

                        <div id="printableArea">
                            <div class="text-center">
                                <h5>Laporan Stok per Customer</h5>
                                <p><b><?= !empty($customer->nama_cust) ? $customer->nama_cust  : 'DATA KOSONG' ?></b> | Periode: <?= (new DateTime('first day of -1 month'))->format('M Y') ?></p>
                            </div>
                            <hr>
                            <table class="table table-bordered table-sm" id="dataTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width:3%">#</th>
                                        <th>Nama Toko</th>
                                        <th class="text-center">Stok Saat Ini</th>
                                        <th class="text-center">Penjualan<br><small><?= (new DateTime('first day of -1 month'))->format('M Y') ?></small></th>
                                        <th class="text-center">Stok Akhir<br><small><?= (new DateTime('first day of -1 month'))->format('M Y') ?></small></th>
                                        <th class="text-center">Rasio</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    $jual = 0;
                                    $akhir = 0;
                                    if (is_array($list_data)) {
                                        $no = 0;
                                        foreach ($list_data as $dd) :
                                            $no++;
                                            // Hitung rasio - jika penjualan = 0, tidak bisa dihitung
                                            if (!empty($dd->t_jual) && $dd->t_jual > 0) {
                                                $rasio = ROUND($dd->t_akhir / $dd->t_jual, 2);
                                                $rasio_display = $rasio;
                                            } else {
                                                $rasio = 0;
                                                $rasio_display = 'N/A';
                                            }

                                            // Tentukan status berdasarkan rasio
                                            if ($rasio_display === 'N/A') {
                                                $badge_class = 'badge-secondary';
                                                $status_text = 'Tidak Ada Penjualan';
                                                $icon = 'fa-minus-circle';
                                            } elseif ($rasio <= 2) {
                                                $badge_class = 'badge-success';
                                                $status_text = 'Optimal';
                                                $icon = 'fa-check-circle';
                                            } elseif ($rasio <= 4) {
                                                $badge_class = 'badge-warning';
                                                $status_text = 'Perhatian';
                                                $icon = 'fa-exclamation-triangle';
                                            } else {
                                                $badge_class = 'badge-danger';
                                                $status_text = 'Berlebih';
                                                $icon = 'fa-times-circle';
                                            }
                                    ?>
                                            <tr>
                                                <td class="text-center"><?= $no ?></td>
                                                <td><?= $dd->nama_toko ?></td>
                                                <td class="text-center"><?= number_format($dd->t_stok) ?></td>
                                                <td class="text-center"><?= number_format($dd->t_jual) ?></td>
                                                <td class="text-center"><?= number_format($dd->t_akhir) ?></td>
                                                <td class="text-center"><strong><?= $rasio_display ?></strong></td>
                                                <td class="text-center">
                                                    <span class="badge <?= $badge_class ?>"><?= $status_text ?></span>
                                                </td>
                                            </tr>
                                        <?php
                                            $total += $dd->t_stok;
                                            $akhir += $dd->t_akhir;
                                            $jual += $dd->t_jual;
                                        endforeach;

                                        // Hitung total rasio - jika total penjualan = 0, tidak bisa dihitung
                                        if (!empty($jual) && $jual > 0) {
                                            $total_rasio = ROUND($akhir / $jual, 2);
                                            $total_rasio_display = $total_rasio;
                                        } else {
                                            $total_rasio = 0;
                                            $total_rasio_display = 'N/A';
                                        }
                                        ?>
                                        <tr class="font-weight-bold bg-light">
                                            <td colspan="2" class="text-right">TOTAL</td>
                                            <td class="text-center"><?= number_format($total) ?></td>
                                            <td class="text-center"><?= number_format($jual) ?></td>
                                            <td class="text-center"><?= number_format($akhir) ?></td>
                                            <td class="text-center"><strong><?= $total_rasio_display ?></strong></td>
                                            <td class="text-center">
                                                <?php
                                                if ($total_rasio_display === 'N/A') {
                                                    echo '<span class="badge badge-secondary">N/A</span>';
                                                } elseif ($total_rasio <= 2) {
                                                    echo '<span class="badge badge-success">Optimal</span>';
                                                } elseif ($total_rasio <= 4) {
                                                    echo '<span class="badge badge-warning">Perhatian</span>';
                                                } else {
                                                    echo '<span class="badge badge-danger">Berlebih</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Tidak ada data tersedia</td>
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
        location.reload();
    }

    function downloadExcel() {
        try {
            var wb = XLSX.utils.book_new();
            var customerName = document.getElementById('toko').value;
            var periode = document.getElementById('periode').value;

            // Prepare sheet data
            var sheetData = [];

            // Title
            sheetData.push(["LAPORAN STOK PER CUSTOMER"]);
            sheetData.push(["Customer: " + customerName]);
            sheetData.push(["Periode: " + periode]);
            sheetData.push(["Tanggal: " + new Date().toLocaleDateString('id-ID')]);
            sheetData.push([]);
            sheetData.push(["Formula: Rasio = Stok Akhir ÷ Penjualan | Optimal: 0-2, Perhatian: 2-4, Berlebih: >4"]);
            sheetData.push([]);

            // Headers
            sheetData.push(["No", "Nama Toko", "Stok Saat Ini", "Penjualan", "Stok Akhir", "Rasio", "Status"]);

            // Data from table
            var table = document.querySelector("#dataTable tbody");
            var rows = table.querySelectorAll("tr");

            rows.forEach(function(row) {
                var cells = row.querySelectorAll("td");
                if (cells.length >= 7) {
                    var rowData = [];
                    var firstCellText = cells[0].textContent.trim();

                    // Check if this is data row or total row
                    if (firstCellText === '' || cells[1].textContent.trim() === 'TOTAL') {
                        // This is the TOTAL row
                        rowData.push('');
                        rowData.push('TOTAL');
                        rowData.push(parseFloat(cells[2].textContent.trim().replace(/,/g, '')) || 0);
                        rowData.push(parseFloat(cells[3].textContent.trim().replace(/,/g, '')) || 0);
                        rowData.push(parseFloat(cells[4].textContent.trim().replace(/,/g, '')) || 0);
                        // Rasio - handle N/A
                        var rasioText = cells[5].textContent.trim();
                        rowData.push(rasioText === 'N/A' ? 'N/A' : (parseFloat(rasioText) || 0));
                        rowData.push(cells[6].textContent.trim());
                    } else {
                        // Regular data row
                        rowData.push(firstCellText);
                        rowData.push(cells[1].textContent.trim());
                        rowData.push(parseFloat(cells[2].textContent.trim().replace(/,/g, '')) || 0);
                        rowData.push(parseFloat(cells[3].textContent.trim().replace(/,/g, '')) || 0);
                        rowData.push(parseFloat(cells[4].textContent.trim().replace(/,/g, '')) || 0);
                        // Rasio - handle N/A
                        var rasioText = cells[5].textContent.trim();
                        rowData.push(rasioText === 'N/A' ? 'N/A' : (parseFloat(rasioText) || 0));
                        rowData.push(cells[6].textContent.trim());
                    }

                    sheetData.push(rowData);
                }
            });

            // Create worksheet
            var ws = XLSX.utils.aoa_to_sheet(sheetData);

            // Set column widths
            ws['!cols'] = [{
                    wch: 5
                }, // No
                {
                    wch: 30
                }, // Nama Toko
                {
                    wch: 15
                }, // Stok
                {
                    wch: 15
                }, // Penjualan
                {
                    wch: 15
                }, // Stok Akhir
                {
                    wch: 10
                }, // Rasio
                {
                    wch: 12
                } // Status
            ];

            // Add worksheet to workbook
            XLSX.utils.book_append_sheet(wb, ws, 'Stok Per Toko');

            // Generate filename
            var filename = 'Stok_' + customerName.replace(/\s+/g, '_') + '_' + new Date().getTime() + '.xlsx';

            // Download
            XLSX.writeFile(wb, filename);
        } catch (error) {
            alert('Error saat mengunduh Excel: ' + error.message);
            console.error('Excel Error:', error);
        }
    }
</script>