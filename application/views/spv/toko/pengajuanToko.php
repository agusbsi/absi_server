<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info ">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> Pengajuan Toko</b> </h3>
          </div>
          <div class="card-body">
            <div class="row" style="align-items: center;">
              <div class="col-md-9">
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <i class="icon fas fa-check"></i>
                  <small>Proses pengajuan Toko baru sekarang hanya melalui ABSI, anda tidak perlu lagi membuat pengajuan secara manual. </small>
                </div>
              </div>
              <div class="col-md-3 text-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-outline-success btn-sm"> <i class="fas fa-plus"></i> Pengajuan Toko</button>
                  <button type="button" class="btn btn-success btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="<?= base_url('spv/Toko/customer') ?>">Tambah Customer Baru</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url('spv/Toko/toko') ?>"> Tambah Toko Baru</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModalCenter"> Tutup Toko</a>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <table id="table_toko" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="text-center" style="width:4%">No</th>
                  <th style="width:14%">No Pengajuan</th>
                  <th>Toko</th>
                  <th>Kategori</th>
                  <th class="text-center">Status</th>
                  <th class="text-center" style="width:12%">Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($pengajuan as $t) :
                  $no++
                ?>
                  <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td>
                      <small>
                        <strong><?= $t->nomor ?></strong>
                      </small>
                    </td>
                    <td>
                      <small>
                        <strong><?= $t->nama_toko ?></strong>
                        <address><?= $t->alamat ?></address>
                      </small>
                    </td>
                    <td>
                      <small>
                        <strong><?= kategori_pengajuan($t->kategori) ?></strong>
                      </small>
                    </td>
                    <td class="text-center">
                      <?= status_pengajuan($t->status) ?>
                    </td>
                    <td class="text-center">
                      <div class="btn-group">
                        <button type="button" class="btn btn-outline-info btn-sm"> <i class="fas fa-arrow-right"></i> Lihat</button>
                        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                          <?php if ($t->kategori == 3) { ?>
                            <a class="dropdown-item" href="<?= base_url('spv/Toko/detail_tutup/' . $t->id) ?>">Detail</a>
                          <?php } else { ?>
                            <a class="dropdown-item" href="<?= base_url('spv/Toko/detail/' . $t->id) ?>">Detail</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item <?= $t->status == 4 ? '' : 'disabled' ?>" href="<?= base_url('adm/Toko/fpo/' . $t->id) ?>" target="_blank">Cetak FPO1</a>
                          <?php } ?>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
  </div>
</section>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="exampleModalLongTitle">Pengajuan Tutup Toko</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span class="badge badge-info"><i class="fas fa-info"></i> Noted:</span>
        <br>
        Dalam pengajuan tutup toko ada beberapa point yang harus di diperhatikan, sebagai berikut :
        <hr>
        <li><small>Pastikan SPG sudah input data penjualan terbaru hingga tgl : <strong><?= date('d M Y') ?></strong>.</small></li>
        <li><small>Anda di haruskan Update ASET Toko (* jika ada aset di toko tersebut).</small></li>
        <li><small>Anda di haruskan mengisi jumlah semua artikel yang akan di Retur.</small></li>
        <li><small>Proses pengajuan ini akan diverifikasi oleh : Manager Marketing, Marketing Verifikasi, Direksi.</small></li>
        <li><small>Proses Selesai apabila tim gudang telah menerima barang retur dan input data ke absi.</small></li>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
        <a href="<?= base_url('spv/Toko/form_tutup'); ?>" class="btn btn-success btn-sm">Ya, Lanjutkan</a>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->
<script>
  $(document).ready(function() {

    $('#table_toko').DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
    });


  })
</script>