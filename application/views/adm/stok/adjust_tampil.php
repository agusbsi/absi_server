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
                <div class="tabel-scroll">
                    <table id="tabel_baru" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Pengajuan</th>
                                <th>Nama Toko</th>
                                <th class="text-center">Status</th>
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
                        return '<small><strong>' + row.id_so + '</strong></br>' + row.nama_toko + '</small>';
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
                        if (row.status == 0) {
                            return '<div class="waktu" data-waktu="' + data + '"></div>';
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    "data": "id",
                    "className": "text-center",
                    "render": function(data, type, row) {
                        if (row.status == 0) {
                            return '<a href="<?= base_url('adm/Stok/adjust_detail/') ?>' + data + '" class="btn btn-sm btn-success"><i class="fas fa-paper-plane"></i> Proses</a>';
                        } else {
                            return '<a href="<?= base_url('adm/Stok/adjust_detail/') ?>' + data + '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>';
                        }
                    }
                }
            ],
            "order": []
        });
    });

    function adjustStatus(id) {
        if (id == 0) {
            return "<small><span class='badge badge-warning'>Proses Verifikasi</span></small>";
        } else if (id == 1) {
            return "<small><span class='badge badge-success'>Disetujui</span></small>";
        } else if (id == 2) {
            return "<small><span class='badge badge-danger'>Ditolak</span></small>";
        } else {
            return "<small><span class='badge badge-danger'>Dicancel</span></small>";
        }
    }
</script>

<script>
    function updateCountdown() {
        document.querySelectorAll('.waktu').forEach((element) => {
            const waktuData = element.getAttribute('data-waktu'); // Ambil atribut data-waktu
            const waktuSo = new Date(waktuData).getTime(); // Konversi ke waktu dalam milidetik
            const targetTime = waktuSo + (10 * 24 * 60 * 60 * 1000); // Tambahkan 10 hari ke waktu awal
            const now = new Date().getTime(); // Waktu saat ini dalam milidetik
            const distance = targetTime - now; // Hitung selisih antara targetTime dan waktu sekarang

            // Menghitung hari, jam, menit, dan detik yang tersisa
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Format waktu yang tersisa
            let formattedTime = '';
            if (days > 0) {
                formattedTime += `${String(days).padStart(2, '0')} hari, `;
            }
            formattedTime += `${String(hours).padStart(2, '0')} : ${String(minutes).padStart(2, '0')} : ${String(seconds).padStart(2, '0')}`;
            element.textContent = formattedTime; // Tampilkan waktu di elemen

            // Jika waktu sudah melewati targetTime, tampilkan "Kadaluarsa"
            if (distance < 0) {
                element.textContent = 'Kadaluarsa';
            }
        });
    }

    // Memanggil updateCountdown setiap 1 detik
    setInterval(updateCountdown, 1000);
    updateCountdown();
</script>