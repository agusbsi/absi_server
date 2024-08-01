<link rel="stylesheet" href="<?= base_url('') ?>assets/plugins/bs-stepper/css/bs-stepper.min.css">
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <form action="<?= base_url('spv/Toko/saveTutup'); ?>" method="post" id="form_tutup">
          <div class="card card-success ">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-file"></i> Form Tutup Toko</b> </h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="">No Pengajuan :</label>
                    <input type="text" name="no_retur" value="<?= $kode_retur ?>" class="form-control form-control-sm" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Nama Toko :</label>
                    <select name="id_toko" id="id_toko" class="form-control form-control-sm select2" required>
                      <option value="">- Pilih Toko -</option>
                      <?php foreach ($list_toko as $dt) : ?>
                        <option value="<?= $dt->id ?>"><?= $dt->nama_toko ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Tgl Penarikan :</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="date" name="tgl_tarik" id="tgl_tarik" class="form-control form-control-sm" autocomplete="off" required>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Di ajukan Oleh:</label>
                    <input type="text" value="<?= $this->session->userdata('nama_user'); ?>" class="form-control form-control-sm" readonly>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-12">
                  <div class="card card-default" id="list_tutup">
                    <div class="card-header">
                      <h3 class="card-title">Langkah-langkah Tutup Toko</h3>
                    </div>
                    <div class="card-body p-0">
                      <div class="bs-stepper linear">
                        <div class="bs-stepper-header" role="tablist">
                          <!-- your steps here -->
                          <div class="step active" data-target="#Penjualan-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="Penjualan-part" id="Penjualan-part-trigger" aria-selected="true">
                              <span class="bs-stepper-circle">1</span>
                              <span class="bs-stepper-label">Update Penjualan</span>
                            </button>
                          </div>
                          <div class="line"></div>
                          <div class="step" data-target="#Aset-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="Aset-part" id="Aset-part-trigger" aria-selected="false" disabled="disabled">
                              <span class="bs-stepper-circle">2</span>
                              <span class="bs-stepper-label">Update Aset</span>
                            </button>
                          </div>
                          <div class="line"></div>
                          <div class="step" data-target="#Stok-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="Stok-part" id="Stok-part-trigger" aria-selected="false" disabled="disabled">
                              <span class="bs-stepper-circle">3</span>
                              <span class="bs-stepper-label">Update Artikel</span>
                            </button>
                          </div>
                        </div>
                        <div class="bs-stepper-content">
                          <!-- your steps content here -->
                          <div id="Penjualan-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="Penjualan-part-trigger">

                            <div class="card-body">
                              <div class="form-group mb-0">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                                  <label class="custom-control-label" for="exampleCheck1"> Saya memastikan bahwa <a href="#"> SPG sudah input data penjualan hingga tgl <?= date('d M Y') ?> </a>.</label>
                                </div>
                              </div>
                            </div>

                            <button type="button" class="btn btn-primary btn-sm" id="btn_jual">Next <i class="fas fa-arrow-right"></i></button>
                          </div>
                          <div id="Aset-part" class="content " role="tabpanel" aria-labelledby="Aset-part-trigger">
                            <table id="table_retur" class="table table-bordered table-striped">
                              <thead>
                                <tr class="text-center">
                                  <th style="width:5%">No</th>
                                  <th style="width:30%">Nama Aset</th>
                                  <th style="width:15%">Jumlah</th>
                                  <th>Kondisi</th>
                                </tr>
                              </thead>
                              <tbody id="body_aset">
                              </tbody>
                            </table>
                            <span>Noted :</span> <br>
                            Jika data di sistem tidak sesuai dengan fisik di toko, segera hubungi Tim Operasional.
                            <hr>
                            <button type="button" class="btn btn-danger btn-sm" onclick="stepper.previous()"> <i class="fas fa-arrow-left"></i> Previous</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="stepper.next()">Next <i class="fas fa-arrow-right"></i></button>
                          </div>
                          <div id="Stok-part" class="content" role="tabpanel" aria-labelledby="Stok-part-trigger">
                            <table class="table table-bordered table-striped ">
                              <thead>
                                <tr>
                                  <th class="text-center">No</th>
                                  <th class="text-center">Kode Artikel</th>
                                  <th class="text-center">Deskripsi</th>
                                  <th class="text-center">Stok Sistem</th>
                                  <th class="text-center">QTY Retur</th>
                                </tr>
                              </thead>
                              <tbody id="body_hasil">
                              </tbody>
                            </table>
                            <div class="form-group">
                              <label for="">Catatan: *</label><br />
                              <textarea name="catatan" class="form-control form-control-sm" rows="5" cols="100%" required></textarea>
                              <small>Harus di isi.</small>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm" onclick="stepper.previous()"><i class="fas fa-arrow-left"></i> Previous</button>
                            <button type="submit" class="btn btn-primary btn-sm btn_kirim"><i class="fas fa-paper-plane"></i> Kirim</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                    </div>
                  </div>
                  <!-- /.card -->
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script src="<?= base_url('') ?>assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script src="<?= base_url('') ?>assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<script>
  $(document).ready(function() {
    $("#id_toko").change(function() {
      var id_toko = $(this).val();
      if (id_toko === "") {
        $("#body_hasil").html('');
        $("#body_aset").html('');
      } else {
        $.ajax({
          url: "<?php echo base_url('spv/Toko/artikelToko'); ?>",
          type: "GET",
          dataType: "json",
          data: {
            id_toko: id_toko
          },
          success: function(data) {
            var html = '';
            var aset = '';

            if (data.aset.length === 0) {
              aset += '<tr>';
              aset += '<td colspan ="4" class="text-center"> ASET KOSONG</td>';
              aset += '</tr>';
            } else {
              $.each(data.aset, function(i, item) {
                aset += '<tr>';
                aset += '<td class="text-center">' + (i + 1) + '</td>';
                aset += '<td> <small><strong>' + item.no_aset + '</strong><br>' + item.aset + '</small></td>';
                aset += '<td><input type="number" class="form-control form-control-sm" name="qty_aset[]" value="' + item.qty + '"></td>';
                aset += '<td><input type="hidden" class="id_produk" name="id_aset[]" value="' + item.id_aset + '"><textarea class="form-control form-control-sm" name="keterangan[]"></textarea></td>';
                aset += '</tr>';
              });
            }

            $.each(data.artikel, function(i, item) {
              html += '<tr>';
              html += '<td class="text-center">' + (i + 1) + '</td>';
              html += '<td>' + item.kode + '</td>';
              html += '<td>' + item.nama_produk + '</td>';
              html += '<td class="text-center">' + item.qty + '</td>';
              html += '<td><input type="hidden" class="id_produk" name="id_produk[]" value="' + item.id_produk + '"><input type="number" class="form-control form-control-sm" name="qty_retur[]" value="' + item.qty + '" required></td>';
              html += '</tr>';
            });
            $("#body_hasil").html(html);
            $("#body_aset").html(aset);
          },
          error: function(xhr, status, error) {
            console.log(xhr.responseText);
          }
        });
      }
    });

    function validateForm() {
      let isValid = true;
      // Get all required input fields
      $('#form_tutup').find('input[required], select[required], textarea[required]').each(function() {
        if ($(this).val() === '') {
          isValid = false;
          $(this).addClass('is-invalid');
        } else {
          $(this).removeClass('is-invalid');
        }
      });
      return isValid;
    }
    $('.btn_kirim').click(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data Pengajuan Tutup Toko akan di proses",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Yakin'
      }).then((result) => {
        if (result.isConfirmed) {

          if (validateForm()) {
            document.getElementById("form_tutup").submit();
          } else {
            Swal.fire({
              title: 'Belum Lengkap',
              text: ' Semua kolom  harus di isi.',
              icon: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            });
          }
        }
      })
    })
  });


  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function() {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'));
  });

  document.getElementById("btn_jual").addEventListener("click", function() {
    var checkbox = document.getElementById("exampleCheck1");
    var toko = $('#id_toko').val();
    var tgl_tarik = $('#tgl_tarik').val();
    if (toko === "" || tgl_tarik === "") {
      Swal.fire({
        title: 'Belum Lengkap',
        text: 'Nama toko dan tgl Penarikan tidak boleh kosong.',
        icon: 'error',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    } else if (!checkbox.checked) {
      Swal.fire({
        title: 'Belum Lengkap',
        text: 'Anda harus Checklist untuk memastikan spg sudah input data penjualan.',
        icon: 'error',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }
    stepper.next();
  });
</script>