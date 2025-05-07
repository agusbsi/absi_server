<style>
    .waktu {
        font-size: 10px;
        font-weight: 700;
        padding: 3px 5px;
        background-color: #3e007c;
        color: #ff9628;
        border-radius: 20px;
        letter-spacing: 1px;
    }

    @media (max-width: 600px) {
        .tabel-scroll {
            width: 100%;
            overflow-y: auto;
        }
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <li class="fas fa-window-restore"></li> Data Adjusment Stok
                </h3>
                <div class="card-tools">
                    <a href="<?= base_url('adm/Dashboard') ?>" type="button" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-2">
                    <div class="form-group">
                        <label for="">Integrasi Easy</label> <br>
                        <button type="button" data-toggle="modal" data-target="#modal-export-all" class="btn btn-success btn-block btn-sm btn_export_all" title="Export DO"><i class="fa fa-file-export"></i> Export Data</button>
                    </div>
                </div>
                <hr>
                <div class="tabel-scroll">
                    <table id="tabel_baru" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Pengajuan</th>
                                <th>Nama Toko</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Diajukan</th>
                                <th class="text-center">Waktu</th>
                                <th class="text-center">Menu</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modal-export-all">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title">
                    <li class="fa fa-excel"></li> Integrasi Data ke Easy Accounting
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formExport-all" method="post" action="<?= base_url('adm/Stok/export_adjust'); ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="file">Gudang Tujuan *</label>
                                <select name="gudang" class="form-control form-control-sm select2" required>
                                    <option value="">- Pilih Gudang -</option>
                                    <?php
                                    $pt = $this->session->userdata('pt');
                                    if ($pt == "VISTA MANDIRI GEMILANG") {
                                        echo '<option value="VISTA"> 51.1 GUD KONSINYASI </option>';
                                    } else {
                                        echo '<option value="TOKO"> SESUAI NAMA TOKO </option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Template Easy</label>
                                <input type="text" class="form-control form-control-sm" value="Inventory Adjustment" readonly>
                            </div>
                            <div class="form-group">
                                <label for="file">Deskripsi *</label>
                                <textarea name="deskripsi" class="form-control form-control-sm" placeholder="Masukan deskripsi untuk easy accounting, exp : Pemutihan stok .." required></textarea>
                            </div>
                            <br>
                            <hr>
                            <div class="text-center">
                                <strong>Jumlah data adjust yang dipilih : </strong> <br>
                                <h1 id="selectedCount" class="headline text-warning" style="font-size: 80px; font-weight:bold">0</h1>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="file">List data adjustment stok</label>
                                <div class="input-group mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm " id="searchInput" placeholder="Cari Berdasarkan Nomor Adjust, Nama Toko...">
                                </div>
                                <div style="overflow-x: auto; max-height : 300px;">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nomor</th>
                                                <th>Toko</th>
                                                <th>
                                                    <input type="checkbox" id="cekAll">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 0;
                                            foreach ($list as $pr) {
                                                $no++; ?>
                                                <tr>
                                                    <td class="text-center"><?= $no ?></td>
                                                    <td>
                                                        <small>
                                                            <strong><?= $pr->nomor ?></strong>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <small><?= $pr->nama_toko ?></small>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="checkbox" name="id_kirim_all[]" class="checkbox-item" value="<?= $pr->id ?>">
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                    <li class="fas fa-times-circle"></li> Close
                </button>
                <button type="submit" class="btn btn-primary btn-sm " id="export-button-all">
                    <li class="fas fa-file-export"></li> Export
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tabel_baru').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= base_url('adm/Stok/get_adjust_stok') ?>",
                "type": "POST"
            },
            "columns": [{
                    "data": "no"
                },
                {
                    "data": "nomor"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return `
            <small>
                <strong>${row.id_so}</strong><br>
                <strong>Tgl SO : ${row.tgl_so}</strong><br>
                ${row.nama_toko}
            </small>
        `;
                    }
                },
                {
                    "data": "status",
                    "className": "text-center",
                    "render": function(data, type, row) {
                        return adjustStatus(data);
                    }
                },
                {
                    "data": "created_at",
                    "className": "text-center",
                    "render": function(data, type, row) {
                        if (!data) return '-';

                        const date = new Date(data);
                        const options = {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        };

                        return date.toLocaleDateString('id-ID', options);
                    }
                },
                {
                    "data": "created_at",
                    "className": "text-center",
                    "render": function(data, type, row) {
                        if (row.status == 4) {
                            return '<span class="waktu text-nowrap" data-waktu="' + data + '">' + data + '</span>';
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    "data": "id",
                    "className": "text-center",
                    "render": function(data, type, row) {
                        const baseUrl = "<?= base_url('adm/Stok/adjust_detail/') ?>"; // Mendapatkan base URL
                        const role = <?= $this->session->userdata('role'); ?>; // Mendapatkan role dari sesi PHP

                        if (row.status == 4 && role == 1) {
                            return '<a href="' + baseUrl + data + '" class="btn btn-sm btn-success"><i class="fas fa-paper-plane"></i> Proses</a>';
                        } else {
                            return '<a href="' + baseUrl + data + '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>';
                        }
                    }
                }

            ],
            "order": []
        });
        // Fungsi untuk melakukan pencarian
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length; j++) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break; // keluar dari loop jika sudah ada satu td yang cocok
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        document.getElementById("searchInput").addEventListener("input", searchTable);
    });

    function adjustStatus(id) {
        if (id == 0) {
            return "<small><span class='badge badge-warning'>Di Proses Manager OPR</span></small>";
        } else if (id == 1) {
            return "<small><span class='badge badge-success'>Disetujui</span></small>";
        } else if (id == 2) {
            return "<small><span class='badge badge-danger'>Ditolak</span></small>";
        } else if (id == 4) {
            return "<small><span class='badge badge-warning'>Di Proses Direksi</span></small>";
        } else {
            return "<small><span class='badge badge-danger'>Dicancel</span></small>";
        }
    }
