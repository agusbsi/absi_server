<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Print - Laporan Stok Pelanggan</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url('assets/css/adminlte.min.css') ?>">
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
            .content {
                margin: 0;
                padding: 20px;
            }
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .print-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }
        .print-header h2 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        .print-header p {
            margin: 2px 0;
            font-size: 12px;
            color: #666;
        }
        .table-print {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }
        .table-print th {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }
        .table-print td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table-print tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
        .table-print .text-center {
            text-align: center;
        }
        .table-print .text-right {
            text-align: right;
        }
        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .print-footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        .button-group {
            margin-bottom: 20px;
            text-align: right;
        }
        .button-group button {
            padding: 8px 15px;
            margin-left: 5px;
            border: 1px solid #ddd;
            background-color: #fff;
            cursor: pointer;
            border-radius: 3px;
            font-size: 12px;
        }
        .button-group button:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="button-group no-print">
        <button onclick="window.print()"><i class="fas fa-print"></i> Print</button>
        <button onclick="window.close()"><i class="fas fa-times"></i> Tutup</button>
    </div>

    <div class="print-header">
        <h2><?= strtoupper($customer->nama_cust) ?></h2>
        <p>Laporan Stok Pelanggan</p>
        <p>Periode: <strong><?= $periode ?></strong></p>
        <p style="margin-top: 10px; font-size: 10px; color: #999;"><?= date('d F Y H:i:s') ?></p>
    </div>

    <table class="table-print">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th>Nama Toko</th>
                <th style="width: 12%">Stok Awal</th>
                <th style="width: 12%">Penjualan</th>
                <th style="width: 12%">Stok Akhir</th>
                <th style="width: 12%">Rasio</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($list_data)): ?>
                <?php
                $no = 0;
                foreach ($list_data as $item):
                    $no++;
                    $rasio = (!empty($item->penjualan) && $item->penjualan != 0) 
                        ? round($item->stok_akhir / $item->penjualan, 2) 
                        : round($item->stok_akhir / 1, 2);
                ?>
                    <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td><?= $item->nama_toko ?></td>
                        <td class="text-right"><?= number_format($item->stok_awal) ?></td>
                        <td class="text-right"><?= number_format($item->penjualan) ?></td>
                        <td class="text-right"><?= number_format($item->stok_akhir) ?></td>
                        <td class="text-right"><?= $rasio ?>x</td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="2" class="text-right">TOTAL</td>
                    <td class="text-right"><?= number_format($total_stok_awal) ?></td>
                    <td class="text-right"><?= number_format($total_penjualan) ?></td>
                    <td class="text-right"><?= number_format($total_stok_akhir) ?></td>
                    <td class="text-right">
                        <?php
                        $total_rasio = (!empty($total_penjualan) && $total_penjualan != 0) 
                            ? round($total_stok_akhir / $total_penjualan, 2) 
                            : round($total_stok_akhir / 1, 2);
                        echo $total_rasio . 'x';
                        ?>
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="print-footer">
        <p>Laporan ini dicetak secara otomatis oleh sistem</p>
    </div>
</body>
</html>
