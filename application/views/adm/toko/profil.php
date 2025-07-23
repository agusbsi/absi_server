<style>
  #loading {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(255, 255, 255, 0.7);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .loader {
    position: relative;
    width: 200px;
    height: 200px;
  }

  .circle {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: conic-gradient(#3498db 0deg, #3498db 0deg, transparent 0deg);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .percentage {
    position: absolute;
    font-size: 2em;
    font-weight: bold;
    color: #ffc107;
  }

  .img-nodata {
    width: 100%;

  }

  .judul_toko {
    grid-column: span 2;
    background-color: #FFFFFF;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 8px;
    position: relative;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
  }

  .judul_toko h5 {
    margin: 0;
    font-weight: bold;
  }

  .btn_edit {
    background-color: #FFC107;
    border: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    color: black;
    border-radius: 5px;
    padding: 0 5px;
    cursor: pointer;
    position: absolute;
    right: 10px;
    bottom: 5px;
    font-size: 12px;
    font-weight: 500;
    overflow: hidden;
    transition: color 0.4s ease;
    z-index: 1;
  }

  .btn_edit::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background-color: #3498db;
    transition: left 0.4s ease;
    z-index: 0;
  }

  .btn_edit:hover::before {
    left: 0;
  }

  .btn_edit:hover {
    color: white;
  }

  .btn_edit i,
  .btn_edit span {
    position: relative;
    z-index: 1;
  }


  .image-section {
    background-color: #ffffff;
    border-radius: 8px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .image-section img {
    width: 100%;
    border-radius: 8px;
  }

  .detail-title {
    font-size: 14px;
    font-weight: bold;
    margin: 0;
    display: block;
  }

  .detail-description {
    display: block;
    font-size: 12px;
    color: #666666;
    margin-bottom: 2px;
  }
</style>
<section class="content">
  <div class="container-fluid">
    <?php if ($cek_status->status == 0) { ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fas fa-exclamation-triangle"></i>
        <small><strong>Perhatian:</strong> Toko ini telah <u>disuspend</u> dan saat ini <u>tidak aktif</u>. Seluruh stok barang telah dinonaktifkan dan tidak dapat diproses lebih lanjut.</small>
      </div>
    <?php } ?>

    <div class="judul_toko">
      <h5><i class="fas fa-store"></i> <?= $toko->nama_toko ?></h5>
      <?php if (in_array($this->session->userdata('role'), [1, 6, 9])) { ?>
        <button class="btn_edit" data-toggle="modal" data-target="#modal_toko" data-id="<?= $toko->id; ?>" data-toko="<?= $toko->nama_toko; ?>"><i class="fas fa-edit"></i> <span>Ubah</span></button>
      <?php } ?>
    </div>
    <div class="row">
      <div class="col-md-5">
        <div class="image-section">
          <?php if ($toko->foto_toko == null) { ?>
            <img src="<?php echo base_url() ?>assets/img/toko/hicoop.png" alt="Foto toko">
          <?php } else { ?>
            <img src="<?php echo base_url('assets/img/toko/' . $toko->foto_toko . "?" . time()) ?>" alt="Foto toko">
          <?php } ?>
          <?php if (in_array($this->session->userdata('role'), [1, 6, 9])) { ?>
            <button class="btn_edit" data-toggle="modal" data-target="#modal_foto" data-id="<?= $toko->id; ?>"><i class="fas fa-edit"></i> <span>Ubah</span></button>
          <?php } ?>
        </div>
        <div class="card card-outline card-info">
          <div class="card-header">
            <strong>Detail</strong>
          </div>
          <div class="card-body">
            <p class="detail-title">Customer</p>
            <p class="detail-description"><?= $toko->nama_cust ?></p>
            <p class="detail-title">Jenis Toko</p>
            <p class="detail-description"><?= jenis_toko($toko->jenis_toko) ?></p>
            <p class="detail-title">PIC & Telp</p>
            <p class="detail-description"><?= $toko->nama_pic ?> | <?= $toko->telp ?></p>
            <p class="detail-title">Provinsi</p>
            <p class="detail-description"><?= $toko->provinsi ?></p>
            <p class="detail-title">Kabupaten</p>
            <p class="detail-description"><?= $toko->kabupaten ?></p>
            <p class="detail-title">Kecamatan</p>
            <p class="detail-description"><?= $toko->kecamatan ?></p>
            <p class="detail-title">Alamat</p>
            <p class="detail-description"><?= $toko->alamat ?></p>
            <p class="detail-title">Di buat</p>
            <p class="detail-description"><?= date('d M Y H:i:s', strtotime($toko->created_at)) ?></p>
            <button class="btn_edit" data-toggle="modal" data-target="#modal_detail"
              data-id="<?= $toko->id; ?>"
              data-id_cust="<?= $toko->id_customer; ?>"
              data-jenis_toko="<?= $toko->jenis_toko; ?>"
              data-pic="<?= $toko->nama_pic; ?>"
              data-telp="<?= $toko->telp; ?>"
              data-provinsi="<?= $toko->id_provinsi; ?>"
              data-kabupaten="<?= $toko->id_kab; ?>"
              data-kecamatan="<?= $toko->id_kec; ?>"
              data-alamat="<?= $toko->alamat; ?>">
              <?php if (in_array($this->session->userdata('role'), [1, 6, 9])) { ?>
                <i class="fas fa-edit"></i> <span>Ubah</span></button>
          <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-outline card-info">
              <div class="card-header">
                <strong>Pengaturan</strong>
              </div>
              <div class="card-body">
                <p class="detail-title">Gudang Easy</p>
                <p class="detail-description"><?= $toko->gudang ? $toko->gudang : 'kosong' ?></p>
                <p class="detail-title">Max Tgl SO</p>
                <p class="detail-description"><?= $toko->tgl_so ?> / Bulan</p>
                <p class="detail-title">Margin</p>
                <p class="detail-description"><?= $toko->diskon ?> %</p>
                <p class="detail-title">Target Toko</p>
                <p class="detail-description">Rp <?= number_format($toko->target) ?></p>
                <p class="detail-title">Tipe Harga</p>
                <p class="detail-description"><?= $toko->het == 1 ? 'HET JAWA' : 'HET INDOBARAT' ?></p>
                <?php if (in_array($this->session->userdata('role'), [1, 6, 9])) { ?>
                  <button class="btn_edit" data-toggle="modal" data-target="#modal_pengaturan"
                    data-id_toko_pengaturan="<?= $toko->id; ?>"
                    data-gudang="<?= $toko->gudang; ?>"
                    data-tgl_so="<?= $toko->tgl_so; ?>"
                    data-margin="<?= $toko->diskon; ?>"
                    data-target_toko="<?= $toko->target; ?>"
                    data-het="<?= $toko->het; ?>"><i class="fas fa-edit"></i> <span>Ubah</span></button>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-outline card-info">
              <div class="card-header">
                <strong>Purchase Order ( PO )</strong>
              </div>
              <div class="card-body">
                <p class="detail-title">Tipe Pengajuan</p>
                <p class="detail-description">MANUAL</p>
                <hr>
                <p class="detail-title">Batas PO</p>
                <p class="detail-description"><?= $toko->status_ssr == 1 ? 'AKTIF' : 'NON-AKTIF' ?></p>
                <p class="detail-title">SSR Toko</p>
                <p class="detail-description"><?= $toko->ssr ?> X <small>( Dari Total barang keluar bulan kemarin )</small></p>
                <p class="detail-title">Max PO</p>
                <p class="detail-description"><?= $toko->max_po ?> % <small>( Dari Total barang keluar bulan kemarin )</small></p>
                <p class="detail-title">Min Pengiriman</p>
                <p class="detail-description">Rp -</p>
                <p class="detail-title">Periode</p>
                <p class="detail-description">-</p>
                <?php if (in_array($this->session->userdata('role'), [1, 6, 9])) { ?>
                  <button class="btn_edit" data-toggle="modal" data-target="#modal_po"
                    data-id_toko_po="<?= $toko->id; ?>"
                    data-batas_po="<?= $toko->status_ssr; ?>"
                    data-ssr="<?= $toko->ssr; ?>"
                    data-max_po="<?= $toko->max_po; ?>"><i class="fas fa-edit"></i> <span>Ubah</span></button>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-outline card-info">
              <div class="card-header">
                <strong> Tim Marketing</strong>
              </div>
              <div class="card-body">
                <p class="detail-title">Supervisor</p>
                <p class="detail-description"><?= $toko->id_spv == 0 ? "Belum di kaitkan " : $toko->nama_spv ?></p>
                <p class="detail-title">Team Leader</p>
                <p class="detail-description"><?= $toko->id_leader == 0 ? "Belum di kaitkan " : $toko->leader ?></p>
                <p class="detail-title">SPG / SPB</p>
                <p class="detail-description"><?= $toko->id_spg == 0 ? "Belum di kaitkan " : $toko->spg ?></p>
                <?php if (in_array($this->session->userdata('role'), [1, 6, 9])) { ?>
                  <button class="btn_edit" data-toggle="modal" data-target="#modal_marketing"
                    data-id_toko_marketing="<?= $toko->id; ?>"
                    data-spv="<?= $toko->id_spv; ?>"
                    data-leader="<?= $toko->id_leader; ?>"
                    data-spg="<?= $toko->id_spg; ?>"><i class="fas fa-edit"></i> <span>Ubah</span></button>
                <?php } ?>
              </div>
            </div>
            <button type="button" class="btn btn-outline-info btn-block btn-sm" id="btnHistori" data-id="<?= $toko->id ?>"><i class="fas fa-feather"></i> Histori Pengajuan </button>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-primary mt-3">
      <div class="card-header">
        <h3 class="card-title">
          <li class="fas fa-box"></li> Data Stok Artikel
        </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div id="loading" style="display: none;">
          <div class="loader">
            <div class="circle">
              <div class="percentage" id="percentage">0%</div>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-success btn-sm btn_tambah <?= ($this->session->userdata('role') != 1) ? 'd-none' : '' ?>" data-id_toko="<?= $toko->id ?>" data-toggle="modal" data-target="#modal-tambah-produk"><i class="fa fa-plus"></i> Tambah Produk</button>
        <a href="<?= base_url('adm/Toko/templateStok/' . $toko->id) ?>" class="btn btn-warning btn-sm <?= ($cek_status->status != 1) ? 'd-none' : '' ?>"><i class="fa fa-download"></i> Unduh Template</a>
        <button type="button" class="btn btn-primary btn-sm btn_tambah <?= ($this->session->userdata('role') != 1) ? 'd-none' : '' ?>" data-id_toko="<?= $toko->id ?>" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-upload"></i> Import Stok</button>
        <div class="tab-content">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Artikel</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Max Stok</th>
                <th>Menu</th>
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
                    <small><strong><?= $stok->kode ?></strong></small> <br>
                    <small><?= $stok->nama_produk ?></small>
                  </td>
                  <td class="text-center"><small><?= $stok->satuan ?></small></td>
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
                    <?= $stok->ssr ?>
                  </td>
                  <td class="text-center">
                    <button class="btn btn-sm btn-success btn_kartu" data-id="<?= $stok->id ?>" data-id_toko="<?= $toko->id ?>" data-toggle="modal" data-target="#modal_kartu"> <i class="fas fa-clipboard-list"></i> <small>Kartu Stok</small></button>
                  </td>
              </tr>
            <?php
                  $total += $stok->qty;
                } ?>

            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" class="text-right"> <strong>Total :</strong> </td>
                <td class="text-center"><b><?php
                                            if ($cek_status_stok > 0) {
                                              echo "<span class='badge badge-warning' >belum di approve </span>";
                                            } else {
                                              echo $total;
                                            }
                                            ?></b></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="modal-tambah-produk">
  <div class="modal-dialog">
    <form action="<?= base_url('adm/toko/tambah_produk') ?>" role="form" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-supervisor">Tambah Artikel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label>Nama Artikel</label>
            <select name="id_produk" class="form-control select2bs4" required>
              <option value="">- Pilih Artikel -</option>
              <?php foreach ($list_produk as $pr) { ?>
                <option value="<?= $pr->id ?>"><?= $pr->kode . " | " . $pr->nama_produk ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="form-group">
            <label>Harga</label>
            <p>
              * Artikel ini berlaku untuk harga : <strong> <?= status_het($toko->het) ?></strong>
            </p>
            <input class="form-control" type="hidden" name="id_toko" value="<?= $toko->id ?>">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Tambah</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h4 class="modal-title">
          <li class="fa fa-excel"></li> Import Excel
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- isi konten -->
        <form method="post" enctype="multipart/form-data" action="<?php echo base_url('adm/Toko/importStok'); ?>">
          <span class="badge badge-danger">Perhatian :</span> <br> - Fitur ini akan memperbarui stok pada toko <b><?= $toko->nama_toko ?>,</b>.
          <br>
          - Pastikan file excel diambil dari template toko <b><?= $toko->nama_toko ?>.</b>
          <br>
          - pastikan data di input dengan benar.</b>
          <hr>
          <div class="form-group">
            <label for="file">File Upload</label>
            <input type="file" name="file" class="form-control" id="exampleInputFile" accept=".xlsx,.xls" required>
          </div>
          <!-- end konten -->
      </div>
      <div class="modal-footer right">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
          <li class="fas fa-times-circle"></li> Cancel
        </button>
        <button type="submit" class="btn btn-sm btn-success">
          <li class="fas fa-save"></li> Import
        </button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modal_kartu">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-success">
        Detail Kartu Stok
      </div>
      <div class="modal-body">
        Menampilkan 3 transaksi terakhir :
        <hr>
        <p class="text-center" id="artikel"></p>
        <p class="text-center" id="toko"></p>
        <div class="row mr-4" style="justify-content:flex-end">
          <p class="mr-5">Saldo Awal :</p>
          <strong id="s_awal" class="ml-5"></strong>
        </div>
        <table class="table table-bordered">
          <thead>
            <tr class="text-center">
              <th rowspan="2">Tanggal</th>
              <th rowspan="2">No. Dok</th>
              <th rowspan="2">Transaksi</th>
              <th rowspan="2">Pembuat</th>
              <th colspan="3">Stok Artikel</th>
            </tr>
            <tr class="text-center">
              <th>Masuk</th>
              <th>Keluar</th>
              <th>Sisa</th>
            </tr>
          </thead>
          <tbody id="dataTableBody">
          </tbody>
        </table>
        <div class="row mr-4" style="justify-content:flex-end">
          <p class="mr-5">Saldo Akhir :</p>
          <strong id="s_akhir" class="ml-5"></strong>
        </div>
        <hr>
        # Untuk melihat riwayat transaksi lebih lengkap silahkan buka menu : <a href="<?= base_url('adm/Stok/kartu_stok') ?>">Laporan Kartu Stok</a>
      </div>
      <div class="modal-footer right">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
          <li class="fas fa-times-circle"></li> Close
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalHistori" tabindex="-1" role="dialog" aria-labelledby="modalHistoriTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHistoriTitle">Histori Pengajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="timeline">
          <!-- Tempat untuk menampilkan histori pengajuan -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal_toko" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('adm/Toko/update_toko') ?>" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Ubah Nama Toko</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-grou mb-1p">
            <label>Nama Toko</label>
            <input type="text" class="form-control form-control-sm" id="nama_toko" name="nama_toko" autocomplete="off" placeholder="nama toko ..." required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cancel</button>
          <input type="hidden" name="id_toko" id="toko_id">
          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="modal_foto" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('adm/Toko/update_foto') ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Ubah Foto Toko</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-grou mb-1p">
            <label>Pilih Foto</label>
            <input type="file" class="form-control form-control-sm" name="foto" accept="image/png, image/jpeg, image/jpg" required></input>
            <small>noted: Jenis foto yang diperbolehkan : JPG|JPEG|PNG & size maksimal : 2 mb</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cancel</button>
          <input type="hidden" name="id_toko_foto" id="toko_id_foto">
          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="modal_detail">
  <div class="modal-dialog modal-lg" role="document">
    <form action="<?= base_url('adm/Toko/update_detail') ?>" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-grou mb-1p">
                <label>Customer</label>
                <select class="form-control form-control-sm select2" id="id_cust" name="id_cust" required>
                  <?php foreach ($customer as $p) : ?>
                    <option value="<?= $p->id ?>"><?= $p->nama_cust ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-grou mb-1p">
                <label>Jenis Toko</label>
                <select class="form-control form-control-sm" id="jenis_toko" name="jenis_toko" required>
                  <option value="1">Dept Store</option>
                  <option value="2">Supermarket</option>
                  <option value="3">Grosir</option>
                  <option value="4">Minimarket</option>
                  <option value="6">Hypermart</option>
                  <option value="5">Lain-lain.</option>
                </select>
              </div>
              <div class="form-grou mb-1p">
                <label>PIC</label>
                <input type="text" class="form-control form-control-sm " id="pic" name="pic" autocomplete="off">
              </div>
              <div class="form-grou mb-1p">
                <label>Telp / Whastapp</label>
                <input type="number" class="form-control form-control-sm" id="telp" name="telp" autocomplete="off">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-grou mb-1p">
                <label>Provinsi</label>
                <select class="form-control form-control-sm select2" id="id_provinsi" name="provinsi" required>
                  <?php foreach ($provinsi as $p) : ?>
                    <option value="<?= $p->id ?>"><?= $p->nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-grou mb-1p">
                <label>Kabupaten</label>
                <select class="form-control form-control-sm select2" id="kabupaten" name="kabupaten" required>
                  <?php foreach ($kabupaten as $p) : ?>
                    <option value="<?= $p->id ?>"><?= $p->nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-grou mb-1p">
                <label>Kecamatan</label>
                <select class="form-control form-control-sm select2" id="kecamatan" name="kecamatan" required>
                  <?php foreach ($kecamatan as $p) : ?>
                    <option value="<?= $p->id ?>"><?= $p->nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-grou mb-1p">
                <label>Alamat</label>
                <textarea class="form-control form-control-sm " id="alamat" name="alamat" required></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cancel</button>
          <input type="hidden" name="id_toko_detail" id="id_toko_detail">
          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="modal_pengaturan">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('adm/Toko/update_pengaturan') ?>" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Pengaturan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-grou mb-1p">
            <label>Nama Gudang Easy</label>
            <input type="text" class="form-control form-control-sm" id="gudang" name="gudang" autocomplete="off">
          </div>
          <div class="form-grou mb-1p">
            <label>Tanggal SO</label>
            <select class="form-control form-control-sm select2" id="tgl_so" name="tgl_so" required>
              <option value="">- Pilih tgl SO -</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
            </select>
          </div>
          <div class="form-grou mb-1p">
            <label>Margin</label>
            <input type="number" class="form-control form-control-sm" id="margin" name="margin" autocomplete="off" required>
          </div>
          <div class="form-grou mb-1p">
            <label>Target Toko</label>
            <input type="text" class="form-control form-control-sm rupiah-input" id="target" name="target" autocomplete="off" required>
          </div>
          <div class="form-grou mb-1p">
            <strong>Tipe Harga</strong>
            <select class="form-control form-control-sm select2" id="het" name="het" required>
              <option value="">- Pilih Tipe Harga -</option>
              <option value="1">HET JAWA</option>
              <option value="2">HET INDOBARAT</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cancel</button>
          <input type="hidden" name="id_toko_pengaturan" id="id_toko_pengaturan">
          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="modal_po" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('adm/Toko/update_po') ?>" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Ubah Purchase Order ( PO )</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <small>Info : Fitur PO otomatis sedang dalam pengembangan.</small>
          <hr>
          <div class="form-grou mb-1p">
            <strong>Batas PO</strong>
            <select class="form-control form-control-sm select2" id="batas_po" name="batas_po" required>
              <option value="">- Pilih fungsi -</option>
              <option value="1">AKTIF</option>
              <option value="0">TIDAK AKTIF</option>
            </select>
          </div>
          <div class="form-grou mb-1p">
            <strong>SSR Toko</strong>
            <input type="number" class="form-control form-control-sm" id="ssr" name="ssr" autocomplete="off" required>
          </div>
          <div class="form-grou mb-1p">
            <strong>Max PO</strong>
            <input type="number" class="form-control form-control-sm" id="max_po" name="max_po" autocomplete="off" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cancel</button>
          <input type="hidden" name="id_toko_po" id="id_toko_po">
          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="modal_marketing" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('adm/Toko/update_marketing') ?>" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Ubah Tim Marketing</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-grou mb-1p">
            <label>Supervisor</label>
            <select class="form-control form-control-sm select2" id="id_spv" name="id_spv" required>
              <?php foreach ($spv as $p) : ?>
                <option value="<?= $p->id ?>"><?= $p->nama_user ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-grou mb-1p">
            <label>Tim Leader</label>
            <select class="form-control form-control-sm select2" id="id_leader" name="id_leader">
              <option value="0">- Belum Ada -</option>
              <?php foreach ($leader as $p) : ?>
                <option value="<?= $p->id ?>"><?= $p->nama_user ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-grou mb-1p">
            <label>SPG / SPB</label>
            <select class="form-control form-control-sm select2" id="id_spg" name="id_spg">
              <option value="0">- Belum Ada -</option>
              <?php foreach ($spg as $p) : ?>
                <option value="<?= $p->id ?>"><?= $p->nama_user ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cancel</button>
          <input type="hidden" name="id_toko_marketing" id="id_toko_marketing">
          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $('.btn_kartu').click(function() {
    var id_produk = $(this).data('id');
    var id_toko = $(this).data('id_toko');
    const url = '<?= base_url('adm/Toko') ?>';
    document.getElementById('loading').style.display = 'flex';
    // Reset the percentage
    var percentageElement = document.getElementById('percentage');
    percentageElement.textContent = '0%';
    var circle = document.querySelector('.circle');
    // Simulate loading data with setInterval
    var percentage = 0;
    var intervalTime = 50; // update every 50ms
    var interval = setInterval(() => {
      if (percentage < 100) {
        percentage += 1;
        percentageElement.textContent = Math.round(percentage) + '%';
        var angle = percentage * 3.6;
        circle.style.background = `conic-gradient(
                    #3498db 0deg,
                    #3498db ${angle}deg,
                    transparent ${angle}deg,
                    transparent 360deg
                )`;
      } else {
        clearInterval(interval);
      }
    }, intervalTime);
    fetch(`${url}/cari_kartu?id_toko=${id_toko}&id_artikel=${id_produk}`)
      .then(response => response.json())
      .then(data => {
        // Additional duration after data is fetched
        var additionalDuration = 2000; // 3 seconds
        var additionalIntervalTime = intervalTime; // same interval time
        var additionalIntervals = additionalDuration / additionalIntervalTime;
        var remainingIntervals = 0;

        var additionalInterval = setInterval(() => {
          remainingIntervals++;
          percentage = Math.min(100, percentage + (1 / additionalIntervals) * 100);
          if (remainingIntervals <= additionalIntervals && percentage <= 100) {
            percentageElement.textContent = Math.round(percentage) + '%';
            var angle = percentage * 3.6;
            circle.style.background = `conic-gradient(
                            #3498db 0deg,
                            #3498db ${angle}deg,
                            transparent ${angle}deg,
                            transparent 360deg
                        )`;
          } else {
            clearInterval(additionalInterval);
            percentageElement.textContent = '100%';
            circle.style.background = `conic-gradient(
                            #3498db 0deg,
                            #3498db 360deg,
                            transparent 360deg,
                            transparent 360deg
                        )`;
            setTimeout(() => {
              // Hide the loading animation
              document.getElementById('loading').style.display = 'none';
              updateUI(data);

            }, 500);
          }
        }, additionalIntervalTime);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
        clearInterval(interval);
        document.getElementById('loading').style.display = 'none';
      });
  });

  function updateUI(data) {
    // Function to format the date
    function formatDate(dateString) {
      const date = new Date(dateString);
      const options = {
        year: 'numeric',
        month: 'long',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
      };
      // Format date using Indonesian locale
      let formattedDate = new Intl.DateTimeFormat('id-ID', options).format(date);
      // Remove the word "pukul"
      formattedDate = formattedDate.replace(' pukul ', ' ');
      return formattedDate;
    }

    // Update the table
    var tableBody = document.getElementById('dataTableBody');
    tableBody.innerHTML = ''; // Clear previous content
    if (data.tabel_data.length > 0) {
      data.tabel_data.forEach((item, index) => {
        var formattedDate = formatDate(item.tanggal);
        var row = document.createElement('tr');
        row.innerHTML = `
                <td class="text-center">${formattedDate}</td>
                <td class="text-center">${item.no_doc}</td>
                <td class="text-center">${item.keterangan}</td>
                <td class="text-center">${item.pembuat}</td>
                <td class="text-center">${item.masuk}</td>
                <td class="text-center">${item.keluar}</td>
                <td class="text-center">${item.sisa}</td>
            `;
        tableBody.appendChild(row);
      });
      // Assuming s_awal is the stock at the start of the period
      $('#s_awal').html(data.s_awal);
      $('#s_akhir').html(data.s_akhir);
    } else {
      // Display message when data is empty
      tableBody.innerHTML = '<tr><td colspan="7" class="text-center">TIDAK ADA RIWAYAT TRANSAKSI</td></tr>';
      $('#s_awal').html('0'); // You can set default values here
      $('#s_akhir').html('0'); // You can set default values here
    }
  }
</script>
<script>
  $(document).ready(function() {
    $('#btnHistori').click(function() {
      var id = $(this).data('id');
      $.ajax({
        url: '<?= base_url('adm/Toko/histori/') ?>' + id, // Ganti url dengan endpoint Anda
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.status === 'success') {
            // Bersihkan konten timeline sebelum menambahkan data baru
            $('.timeline').empty();

            // Iterasi data histori dan tambahkan ke dalam timeline
            $.each(response.data, function(index, item) {
              var timelineItem = `
                <div>
                  <i class="fas bg-blue">${index + 1}</i>
                  <div class="timeline-item">
                    <span class="time"></span>
                    <p class="timeline-header"><small>${item.aksi} <strong>${item.pembuat}</strong></small></p>
                    <div class="timeline-body">
                      <small>
                        ${item.tanggal} <br>
                        Catatan :<br>
                        ${item.catatan}
                      </small>
                    </div>
                  </div>
                </div>
              `;
              $('.timeline').append(timelineItem);
            });

            // Tampilkan modal
            $('#modalHistori').modal('show');
          } else {
            // Tampilkan pesan error jika terjadi kesalahan
            alert('Histori Toko Tidak Ditemukan.');
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          alert('Terjadi kesalahan saat mengambil data histori.');
        }
      });
    });
    $('.btn_edit[data-target="#modal_toko"]').on('click', function() {
      var id = $(this).data('id');
      var namaToko = $(this).data('toko');
      $('#toko_id').val(id);
      $('#nama_toko').val(namaToko);
    });
    $('.btn_edit[data-target="#modal_foto"]').on('click', function() {
      var id = $(this).data('id');
      var namaToko = $(this).data('toko');
      $('#toko_id_foto').val(id);
    });
    $('.btn_edit[data-target="#modal_detail"]').on('click', function() {
      var id = $(this).data('id');
      var id_cust = $(this).data('id_cust');
      var jenis_toko = $(this).data('jenis_toko');
      var pic = $(this).data('pic');
      var telp = $(this).data('telp');
      var provinsi = $(this).data('provinsi');
      var kab = $(this).data('kabupaten');
      var kec = $(this).data('kecamatan');
      var alamat = $(this).data('alamat');
      $('#id_cust').val(id_cust).trigger('change');
      $('#jenis_toko').val(jenis_toko).trigger('change');
      setAutoProvinsi(provinsi);
      setAutoKabupaten(kab);
      $('#kecamatan').val(kec).trigger('change');
      $('#pic').val(pic);
      $('#telp').val(telp);
      $('#alamat').val(alamat);
      $('#id_toko_detail').val(id);
    });
    $('.btn_edit[data-target="#modal_pengaturan"]').on('click', function() {
      var id = $(this).data('id_toko_pengaturan');
      var gudang = $(this).data('gudang');
      var tgl_so = $(this).data('tgl_so');
      var margin = $(this).data('margin');
      var target_toko = $(this).data('target_toko');
      var het = $(this).data('het');
      $('#tgl_so').val(tgl_so).trigger('change');
      $('#het').val(het).trigger('change');
      $('#id_toko_pengaturan').val(id);
      $('#gudang').val(gudang);
      $('#margin').val(margin);
      $('#target').val(target_toko);
    });
    $('.btn_edit[data-target="#modal_po"]').on('click', function() {
      var id = $(this).data('id_toko_po');
      var batas_po = $(this).data('batas_po');
      var ssr = $(this).data('ssr');
      var max_po = $(this).data('max_po');
      $('#id_toko_po').val(id);
      $('#batas_po').val(batas_po).trigger('change');
      $('#ssr').val(ssr);
      $('#max_po').val(max_po);
    });
    $('.btn_edit[data-target="#modal_marketing"]').on('click', function() {
      var id = $(this).data('id_toko_marketing');
      var spv = $(this).data('spv');
      var leader = $(this).data('leader');
      var spg = $(this).data('spg');
      $('#id_toko_marketing').val(id);
      $('#id_spv').val(spv).trigger('change');
      $('#id_leader').val(leader).trigger('change');
      $('#id_spg').val(spg).trigger('change');
    });

    function setAutoProvinsi(provinsi) {
      autoTriggered = true;
      $('#id_provinsi').val(provinsi).trigger('change');
      autoTriggered = false;
    }

    function setAutoKabupaten(kabupaten) {
      autoTriggered = true;
      $('#kabupaten').val(kabupaten).trigger('change');
      autoTriggered = false;
    }
  });
  var autoTriggered = false;
  $('#id_provinsi').on('change', function() {
    if (!autoTriggered) {
      var selectedProvinsi = $(this).val();
      if (selectedProvinsi) {
        $.ajax({
          url: "<?php echo base_url('adm/Toko/add_ajax_kab'); ?>/" + selectedProvinsi,
          dataType: 'json',
          success: function(data) {
            $('#kabupaten').empty();
            $('#kecamatan').empty();
            $('#kecamatan').append('<option value="">- Select Kecamatan -</option>');
            $('#kabupaten').append('<option value="">- Select Kabupaten -</option>');
            $.each(data, function(index, item) {
              $('#kabupaten').append('<option value="' + item.id + '">' + item.nama + '</option>');
            });
          }
        });
      }
    }
  });
  $("#kabupaten").change(function() {
    if (!autoTriggered) {
      var selectedkab = $(this).val();
      if (selectedkab) {
        $.ajax({
          url: "<?php echo base_url('adm/Toko/add_ajax_kec'); ?>/" + selectedkab,
          dataType: 'json',
          success: function(data) {
            $('#kecamatan').empty();
            $('#kecamatan').append('<option value="">- Select Kecamatan -</option>');
            $.each(data, function(index, item) {
              $('#kecamatan').append('<option value="' + item.id + '">' + item.nama + '</option>');
            });
          }
        });
      }
    }

  });
</script>
<script>
  function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }

  document.addEventListener('DOMContentLoaded', function() {
    var inputs = document.querySelectorAll('.rupiah-input');
    inputs.forEach(function(input) {
      input.addEventListener('keyup', function(e) {
        this.value = formatRupiah(this.value, 'Rp. ');
      });
    });
  });
</script>