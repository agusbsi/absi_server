<style>
  /* Default: desktop tampilkan table, sembunyikan card */
  .card-mobile {
    display: none;
  }

  /* Untuk layar max 767px (mobile) */
  @media (max-width: 767.98px) {
    .table-desktop {
      display: none !important;
    }

    .card-mobile {
      display: block !important;
    }
  }

  /* Optional styling cards */
  .card {
    border-radius: 0.5rem;
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="callout callout-info">
          <h5> Nomor Po :</h5>
          <div class="row">
            <div class="col-md-6">
              <strong><?= $po->id ?></strong>
            </div>
            <div class="col-md-6">
              Status : <?= status_permintaan($po->status) ?>
            </div>
          </div>
        </div>
        <!-- print area -->
        <div id="printableArea">
          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <div class="col-12">

              <!-- VERSI TABLE UNTUK DESKTOP -->
              <div class="table-desktop">
                <table class="table table-striped tabel_po">
                  <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Artikel</th>
                      <th>Stok</th>
                      <th>Jml Minta</th>
                      <th>Jml Acc</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 0;
                    $total_minta = 0;
                    $total_acc = 0;

                    foreach ($detail as $d) :
                      $no++;
                      $total_minta += (int)$d->qty;
                      $total_acc += (int)$d->qty_acc;
                    ?>
                      <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td>
                          <small>
                            <strong><?= htmlspecialchars($d->kode_produk); ?></strong><br>
                            <?= htmlspecialchars($d->nama_produk); ?>
                          </small>
                        </td>
                        <td class="text-center"><?= $d->stok !== null ? $d->stok : '-' ?></td>
                        <td class="text-center"><?= $d->qty ?></td>
                        <td class="text-center"><?= $d->qty_acc ?></td>
                        <td class="text-center">
                          <small><?= htmlspecialchars($d->keterangan); ?></small>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <tr class="font-weight-bold bg-light">
                      <td colspan="3" class="text-right">Total :</td>
                      <td class="text-center"><?= $total_minta ?></td>
                      <td class="text-center"><?= $total_acc ?></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- VERSI CARD UNTUK MOBILE -->
              <div class="card-mobile">
                <?php
                $no = 0;
                $total_minta_mobile = 0;
                $total_acc_mobile = 0;

                foreach ($detail as $d) :
                  $no++;
                  $total_minta_mobile += (int)$d->qty;
                  $total_acc_mobile += (int)$d->qty_acc;
                ?>
                  <div class="card mb-3 shadow-sm">
                    <div class="card-body p-2">
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="font-weight-bold">No: <?= $no ?></span>
                        <span><small>Stok: <?= $d->stok !== null ? $d->stok : '-' ?></small></span>
                      </div>
                      <h6 class="card-title mb-1"><strong><?= htmlspecialchars($d->kode_produk); ?></strong></h6>
                      <p class="card-text mb-1"><?= htmlspecialchars($d->nama_produk); ?></p>
                      <div class="d-flex justify-content-between">
                        <small>Jml Minta: <span class="font-weight-bold"><?= $d->qty ?></span></small>
                        <small>Jml Acc: <span class="font-weight-bold"><?= $d->qty_acc ?></span></small>
                      </div>
                      <small class="text-muted d-block mt-1">Keterangan: <?= htmlspecialchars($d->keterangan); ?></small>
                    </div>
                  </div>
                <?php endforeach; ?>
                <div class="card bg-light p-2">
                  <div class="d-flex justify-content-between font-weight-bold">
                    <span>Total :</span>
                    <span>Jml Minta: <?= $total_minta_mobile ?></span>
                    <span>Jml Acc: <?= $total_acc_mobile ?></span>
                  </div>
                </div>
              </div>

              <hr>
              # Proses Pengajuan :
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

              <hr>
            </div>

            <a href="<?= base_url('leader/Permintaan') ?>" class="btn btn-sm btn-danger float-right"><i class="fas fa-times-circle"></i> Tutup</a>
            <br>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $('#btn_edit').click(function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    Swal.fire({
      title: 'YAKIN EDIT DATA PO ?',
      text: "Status Data PO akan di kembalikan ke TIM Leader.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "<?= base_url('leader/Permintaan/edit/') ?>" + id;
      }
    })
  })
</script>