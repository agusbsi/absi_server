<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($title_pdf); ?></title>
    <style>
        #table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }

        #table thead {
            display: table-header-group;
        }

        #table tr {
            page-break-inside: avoid;
        }

        .empty-row {
            color: #777;
            text-align: center;
            padding: 24px 8px !important;
        }

        #footer {
            position: fixed;
            right: 0px;
            bottom: 10px;
            text-align: center;
            border-top: 1px solid black;
        }

        #footer .page:after {
            content: counter(page, decimal);
        }

        @page {
            margin: 20px 30px 40px 50px;
        }
    </style>
</head>

<body>
    <div style="text-align:center">
        <h3 style="margin-bottom:5px">FORMAT STOK OPNAME</h3>
        <strong>Periode <?= date('m-Y') ?></strong>

    </div>
    <div class="col-md-12">
        <div><strong>Nama Toko :</strong> <?= html_escape($data_toko->nama_toko) ?></div>
        <div><strong>SPG :</strong> <?= html_escape($data_toko->nama_user) ?></div>
    </div>
    <hr>
    <table id="table">
        <thead>
            <tr style="text-align:center">
                <th>No.</th>
                <th>Artikel</th>
                <th>Satuan</th>
                <th>Stok Fisik</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            if (!empty($stok)) :
            foreach ($stok as $s) :
                $no++
            ?>
                <tr>
                    <td scope="row" style="text-align:center"><?= $no ?></td>
                    <td>
                        <small>
                            <strong><?= html_escape($s->kode) ?></strong> <br>
                            <?= html_escape($s->nama_produk) ?>
                        </small>
                    </td>
                    <td style="text-align:center"><?= html_escape($s->satuan) ?></td>
                    <td style="text-align:center">...</td>
                </tr>
            <?php endforeach; else : ?>
                <tr><td colspan="4" class="empty-row">Tidak ada produk dengan stok aktif di toko ini.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div id="footer">
        <p class="page"> Halaman </p>
    </div>
</body>

</html>
