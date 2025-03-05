<section class="content">
    <div class="container-fluid">
        <form action="<?= base_url('adm/Stok/adjust_save') ?>" method="post" id="form_proses">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <li class="fas fa-window-restore"></li> Detail Adjusment Stok
                    </h3>
                    <div class="card-tools">
                        <a href="<?= base_url('adm/Stok/adjust_stok') ?>" type="button" class="btn btn-tool">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <strong>Nomor:</strong>
                                <input type="text" name="no_adjust" class="form-control form-control-sm" value="<?= $row->nomor ?>" readonly>
                                <input type="hidden" name="id_adjust" value="<?= $row->id ?>">
                                <input type="hidden" name="id_so" value="<?= $row->id_so ?>">
                                <input type="hidden" name="id_toko" value="<?= $row->id_toko ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <strong>No SO:</strong>
                                <input type="text" class="form-control form-control-sm" value="<?= $row->id_so ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <strong>Periode:</strong>
                                <input type="text" class="form-control form-control-sm" value="<?= date('F Y', strtotime('-1 month', strtotime($row->periode))) ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Toko:</strong>
                                <input type="text" class="form-control form-control-sm" value="<?= $row->nama_toko ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <strong>Status:</strong> <br>
                                <small><?= status_adjust($row->status) ?></small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Artikel</th>
                                <th class="text-center">Stok Sistem</th>
                                <th class="text-center">SO SPG</th>
                                <th class="text-center">Selisih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $selisih = 0;
                            $t_sistem = 0;
                            $t_hasil = 0;
                            $t_selisih = 0;
                            foreach ($detail as $d) :
                                $no++;
                                $selisih = $d->hasil_so - $d->stok_akhir; ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td>
                                        <small>
                                            <strong><?= $d->kode ?></strong> <br>
                                            <?= $d->artikel ?>
                                        </small>
                                        <input type="hidden" name="id_produk[]" value="<?= $d->id_produk ?>">
                                        <input type="hidden" name="stok_akhir[]" value="<?= $d->stok_akhir ?>">
                                        <input type="hidden" name="hasil_so[]" value="<?= $d->hasil_so ?>">
                                    </td>
                                    <td class="text-center"><?= $d->stok_akhir ?></td>
                                    <td class="text-center"><?= $d->hasil_so ?></td>
                                    <td class="text-center <?= ($selisih > 0) ? 'text-success' : 'text-danger' ?>"><?= ($selisih > 0) ? '+' : '' ?><?= $selisih ?></td>
                                </tr>
                            <?php
                                $t_sistem += $d->stok_akhir;
                                $t_hasil += $d->hasil_so;
                                $t_selisih += $selisih;
                            endforeach ?>
                            <tr>
                                <td colspan="2" class="text-right"><strong>Total : </strong></td>
                                <td class="text-center"><strong><?= $t_sistem ?></strong></td>
                                <td class="text-center"><strong><?= $t_hasil ?></strong></td>
                                <td class="text-center <?= ($t_selisih > 0) ? 'text-success' : 'text-danger' ?>"><strong><?= ($t_selisih > 0) ? '+' : '' ?><?= $t_selisih ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right"><strong>Rasio Kehilangan : </strong></td>
                                <td colspan="3" class="text-center text-danger"><strong><?= ($t_selisih > 0 || empty($t_selisih)) ? '-' : ROUND(($t_selisih / $t_sistem * 100), 2) . '%' ?> </strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <small>
                        <strong> Keterangan :</strong> <br>
                        <li>Proses ini membutuhkan verifikasi Direksi.</li>
                        <li>Ketika sudah disetujui maka sistem akan memperbarui stok & stok awal sesuai dengan hasil so SPG berdasarkan tanggal SO.</li>
                        <li>Jika pengajuan ini tidak di proses selama 10 hari, secara otomatis di batalkan oleh sistem.</li>
                    </small>
                    <hr>
                    <small><strong># Proses Pengajuan :</strong></small>
                    <hr>
                    <div class="timeline">
                        <?php $no = 0;
                        foreach ($histori as $h) :
                            $no++;
                        ?>
                            <div>
                                <i class="fas bg-blue"><?= $no ?></i>
                                <div class="timeline-item">
                                    <span class="time"></span>
                                    <p class="timeline-header"><small><?= $h->aksi ?> <strong><?= $h->pembuat ?></strong></small></p>
                                    <div class="timeline-body">
                                        <small>
                                            <?= date('d-M-Y  H:i:s', strtotime($h->tanggal)) ?> <br>
                                            Catatan :<br>
                                            <?= $h->catatan ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <?php if ($row->status == 0 && $this->session->userdata('role') == 1) { ?>
                        <div class="form-group">
                            <label for=""> Catatan anda *</label>
                            <textarea name="catatan" cols="3" class="form-control form-control-sm" placeholder="..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for=""> Keputusan anda *</label>
                            <select name="keputusan" class="form-control form-control-sm" required>
                                <option value="">- Pilih -</option>
                                <option value="1"> Setujui </option>
                                <option value="2"> Tolak </option>
                            </select>
                        </div>
                    <?php } ?>
                </div>
                <div class="card-footer text-right">
                    <a href="<?= base_url('adm/Stok/adjust_stok') ?>" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left"></i> kembali</a>
                    <?php if ($row->status == 0 && $this->session->userdata('role') == 1) { ?>
                        <button type="submit" class="btn btn-success btn-sm" id="btn-kirim"><i class="fas fa-save"></i> Simpan</button>
                    <?php } ?>
                    <?php if ($row->status == 1 && $this->session->userdata('role') == 1) { ?>
                        <button type="button" class="btn btn-warning btn-sm" id="btn-restore"><i class="fas fa-reply"></i> Restore</button>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    function validateForm() {
        let isValid = true;
        // Get all required input fields
        $('#form_proses').find('input[required], select[required], textarea[required]').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        return isValid;
    }
    $('#btn-kirim').click(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data Pengajuan Adjust Stok akan di proses",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Yakin'
        }).then((result) => {
            if (result.isConfirmed) {

                if (validateForm()) {
                    document.getElementById("form_proses").submit();
                } else {
                    Swal.fire({
                        title: 'Belum Lengkap',
                        text: ' Catatan & tindakan tidak boleh kosong',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            }
        })
    })
    $('#btn-restore').click(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin restore?',
            text: "Data stok awal akan dikembalikan ke stok sistem sebelumnya.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Yakin'
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = $('#form_proses').serialize(); // Mengambil semua data dari form

                // Tampilkan loading sebelum proses dimulai
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Silakan tunggu, sedang merestore data.',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.post('<?= base_url('adm/Stok/adjust_restore') ?>', formData, function(response) {
                    // Tutup loading dan tampilkan notifikasi sukses
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data telah di-restore.',
                        icon: 'success'
                    }).then(() => {
                        location.reload(); // Reload halaman setelah sukses
                    });
                }).fail(function() {
                    // Tutup loading dan tampilkan notifikasi gagal
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat merestore data.',
                        icon: 'error'
                    });
                });
            }
        });
    });
</script>