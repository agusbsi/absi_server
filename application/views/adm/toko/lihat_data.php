<?php
$total_toko = count($toko);
$toko_baru = $tim_lengkap = $perlu_perhatian = 0;
foreach ($toko as $item) {
  if (!empty($item->created_at) && date('m-Y', strtotime($item->created_at)) === date('m-Y')) $toko_baru++;
  if (trim((string) $item->nama_spv) !== '' && trim((string) $item->leader) !== '' && trim((string) $item->spg) !== '') $tim_lengkap++;
  if (in_array((string) $item->status, array('4', '5'), true)) $perlu_perhatian++;
}
?>
<style>
  .store-page{--primary:#0f766e;--ink:#172033;--muted:#718096;--line:#e7edf3;padding-bottom:28px;color:var(--ink)}
  .store-page .store-hero{position:relative;overflow:hidden;margin-bottom:20px;padding:27px 30px;color:#fff;background:linear-gradient(120deg,#115e59 0%,#0f766e 55%,#14b8a6 125%);border-radius:18px;box-shadow:0 14px 34px rgba(15,118,110,.18)}
  .store-page .store-hero:after{position:absolute;top:-105px;right:-50px;width:260px;height:260px;content:'';border:1px solid rgba(255,255,255,.15);border-radius:50%}.store-page .hero-content{position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between}.store-page .hero-eyebrow{display:block;margin-bottom:7px;color:rgba(255,255,255,.78);font-size:11px;font-weight:700;letter-spacing:.09em;text-transform:uppercase}.store-page .store-hero h1{margin:0 0 7px;font-size:26px;font-weight:700}.store-page .store-hero p{margin:0;color:rgba(255,255,255,.82);font-size:13px}.store-page .hero-icon{display:flex;width:60px;height:60px;align-items:center;justify-content:center;background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.2);border-radius:17px;font-size:23px}
  .store-page .summary-card{display:flex;min-height:94px;align-items:center;gap:14px;margin-bottom:18px;padding:17px;background:#fff;border:1px solid var(--line);border-radius:15px;box-shadow:0 5px 18px rgba(34,45,70,.04)}.store-page .summary-icon{display:flex;width:43px;height:43px;flex:0 0 43px;align-items:center;justify-content:center;color:var(--color);background:var(--bg);border-radius:12px}.store-page .summary-value{margin:0 0 4px;color:#111827;font-size:23px;font-weight:700;line-height:1}.store-page .summary-label{margin:0;color:var(--muted);font-size:12px}
  .store-page .modern-card{overflow:hidden;border:1px solid var(--line);border-radius:17px;box-shadow:0 6px 20px rgba(34,45,70,.045)}.store-page .modern-card>.card-header{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:18px 21px;background:#fff;border-bottom:1px solid var(--line)}.store-page .modern-card .card-title{margin:0;color:var(--ink);font-size:16px;font-weight:700}.store-page .header-subtitle{display:block;margin-top:4px;color:var(--muted);font-size:11px;font-weight:400}.store-page .toolbar{display:flex;align-items:center;gap:8px}.store-page .search-box{position:relative;width:270px;margin:0}.store-page .search-box i{position:absolute;top:50%;left:13px;color:#94a3b8;transform:translateY(-50%)}.store-page .search-box input{width:100%;height:39px;padding:8px 12px 8px 37px;background:#f8fafc;border:1px solid #dfe6ee;border-radius:10px;outline:none;font-size:12px}.store-page .toolbar .btn{display:inline-flex;height:39px;align-items:center;gap:6px;padding:0 12px;border:0;border-radius:10px;font-size:11px;font-weight:700;white-space:nowrap}
  .store-page table{width:100%!important;margin:0}.store-page table thead th{padding:13px 10px;color:#64748b;background:#fbfcfe;border-top:0;border-bottom:1px solid var(--line);font-size:10px;letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}.store-page table tbody td{padding:14px 10px;vertical-align:middle;border-color:#eef2f6;font-size:12px}.store-page table tbody tr:hover{background:#fbfefd}.store-page .store-name{display:flex;align-items:center;gap:10px}.store-page .store-avatar{display:flex;width:35px;height:35px;flex:0 0 35px;align-items:center;justify-content:center;color:var(--primary);background:#ecfdf5;border-radius:10px}.store-page .store-name strong{display:block;color:#253047}.store-page .store-type{color:var(--muted);font-size:10px}.store-page .new-badge{display:inline-block;margin-top:3px;padding:2px 6px;color:#b45309;background:#fff7ed;border-radius:999px;font-size:9px;font-weight:700}.store-page .address{display:-webkit-box;max-width:360px;overflow:hidden;color:var(--muted);line-height:1.5;-webkit-box-orient:vertical;-webkit-line-clamp:2}.store-page .team-list{margin:0;padding:0;list-style:none;color:#475569;line-height:1.65}.store-page .team-list span{display:inline-block;width:48px;color:#94a3b8;font-size:10px;font-weight:700;text-transform:uppercase}.store-page .detail-btn{display:inline-flex;align-items:center;gap:6px;padding:7px 11px;color:#fff!important;background:var(--primary);border:0;border-radius:9px;font-size:10px;font-weight:700}.store-page .detail-btn.warning{background:#d97706}.store-page .dataTables_filter,.store-page .dataTables_length{display:none}.store-page .dataTables_info,.store-page .dataTables_paginate{padding-top:16px!important;color:var(--muted);font-size:11px}
  .store-modal .modal-content{overflow:hidden;border:0;border-radius:16px;box-shadow:0 20px 60px rgba(15,23,42,.2)}.store-modal .modal-header{padding:18px 22px;color:#fff;background:linear-gradient(120deg,#115e59,#0f766e);border:0}.store-modal .modal-body{padding:22px}.store-modal .notice{margin-bottom:20px;padding:12px 14px;color:#92400e;background:#fff7ed;border-left:3px solid #f59e0b;border-radius:8px;font-size:11px}.store-modal label{color:#475569;font-size:11px;font-weight:700}.store-modal .form-control{min-height:40px;border-color:#dfe6ee;border-radius:9px;font-size:12px}.store-modal .modal-footer{padding:14px 22px;background:#f8fafc}.store-modal .modal-footer .btn{padding:8px 14px;border:0;border-radius:9px;font-size:11px;font-weight:700}
  @media(max-width:991.98px){.store-page .modern-card>.card-header{align-items:flex-start;flex-direction:column}.store-page .toolbar{width:100%;flex-wrap:wrap}.store-page .search-box{flex:1;min-width:220px}}@media(max-width:575.98px){.store-page .store-hero{padding:22px 20px}.store-page .hero-icon{display:none}.store-page .toolbar .btn span{display:none}}
</style>
<section class="content store-page">
  <div class="container-fluid">
    <div class="store-hero"><div class="hero-content"><div><span class="hero-eyebrow"><i class="fas fa-map-marked-alt mr-1"></i> Manajemen Toko</span><h1>Toko Aktif</h1><p>Pantau profil toko, lokasi, tim marketing, dan status operasional dalam satu halaman.</p></div><span class="hero-icon"><i class="fas fa-store"></i></span></div></div>
    <div class="row">
      <?php $summaries = array(array('Total toko aktif',$total_toko,'fa-store','#0f766e','#ecfdf5'),array('Toko baru bulan ini',$toko_baru,'fa-bolt','#2563eb','#eff6ff'),array('Tim lengkap',$tim_lengkap,'fa-user-check','#7c3aed','#f5f3ff'),array('Perlu perhatian',$perlu_perhatian,'fa-exclamation-circle','#d97706','#fff7ed')); foreach ($summaries as $summary) : ?>
        <div class="col-xl-3 col-sm-6"><article class="summary-card" style="--color:<?= $summary[3] ?>;--bg:<?= $summary[4] ?>"><span class="summary-icon"><i class="fas <?= $summary[2] ?>"></i></span><div><h2 class="summary-value"><?= number_format($summary[1]) ?></h2><p class="summary-label"><?= $summary[0] ?></p></div></article></div>
      <?php endforeach; ?>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card modern-card">
          <div class="card-header">
            <h3 class="card-title">Daftar toko<span class="header-subtitle">Cari toko dan buka detail untuk pengelolaan lebih lanjut.</span></h3>
            <div class="toolbar"><label class="search-box" for="store-search"><i class="fas fa-search"></i><input type="search" id="store-search" placeholder="Cari toko, alamat, atau tim..." autocomplete="off"></label><a href="<?= base_url('adm/Toko/unduhExcel') ?>" class="btn btn-warning"><i class="fas fa-file-excel"></i><span>Unduh Excel</span></a><?php if ((int)$this->session->userdata('role') === 1) : ?><button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i><span>Tambah Toko</span></button><?php endif; ?></div>
          </div>
          <div class="card-body">
            <div class="table-responsive"><table id="table_toko" class="table">
              <thead>
                <tr class="text-center">
                  <th style="width:4%">No</th>
                  <th>Nama Toko</th>
                  <th style="width:30%">Alamat</th>
                  <th>Tim Marketing</th>
                  <th>Status</th>
                  <th style="width:10%">Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($toko as $t) :
                  $no++
                ?>
                  <tr>
                    <td class="text-center text-muted"><?= $no ?></td>
                    <td>
                      <div class="store-name"><span class="store-avatar"><i class="fas fa-store"></i></span><div>
                        <strong><?= html_escape($t->nama_toko) ?></strong>
                        <span class="store-type"><?= html_escape(jenis_toko($t->jenis_toko)) ?></span>
                        <?php if (DATE('m-Y', strtotime($t->created_at)) == DATE('m-Y')) { ?>
                          <span class="new-badge">TOKO BARU</span>
                        <?php } ?>
                      </div></div>
                    </td>
                    <td>
                      <span class="address" title="<?= html_escape($t->alamat) ?>"><i class="fas fa-map-marker-alt mr-1"></i><?= html_escape($t->alamat) ?></span>
                    </td>
                    <td>
                      <ul class="team-list"><li><span>SPV</span><?= html_escape($t->nama_spv ?: '-') ?></li><li><span>Leader</span><?= html_escape($t->leader ?: '-') ?></li><li><span>SPG</span><?= html_escape($t->spg ?: '-') ?></li></ul>
                    </td>
                    <td class="text-center">
                      <?= status_toko($t->status) ?>
                    </td>
                    <td class="text-center">
                      <a href="<?= base_url('adm/Toko/profil/' . $t->id) ?>" class="detail-btn <?= ($t->status == '4' || $t->status == '5') ? 'warning' : '' ?>"><i class="fas <?= ($t->status == '4' || $t->status == '5') ? 'fa-cog' : 'fa-eye' ?>"></i><?= ($t->status == '4' || $t->status == '5') ? 'Kelola' : 'Detail' ?></a>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table></div>
          </div>
        </div>
      </div>

    </div>
  </div>
  </div>
</section>
<div class="modal fade" id="modalUpdate">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title">
          Update nama Toko
        </h5>
      </div>
      <form action="<?= base_url('adm/Toko/update_nama'); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="file_excel" required>
        <button type="submit">Upload</button>
      </form>
    </div>
  </div>
</div>
<div class="modal fade store-modal" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambah-title" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-tambah-title"><i class="fas fa-store mr-2"></i>Tambah Toko</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
      </div>
      <form method="post" enctype="multipart/form-data" action="<?php echo base_url('adm/Toko/tambahToko'); ?>">
        <div class="modal-body">
          <!-- isi konten -->
          <div class="notice"><i class="fas fa-info-circle mr-1"></i> Fitur ini khusus untuk menambahkan toko dari Easy Accounting ke ABSI, bukan untuk proses pembukaan toko baru.</div>
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="file">Nama Toko</label>
                <input type="text" name="namaToko" class="form-control form-control-sm" placeholder="nama toko...." required>
              </div>
              <div class="form-group">
                <label for="file">Customer</label>
                <select name="id_customer" class="form-control form-control-sm select2bs4" id="customer" required>
                  <option value="">- Pilih customer -</option>
                  <?php foreach ($customer as $c) : ?>
                    <option value="<?= $c->id ?>"><?= $c->nama_cust ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label for="file">Jenis Toko</label>
                <select name="jenis_toko" class="form-control form-control-sm select2bs4" required="">
                  <option value="">-Pilih-</option>
                  <option value="1">Dept Store</option>
                  <option value="6">Hypermarket</option>
                  <option value="2">Supermarket</option>
                  <option value="3">Grosir</option>
                  <option value="4">Minimarket</option>
                  <option value="5">Lain-lain.</option>
                </select>
              </div>
              <div class="form-group">
                <label>Tipe Harga</label>
                <select class="form-control select2bs4" name="het" required>
                  <option value="">- Pilih Tipe Harga -</option>
                  <option value="1">HET JAWA</option>
                  <option value="2">HET INDOBARAT</option>
                </select>
              </div>
              <div class="form-group">
                <label for="file">Dibuat Oleh</label>
                <input type="text" class="form-control form-control-sm" value="<?= html_escape($this->session->userdata('nama_user')) ?>" readonly>
              </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Provinsi</label>
                <select class="form-control provinsi select2bs4" name="provinsi" id="provinsi" required>
                  <option value=''>- Select Provinsi -</option>
                  <?php foreach ($provinsi as $p) : ?>
                    <option value="<?= $p->id ?>"><?= $p->nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Kabupaten</label>
                <select class="form-control kabupaten select2bs4" name="kabupaten" id="kabupaten" required>

                </select>
              </div>
              <div class="form-group">
                <label>Kecamatan</label>
                <select class="form-control kecamatan select2bs4" name="kecamatan" id="kecamatan" required>

                </select>
              </div>
              <div class="form-group">
                <label>Alamat</label> </br>
                <textarea class="form-control alamat" name="alamat" placeholder="Masukkan alamat lengkap toko" required></textarea>
              </div>
            </div>

          </div>
          <!-- end konten -->
        </div>
        <div class="modal-footer right">
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
            <i class="fas fa-times-circle"></i> Batal
          </button>
          <button type="submit" class="btn btn-sm btn-success">
            <i class="fas fa-save"></i> Simpan Toko
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script>
  $(document).ready(function() {

    $('#table_toko').DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      pageLength: 10,
      language: {
        info: 'Menampilkan _START_–_END_ dari _TOTAL_ toko',
        infoEmpty: 'Tidak ada toko',
        zeroRecords: 'Toko yang dicari tidak ditemukan',
        paginate: { previous: '<i class="fas fa-chevron-left"></i>', next: '<i class="fas fa-chevron-right"></i>' }
      }
    });

    var storeTable = $('#table_toko').DataTable();
    $('#store-search').on('input', function() { storeTable.search(this.value).draw(); });


  })
</script>
<script>
  $("#provinsi").change(function() {
    var selectedProvinsi = $(this).val();

    // Lakukan permintaan AJAX untuk mengambil data Kabupaten berdasarkan Provinsi yang dipilih
    $.ajax({
      url: "<?php echo base_url('adm/Toko/add_ajax_kab'); ?>/" + selectedProvinsi,
      dataType: 'json', // Tentukan bahwa Anda mengharapkan data JSON
      success: function(data) {
        // Bersihkan elemen select kabupaten
        $('#kabupaten').empty();
        $('#kecamatan').empty();
        $('#kecamatan').append('<option value="">- Select Kecamatan -</option>');
        // Tambahkan opsi kosong sebagai opsi default
        $('#kabupaten').append('<option value="">- Select Kabupaten -</option>');

        // Tambahkan opsi-opsi kabupaten yang diterima dari respons JSON
        $.each(data, function(index, item) {
          $('#kabupaten').append('<option value="' + item.id + '">' + item.nama + '</option>');
        });
      }
    });
  });


  $("#kabupaten").change(function() {
    var url = "<?php echo base_url('adm/Toko/add_ajax_kec'); ?>/" + $(this).val();
    $.ajax({
      url: url,
      dataType: 'json', // Tentukan bahwa Anda mengharapkan data JSON
      success: function(data) {
        $('#kecamatan').empty();
        $('#kecamatan').append('<option value="">- Select Kecamatan -</option>');
        $.each(data, function(index, item) {
          $('#kecamatan').append('<option value="' + item.id + '">' + item.nama + '</option>');
        });
      }
    });
  });
</script>
