<?php
$is_administrator = (string) $this->session->userdata('role') === '1';
$produk = is_array($list_data) ? $list_data : array();
$total_produk = count($produk);
$total_aktif = 0;
$total_nonaktif = 0;
$daftar_brand = array();

foreach ($produk as $item) {
  if ((int) $item->status === 1) {
    $total_aktif++;
  } else {
    $total_nonaktif++;
  }

  $brand = trim((string) $item->brand);
  if ($brand !== '') {
    $daftar_brand[strtolower($brand)] = $brand;
  }
}
?>

<style>
  .product-catalog {
    --product-ink: #172033;
    --product-muted: #64748b;
    --product-line: #e7edf4;
    padding: 18px 8px 30px;
    color: var(--product-ink);
  }

  .product-card {
    overflow: hidden;
    border: 1px solid var(--product-line);
    border-radius: 22px;
    box-shadow: 0 12px 32px rgba(15, 23, 42, .065);
  }

  .product-card > .product-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 25px 26px;
    color: #fff;
    background: radial-gradient(circle at 85% 0, rgba(125, 211, 252, .3), transparent 25%), linear-gradient(125deg, #0f172a 0%, #075985 62%, #0284c7 100%);
    border: 0;
  }

  .product-title-wrap { display: flex; min-width: 0; align-items: center; gap: 14px; }

  .product-title-icon {
    display: inline-flex;
    width: 48px;
    height: 48px;
    flex: 0 0 48px;
    align-items: center;
    justify-content: center;
    color: #e0f2fe;
    background: rgba(255, 255, 255, .12);
    border: 1px solid rgba(255, 255, 255, .14);
    border-radius: 15px;
    font-size: 20px;
  }

  .product-header h1 { margin: 0 0 4px; font-size: 22px; font-weight: 800; }
  .product-header p { margin: 0; color: rgba(255, 255, 255, .72); font-size: 12px; }

  .product-role-badge {
    padding: 7px 11px;
    color: #e0f2fe;
    background: rgba(255, 255, 255, .11);
    border: 1px solid rgba(255, 255, 255, .14);
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
  }

  .product-card > .card-body { padding: 22px 24px 25px; }

  .product-summary {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 12px;
    margin-bottom: 20px;
  }

  .product-stat {
    display: flex;
    min-width: 0;
    align-items: center;
    gap: 12px;
    padding: 15px;
    background: #fff;
    border: 1px solid var(--product-line);
    border-radius: 16px;
  }

  .product-stat-icon {
    display: inline-flex;
    width: 40px;
    height: 40px;
    flex: 0 0 40px;
    align-items: center;
    justify-content: center;
    color: var(--stat-color);
    background: var(--stat-bg);
    border-radius: 12px;
  }

  .product-stat.all { --stat-color: #0369a1; --stat-bg: #e0f2fe; }
  .product-stat.active { --stat-color: #15803d; --stat-bg: #dcfce7; }
  .product-stat.inactive { --stat-color: #b91c1c; --stat-bg: #fee2e2; }
  .product-stat.brand { --stat-color: #7c3aed; --stat-bg: #ede9fe; }
  .product-stat-value { display: block; overflow: hidden; font-size: 21px; font-weight: 800; line-height: 1.1; text-overflow: ellipsis; }
  .product-stat-label { color: var(--product-muted); font-size: 10px; font-weight: 600; }

  .product-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 18px;
    padding: 13px;
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 15px;
  }

  .product-toolbar-group { display: flex; flex-wrap: wrap; gap: 8px; }
  .product-toolbar .btn { padding: 8px 12px; border-radius: 10px; font-size: 11px; font-weight: 700; }
  .product-toolbar .btn i { margin-right: 5px; }
  .product-toolbar #toggleAktif,
  .product-toolbar #toggleNonAktif { margin-bottom: 0 !important; }

  .product-readonly-note {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
    padding: 12px 14px;
    color: #475569;
    background: #f8fafc;
    border: 1px solid var(--product-line);
    border-radius: 14px;
    font-size: 11px;
  }

  .product-readonly-note i { color: #0369a1; font-size: 15px; }

  .product-table-wrap {
    overflow-x: auto;
    border: 1px solid var(--product-line);
    border-radius: 16px;
  }

  .product-table-wrap .dataTables_wrapper { padding-top: 14px; }
  .product-table-wrap .dataTables_length,
  .product-table-wrap .dataTables_filter { padding: 0 14px 10px; color: var(--product-muted); font-size: 11px; }
  .product-table-wrap .dataTables_info { padding: 13px 14px !important; color: var(--product-muted); font-size: 11px; }
  .product-table-wrap .dataTables_paginate { padding: 8px 14px !important; }
  .product-table-wrap .dataTables_filter input,
  .product-table-wrap .dataTables_length select { min-height: 34px; border: 1px solid #dbe3ec; border-radius: 9px; }

  .product-table { width: 100% !important; margin: 0 !important; border: 0 !important; }
  .product-table thead th {
    padding: 11px 12px;
    vertical-align: middle;
    color: #64748b;
    background: #f8fafc;
    border-color: #e9eff5 !important;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .035em;
    text-transform: uppercase;
    white-space: nowrap;
  }

  .product-table tbody td {
    padding: 13px 12px;
    vertical-align: middle;
    color: #334155;
    border-color: #edf2f7 !important;
    font-size: 11px;
    text-align: left;
  }

  .product-table tbody tr { background: #fff; transition: background .18s ease; }
  .product-table tbody tr:hover { background: #f8fbfe !important; }
  .product-code { color: #0369a1; font-weight: 800; white-space: nowrap; }
  .product-name { min-width: 190px; font-weight: 600; }
  .product-price { color: #334155; font-variant-numeric: tabular-nums; font-weight: 600; white-space: nowrap; }
  .product-action { display: flex; justify-content: center; gap: 6px; }
  .product-action .btn { display: inline-flex; width: 31px; height: 31px; align-items: center; justify-content: center; padding: 0; border-radius: 9px; }
  .product-empty { padding: 42px 18px !important; color: var(--product-muted) !important; text-align: center !important; }
  .product-empty i { display: block; margin-bottom: 8px; color: #94a3b8; font-size: 22px; }

  .product-modal .modal-content { overflow: hidden; border: 0; border-radius: 18px; box-shadow: 0 22px 55px rgba(15, 23, 42, .18); }
  .product-modal .modal-header { padding: 18px 20px; background: #f8fafc; border-bottom-color: var(--product-line); }
  .product-modal .modal-title { color: var(--product-ink); font-size: 17px; font-weight: 800; }
  .product-modal .modal-body { padding: 20px; }
  .product-modal .modal-footer { padding: 14px 20px; background: #f8fafc; border-top-color: var(--product-line); }
  .product-modal label { margin-bottom: 5px; color: #475569; font-size: 11px; font-weight: 700; }
  .product-modal .form-control { min-height: 38px; border-color: #dbe3ec; border-radius: 9px; }

  @media (max-width: 991.98px) {
    .product-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  }

  @media (max-width: 767.98px) {
    .product-catalog { padding: 10px 0 22px; }
    .product-card { border-radius: 18px; }
    .product-card > .product-header { align-items: flex-start; padding: 21px 18px; }
    .product-role-badge { display: none; }
    .product-card > .card-body { padding: 17px 14px 20px; }
    .product-toolbar { align-items: stretch; flex-direction: column; }
    .product-toolbar-group .btn { flex: 1 1 auto; }
  }

  @media (max-width: 479.98px) {
    .product-summary { gap: 8px; }
    .product-stat { gap: 9px; padding: 12px; }
    .product-stat-icon { width: 36px; height: 36px; flex-basis: 36px; }
    .product-stat-value { font-size: 18px; }
  }
</style>

<section class="content product-catalog">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card product-card">
          <div class="card-header product-header">
            <div class="product-title-wrap">
              <span class="product-title-icon"><i class="fas fa-cubes"></i></span>
              <div>
                <h1>Data Artikel</h1>
                <p>Kelola dan pantau katalog artikel, harga, serta status ketersediaannya.</p>
              </div>
            </div>
            <span class="product-role-badge"><i class="fas <?= $is_administrator ? 'fa-user-shield' : 'fa-eye' ?> mr-1"></i><?= $is_administrator ? 'Mode Administrator' : 'Mode lihat' ?></span>
          </div>
          <div class="card-body">
            <div class="product-summary">
              <div class="product-stat all">
                <span class="product-stat-icon"><i class="fas fa-cubes"></i></span>
                <div><strong class="product-stat-value"><?= number_format($total_produk, 0, ',', '.') ?></strong><span class="product-stat-label">Total artikel</span></div>
              </div>
              <div class="product-stat active">
                <span class="product-stat-icon"><i class="fas fa-check-circle"></i></span>
                <div><strong class="product-stat-value"><?= number_format($total_aktif, 0, ',', '.') ?></strong><span class="product-stat-label">Artikel aktif</span></div>
              </div>
              <div class="product-stat inactive">
                <span class="product-stat-icon"><i class="fas fa-ban"></i></span>
                <div><strong class="product-stat-value"><?= number_format($total_nonaktif, 0, ',', '.') ?></strong><span class="product-stat-label">Tidak aktif</span></div>
              </div>
              <div class="product-stat brand">
                <span class="product-stat-icon"><i class="fas fa-tags"></i></span>
                <div><strong class="product-stat-value"><?= number_format(count($daftar_brand), 0, ',', '.') ?></strong><span class="product-stat-label">Brand terdaftar</span></div>
              </div>
            </div>

            <?php if ($is_administrator) { ?>
              <div class="product-toolbar">
                <div class="product-toolbar-group">
                <button type="button" id="toggleAktif" class="btn btn-sm btn-primary" style="display: none; margin-bottom: 10px;"><i class="fas fa-check-circle"></i> AKTIFKAN</button>
                <button type="button" id="toggleNonAktif" class="btn btn-sm btn-danger" style="display: none; margin-bottom: 10px;"><i class="fas fa-ban"></i> NON AKTIFKAN</button>
                </div>
                <div class="product-toolbar-group">
                <a href="<?= base_url('adm/Produk/template_artikel') ?>" class="btn btn-warning btn-sm"><i class="fas fa-download"></i>
                  Unduh template
                </a>
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-import"><i class="fas fa-upload"></i>
                  Import artikel
                </button>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i>
                  Tambah artikel
                </button>
                </div>
              </div>
            <?php } else { ?>
              <div class="product-readonly-note"><i class="fas fa-info-circle"></i><span>Anda memiliki akses lihat. Pengelolaan artikel hanya tersedia untuk Administrator.</span></div>
            <?php } ?>

            <div class="product-table-wrap">
            <table id="example1" class="table product-table">
              <thead>
                <tr>
                  <?php if ($is_administrator) { ?><th rowspan="2" class="text-center"><input type="checkbox" id="checkAll" aria-label="Pilih semua artikel"></th><?php } ?>
                  <th rowspan="2" style="width:10%" class="text-center">No Rak</th>
                  <th rowspan="2" style="width:10%" class="text-center">Kode</th>
                  <th rowspan="2" class="text-center">Nama Artikel</th>
                  <th rowspan="2">Satuan</th>
                  <th rowspan="2">Brand</th>
                  <th rowspan="2">Min-Pack</th>
                  <th colspan="3" class="text-center">HET</th>
                  <th rowspan="2" style="width:10%" class="text-center">Status</th>
                  <?php if ($is_administrator) { ?><th rowspan="2" class="text-center">Aksi</th><?php } ?>
                </tr>
                <tr>
                  <th class="text-center">Jawa</th>
                  <th class="text-center">IndoBarat</th>
                  <th class="text-center">SP</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($produk as $dd) : ?>
                  <tr>
                    <?php if ($is_administrator) { ?><td class="text-center"><input type="checkbox" class="rowCheck" value="<?= (int) $dd->id ?>" aria-label="Pilih artikel <?= html_escape($dd->kode) ?>"></td><?php } ?>
                    <td class="text-center"><strong><?= $dd->no_rak ? html_escape($dd->no_rak) : '-' ?></strong></td>
                    <td><span class="product-code"><?= html_escape($dd->kode) ?></span></td>
                    <td class="product-name"><?= html_escape($dd->nama_produk) ?></td>
                    <td><?= html_escape($dd->satuan) ?></td>
                    <td><?= $dd->brand ? html_escape($dd->brand) : '-' ?></td>
                    <td><?= number_format((int) $dd->packing, 0, ',', '.') ?></td>
                    <td class="text-right product-price">Rp <?= number_format((float) $dd->harga_jawa, 0, ',', '.') ?></td>
                    <td class="text-right product-price">Rp <?= number_format((float) $dd->harga_indobarat, 0, ',', '.') ?></td>
                    <td class="text-right product-price">Rp <?= number_format((float) $dd->sp, 0, ',', '.') ?></td>
                    <td class="text-center"><?= status_artikel($dd->status) ?></td>
                    <?php if ($is_administrator) { ?>
                      <td>
                        <div class="product-action">
                          <button type="button" class="btn btn-warning btn-edit btn-sm" data-toggle="modal" data-target="#editModal" data-id="<?= (int) $dd->id ?>" data-kode="<?= html_escape($dd->kode) ?>" data-status="<?= (int) $dd->status ?>" data-packing="<?= (int) $dd->packing ?>" data-brand="<?= html_escape($dd->brand) ?>" data-nama_produk="<?= html_escape($dd->nama_produk) ?>" data-harga1="<?= (float) $dd->harga_jawa ?>" data-harga2="<?= (float) $dd->harga_indobarat ?>" data-satuan="<?= html_escape($dd->satuan) ?>" data-sp="<?= (float) $dd->sp ?>" title="Edit artikel" aria-label="Edit <?= html_escape($dd->kode) ?>">
                            <i class="fas fa-edit"></i>
                          </button>
                          <a class="btn btn-danger btn-hapus btn-sm" href="<?= base_url('adm/produk/hapus/' . (int) $dd->id) ?>" title="Nonaktifkan artikel" aria-label="Nonaktifkan <?= html_escape($dd->kode) ?>"><i class="fas fa-ban"></i></a>
                        </div>
                      </td>
                    <?php } ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php if ($is_administrator) { ?>
<div class="modal fade product-modal" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahTitle" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="<?= base_url('adm/produk/proses_tambah') ?>">
      <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalTambahTitle"><i class="fas fa-plus-circle mr-1"></i> Tambah Artikel</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group mb-1">
            <label for="kode_tambah">Kode Artikel</label>
            <input type="text" name="kode" id="kode_tambah" class="form-control form-control-sm" autocomplete="off" placeholder="Contoh: ART-001" required>
          </div>
          <div class="form-group mb-1">
            <label for="nama">Deskripsi</label>
            <input type="text" name="nama" class="form-control form-control-sm" autocomplete="off" id="nama" placeholder="Nama Artikel" required>
          </div>
          <div class="form-group mb-1">
            <label for="satuan_tambah">Satuan</label>
            <select class="form-control form-control-sm" id="satuan_tambah" name="satuan" required>
              <option value="">- Pilih Satuan -</option>
              <option value="Bnd">Bnd</option>
              <option value="Box">Box</option>
              <option value="Pcs">Pcs</option>
              <option value="Pck">Pck</option>
              <option value="Psg">Psg</option>
            </select>
          </div>
          <div class="form-group mb-1">
            <label>Brand</label>
            <input type="text" class="form-control form-control-sm" name="brand" placeholder="Brand Produk...">
          </div>
          <div class="form-group mb-1">
            <label>Min-Packing</label>
            <input type="number" class="form-control form-control-sm" name="packing" placeholder="0" required>
          </div>
          <div class="form-group mb-1">
            <label>HET Jawa</label>
            <input type="text" class="form-control form-control-sm" id="jawa_add" name="harga_jawa" placeholder=" Rp 0..." required>
          </div>
          <div class="form-group mb-1">
            <label>HET Indobarat</label>
            <input type="text" class="form-control form-control-sm" id="indo_add" name="harga_indo" placeholder="Rp 0..." required>
          </div>
          <div class="form-group mb-1">
            <label>SP</label>
            <input type="text" class="form-control form-control-sm" id="sp_add" name="sp" placeholder="Rp 0..." required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
          <i class="fas fa-times-circle"></i> Batal
        </button>
        <button type="submit" class="btn btn-success btn-sm">
          <i class="fas fa-save"></i> Simpan
        </button>
      </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade product-modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('adm/produk/proses_update') ?>" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalTitle"><i class="fas fa-edit mr-1"></i> Edit Artikel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-1">
            <label>Kode Artikel</label>
            <input type="text" class="form-control form-control-sm kode" name="kode" required>
          </div>
          <div class="form-group mb-1">
            <label>Nama Artikel</label>
            <input type="text" class="form-control form-control-sm nama_produk" name="nama_produk" required>
          </div>
          <div class="form-group mb-1">
            <label for="satuan_edit">Satuan</label>
            <select class="form-control form-control-sm" id="satuan_edit" name="satuan" required>
              <option value="">-- Pilih Satuan --</option>
              <option value="Bnd">Bnd</option>
              <option value="Box">Box</option>
              <option value="Pcs">Pcs</option>
              <option value="Pck">Pck</option>
              <option value="Psg">Psg</option>
            </select>
          </div>
          <div class="form-group mb-1">
            <label>Brand</label>
            <input type="text" class="form-control form-control-sm" id="brand_edit" name="brand">
          </div>
          <div class="form-group mb-1">
            <label>Min-Packing</label>
            <input type="number" class="form-control form-control-sm" id="packing_edit" name="packing" placeholder="0" required>
          </div>
          <div class="form-group mb-1">
            <label>HET Jawa</label>
            <input type="text" class="form-control form-control-sm harga1" id="jawa_edit" name="harga_jawa" required>
          </div>
          <div class="form-group mb-1">
            <label>HET Indobarat</label>
            <input type="text" class="form-control form-control-sm harga2" id="indo_edit" name="harga_indo" required>
          </div>
          <div class="form-group mb-1">
            <label>SP</label>
            <input type="text" class="form-control form-control-sm sp" id="sp_edit" name="sp" required>
          </div>
          <div class="form-group mb-1">
            <label>Status</label>
            <select class="form-control form-control-sm" name="status" id="status_edit" required>
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
            <i class="fas fa-times-circle"></i> Batal
          </button>
          <input type="hidden" name="id" class="id">
          <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa-save"></i> Simpan perubahan
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade product-modal" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modalImportTitle" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" enctype="multipart/form-data" action="<?= base_url('adm/Produk/import_artikel') ?>">
      <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalImportTitle">
          <i class="fas fa-file-excel mr-1"></i> Import Artikel
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputFile">Pilih file Excel</label>
            <input type="file" name="file" class="form-control" id="exampleInputFile" accept=".xlsx,.xls" required>
            <small class="form-text text-muted">Gunakan format template artikel (.xlsx atau .xls).</small>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
          <i class="fas fa-times-circle"></i> Batal
        </button>
        <button type="submit" class="btn btn-primary btn-sm">
          <i class="fas fa-upload"></i> Import data
        </button>
      </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal Konfirmasi -->
<div id="confirmModal" class="modal fade product-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Perubahan Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="confirmMessage"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" id="confirmAction" class="btn btn-primary">Ya, Lanjutkan</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#jawa_add, #indo_add, #sp_add,#jawa_edit, #indo_edit, #sp_edit').on('keyup', function() {
      var angka = $(this).val().replace(/[Rp.,]/g, '');
      var rupiah = formatRupiah(angka);
      $(this).val(rupiah);
    });
    $('.btn-edit').on('click', function() {
      const id = $(this).data('id');
      const kode = $(this).data('kode');
      const nama_produk = $(this).data('nama_produk');
      const deskripsi = $(this).data('deskripsi');
      const satuan = $(this).data('satuan');
      const packing = $(this).data('packing');
      const brand = $(this).data('brand');
      const harga1 = $(this).data('harga1');
      const harga2 = $(this).data('harga2');
      const status = $(this).data('status');
      const sp = $(this).data('sp');
      $('.id').val(id);
      $('.nama_produk').val(nama_produk);
      $('.kode').val(kode);
      $('#satuan_edit').val(satuan).trigger('change');
      $('#status_edit').val(status).trigger('change');
      $('#packing_edit').val(packing);
      $('#brand_edit').val(brand);
      $('.deskripsi').val(deskripsi);
      $('.harga1').val(harga1);
      $('.harga2').val(harga2);
      $('.sp').val(sp);
      $('#editModal').modal('show');
    });
  })
</script>
<script>
  function formatRupiah(angka) {
    var number_string = angka.toString().replace(/[^,\d]/g, ""),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return "Rp " + rupiah;
  }
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const checkAll = document.getElementById("checkAll");
    const rowChecks = document.querySelectorAll(".rowCheck");
    const toggleAktifBtn = document.getElementById("toggleAktif");
    const toggleNonAktifBtn = document.getElementById("toggleNonAktif");
    const confirmModal = document.getElementById("confirmModal");
    const confirmMessage = document.getElementById("confirmMessage");
    const confirmAction = document.getElementById("confirmAction");
    let selectedIds = [];
    let actionType = "";

    checkAll.addEventListener("change", function() {
      rowChecks.forEach(checkbox => checkbox.checked = checkAll.checked);
      updateToggleButtons();
    });

    rowChecks.forEach(checkbox => {
      checkbox.addEventListener("change", function() {
        updateToggleButtons();
      });
    });

    function updateToggleButtons() {
      let anyChecked = Array.from(rowChecks).some(checkbox => checkbox.checked);
      toggleAktifBtn.style.display = anyChecked ? "inline-block" : "none";
      toggleNonAktifBtn.style.display = anyChecked ? "inline-block" : "none";
    }

    [toggleAktifBtn, toggleNonAktifBtn].forEach(button => {
      button.addEventListener("click", function() {
        selectedIds = Array.from(rowChecks)
          .filter(checkbox => checkbox.checked)
          .map(checkbox => checkbox.value);

        if (selectedIds.length > 0) {
          actionType = this.id === "toggleAktif" ? "aktifkan" : "nonaktifkan";
          confirmMessage.textContent = `Apakah Anda yakin ingin ${actionType} ${selectedIds.length} artikel yang dipilih?`;
          $("#confirmModal").modal("show");
        }
      });
    });

    confirmAction.addEventListener("click", function() {
      fetch("<?= base_url('adm/produk/update_status') ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            ids: selectedIds,
            status: actionType === "aktifkan" ? 1 : 0
          })
        })
        .then(response => response.json())
        .then(data => {
          alert(data.message);
          $("#confirmModal").modal("hide"); // Modal ditutup setelah request sukses
          location.reload();
        })
        .catch(error => {
          console.error("Error:", error);
          alert("Terjadi kesalahan, coba lagi.");
        });
    });

  });
</script>
<?php } ?>
