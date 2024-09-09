<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <li class="fas fa-window-restore"></li> Form Adjusment Stok
                </h3>
                <div class="card-tools">
                    <a href="<?= base_url('mng_ops/Dashboard/adjust_stok') ?>" type="button" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>No SO:</strong>
                            <input type="text" class="form-control form-control-sm" value="1313" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Nama Toko:</strong>
                            <textarea class="form-control form-control-sm" readonly>Toko maju jayadi</textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Tgl SO:</strong>
                            <input type="text" class="form-control form-control-sm" value="1313" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Dibuat:</strong>
                            <input type="text" class="form-control form-control-sm" value="1313" readonly>
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Artikel</th>
                            <th>Stok Sistem</th>
                            <th>SO SPG</th>
                            <th>Selisih</th>
                        </tr>
                    </thead>
                </table>
                <div class="form-group">
                    <strong>Catatan : *</strong>
                    <textarea name="catatan" class="form-control form-control-sm" required placeholder="masukan catatan disini...."></textarea>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="<?= base_url('mng_ops/Dashboard/adjust_stok') ?>" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left"></i> kembali</a>
                <button type="submit" class="btn btn-sm btn-primary" title="kirim"><i class="fas fa-paper-plane"></i> Kirim</button>
            </div>
        </div>
    </div>
</section>