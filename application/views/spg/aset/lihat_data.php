<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <?php if (($toko->status_aset) == 1) { ?>
          <div class="asset-success-wrap">
            <div class="asset-success-card">
              <div class="asset-success-accent"></div>
              <div class="asset-success-content">
                <div class="success-icon" aria-hidden="true">
                  <i class="fas fa-check"></i>
                </div>
                <span class="success-label">
                  <i class="fas fa-cloud-upload-alt mr-1"></i> Data berhasil terkirim
                </span>
                <h2>Update Aset Berhasil</h2>
                <p class="success-description">
                  Terima kasih, laporan aset <strong><?= html_escape($toko->nama_toko) ?></strong> untuk bulan ini sudah tersimpan dan siap diproses oleh Admin Support Hicoop.
                </p>

                <div class="success-info">
                  <i class="fas fa-shield-alt"></i>
                  <div>
                    <strong>Proses update telah selesai</strong>
                    <span>Anda tidak perlu mengirim ulang data aset pada periode ini.</span>
                  </div>
                </div>

                <div class="success-actions">
                  <a href="<?= base_url('spg/Stok_opname') ?>" class="btn btn-success btn-lg">
                    Lanjut Stok Opname <i class="fas fa-arrow-right ml-2"></i>
                  </a>
                  <a href="<?= base_url('spg/Dashboard') ?>" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-home mr-2"></i> Kembali ke Dashboard
                  </a>
                </div>
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
              <div class="form-actions">
                <button type="submit" class="btn btn-sm btn-success">
                  <i class="fas fa-save"></i> Update Aset
                </button>
                <a href="<?= base_url('spg/Dashboard') ?>" class="btn btn-sm btn-danger">
                  <i class="fas fa-times"></i> Batal
                </a>
              </div>
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
                  Jangan tutup halaman saat proses upload berlangsung. Maksimal ukuran 4 MB per foto.
                </small>
              </div>
            </div>

            <div class="card card-outline card-success mb-3" id="ringkasan_upload">
              <div class="card-header">
                <h6 class="card-title mb-0"><i class="fas fa-check-double mr-1 text-success"></i> List Aset yang Diupload</h6>
              </div>
              <div class="card-body p-0">
                <div id="upload_empty" class="p-3 text-muted <?= $total_selesai > 0 ? 'd-none' : '' ?>">
                  Belum ada aset yang diupload.
                </div>
                <div id="upload_list" class="list-group list-group-flush">
                  <?php foreach ($list_aset as $row) {
                    if (empty($row->id_laporan)) continue;
                  ?>
                    <div class="list-group-item uploaded-row" data-id="<?= (int) $row->id ?>">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <strong class="uploaded-name"><?= html_escape($row->aset) ?></strong>
                          <div class="small text-muted">No. aset: <?= html_escape($row->no_aset) ?></div>
                        </div>
                        <div class="uploaded-actions">
                          <span class="badge badge-success"><i class="fas fa-check mr-1"></i>Terkirim</span>
                          <button type="button" class="btn btn-sm btn-link text-danger p-0 delete-upload" title="Hapus data upload" aria-label="Hapus <?= html_escape($row->aset) ?>">
                            <i class="fas fa-times-circle"></i>
                          </button>
                        </div>
                      </div>
                      <div class="uploaded-details small mt-2">
                        <span><strong>Jumlah:</strong> <span class="uploaded-qty"><?= (int) $row->qty_laporan ?></span></span>
                        <span><strong>Kondisi:</strong> <span class="uploaded-note"><?= html_escape($row->keterangan_laporan) ?></span></span>
                      </div>
                    </div>
                  <?php } ?>
                </div>
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
                  data-name="<?= html_escape($row->aset) ?>"
                  data-number="<?= html_escape($row->no_aset) ?>"
                  data-completed="<?= $sudah_selesai ? '1' : '0' ?>">
                  <div class="card-header">
                    <h6 class="card-title mb-0"> <?= html_escape($row->aset) ?></h6>
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
                        Upload Aset Ini &amp; Lanjut
                      </button>
                    </div>
                  </div>
                </div>
              <?php } ?>

              <div id="panel_selesai" class="<?= $total_selesai === $total_aset ? '' : 'd-none' ?>">
                <div class="callout callout-success">
                  <h5><i class="fas fa-check-circle mr-1"></i> Semua aset berhasil diupload</h5>
                  <p class="mb-0">Periksa kembali daftar aset di atas, lalu pilih <strong>Simpan Aset</strong> untuk menyelesaikan laporan bulan ini.</p>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" id="btn_selesai" class="btn btn-success <?= $total_selesai === $total_aset ? '' : 'd-none' ?>">
                  <i class="fas fa-save mr-1"></i> Simpan Aset
                </button>
                <a href="<?= base_url('spg/Dashboard') ?>" class="btn btn-danger">
                  <i class="fas fa-times"></i> Batal
                </a>
              </div>
              <small>* Jika nama aset tidak ada, silakan hubungi tim Operasional ABSI.</small>
            </form>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</section>

