<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> <i class="fas fa-chartpie"></i> Detail Per Customer</h3>
                        <div class="card-tools">
                            <a href="<?= base_url('spv/Stok/s_customer') ?>" type="button" class="btn btn-tool remove">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="toko" value="<?= !empty($data->nama_cust) ? $data->nama_cust : "KOSONG" ?>">
                        <div id="printableArea">
                            <div class="text-center">
                                - Laporan Stok per Customer -
                                <hr>
                                <b><?= !empty($data->nama_cust) ? $data->nama_cust  : 'DATA KOSONG' ?> </b>
                            </div>
                            <hr>
                            <p class="float-right mr-3">Tanggal Cetak : <?= date('d-M-Y') ?></p>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="width:3%">#</th>
                                        <th rowspan="2" class="text-center">Nama Toko</th>
                                        <th colspan="3" class="text-center">Total</th>
                                        <th rowspan="2" class="text-center">Stok Rasio </th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">
                                            Penjualan <br>
                                            <small> ( <?= (new DateTime('first day of -2 month'))->format('M-Y') ?> )</small>
                                        </th>
                                        <th class="text-center">
                                            Stok Akhir <br>
                                            <small> ( <?= (new DateTime('first day of -1 month'))->format('M-Y') ?> )</small>
                                        </th>
                                        <th class="text-center">Stok</th>
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
                                    ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><small><?= $dd->nama_toko ?></small></td>
                                                <td class="text-center"><?= number_format($dd->t_jual) ?></td>
                                                <td class="text-center"><?= number_format($dd->t_akhir) ?></td>
                                                <td class="text-center"><?= number_format($dd->t_stok) ?></td>
                                                <td class="text-center"> <?= (!empty($dd->t_jual) && $dd->t_jual != 0) ? ROUND($dd->t_akhir / $dd->t_jual, 2) : ROUND($dd->t_akhir / 1, 2) ?></td>
                                            </tr>
                                        <?php
                                            $total += $dd->t_stok;
                                            $akhir += $dd->t_akhir;
                                            $jual += $dd->t_jual;
                                        endforeach;
                                        ?>
                                        <tr>
                                            <td colspan="2" class="text-right">Total :</td>
                                            <td class="text-center"><b><?= number_format($jual) ?></b></td>
                                            <td class="text-center"><b><?= number_format($akhir) ?></b></td>
                                            <td class="text-center"><b><?= number_format($total) ?></b></td>
                                            <td class="text-center"><b><?= (!empty($akhir) && $jual != 0) ? ROUND($akhir / $jual, 2) : ROUND($akhir / 1, 2) ?></b></td>
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
                            <a href="<?= base_url('spv/Stok/s_customer') ?>" class="btn btn-danger btn-sm float-right mr-1 "> <i class="fa fa-times-circle"></i> Close</a>

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
        var header = ["#", "Nama Toko", "Penjualan", "Stok Akhir", "Stok", "Rasio"];
        sheetData.push(header);

        // Select the table body
        var table = document.querySelector("#printableArea table tbody");

        // Loop through table rows and collect data
        var rows = table.getElementsByTagName("tr");
        for (var i = 0; i < rows.length; i++) {
            var row = [];
            var cells = rows[i].getElementsByTagName("td");
            for (var j = 0; j < cells.length; j++) {
                var cellValue = table.rows[i].cells[j].textContent.trim();
                if (header[j] === "Stok" || header[j] === "Penjualan" || header[j] === "Stok Akhir") {
                    var numericValue = parseFloat(cellValue.replace(/[^0-9.-]+/g, ''));
                    row.push(isNaN(numericValue) ? cellValue : numericValue);
                } else {
                    row.push(cellValue);
                }
            }
            sheetData.push(row);
        }

        // Create worksheet from the data
        var ws = XLSX.utils.aoa_to_sheet(sheetData);

        // Get the title from the #produk element
        var judul = document.getElementById('toko').value;

        // Append the worksheet to the workbook with the title as sheet name
        XLSX.utils.book_append_sheet(wb, ws, 'stok per toko');

        // Define the filename
        var filename = judul + '.xlsx';
        XLSX.writeFile(wb, filename);
    }
</script>