</script>
<script>
    function updateCountdown() {
        document.querySelectorAll('.waktu').forEach((element) => {
            const waktuData = element.getAttribute('data-waktu');
            const waktuSo = new Date(waktuData).getTime();
            const targetTime = waktuSo + (2 * 24 * 60 * 60 * 1000);
            const now = new Date().getTime();
            const distance = targetTime - now;
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            let formattedTime = '';
            if (days > 0) {
                formattedTime += `${String(days).padStart(2, '0')} hari, `;
            }
            formattedTime += `${String(hours).padStart(2, '0')} : ${String(minutes).padStart(2, '0')} : ${String(seconds).padStart(2, '0')}`;
            element.textContent = formattedTime;
            if (distance < 0) {
                element.textContent = 'Kadaluarsa';
                fetch('<?= base_url('Otomatis/adjust_waktu') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
            }
        });
    }
    setInterval(updateCountdown, 1000);
    updateCountdown();
</script>
<script>
    $(document).ready(function() {
        const form = document.getElementById('formExport-all');
        const checkboxes = document.querySelectorAll('.checkbox-item');
        const selectedCount = document.getElementById('selectedCount');
        const cekAll = document.getElementById('cekAll');

        function updateCount() {
            const count = document.querySelectorAll('.checkbox-item:checked').length;
            selectedCount.textContent = count;
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateCount);
        });

        cekAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = cekAll.checked;
            });
            updateCount();
        });

        // Initial count update
        updateCount();


    });
</script>
<script>
    document.getElementById('export-button-all').addEventListener('click', function(event) {
        event.preventDefault();
        const checkedCount = document.querySelectorAll('.checkbox-item:checked').length;
        const checkboxes = document.querySelectorAll('.checkbox-item');
        var gudang = $('[name="gudang"]').val();
        var deskripsi = $('[name="deskripsi"]').val();
        if (gudang == "" || deskripsi == "") {
            Swal.fire(
                'BELUM LENGKAP',
                'Gudang Dan deskripsi tidak boleh kosong.',
                'info'
            );
        } else if (checkedCount === 0) {
            Swal.fire(
                'BELUM LENGKAP',
                'Minimal 1 Nomor harus terpilih.',
                'info'
            );
        } else {
            document.getElementById('formExport-all').submit();
            alert('Berhasil Export Data');
            $('#modal-export-all').modal('hide');
            $('[name="deskripsi"]').val('');
            $('[name="gudang"]').val('').trigger('change');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = false;
            });
            const count = document.querySelectorAll('.checkbox-item:checked').length;
            selectedCount.textContent = count;
        }

    });
</script>