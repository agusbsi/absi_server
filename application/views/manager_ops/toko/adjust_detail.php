<section class="content">
    <div class="container-fluid">
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
            </div>
            <div class="card-footer text-right">
                <a href="<?= base_url('mng_ops/Dashboard/adjust_stok') ?>" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left"></i> kembali</a>
            </div>
        </div>
    </div>
</section>