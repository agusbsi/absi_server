<section class="content">
    <div class="container-fluid">
        <div class="card-container">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <li class="fas fa-warehouse"></li> Data Stok Gudang Prepedan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-box"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Item</span>
                                    <span class="info-box-number"><?= ($t_item->total_item == 0) ? "Kosong" : number_format($t_item->total_item) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-cubes"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Stok (Gudang Prepedan)</span>
                                    <span class="info-box-number"><?= ($t_item->total_stok == 0) ? '<small class="text-danger">Kosong</small>' : number_format($t_item->total_stok) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="far fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Terakhir Diperbarui</span>
                                    <span class="info-box-number"><?= ($waktu) ? date('d M Y H:i:s', strtotime($waktu->updated_at)) : '<small class="text-danger">Belum ada pembaruan</small>' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="tabel-scroll">
                        <table id="tabel_baru" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Artikel</th>
                                    <th>Satuan</th>
                                    <th class="text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <small>
                        <strong>Keterangan :</strong>
                        <li>Data stok gudang ini diambil dari data Easy Accounting.</li>
                        <li>Data di perbarui setiap hari pukul 08.00 - 09.00 WIB.</li>
                        <li>Data di import oleh tim Accounting.</li>
                    </small>
                </div>
                <div class="card-footer text-right">
                    <a href="<?= base_url('adm/Stok/unduhExcel') ?>" class="btn btn-warning btn-sm"><i class="fas fa-download"></i> Unduh Template Excel </a>
                    <?php if ($this->session->userdata('role') == 15) { ?>
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#importModel"><i class="fas fa-upload"></i> Import Stok</button>
                    <?php } ?>
                </div>
            </div>
        </div>
</section>

<style>
    .upload-loading,
    .save-loading {
        color: #fff;
    }

    .progress-bar {
        transition: width 0.3s ease;
    }

    #processStatus {
        border-left: 4px solid #17a2b8;
    }

    #largeDataWarning {
        border-left: 4px solid #ffc107;
    }

    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }

    .alert {
        margin-bottom: 15px;
    }

    .progress {
        height: 25px;
    }

    .progress-bar {
        line-height: 25px;
        font-size: 12px;
    }

    .info-box {
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        border-radius: .25rem;
        background: #fff;
        display: flex;
        margin-bottom: 1rem;
        min-height: 80px;
        padding: .5rem;
        position: relative;
        width: 100%;
    }

    .info-box .info-box-icon {
        border-radius: .25rem;
        align-items: center;
        display: flex;
        font-size: 1.875rem;
        justify-content: center;
        text-align: center;
        width: 70px;
        color: rgba(255, 255, 255, .8);
    }

    .info-box .info-box-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        line-height: 1.8;
        margin-left: .5rem;
        padding: 0 .5rem;
    }

    .info-box .info-box-text {
        display: block;
        font-size: .875rem;
        font-weight: 600;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .info-box .info-box-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .thead-dark th {
        background-color: #343a40;
        color: #fff;
    }

    .modal-xl {
        max-width: 1200px;
    }

    #emptyDataRow td {
        padding: 3rem 1rem;
        font-size: 1.1rem;
    }

    .card-outline.card-info {
        border-top: 3px solid #17a2b8;
    }
