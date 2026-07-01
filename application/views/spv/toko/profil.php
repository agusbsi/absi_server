<?php
$jumlah_artikel = is_array($stok_produk) ? count($stok_produk) : 0;
$total_stok_ringkas = 0;
$artikel_pending = 0;
if (!empty($stok_produk)) foreach ($stok_produk as $item) {
  $total_stok_ringkas += (int) $item->qty;
  if ((int) $item->status === 2) $artikel_pending++;
}
?>
<style>
  .store-profile-page{--primary:#2563eb;--muted:#64748b;--line:#e2e8f0;color:#0f172a}.store-profile-page .profile-hero{display:flex;align-items:center;justify-content:space-between;padding:25px 27px;margin-bottom:18px;border-radius:19px;color:#fff;background:linear-gradient(125deg,#172554,#1d4ed8 75%,#38bdf8 140%);box-shadow:0 13px 32px rgba(30,64,175,.17)}.store-profile-page .profile-hero h2{margin:0 0 6px;font-size:25px;font-weight:700}.store-profile-page .profile-hero p{margin:0;color:rgba(255,255,255,.78);font-size:12px}.store-profile-page .hero-actions{display:flex;align-items:center}.store-profile-page .store-status{padding:6px 11px;margin-right:10px;border-radius:20px;color:#047857;background:#ecfdf5;font-size:10px;font-weight:700}.store-profile-page .back-action{display:inline-flex;height:36px;align-items:center;padding:0 12px;border:1px solid rgba(255,255,255,.25);border-radius:10px;color:#fff;background:rgba(255,255,255,.1);font-size:11px;font-weight:700}.store-profile-page .back-action:hover{color:#fff;background:rgba(255,255,255,.2);text-decoration:none}
  .store-profile-page .status-notice{display:flex;align-items:center;padding:13px 16px;margin-bottom:17px;border:1px solid #fde68a;border-radius:13px;color:#92400e;background:#fffbeb;font-size:12px;font-weight:600}.store-profile-page .status-notice i{margin-right:9px}.store-profile-page .overlay-wrapper .overlay{position:static;justify-content:flex-start;background:transparent}.store-profile-page .overlay-wrapper .fa-spin{display:none}
  .store-profile-page .summary-card{display:flex;align-items:center;height:100%;min-height:84px;padding:15px 17px;border:1px solid var(--line);border-radius:14px;background:#fff;box-shadow:0 4px 16px rgba(15,23,42,.04)}.store-profile-page .summary-icon{display:flex;width:42px;height:42px;align-items:center;justify-content:center;margin-right:11px;border-radius:12px;color:#2563eb;background:#eff6ff}.store-profile-page .summary-icon.green{color:#059669;background:#ecfdf5}.store-profile-page .summary-icon.amber{color:#d97706;background:#fffbeb}.store-profile-page .summary-label{display:block;color:var(--muted);font-size:10px;font-weight:600}.store-profile-page .summary-value{font-size:19px;line-height:1.2}
  .store-profile-page .profile-card{overflow:hidden;height:calc(100% - 16px);margin-bottom:16px;border:1px solid var(--line);border-radius:16px;box-shadow:0 5px 18px rgba(15,23,42,.05)}.store-profile-page .profile-card>.card-header{padding:17px 20px;border:0;border-bottom:1px solid #f1f5f9;color:#0f172a;background:#fff;font-size:14px;font-weight:700}.store-profile-page .profile-card>.card-body{padding:20px;background:#fff}.store-profile-page .store-cover{position:relative;isolation:isolate;width:100%;aspect-ratio:16/9;min-height:190px;max-height:270px;overflow:hidden;border-radius:16px;background:linear-gradient(145deg,#eff6ff,#e2e8f0);box-shadow:inset 0 0 0 1px rgba(148,163,184,.18),0 8px 24px rgba(15,23,42,.08)}.store-profile-page .store-photo{position:absolute;z-index:1;inset:0;width:100%;height:100%;border:0;border-radius:0;object-fit:cover;box-shadow:none;transition:transform .35s ease}.store-profile-page .store-cover:hover .store-photo{transform:scale(1.025)}.store-profile-page .photo-fallback{position:absolute;z-index:0;inset:0;display:flex;align-items:center;justify-content:center;flex-direction:column;color:#64748b}.store-profile-page .photo-fallback i{display:flex;width:68px;height:68px;align-items:center;justify-content:center;margin-bottom:10px;border-radius:20px;color:#2563eb;background:rgba(255,255,255,.75);font-size:27px;box-shadow:0 8px 20px rgba(30,64,175,.1)}.store-profile-page .photo-fallback span{font-size:11px;font-weight:600}.store-profile-page .cover-label{position:absolute;z-index:2;left:13px;bottom:13px;padding:6px 10px;border:1px solid rgba(255,255,255,.35);border-radius:20px;color:#fff;background:rgba(15,23,42,.62);backdrop-filter:blur(7px);font-size:10px;font-weight:700}.store-profile-page .profile-username{margin:15px 0 3px;font-size:20px}.store-profile-page .store-id{display:inline-block;padding:4px 9px;border-radius:20px;color:#475569;background:#f1f5f9;font-size:10px}.store-profile-page .detail-table{margin:15px 0 0}.store-profile-page .detail-table td{padding:9px 6px;border-color:#f1f5f9;font-size:11px;vertical-align:top}.store-profile-page .detail-table td:first-child{width:130px;color:#475569}.store-profile-page .detail-table td:last-child{color:#0f172a;font-weight:500}.store-profile-page .detail-table .badge{padding:5px 8px;border-radius:20px}
  .store-profile-page .stock-card{overflow:hidden;border:1px solid var(--line);border-radius:16px;box-shadow:0 5px 18px rgba(15,23,42,.05)}.store-profile-page .stock-card>.card-header{display:flex;align-items:center;justify-content:space-between;padding:18px 20px;border:0;color:#0f172a;background:#fff}.store-profile-page .stock-card .card-title{font-size:16px;font-weight:700}.store-profile-page .stock-card .card-tools{color:var(--muted);font-size:10px}.store-profile-page .stock-card>.card-body{padding:0 20px 20px}.store-profile-page .stock-toolbar{display:flex;align-items:center;justify-content:space-between;padding:13px 0}.store-profile-page .stock-toolbar .btn{border-radius:9px;font-size:11px;font-weight:700}.store-profile-page .table thead th{padding:12px 10px;border-width:1px 0;border-color:var(--line);color:#475569;background:#f8fafc;font-size:10px;text-transform:uppercase}.store-profile-page .table tbody td{padding:13px 10px;border-color:#f1f5f9;vertical-align:middle}.store-profile-page .product-name{color:#0f172a;font-size:12px;font-weight:600}.store-profile-page .product-code{color:#1d4ed8;font-size:10px;font-weight:700}.store-profile-page .stock-card .badge{padding:5px 8px;border-radius:20px;font-size:9px}.store-profile-page .stock-card>.card-footer{border-color:#f1f5f9;color:var(--muted);background:#fff;font-size:10px}
  .store-product-modal .modal-content{overflow:hidden;border:0;border-radius:17px;box-shadow:0 20px 50px rgba(15,23,42,.2)}.store-product-modal .modal-header{padding:18px 20px;border:0}.store-product-modal .modal-body{padding:20px}.store-product-modal .input-group-text,.store-product-modal .form-control{height:40px;border-color:#cbd5e1}.store-product-modal .form-control{font-size:12px}.store-product-modal .table thead th{position:sticky;top:0;background:#f8fafc;z-index:1}.store-product-modal .modal-footer{border-color:#f1f5f9}.store-product-modal .btn{border-radius:9px}
  .store-profile-page .profile-card{height:auto}
  @media(max-width:767.98px){.store-profile-page .profile-hero{align-items:flex-start;padding:21px}.store-profile-page .profile-hero h2{font-size:21px}.store-profile-page .store-status{display:none}.store-profile-page .summary-card{margin-bottom:12px;height:auto}.store-profile-page .stock-card>.card-header,.store-profile-page .stock-toolbar{align-items:flex-start;flex-direction:column}.store-profile-page .stock-card .card-tools,.store-profile-page .stock-toolbar .btn{margin-top:8px}.store-profile-page .stock-card>.card-body{padding:0 13px 15px}}
</style>
<section class="content store-profile-page">
  <div class="profile-hero"><div><h2><?= html_escape($toko->nama_toko) ?></h2><p>Profil toko, pengguna sistem, dan informasi stok artikel.</p></div><div class="hero-actions"><span class="store-status"><i class="fas fa-circle mr-1"></i><?= (int) $cek_status->status === 1 ? 'Toko Aktif' : 'Status Toko' ?></span><a href="<?= base_url('spv/Toko') ?>" class="back-action"><i class="fas fa-arrow-left mr-1"></i>Kembali</a></div></div>
  <div class="row mb-1">
    <div class="col-6 col-lg-3 mb-3"><div class="summary-card"><div class="summary-icon"><i class="fas fa-boxes"></i></div><div><span class="summary-label">Total Artikel</span><strong class="summary-value"><?= number_format($jumlah_artikel, 0, ',', '.') ?></strong></div></div></div>
    <div class="col-6 col-lg-3 mb-3"><div class="summary-card"><div class="summary-icon green"><i class="fas fa-cubes"></i></div><div><span class="summary-label">Total Stok</span><strong class="summary-value"><?= number_format($total_stok_ringkas, 0, ',', '.') ?></strong></div></div></div>
    <div class="col-6 col-lg-3 mb-3"><div class="summary-card"><div class="summary-icon amber"><i class="fas fa-clock"></i></div><div><span class="summary-label">Menunggu Persetujuan</span><strong class="summary-value"><?= number_format($artikel_pending, 0, ',', '.') ?></strong></div></div></div>
    <div class="col-6 col-lg-3 mb-3"><div class="summary-card"><div class="summary-icon"><i class="fas fa-users"></i></div><div><span class="summary-label">Pengguna Terkait</span><strong class="summary-value"><?= (empty($leader_toko) ? 0 : 1) + (empty($spg) ? 0 : 1) ?></strong></div></div></div>
  </div>
  <div class="container-fluid">
    <?php if ($cek_status->status == 0) { ?>

      <div class="overlay-wrapper status-notice">
        <div class="overlay">
          <i class="fas fa-3x fa-sync-alt fa-spin"></i>
          <div class="text-bold pt-2">TOKO NON-AKTIF !</div>
        </div>
      </div>
    <?php } else if ($cek_status->status == 2) { ?>
      <div class="overlay-wrapper status-notice">
        <div class="overlay">
          <i class="fas fa-3x fa-sync-alt fa-spin"></i>
          <div class="text-bold pt-2">Data Toko Menunggu Approve Manager Marketing !</div>
        </div>
      </div>
    <?php } else if ($cek_status->status == 3) { ?>
      <div class="overlay-wrapper status-notice">
        <div class="overlay">
          <i class="fas fa-3x fa-sync-alt fa-spin"></i>
          <div class="text-bold pt-2">Data Toko Menunggu Pemeriksaan Audit !</div>
        </div>
      </div>
    <?php } else if ($cek_status->status == 4) { ?>
      <div class="overlay-wrapper status-notice">
        <div class="overlay">
          <i class="fas fa-3x fa-sync-alt fa-spin"></i>
          <div class="text-bold pt-2">Data Toko Menunggu Approve Direksi !</div>
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="row">
    <div class="col-md-5">
      <!-- Profile Image -->
      <div class="card profile-card">
        <div class="card-header">
          Toko
        </div>
        <div class="card-body">
          <div class="store-cover">
            <div class="photo-fallback" aria-hidden="true"><i class="fas fa-store"></i><span>Foto toko belum tersedia</span></div>
            <?php if (!empty($toko->foto_toko)) : ?>
              <img class="store-photo" src="<?= base_url('assets/img/toko/' . rawurlencode($toko->foto_toko)) ?>" alt="Foto <?= html_escape($toko->nama_toko) ?>" loading="lazy" onerror="this.style.display='none'">
            <?php endif; ?>
            <span class="cover-label"><i class="fas fa-camera mr-1"></i>Foto Toko</span>
          </div>
          <h3 class="profile-username text-center"><strong><?= html_escape($toko->nama_toko) ?></strong></h3>
          <p class="text-center"><span class="store-id">ID Toko: <?= (int) $toko->id ?></span></p>
          <table class="table table-sm detail-table">
            <tbody>
              <tr>
                <td><b>Provinsi</b></td>
                <td>
                  <?= html_escape($toko->provinsi) ?>
                </td>
              </tr>
              <tr>
                <td><b>Kabupaten</b></td>
                <td>
                  <?= html_escape($toko->kabupaten) ?>
                </td>
              </tr>
              <tr>
                <td><b>Kecamatan</b></td>
                <td>
                  <?= html_escape($toko->kecamatan) ?>
                </td>
              </tr>
              <tr>
                <td><b>Alamat</b></td>
                <td>
                  <?= html_escape($toko->alamat) ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </div>
    <div class="col-md-7">
      <!-- Profile Image -->
      <div class="card profile-card">
        <div class="card-header">
          Detail
        </div>
        <div class="card-body">
          <table class="table table-sm detail-table">
            <tbody>
              <tr>
                <td><b>Jenis Toko</b></td>
                <td>
                  : <?= jenis_toko($toko->jenis_toko) ?>
                </td>
              </tr>
              <tr>
                <td><b>PIC & Telp</b></td>
                <td>
                  <?= html_escape($toko->nama_pic) ?> | <?= html_escape($toko->telp) ?>
                </td>
              </tr>
              <tr>
                <td><b>Margin</b></td>
                <td>
                  : <?= $toko->diskon ?> %
                </td>
              </tr>
              <tr>
                <td><b>Jenis Harga</b></td>
                <td>
                  : <?= status_het($toko->het) ?>
                </td>
              </tr>
              <tr>
                <td><b>Batas PO</b></td>
                <td>
                  : <?= $toko->status_ssr == 1 ? '<span class = "badge badge-success"> Aktif </span>  <small> ( PO barang di batasi dengan SSR ) </small>' : '<span class = "badge badge-danger"> Tidak Aktif </span> <small> ( PO barang Tidak di batasi ) </samll>' ?>
                </td>
              </tr>
              <tr>
                <td><b>SSR</b></td>
                <td>
                  : <?= $toko->ssr ?>
                </td>
              </tr>
              <tr>
                <td><b>Max Po</b></td>
                <td>
                  : <?= $toko->max_po ?> %
                </td>
              </tr>
              <tr>
                <td><b>Di buat</b></td>
                <td>
                  : <?= $toko->created_at ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <div class="card profile-card">
        <div class="card-header">
          Pengguna Sistem
        </div>
        <div class="card-body">
          <table class="table table-sm detail-table">
            <tbody>
              <tr>
                <td><b>Team Leader</b></td>
                <td>
                  <?= empty($leader_toko) ? "Belum dikaitkan" : html_escape($leader_toko->nama_user) ?>
                </td>
              </tr>
              <tr>
                <td><b>Spg</b></td>
                <td>
                  <?= empty($spg) ? "Belum dikaitkan" : html_escape($spg->nama_user) ?>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </div>
  <div class="card stock-card">
    <div class="card-header">
      <h3 class="card-title">
        <li class="fas fa-box"></li> Data Stok Artikel
      </h3>

      <div class="card-tools">
        <li class="fas fa-clock"></li> Update data terakhir : <?= (isset($last_update)) ? $last_update : "" ?>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="stock-toolbar"><span class="btn btn-light border btn-sm">Harga berlaku: <?= status_het($toko->het) ?></span><button type="button" class="btn btn-primary btn-sm btn_tambah <?= ($cek_status->status == 2) ? 'd-none' : '' ?>" data-id_toko="<?= (int) $toko->id ?>" data-toggle="modal" data-target="#modal-tambah-produk"><i class="fa fa-plus mr-1"></i>Tambah Produk</button></div>
      <div class="tab-content">
        <div class="table-responsive"><table id="example1" class="table">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>Kode</th>
              <th style="width:30%">Artikel</th>
              <th>Satuan</th>
              <th>Stok</th>
              <th>Harga</th>
              <th style="width:5px">menu</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php
              $no = 0;
              $total = 0;
              foreach ($stok_produk as $stok) {
                $no++
              ?>
                <td><?= $no ?></td>

                <td>
                  <span class="product-code"><?= html_escape($stok->kode) ?></span>
                </td>
                <td>
                  <span class="product-name"><?= html_escape($stok->nama_produk) ?></span>
                </td>
                <td class="text-center">
                  <small><?= $stok->satuan ?></small>
                </td>
                <td class="text-center">
                  <?php
                  if ($stok->status == 2) {
                    echo "<span class='badge badge-warning' >belum di approve </span>";
                  } else {
                    echo $stok->qty;
                  }
                  ?>
                </td>
                <td class="text-right">
                  <?php
                  if ($stok->status == 2) {
                    echo "<span class='badge badge-warning' >belum di approve </span>";
                  } else {
                    if ($toko->het == 1) {
                      echo "Rp. ";
                      echo number_format($stok->harga_jawa);
                      echo " ,-";
                    } else {
                      echo "Rp. ";
                      echo number_format($stok->harga_indobarat);
                      echo " ,-";
                    }
                  }
                  ?>
                </td>
                <td class="text-center">
                  <?php
                  if ($stok->qty == 0) {
                  ?>
                    <a href="<?= base_url('spv/Toko/hapus_item/' . $stok->id) ?>" class="text-danger"><i class="fas fa-trash"></i></a>
                  <?php } else { ?>
                    -
                  <?php } ?>
                </td>
            </tr>
          <?php
                $total += $stok->qty;
              } ?>

          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-right"> <strong>Total :</strong> </td>
              <td class="text-center"><b><?php
                                          if ($cek_status_stok > 0) {
                                            echo "<span class='badge badge-warning' >belum di approve </span>";
                                          } else {
                                            echo $total;
                                          }
                                          ?></b></td>
              <td></td>
              <td></td>
            </tr>

          </tfoot>
        </table></div>
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <i class="fas fa-info-circle mr-1"></i> Data ini merupakan jumlah stok yang dimiliki toko <b><?= html_escape($toko->nama_toko) ?></b>.
    </div>
  </div>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<!-- Modal Tambah Produk -->
<div class="modal fade store-product-modal" id="modal-tambah-produk" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="modal-supervisor">Tambah Artikel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-8">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" class="form-control form-control-sm " id="searchInput" placeholder="Cari artikel berdasarkan kode atau nama artikel...">
          </div>
        </div>
        <form action="<?= base_url('spv/toko/tambah_artikel') ?>" role="form" method="post">
          <div style="overflow-x: auto; max-height : 300px;">
            <table id="myTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Artikel</th>
                  <th>
                    <input type="checkbox" id="cekAll">
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($list_produk as $pr) {
                  $no++; ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><small><?= $pr->kode ?></small></td>
                    <td><small><?= $pr->nama_produk ?></small></td>
                    <td>
                      <input type="checkbox" name="id_produk[]" class="checkbox-item" value="<?= $pr->id ?>">
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <span class="badge badge-warning">Catatan :</span>
          <address>
            Penambahan artikel ini akan aktif setelah di approve dari manager marketing.
          </address>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="id_toko" value="<?= $toko->id ?>">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Tambah Data</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $("#cekAll").click(function() {
      $(".checkbox-item").prop('checked', $(this).prop('checked'));
    });

    $(".checkbox-item").change(function() {
      if (!$(this).prop("checked")) {
        $("#cekAll").prop("checked", false);
      }
    });
    // Fungsi untuk melakukan pencarian
    function searchTable() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
          txtValue = td[j].textContent || td[j].innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
            break; // keluar dari loop jika sudah ada satu td yang cocok
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    document.getElementById("searchInput").addEventListener("input", searchTable);


  })
</script>
