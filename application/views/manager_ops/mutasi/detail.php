<section class="content">
  <div class="container-fluid">
    <div class="card card-default">
      <form action="<?= base_url('mng_ops/Mutasi/proses_simpan') ?>" method="post" id="form_mutasi">
        <div class="card-header">
          <h3 class="card-title">
            <li class="fas fa-copy"></li> <strong>Data Mutasi</strong>
          </h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>No Mutasi :</label>
                <input type="text" class="form-control form-control-sm" name="id_mutasi" value="<?= $mutasi->id ?>" readonly>
                <input type="hidden" class="form-control form-control-sm" name="id_leader" value="<?= $mutasi->id_user ?>" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Tanggal :</label>
                <input type="text" class="form-control form-control-sm" value="<?= date('d M Y', strtotime($mutasi->created_at)) ?>" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Diajukan Oleh :</label>
                <br>
                [ <?= $mutasi->leader ?> ]
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Status :</label>
                <br>
                <?= status_mutasi($mutasi->status) ?>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Toko Asal :</label>
                <input type="text" class="form-control form-control-sm" value="<?= $mutasi->asal ?>" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Toko tujuan :</label>
                <input type="text" class="form-control form-control-sm" value="<?= $mutasi->tujuan ?>" readonly>
              </div>
            </div>
          </div>
          <hr>
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Artikel</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th style="width:15%" class="text-center">QTY</th>
                <th style="width:15%" class="text-center">QTY Diterima</th>
                <th class="text-center">Menu</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              $total = 0;
              $total_stok = 0;
              $total_t = 0;
              foreach ($detail_mutasi as $d) :
                $no++;
              ?>
                <tr>
                  <td class="text-center"><?= $no ?></td>
                  <td>
                    <small>
                      <strong><?= $d->kode ?></strong> <br>
                      <?= $d->nama_produk ?>
                    </small>
                  </td>
                  <td>
                    <?= $d->satuan ?>
                  </td>
                  <td>
                    <?= $d->stok ?>
                  </td>
                  <td>
                    <input type="number" class="form-control form-control-sm qty-input" name="qty[]" value="<?= $d->qty ?>" max="<?= $d->stok ?>" data-max="<?= $d->stok ?>" required <?= $mutasi->status == 0 ? '' : 'readonly' ?>>
                    <input type="hidden" class="form-control form-control-sm" name="id_detail[]" value="<?= $d->id ?>">
                  </td>
                  <td class="text-center"><?= $mutasi->status != 2 ? '-' : $d->qty_terima ?></td>
                  <td class="text-center">
                    <a href="#" data-id="<?= $d->id ?>" class="text-danger btn-delete <?= $mutasi->status == 0 ? '' : 'd-none' ?>"><i class="fas fa-trash"></i></a>
                  </td>
                </tr>
              <?php
                $total += $d->qty;
                $total_stok += $d->stok;
                $total_t += $d->qty_terima;
              endforeach
              ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" align="right"> <strong>Total</strong> </td>
                <td><?= $total_stok; ?></td>
                <td><span id="total-qty"><?= $total ?></span></td>
                <td class="text-center"><?= $mutasi->status != 2 ? '-' : $total_t ?></td>
                <td></td>
              </tr>
            </tfoot>
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
          <div class="form-group <?= $mutasi->status == 0 ? '' : 'd-none' ?>">
            <label for="">Catatan : *</label>
            <textarea name="catatan" class="form-control form-control-sm" required></textarea>
          </div>
          <div class="form-group <?= $mutasi->status == 0 ? '' : 'd-none' ?>">
            <label for="">Tindakan : *</label>
            <select name="tindakan" class="form-control form-control-sm" required>
              <option value=""> Pilih </option>
              <option value="1"> Setuju </option>
              <option value="3"> Tolak </option>
            </select>
            <small>* Harus di isi.</small>
          </div>
        </div>
        <div class="card-footer">
          <?php if ($mutasi->status == 0) { ?>
            <div class="col-12">
              <a href="<?= base_url('mng_ops/Mutasi') ?>" class="btn btn-danger float-right btn-sm" style="margin-left: 5px;"><i class="fas fa-times-circle"></i> Close </a>
              <button type="submit" class="btn btn-success float-right btn-sm" id="btn_simpan" style="margin-right: 5px;"><i class="fas fa-save"></i> Simpan </button>
            </div>
          <?php } else { ?>
            <a href="<?= base_url('leader/Mutasi/mutasi_print/' . $mutasi->id) ?>" target="_blank" class="btn btn-default float-right btn-sm" style="margin-right: 5px;" title="Print Surat Jalan">
              <i class="fas fa-print"></i> Print
            </a>
            <a href="<?= base_url('mng_ops/Mutasi') ?>" class="btn btn-danger float-right btn-sm" style="margin-right: 5px;"><i class="fas fa-times-circle"></i> Close </a>
          <?php } ?>
        </div>
      </form>
    </div>
  </div>
</section>
<script>
  function validateForm() {
    let isValid = true;
    $('#form_mutasi').find('input[required],select[required],textarea[required]').each(function() {
      if ($(this).val() === '') {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    return isValid;
  }
  $('.btn-delete').click(function(e) {
    var id = $(this).data('id');
    var tr = $(this).closest('tr');
    e.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Artikel ini akan dihapus dari list?",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url() ?>mng_ops/Mutasi/hapus_item",
          method: "POST",
          data: {
            id: id
          },
          success: function(data) {
            tr.find('td').fadeOut(1000, function() {
              tr.remove();
              updateTotalQty();
            });
          }
        });
      }
    })
  })
  $('#btn_simpan').click(function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data Mutasi akan di proses.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        if (validateForm()) {
          document.getElementById("form_mutasi").submit();
        } else {
          Swal.fire({
            icon: 'info',
            title: 'Peringatan !',
            text: 'Semua kolom harus di isi.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        }
      }
    })
  })

  function updateTotalQty() {
    let totalQty = 0;
    document.querySelectorAll('.qty-input').forEach(function(input) {
      totalQty += parseInt(input.value) || 0;
    });
    document.getElementById('total-qty').innerText = totalQty;
  }
  document.querySelectorAll('.qty-input').forEach(function(input) {
    input.addEventListener('input', function() {
      const maxQty = parseInt(this.getAttribute('data-max'));
      const currentQty = parseInt(this.value);

      if (currentQty > maxQty) {
        this.value = maxQty;
        Swal.fire({
          title: 'Peringatan!',
          text: 'Jumlah tidak boleh melebihi stok.',
          icon: 'info',
        });
      }

      updateTotalQty();
    });
  });
  updateTotalQty();
</script>