</style>
<div class="modal" id="importModel" role="dialog" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white">Import Data Excel
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> <strong>Petunjuk Import Data Excel:</strong></h6>
                    <ul class="mb-0">
                        <li>Pastikan file Excel berasal dari <strong>ABSI</strong> & Data khusus untuk PT. <?= $this->session->userdata('pt') ? $this->session->userdata('pt') : '' ?></li>
                        <li>Format file harus sesuai template: <strong>Kolom B (Kode), C (Nama Artikel), E (Stok)</strong></li>
                        <li>Data mulai dari <strong>baris ke-2</strong> sesuai format ABSI</li>
                        <li>Maksimal <strong>10,000 baris</strong> dan ukuran file <strong>50MB</strong></li>
                        <li>Periksa data preview sebelum menyimpan untuk memastikan keakuratan</li>
                    </ul>
                </div>

                <form method="post" id="uploadForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <label><strong>Pilih File Excel :</strong></label>
                            <small class="text-muted d-block">Format: .xlsx atau .xls</small>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="file" class="form-control form-control-sm" id="excelFile" name="excel_file" accept=".xlsx,.xls" required>
                                <small class="text-muted">Maks: 50MB</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success btn-sm" id="uploadBtn">
                                <span class="upload-text"><i class="fas fa-upload"></i> Upload File</span>
                                <span class="upload-loading d-none">
                                    <i class="fas fa-spinner fa-spin"></i> Uploading...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row mb-2" id="summaryInfo" style="display: none;">
                    <div class="col-md-12">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h6 class="card-title"><i class="fas fa-chart-bar"></i> Ringkasan Data Import</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="info-box bg-info">
                                            <span class="info-box-icon"><i class="fas fa-file-excel"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Data</span>
                                                <span class="info-box-number total-data-uploaded">0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box bg-success">
                                            <span class="info-box-icon"><i class="fas fa-check"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Terverifikasi</span>
                                                <span class="info-box-number total-data-verified">0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box bg-danger">
                                            <span class="info-box-icon"><i class="fas fa-times"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Tidak Ditemukan</span>
                                                <span class="info-box-number total-data-not-found">0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box bg-warning">
                                            <span class="info-box-icon"><i class="fas fa-percentage"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Akurasi</span>
                                                <span class="info-box-number" id="accuracy-percentage">0%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="dataValidationAlert" class="alert d-none">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Periksa Data Sebelum Menyimpan!</strong>
                    <span id="validationMessage"></span>
                </div>
                <div id="processStatus" class="alert alert-info d-none">
                    <i class="fas fa-info-circle"></i> <span id="processStatusText">Sedang memproses file Excel...</span>
                </div>
                <div id="progressContainer" class="d-none mb-3">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                            style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            <span class="sr-only">0% Complete</span>
                        </div>
                    </div>
                    <small class="text-muted" id="progressText">Memproses data...</small>
                </div>
                <div id="largeDataWarning" class="alert alert-warning d-none">
                    <i class="fas fa-exclamation-triangle"></i> <strong>Peringatan:</strong>
                    File berisi data dalam jumlah besar. Proses mungkin memakan waktu lebih lama.
                </div>
                <form method="post" id="saveForm" enctype="multipart/form-data">
                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="table table-striped table-sm">
                            <thead class="thead-dark" style="position: sticky; top: 0; z-index: 10;">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Kode Artikel</th>
                                    <th width="40%">Nama Artikel</th>
                                    <th width="15%">Stok</th>
                                    <th width="25%">Status Validasi</th>
                                </tr>
                            </thead>
                            <tbody id="excelPreview">
                                <tr id="emptyDataRow">
                                    <td colspan="5" class="text-center text-muted">
                                        <i class="fas fa-upload"></i><br>
                                        Silakan upload file Excel untuk melihat preview data
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>

                <button type="button" class="btn btn-warning btn-sm" id="resetData" style="display: none;">
                    <i class="fas fa-undo"></i> Reset Data
                </button>

                <button type="button" class="btn btn-primary btn-sm" id="saveData" style="display: none;">
                    <span class="save-text">
                        <i class="fas fa-save"></i> Simpan Data
                    </span>
                    <span class="save-loading d-none">
                        <i class="fas fa-spinner fa-spin"></i> Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tabel_baru').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= base_url('adm/Stok/get_stokGudang') ?>",
                "type": "POST"
            },
            "columns": [{
                    "data": "no"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<small><strong>' + row.kode + '</strong></small>';
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<small>' + row.nama_produk + '</small>';
                    }
                },
                {
                    "data": "satuan"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        var stok = parseFloat(row.stok) || 0;
                        var formattedStock = stok.toLocaleString('en-US');
                        return '<div class="text-center"><small>' + formattedStock + '</small></div>';
                    }
                }
            ],
            "order": []
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            // Validate file selection
            var fileInput = $('#excelFile')[0];
            if (!fileInput.files.length) {
                Swal.fire('Error', 'Silakan pilih file Excel terlebih dahulu', 'error');
                return;
            }

            // Validate file size (max 10MB)
            var file = fileInput.files[0];
            var maxSize = 10 * 1024 * 1024; // 10MB in bytes
            if (file.size > maxSize) {
                Swal.fire('Error', 'Ukuran file terlalu besar. Maksimal 10MB', 'error');
                return;
            }

            // Show warning for large files
            if (file.size > 5 * 1024 * 1024) { // 5MB
                $('#largeDataWarning').removeClass('d-none');
                $('#processStatusText').text('Memproses file besar, harap tunggu...');
                $('#progressText').text('Memproses data dalam batch untuk mencegah timeout...');
            }

            // Show loading state
            $('#uploadBtn').prop('disabled', true);
            $('.upload-text').addClass('d-none');
            $('.upload-loading').removeClass('d-none');
            $('#processStatus').removeClass('d-none');
            $('#progressContainer').removeClass('d-none');

            // Animate progress bar with more realistic timing for large files
            var progress = 0;
            var progressStep = file.size > 5 * 1024 * 1024 ? 5 : 15; // Slower for large files
            var progressInterval = setInterval(function() {
                progress += Math.random() * progressStep;
                if (progress > 90) progress = 90;
                $('.progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
            }, 300);

            var formData = new FormData(this);
            $.ajax({
                url: '<?= base_url('adm/Stok/process_import'); ?>',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 600000, // Increased to 10 minutes for large files
                success: function(response) {
                    clearInterval(progressInterval);
                    $('.progress-bar').css('width', '100%').attr('aria-valuenow', 100);

                    setTimeout(function() {
                        try {
                            var result = JSON.parse(response);
                            if (result.error) {
                                Swal.fire('Error', result.error, 'error');
                            } else {
                                // Hide empty data row
                                $('#emptyDataRow').hide();

                                // Show summary info
                                $('#summaryInfo').show();

                                // Update data
                                $('#excelPreview').html(result.excelData);
                                $('.total-data-uploaded').text(result.totalData);
                                $('.total-data-verified').text(result.totalTerverifikasi);
                                $('.total-data-not-found').text(result.totalTidakDitemukan);

                                // Calculate accuracy percentage
                                var accuracy = result.totalData > 0 ?
                                    Math.round((result.totalTerverifikasi / result.totalData) * 100) : 0;
                                $('#accuracy-percentage').text(accuracy + '%');

                                // Show validation alert based on data quality
                                showDataValidationAlert(result.totalData, result.totalTerverifikasi, result.totalTidakDitemukan, accuracy);

                                // Show action buttons
                                $('#resetData, #saveData').show();

                                // Show file information if available
                                if (result.fileInfo) {
                                    console.log('File Info:', result.fileInfo);
                                }

                                // Show success message with more details
                                var successMessage = `File berhasil diproses! Total data: ${result.totalData}, Terverifikasi: ${result.totalTerverifikasi}`;
                                if (result.totalTidakDitemukan > 0) {
                                    successMessage += `, Tidak ditemukan: ${result.totalTidakDitemukan}`;
                                }

                                Swal.fire({
                                    title: 'Berhasil',
                                    text: successMessage,
                                    icon: 'success',
                                    timer: 4000,
                                    showConfirmButton: false
                                });
                            }
                        } catch (error) {
                            console.error('Error parsing response:', error);
                            Swal.fire('Error', 'Terjadi kesalahan saat memproses respons dari server', 'error');
                        }
                    }, 500);
                },
                error: function(xhr, status, error) {
                    clearInterval(progressInterval);
                    console.error('Upload error:', error);

                    var errorMessage = 'Gagal melakukan upload file';
                    if (status === 'timeout') {
                        errorMessage = 'Upload timeout. File terlalu besar atau proses memakan waktu terlalu lama. Coba dengan file yang lebih kecil.';
                    } else if (xhr.status === 413) {
                        errorMessage = 'File terlalu besar untuk diupload';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Terjadi kesalahan server. Mungkin data terlalu besar untuk diproses.';
                    }

                    Swal.fire('Error', errorMessage, 'error');
                },
                complete: function() {
                    // Reset loading state
                    $('#uploadBtn').prop('disabled', false);
                    $('.upload-text').removeClass('d-none');
                    $('.upload-loading').addClass('d-none');
                    $('#processStatus').addClass('d-none');
                    $('#progressContainer').addClass('d-none');
                    $('#largeDataWarning').addClass('d-none');
                    $('.progress-bar').css('width', '0%').attr('aria-valuenow', 0);
                }
            });
        });
        $('#saveData').click(function() {
            var rowCount = $('#excelPreview tr').length;
            if (rowCount === 0 || $('#emptyDataRow').is(':visible')) {
                Swal.fire(
                    'Belum Lengkap',
                    'List tabel data kosong, silahkan upload file terlebih dahulu.',
                    'info'
                );
                return;
            }

            // Show confirmation dialog for large datasets
            if (rowCount > 1000) {
                Swal.fire({
                    title: 'Data Banyak',
                    text: `Anda akan menyimpan ${rowCount} data. Proses ini mungkin memakan waktu beberapa menit. Lanjutkan?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        processSaveData();
                    }
                });
            } else {
                // Show final confirmation with data summary
                var totalData = $('.total-data-uploaded').text();
                var verifiedData = $('.total-data-verified').text();
                var notFoundData = $('.total-data-not-found').text();

                Swal.fire({
                    title: 'Konfirmasi Simpan Data',
                    html: `
                        <div class="text-left">
                            <p><strong>Pastikan data berikut sudah sesuai:</strong></p>
                            <ul>
                                <li>Total Data: <strong>${totalData}</strong></li>
                                <li>Data Terverifikasi: <strong style="color: green;">${verifiedData}</strong></li>
                                <li>Data Tidak Ditemukan: <strong style="color: red;">${notFoundData}</strong></li>
                            </ul>
                            <p class="text-warning"><i class="fas fa-exclamation-triangle"></i> 
                            Hanya data yang terverifikasi yang akan disimpan ke database.</p>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        processSaveData();
                    }
                });
            }
        });

        // Reset data functionality
        $('#resetData').click(function() {
            Swal.fire({
                title: 'Reset Data?',
                text: 'Semua data yang telah diupload akan dihapus. Anda perlu upload ulang file Excel.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    resetImportData();
                    Swal.fire({
                        title: 'Data Direset',
                        text: 'Silakan upload file Excel yang baru.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Function to show data validation alert
        function showDataValidationAlert(totalData, verifiedData, notFoundData, accuracy) {
            var alertElement = $('#dataValidationAlert');
            var messageElement = $('#validationMessage');

            if (accuracy === 100) {
                alertElement.removeClass('alert-warning alert-danger').addClass('alert-success');
                messageElement.html('Semua data berhasil diverifikasi dan siap disimpan.');
            } else if (accuracy >= 80) {
                alertElement.removeClass('alert-success alert-danger').addClass('alert-warning');
                messageElement.html(`${notFoundData} kode artikel tidak ditemukan. Periksa kembali data sebelum menyimpan.`);
            } else {
                alertElement.removeClass('alert-success alert-warning').addClass('alert-danger');
                messageElement.html(`Banyak data tidak valid (${notFoundData} dari ${totalData}). Pastikan file Excel berasal dari Easy Accounting PT. ABSI yang benar.`);
            }

            alertElement.removeClass('d-none');
        }

        // Function to reset import data
        function resetImportData() {
            // Clear file input
            $('#excelFile').val('');

            // Hide summary and alerts
            $('#summaryInfo').hide();
            $('#dataValidationAlert').addClass('d-none');

            // Reset counters
            $('.total-data-uploaded').text('0');
            $('.total-data-verified').text('0');
            $('.total-data-not-found').text('0');
            $('#accuracy-percentage').text('0%');

            // Clear preview table and show empty message
            $('#excelPreview').html(`
                <tr id="emptyDataRow">
                    <td colspan="5" class="text-center text-muted">
                        <i class="fas fa-upload"></i><br>
                        Silakan upload file Excel untuk melihat preview data
                    </td>
                </tr>
            `);

            // Hide action buttons
            $('#resetData, #saveData').hide();

            // Reset any loading states
            $('#uploadBtn').prop('disabled', false);
            $('.upload-text').removeClass('d-none');
            $('.upload-loading').addClass('d-none');
            $('#processStatus').addClass('d-none');
            $('#progressContainer').addClass('d-none');
            $('#largeDataWarning').addClass('d-none');
            $('.progress-bar').css('width', '0%').attr('aria-valuenow', 0);
        }

        function processSaveData() {
            // Show loading state
            $('#saveData').prop('disabled', true);
            $('.save-text').addClass('d-none');
            $('.save-loading').removeClass('d-none');

            var rowCount = $('#excelPreview tr').length;
            var progressText = 'Sedang menyimpan data ke database...';

            if (rowCount > 500) {
                progressText = `Menyimpan ${rowCount} data dalam batch. Proses mungkin memakan waktu beberapa menit...`;
            }

            // Show progress indicator
            Swal.fire({
                title: 'Menyimpan Data',
                text: progressText,
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            var dataToSave = []; // Prepare array to store data to save
            $('#excelPreview tr').each(function() {
                var rowData = {
                    'kode': $(this).find('td:eq(1)').text(),
                    'stok': $(this).find('td:eq(3)').text()
                };
                dataToSave.push(rowData);
            });

            $.ajax({
                url: '<?= base_url('adm/Stok/save_import'); ?>',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(dataToSave),
                timeout: 900000, // Increased to 15 minutes for very large datasets
                success: function(response) {
                    try {
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            var successMessage = result.message;
                            if (result.details) {
                                successMessage += ` (Total: ${result.details.total_processed}, Berhasil: ${result.details.success_count}`;
                                if (result.details.not_found_count > 0) {
                                    successMessage += `, Tidak ditemukan: ${result.details.not_found_count}`;
                                }
                                successMessage += ')';
                            }

                            Swal.fire({
                                title: 'Berhasil',
                                text: successMessage,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal',
                                text: result.message || 'Terjadi kesalahan saat menyimpan data.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    } catch (error) {
                        console.error('Error parsing response:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memproses respons dari server.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error saving data:', error);

                    var errorMessage = 'Gagal melakukan request ke server.';
                    if (status === 'timeout') {
                        errorMessage = 'Proses menyimpan timeout. Data terlalu banyak atau server sedang sibuk. Coba lagi dengan data yang lebih sedikit.';
                    } else if (xhr.status === 413) {
                        errorMessage = 'Data terlalu besar untuk diproses. Coba bagi file menjadi beberapa bagian.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Terjadi kesalahan pada server. Mungkin ada masalah dengan format data atau database.';
                    } else if (xhr.status === 0) {
                        errorMessage = 'Koneksi terputus. Periksa koneksi internet dan coba lagi.';
                    }

                    Swal.fire({
                        title: 'Error',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                },
                complete: function() {
                    // Reset loading state
                    $('#saveData').prop('disabled', false);
                    $('.save-text').removeClass('d-none');
                    $('.save-loading').addClass('d-none');
                }
            });
        }
    });
</script>