<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box bg-info shadow-sm">
                    <span class="info-box-icon bg-white"><i class="fas fa-hospital text-info"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Customer</span>
                        <span class="info-box-number"><?= $cust->total ? number_format($cust->total) : "Kosong" ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box bg-info shadow-sm">
                    <span class="info-box-icon bg-white"><i class="fas fa-chart-pie text-info"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Stok</span>
                        <span class="info-box-number"><?= $stok->total ? number_format($stok->total) : "Kosong" ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box bg-info shadow-sm" title="Rasio berdasarkan total stok akhir / total penjualan">
                    <span class="info-box-icon bg-white"><i class="fas fa-scroll text-info"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Stok Rasio</span>
                        <span class="info-box-number">
                            <?php
                            if ($jual->total != 0) {
                                echo round($stok->stok_akhir / $jual->total, 2);
                            } else {
                                echo "Kosong";
                            }
                            ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> <i class="fas fa-chart-pie"></i> Data Stok Per Customer</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="width:3%">#</th>
                                    <th rowspan="2" style="width:30%;" class="text-center">Customer </th>
                                    <th colspan="4" class="text-center">Total</th>
                                    <th rowspan="2" class="text-center">Stok Rasio </th>
                                    <th rowspan="2" class="text-center">Menu </th>
                                </tr>
                                <tr>
                                    <th class="text-center">Toko</th>
                                    <th class="text-center">
                                        Penjualan <br>
                                        <small> ( <?= (new DateTime('first day of -2 month'))->format('M-Y') ?> )</small>
                                    </th>
                                    <th class="text-center">
                                        Stok Akhir <br>
                                        <small> ( <?= (new DateTime('first day of -1 month'))->format('M-Y') ?> )</small>
                                    </th>
                                    <th class="text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if (is_array($list_data)) { ?>
                                        <?php
                                        $no = 0;
                                        foreach ($list_data as $dd) :
                                            $no++; ?>
                                            <td><?= $no ?></td>
                                            <td>
                                                <small>
                                                    <strong><?= $dd->nama_cust ?></strong> <br>
                                                    Alamat : <?= $dd->alamat_cust ?>
                                                </small>
                                            </td>
                                            <td class="text-center"><?= $dd->t_toko ?></td>
                                            <td class="text-center"><?= number_format($dd->t_jual) ?></td>
                                            <td class="text-center"><?= number_format($dd->t_akhir) ?></td>
                                            <td class="text-center"><?= number_format($dd->t_stok) ?></td>
                                            <td class="text-center"> <?= (!empty($dd->t_jual) && $dd->t_jual != 0) ? ROUND($dd->t_akhir / $dd->t_jual, 2) : ROUND($dd->t_akhir / 1, 2) ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm"> Lihat</button>
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu" style="">
                                                        <a class="dropdown-item" href="<?= base_url('adm/Stok/detail_toko/' . $dd->id) ?>">Per Toko</a>
                                                        <a class="dropdown-item" href="<?= base_url('adm/Stok/detail_artikel/' . $dd->id) ?>">Per Artikel</a>
                                                    </div>
                                                </div>
                                            </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php } ?>

                            </tbody>

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>