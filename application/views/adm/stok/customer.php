<style>
    .stock-loading-overlay {
        position: fixed;
        inset: 0;
        z-index: 2050;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, 0.58);
        backdrop-filter: blur(5px);
    }

    .stock-loading-overlay.is-visible {
        display: flex;
    }

    .stock-loading-card {
        width: min(360px, 100%);
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 22px 60px rgba(15, 23, 42, 0.28);
        padding: 24px;
        text-align: center;
    }

    .stock-loading-ring {
        position: relative;
        width: 76px;
        height: 76px;
        margin: 0 auto 18px;
        border-radius: 50%;
        background:
            conic-gradient(#17a2b8 0 32%, #007bff 32% 64%, #e9f3ff 64% 100%);
        animation: stockLoadingSpin 1s linear infinite;
    }

    .stock-loading-ring::after {
        content: "";
        position: absolute;
        inset: 9px;
        border-radius: 50%;
        background: #fff;
    }

    .stock-loading-icon {
        position: absolute;
        inset: 0;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #007bff;
        font-size: 22px;
        animation: stockLoadingIcon 1s linear infinite reverse;
    }

    .stock-loading-title {
        margin-bottom: 6px;
        color: #1f2937;
        font-size: 18px;
        font-weight: 700;
    }

    .stock-loading-text {
        margin-bottom: 18px;
        color: #6b7280;
        font-size: 14px;
        line-height: 1.5;
    }

    .stock-loading-progress {
        overflow: hidden;
        height: 6px;
        border-radius: 999px;
        background: #e5e7eb;
    }

    .stock-loading-progress span {
        display: block;
        width: 42%;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #17a2b8, #007bff);
        animation: stockLoadingProgress 1.2s ease-in-out infinite;
    }

    @keyframes stockLoadingSpin {
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes stockLoadingIcon {
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes stockLoadingProgress {
        0% {
            transform: translateX(-110%);
        }

        100% {
            transform: translateX(250%);
        }
    }
</style>

<div class="stock-loading-overlay" id="stockLoadingOverlay" aria-live="polite" aria-hidden="true">
    <div class="stock-loading-card">
        <div class="stock-loading-ring">
            <div class="stock-loading-icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div class="stock-loading-title" id="stockLoadingTitle">Mengambil data stok</div>
        <div class="stock-loading-text" id="stockLoadingText">
            Sistem sedang menyiapkan laporan. Mohon tunggu sebentar.
        </div>
        <div class="stock-loading-progress"><span></span></div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-filter"></i> Filter Laporan Stok Customer</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('adm/Stok/s_customer') ?>" id="filterForm" class="form-inline w-100 justify-content-end">
                            <div class="form-group mr-2">
                                <label for="bulan" class="mr-2">Bulan:</label>
                                <select class="form-control form-control-sm" id="bulan" name="bulan" required>
                                    <?php
                                    $bulan_name = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    for ($i = 1; $i <= 12; $i++):
                                        $bulan_value = str_pad($i, 2, '0', STR_PAD_LEFT);
                                    ?>
                                        <option value="<?= $bulan_value ?>" <?= ($bulan_filter === $bulan_value) ? 'selected' : '' ?>>
                                            <?= $bulan_name[$i] ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

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

                            <button type="submit" class="btn btn-primary btn-sm" id="filterSubmitBtn">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-info">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <h3 class="mb-1"><strong>LAPORAN STOK CUSTOMER</strong></h3>
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
                                    <th>Nama Customer</th>
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
                                        <td><?= $item->nama_cust ?></td>
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
                                            <?php if (empty($item->stok_awal) || $item->stok_awal == 0): ?>
                                                <div class="badge badge-warning" style="display: inline-block; padding: 8px; font-size: 11px;">
                                                    <i class="fas fa-exclamation-triangle"></i> Data belum Valid
                                                </div>
                                                <div style="font-size: 10px; margin-top: 4px; color: #b8860b;">
                                                    Hubungi tim Operasional
                                                </div>
                                            <?php else: ?>
                                                <a href="<?= base_url('adm/Stok/detail_customer/' . $item->id . '/' . $tahun_filter . '/' . $bulan_filter) ?>" class="btn btn-sm btn-info js-loading-link" data-loading-title="Membuka detail customer" data-loading-text="Sistem sedang mengambil rincian toko untuk <?= htmlspecialchars($item->nama_cust, ENT_QUOTES, 'UTF-8') ?>.">
                                                    Detail <i class="fas fa-arrow-circle-right"></i>
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
                        <i class="fas fa-info-circle"></i> Tidak ada data customer untuk periode yang dipilih.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
    (function() {
        var overlay = document.getElementById('stockLoadingOverlay');
        var title = document.getElementById('stockLoadingTitle');
        var text = document.getElementById('stockLoadingText');
        var filterForm = document.getElementById('filterForm');
        var filterSubmitBtn = document.getElementById('filterSubmitBtn');

        function showStockLoading(customTitle, customText) {
            title.textContent = customTitle || 'Mengambil data stok';
            text.textContent = customText || 'Sistem sedang menyiapkan laporan. Mohon tunggu sebentar.';
            overlay.classList.add('is-visible');
            overlay.setAttribute('aria-hidden', 'false');
        }

        if (filterForm) {
            filterForm.addEventListener('submit', function() {
                showStockLoading(
                    'Mengambil laporan customer',
                    'Filter periode sedang diproses dan data stok sedang dihitung.'
                );

                if (filterSubmitBtn) {
                    filterSubmitBtn.disabled = true;
                    filterSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses';
                }
            });
        }

        document.querySelectorAll('.js-loading-link').forEach(function(link) {
            link.addEventListener('click', function() {
                showStockLoading(
                    link.getAttribute('data-loading-title'),
                    link.getAttribute('data-loading-text')
                );
                link.classList.add('disabled');
                link.setAttribute('aria-disabled', 'true');
                link.innerHTML = 'Membuka <i class="fas fa-spinner fa-spin"></i>';
            });
        });
    })();
</script>