<style>
  .asset-success-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 190px);
    padding: 24px 0 40px;
  }

  .asset-success-card {
    position: relative;
    width: 100%;
    max-width: 720px;
    overflow: hidden;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    box-shadow: 0 18px 45px rgba(31, 41, 55, 0.1);
  }

  .asset-success-accent {
    height: 7px;
    background: linear-gradient(90deg, #28a745, #20c997);
  }

  .asset-success-content {
    padding: 46px 52px 42px;
    text-align: center;
  }

  .success-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 82px;
    height: 82px;
    margin-bottom: 20px;
    color: #fff;
    font-size: 34px;
    background: linear-gradient(135deg, #28a745, #20c997);
    border: 8px solid #eaf8ee;
    border-radius: 50%;
    box-shadow: 0 10px 24px rgba(40, 167, 69, 0.22);
  }

  .success-label {
    display: table;
    margin: 0 auto 12px;
    padding: 6px 12px;
    color: #218838;
    font-size: 0.8rem;
    font-weight: 600;
    background: #eaf8ee;
    border-radius: 999px;
  }

  .asset-success-content h2 {
    margin-bottom: 12px;
    color: #1f2937;
    font-size: 2rem;
    font-weight: 700;
  }

  .success-description {
    max-width: 570px;
    margin: 0 auto 26px;
    color: #6b7280;
    font-size: 1rem;
    line-height: 1.7;
  }

  .success-info {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 28px;
    padding: 16px 18px;
    color: #374151;
    text-align: left;
    background: #f7faf8;
    border: 1px solid #dcefe1;
    border-radius: 12px;
  }

  .success-info > i {
    color: #28a745;
    font-size: 1.45rem;
  }

  .success-info strong,
  .success-info span {
    display: block;
  }

  .success-info span {
    margin-top: 2px;
    color: #6b7280;
    font-size: 0.88rem;
  }

  .success-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
  }

  .success-actions .btn {
    min-width: 210px;
    border-radius: 9px;
    font-size: 0.95rem;
    font-weight: 600;
  }

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

  .uploaded-details {
    display: flex;
    flex-wrap: wrap;
    gap: 4px 24px;
  }

  .uploaded-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
  }

  .delete-upload {
    font-size: 1.15rem;
    line-height: 1;
  }

  .form-actions {
    display: flex;
    flex-direction: row-reverse;
    gap: 8px;
    margin-bottom: 12px;
  }

  .form-actions .btn {
    min-width: 150px;
  }

  @media (max-width: 575.98px) {
    .asset-success-wrap {
      min-height: 0;
      padding: 12px 0 28px;
    }

    .asset-success-card {
      border-radius: 14px;
    }

    .asset-success-content {
      padding: 32px 20px 26px;
    }

    .success-icon {
      width: 72px;
      height: 72px;
      font-size: 28px;
    }

    .asset-success-content h2 {
      font-size: 1.55rem;
    }

    .success-actions {
      flex-direction: column;
    }

    .success-actions .btn {
      width: 100%;
      min-width: 0;
    }

    .form-actions {
      flex-direction: column;
    }

    .form-actions .btn {
      width: 100%;
      min-width: 0;
    }

    .upload-item {
      width: 100%;
      margin-top: 8px;
    }
  }
</style>

