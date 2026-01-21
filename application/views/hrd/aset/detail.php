<section class="content">
  <div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-2">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0 font-weight-bold"><i class="fas fa-box-open mr-1"></i>Detail Aset Toko</h5>
          <a href="<?= base_url('hrd/Aset/list_aset') ?>" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <!-- Store Information Card -->
        <div class="card border mb-3">
          <div class="card-body p-2">
            <div class="row align-items-center">
              <div class="col-lg-2 col-md-3 text-center mb-2 mb-md-0">
                <img src="<?= $toko ? base_url('assets/img/toko/' . $toko->foto_toko) : base_url('assets/img/toko/hicoop.png') ?>"
                  class="img-fluid rounded"
                  style="max-width: 80px; border: 2px solid #e9ecef;"
                  alt="foto toko">
                <div class="mt-1">
                  <small class="font-weight-bold d-block"><?= $toko ? $toko->nama_toko : 'Data toko tidak ditemukan.' ?></small>
                </div>
              </div>
              <div class="col-lg-10 col-md-9">
                <div class="row">
                  <div class="col-md-6 col-lg-3 mb-2">
                    <div class="d-flex align-items-center p-2 bg-light rounded">
                      <div class="mr-2"><i class="fas fa-map-marker-alt text-primary"></i></div>
                      <div class="flex-fill" style="min-width: 0;">
                        <small class="text-muted d-block" style="font-size: 0.85rem;">Alamat</small>
                        <small class="font-weight-bold text-truncate d-block" style="font-size: 0.95rem;"><?= $toko->alamat ?></small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 mb-2">
                    <div class="d-flex align-items-center p-2 bg-light rounded">
                      <div class="mr-2"><i class="fas fa-user-tie text-success"></i></div>
                      <div class="flex-fill" style="min-width: 0;">
                        <small class="text-muted d-block" style="font-size: 0.85rem;">Supervisor</small>
                        <small class="font-weight-bold text-truncate d-block" style="font-size: 0.95rem;"><?= $toko->spv ?></small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 mb-2">
                    <div class="d-flex align-items-center p-2 bg-light rounded">
                      <div class="mr-2"><i class="fas fa-users text-warning"></i></div>
                      <div class="flex-fill" style="min-width: 0;">
                        <small class="text-muted d-block" style="font-size: 0.85rem;">Team Leader</small>
                        <small class="font-weight-bold text-truncate d-block" style="font-size: 0.95rem;"><?= $toko->leader ?></small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 mb-2">
                    <div class="d-flex align-items-center p-2 bg-light rounded">
                      <div class="mr-2"><i class="fas fa-user text-info"></i></div>
                      <div class="flex-fill" style="min-width: 0;">
                        <small class="text-muted d-block" style="font-size: 0.85rem;">SPG</small>
                        <small class="font-weight-bold text-truncate d-block" style="font-size: 0.95rem;"><?= $toko->spg ?></small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Asset from GA Table -->
        <div class="card border mb-3">
          <div class="card-header bg-primary text-white p-2">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h6 class="mb-1">
                  <i class="fas fa-database mr-1"></i>Data Master Aset
                </h6>
                <small class="d-block" style="font-size: 0.75rem; opacity: 0.9;">
                  <i class="fas fa-info-circle mr-1"></i>Data acuan dari Tim HRD GA untuk pemeriksaan kondisi aset oleh SPG
                </small>
              </div>
              <?php if (in_array($this->session->userdata('role'), [1, 14, 17])): ?>
                <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modal-tambah">
                  <i class="fas fa-plus"></i> Tambah
                </button>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-sm table-hover mb-0">
                <thead class="bg-light" style="font-size: 0.9rem;">
                  <tr>
                    <th class="text-center" style="width: 40px;">No</th>
                    <th style="width: 80px;">Kode</th>
                    <th>No Aset</th>
                    <th>Nama Aset</th>
                    <th class="text-center" style="width: 70px;">Qty</th>
                    <th class="text-center" style="width: 60px;">Unit</th>
                    <th class="text-center" style="width: 80px;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  $total = 0;
                  if (!empty($list)) {
                    foreach ($list as $l) :
                      $no++;
                      $total += $l->qty;
                  ?>
                      <tr style="font-size: 0.95rem;">
                        <td class="text-center"><?= $no ?></td>
                        <td><span class="badge badge-secondary badge-sm"><?= $l->kode ?></span></td>
                        <td><strong><code style="font-size: 1rem;"><?= $l->no_aset ?></code></strong></td>
                        <td><?= $l->aset ?></td>
                        <td class="text-center">
                          <span class="badge badge-info"><?= $l->qty ?></span>
                        </td>
                        <td class="text-center"><small><?= $l->unit ?></small></td>
                        <td class="text-center">
                          <?php if (in_array($this->session->userdata('role'), [1, 14, 17])): ?>
                            <div class="btn-group btn-group-sm">
                              <button onclick="getUpdate('<?php echo $l->id; ?>')"
                                data-toggle="modal"
                                data-target="#modalUpdate"
                                class="btn btn-warning mr-1"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                              </button>
                              <a href="<?= base_url('hrd/Aset/hapus_asetToko/' . $l->id) ?>"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                class="btn btn-danger"
                                title="Hapus">
                                <i class="fas fa-trash"></i>
                              </a>
                            </div>
                          <?php else: ?>
                            <small class="text-muted">-</small>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php
                    endforeach;
                  } else {
                    ?>
                    <tr>
                      <td colspan="7" class="text-center py-3 text-muted">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        <small>Belum ada data aset</small>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
                <?php if (!empty($list)) { ?>
                  <tfoot class="bg-light" style="font-size: 0.85rem;">
                    <tr>
                      <td colspan="4" class="text-right font-weight-bold">Total:</td>
                      <td class="text-center">
                        <span class="badge badge-primary"><?= $total ?></span>
                      </td>
                      <td colspan="2"></td>
                    </tr>
                  </tfoot>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>

        <!-- SPG Asset Updates Table -->
        <div class="card border mb-3">
          <div class="card-header bg-info text-white p-2">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h6 class="mb-1">
                  <i class="fas fa-clipboard-check mr-1"></i>Laporan Kondisi Aset Terkini
                </h6>
                <small class="d-block" style="font-size: 0.75rem; opacity: 0.9;">
                  <i class="fas fa-calendar-alt mr-1"></i>Data kondisi realtime aset yang diperbarui rutin setiap bulan oleh SPG
                </small>
              </div>
              <?php if (!empty($aset_spg) && in_array($this->session->userdata('role'), [1, 14, 17])): ?>
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-reset">
                  <i class="fas fa-redo"></i> Reset Laporan
                </button>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-sm table-hover mb-0">
                <thead class="bg-light" style="font-size: 0.9rem;">
                  <tr>
                    <th class="text-center" style="width: 40px;">No</th>
                    <th style="width: 30%;">Aset</th>
                    <th class="text-center" style="width: 70px;">Qty</th>
                    <th>Keterangan</th>
                    <th class="text-center" style="width: 100px;">Tanggal</th>
                    <th class="text-center" style="width: 70px;">Foto</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  $total_spg = 0;
                  if (!empty($aset_spg)) {
                    foreach ($aset_spg as $l) :
                      $no++;
                      $total_spg += $l->qty;
                  ?>
                      <tr style="font-size: 0.95rem;">
                        <td class="text-center"><?= $no ?></td>
                        <td>
                          <strong><code style="font-size: 1rem;"><?= $l->no_aset ?></code></strong>
                          <div><?= $l->aset ?></div>
                        </td>
                        <td class="text-center">
                          <span class="badge badge-success"><?= $l->qty ?></span>
                        </td>
                        <td>
                          <small class="text-muted"><?= $l->keterangan ?></small>
                        </td>
                        <td class="text-center">
                          <small><?= date('d M Y', strtotime($l->tanggal)); ?></small>
                        </td>
                        <td class="text-center">
                          <button class="btn btn-info btn-sm"
                            onclick="getDetail('<?php echo $l->gambar; ?>')"
                            data-toggle="modal"
                            data-target="#modalFoto"
                            title="Lihat">
                            <i class="fa fa-image"></i>
                          </button>
                        </td>
                      </tr>
                    <?php
                    endforeach;
                  } else {
                    ?>
                    <tr>
                      <td colspan="6" class="text-center py-3 text-muted">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        <small>Belum ada update dari SPG</small>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
                <?php if (!empty($list)) { ?>
                  <tfoot class="bg-light" style="font-size: 0.85rem;">
                    <tr>
                      <td colspan="2" class="text-right font-weight-bold">Total:</td>
                      <td class="text-center">
                        <span class="badge badge-success"><?= $total_spg ?></span>
                      </td>
                      <td colspan="2"></td>
                    </tr>
                  </tfoot>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- Modal Reset Laporan -->
<div class="modal fade" id="modal-reset">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning p-3">
        <h5 class="modal-title mb-0">
          <i class="fas fa-exclamation-triangle mr-2"></i>Konfirmasi Reset Laporan
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <div class="alert alert-warning border-warning" role="alert">
          <div class="d-flex align-items-start">
            <i class="fas fa-exclamation-triangle fa-2x mr-3 mt-1"></i>
            <div>
              <h6 class="alert-heading mb-2">Perhatian!</h6>
              <p class="mb-0">Aksi ini akan menghapus <strong>semua laporan</strong> kondisi aset yang telah diinput oleh SPG untuk toko ini bulan ini.</p>
            </div>
          </div>
        </div>

        <div class="card border mb-3">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-md-6 mb-2">
                <label class="text-muted mb-1" style="font-size: 0.85rem;"><i class="fas fa-store mr-1"></i>Nama Toko</label>
                <div class="font-weight-bold"><?= $toko->nama_toko ?></div>
              </div>
              <div class="col-md-6 mb-2">
                <label class="text-muted mb-1" style="font-size: 0.85rem;"><i class="fas fa-list mr-1"></i>Total Laporan</label>
                <div class="font-weight-bold">
                  <span class="badge badge-warning" style="font-size: 1rem;"><?= !empty($aset_spg) ? count($aset_spg) : 0 ?></span> item akan dihapus
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php if (!empty($aset_spg)): ?>
          <div class="mb-3">
            <label class="font-weight-bold mb-2"><i class="fas fa-clipboard-list mr-1"></i>Detail Laporan yang akan dihapus:</label>
            <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
              <table class="table table-sm table-bordered mb-0">
                <thead class="bg-light sticky-top">
                  <tr>
                    <th style="width: 40px;" class="text-center">No</th>
                    <th style="width: 150px;">No Aset</th>
                    <th>Nama Aset</th>
                    <th style="width: 70px;" class="text-center">Qty</th>
                    <th style="width: 120px;" class="text-center">Tanggal Input</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($aset_spg as $item):
                    $no++;
                  ?>
                    <tr>
                      <td class="text-center"><?= $no ?></td>
                      <td><code><?= $item->no_aset ?></code></td>
                      <td><?= $item->aset ?></td>
                      <td class="text-center"><span class="badge badge-info"><?= $item->qty ?></span></td>
                      <td class="text-center"><small><?= date('d M Y', strtotime($item->tanggal)) ?></small></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>

        <div class="alert alert-danger border-danger mb-0" role="alert">
          <i class="fas fa-exclamation-circle mr-2"></i>
          <strong>Data yang dihapus tidak dapat dikembalikan!</strong> SPG harus menginput ulang seluruh laporan kondisi aset.
        </div>
      </div>
      <div class="modal-footer p-3 bg-light border-top">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times mr-1"></i> Batal
        </button>
        <button type="button" class="btn btn-warning" onclick="submitResetLaporan()">
          <i class="fas fa-redo mr-1"></i> Ya, Reset Laporan
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Tambah Aset -->
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white p-2">
        <h6 class="modal-title mb-0">
          <i class="fas fa-plus-circle mr-1"></i>Tambah Aset
        </h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="<?= base_url('hrd/Aset/tambah_aset_toko') ?>" role="form" enctype="multipart/form-data">
        <div class="modal-body p-3">
          <div class="mb-2 p-2 bg-light rounded">
            <small class="font-weight-bold"><i class="fas fa-store mr-1"></i><?= $toko->nama_toko ?></small>
          </div>

          <div class="form-group mb-2">
            <label for="id_aset" class="font-weight-bold" style="font-size: 0.85rem;">
              <i class="fas fa-list mr-1"></i>Pilih Aset <span class="text-danger">*</span>
            </label>
            <select name="id_aset" class="form-control form-control-sm select2" id="id_aset" required>
              <option value="">-- Pilih Aset --</option>
              <?php foreach ($aset as $s) : ?>
                <option value="<?= $s->id ?>">(<?= $s->kode ?>) <?= $s->aset ?></option>
              <?php endforeach ?>
            </select>
          </div>

          <div class="form-group mb-2">
            <label for="no_aset" style="font-size: 0.85rem;">
              <i class="fas fa-hashtag mr-1"></i>No Aset
            </label>
            <input type="text" name="no_aset" class="form-control form-control-sm bg-light" id="no_aset" readonly>
            <input type="hidden" name="no_urut" id="no_urut">
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group mb-2">
                <label for="qty" style="font-size: 0.85rem;">
                  <i class="fas fa-boxes mr-1"></i>Jumlah <span class="text-danger">*</span>
                </label>
                <input type="number" name="qty" class="form-control form-control-sm" placeholder="Qty" min="1" required>
                <input type="hidden" name="id_toko" value="<?= $toko->id ?>">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group mb-2">
                <label for="unit" style="font-size: 0.85rem;">
                  <i class="fas fa-tag mr-1"></i>Unit
                </label>
                <input type="text" name="unit" class="form-control form-control-sm bg-light" id="unit" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer p-2 bg-light">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i> Batal
          </button>
          <button type="submit" class="btn btn-sm btn-success">
            <i class="fas fa-save"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Update Aset -->
<div class="modal fade" id="modalUpdate">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning p-2">
        <h6 class="modal-title mb-0">
          <i class="fas fa-edit mr-1"></i>Update Aset
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="<?= base_url('hrd/Aset/update_asetToko') ?>" enctype="multipart/form-data">
        <div class="modal-body p-3">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold">
                  <i class="fas fa-barcode mr-1"></i>Kode Aset
                </label>
                <input type="text" name="kode" class="form-control bg-light" id="kode_edit" readonly>
                <input type="hidden" name="id" id="id_edit">
              </div>

              <div class="form-group">
                <label class="font-weight-bold">
                  <i class="fas fa-hashtag mr-1"></i>No Aset
                </label>
                <input type="text" name="no_aset" class="form-control bg-light" id="no_aset_edit" readonly>
              </div>

              <div class="form-group">
                <label class="font-weight-bold">
                  <i class="fas fa-box mr-1"></i>Nama Aset
                </label>
                <input type="text" name="aset" class="form-control bg-light" id="aset_edit" readonly>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold">
                  <i class="fas fa-boxes mr-1"></i>Jumlah <span class="text-danger">*</span>
                </label>
                <input type="number" name="qty" class="form-control form-control-lg" id="qty_edit" min="1" required>
                <small class="form-text text-muted">Masukkan jumlah aset yang tersedia</small>
              </div>

              <div class="form-group">
                <label class="font-weight-bold">
                  <i class="fas fa-tag mr-1"></i>Unit
                </label>
                <input type="text" name="unit" class="form-control bg-light" id="unit_edit" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i>Batal
          </button>
          <button type="submit" class="btn btn-warning">
            <i class="fas fa-save mr-1"></i>Update Data
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Foto Aset -->
<div class="modal fade" id="modalFoto">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white p-2">
        <h6 class="modal-title mb-0">
          <i class="fas fa-image mr-1"></i>Foto Aset
        </h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        <div class="text-center bg-dark" style="min-height: 300px; display: flex; align-items: center; justify-content: center;">
          <img src="" alt="Foto Aset" class="img-fluid" style="max-height: 400px; max-width: 100%;">
        </div>
      </div>
      <div class="modal-footer p-2 bg-light">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
          <i class="fas fa-times"></i> Tutup
        </button>
      </div>
    </div>
  </div>
</div>

<style>
  /* Minimalist Compact Styling */
  .card {
    border-radius: 6px;
  }

  .table-sm td,
  .table-sm th {
    padding: 0.4rem;
  }

  .table thead th {
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
  }

  .table tbody tr:hover {
    background-color: #f8f9fa;
  }

  .badge {
    font-weight: 500;
    padding: 0.25em 0.5em;
    font-size: 0.8rem;
  }

  .badge-sm {
    font-size: 0.7rem;
    padding: 0.2em 0.4em;
  }

  .btn-group-sm>.btn {
    padding: 0.2rem 0.4rem;
    font-size: 0.8rem;
  }

  .modal-content {
    border-radius: 6px;
  }

  code {
    background-color: #f1f3f5;
    padding: 2px 4px;
    border-radius: 3px;
    font-size: 0.85em;
  }

  .form-control-sm {
    font-size: 0.85rem;
  }

  .select2-container--default .select2-selection--single {
    height: calc(1.8rem + 2px) !important;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 1.8rem !important;
    font-size: 0.85rem;
  }

  @media (max-width: 768px) {
    .table-responsive {
      font-size: 0.8rem;
    }

    .btn-group-sm>.btn {
      padding: 0.15rem 0.3rem;
      font-size: 0.75rem;
    }
  }
</style>
<script>
  $(document).ready(function() {
    $('#id_aset').on('change', function() {
      var id_aset = $(this).val();
      updateNoSeri(id_aset);
    });

    function updateNoSeri(id_aset) {
      $.ajax({
        url: '<?= base_url('hrd/Aset/getLatestAsetNumber') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
          id_aset: id_aset
        },
        success: function(data) {
          if (typeof data.nomor_urut !== 'undefined' && !isNaN(data.nomor_urut)) {
            var no_urut = data.nomor_urut;
            var no_seri = data.kode_aset + "-" + no_urut;
            $('#no_aset').val(no_seri);
            $('#no_urut').val(no_urut);
            $('#unit').val(data.unit);
          } else {
            alert('Respon dari server tidak berisi nomor urut yang valid.');
          }
        },
        error: function() {
          alert('Gagal mengambil nomor urut dari server.');
        }
      });
    }



  });

  function getDetail(aset) {
    var timestamp = new Date().getTime();
    var fotoAset = aset ? "<?php echo base_url('assets/img/aset/toko/'); ?>" + aset + '?' + timestamp : "<?php echo base_url('assets/img/default.png'); ?>";
    var imgElement = $("#modalFoto img");
    imgElement.attr("src", fotoAset);
  }

  function getUpdate(aset) {
    $.ajax({
      url: "<?php echo base_url('hrd/Aset/get_asetToko'); ?>",
      method: "POST",
      data: {
        aset: aset
      },
      dataType: "json", // Ubah ke dataType "json" jika data yang diambil dari server adalah JSON
      success: function(data) {

        $("#id_edit").val(data.id);
        $("#kode_edit").val(data.kode);
        $("#aset_edit").val(data.aset);
        $("#qty_edit").val(data.qty);
        $("#unit_edit").val(data.unit);
        $("#no_aset_edit").val(data.no_aset);
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  }

  function submitResetLaporan() {
    // Collect all id_aset from aset_spg
    var id_aset_list = [];
    <?php if (!empty($aset_spg)): ?>
      <?php foreach ($aset_spg as $item): ?>
        id_aset_list.push('<?= $item->id ?>');
      <?php endforeach; ?>
    <?php endif; ?>

    // Prepare data to send
    var dataToSend = {
      id_toko: '<?= $toko->id ?>',
      id_aset_list: id_aset_list
    };

    // Show loading state
    Swal.fire({
      title: 'Memproses...',
      text: 'Sedang menghapus laporan',
      allowOutsideClick: false,
      allowEscapeKey: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });

    // Send AJAX request
    $.ajax({
      url: "<?= base_url('hrd/Aset/reset_laporan') ?>",
      method: "POST",
      data: dataToSend,
      dataType: "json",
      success: function(response) {
        $('#modal-reset').modal('hide');

        if (response.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: response.message,
            confirmButtonColor: '#28a745'
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: response.message,
            confirmButtonColor: '#dc3545'
          });
        }
      },
      error: function(xhr, status, error) {
        $('#modal-reset').modal('hide');
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Terjadi kesalahan saat memproses permintaan.',
          confirmButtonColor: '#dc3545'
        });
        console.error(xhr.responseText);
      }
    });
  }
</script>