<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-truck"></i> Detail Pengiriman</h3>
        <div class="card-tools">
          <a href="<?= base_url('adm/Pengiriman') ?>" type="button" class="btn btn-tool">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="callout callout-info">
          <h5><i class="fas fa-store"></i> Nama Toko:</h5>
          <div class="row">
            <div class="col-md-4">
              <strong><?= $pengiriman->nama_toko; ?></strong>
            </div>
            <div class="col-md-4">
              No. Pengiriman : <strong><?= $pengiriman->id; ?></strong> <br>
              No. Permintaan : <strong><?= $pengiriman->id_permintaan; ?></strong>
            </div>
            <div class="col-md-4">
              Tgl Dibuat : <strong><?= date('d-M-Y H:i:s', strtotime($pengiriman->created_at)) ?></strong> <br>
              Tgl Terima : <strong><?= $pengiriman->tgl_terima ? date('d-M-Y H:i:s', strtotime($pengiriman->tgl_terima)) : '-' ?></strong> <br>
              <strong><?= status_pengiriman($pengiriman->status) ?></strong>

            </div>
          </div>
        </div>
        <hr>

        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Artikel #</th>
              <th>Deskripsi</th>
              <th class="text-center">Jml Kirim</th>
              <th class="text-center">Jml Terima </th>
              <th class="text-center">Selisih </th>
            </tr>
          </thead>
          <tbody>
            <?php
            $total = $total_t = $total_s = 0;
            foreach ($detail as $no => $d) :
            ?>
              <tr>
                <td class="text-center"><?= ++$no ?></td>
                <td><?= $d->kode ?></td>
                <td><small><?= $d->nama_produk ?></small></td>
                <td class="text-center"><?= $d->qty ?></td>
                <td class="text-center"><?= ($pengiriman->status <= 1) ? '<small>Belum diterima</small>' : $d->qty_diterima ?></td>
                <td class="text-center <?= ($d->qty != $d->qty_diterima && $pengiriman->status > 1) ? 'bg-warning' : '' ?>"><?= ($pengiriman->status <= 1) ? '<small>Belum diterima</small>' : $d->qty_diterima - $d->qty ?></td>
              </tr>
            <?php
              $total += $d->qty;
              $total_t += $d->qty_diterima;
              $total_s += ($pengiriman->status <= 1) ? 0 : $d->qty_diterima - $d->qty;
            endforeach;
            ?>
          </tbody>

          <tfoot>
            <tr>
              <td colspan="3" align="right"> <strong>Total :</strong> </td>
              <td class="text-center"><strong><?= number_format($total); ?></strong></td>
              <td class="text-center"><strong><?= ($pengiriman->status <= 1) ? '<small>Belum diterima</small>' : number_format($total_t); ?></strong></td>
              <td class="text-center"><strong><?= ($pengiriman->status <= 1) ? '<small>Belum diterima</small>' : number_format($total_s); ?></strong></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</section>