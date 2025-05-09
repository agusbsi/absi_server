<section class="content">
    <div class="container-fluid">
        <form action="<?= base_url('mng_ops/Dashboard/approve_adjust') ?>" method="post" id="form_proses">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <li class="fas fa-window-restore"></li> Detail Adjusment Stok
                    </h3>
                    <div class="card-tools">
                        <a href="<?= base_url('mng_ops/Dashboard/adjust_stok') ?>" type="button" class="btn btn-tool">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <strong>Nomor:</strong>
                                <input type="text" class="form-control form-control-sm" value="<?= $row->nomor ?>" readonly>
                                <input type="hidden" name="id_adjust" value="<?= $row->id ?>">
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
                    <div class="form-group">
                        <strong>Berkas yang di Upload:</strong><br>
                        <?php if ($row->berkas): ?>
                            <?php
                            $file_ext = pathinfo($row->berkas, PATHINFO_EXTENSION);
                            $file_url = base_url('assets/img/adj/' . $row->berkas);
                            ?>
                            <?php if (in_array(strtolower($file_ext), ['jpg', 'jpeg', 'png'])): ?>
                                <img src="<?= $file_url ?>" alt="Bukti Gambar" class="img-fluid img-thumbnail" style="max-height: 500px;">
                            <?php elseif (strtolower($file_ext) === 'pdf'): ?>
                                <a href="<?= $file_url ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-pdf"></i> Lihat PDF
                                </a>
                            <?php else: ?>
                                <p class="text-danger">Format file tidak didukung.</p>
                            <?php endif; ?>
                        <?php else: ?>
                            <small class="text-muted">Tidak ada file yang diunggah.</small>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <strong> Keterangan :</strong> <br>
                    <li><small>Proses ini membutuhkan verifikasi dari Manager OPR & Direksi.</small></li>
                    <li><small>Proses ini hanya bisa di lakukan sekali untuk satu nomor SO.</small></li>
                    <li><small>Ketika proses sudah di verifikasi maka akan memperbarui stok sistem sesuai dengan hasil SO SPG berdasarkan tanggal SO.</small></li>
                    <li><small>Jika pengajuan ini tidak di verifikasi selama 2 hari, maka sistem akan membatalkan secara otomatis.</small></li>
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
                    <hr>
                    <?php if ($row->status == 0 && $this->session->userdata('role') == 17) { ?>
                        <div class="form-group">
                            <label for=""> Catatan anda *</label>
                            <textarea name="catatan" cols="3" class="form-control form-control-sm" placeholder="..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for=""> Keputusan anda *</label>
                            <select name="keputusan" class="form-control form-control-sm" required>
                                <option value="">- Pilih -</option>
                                <option value="4"> Setujui </option>
                                <option value="2"> Tolak </option>
                            </select>
                        </div>
                    <?php } ?>
                </div>
                <div class="card-footer text-right">
                    <a href="<?= base_url('mng_ops/Dashboard/adjust_stok') ?>" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left"></i> kembali</a>
                    <?php if ($row->status == 0 && $this->session->userdata('role') == 17) { ?>
                        <button type="submit" class="btn btn-success btn-sm" id="btn-kirim"><i class="fas fa-save"></i> Simpan</button>
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
</script>