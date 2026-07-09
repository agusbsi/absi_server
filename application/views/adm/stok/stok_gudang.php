<section class="content warehouse-page">
    <div class="container-fluid">
        <div class="card-container">
            <div class="card warehouse-card">
                <div class="card-header warehouse-hero">
                    <div><h2><i class="fas fa-warehouse mr-2"></i>Stok Gudang Prepedan</h2><p>Pantau ketersediaan artikel dan pembaruan stok dari Easy Accounting.</p></div>
                    <span class="sync-badge"><i class="fas fa-sync-alt mr-1"></i>Sinkronisasi Harian</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-box"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Item</span>
                                <span class="info-box-number"><?= number_format($t_item->total_item, 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-cubes"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Stok Gudang</span>
                                    <span class="info-box-number"><?= number_format($t_item->total_stok, 0, ',', '.') ?></span>
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
                    <div class="table-heading"><div><h3>Daftar Stok Artikel</h3><p>Gunakan pencarian untuk menemukan kode atau nama artikel.</p></div><span><?= number_format($t_item->total_item, 0, ',', '.') ?> artikel</span></div>
                    <div class="tabel-scroll table-responsive">
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
                    <div class="stock-note"><i class="fas fa-info-circle"></i><div><strong>Informasi pembaruan</strong><span>Data berasal dari Easy Accounting, diperbarui setiap hari pukul 08.00–09.00 WIB, dan diimpor oleh tim Accounting.</span></div></div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?= base_url('adm/Stok/unduhExcel') ?>" class="btn btn-light border btn-sm"><i class="fas fa-download"></i> Unduh Template Excel </a>
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

    .warehouse-page{--primary:#2563eb;--muted:#64748b;--line:#e2e8f0;color:#0f172a}.warehouse-page .warehouse-card{overflow:hidden;border:0;border-radius:19px;background:#fff;box-shadow:0 10px 35px rgba(15,23,42,.08)}.warehouse-page .warehouse-hero{display:flex;align-items:center;justify-content:space-between;padding:25px 27px;border:0;color:#fff;background:linear-gradient(125deg,#172554,#1d4ed8 75%,#38bdf8 140%)}.warehouse-page .warehouse-hero:after{display:none}.warehouse-page .warehouse-hero h2{margin:0 0 5px;font-size:24px;font-weight:700}.warehouse-page .warehouse-hero p{margin:0;color:rgba(255,255,255,.78);font-size:12px}.warehouse-page .sync-badge{padding:7px 11px;border:1px solid rgba(255,255,255,.25);border-radius:20px;background:rgba(255,255,255,.1);font-size:10px;font-weight:700}.warehouse-page .warehouse-card>.card-body{padding:21px}
    .warehouse-page .info-box{min-height:100px;padding:14px;border:1px solid var(--line);border-radius:15px;box-shadow:0 4px 16px rgba(15,23,42,.04)}.warehouse-page .info-box .info-box-icon{width:50px;height:50px;border-radius:13px;color:#2563eb!important;background:#eff6ff!important;font-size:19px}.warehouse-page .col-md-4:nth-child(2) .info-box-icon{color:#059669!important;background:#ecfdf5!important}.warehouse-page .col-md-4:nth-child(3) .info-box-icon{color:#d97706!important;background:#fffbeb!important}.warehouse-page .info-box .info-box-text{color:var(--muted);font-size:10px;letter-spacing:.04em}.warehouse-page .info-box .info-box-number{color:#0f172a;font-size:20px;line-height:1.3}.warehouse-page .col-md-4:nth-child(3) .info-box-number{font-size:13px}.warehouse-page .table-heading{display:flex;align-items:flex-end;justify-content:space-between;padding:10px 0 13px;margin-top:5px}.warehouse-page .table-heading h3{margin:0 0 3px;font-size:16px;font-weight:700}.warehouse-page .table-heading p{margin:0;color:var(--muted);font-size:11px}.warehouse-page .table-heading>span{padding:5px 9px;border-radius:20px;color:#1d4ed8;background:#eff6ff;font-size:10px;font-weight:700}.warehouse-page .tabel-scroll{max-height:none;overflow:visible}.warehouse-page #tabel_baru thead th{padding:12px 10px;border-width:1px 0;border-color:var(--line);color:#475569;background:#f8fafc;font-size:10px;text-transform:uppercase}.warehouse-page #tabel_baru tbody td{padding:13px 10px;border-color:#f1f5f9;vertical-align:middle}.warehouse-page .stock-note{display:flex;align-items:flex-start;padding:13px 15px;margin-top:17px;border:1px solid #bfdbfe;border-radius:12px;color:#475569;background:#eff6ff}.warehouse-page .stock-note>i{margin:2px 10px 0 0;color:#2563eb}.warehouse-page .stock-note strong,.warehouse-page .stock-note span{display:block}.warehouse-page .stock-note strong{color:#1e3a8a;font-size:11px}.warehouse-page .stock-note span{font-size:10px}.warehouse-page .warehouse-card>.card-footer{padding:15px 21px;border-color:#f1f5f9;background:#fff}.warehouse-page .warehouse-card>.card-footer .btn{height:36px;padding:0 13px;border-radius:9px;font-size:11px;font-weight:700}
    .warehouse-import-modal .modal-content{overflow:hidden;border:0;border-radius:18px;box-shadow:0 22px 55px rgba(15,23,42,.23)}.warehouse-import-modal .modal-header{padding:19px 21px;border:0;background:linear-gradient(120deg,#172554,#2563eb)!important}.warehouse-import-modal .modal-title{font-weight:700}.warehouse-import-modal .modal-body{padding:20px}.warehouse-import-modal .alert{border:0;border-radius:12px;font-size:11px}.warehouse-import-modal #uploadForm{padding:16px;border:1px dashed #93c5fd;border-radius:13px;background:#f8fbff}.warehouse-import-modal #excelFile{height:auto;padding:7px;border-color:#bfdbfe;border-radius:9px;background:#fff}.warehouse-import-modal .btn{border-radius:9px;font-weight:600}.warehouse-import-modal .table-responsive{border:1px solid var(--line);border-radius:12px}.warehouse-import-modal .modal-footer{padding:14px 20px;border-color:#f1f5f9}
    @media(max-width:767.98px){
        .warehouse-page{padding:8px 0}
        .warehouse-page .container-fluid{padding-right:10px;padding-left:10px}
        .warehouse-page .warehouse-card{border-radius:14px}
        .warehouse-page .warehouse-hero{align-items:flex-start;padding:18px 16px}
        .warehouse-page .warehouse-hero h2{font-size:19px;line-height:1.25}
        .warehouse-page .warehouse-hero p{font-size:11px;line-height:1.45}
        .warehouse-page .sync-badge{display:none}
        .warehouse-page .warehouse-card>.card-body{padding:13px}
        .warehouse-page .info-box{min-height:78px;padding:11px;border-radius:12px}
        .warehouse-page .info-box .info-box-icon{width:43px;height:43px;flex:0 0 43px;font-size:16px}
        .warehouse-page .info-box .info-box-content{min-width:0;margin-left:7px;padding:0}
        .warehouse-page .info-box .info-box-text{white-space:normal;font-size:9px;line-height:1.35}
        .warehouse-page .info-box .info-box-number{overflow-wrap:anywhere;font-size:17px}
        .warehouse-page .col-md-4:nth-child(3) .info-box-number{font-size:12px}
        .warehouse-page .table-heading{align-items:flex-start;flex-direction:column;padding-top:4px}
        .warehouse-page .table-heading h3{font-size:15px}
        .warehouse-page .table-heading p{line-height:1.45}
        .warehouse-page .table-heading>span{margin-top:8px}
        .warehouse-page .tabel-scroll{overflow:visible}
        .warehouse-page #tabel_baru{display:block;width:100%!important;margin:0!important;border-collapse:separate;border-spacing:0 8px}
        .warehouse-page #tabel_baru thead{display:none}
        .warehouse-page #tabel_baru tbody{display:block}
        .warehouse-page #tabel_baru tbody tr{display:grid;grid-template-columns:1fr auto;gap:5px 12px;margin-bottom:8px;padding:11px 12px;border:1px solid var(--line);border-radius:12px;background:#fff;box-shadow:0 4px 14px rgba(15,23,42,.05)}
        .warehouse-page #tabel_baru tbody td{display:block;padding:0;border:0;color:#0f172a;font-size:12px;text-align:left}
        .warehouse-page #tabel_baru tbody td:before{display:none}
        .warehouse-page #tabel_baru tbody td:nth-child(1){grid-column:2;grid-row:1;color:#94a3b8;font-size:10px;text-align:right}
        .warehouse-page #tabel_baru tbody td:nth-child(2){grid-column:1;grid-row:1;color:#1d4ed8;font-size:12px;line-height:1.25}
        .warehouse-page #tabel_baru tbody td:nth-child(3){grid-column:1 / -1;grid-row:2;color:#334155;line-height:1.4}
        .warehouse-page #tabel_baru tbody td:nth-child(4){grid-column:1;grid-row:3;color:#64748b;font-size:11px}
        .warehouse-page #tabel_baru tbody td:nth-child(5){grid-column:2;grid-row:3;color:#0f172a;font-weight:700;text-align:right}
        .warehouse-page #tabel_baru tbody td:nth-child(4):before{display:inline;content:"Sat: ";color:#94a3b8;font-weight:700}
        .warehouse-page #tabel_baru tbody td:nth-child(5):before{display:inline;content:"Stok: ";color:#94a3b8;font-weight:700}
        .warehouse-page #tabel_baru tbody td:nth-child(3) small{display:block;line-height:1.4}
        .warehouse-page #tabel_baru tbody td .text-center{text-align:right!important}
        .warehouse-page .dataTables_wrapper>.row:first-child{display:flex;align-items:flex-end;gap:8px;margin:0 0 10px}
        .warehouse-page .dataTables_wrapper>.row:first-child>[class*="col-"]{width:auto;max-width:none;flex:0 0 auto;padding-right:0;padding-left:0}
        .warehouse-page .dataTables_wrapper>.row:first-child>[class*="col-"]:last-child{flex:1 1 auto;min-width:0}
        .warehouse-page .dataTables_length,
        .warehouse-page .dataTables_filter{text-align:left!important;font-size:10px}
        .warehouse-page .dataTables_filter label,
        .warehouse-page .dataTables_length label{display:block;width:100%;margin-bottom:0;color:var(--muted);line-height:1.2}
        .warehouse-page .dataTables_filter input,
        .warehouse-page .dataTables_length select{height:32px;margin:4px 0 0;border:1px solid #dbe3ec;border-radius:8px;font-size:12px}
        .warehouse-page .dataTables_length select{width:58px!important;padding:4px 6px}
        .warehouse-page .dataTables_filter input{width:100%!important;max-width:180px;padding:4px 8px}
        .warehouse-page .dataTables_wrapper>.row:last-child{gap:8px;margin:4px 0 0}
        .warehouse-page .dataTables_wrapper>.row:last-child>[class*="col-"]{padding-right:0;padding-left:0}
        .warehouse-page .dataTables_info{padding-top:4px!important;color:var(--muted);font-size:10px;text-align:center}
        .warehouse-page .dataTables_paginate .pagination{flex-wrap:wrap;justify-content:center;margin:0}
        .warehouse-page .pagination .page-link{padding:5px 8px;font-size:11px}
        .warehouse-page .stock-note{padding:12px;margin-top:12px}
        .warehouse-page .stock-note span{line-height:1.45}
        .warehouse-page .warehouse-card>.card-footer{display:flex;flex-direction:column;gap:8px;padding:13px;text-align:initial!important}
        .warehouse-page .warehouse-card>.card-footer .btn{display:flex;align-items:center;justify-content:center;width:100%;margin-bottom:0}
        .warehouse-import-modal .modal-body{padding:14px}
    }
</style>
<div class="modal warehouse-import-modal" id="importModel" role="dialog" aria-hidden="true" data-backdrop="false">
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
                        <li>Maksimal <strong>10.000 baris</strong> dan ukuran file <strong>50 MB</strong></li>
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
                                <small class="text-muted">Maksimal 50 MB</small>
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
            "createdRow": function(row) {
                var labels = ['No', 'Kode', 'Nama Artikel', 'Satuan', 'Stok'];
                $('td', row).each(function(index) {
                    $(this).attr('data-label', labels[index]);
                });
            },
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

            // Validate file size (max 50MB, sesuai batas server)
            var file = fileInput.files[0];
            var maxSize = 50 * 1024 * 1024;
            if (file.size > maxSize) {
                Swal.fire('Error', 'Ukuran file terlalu besar. Maksimal 50 MB', 'error');
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