<script>
  $(function() {
    var uploadUrl = <?= json_encode(base_url('spg/Aset/updateFotoAset')) ?>;
    var deleteUrl = <?= json_encode(base_url('spg/Aset/deleteFotoAset')) ?>;
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
        $('#btn_selesai').addClass('d-none');
        $('html, body').animate({ scrollTop: $current.offset().top - 80 }, 250);
      } else {
        $('#panel_selesai').removeClass('d-none');
        $('#btn_selesai').removeClass('d-none');
        $('html, body').animate({ scrollTop: $('#panel_selesai').offset().top - 80 }, 250);
      }
    }

    function updateUploadedSummary($item) {
      var id = String($item.data('id'));
      var $row = $('#upload_list .uploaded-row').filter(function() {
        return String($(this).data('id')) === id;
      });

      if (!$row.length) {
        $row = $('<div>', {
          'class': 'list-group-item uploaded-row',
          'data-id': id
        });
        var $top = $('<div>', {'class': 'd-flex justify-content-between align-items-start'});
        var $identity = $('<div>')
          .append($('<strong>', {'class': 'uploaded-name'}))
          .append($('<div>', {'class': 'small text-muted uploaded-number'}));
        var $badge = $('<span>', {'class': 'badge badge-success'})
          .append($('<i>', {'class': 'fas fa-check mr-1'}))
          .append(document.createTextNode('Terkirim'));
        var $deleteButton = $('<button>', {
          type: 'button',
          'class': 'btn btn-sm btn-link text-danger p-0 delete-upload',
          title: 'Hapus data upload',
          'aria-label': 'Hapus data upload'
        }).append($('<i>', {'class': 'fas fa-times-circle'}));
        var $actions = $('<div>', {'class': 'uploaded-actions'}).append($badge, $deleteButton);
        var $details = $('<div>', {'class': 'uploaded-details small mt-2'})
          .append($('<span>').append('<strong>Jumlah:</strong> ').append($('<span>', {'class': 'uploaded-qty'})))
          .append($('<span>').append('<strong>Kondisi:</strong> ').append($('<span>', {'class': 'uploaded-note'})));

        $top.append($identity, $actions);
        $row.append($top, $details).appendTo('#upload_list');
      }

      $row.find('.uploaded-name').text($item.attr('data-name'));
      $row.find('.uploaded-number').text('No. aset: ' + $item.attr('data-number'));
      $row.find('.uploaded-qty').text($item.find('.jumlah').val());
      $row.find('.uploaded-note').text($.trim($item.find('.keterangan').val()));
      $('#upload_empty').addClass('d-none');
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
          setStatus($item, 'success', 'Berhasil terkirim');
          updateUploadedSummary($item);
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

    $('#upload_list').on('click', '.delete-upload', function() {
      var $button = $(this);
      var $row = $button.closest('.uploaded-row');
      var id = $row.data('id');
      var name = $row.find('.uploaded-name').text();

      if (!window.confirm('Hapus data upload "' + name + '"? Aset ini harus diupload kembali.')) {
        return;
      }

      $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
      $.ajax({
        url: deleteUrl,
        method: 'POST',
        data: {id_aset_toko: id},
        dataType: 'json',
        timeout: 30000
      }).done(function(response) {
        if (!response.success) {
          window.alert(response.message || 'Data upload gagal dihapus.');
          return;
        }

        var $item = $('.aset-item').filter(function() {
          return String($(this).data('id')) === String(id);
        });
        var $preview = $item.find('.foto-preview');
        var previewUrl = $preview.data('object-url');
        if (previewUrl) {
          URL.revokeObjectURL(previewUrl);
        }

        $item.attr('data-completed', '0').data('completed', 0)
          .removeClass('card-success aset-selesai').addClass('card-info');
        $item.removeData('selected-file');
        $item.find('.foto-camera, .foto-gallery').val('');
        $item.find('.foto-info').removeClass('text-success text-danger').addClass('text-muted')
          .text('Data sebelumnya sudah dihapus. Pilih foto untuk mengupload kembali.');
        $preview.removeAttr('src').removeData('object-url').addClass('d-none');
        $row.remove();

        if (!$('#upload_list .uploaded-row').length) {
          $('#upload_empty').removeClass('d-none');
        }
        updateProgress();
        showCurrentStep();
      }).fail(function(xhr) {
        var response = xhr.responseJSON || {};
        window.alert(response.message || 'Data upload gagal dihapus. Periksa koneksi lalu coba lagi.');
      }).always(function() {
        if ($row.closest('html').length) {
          $button.prop('disabled', false).html('<i class="fas fa-times-circle"></i>');
        }
      });
    });

    $('#form_aset').on('submit', function() {
      $('#btn_selesai').prop('disabled', true)
        .html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');
    });

    updateProgress();
  });
</script>
