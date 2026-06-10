<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Detail Stok Customer</h3>
                <div class="card-tools">
                    <a href="<?= base_url('adm/Stok/s_customer?bulan=' . $bulan_filter . '&tahun=' . $tahun_filter) ?>" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($customer)): ?>
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <h3 class="mb-1"><strong><?= strtoupper($customer->nama_cust) ?></strong></h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-calendar"></i> Periode: <strong><?= $periode ?></strong>
                            </p>
                        </div>
                    </div>

                    <?php if (!empty($list_data)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th style="width: 5%">No</th>
                                        <th>Nama Toko</th>
                                        <th style="width: 12%">Stok Awal</th>
                                        <th style="width: 12%">Penjualan</th>
                                        <th style="width: 12%">Stok Akhir</th>
                                        <th style="width: 12%">Rasio</th>
                                        <th style="width: 12%">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($list_data as $item):
                                        $no++;
                                        $rasio = (!empty($item->penjualan) && $item->penjualan != 0)
                                            ? round($item->stok_akhir / $item->penjualan, 2)
                                            : round($item->stok_akhir / 1, 2);

                                        if ($rasio < 1) {
                                            $rasioBadge = 'badge-danger';
                                        } elseif ($rasio < 2) {
                                            $rasioBadge = 'badge-warning';
                                        } else {
                                            $rasioBadge = 'badge-success';
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td><?= $item->nama_toko ?></td>
                                            <td class="text-center">
                                                <span class="badge badge-sm badge-light"><?= number_format($item->stok_awal) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-sm badge-info"><?= number_format($item->penjualan) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-sm badge-primary"><?= number_format($item->stok_akhir) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-sm <?= $rasioBadge ?>"><?= $rasio ?>x</span>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($item->status_kunci != 1): ?>
                                                    <div class="badge badge-warning" style="display: inline-block; padding: 8px; font-size: 11px;">
                                                        <i class="fas fa-exclamation-triangle"></i> Data belum valid
                                                    </div>
                                                    <div style="font-size: 10px; margin-top: 4px; color: #b8860b;">
                                                        Hubungi tim MV/Operasional
                                                    </div>
                                                <?php else: ?>
                                                    <a href="<?= base_url('sup/So/riwayat_so_toko/' . $item->id . '/' . $item->nomor_so) ?>" class="btn btn-sm btn-info" target="_blank" rel="noopener noreferrer">
                                                        Lihat <i class="fas fa-arrow-circle-right"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="thead-light">
                                    <tr class="text-center">
                                        <td colspan="2" class="text-left"><strong>TOTAL</strong></td>
                                        <td>
                                            <span class="badge badge-sm badge-light"><?= number_format($total_stok_awal) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm badge-info"><?= number_format($total_penjualan) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm badge-primary"><?= number_format($total_stok_akhir) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm badge-success">
                                                <?php
                                                $total_rasio = (!empty($total_penjualan) && $total_penjualan != 0)
                                                    ? round($total_stok_akhir / $total_penjualan, 1)
                                                    : round($total_stok_akhir / 1, 1);
                                                echo $total_rasio . 'x';
                                                ?>
                                            </span>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i> Tidak ada data toko untuk customer dan periode yang dipilih.
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> Customer tidak ditemukan.
                    </div>
                <?php endif; ?>

                <a href="<?= base_url('adm/Stok/s_customer?bulan=' . $bulan_filter . '&tahun=' . $tahun_filter) ?>" class="btn btn-danger btn-sm float-right mr-1">
                    <i class="fa fa-times-circle"></i> Close
                </a>
            </div>
        </div>
    </div>
</section>
