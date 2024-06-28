<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="info-box bg-info shadow-sm">
                    <span class="info-box-icon bg-white"><i class="fas fa-box text-info"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Artikel</span>
                        <span class="info-box-number"><?= $artikel->total ? number_format($artikel->total) : "Kosong" ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="info-box bg-info shadow-sm">
                    <span class="info-box-icon bg-white"><i class="fas fa-chart-pie text-info"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Stok</span>
                        <span class="info-box-number"><?= $artikel->stok ? number_format($artikel->stok) : "Kosong" ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> <i class="fas fa-chart-pie"></i> Data Stok Per Artikel</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width:3%">#</th>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Nama Artikel</th>
                                    <th class="text-center">Total Stok</th>
                                    <th style="width:10%" class="text-center">Menu</th>
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
                                                    <strong><?= $dd->kode ?></strong>
                                                </small>
                                            </td>
                                            <td>
                                                <small><?= $dd->nama_produk ?></small>
                                            </td>
                                            <td class="text-center"><?= $dd->stok ?></td>
                                            <td>
                                                <a href="<?= base_url('leader/Stok/detail/' . $dd->id) ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail</a>
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