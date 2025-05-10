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
        <!-- print area -->
        <div id="printableArea">
          <div class="invoice p-3 mb-3">
            <!-- Detail -->
            <hr>
            <form action="<?= base_url('leader/Permintaan/approve') ?>" method="POST" id="form_po">
              <input type="hidden" name="id_minta" value="<?= $permintaan->id ?>">
              <div class="row">
                <div class="col-12 table-responsive d-none d-md-block">
                  <table class="table table-striped tabel_po">
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
                      <?php
                      $no = 0;
                      $total = 0;
                      foreach ($detail_permintaan as $d) {
                        $no++;
                        $id_toko = $permintaan->id_toko;
                        $id_produk = $d->id_produk;
                        $query = $this->db->query("SELECT tb_stok.qty AS stok FROM tb_stok JOIN tb_permintaan ON tb_permintaan.id_toko = tb_stok.id_toko JOIN tb_permintaan_detail ON tb_permintaan_detail.id_produk = tb_stok.id_produk WHERE tb_stok.id_produk = $id_produk AND tb_stok.id_toko = $id_toko");
                        $stok = ($query->num_rows() > 0) ? $query->row()->stok : 0;
                      ?>
                        <tr>
                          <td><?= $no ?></td>
                          <td><strong><?= $d->kode_produk; ?></strong><br><?= $d->nama_produk; ?></td>
                          <td><?= $stok; ?></td>
                          <td><input type="number" class="form-control form-control-sm" name="qty_acc[]" min="0" value="<?= $d->qty; ?>" required><input type="hidden" name="id_detail[]" value="<?= $d->id; ?>"></td>
                          <td class="text-center"><?= $d->keterangan; ?></td>
                          <td class="text-center"><a href="#" class="text-danger btn-delete" data-id="<?= $d->id ?>"><i class="far fa-trash-alt"></i></a></td>
                        </tr>
                      <?php
                        $total += $d->qty;
                      }
                      ?>
                    </tbody>
                  </table>
                </div>

                <!-- MOBILE CARD LIST VIEW -->
                <div class="card-mobile-list d-block d-md-none w-100">
                  <?php
                  foreach ($detail_permintaan as $d) :
                    $id_toko = $permintaan->id_toko;
                    $id_produk = $d->id_produk;
                    $query = $this->db->query("SELECT tb_stok.qty AS stok FROM tb_stok JOIN tb_permintaan ON tb_permintaan.id_toko = tb_stok.id_toko JOIN tb_permintaan_detail ON tb_permintaan_detail.id_produk = tb_stok.id_produk WHERE tb_stok.id_produk = $id_produk AND tb_stok.id_toko = $id_toko");
                    $stok = ($query->num_rows() > 0) ? $query->row()->stok : 0;
                  ?>
                    <div class="card mb-3 shadow-sm">
                      <div class="card-body p-3">
                        <div class="d-flex justify-content-between">
                          <strong><?= $d->nama_produk ?></strong>
                          <a href="#" class="text-danger btn-delete" data-id="<?= $d->id ?>"><i class="far fa-trash-alt"></i></a>
                        </div>
                        <small class="text-muted">Kode: <?= $d->kode_produk ?></small>
                        <p class="mb-1">Stok: <?= $stok ?></p>
                        <div class="form-group mb-2">
                          <label class="small mb-1">Qty *</label>
                          <input type="number" class="form-control form-control-sm" name="qty_acc[]" min="0" value="<?= $d->qty; ?>" required>
                          <input type="hidden" name="id_detail[]" value="<?= $d->id; ?>">
                        </div>
                        <p class="mb-0"><small>Keterangan:</small> <?= $d->keterangan ?></p>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>

                <!-- FORM -->
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
        <!-- end print area -->
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

<!-- CSS -->
<style>
  .card-mobile-list .card {
    border-radius: 10px;
    border: 1px solid #ddd;
  }

  .card-mobile-list .card-body {
    font-size: 14px;
    padding: 10px;
  }

  @media (max-width: 767px) {
    .table-responsive {
      display: none;
    }

    .card-mobile-list {
      display: block;
    }
  }

  @media (min-width: 768px) {
    .card-mobile-list {
      display: none;
    }
  }

  .btn-sm {
    font-size: 0.85rem;
    padding: 4px 8px;
  }

  .is-invalid {
    border-color: red;
  }
</style>