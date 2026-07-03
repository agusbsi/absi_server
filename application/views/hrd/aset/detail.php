<?php
$toko_tersedia = !empty($toko);
$jumlah_master = !empty($list) ? count($list) : 0;
$jumlah_laporan = !empty($aset_spg) ? count($aset_spg) : 0;
$total_master = 0;
$total_laporan = 0;

if (!empty($list)) {
  foreach ($list as $item_master) {
    $total_master += (int) $item_master->qty;
  }
}

if (!empty($aset_spg)) {
  foreach ($aset_spg as $item_laporan) {
    $total_laporan += (int) $item_laporan->qty;
  }
}
?>

<section class="content aset-detail-page">
  <div class="container-fluid">
    <div class="asset-hero mb-4">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div class="d-flex align-items-center mb-3 mb-md-0">
          <div class="hero-icon mr-3"><i class="fas fa-boxes"></i></div>
          <div>
            <div class="hero-eyebrow">INVENTARIS TOKO</div>
            <h4 class="mb-1 font-weight-bold">Detail Aset Toko</h4>
            <p class="mb-0">Pantau data master dan laporan kondisi aset dalam satu halaman.</p>
          </div>
        </div>
        <a href="<?= base_url('hrd/Aset/list_aset') ?>" class="btn btn-light hero-back-btn">
          <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
      </div>
    </div>

    <div class="row summary-row">
      <div class="col-6 col-xl-3 mb-3">
        <div class="summary-card summary-blue">
          <div><span>Jenis Aset</span><strong><?= number_format($jumlah_master) ?></strong><small>terdaftar di master</small></div>
          <i class="fas fa-cubes"></i>
        </div>
      </div>
      <div class="col-6 col-xl-3 mb-3">
        <div class="summary-card summary-indigo">
          <div><span>Total Unit</span><strong><?= number_format($total_master) ?></strong><small>unit aset tercatat</small></div>
          <i class="fas fa-layer-group"></i>
        </div>
      </div>
      <div class="col-6 col-xl-3 mb-3">
        <div class="summary-card summary-cyan">
          <div><span>Laporan SPG</span><strong><?= number_format($jumlah_laporan) ?></strong><small>pembaruan kondisi</small></div>
          <i class="fas fa-clipboard-check"></i>
        </div>
      </div>
      <div class="col-6 col-xl-3 mb-3">
        <div class="summary-card summary-green">
          <div><span>Unit Dilaporkan</span><strong><?= number_format($total_laporan) ?></strong><small>dalam laporan terkini</small></div>
          <i class="fas fa-check-circle"></i>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <!-- Store Information Card -->
        <div class="card store-profile-card mb-4">
          <div class="card-body p-0">
            <div class="row no-gutters align-items-stretch">
              <div class="col-lg-4 profile-main">
                <div class="store-identity">
                  <img src="<?= $toko_tersedia && !empty($toko->foto_toko) ? base_url('assets/img/toko/' . $toko->foto_toko) : base_url('assets/img/toko/hicoop.png') ?>"
                    class="store-photo"
                    alt="Foto <?= $toko_tersedia ? html_escape($toko->nama_toko) : 'toko' ?>">
                  <div class="store-name-wrap">
                    <span class="store-label"><i class="fas fa-store mr-1"></i>PROFIL TOKO</span>
                    <h5><?= $toko_tersedia ? html_escape($toko->nama_toko) : 'Data toko tidak ditemukan' ?></h5>
                    <span class="status-pill">
                      <i class="fas fa-circle mr-1"></i><?= $toko_tersedia ? 'Data aktif' : 'Data tidak tersedia' ?>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-lg-8 profile-details">
                <div class="row">
                  <div class="col-sm-6 col-xl-3 mb-2">
                    <div class="store-info-item">
                      <div class="info-icon text-primary"><i class="fas fa-map-marker-alt"></i></div>
                      <div class="info-content">
                        <small>Alamat</small>
                        <strong title="<?= $toko_tersedia ? html_escape($toko->alamat) : '-' ?>"><?= $toko_tersedia ? html_escape($toko->alamat) : '-' ?></strong>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-xl-3 mb-2">
                    <div class="store-info-item">
                      <div class="info-icon text-success"><i class="fas fa-user-tie"></i></div>
                      <div class="info-content">
                        <small>Supervisor</small>
                        <strong><?= $toko_tersedia && !empty($toko->spv) ? html_escape($toko->spv) : '-' ?></strong>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-xl-3 mb-2">
                    <div class="store-info-item">
                      <div class="info-icon text-warning"><i class="fas fa-users"></i></div>
                      <div class="info-content">
                        <small>Team Leader</small>
                        <strong><?= $toko_tersedia && !empty($toko->leader) ? html_escape($toko->leader) : '-' ?></strong>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-xl-3 mb-2">
                    <div class="store-info-item">
                      <div class="info-icon text-info"><i class="fas fa-user"></i></div>
                      <div class="info-content">
                        <small>SPG</small>
                        <strong><?= $toko_tersedia && !empty($toko->spg) ? html_escape($toko->spg) : '-' ?></strong>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Asset from GA Table -->
        <div class="card data-card master-card mb-4">
          <div class="card-header section-card-header">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h6 class="mb-1 font-weight-bold">
                  <i class="fas fa-database mr-1"></i>Data Master Aset
                </h6>
                <small class="d-block" style="font-size: 0.75rem; opacity: 0.9;">
                  <i class="fas fa-info-circle mr-1"></i>Data acuan dari Tim HRD GA untuk pemeriksaan kondisi aset oleh SPG
                </small>
              </div>
              <?php if (in_array($this->session->userdata('role'), [1, 14, 17])): ?>
                <button type="button" class="btn btn-primary btn-sm action-btn" data-toggle="modal" data-target="#modal-tambah">
                  <i class="fas fa-plus mr-1"></i>Tambah Aset
                </button>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table asset-table table-hover mb-0">
                <thead>
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
                      <tr>
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
        <div class="card data-card report-card mb-4">
          <div class="card-header section-card-header">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h6 class="mb-1 font-weight-bold">
                  <i class="fas fa-clipboard-check mr-1"></i>Laporan Kondisi Aset Terkini
                </h6>
                <small class="d-block" style="font-size: 0.75rem; opacity: 0.9;">
                  <i class="fas fa-calendar-alt mr-1"></i>Data kondisi realtime aset yang diperbarui rutin setiap bulan oleh SPG
                </small>
              </div>
              <?php if (!empty($aset_spg) && in_array($this->session->userdata('role'), [1, 14, 17])): ?>
                <button type="button" class="btn btn-outline-warning btn-sm action-btn" data-toggle="modal" data-target="#modal-reset">
                  <i class="fas fa-redo mr-1"></i>Reset Laporan
                </button>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table asset-table table-hover mb-0">
                <thead>
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
                      <tr>
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
                <?php if (!empty($aset_spg)) { ?>
                  <tfoot class="bg-light" style="font-size: 0.85rem;">
                    <tr>
                      <td colspan="2" class="text-right font-weight-bold">Total:</td>
                      <td class="text-center">
                        <span class="badge badge-success"><?= $total_spg ?></span>
                      </td>
                      <td colspan="3"></td>
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
  .aset-detail-page {
    --asset-primary: #2563eb;
    --asset-navy: #172554;
    --asset-muted: #64748b;
    --asset-border: #e2e8f0;
    --asset-surface: #f8fafc;
    padding-top: 8px;
    padding-bottom: 28px;
  }

  .asset-hero {
    position: relative;
    overflow: hidden;
    padding: 24px 28px;
    color: #fff;
    border-radius: 16px;
    background: linear-gradient(125deg, #172554 0%, #1d4ed8 68%, #0ea5e9 100%);
    box-shadow: 0 12px 30px rgba(30, 64, 175, .18);
  }

  .asset-hero:after {
    content: "";
    position: absolute;
    width: 210px;
    height: 210px;
    right: 14%;
    top: -140px;
    border: 35px solid rgba(255, 255, 255, .08);
    border-radius: 50%;
  }

  .asset-hero>div { position: relative; z-index: 1; }
  .asset-hero h4 { letter-spacing: -.35px; }
  .asset-hero p { color: rgba(255, 255, 255, .78); font-size: .9rem; }
  .hero-eyebrow { color: #bae6fd; font-size: .7rem; font-weight: 700; letter-spacing: 1.5px; }
  .hero-icon { display: flex; width: 54px; height: 54px; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,.22); border-radius: 14px; background: rgba(255,255,255,.13); font-size: 1.35rem; }
  .hero-back-btn { border: 0; border-radius: 9px; color: #1e3a8a; font-weight: 600; box-shadow: 0 5px 14px rgba(15,23,42,.12); }

  .summary-card {
    display: flex;
    min-height: 118px;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    border: 1px solid var(--asset-border);
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 4px 16px rgba(15, 23, 42, .045);
  }

  .summary-card span, .summary-card small { display: block; color: var(--asset-muted); }
  .summary-card span { margin-bottom: 2px; font-size: .78rem; font-weight: 600; text-transform: uppercase; letter-spacing: .45px; }
  .summary-card strong { display: block; color: #0f172a; font-size: 1.65rem; line-height: 1.15; }
  .summary-card small { margin-top: 3px; font-size: .74rem; }
  .summary-card>i { display: flex; width: 44px; height: 44px; flex-shrink: 0; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.1rem; }
  .summary-blue>i { color: #2563eb; background: #dbeafe; }
  .summary-indigo>i { color: #7c3aed; background: #ede9fe; }
  .summary-cyan>i { color: #0891b2; background: #cffafe; }
  .summary-green>i { color: #059669; background: #d1fae5; }

  .store-profile-card, .data-card { border: 1px solid var(--asset-border); border-radius: 14px; box-shadow: 0 5px 18px rgba(15, 23, 42, .05); }
  .store-profile-card { overflow: hidden; }
  .profile-main { display: flex; background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 100%); }
  .profile-details { display: flex; align-items: center; padding: 20px 20px 12px; }
  .profile-details>.row { width: 100%; }
  .store-identity { display: flex; width: 100%; min-height: 132px; align-items: center; padding: 24px; border-right: 1px solid var(--asset-border); }
  .store-photo { width: 82px; height: 82px; flex-shrink: 0; margin-right: 18px; border: 4px solid #fff; border-radius: 18px; object-fit: cover; box-shadow: 0 6px 18px rgba(30,64,175,.16); }
  .store-name-wrap { min-width: 0; flex: 1; }
  .store-label { display: block; margin-bottom: 5px; color: var(--asset-primary); font-size: .67rem; font-weight: 700; letter-spacing: 1px; }
  .store-name-wrap h5 { margin: 0 0 9px; color: #0f172a; font-size: 1.12rem; font-weight: 750; line-height: 1.35; overflow-wrap: anywhere; white-space: normal; }
  .status-pill { display: inline-block; padding: 3px 8px; color: #047857; border-radius: 20px; background: #d1fae5; font-size: .7rem; font-weight: 600; }
  .status-pill i { font-size: .45rem; vertical-align: middle; }
  .store-info-item { display: flex; min-height: 72px; align-items: center; padding: 12px; border-radius: 10px; background: var(--asset-surface); }
  .info-icon { display: flex; width: 34px; height: 34px; flex-shrink: 0; align-items: center; justify-content: center; margin-right: 10px; border-radius: 9px; background: #fff; box-shadow: 0 2px 8px rgba(15,23,42,.07); }
  .info-content { min-width: 0; }
  .info-content small, .info-content strong { display: block; }
  .info-content small { margin-bottom: 1px; color: var(--asset-muted); font-size: .72rem; }
  .info-content strong { overflow: hidden; color: #334155; font-size: .82rem; text-overflow: ellipsis; white-space: nowrap; }

  .data-card { overflow: hidden; }
  .section-card-header { padding: 17px 20px; border-bottom: 1px solid var(--asset-border); background: #fff; }
  .section-card-header h6 { color: #0f172a; }
  .section-card-header h6 i { display: inline-flex; width: 28px; height: 28px; align-items: center; justify-content: center; margin-right: 7px !important; border-radius: 8px; }
  .master-card .section-card-header h6 i { color: #2563eb; background: #dbeafe; }
  .report-card .section-card-header h6 i { color: #0891b2; background: #cffafe; }
  .section-card-header small { margin-left: 39px; color: var(--asset-muted); }
  .action-btn { border-radius: 8px; font-weight: 600; white-space: nowrap; }

  .asset-table { color: #334155; font-size: .88rem; }
  .asset-table thead th { padding: 12px 10px; color: #64748b; border-top: 0; border-bottom: 1px solid var(--asset-border); background: var(--asset-surface); font-size: .69rem; font-weight: 700; letter-spacing: .55px; text-transform: uppercase; vertical-align: middle; white-space: nowrap; }
  .asset-table tbody td { padding: 12px 10px; border-color: #edf2f7; vertical-align: middle; }
  .asset-table tbody tr:hover { background: #f8fbff; }
  .asset-table tfoot td { padding: 11px 10px; border-top: 1px solid var(--asset-border); }
  .asset-table code { padding: 4px 7px; color: #1d4ed8; border-radius: 5px; background: #eff6ff; font-size: .82rem; }
  .asset-table .badge { padding: .38em .62em; border-radius: 6px; font-weight: 600; }
  .btn-group-sm>.btn { border-radius: 6px !important; }

  .modal-content { overflow: hidden; border: 0; border-radius: 14px; box-shadow: 0 20px 60px rgba(15,23,42,.22); }
  .modal-header { border-bottom: 0; }
  .form-control { border-color: #dbe3ec; border-radius: 8px; }
  .form-control:focus { border-color: #60a5fa; box-shadow: 0 0 0 .18rem rgba(59,130,246,.12); }

  @media (max-width: 991.98px) {
    .asset-hero { padding: 20px; }
    .store-identity { min-height: 0; border-right: 0; border-bottom: 1px solid var(--asset-border); }
    .profile-details { padding-top: 16px; }
  }

  @media (max-width: 767.98px) {
    .asset-hero h4 { font-size: 1.25rem; }
    .hero-icon { width: 46px; height: 46px; }
    .hero-back-btn { width: 100%; }
    .store-identity { padding: 20px; }
    .store-photo { width: 72px; height: 72px; margin-right: 15px; }
    .store-name-wrap h5 { font-size: 1rem; }
    .profile-details { padding: 15px 15px 7px; }
    .summary-card { min-height: 105px; padding: 15px; }
    .summary-card strong { font-size: 1.4rem; }
    .summary-card>i { width: 36px; height: 36px; }
    .section-card-header { padding: 14px; }
    .section-card-header>div { align-items: flex-start !important; }
    .section-card-header small { margin-left: 0; }
    .asset-table { min-width: 700px; }
    .table-responsive { font-size: .8rem; }
  }

  @media (max-width: 420px) {
    .summary-row .col-6 { flex: 0 0 100%; max-width: 100%; }
    .summary-card { min-height: 96px; }
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
