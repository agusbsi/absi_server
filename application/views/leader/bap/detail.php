<style>
  .judul {
    display: flex;
    justify-content: space-between;
    background-color: #17a2b8;
    color: #f4f6f9;
    padding: 2px 10px 2px 10px;
    border-radius: 10px;
    align-items: center;
    margin-bottom: 20px;
  }

  .cardArtikel {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    margin-bottom: 20px;
    padding: 10px;
  }

  .cardArtikel strong {
    font-size: 16px;
    font-weight: bold;
    display: block;
  }

  .cardArtikel small {
    margin-bottom: 10px;
    display: block;
  }

  .perbaikan {
    display: flex;
    justify-content: flex-start;
    gap: 20px;
  }
</style>
<section class="content">
  <div class="container-fluid mb-5">
    <div class="callout callout-info">
      <h5><i class="fas fa-info"></i> BAP :</h5>
      <div class="row">
        <div class="col-md-3">
          <strong>Nomor : </strong> <br>
          <?= $bap->nomor ? $bap->nomor : "-" ?>
        </div>
        <div class="col-md-4">
          <strong>Toko : </strong> <br>
          <small><?= $bap->nama_toko ?></small>
        </div>
        <div class="col-md-3">
          <strong>Status : </strong> <br>
          <small><?= status_bap($bap->status) ?></small>
        </div>
        <div class="col-md-2">
          <strong>Tanggal : </strong> <br>
          <small><?= date('d F Y', strtotime($bap->created_at)) ?></small>
        </div>
      </div>
    </div>
    <?php $no = 0;
    foreach ($detail_bap as $d): $no++; ?>
      <div class="cardArtikel">
        <strong><?= $no ?> | <?= $d->kode ?></strong>
        <small><?= $d->artikel ?></small>
        <div class="form-group mt-1">
          <input type="text" class="form-control form-control-sm" value="<?= $d->kategori ?>" readonly>
        </div>
        <div class="perbaikan">
          <div class="form-group">
            <strong>Di kirim</strong>
            <input type="text" name="qty_kirim[]" class="form-control form-control-sm" value="<?= $d->qty_kirim ?>" readonly>
          </div>
          <div class="form-group">
            <strong>Di Terima</strong>
            <input type="text" name="qty_terima[]" class="form-control form-control-sm" value="<?= $d->qty_awal ?>" readonly>
          </div>
          <div class="form-group">
            <strong>Di Update</strong>
            <input type="number" name="qty_update[]" class="form-control form-control-sm qty_update" value="<?= $d->qty_update ?>" readonly>
          </div>
        </div>
        <div class="form-group mb-0">
          <strong>Catatan :</strong>
          <textarea name="catatan[]" class="form-control form-control-sm" readonly><?= $d->catatan ?></textarea>
        </div>
      </div>
    <?php endforeach ?>
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
    <form action="<?= base_url('leader/Bap/simpan') ?>" method="post" id="form_bap">
      <input type="hidden" name="id_bap" value="<?= $bap->id ?>">
      <?php if ($bap->status == 0) { ?>
        <div class="form-group">
          <label for="Catatan Leader:">Catatan Leader : *</label>
          <textarea name="catatan_leader" class="form-control form-control-sm" placeholder="Masukan catatan ....." required></textarea>
        </div>
        <div class="form-group">
          <label for="tindakan">Tindakan : *</label>
          <select name="tindakan" class="form-control form-control-sm select2" required>
            <option value=""> Pilih </option>
            <option value="1"> Setuju </option>
            <option value="4"> Tolak</option>
          </select>
        </div>
      <?php } ?>
      <hr>
      <div class="row no-print">
        <div class="col-12">
          <?php if ($bap->status == 0) { ?>
            <button type="submit" class="btn btn-sm btn-primary float-right" id="btn_kirim"><i class="fas fa-save"></i> Simpan</button>
            <a href="<?= base_url('leader/Bap') ?>" class="btn btn-sm btn-danger float-right mr-2"> <i class="fas fa-times-circle"></i> Close</a>
          <?php } else { ?>
            <a href="<?= base_url('leader/Bap') ?>" class="btn btn-sm btn-danger float-right"> <i class="fas fa-times-circle"></i> Close</a>
          <?php } ?>
        </div>
      </div>
    </form>
  </div>
</section>
<script>
  function validateForm() {
    let isValid = true;
    $('#form_bap').find('input[required], select[required], textarea[required]').each(function() {
      if ($(this).val() === '') {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    return isValid;
  }
  document.getElementById("btn_kirim").addEventListener("click", function(event) {
    event.preventDefault();

    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data Pengajuan BAP akan di proses",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        if (validateForm()) {
          document.getElementById("form_bap").submit();
        } else {
          Swal.fire({
            title: 'Belum lengkap',
            text: "Kolom Catatan dan Tindakan harus di isi.",
            icon: 'info',
          });
        }

      }
    })
  });
</script>