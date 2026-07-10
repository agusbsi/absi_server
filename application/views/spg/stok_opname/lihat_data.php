<style>
  .foto_so {
    width: 100%;
    max-width: 150px;
    height: auto;
  }

  .area-footer {
    text-align: center;
    margin-bottom: 5px;
  }

  .area-footer small {
    display: block;
  }

  .waktu {
    font-size: 16px;
    font-weight: 700;
    padding: 6px 20px;
    background-color: #3e007c;
    color: #ff9628;
    margin: 15px 30%;
    border-radius: 25px;
    letter-spacing: 2px;
  }

  .waktu-open {
    font-size: 16px;
    font-weight: 700;
    padding: 6px 20px;
    background-color: rgb(33, 136, 56);
    color: #ffffff;
    margin: 15px 30%;
    border-radius: 25px;
    letter-spacing: 2px;
  }

  @media (max-width: 575.98px) {
    .waktu,
    .waktu-open {
      margin: 15px 0;
    }
  }

  .so-input-toolbar {
    position: sticky;
    top: 76px;
    z-index: 20;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    padding: 8px 10px;
    background: rgba(255, 255, 255, .98);
    border: 1px solid #d7e7dc;
    border-radius: 6px;
    box-shadow: 0 6px 16px rgba(15, 23, 42, .08);
  }

  .so-input-count {
    color: #146c43;
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
  }

  .so-input-count strong {
    color: #0f5132;
    font-size: 15px;
  }

  .so-search {
    position: relative;
    margin-bottom: 10px;
  }

  .so-search i {
    position: absolute;
    top: 50%;
    left: 12px;
    color: #94a3b8;
    font-size: 13px;
    transform: translateY(-50%);
  }

  .so-search input {
    height: 38px;
    padding-left: 34px;
    border-radius: 8px;
    font-size: 13px;
  }

  .so-list {
    display: grid;
    gap: 8px;
    margin-bottom: 16px;
  }

  .so-item {
    display: grid;
    grid-template-columns: 34px minmax(0, 1fr) 118px;
    gap: 10px;
    align-items: center;
    padding: 10px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 1px 4px rgba(15, 23, 42, .06);
  }

  .so-item:hover {
    border-color: #cbd5e1;
    box-shadow: 0 2px 8px rgba(15, 23, 42, .08);
  }

  .so-item.so-row-invalid {
    background: #fff5f5;
    border-color: #f5c2c7;
  }

  .so-row-number {
    display: inline-flex;
    width: 26px;
    height: 26px;
    align-items: center;
    justify-content: center;
    color: #2563eb;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 50%;
    font-size: 11px;
    font-weight: 800;
  }

  .so-article-info {
    min-width: 0;
  }

  .so-article-code {
    display: inline-block;
    margin-bottom: 3px;
    padding: 2px 7px;
    color: #0f172a;
    background: #eef2ff;
    border: 1px solid #dbe4ff;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 800;
    line-height: 1.2;
  }

  .so-article-name {
    display: block;
    color: #334155;
    font-size: 12px;
    line-height: 1.35;
  }

  .so-qty-cell {
    min-width: 0;
  }

  .qty-so {
    height: 38px;
    width: 100%;
    font-size: 16px;
    font-weight: 700;
    text-align: center;
  }

  .qty-so.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 .16rem rgba(220, 53, 69, .18);
  }

  .so-invalid-hint {
    display: none;
    margin-top: 4px;
    color: #dc3545;
    font-size: 11px;
    font-weight: 700;
  }

  .qty-so.is-invalid + .so-invalid-hint {
    display: block;
  }

  @media (max-width: 575.98px) {
    .so-input-toolbar {
      top: 68px;
      margin-right: -6px;
      margin-left: -6px;
      padding: 7px 10px;
    }

    .so-input-count {
      text-align: center;
    }

    .so-search input {
      height: 40px;
    }

    .so-list {
      gap: 7px;
    }

    .so-item {
      grid-template-columns: 26px minmax(0, 1fr) 82px;
      gap: 8px;
      padding: 9px 8px;
    }

    .so-article-code {
      max-width: 100%;
      margin-bottom: 5px;
      overflow: hidden;
      font-size: 11px;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .so-article-name {
      font-size: 11px;
      line-height: 1.3;
    }

    .qty-so {
      height: 42px;
      font-size: 17px;
    }

    .so-invalid-hint {
      text-align: center;
    }
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <?php if (($toko->status_so) == 1) { ?>
          <div class="row text-center">
            <div class="col-md-6">
              <img src="<?= base_url('assets/img/komplet.svg') ?>" alt="complete" class="foto_so">
            </div>
            <div class="col-md-6" style="padding-top: 30px;">
              <h3>Stok Opname Berhasil</h3>
              <p>Terima kasih, kamu telah selesai melakukan stok opname artikel di bulan ini.
                data akan di verifikasi oleh tim Operasional ABSI.</p>
            </div>
          </div>
          <hr>

          <div class="area-footer">
            <small>* Jika data SO belum sesuai, kamu bisa memperbaruinya selama waktu tersedia atau bisa hubungi tim operasional.</small>
            <input type="hidden" id="waktuSo" value="<?= $dataSo ? $dataSo->created_at : '' ?>">
            <?php if ($dataSo->status == 1) { ?>
              <div class="waktu-open">Terbuka</div>
              <a href="<?php echo base_url('spg/dashboard') ?>" class="btn btn-sm btn-success" title="Ke Beranda"> <i class="fas fa-home"></i> Beranda</a>
              <a href="<?php echo base_url('spg/Stok_opname/detail/' . $dataSo->id . '/edit') ?>" class="btn btn-sm btn-warning" title="Edit Data"> <i class="fas fa-edit"></i> Edit</a>
              <a href="<?php echo base_url('spg/Stok_opname/detail/' . $dataSo->id . '/tampil') ?>" class="btn btn-sm btn-primary" title="Lihat Detail"> Lihat <i class="fas fa-arrow-right"></i></a>
            <?php } else { ?>
              <div class="waktu" id="waktu"></div>
              <a href="<?php echo base_url('spg/dashboard') ?>" class="btn btn-sm btn-success" title="Ke Beranda"> <i class="fas fa-home"></i> Beranda</a>
              <a href="<?php echo base_url('spg/Stok_opname/detail/' . $dataSo->id . '/edit') ?>" class="btn btn-sm btn-warning" title="Edit Data" id="editButton"> <i class="fas fa-edit"></i> Edit</a>
              <a href="<?php echo base_url('spg/Stok_opname/detail/' . $dataSo->id . '/tampil') ?>" class="btn btn-sm btn-primary" title="Lihat Detail"> Lihat <i class="fas fa-arrow-right"></i></a>
            <?php } ?>
          </div>

        <?php } else { ?>
          <form action="<?= base_url('spg/stok_opname/simpan_so') ?>" method="post" id="form-so">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-pie"></i> Stok Opname Artikel</b> </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Toko</label>
                      <input type="text" value="<?= $toko->nama_toko ?>" class="form-control form-control-sm" readonly>
                      <input type="hidden" name="id_toko" value="<?= $toko->id ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>PT</label>
                      <input type="text" value="<?= $this->session->userdata('pt') ?>" class="form-control form-control-sm" readonly>
                    </div>
                  </div>

                </div>
                <hr>
                <div class="form-group">
                  <label for="">Tanggal SO</label>
                  <input type="date" name="tgl_so" class="form-control form-control-sm" id="tglSo" max="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d', strtotime('-26 days')) ?>" tabindex="1" required>
                </div>
                <hr>
                <div class="so-input-toolbar">
                  <span class="so-input-count">Terisi <strong id="soFilledCount">0</strong> dari <strong id="soTotalCount"><?= count($stok_produk) ?></strong></span>
                </div>
                <div class="so-search">
                  <i class="fas fa-search"></i>
                  <input type="search" class="form-control form-control-sm" id="soSearch" placeholder="Cari kode atau nama artikel" autocomplete="off" tabindex="-1">
                </div>
                <div class="so-list" id="soList">
                  <?php
                    $no = 0;
                    foreach ($stok_produk as $stok) {
                      $no++;
                      $qty_awal = empty($stok->qty_awal) ? 0 : $stok->qty_awal;
                      $search_text = strtolower($stok->kode . ' ' . $stok->nama_produk);
                  ?>
                    <div class="so-item" data-search="<?= html_escape($search_text) ?>">
                      <span class="so-row-number"><?= $no ?></span>
                      <div class="so-article-info">
                        <span class="so-article-code"><?= $stok->kode ?></span>
                        <span class="so-article-name"><?= $stok->nama_produk ?></span>
                        <input type="hidden" name="id_produk[]" value="<?= $stok->id_produk ?>">
                        <input type="hidden" name="qty_awal[]" value="<?= $qty_awal ?>">
                      </div>
                      <div class="so-qty-cell">
                        <input type="number" name="qty_input[]" min="0" class="form-control form-control-sm qty-so"
                          inputmode="numeric" pattern="[0-9]*" autocomplete="off" placeholder="...." tabindex="<?= $no + 1 ?>" data-product-id="<?= $stok->id_produk ?>"
                          oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        <small class="so-invalid-hint">Wajib diisi</small>
                      </div>
                    </div>
                  <?php
                    } ?>
                </div>
                <div class="form-group">
                  <label for="">Catatan :</label>
                  <textarea name="keterangan" class="form-control form-control-sm" placeholder="Silahkan tambahkan keterangan jika ada"></textarea>
                </div>
                <hr>
                <div class="text-center p-3">
                  <button type="reset" class="btn btn-sm btn-danger">
                    <i class="fa fa-times-circle"></i> Reset
                  </button>
                  <button type="submit" class="btn btn-sm btn-success ml-3" id="btn-kirim"><i class="fa fa-paper-plane"></i> Kirim Data</button>
                </div>
              </div>
            </div>
          </form>
    <?php } ?>
    </div>
  </div>
  </div>
</section>
<script>
  $(function() {
    const waktuElement = document.getElementById('waktu');
    const waktuSoElement = document.getElementById('waktuSo');
    const editButton = document.getElementById('editButton');

    if (!waktuElement || !waktuSoElement || !waktuSoElement.value) {
      return;
    }

    const waktuSo = new Date(waktuSoElement.value).getTime();

    if (Number.isNaN(waktuSo)) {
      waktuElement.textContent = 'Terkunci';
      if (editButton) {
        editButton.classList.add('disabled');
        editButton.setAttribute('aria-disabled', 'true');
      }
      return;
    }

    const targetTime = waktuSo + (23 * 60 * 60 * 1000);
    let interval = null;

    function lockEditButton() {
      waktuElement.textContent = 'Terkunci';
      if (editButton) {
        editButton.classList.add('disabled');
        editButton.setAttribute('aria-disabled', 'true');
        editButton.addEventListener('click', function(e) {
          e.preventDefault();
        });
      }
    }

    function updateCountdown() {
      const now = new Date().getTime();
      const distance = targetTime - now;

      if (distance < 0) {
        if (interval) {
          clearInterval(interval);
        }
        lockEditButton();
        return;
      }

      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);
      waktuElement.textContent = `${String(hours).padStart(2, '0')} : ${String(minutes).padStart(2, '0')} : ${String(seconds).padStart(2, '0')}`;
    }

    interval = setInterval(updateCountdown, 1000);
    updateCountdown();
  });
</script>
<script type="text/javascript">
  const soDraftKey = 'absi_so_draft_<?= (int) $toko->id ?>_<?= md5(implode(',', array_map(function($item) { return $item->id_produk; }, $stok_produk))) ?>';
  let soDraftRestoring = false;
  let soDraftTimer = null;

  function getSoDraftData() {
    const qty = {};

    $('input[name="qty_input[]"]').each(function() {
      const productId = $(this).data('product-id');

      if (productId !== undefined && $(this).val() !== '') {
        qty[String(productId)] = $(this).val();
      }
    });

    return {
      tgl_so: $('#tglSo').val(),
      keterangan: $('textarea[name="keterangan"]').val(),
      qty: qty,
      saved_at: new Date().toISOString()
    };
  }

  function saveSoDraft() {
    if (soDraftRestoring || !window.localStorage) {
      return;
    }

    try {
      localStorage.setItem(soDraftKey, JSON.stringify(getSoDraftData()));
    } catch (error) {
      // Jika storage penuh atau diblokir browser, form tetap berjalan normal.
    }
  }

  function scheduleSoDraftSave() {
    clearTimeout(soDraftTimer);
    soDraftTimer = setTimeout(saveSoDraft, 150);
  }

  function clearSoDraft() {
    if (!window.localStorage) {
      return;
    }

    try {
      clearTimeout(soDraftTimer);
      localStorage.removeItem(soDraftKey);
    } catch (error) {}
  }

  function restoreSoDraft() {
    if (!window.localStorage) {
      return;
    }

    let draft = null;

    try {
      draft = JSON.parse(localStorage.getItem(soDraftKey) || 'null');
    } catch (error) {
      localStorage.removeItem(soDraftKey);
      return;
    }

    if (!draft) {
      return;
    }

    soDraftRestoring = true;

    if (draft.tgl_so) {
      $('#tglSo').val(draft.tgl_so);
    }

    if (draft.keterangan) {
      $('textarea[name="keterangan"]').val(draft.keterangan);
    }

    if (draft.qty) {
      $('input[name="qty_input[]"]').each(function() {
        const productId = String($(this).data('product-id'));

        if (Object.prototype.hasOwnProperty.call(draft.qty, productId)) {
          $(this).val(draft.qty[productId]);
          markInputValid($(this));
        }
      });
    }

    soDraftRestoring = false;
    updateSoFilledCount();
  }

  function updateSoFilledCount() {
    const total = $('input[name="qty_input[]"]').length;
    const filled = $('input[name="qty_input[]"]').filter(function() {
      return $(this).val() !== '';
    }).length;

    $('#soFilledCount').text(filled);
    $('#soTotalCount').text(total);
  }

  function markInputValid($input) {
    $input.removeClass('is-invalid');
    $input.closest('.so-item').removeClass('so-row-invalid');
  }

  function markInputInvalid($input) {
    $input.addClass('is-invalid');
    $input.closest('.so-item').addClass('so-row-invalid').show();
  }

  function clearSoSearch() {
    $('#soSearch').val('');
    $('.so-item').show();
  }

  function scrollToInvalidInput($input) {
    if (!$input.length) {
      return;
    }

    clearSoSearch();

    setTimeout(function() {
      const input = $input.get(0);
      const headerOffset = $('.main-header').outerHeight() || 70;
      const top = $input.offset().top - headerOffset - 90;

      $('html, body').animate({
        scrollTop: Math.max(0, top)
      }, 350, function() {
        input.focus();
        input.select();
      });
    }, 80);
  }

  function validateForm() {
    let isValid = true;
    let firstInvalid = null;

    $('#form-so').find('input[required], select[required], textarea[required]').each(function() {
      const $field = $(this);

      if ($field.val() === '') {
        isValid = false;
        $field.addClass('is-invalid');

        if ($field.attr('name') === 'qty_input[]') {
          markInputInvalid($field);
        }

        if (!firstInvalid) {
          firstInvalid = $field;
        }
      } else {
        $field.removeClass('is-invalid');

        if ($field.attr('name') === 'qty_input[]') {
          markInputValid($field);
        }
      }
    });

    if (!isValid && firstInvalid) {
      scrollToInvalidInput(firstInvalid);
    }

    return isValid;
  }

  $(document).on('input change', 'input[name="qty_input[]"]', function() {
    const $input = $(this);

    if ($input.val() !== '') {
      markInputValid($input);
    }

    updateSoFilledCount();
    scheduleSoDraftSave();
  });

  $('#tglSo, textarea[name="keterangan"]').on('input change', scheduleSoDraftSave);

  $(document).on('focus', 'input[name="qty_input[]"]', function() {
    this.select();
  });

  function focusQtyInput($input) {
    if (!$input.length) {
      return;
    }

    clearSoSearch();

    setTimeout(function() {
      const input = $input.get(0);
      const headerOffset = $('.main-header').outerHeight() || 70;
      const top = $input.offset().top - headerOffset - 90;

      $('html, body').stop(true).animate({
        scrollTop: Math.max(0, top)
      }, 180, function() {
        input.focus();
        input.select();
      });
    }, 20);
  }

  $('#tglSo').on('keydown', function(e) {
    if (e.key !== 'Tab' || e.shiftKey) {
      return;
    }

    e.preventDefault();
    focusQtyInput($('input[name="qty_input[]"]').first());
  });

  $(document).on('keydown', 'input[name="qty_input[]"]', function(e) {
    if (e.key !== 'Enter' && e.key !== 'Tab') {
      return;
    }

    e.preventDefault();
    const inputs = $('input[name="qty_input[]"]');
    const currentIndex = inputs.index(this);
    const targetIndex = e.shiftKey ? currentIndex - 1 : currentIndex + 1;
    const targetInput = inputs.eq(targetIndex);

    if (targetInput.length) {
      focusQtyInput(targetInput);
    } else {
      this.blur();
    }
  });

  $('#form-so').on('reset', function() {
    setTimeout(function() {
      $('#form-so').find('.is-invalid').removeClass('is-invalid');
      $('.so-item').removeClass('so-row-invalid').show();
      $('#soSearch').val('');
      updateSoFilledCount();
      clearSoDraft();
    }, 0);
  });

  $('#soSearch').on('input', function() {
    const keyword = this.value.toLowerCase().trim();

    $('.so-item').each(function() {
      const itemText = $(this).data('search') || '';
      $(this).toggle(itemText.indexOf(keyword) !== -1);
    });
  });

  restoreSoDraft();
  updateSoFilledCount();

  $('#btn-kirim').click(function(e) {
    e.preventDefault();

    if (!validateForm()) {
      Swal.fire({
        toast: true,
        position: 'top',
        title: 'Belum Lengkap',
        text: 'Lengkapi artikel yang ditandai merah.',
        icon: 'error',
        showConfirmButton: false,
        timer: 2200,
        timerProgressBar: true
      });
      return;
    }

    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data Stok Opname akan di proses. !",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        clearSoDraft();
        document.getElementById("form-so").submit();
      }
    })
  })
</script>
