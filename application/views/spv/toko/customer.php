<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <form action="<?= base_url('spv/Toko/add_customer') ?>" method="post" enctype="multipart/form-data" id="form_proses">
          <div class="card card-info ">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-store"></i> Pengajuan Toko </h3>
              <div class="card-tools">
                <a href="<?= base_url('spv/Toko/pengajuanToko') ?>"> <i class="fas fa-times-circle"></i></a>
              </div>
            </div>
            <div class="card-body">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-user"></i>
                    <strong>Data Customer</strong>
                  </h3>
                </div>
                <div class="card-body">
                  <table class="table">
                    <tr>
                      <td>Nama Customer *</td>
                      <td>
                        <input type="text" class="form-control form-control-sm" id="customer" name="customer" placeholder="...." autocomplete="off" required>
                      </td>
                    </tr>
                    <tr>
                      <td>PIC *</td>
                      <td>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <span>Nama</span>
                              <input type="text" class="form-control form-control-sm" name="pic_cust" placeholder="...." autocomplete="off" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <span>Telp</span>
                              <input type="number" class="form-control form-control-sm" name="telp_cust" placeholder="...." autocomplete="off" required>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Jatuh Tempo / T.O.P *</td>
                      <td>
                        <input type="number" class="form-control form-control-sm" name="top" placeholder="...." autocomplete="off" required>
                        <small>Hitungan jumlah hari</small>
                      </td>
                    </tr>
                    <tr>
                      <td>Alamat Office *</td>
                      <td>
                        <textarea class="form-control form-control-sm" name="alamat_cust" placeholder="..." autocomplete="off" required></textarea>
                        <small>Alamat yang digunakan untuk penagihan.</small>
                      </td>
                    </tr>
                    <tr>
                      <td>Data Pendukung</td>
                      <td>
                        <div class="row">
                          <div class="col-sm-5">
                            <div class="form-group">
                              <span>Foto KTP</span>
                              <input type="file" class="form-control form-control-sm" name="foto_ktp" accept="image/png, image/jpeg, image/jpg">
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                              <span>Foto NPWP *</span>
                              <input type="file" class="form-control form-control-sm" name="foto_npwp" accept="image/png, image/jpeg, image/jpg" required>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="card card-warning card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-store"></i>
                    <strong>Data Toko</strong>
                  </h3>
                </div>
                <div class="card-body">
                  <table class="table">
                    <tr>
                      <td>Nama Toko *</td>
                      <td>
                        <input type="text" class="form-control form-control-sm" id="toko" name="nama_toko" placeholder="...." required>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <p class="mb-0">Jenis Toko *</p>
                              <select name="jenis_toko" class="form-control form-control-sm" required>
                                <option value="">Pilih Jenis Toko</option>
                                <option value="1">Dept Store</option>
                                <option value="6">Hypermarket</option>
                                <option value="2">Supermarket</option>
                                <option value="3">Grosir</option>
                                <option value="4">Minimarket</option>
                                <option value="5">Lain-lain.</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <p class="mb-0">HET *</p>
                              <select name="het" class="form-control form-control-sm" required>
                                <option value="">- Pilih Type Harga -</option>
                                <option value="1">HET JAWA</option>
                                <option value="2">HET INDOBARAT</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <p class="mb-0">Margin (%) *</p>
                              <input type="text" class="form-control form-control-sm" name="diskon" id="diskon" autocomplete="off" placeholder="contoh : 23.6" required>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <p class="mb-0">Tgl Stok Opname (SO) *</p>
                              <div class="input-group input-group-sm date" id="reservationdate" data-target-input="nearest">
                                <select name="tgl_so" class="form-control" required>
                                  <option value="">- Pilih Tgl SO -</option>
                                  <?php
                                  $limit = 15;
                                  for ($i = 1; $i <= $limit; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                  }
                                  ?>

                                </select>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                  <div class="input-group-text">/ Bulan</div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Potensi Sales *</td>
                      <td>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <p class="mb-0">Rider *</p>
                              <input type="text" class="form-control form-control-sm rupiah-input" name="s_rider" placeholder="..." required>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <p class="mb-0">GT-Man *</p>
                              <input type="text" class="form-control form-control-sm rupiah-input" name="s_gtman" placeholder="..." required>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <p class="mb-0">Crocodile *</p>
                              <input type="text" class="form-control form-control-sm rupiah-input" name="s_crocodile" placeholder="..." required>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <p class="mb-0">Target Sales *</p>
                              <input type="text" class="form-control form-control-sm rupiah-input" name="target" id="target" placeholder="..." required>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <p class="mb-0">Limit Toko</p>
                              <input type="text" class="form-control form-control-sm rupiah-input" name="limit" id="limit" placeholder="( opsional )">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <p class="mb-0">Listing Fee</p>
                              <input type="text" class="form-control form-control-sm rupiah-input" name="listing" placeholder="( opsional )">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <p class="mb-0">Etc Fee</p>
                              <input type="text" class="form-control form-control-sm rupiah-input" name="etc" placeholder="( opsional )">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <p class="mb-0">Sewa Rak</p>
                              <input type="text" class="form-control form-control-sm rupiah-input" name="sewa_rak" placeholder="( opsional )">
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>PIC *</td>
                      <td>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <span>Nama</span>
                              <input type="text" class="form-control form-control-sm" name="pic_toko" placeholder="..." required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <span>Telp</span>
                              <input type="number" class="form-control form-control-sm" name="telp_toko" placeholder="..." required>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Alamat Toko *</td>
                      <td>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <p class="mb-0">Provinsi :</p>
                              <select name="provinsi" class="form-control form-control-sm select2" id="provinsi_toko" required>
                                <option>- Pilih Provinsi -</option>
                                <?php
                                foreach ($provinsi as $prov) {
                                  echo '<option value="' . $prov->id . '">' . $prov->nama . '</option>';
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <p class="mb-0">Kabupaten :</p>
                              <select name="kabupaten" class="form-control form-control-sm select2" id="kabupaten_toko" required>
                                <option value=''>- Pilih Kabupaten -</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <p class="mb-0">Kecamatan :</p>
                              <select name="kecamatan" class="form-control form-control-sm select2" id="kecamatan_toko" required>
                                <option>- Pilih Kecamatan -</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>
                        <textarea class="form-control form-control-sm" name="alamat_toko" placeholder="..." required></textarea>
                        <small>Alamat untuk pengiriman Barang</small>
                      </td>
                    </tr>
                    <tr>
                      <td>Pengguna Sistem</td>
                      <td>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <span>Leader *</span>
                              <select name="id_leader" class="form-control form-control-sm select2" required>
                                <option value="">Pilih Team Leader</option>
                                <?php foreach ($list_leader as $l) { ?>
                                  <option value="<?= $l->id ?>"><?= $l->nama_user ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <span>SPG</span>
                              <select name="id_spg" class="form-control form-control-sm select2">
                                <option value="0"> - Belum ada SPG -</option>
                                <?php foreach ($list_spg as $l) { ?>
                                  <option value="<?= $l->id ?>"><?= $l->nama_user ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Data Pendukung </td>
                      <td>
                        <div class="row">
                          <div class="col-sm-5">
                            <div class="form-group">
                              <span>Foto Toko *</span>
                              <input type="file" class="form-control form-control-sm" name="foto_toko" accept="image/png, image/jpeg, image/jpg" required>
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                              <span>Foto PIC *</span>
                              <input type="file" class="form-control form-control-sm" name="foto_pic" accept="image/png, image/jpeg, image/jpg" required>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Waktu Realisasi *</td>
                      <td>
                        <input type="date" class="form-control form-control-sm" style="max-width: 200px;" name="realisasi" min="<?= date('Y-m-d') ?>" required>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="form-group">
                <strong> Catatan : *</strong>
                <textarea name="catatan_spv" class="form-control form-control-sm" placeholder="...." required></textarea>
              </div>
              <hr>
              <small>*) Harus Di lengkapi.</small>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-success float-right btn-sm" id="btn-kirim"><i class="fa fa-paper-plane"></i> Ajukan</button>
              <a href="<?= base_url('spv/Toko/pengajuanToko') ?>" class="btn btn-danger float-right mr-3 btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  function validateForm() {
    let isValid = true;
    // Get all required input fields
    $('#form_proses').find('input[required], select[required], textarea[required]').each(function() {
      if ($(this).val() === '') {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    return isValid;
  }
  $('#btn-kirim').click(function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data Pengajuan Toko akan di proses",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {

        if (validateForm()) {
          document.getElementById("form_proses").submit();
        } else {
          Swal.fire({
            title: 'Belum Lengkap',
            text: ' Pastikan data di input dengan lengkap',
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        }
      }
    })
  })
</script>
<script>
  // Mengambil elemen input diskon dari halaman HTML
  const inputDiskon = document.getElementById('diskon');
  // non aktif huruf dan koma
  inputDiskon.addEventListener('keydown', function(event) {
    if ((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode == 188)) {
      event.preventDefault();
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
<script>
  $(document).ready(function() {
    $("#provinsi_toko").change(function() {
      var url = "<?php echo base_url('spv/Toko/add_ajax_kab'); ?>/" + $(this).val();
      $('#kabupaten_toko').load(url);
      return false;
    })
    $("#kabupaten_toko").change(function() {
      var url = "<?php echo base_url('spv/Toko/add_ajax_kec'); ?>/" + $(this).val();
      $('#kecamatan_toko').load(url);
      return false;
    })
    $('#customer').change(function() {
      var customer = $(this).val()
      // Kirim data ke controller MyTable dengan AJAX
      $.ajax({
        url: "<?php echo base_url('spv/Toko/cek_cust') ?>",
        type: "POST",
        dataType: "JSON",
        data: {
          customer: customer
        },
        success: function(data) {
          if (data == true) {
            Swal.fire('CUSTOMER SUDAH ADA', 'silahkan input dengan customer yang lain!', 'info');
            $('#customer').val('');
          }
        }
      });
    })
    $('#toko').change(function() {
      var toko = $(this).val()
      $.ajax({
        url: "<?php echo base_url('spv/Toko/cek_toko') ?>",
        type: "POST",
        dataType: "JSON",
        data: {
          toko: toko
        },
        success: function(data) {
          if (data == true) {
            Swal.fire('TOKO SUDAH ADA', 'silahkan input dengan toko yang lain!', 'info');
            $('#toko').val('');
          }
        }
      });
    })
  });
</script>