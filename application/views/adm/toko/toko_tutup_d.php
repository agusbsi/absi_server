<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-danger ">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> Pengajuan <?= kategori_pengajuan($retur->kategori) ?></b> </h3>
            <div class="card-tools">
              <a href="<?= base_url('adm/Toko/pengajuanToko') ?>"> <i class="fas fa-times-circle"></i></a>
            </div>
          </div>
          <div class="card-body">
            <!-- Info Summary -->
            <div class="row">
              <div class="col-lg-3 col-md-6 mb-3">
                <div class="info-box shadow-sm">
                  <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-file-alt"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">No. Pengajuan</span>
                    <span class="info-box-number"><?= $retur->nomor ?></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 mb-3">
                <div class="info-box shadow-sm">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-plus"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Tanggal Dibuat</span>
                    <span class="info-box-number" style="font-size: 16px;"><?= date('d M Y', strtotime($retur->created_at)) ?></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 mb-3">
                <div class="info-box shadow-sm">
                  <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-times"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Tanggal Tutup</span>
                    <span class="info-box-number" style="font-size: 16px;"><?= date('d M Y', strtotime($retur->tgl_jemput)) ?></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 mb-3">
                <div class="info-box shadow-sm">
                  <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Status</span>
                    <span class="info-box-number" style="font-size: 16px;"><?= status_pengajuan($retur->status) ?></span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Informasi Toko -->
            <div class="row mt-2">
              <div class="col-md-12">
                <div class="card card-outline card-primary shadow-sm">
                  <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-store-alt mr-1"></i> Informasi Toko</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4 mb-2">
                        <strong class="d-block mb-2"><i class="fas fa-building mr-1"></i> Nama Toko</strong>
                        <p class="text-muted mb-0"><?= $retur->nama_toko ?></p>
                      </div>
                      <div class="col-md-8 mb-2">
                        <strong class="d-block mb-2"><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                        <p class="text-muted mb-0"><?= $retur->alamat ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Daftar Artikel -->
            <div class="row mt-2">
              <div class="col-md-12">
                <div class="card card-outline card-success shadow-sm">
                  <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-boxes mr-1"></i> Daftar Artikel / Barang</h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                      <table class="table table-hover table-sm mb-0">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 1;">
                          <tr>
                            <th style="width: 60px;" class="text-center">No</th>
                            <th>Kode & Nama Barang</th>
                            <th style="width: 120px;" class="text-center">Jumlah</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 0;
                          $total = 0;
                          foreach ($artikel as $t) :
                            $no++
                          ?>
                            <tr>
                              <td class="text-center align-middle"><?= $no ?></td>
                              <td class="align-middle">
                                <span class="badge badge-info mr-2"><?= $t->kode ?></span>
                                <span><?= $t->nama_produk ?></span>
                              </td>
                              <td class="text-center align-middle">
                                <span class="badge badge-primary"><?= $t->qty ?></span>
                              </td>
                            </tr>
                          <?php
                            $total += $t->qty;
                          endforeach;
                          ?>
                        </tbody>
                        <tfoot class="bg-light" style="position: sticky; bottom: 0; z-index: 1;">
                          <tr>
                            <th colspan="2" class="text-right py-2">
                              <i class="fas fa-calculator mr-1"></i> Total Barang:
                            </th>
                            <th class="text-center py-2">
                              <span class="badge badge-success" style="font-size: 15px; padding: 6px 12px;"><?= $total ?></span>
                            </th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Riwayat Proses -->
            <div class="row mt-2">
              <div class="col-md-12">
                <div class="card shadow-sm">
                  <div class="card-header bg-white border-0">
                    <h6 class="mb-0 text-secondary"><i class="fas fa-history mr-2"></i>Riwayat Proses</h6>
                  </div>
                  <div class="card-body p-0">
                    <hr>
                    <div class="timeline">
                      <?php
                      $no = 0;
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
                                <?= $h->catatan_h ?>
                              </small>
                            </div>
                          </div>
                        </div>
                      <?php endforeach ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Transaksi Pending -->
            <div class="row mt-2">
              <div class="col-md-12">
                <div class="card shadow-sm">
                  <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0 text-secondary"><i class="fas fa-clock mr-2"></i>Transaksi Pending</h6>
                      <button type="button" class="btn btn-sm btn-outline-primary" onclick="refreshPendingData()" title="Refresh Data">
                        <i class="fas fa-sync-alt"></i> Refresh
                      </button>
                    </div>
                  </div>
                  <div class="card-body pt-2">
                    <style>
                      .pending-item {
                        background: #fff;
                        border: 1px solid #e9ecef;
                        border-radius: 8px;
                        padding: 12px 16px;
                        margin-bottom: 12px;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                      }

                      .pending-item:hover {
                        border-color: #dee2e6;
                        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                        transform: translateY(-1px);
                      }

                      .pending-header {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                      }

                      .pending-title {
                        font-size: 14px;
                        font-weight: 500;
                        color: #495057;
                        margin: 0;
                      }

                      .pending-badge {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        min-width: 28px;
                        height: 28px;
                        border-radius: 20px;
                        font-size: 13px;
                        font-weight: 600;
                        padding: 0 10px;
                      }

                      .pending-dropdown {
                        max-height: 0;
                        overflow: hidden;
                        transition: max-height 0.3s ease;
                        margin-top: 0;
                      }

                      .pending-dropdown.show {
                        max-height: 400px;
                        margin-top: 12px;
                        overflow-y: auto;
                      }

                      .pending-table {
                        width: 100%;
                        font-size: 12px;
                        margin: 0;
                      }

                      .pending-table thead {
                        background: #f8f9fa;
                      }

                      .pending-table thead th {
                        padding: 8px;
                        font-weight: 600;
                        color: #6c757d;
                        border-bottom: 2px solid #dee2e6;
                        text-align: left;
                      }

                      .pending-table tbody td {
                        padding: 8px;
                        border-bottom: 1px solid #f1f3f5;
                        color: #495057;
                      }

                      .pending-table tbody tr:last-child td {
                        border-bottom: none;
                      }

                      .pending-table tbody tr:hover {
                        background: #f8f9fa;
                      }

                      .status-badge {
                        font-size: 10px;
                        padding: 3px 8px;
                        border-radius: 12px;
                        font-weight: 500;
                      }

                      .empty-state {
                        text-align: center;
                        padding: 20px;
                        color: #adb5bd;
                        font-size: 12px;
                      }

                      .chevron-icon {
                        transition: transform 0.3s ease;
                        font-size: 12px;
                        color: #adb5bd;
                        margin-left: 8px;
                      }

                      .chevron-icon.rotated {
                        transform: rotate(180deg);
                      }
                    </style>

                    <!-- PO Artikel -->
                    <div class="pending-item" data-type="po" onclick="toggleDropdown('po')">
                      <div class="pending-header">
                        <div class="d-flex align-items-center">
                          <i class="fas fa-file-invoice text-primary mr-2" style="font-size: 16px;"></i>
                          <span class="pending-title">PO Artikel</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <span class="pending-badge bg-primary text-white" id="pending_po">-</span>
                          <i class="fas fa-chevron-down chevron-icon" id="chevron_po"></i>
                        </div>
                      </div>
                      <div class="pending-dropdown" id="dropdown_po">
                        <table class="pending-table">
                          <thead>
                            <tr>
                              <th style="width: 40px;">No</th>
                              <th>Nomor Transaksi</th>
                              <th style="width: 100px;">Tanggal</th>
                              <th style="width: 100px;">Status</th>
                              <th style="width: 60px;" class="text-center">Aksi</th>
                            </tr>
                          </thead>
                          <tbody id="list_po">
                            <tr>
                              <td colspan="4" class="empty-state">Memuat data...</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- Pengiriman -->
                    <div class="pending-item" data-type="pengiriman" onclick="toggleDropdown('pengiriman')">
                      <div class="pending-header">
                        <div class="d-flex align-items-center">
                          <i class="fas fa-truck text-success mr-2" style="font-size: 16px;"></i>
                          <span class="pending-title">Pengiriman</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <span class="pending-badge bg-success text-white" id="pending_pengiriman">-</span>
                          <i class="fas fa-chevron-down chevron-icon" id="chevron_pengiriman"></i>
                        </div>
                      </div>
                      <div class="pending-dropdown" id="dropdown_pengiriman">
                        <table class="pending-table">
                          <thead>
                            <tr>
                              <th style="width: 40px;">No</th>
                              <th>Nomor Transaksi</th>
                              <th style="width: 100px;">Tanggal</th>
                              <th style="width: 100px;">Status</th>
                              <th style="width: 60px;" class="text-center">Aksi</th>
                            </tr>
                          </thead>
                          <tbody id="list_pengiriman">
                            <tr>
                              <td colspan="5" class="empty-state">Memuat data...</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- Mutasi Keluar -->
                    <div class="pending-item" data-type="mutasi_keluar" onclick="toggleDropdown('mutasi_keluar')">
                      <div class="pending-header">
                        <div class="d-flex align-items-center">
                          <i class="fas fa-arrow-up text-info mr-2" style="font-size: 16px;"></i>
                          <span class="pending-title">Mutasi Keluar</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <span class="pending-badge bg-info text-white" id="pending_mutasi_keluar">-</span>
                          <i class="fas fa-chevron-down chevron-icon" id="chevron_mutasi_keluar"></i>
                        </div>
                      </div>
                      <div class="pending-dropdown" id="dropdown_mutasi_keluar">
                        <table class="pending-table">
                          <thead>
                            <tr>
                              <th style="width: 40px;">No</th>
                              <th>Nomor Transaksi</th>
                              <th style="width: 100px;">Tanggal</th>
                              <th style="width: 100px;">Status</th>
                              <th style="width: 60px;" class="text-center">Aksi</th>
                            </tr>
                          </thead>
                          <tbody id="list_mutasi_keluar">
                            <tr>
                              <td colspan="5" class="empty-state">Memuat data...</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- Mutasi Masuk -->
                    <div class="pending-item" data-type="mutasi_masuk" onclick="toggleDropdown('mutasi_masuk')">
                      <div class="pending-header">
                        <div class="d-flex align-items-center">
                          <i class="fas fa-arrow-down text-warning mr-2" style="font-size: 16px;"></i>
                          <span class="pending-title">Mutasi Masuk</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <span class="pending-badge bg-warning text-white" id="pending_mutasi_masuk">-</span>
                          <i class="fas fa-chevron-down chevron-icon" id="chevron_mutasi_masuk"></i>
                        </div>
                      </div>
                      <div class="pending-dropdown" id="dropdown_mutasi_masuk">
                        <table class="pending-table">
                          <thead>
                            <tr>
                              <th style="width: 40px;">No</th>
                              <th>Nomor Transaksi</th>
                              <th style="width: 100px;">Tanggal</th>
                              <th style="width: 100px;">Status</th>
                              <th style="width: 60px;" class="text-center">Aksi</th>
                            </tr>
                          </thead>
                          <tbody id="list_mutasi_masuk">
                            <tr>
                              <td colspan="5" class="empty-state">Memuat data...</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- Retur -->
                    <div class="pending-item" data-type="retur" onclick="toggleDropdown('retur')">
                      <div class="pending-header">
                        <div class="d-flex align-items-center">
                          <i class="fas fa-undo text-danger mr-2" style="font-size: 16px;"></i>
                          <span class="pending-title">Retur</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <span class="pending-badge bg-danger text-white" id="pending_retur">-</span>
                          <i class="fas fa-chevron-down chevron-icon" id="chevron_retur"></i>
                        </div>
                      </div>
                      <div class="pending-dropdown" id="dropdown_retur">
                        <table class="pending-table">
                          <thead>
                            <tr>
                              <th style="width: 40px;">No</th>
                              <th>Nomor Transaksi</th>
                              <th style="width: 100px;">Tanggal</th>
                              <th style="width: 100px;">Status</th>
                              <th style="width: 60px;" class="text-center">Aksi</th>
                            </tr>
                          </thead>
                          <tbody id="list_retur">
                            <tr>
                              <td colspan="5" class="empty-state">Memuat data...</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <?php if ($retur->status == 3 && $this->session->userdata('role') == 1) { ?>
              <!-- Keputusan Direksi -->
              <div class="row mt-2">
                <div class="col-md-12">
                  <div class="card card-outline card-danger shadow-sm">
                    <div class="card-header bg-danger">
                      <h3 class="card-title"><i class="fas fa-user-tie mr-1"></i> Keputusan Direksi</h3>
                    </div>
                    <div class="card-body">
                      <form action="<?= base_url('adm/Toko/tindakan') ?>" method="post" id="form_approve">
                        <div class="form-group">
                          <label for="catatan_direksi"><i class="fas fa-comment-dots"></i> Catatan Direksi: <span class="text-danger">*</span></label>
                          <textarea name="catatan_direksi" id="catatan_direksi" rows="3" class="form-control" placeholder="Masukkan catatan atau alasan keputusan..." required></textarea>
                          <small class="form-text text-muted"><i class="fas fa-info-circle"></i> Catatan wajib diisi</small>
                        </div>
                        <input type="hidden" name="id_pengajuan" value="<?= $retur->id ?>">
                        <input type="hidden" name="id_retur" value="<?= $retur->id_retur ?>">
                        <input type="hidden" name="id_toko" value="<?= $retur->id_toko ?>">
                        <input type="hidden" name="pembuat" value="<?= $retur->id_pembuat ?>">
                        <div class="form-group">
                          <label for="tindakan"><i class="fas fa-gavel"></i> Keputusan: <span class="text-danger">*</span></label>
                          <select name="tindakan" id="tindakan" class="form-control" required>
                            <option value="">-- Pilih Keputusan --</option>
                            <option value="4">✓ Setujui Pengajuan</option>
                            <option value="5">✗ Tolak Pengajuan</option>
                          </select>
                        </div>
                        <hr class="my-4">
                        <div class="card-footer py-3">
                          <div class="d-flex justify-content-between align-items-center">
                            <a href="<?= base_url('adm/Toko/toko_tutup') ?>" class="btn btn-secondary">
                              <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success btn_simpan">
                              <i class="fas fa-paper-plane mr-1"></i> Kirim Keputusan
                            </button>
                            <?php if ($retur->status == 7) : ?>
                              <button type="button" class="btn btn-warning btn-lg btn_suspend">
                                <i class="fas fa-ban mr-1"></i> Suspend Toko
                              </button>
                            <?php endif; ?>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php } else { ?>
              <!-- Suspend Information Panel -->
              <?php if ($retur->status == 6 && ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 15)) : ?>
                <div class="row mt-2 no-print" id="suspend_info_panel" style="display: none;">
                  <div class="col-12">
                    <div class="alert alert-warning border-0 shadow-sm mb-0">
                      <div class="d-flex align-items-start">
                        <i class="fas fa-lock text-warning mr-3" style="font-size: 24px; margin-top: 2px;"></i>
                        <div>
                          <h6 class="alert-heading mb-2"><strong>Tombol Suspend Terkunci</strong></h6>
                          <p class="mb-2" style="font-size: 14px;">Toko masih memiliki <strong id="total_pending_info">0</strong> transaksi pending yang harus diselesaikan terlebih dahulu sebelum melakukan suspend.</p>
                          <div id="pending_detail_info" class="small text-muted"></div>
                          <hr class="my-2">
                          <p class="mb-0 small"><i class="fas fa-info-circle"></i> Tombol suspend akan aktif secara otomatis ketika semua transaksi pending telah diselesaikan.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

              <!-- Action Buttons -->
              <div class="row mt-2 no-print">
                <div class="col-12">
                  <div class="card border-0 shadow-sm">
                    <div class="card-body py-3">
                      <div class="d-flex justify-content-between align-items-center">
                        <a href="<?= base_url('adm/Toko/pengajuanToko') ?>" class="btn btn-light border">
                          <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div>
                          <a href="<?= base_url('adm/Toko/fpo_tutup/' . $retur->id) ?>" target="_blank"
                            class="btn btn-outline-info <?= $retur->status != 6 ? 'disabled' : '' ?>">
                            <i class="fas fa-print"></i> Print FPO
                          </a>
                          <?php if ($retur->status == 6 && ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 15)) : ?>
                            <button type="button" class="btn btn-danger btn_suspend" id="btn_suspend">
                              <i class="fas fa-ban"></i> Suspend Toko
                            </button>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>

    </div>
  </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    function validateForm() {
      let isValid = true;
      // Get all required input fields
      $('#form_approve').find('input[required], select[required], textarea[required]').each(function() {
        if ($(this).val() === '') {
          isValid = false;
          $(this).addClass('is-invalid');
        } else {
          $(this).removeClass('is-invalid');
        }
      });
      return isValid;
    }
    $('.btn_simpan').click(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Konfirmasi Keputusan',
        text: "Apakah Anda yakin dengan keputusan ini? Data akan diproses dan dikirimkan.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Proses'
      }).then((result) => {
        if (result.isConfirmed) {

          if (validateForm()) {
            document.getElementById("form_approve").submit();
          } else {
            Swal.fire({
              title: 'Data Belum Lengkap',
              text: 'Harap lengkapi semua kolom yang wajib diisi.',
              icon: 'warning',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            });
          }
        }
      })
    })

    let totalPending = 0;

    $('.btn_suspend').click(function(e) {
      e.preventDefault();

      // Check if there are pending transactions
      if (totalPending > 0) {
        Swal.fire({
          title: 'Tidak Dapat Suspend!',
          html: `<div class="text-left">
                  <p>Toko masih memiliki <strong class="text-danger">${totalPending} transaksi pending</strong> yang harus diselesaikan terlebih dahulu.</p>
                  <hr>
                  <p class="mb-1"><strong>Transaksi yang harus diselesaikan:</strong></p>
                  <ul class="text-muted" style="font-size: 14px;">
                    ${$('#pending_po').text() > 0 ? '<li>PO Artikel: <strong>' + $('#pending_po').text() + '</strong></li>' : ''}
                    ${$('#pending_pengiriman').text() > 0 ? '<li>Pengiriman: <strong>' + $('#pending_pengiriman').text() + '</strong></li>' : ''}
                    ${$('#pending_mutasi_keluar').text() > 0 ? '<li>Mutasi Keluar: <strong>' + $('#pending_mutasi_keluar').text() + '</strong></li>' : ''}
                    ${$('#pending_mutasi_masuk').text() > 0 ? '<li>Mutasi Masuk: <strong>' + $('#pending_mutasi_masuk').text() + '</strong></li>' : ''}
                    ${$('#pending_retur').text() > 0 ? '<li>Retur: <strong>' + $('#pending_retur').text() + '</strong></li>' : ''}
                  </ul>
                  <p class="mt-2 text-info"><i class="fas fa-info-circle"></i> Selesaikan semua transaksi pending terlebih dahulu sebelum melakukan suspend.</p>
                </div>`,
          icon: 'warning',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Mengerti'
        });
        return false;
      }

      Swal.fire({
        title: 'Suspend Toko?',
        html: `<div class="text-left">
                <p>Apakah Anda yakin ingin suspend toko ini secara lengkap?</p>
                <hr>
                <div class="alert alert-danger mb-0">
                  <i class="fas fa-exclamation-triangle"></i> <strong>Peringatan:</strong>
                  <ul class="mb-0 mt-2">
                    <li>Tindakan ini tidak dapat dibatalkan</li>
                    <li>Semua stok barang akan diubah menjadi 0 secara otomatis</li>
                    <li>Toko tidak dapat melakukan transaksi</li>
                  </ul>
                </div>
              </div>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-ban"></i> Ya, Suspend!',
        cancelButtonText: '<i class="fas fa-times"></i> Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url('adm/Toko/Suspend/' . $retur->id) ?>";
        }
      });
    });


    // Load pending transactions count on page load
    loadPendingCounts();

    function printDiv(divName) {
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
    }
  });

  // Function to toggle dropdown
  function toggleDropdown(type) {
    const dropdown = document.getElementById('dropdown_' + type);
    const chevron = document.getElementById('chevron_' + type);

    // Close all other dropdowns
    document.querySelectorAll('.pending-dropdown').forEach(function(el) {
      if (el.id !== 'dropdown_' + type) {
        el.classList.remove('show');
      }
    });

    // Toggle chevrons
    document.querySelectorAll('.chevron-icon').forEach(function(el) {
      if (el.id !== 'chevron_' + type) {
        el.classList.remove('rotated');
      }
    });

    // Toggle current dropdown
    dropdown.classList.toggle('show');
    chevron.classList.toggle('rotated');
  }

  // Function to load pending transaction counts
  function loadPendingCounts() {
    const idToko = <?= $retur->id_toko ?>;
    const types = ['po', 'pengiriman', 'mutasi_keluar', 'mutasi_masuk', 'retur'];
    totalPending = 0;

    types.forEach(function(type) {
      $.ajax({
        url: '<?= base_url("adm/Toko/getPendingDetail") ?>',
        type: 'POST',
        data: {
          id_toko: idToko,
          type: type
        },
        dataType: 'json',
        success: function(response) {
          const count = (response.success && response.data) ? response.data.length : 0;
          $('#pending_' + type).text(count);
          totalPending += count;

          // Update suspend button state
          updateSuspendButton();

          // Update table list
          if (response.success && response.data.length > 0) {
            let html = '';
            response.data.forEach(function(item, index) {
              let statusBadge = '';
              let statusClass = 'bg-warning text-dark';

              // Use appropriate helper function based on type
              if (type === 'po') {
                statusBadge = item.status_text || 'Pending';
              } else if (type === 'pengiriman') {
                statusBadge = item.status_text || 'Pending';
              } else if (type === 'mutasi_keluar' || type === 'mutasi_masuk') {
                statusBadge = item.status_text || 'Pending';
              } else if (type === 'retur') {
                statusBadge = item.status_text || 'Pending';
              }

              html += '<tr>';
              html += '<td>' + (index + 1) + '</td>';
              html += '<td><strong>' + item.nomor + '</strong></td>';
              html += '<td>' + item.tanggal + '</td>';
              html += '<td><span class="status-badge ' + statusClass + '">' + statusBadge + '</span></td>';
              html += '<td class="text-center">';
              html += '<button class="btn btn-sm btn-outline-secondary" onclick="copyTransactionNumber(\'' + item.nomor + '\')" title="Copy Nomor">';
              html += '<i class="fas fa-copy"></i>';
              html += '</button>';
              html += '</td>';
              html += '</tr>';
            });
            $('#list_' + type).html(html);

            // Auto-open dropdown if there's data
            const dropdown = document.getElementById('dropdown_' + type);
            const chevron = document.getElementById('chevron_' + type);
            if (dropdown && chevron && !dropdown.classList.contains('show')) {
              dropdown.classList.add('show');
              chevron.classList.add('rotated');
            }
          } else {
            $('#list_' + type).html('<tr><td colspan="5" class="empty-state">Tidak ada data pending</td></tr>');
          }
        },
        error: function() {
          $('#pending_' + type).text('0');
          $('#list_' + type).html('<tr><td colspan="5" class="text-danger text-center py-2">Gagal memuat data</td></tr>');
        }
      });
    });
  }

  // Function to update suspend button state
  function updateSuspendButton() {
    const $suspendBtn = $('#btn_suspend');
    const $infoPanel = $('#suspend_info_panel');

    if ($suspendBtn.length) {
      if (totalPending > 0) {
        // Disable button and show as locked
        $suspendBtn.removeClass('btn-danger').addClass('btn-secondary');
        $suspendBtn.prop('disabled', true);
        $suspendBtn.html('<i class="fas fa-lock"></i> Suspend Terkunci');
        $suspendBtn.attr('title', 'Tidak dapat suspend - Masih ada ' + totalPending + ' transaksi pending');

        // Show info panel
        if ($infoPanel.length) {
          $('#total_pending_info').text(totalPending);

          // Build detail list
          let detailHtml = '<ul class="mb-0 pl-3">';
          if ($('#pending_po').text() > 0) detailHtml += '<li>PO Artikel: <strong>' + $('#pending_po').text() + '</strong> transaksi</li>';
          if ($('#pending_pengiriman').text() > 0) detailHtml += '<li>Pengiriman: <strong>' + $('#pending_pengiriman').text() + '</strong> transaksi</li>';
          if ($('#pending_mutasi_keluar').text() > 0) detailHtml += '<li>Mutasi Keluar: <strong>' + $('#pending_mutasi_keluar').text() + '</strong> transaksi</li>';
          if ($('#pending_mutasi_masuk').text() > 0) detailHtml += '<li>Mutasi Masuk: <strong>' + $('#pending_mutasi_masuk').text() + '</strong> transaksi</li>';
          if ($('#pending_retur').text() > 0) detailHtml += '<li>Retur: <strong>' + $('#pending_retur').text() + '</strong> transaksi</li>';
          detailHtml += '</ul>';

          $('#pending_detail_info').html(detailHtml);
          $infoPanel.slideDown();
        }
      } else {
        // Enable button and show as active
        $suspendBtn.removeClass('btn-secondary').addClass('btn-danger');
        $suspendBtn.prop('disabled', false);
        $suspendBtn.html('<i class="fas fa-ban"></i> Suspend Toko');
        $suspendBtn.attr('title', 'Suspend toko ini');

        // Hide info panel
        if ($infoPanel.length) {
          $infoPanel.slideUp();
        }
      }
    }
  }

  // Function to copy transaction number to clipboard
  function copyTransactionNumber(nomor) {
    navigator.clipboard.writeText(nomor).then(function() {
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Nomor berhasil dicopy: ' + nomor,
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
      });
    }).catch(function(err) {
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: 'Gagal copy nomor transaksi',
        showConfirmButton: false,
        timer: 2000
      });
    });
  }

  // Function to refresh pending data
  function refreshPendingData() {
    // Show loading toast
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'info',
      title: 'Memuat ulang data...',
      showConfirmButton: false,
      timer: 1000,
      timerProgressBar: true
    });

    // Reset pending counts and reload
    totalPending = 0;
    loadPendingCounts();

    // Show success after reload
    setTimeout(function() {
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Data berhasil dimuat ulang',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
      });
    }, 1500);
  }
</script>