<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <form action="<?= base_url('spv/Toko/saveTutup'); ?>" method="post" id="form_tutup">
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-store"></i> Form Tutup Toko</h3>
              <div class="card-tools">
                <a href="<?= base_url('spv/Toko/pengajuanToko') ?>"><i class="fas fa-times-circle"></i></a>
              </div>
            </div>
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-md-4">
                  <label for="id_toko">Pilih Toko *</label>
                </div>
                <div class="col-md-4">
                  <select name="id_toko" id="id_toko" class="form-control form-control-sm select2" required>
                    <option value="">- Pilih Toko -</option>
                    <?php foreach ($list_toko as $dt) : ?>
                      <option value="<?= $dt->id ?>"><?= $dt->nama_toko ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-md-4">
                  <label for="tgl_tarik">Tanggal *</label>
                </div>
                <div class="col-md-4">
                  <input type="date" name="tgl_tarik" id="tgl_tarik" class="form-control form-control-sm" autocomplete="off" min="<?= date('Y-m-d') ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label for="catatan">Alasan Tutup: *</label>
                <textarea name="catatan" class="form-control form-control-sm" rows="5" required></textarea>
                <small>Harus di isi.</small>
              </div>
              <hr>
              <p># List Barang</p>
              <div style="max-height: 300px; overflow-y: auto;">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Artikel</th>
                      <th class="text-center">Stok Sistem</th>
                    </tr>
                  </thead>
                  <tbody id="body_hasil"></tbody>
                </table>
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary btn-sm btn_kirim"><i class="fas fa-paper-plane"></i> Ajukan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<script src="<?= base_url('') ?>assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script src="<?= base_url('') ?>assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<script>
  $(document).ready(function() {
    $("#id_toko").change(function() {
      var id_toko = $(this).val();
      var loadingHtml = '<tr><td colspan="3" class="text-center">Loading...</td></tr>';

      if (id_toko === "") {
        $("#body_hasil").html('');
      } else {
        // Tampilkan loading indicator
        $("#body_hasil").html(loadingHtml);

        $.ajax({
          url: "<?php echo base_url('spv/Toko/artikelToko'); ?>",
          type: "GET",
          dataType: "json",
          data: {
            id_toko: id_toko
          },
          success: function(data) {
            var html = '';
            var totalQtyArtikel = 0;

            if (data.artikel.length === 0) {
              html += '<tr><td colspan="3" class="text-center">ARTIKEL KOSONG</td></tr>';
            } else {
              $.each(data.artikel, function(i, item) {
                html += `<tr>
              <td class="text-center">${i + 1}</td>
              <td><small><strong>${item.kode}</strong><br>${item.nama_produk}</small></td>
              <td class="text-center">${item.qty}
              <input type="hidden" name="id_produk[]" value="${item.id_produk}"/>
              <input type="hidden" name="qty_retur[]" value="${item.qty}"/>
              </td>
            </tr>`;
                totalQtyArtikel += parseInt(item.qty);
              });

              html += `<tr>
            <td colspan="2" class="text-right"><strong>Total</strong></td>
            <td class="text-center"><strong>${totalQtyArtikel}</strong></td>
          </tr>`;
            }
            $("#body_hasil").html(html);
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $("#body_hasil").html('<tr><td colspan="3" class="text-center text-danger">Terjadi kesalahan. Coba lagi.</td></tr>');
          }
        });
      }
    });


    function validateForm() {
      let isValid = true;
      $('#form_tutup').find('input[required], select[required], textarea[required]').each(function() {
        if ($(this).val() === '') {
          isValid = false;
          $(this).addClass('is-invalid');
        } else {
          $(this).removeClass('is-invalid');
        }
      });
      return isValid;
    }

    $('.btn_kirim').click(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data Pengajuan Tutup Toko akan di proses",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Yakin'
      }).then((result) => {
        if (result.isConfirmed) {
          if (validateForm()) {
            document.getElementById("form_tutup").submit();
          } else {
            Swal.fire({
              title: 'Belum Lengkap',
              text: 'Semua kolom harus di isi.',
              icon: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            });
          }
        }
      });
    });
  });
</script>