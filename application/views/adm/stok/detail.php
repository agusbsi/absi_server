<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> <i class="fas fa-chartpie"></i> Detail stok Artikel per Toko</h3>
                        <div class="card-tools">
                            <a href="<?= base_url('adm/Stok') ?>" type="button" class="btn btn-tool remove">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <input type="hidden" id="produk" value="<?= !empty($data->nama_produk) ? $data->kode : "KOSONG" ?>">
                        <div id="printableArea">
                            <div class="text-center">
                                - Laporan stok Artikel per Toko -
                                <hr>
                                <b><?= !empty($data->nama_produk) ? $data->kode . ' </b> <br>  ' . $data->nama_produk  : 'DATA STOK KOSONG' ?>
                            </div>
                            <hr>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:3%">#</th>
                                        <th class="text-center">Nama Toko</th>
                                        <th class="text-center">Total Stok</th>
                                        <th class="text-center">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    if (is_array($list_data)) {
                                        $no = 0;
                                        foreach ($list_data as $dd) :
                                            $no++;
                                    ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $dd->nama_toko ?></td>
                                                <td class="text-center"><?= $dd->stok_akhir ?></td>
                                                <td class="text-center"><?= $tanggal ?></td>
                                            </tr>
                                        <?php
                                            $total += $dd->stok_akhir; // Perbaiki penggunaan variabel
                                        endforeach;
                                        ?>
                                        <tr>
                                            <td colspan="2" class="text-right">Total</td>
                                            <td class="text-center"><b><?= $total ?></b></td>
                                            <td></td>
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
                            <a href="<?= base_url('adm/Stok') ?>" class="btn btn-danger btn-sm float-right mr-1 "> <i class="fa fa-times-circle"></i> Close</a>

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
        var header = ["#", "Nama Toko", "Total Stok"];
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
                if (header[j] === "Total Stok") {
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
        var judul = document.getElementById('produk').value;

        // Append the worksheet to the workbook with the title as sheet name
        XLSX.utils.book_append_sheet(wb, ws, 'stok per toko');

        // Define the filename
        var filename = judul + '.xlsx';
        XLSX.writeFile(wb, filename);
    }
</script>