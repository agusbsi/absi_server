<section>
  <div class="container-fluid">
    <div class="card card-info">
      <form method="POST" action="<?= base_url('sup/permintaan/approve') ?>" id="form_po">
        <div class="card-header">
          <h3 class="card-title"><i class="nav-icon fas fa-file"></i> Detail Permintaan</h3>
          <div class="card-tools">
            <a href="<?= base_url('sup/Permintaan') ?>" type="button" class="btn btn-tool">
              <i class="fas fa-times"></i>
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>No PO :</label>
                <input type="text" class="form-control form-control-sm" name="permintaan" value="<?= $permintaan->id ?>" readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Nama Toko :</label>
                <input type="text" class="form-control form-control-sm" name="toko" value="<?= $permintaan->nama_toko ?>" readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Status :</label> <br>
                <?= status_permintaan($permintaan->status); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Nama SPG :</label>
                <input type="text" class="form-control form-control-sm" name="spg" value="<?= $permintaan->spg ?>" readonly>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label>Alamat Toko :</label> <br>
                <address>
                  <small><?= $permintaan->alamat ?></small>
                </address>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12 table-responsive">
              <table class="table table-bordered table-striped" id="myTable">
                <thead>
                  <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2" class="text-center" style="width: 27%;">Artikel #</th>
                    <th rowspan="2" class="text-center">Stok</th>
                    <th colspan="2" class="text-center">Jumlah</th>
                    <th rowspan="2" class="text-center">Harga</th>
                    <th rowspan="2" class="text-center">Total</th>
                    <th rowspan="2" class="text-center">Keterangan</th>
                    <th rowspan="2" class="text-center">Menu</th>
                  </tr>
                  <tr>
                    <th class="text-center">Minta</th>
                    <th class="text-center" style="width: 12%;">ACC</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $no = 0;
                  $total_qty = 0;
                  foreach ($detail_permintaan as $d) {
                    $no++;
                    $total = 0;
                    $grandtotal = 0;
                    $hrg_produk = 0;
                    $qty_barang = $d->qty;
                    if ($d->het != 1) {
                      $hrg_produk = $d->het_indobarat;
                    } else {
                      $hrg_produk = $d->het_jawa;
                    }
                    $total = $hrg_produk * $qty_barang;
                    $total_qty += $qty_barang;
                    $grandtotal += $total;
                  ?>
                    <tr>
                      <td class="text-center"><?= $no ?></td>
                      <td>
                        <b><?= $d->kode ?></b> <br>
                        <small><?= $d->nama_produk ?></small>
                        <input type="hidden" name="id_detail[]" value="<?= $d->id ?>">
                      </td>
                      <td class="text-center">
                        <?= $d->stok ?>
                      </td>
                      <td class="text-center">
                        <?= $d->qty ?>
                      </td>
                      <td class="text-center">
                        <input type="text" name="qty_acc[]" class="form-control form-control-sm" value="<?= $d->qty ?>" required>
                        <!-- <select name="qty_acc[]" class="form-control form-control-sm" required>
                          <option value="">Pilih</option>
                          <option value="0">0</option>
                          <?php for ($i = 1; $i <= 10; $i++) {
                            $qty = $d->packing * $i; ?>
                            <option value="<?= $qty ?>" <?= $qty == $d->qty ? 'selected' : '' ?>><?= $qty ?></option>
                          <?php } ?>
                        </select> -->
                      </td>
                      <td class="text-center">
                        <input type="text" name="hrg_produk[]" class="form-control form-control-sm" readonly="" value="<?= $hrg_produk; ?>" style="width: 85px;">
                      </td>
                      <td class="text-center">
                        <input type="text" name="total[]" readonly="" class="form-control form-control-sm" value="<?= $hrg_produk * $d->qty ?>" style="width: 110px;">
                      </td>
                      <td class="text-center">
                        <small><?= $d->keterangan ?></small>
                      </td>
                      <td class="text-center">
                        <button class="btn btn-danger btn-sm btn-delete " type="button" data-id="<?= $d->id ?>"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5"><button type="button" class="btn btn-primary btn-sm <?= $permintaan->status == 1 ? '' : 'd-none' ?>" data-toggle="modal" data-target="#formTambah"><i class="fas fa-plus"></i> Tambah Artikel</button></td>
                    <td class="text-right">GrandTotal :</td>
                    <td>
                      <div id="grandTotal"></div>
                    </td>
                    <td></td>
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
                          <?= date('d-M-Y  H:m:s', strtotime($h->tanggal)) ?> <br>
                          Catatan :<br>
                          <?= $h->catatan ?>
                        </small>
                      </div>
                    </div>
                  </div>
                <?php endforeach ?>
              </div>
              <hr>
              <div class="form-group">
                <label for="Catatan Leader:">Catatan MV:</label>
                <textarea name="catatan_mv" class="form-control form-control-sm" placeholder="Catatan MV...."></textarea>
                <small>Optional : Tambahkan catatan jika ada.</small>
              </div>
              <div class="form-group">
                <strong>Tindakan :</strong>
                <select name="tindakan" class="form-control form-control-sm" required>
                  <option value="">- Pilih Tindakan -</option>
                  <option value="1"> Setujui </option>
                  <option value="2"> Tunda </option>
                  <option value="3"> Tolak </option>
                </select>
              </div>
              <hr>

            </div>
          </div>
          <input type="hidden" name="id_permintaan" value="<?= $permintaan->id ?>">
          <?php date_default_timezone_set('Asia/Jakarta'); ?>
        </div>
        <div class="card-footer">
          <a href="<?= base_url('sup/Permintaan') ?>" class="btn btn-danger btn-sm float-right"><i class='fas fa-times-circle'></i> Tutup </a>
          <button type='submit' class='btn btn-success btn-sm float-right btn_approve mr-1'><i class='fa fa-save'></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</section>
<div class="modal fade" id="formTambah" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Artikel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('sup/Permintaan/tambah_item') ?>" method="POST">
          <div class="form-group">
            <label>Pilih Artikel</label>
            <select name="id_produk" id="pilih_produk" class="form-control form-control-sm select2" required>
              <option>-- Pilih Produk --</option>
              <?php foreach ($list_produk as $lp) { ?>
                <option value="<?= $lp->id_produk ?>" data-stok="<?= $lp->qty ?>" data-satuan="<?= $lp->satuan ?>"><?= $lp->kode ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Stok di toko</label>
            <input type="text" id="stok" class="form-control form-control-sm" disabled>
          </div>
          <div class="form-group">
            <label>Satuan</label>
            <input type="text" id="satuan" class="form-control form-control-sm" disabled>
          </div>
          <div class="form-group">
            <label>Qty</label>
            <input type="number" name="qty" class="form-control form-control-sm" required>
            <input type="hidden" name="id_permintaan" value="<?= $permintaan->id ?>" class="form-control">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Tambah</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/app/js/alert.js"></script>
<!-- Tambahkan script ini di bagian head atau sebelum penutup tag body -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Fungsi untuk memformat angka ke format Rupiah
    function formatRupiah(angka) {
      return `Rp ${angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
    }

    // Fungsi untuk menghitung total dan memformat input
    function updateTotals(inputs, grandTotalElement) {
      var grandTotal = 0;

      inputs.forEach(function(input) {
        var value = parseInt(input.value.replace(/\D/g, ''), 10) || 0;
        grandTotal += value;
        input.value = formatRupiah(value);
      });

      grandTotalElement.textContent = formatRupiah(grandTotal);
    }

    // Ambil semua elemen input qty_acc dan terapkan event listener
    var qtyAccInputs = document.querySelectorAll('input[name="qty_acc[]"]');
    qtyAccInputs.forEach(function(input) {
      input.addEventListener("input", function() {
        var parentRow = input.closest("tr");
        var hrgProdukValue = parseInt(parentRow.querySelector('input[name="hrg_produk[]"]').value, 10) || 0;
        var totalInput = parentRow.querySelector('input[name="total[]"]');
        var total = parseInt(input.value, 10) * hrgProdukValue;
        totalInput.value = formatRupiah(total);
        updateTotals(document.querySelectorAll('input[name="total[]"]'), document.getElementById("grandTotal"));
      });
    });

    // Ambil semua elemen input total dan terapkan format Rupiah
    updateTotals(document.querySelectorAll('input[name="total[]"]'), document.getElementById("grandTotal"));
  });
</script>
<script>
  $(document).ready(function() {
    function validateForm() {
      let isValid = true;
      // Get all required input fields
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
    $('.btn_approve').click(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data PO Barang akan di proses",
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
              text: ' Semua kolom  harus di isi.',
              icon: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            });
          }
        }
      })
    })

  });

  $('.btn-delete').click(function(e) {
    var id = $(this).data('id');
    var tr = $(this).closest('tr');
    e.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Barang ini akan dihapus dari list?",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url() ?>sup/Permintaan/hapus_item",
          method: "POST",
          data: {
            id: id
          },
          success: function(data) {
            tr.find('td').fadeOut(1000, function() {
              tr.remove();
            });
          }
        });
      }
    })
  })

  $('#pilih_produk').change(function(e) {
    var stok = $(this).find(':selected').data('stok');
    var satuan = $(this).find(':selected').data('satuan');
    $('#stok').val(stok);
    $('#satuan').val(satuan);
  })
</script>