<style>
  @media (max-width: 767.98px) {
    .table thead {
      display: none;
    }

    .table tr.item-row {
      display: block;
      background: #cae1f9;
      border-radius: 8px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
      padding: 5px;
      margin-bottom: 8px;
    }

    .table td {
      display: block;
      text-align: left !important;
      padding: 2px 0;
      border: none;
      border-bottom: 1px solid #eee;
    }

    .table td:last-child {
      border-bottom: none;
    }

    .table td::before {
      content: attr(data-label);
      font-weight: 600;
      display: block;
      font-size: 0.875rem;
      color: #555;
      margin-bottom: 2px;
    }

    .desktop-only {
      display: none;
    }
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="callout callout-info">
          <h5> Nomor PO:</h5>
          <div class="row">
            <div class="col-md-6">
              <strong><?= $permintaan->id ?></strong>
            </div>
            <div class="col-md-6">
              Status : <?= status_permintaan($permintaan->status) ?>
            </div>
          </div>
        </div>
        <div class="invoice p-2 mb-3">
          <form action="<?= base_url('leader/Permintaan/approve') ?>" method="POST" id="form_po">
            <input type="hidden" name="id_minta" value="<?= $permintaan->id ?>">
            <div class="table-responsive" style="overflow-x:auto;">
              <table class="table table-striped table-bordered tabel_po">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Artikel</th>
                    <th>Stok</th>
                    <th class="text-center" style="width: 100px;">Qty *</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Menu</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($detail_permintaan as $index => $d): ?>
                    <tr class="item-row">
                      <td class="desktop-only"><?= $index + 1 ?></td>

                      <!-- Artikel -->
                      <td data-label="Artikel">
                        <strong><?= $d->kode_produk ?></strong><br><?= $d->nama_produk ?>
                      </td>

                      <!-- Stok -->
                      <td data-label="Stok"><?= $d->stok ?: "-" ?></td>

                      <!-- Qty -->
                      <td data-label="Qty *">
                        <input type="hidden" name="id_detail[]" value="<?= $d->id ?>">
                        <input type="number" class="form-control form-control-sm" name="qty_acc[]" value="<?= $d->qty ?>" required>
                      </td>

                      <!-- Keterangan -->
                      <td class="text-center" data-label="Keterangan"><?= $d->keterangan ?></td>

                      <!-- Menu -->
                      <td class="text-center" data-label="Menu">
                        <a href="#" class="text-danger btn-delete" data-id="<?= $d->id ?>"><i class="far fa-trash-alt"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>

              </table>
            </div>
            <!-- FORM CATATAN -->
            <div class="col-12">
              <hr>
              <div class="form-group">
                <label>Catatan *</label>
                <textarea name="catatan_leader" class="form-control form-control-sm" rows="3" required placeholder="Catatan ..."></textarea>
                <small>* Harus di isi</small>
              </div>

              <div class="form-group">
                <label><strong>Tindakan</strong></label>
                <select name="tindakan" class="form-control form-control-sm" required>
                  <option value="">- Pilih Tindakan -</option>
                  <option value="1"> Setujui </option>
                  <option value="2"> Tolak </option>
                </select>
              </div>
              <hr>
            </div>

            <!-- BUTTON -->
            <div class="row no-print">
              <div class="col-12">
                <a href="<?= base_url('leader/permintaan') ?>" class="btn btn-danger float-right btn-sm" style="margin-right: 5px;"><i class="fas fa-times"></i> Close</a>
                <button type="submit" id="btn-kirim" class="btn btn-success float-right btn-sm" style="margin-right: 5px;"><i class="fas fa-save"></i> Simpan </button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- SCRIPTS -->
<script>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  }

  $(document).ready(function() {
    function validateForm() {
      let isValid = true;
      $('#form_po').find('input[required], select[required], textarea[required]').each(function() {
        if ($(this).val() === '') {
          isValid = false;
          $(this).addClass('is-invalid');
        } else {
          $(this).removeClass('is-invalid');
        }
      });
      return isValid;
    }

    $('#btn-kirim').click(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data PO Barang akan diproses.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Yakin'
      }).then((result) => {
        if (result.isConfirmed) {
          if (validateForm()) {
            document.getElementById("form_po").submit();
          } else {
            Swal.fire({
              title: 'Belum Lengkap',
              text: 'Semua kolom wajib diisi.',
              icon: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            });
          }
        }
      })
    })

    $('.btn-delete').click(function(e) {
      var id = $(this).data('id');
      var tr = $(this).closest('tr');
      e.preventDefault();
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Barang ini akan dihapus dari list?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Hapus'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= base_url() ?>leader/Permintaan/hapus_item",
            method: "POST",
            data: {
              id: id
            },
            success: function(data) {
              location.reload();
            }
          });
        }
      })
    })
  });
</script>