<section class="content">
    <div class="container-fluid">
        <!-- Filter Section -->
        <div class="row">
            <div class="col-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-filter"></i> Filter Laporan Stok Pelanggan</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('adm/Stok/s_customer') ?>" id="filterForm" class="form-inline w-100 justify-content-end">
                            <!-- Customer Select -->
                            <div class="form-group mr-2">
                                <label for="id_cust" class="mr-2">Pilih Customer:</label>
                                <select class="form-control form-control-sm select2" id="id_cust" name="id_cust" required style="width: 200px;">
                                    <option value="">-- Pilih Customer --</option>
                                    <?php foreach ($list_customers as $cust): ?>
                                        <option value="<?= $cust->id ?>" <?= (!empty($customer) && $customer->id === $cust->id) ? 'selected' : '' ?>>
                                            <?= $cust->nama_cust ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Month Select -->
                            <div class="form-group mr-2">
                                <label for="bulan" class="mr-2">Bulan:</label>
                                <select class="form-control form-control-sm" id="bulan" name="bulan" required>
                                    <?php
                                    $bulan_name = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>" 
                                            <?= ($bulan_filter === str_pad($i, 2, '0', STR_PAD_LEFT)) ? 'selected' : '' ?>>
                                            <?= $bulan_name[$i] ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <!-- Year Select -->
                            <div class="form-group mr-2">
                                <label for="tahun" class="mr-2">Tahun:</label>
                                <select class="form-control form-control-sm" id="tahun" name="tahun" required>
                                    <?php
                                    $current_year = (int)date('Y');
                                    for ($y = $current_year - 5; $y <= $current_year; $y++): ?>
                                        <option value="<?= $y ?>" <?= ($tahun_filter === (string)$y) ? 'selected' : '' ?>>
                                            <?= $y ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <!-- Search Button -->
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Section -->
        <?php if ($show_report && !empty($customer)): ?>
            <div class="card card-info">
                <div class="card-body">
                    <!-- Header dengan Customer Info -->
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <h3 class="mb-1"><strong><?= strtoupper($customer->nama_cust) ?></strong></h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-calendar"></i> Periode: <strong><?= date('F Y', strtotime("$tahun_filter-$bulan_filter-01")) ?></strong>
                            </p>
                        </div>
                    </div>

                    <!-- Data Table dengan Action Buttons -->
                    <div class="mt-4">
                        
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
                                            
                                            // Determine rasio status
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
                                                        <a href="<?= base_url('sup/So/riwayat_so_toko/' . $item->id . '/' . $item->nomor_so) ?>" class="btn btn-sm btn-info" target="_blank" rel="noopener noreferrer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
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
                                <i class="fas fa-info-circle"></i> Tidak ada data untuk customer dan periode yang dipilih.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>