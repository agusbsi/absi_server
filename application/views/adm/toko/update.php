<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-info card-outline">
      <div class="card-header">
        <h3 class="card-title">Foto Toko</h3>
      </div>
      <form action="<?= base_url('adm/Toko/update_foto') ?>" method="post" enctype="multipart/form-data">
        <div class="card-body box-profile">
          <?php if (!empty($detail->foto_toko)) { ?>
            <img class="img-rounded" style="width: 200px;" src="<?= base_url('assets/img/toko/' . $detail->foto_toko) ?>" alt="Foto Toko">
          <?php } else { ?>
            <img class="img-rounded" style="width: 200px;" src="<?= base_url('assets/img/toko/hicoop.png') ?>" alt="Foto Toko">
          <?php } ?>
          <div class="form-group">
            <label for="foto">Ganti Foto :</label>
            <input type="hidden" name="id_toko_foto" value="<?= $detail->id ?>">
            <input type="file" class="form-control form-control-sm" name="foto" multiple accept="image/png, image/jpeg, image/jpg" required></input>
            <small>noted: Jenis foto yang diperbolehkan : JPG|JPEG|PNG & size maksimal : 2 mb</small>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-outline-primary btn-sm btn-foto"><i class="fas fa-save"></i> Simpan</button>
        </div>
      </form>
    </div>
    <form action="<?= base_url('adm/Toko/proses_update') ?>" method="post">
      <div class="card card-warning">

        <div class="card-header">
          <h3 class="card-title">
            <li class="fas fa-store"></li> Detail Toko
          </h3>
        </div>
        <div class="card-body">
          <strong># Detail</strong>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <strong>Nama Toko</strong>
                <input type="hidden" name="id_toko" class="form-control " value="<?= $detail->id ?>" readonly>
                <input type="text" name="nama_toko" class="form-control form-control-sm nama_toko" value="<?= $detail->nama_toko ?>" required>
              </div>
              <div class="form-group">
                <strong>Customer</strong>
                <select class="form-control form-control-sm provinsi select2" name="customer" required>
                  <option value=''>- Pilih Customer -</option>
                  <?php foreach ($customer as $p) : ?>
                    <option value="<?= $p->id ?>" <?= ($detail->id_customer) == $p->id ? 'selected' : '' ?>><?= $p->nama_cust ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <strong>Jenis Toko</strong>
                <select class="form-control form-control-sm select2" name="jenis_toko">
                  <option value="1" <?= ($detail->jenis_toko) == 1 ? 'selected' : '' ?>>Dept Store</option>
                  <option value="2" <?= ($detail->jenis_toko) == 2 ? 'selected' : '' ?>>Supermarket</option>
                  <option value="3" <?= ($detail->jenis_toko) == 3 ? 'selected' : '' ?>>Grosir</option>
                  <option value="4" <?= ($detail->jenis_toko) == 4 ? 'selected' : '' ?>>Minimarket</option>
                  <option value="5" <?= ($detail->jenis_toko) == 5 ? 'selected' : '' ?>>Lain-lain.</option>
                </select>
              </div>
              <div class="form-group">
                <strong>Nama PIC Toko</strong>
                <input type="text" class="form-control form-control-sm pic" name="pic" value="<?= $detail->nama_pic ?>" required=""></input>
              </div>
              <div class="form-group">
                <strong>No. Telp</strong>
                <input type="number" class="form-control form-control-sm telp" name="no_telp" value="<?= $detail->telp ?>" required=""></input>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <strong>Provinsi</strong>
                <select class="form-control form-control-sm provinsi select2" name="provinsi" id="provinsi" required>
                  <option value=''>- Pilih Provinsi -</option>
                  <?php foreach ($provinsi as $p) : ?>
                    <option value="<?= $p->id ?>" <?= ($detail->provinsi) == $p->id ? 'selected' : '' ?>><?= $p->nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <strong>Kabupaten</strong>
                <select class="form-control form-control-sm kabupaten select2" name="kabupaten" id="kabupaten" required>
                  <?php foreach ($kabupaten as $p) : ?>
                    <option value="<?= $p->id ?>" <?= ($detail->kabupaten) == $p->id ? 'selected' : '' ?>><?= $p->nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <strong>Kecamatan</strong>
                <select class="form-control form-control-sm kecamatan select2" name="kecamatan" id="kecamatan" required>
                  <?php foreach ($kecamatan as $p) : ?>
                    <option value="<?= $p->id ?>" <?= ($detail->kecamatan) == $p->id ? 'selected' : '' ?>><?= $p->nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <strong>Alamat</strong>
                <textarea class="form-control form-control-sm alamat" name="alamat" required> <?= $detail->alamat ?></textarea>
              </div>
            </div>
          </div>
          <hr>
          <strong># Pengaturan</strong>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <strong>Tanggal SO</strong>
                <select class="form-control form-control-sm tgl_so select2" name="tgl_so" required>
                  <option value="">- Pilih tgl SO -</option>
                  <option value="1" <?= ($detail->tgl_so) == 1 ? 'selected' : '' ?>>1</option>
                  <option value="2" <?= ($detail->tgl_so) == 2 ? 'selected' : '' ?>>2</option>
                  <option value="3" <?= ($detail->tgl_so) == 3 ? 'selected' : '' ?>>3</option>
                  <option value="4" <?= ($detail->tgl_so) == 4 ? 'selected' : '' ?>>4</option>
                  <option value="5" <?= ($detail->tgl_so) == 5 ? 'selected' : '' ?>>5</option>
                  <option value="6" <?= ($detail->tgl_so) == 6 ? 'selected' : '' ?>>6</option>
                  <option value="7" <?= ($detail->tgl_so) == 7 ? 'selected' : '' ?>>7</option>
                  <option value="8" <?= ($detail->tgl_so) == 8 ? 'selected' : '' ?>>8</option>
                  <option value="9" <?= ($detail->tgl_so) == 9 ? 'selected' : '' ?>>9</option>
                  <option value="10" <?= ($detail->tgl_so) == 10 ? 'selected' : '' ?>>10</option>
                  <option value="11" <?= ($detail->tgl_so) == 11 ? 'selected' : '' ?>>11</option>
                  <option value="12" <?= ($detail->tgl_so) == 12 ? 'selected' : '' ?>>12</option>
                  <option value="13" <?= ($detail->tgl_so) == 13 ? 'selected' : '' ?>>13</option>
                  <option value="14" <?= ($detail->tgl_so) == 14 ? 'selected' : '' ?>>14</option>
                  <option value="15" <?= ($detail->tgl_so) == 15 ? 'selected' : '' ?>>15</option>
                </select>
              </div>
              <div class="form-group">
                <strong>Tipe Harga</strong>
                <select class="form-control form-control-sm select2" name="het" required>
                  <option value="">- Pilih Tipe Harga -</option>
                  <option value="1" <?= ($detail->het) == 1 ? 'selected' : '' ?>>HET JAWA</option>
                  <option value="2" <?= ($detail->het) == 2 ? 'selected' : '' ?>>HET INDOBARAT</option>
                </select>
              </div>
              <div class="form-group">
                <strong>Margin Toko</strong>
                <div class="input-group my-colorpicker2">
                  <input type="number" class="form-control form-control-sm" name="diskon" value="<?= $detail->diskon ?>" required>
                  <div class="input-group-append ">
                    <span class="input-group-text form-control-sm">%</span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <strong>Limit Toko</strong>
                <input type="text" class="form-control form-control-sm rupiah-input" name="limit" value="<?= $detail->limit_toko ?>" required></input>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <strong>Target Sales Toko</strong>
                <input type="text" class="form-control form-control-sm rupiah-input" name="target" value="<?= $detail->target ?>" required></input>
              </div>
              <div class="form-group">
                <strong>Batas PO</strong>
                <select class="form-control form-control-sm select2" name="batas_po" required>
                  <option value="">- Pilih fungsi -</option>
                  <option value="1" <?= ($detail->status_ssr) == 1 ? 'selected' : '' ?>>AKTIF</option>
                  <option value="0" <?= ($detail->status_ssr) == 0 ? 'selected' : '' ?>>TIDAK AKTIF</option>
                </select>
                <small>Fungsi ini digunakan untuk membatasi maksimal jumlah PO Barang spg.</small>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <strong>SSR Toko</strong>
                    <div class="input-group my-colorpicker2">
                      <input type="number" class="form-control form-control-sm" name="ssr" value="<?= $detail->ssr ?>" required>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <strong>Max PO</strong>
                    <div class="input-group my-colorpicker2">
                      <input type="number" class="form-control form-control-sm" name="max_po" value="<?= $detail->max_po ?>" required>
                      <div class="input-group-append ">
                        <span class="input-group-text form-control-sm">%</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary float-right btn-sm"><i class="fas fa-save"></i> Simpan</button>
          <a href="<?= base_url('adm/toko/') ?>" class="btn btn-danger float-right mr-3 btn-sm"><i class="fas fa-times-circle"></i> Close</a>
        </div>
    </form>

  </div>
  </div>
</section>
<script>
  $(document).ready(function() {
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
  })
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