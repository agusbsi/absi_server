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
            <div class="col-12 table-responsive">
              <table class="table table-striped tabel_po">
                <thead>
                  <tr class="text-center">
                    <th>No</th>
                    <th>Artikel</th>
                    <th>Qty</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  $total = 0;
                  foreach ($detail as $d) :
                    $no++;
                  ?>
                    <tr>
                      <td class="text-center"><?= $no ?></td>
                      <td>
                        <small>
                          <strong><?= $d->kode_produk; ?></strong> <br>
                          <?= $d->nama_produk; ?>
                        </small>
                      </td>
                      <td class="text-center"><?= $d->qty; ?></td>
                      <td class="text-center">
                        <small><?= $d->keterangan; ?></small>
                      </td>
                    </tr>
                  <?php
                    $total += $d->qty;
                  endforeach
                  ?>
                  <tr>
                    <td colspan="2" class="text-right">Total :</td>
                    <td class="text-center"><?= $total ?></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
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
            <!-- <button class="btn btn-warning btn-sm float-right mr-1 <?= $po->status == 2 ? '' : 'd-none' ?>" data-id="<?= $po->id ?>" id="btn_edit" title="Edit PO"><i class="fas fa-edit"></i> Edit</button> -->
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