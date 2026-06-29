<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <?php if (($toko->status_aset) == 1) { ?>
          <div class="error-page">
            <h2 class="headline text-success"><i class="fas fa-check-circle"></i></h2>
            <div class="error-content">
              <h3>UPDATE ASET BERHASIL!</h3>
              <p>
                Terima kasih, Anda telah melakukan Update Aset Toko di bulan ini. Data akan diproses oleh Admin Support Hicoop.
              </p>
              <hr>
              <div class="input-group text-center">
                <a href="<?= base_url('spg/Stok_opname') ?>" class="btn btn-success">
                  Lanjut Stok Opname <i class="fa fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        <?php } else { ?>
          <?php if (empty($list_aset)) { ?>
            <form action="<?= base_url('spg/Aset/update'); ?>" method="post">
              <div class="callout callout-danger">
                <div class="col-lg-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fas fa-dolly"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">ASET KOSONG</span>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="form-group mb-0">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1" required>
                    <label class="custom-control-label" for="exampleCheck1">
                      Saya memastikan di toko <span class="text-info"><?= html_escape($toko->nama_toko) ?></span> tidak ada aset perusahaan.
                    </label>
                  </div>
                </div>
              </div>
              <hr>
              <small>* Jika nama aset tidak ada, silakan hubungi tim Operasional ABSI.</small>
              <hr>
              <button type="submit" class="btn btn-sm btn-success mb-2 float-right">
                <i class="fas fa-save"></i> Update Aset
              </button>
              <a href="<?= base_url('spg/Dashboard') ?>" class="btn btn-sm btn-danger mb-2 float-right mr-2">
                <i class="fas fa-times"></i> Cancel
              </a>
            </form>
          <?php } else { ?>
            <?php
            $total_aset = count($list_aset);
            $total_selesai = 0;
            $langkah_aktif = null;
            foreach ($list_aset as $status_index => $aset_status) {
              if (!empty($aset_status->id_laporan)) {
                $total_selesai++;
              } elseif ($langkah_aktif === null) {
                $langkah_aktif = $status_index;
              }
            }
            ?>

            <div class="card card-outline card-info mb-3">
              <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <strong>Progres update aset</strong>
                  <span id="progress_text"><?= $total_selesai ?> / <?= $total_aset ?> selesai</span>
                </div>
                <div class="progress" style="height: 12px;">
                  <div
                    id="progress_bar"
                    class="progress-bar bg-success"
                    role="progressbar"
                    style="width: <?= $total_aset > 0 ? round(($total_selesai / $total_aset) * 100) : 0 ?>%">
                  </div>
                </div>
                <small class="text-muted d-block mt-2">
                  Foto diproses satu per satu. Maksimal 4 MB per foto dan otomatis dikompres.
                </small>
              </div>
            </div>

            <form id="form_aset" action="<?= base_url('spg/Aset/update') ?>" method="post" novalidate>
              <?php foreach ($list_aset as $index => $row) {
                $sudah_selesai = !empty($row->id_laporan);
                $nomor = $index + 1;
              ?>
                <div
                  class="card card-outline aset-item <?= $sudah_selesai ? 'card-success aset-selesai' : 'card-info' ?> <?= $index === $langkah_aktif ? '' : 'd-none' ?>"
                  data-id="<?= (int) $row->id ?>"
                  data-completed="<?= $sudah_selesai ? '1' : '0' ?>">
                  <div class="card-header">
                    <h6 class="card-title mb-0">Aset <?= $nomor ?> dari <?= $total_aset ?>: <?= html_escape($row->aset) ?></h6>
                    <div class="card-tools">
                      <span class="badge status-badge <?= $sudah_selesai ? 'badge-success' : 'badge-secondary' ?>">
                        <i class="fas <?= $sudah_selesai ? 'fa-check' : 'fa-clock' ?> mr-1"></i>
                        <span><?= $sudah_selesai ? 'Selesai' : 'Belum diupdate' ?></span>
                      </span>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="form-group mb-2">
                      <label class="mb-0 small">No Aset:</label>
                      <input type="text" class="form-control form-control-sm" value="<?= html_escape($row->no_aset) ?>" readonly>
                    </div>

                    <div class="form-group mb-2">
                      <label class="mb-1 small">Foto Aset:</label>
                      <div class="d-flex flex-wrap">
                        <button type="button" class="btn btn-sm btn-info mr-2 mb-2 pilih-foto" data-source="camera">
                          <i class="fas fa-camera mr-1"></i> Kamera
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info mb-2 pilih-foto" data-source="gallery">
                          <i class="fas fa-images mr-1"></i> Galeri
                        </button>
                      </div>
                      <input type="file" class="d-none foto-camera" accept="image/*" capture="environment">
                      <input type="file" class="d-none foto-gallery" accept="image/*">
                      <div class="foto-info small text-muted">
                        <?= $sudah_selesai ? 'Foto bulan ini sudah tersimpan. Pilih foto baru untuk memperbarui.' : 'Belum ada foto dipilih.' ?>
                      </div>
                      <img class="foto-preview mt-2 d-none" alt="Preview foto aset">
                    </div>

                    <div class="form-group mb-2">
                      <label class="mb-0 small">Jumlah:</label>
                      <input
                        type="number"
                        class="form-control form-control-sm jumlah"
                        min="0"
                        step="1"
                        value="<?= $sudah_selesai ? (int) $row->qty_laporan : '' ?>"
                        placeholder="Jumlah aset">
                    </div>

                    <div class="form-group mb-2">
                      <label class="mb-0 small">Kondisi:</label>
                      <textarea
                        class="form-control form-control-sm keterangan"
                        rows="2"
                        maxlength="250"
                        placeholder="Tuliskan kondisi aset"><?= $sudah_selesai ? html_escape($row->keterangan_laporan) : '' ?></textarea>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-3">
                      <small class="upload-message text-muted"></small>
                      <button type="button" class="btn btn-sm btn-primary upload-item">
                        <i class="fas fa-cloud-upload-alt mr-1"></i>
                        Upload &amp; Lanjutkan
                      </button>
                    </div>
                  </div>
                </div>
              <?php } ?>

              <div id="panel_selesai" class="<?= $total_selesai === $total_aset ? '' : 'd-none' ?>">
                <div class="callout callout-success">
                  <h5><i class="fas fa-check-circle mr-1"></i> Semua aset sudah terpenuhi</h5>
                  <p class="mb-0">Periksa progres di atas, lalu simpan untuk menyelesaikan update aset bulan ini.</p>
                </div>
                <button type="submit" id="btn_selesai" class="btn btn-success mb-2 float-right">
                  <i class="fas fa-save mr-1"></i> Simpan &amp; Selesai
                </button>
              </div>
              <a href="<?= base_url('spg/Dashboard') ?>" class="btn btn-danger mb-2 float-right mr-2">
                <i class="fas fa-times"></i> Batal
              </a>
              <div class="clearfix"></div>
              <small>* Jika nama aset tidak ada, silakan hubungi tim Operasional ABSI.</small>
            </form>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</section>

<style>
  .aset-item {
    transition: border-color 0.2s ease;
  }

  .aset-item.is-uploading {
    border-color: #ffc107;
  }

  .foto-preview {
    width: 100%;
    max-width: 260px;
    max-height: 200px;
    object-fit: cover;
    border: 1px solid #dee2e6;
    border-radius: 4px;
  }

  .upload-item {
    min-width: 132px;
  }
</style>

<script>
  $(function() {
    var uploadUrl = <?= json_encode(base_url('spg/Aset/updateFotoAset')) ?>;
    var totalAset = <?= isset($total_aset) ? (int) $total_aset : 0 ?>;
    var maxClientFileSize = 4 * 1024 * 1024;

    function setStatus($item, type, text) {
      var $badge = $item.find('.status-badge');
      var icon = type === 'success' ? 'fa-check' : (type === 'loading' ? 'fa-spinner fa-spin' : 'fa-exclamation-circle');
      var badgeClass = type === 'success' ? 'badge-success' : (type === 'loading' ? 'badge-warning' : 'badge-danger');

      $badge.removeClass('badge-success badge-secondary badge-warning badge-danger')
        .addClass(badgeClass);
      $badge.find('i').attr('class', 'fas ' + icon + ' mr-1');
      $badge.find('span').text(text);
    }

    function updateProgress() {
      var completed = $('.aset-item[data-completed="1"]').length;
      var percentage = totalAset > 0 ? Math.round((completed / totalAset) * 100) : 0;
      $('#progress_text').text(completed + ' / ' + totalAset + ' selesai');
      $('#progress_bar').css('width', percentage + '%');
    }

    function showCurrentStep() {
      var $items = $('.aset-item');
      var $current = $items.filter(function() {
        return $(this).attr('data-completed') !== '1';
      }).first();

      $items.addClass('d-none');
      if ($current.length) {
        $current.removeClass('d-none');
        $('#panel_selesai').addClass('d-none');
        $('html, body').animate({ scrollTop: $current.offset().top - 80 }, 250);
      } else {
        $('#panel_selesai').removeClass('d-none');
        $('html, body').animate({ scrollTop: $('#panel_selesai').offset().top - 80 }, 250);
      }
    }

    function resetValidation($item) {
      $item.find('.is-invalid').removeClass('is-invalid');
      $item.find('.foto-info').removeClass('text-danger');
      $item.find('.upload-message').removeClass('text-danger text-success').addClass('text-muted').text('');
    }

    function validateItem($item, requirePhoto) {
      resetValidation($item);
      var valid = true;
      var jumlah = $item.find('.jumlah').val();
      var keterangan = $.trim($item.find('.keterangan').val());
      var file = $item.data('selected-file');

      if (jumlah === '' || !/^\d+$/.test(jumlah)) {
        $item.find('.jumlah').addClass('is-invalid');
        valid = false;
      }
      if (!keterangan) {
        $item.find('.keterangan').addClass('is-invalid');
        valid = false;
      }
      if (requirePhoto && !file) {
        $item.find('.foto-info').addClass('text-danger').removeClass('text-muted');
        valid = false;
      }
      if (file && file.size > maxClientFileSize) {
        $item.find('.foto-info').addClass('text-danger').removeClass('text-muted')
          .text('Ukuran foto setelah diproses masih lebih dari 4 MB.');
        valid = false;
      }

      if (!valid) {
        $item.find('.upload-message').removeClass('text-muted').addClass('text-danger')
          .text('Lengkapi data dan foto aset.');
      }
      return valid;
    }

    function compressForUpload(file) {
      return new Promise(function(resolve, reject) {
        if (!file.type.match(/^image\//)) {
          reject(new Error('File yang dipilih harus berupa foto.'));
          return;
        }

        var image = new Image();
        var objectUrl = URL.createObjectURL(file);
        image.onload = function() {
          URL.revokeObjectURL(objectUrl);
          var maxDimension = 1600;
          var scale = Math.min(1, maxDimension / Math.max(image.naturalWidth, image.naturalHeight));
          var canvas = document.createElement('canvas');
          canvas.width = Math.max(1, Math.round(image.naturalWidth * scale));
          canvas.height = Math.max(1, Math.round(image.naturalHeight * scale));
          var context = canvas.getContext('2d');
          context.drawImage(image, 0, 0, canvas.width, canvas.height);

          canvas.toBlob(function(blob) {
            if (!blob) {
              reject(new Error('Foto tidak dapat diproses.'));
              return;
            }
            resolve(blob);
          }, 'image/jpeg', 0.78);
        };
        image.onerror = function() {
          URL.revokeObjectURL(objectUrl);
          reject(new Error('Foto tidak dapat dibaca.'));
        };
        image.src = objectUrl;
      });
    }

    function chooseFile($item, input) {
      var file = input.files && input.files[0];
      if (!file) {
        return;
      }

      $item.find('.foto-info').removeClass('text-danger').addClass('text-muted').text('Memproses foto...');
      compressForUpload(file).then(function(compressedFile) {
        if (compressedFile.size > maxClientFileSize) {
          throw new Error('Ukuran foto setelah diproses masih lebih dari 4 MB.');
        }

        $item.data('selected-file', compressedFile);
        $item.find('.foto-info').removeClass('text-danger').addClass('text-success')
          .text('Foto siap diupload (' + Math.max(1, Math.round(compressedFile.size / 1024)) + ' KB).');

        var previewUrl = URL.createObjectURL(compressedFile);
        var $preview = $item.find('.foto-preview');
        var oldPreviewUrl = $preview.data('object-url');
        if (oldPreviewUrl) {
          URL.revokeObjectURL(oldPreviewUrl);
        }
        $preview.attr('src', previewUrl).data('object-url', previewUrl).removeClass('d-none');
      }).catch(function(error) {
        $item.removeData('selected-file');
        $item.find('.foto-info').removeClass('text-muted text-success').addClass('text-danger').text(error.message);
      });
    }

    function uploadItem($item) {
      return new Promise(function(resolve, reject) {
        if (!validateItem($item, true)) {
          reject(new Error('Data belum lengkap.'));
          return;
        }

        var formData = new FormData();
        formData.append('id_aset_toko', $item.data('id'));
        formData.append('jumlah', $item.find('.jumlah').val());
        formData.append('keterangan', $.trim($item.find('.keterangan').val()));
        formData.append('foto_aset', $item.data('selected-file'), 'foto-aset.jpg');

        $item.addClass('is-uploading');
        $item.find(':input, button').prop('disabled', true);
        $item.find('.upload-message').removeClass('text-danger text-success').addClass('text-muted').text('Mengupload...');
        setStatus($item, 'loading', 'Mengupload');

        $.ajax({
          url: uploadUrl,
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          timeout: 120000
        }).done(function(response) {
          if (!response.success) {
            reject(new Error(response.message || 'Upload gagal.'));
            return;
          }

          $item.attr('data-completed', '1').data('completed', 1)
            .removeClass('card-info').addClass('card-success aset-selesai');
          $item.removeData('selected-file');
          $item.find('.upload-message').removeClass('text-muted text-danger').addClass('text-success')
            .text('Tersimpan di server.');
          setStatus($item, 'success', 'Selesai');
          updateProgress();
          resolve(response);
        }).fail(function(xhr) {
          var response = xhr.responseJSON || {};
          reject(new Error(response.message || 'Upload gagal. Periksa koneksi lalu coba lagi.'));
        }).always(function() {
          $item.removeClass('is-uploading');
          $item.find(':input, button').prop('disabled', false);
        });
      });
    }

    $('.pilih-foto').on('click', function() {
      var $item = $(this).closest('.aset-item');
      var source = $(this).data('source');
      var input = $item.find(source === 'camera' ? '.foto-camera' : '.foto-gallery').get(0);

      if (!input) {
        return;
      }

      input.value = '';
      if (source === 'camera') {
        input.setAttribute('accept', 'image/*');
        input.setAttribute('capture', 'environment');
      } else {
        input.removeAttribute('capture');
      }
      input.click();
    });

    $('.foto-camera, .foto-gallery').on('change', function() {
      chooseFile($(this).closest('.aset-item'), this);
    });

    $('.upload-item').on('click', function() {
      var $item = $(this).closest('.aset-item');
      uploadItem($item).then(function() {
        showCurrentStep();
      }).catch(function(error) {
        $item.find('.upload-message').removeClass('text-muted text-success').addClass('text-danger').text(error.message);
        setStatus($item, 'error', 'Gagal');
      });
    });

    $('#form_aset').on('submit', function() {
      $('#btn_selesai').prop('disabled', true)
        .html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');
    });

    updateProgress();
  });
</script>
