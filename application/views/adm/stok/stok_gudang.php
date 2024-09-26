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
                        <li>Data di perbarui setiap hari pukul 08.00 WIB.</li>
                        <li>Data di import oleh tim Accounting.</li>
                    </small>
                </div>
                <div class="card-footer text-right">
                    <?php if ($this->session->userdata('role') == 15) { ?>
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#importModel"><i class="fas fa-upload"></i> Import Stok</button>
                    <?php } ?>
                </div>
            </div>
        </div>
</section>
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
                <form method="post" id="uploadForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Pilih File Excel dari Easy Accounting : </label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="file" class="form-control form-control-sm" id="excelFile" name="excel_file" accept=".xlsx,.xls" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success btn-sm">Upload File</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row mb-2">
                    <div class="col-md-4">Total Data: <span class="total-data-uploaded">0</span></div>
                    <div class="col-md-4">Terverifikasi: <span class="total-data-verified">0</span></div>
                    <div class="col-md-4">Kode tidak ditemukan: <span class="total-data-not-found">0</span></div>
                </div>
                <form method="post" id="saveForm" enctype="multipart/form-data">
                    <table class="table table-striped">
                        <thead>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Artikel</th>
                            <th>Stok</th>
                            <th>Keterangan</th>
                        </thead>
                        <tbody id="excelPreview"></tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>

                <button type="button" class="btn btn-primary ms-1 btn-sm" id="saveData">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Simpan</span>
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
            var formData = new FormData(this);
            $.ajax({
                url: '<?= base_url('adm/Stok/process_import'); ?>',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.error) {
                        alert(result.error);
                    } else {
                        $('#excelPreview').html(result.excelData);
                        $('.total-data-uploaded').text(result.totalData);
                        $('.total-data-verified').text(result.totalTerverifikasi);
                        $('.total-data-not-found').text(result.totalTidakDitemukan);
                    }
                }
            });
        });
        $('#saveData').click(function() {
            var rowCount = $('#excelPreview tr').length;
            if (rowCount === 0) {
                Swal.fire(
                    'Belum Lengkap',
                    'List tabel data kosong, silahkan upload file terlebih dahulu.',
                    'info'
                );
                return;
            }

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
                success: function(response) {
                    try {
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil',
                                text: result.message,
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
                                text: 'Terjadi kesalahan saat menyimpan data.',
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
                    Swal.fire({
                        title: 'Error',
                        text: 'Gagal melakukan request ke server.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>