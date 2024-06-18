<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <form action="<?= base_url('adm/Toko/approve') ?>" method="post" id="form_proses">
          <div class="card card-info ">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-store"></i> Data Pengajuan Toko </h3>
              <div class="card-tools">
                <a href="<?= base_url('adm/Toko/pengajuanToko') ?>"> <i class="fas fa-times-circle"></i> Close </a>
              </div>
            </div>
            <div class="card-body">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-user"></i>
                    Data Customer
                  </h3>
                </div>
                <div class="card-body">
                  <table class="table">
                    <tr>
                      <td>Nama Customer</td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->nama_cust ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td>PIC</td>
                      <td>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Nama</label>
                              <input type="text" class="form-control form-control-sm" value="<?= $toko->nama_pic ?>" readonly>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Telp</label>
                              <input type="text" class="form-control form-control-sm" value="<?= $toko->telp ?>" readonly>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>TOP</td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->top ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td>Alamat Office</td>
                      <td>
                        <textarea class="form-control form-control-sm" readonly><?= $toko->alamat_cust ?></textarea>
                      </td>
                    </tr>
                  </table>
                  <hr>
                  Data Pendukung
                  <hr>
                  <div class="row">
                    <div class="col-sm-5">
                      <div class="position-relative p-3" style="height: 180px">
                        <?php if (empty($toko->foto_ktp)) { ?>
                          Foto Kosong
                        <?php } else { ?>
                          <img src="<?= base_url('assets/img/customer/' . $toko->foto_ktp) ?>" style="height: 150px;" alt="Photo 2" class="img-fluid">
                        <?php } ?>
                        <div class="ribbon-wrapper ribbon-lg">
                          <div class="ribbon bg-warning">
                            KTP
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <div class="position-relative p-3" style="height: 180px">
                        <?php if (empty($toko->foto_npwp)) { ?>
                          Foto Kosong
                        <?php } else { ?>
                          <img src="<?= base_url('assets/img/customer/' . $toko->foto_npwp) ?>" style="height: 150px;" alt="Photo 2" class="img-fluid">
                        <?php } ?>
                        <div class="ribbon-wrapper ribbon-lg">
                          <div class="ribbon bg-danger">
                            NPWP
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card card-warning card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-store"></i>
                    Data Toko
                  </h3>
                </div>
                <div class="card-body">
                  <table class="table">
                    <tr>
                      <td>Nama Toko</td>
                      <td>
                        <input type="text" name="toko" class="form-control form-control-sm" value="<?= $toko->nama_toko ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="">Jenis Toko</label>
                              <input type="text" class="form-control form-control-sm" value="<?= jenis_toko($toko->jenis_toko) ?>" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="">HET</label> <br>
                              <?= status_het($toko->het) ?>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="">Margin (%)</label>
                              <input type="text" class="form-control form-control-sm" value="<?= $toko->diskon ?> %" readonly>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Potensi Sales</td>
                      <td>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="">Rider</label>
                              <input type="text" class="form-control form-control-sm" value="Rp <?= number_format($toko->s_rider) ?>" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="">GT-Men</label>
                              <input type="text" class="form-control form-control-sm" value="Rp <?= number_format($toko->s_gtman) ?>" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="">Crocodile</label>
                              <input type="text" class="form-control form-control-sm" value="Rp <?= number_format($toko->s_crocodile) ?>" readonly>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Target Sales Toko</label>
                              <input type="text" class="form-control form-control-sm" value="Rp <?= number_format($toko->target) ?>" readonly>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Limit Toko</label>
                              <input type="text" class="form-control form-control-sm" value="Rp <?= number_format($toko->limit_toko) ?>" readonly>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>PIC</td>
                      <td>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Nama</label>
                              <input type="text" class="form-control form-control-sm" value="<?= $toko->nama_pic ?>" readonly>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Telp</label>
                              <input type="text" class="form-control form-control-sm" value="<?= $toko->telp ?>" readonly>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Alamat Toko</td>
                      <td>
                        <textarea class="form-control form-control-sm" readonly><?= $toko->alamat ?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td>Pengguna Sistem</td>
                      <td>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Leader</label>
                              <input type="text" class="form-control form-control-sm" value="<?= $toko->leader ?>" readonly>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">SPG</label>
                              <input type="text" class="form-control form-control-sm" value="<?= ($toko->spg ? $toko->spg : "Belum ada spg") ?>" readonly>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
                  <hr>
                  # Data Pendukung
                  <hr>
                  <div class="row">
                    <div class="col-sm-5">
                      <div class="position-relative p-3" style="height: 180px">
                        <?php if (empty($toko->foto_toko)) { ?>
                          Foto Kosong
                        <?php } else { ?>
                          <img src="<?= base_url('assets/img/toko/' . $toko->foto_toko) ?>" style="height: 150px;" alt="Photo 2" class="img-fluid">
                        <?php } ?>
                        <div class="ribbon-wrapper ribbon-lg">
                          <div class="ribbon bg-warning">
                            Toko
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <div class="position-relative p-3" style="height: 180px">
                        <?php if (empty($toko->foto_pic)) { ?>
                          Foto Kosong
                        <?php } else { ?>
                          <img src="<?= base_url('assets/img/toko/' . $toko->foto_pic) ?>" style="height: 150px;" alt="Photo 2" class="img-fluid">
                        <?php } ?>
                        <div class="ribbon-wrapper ribbon-lg">
                          <div class="ribbon bg-danger">
                            PIC
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              # Proses Pengajuan :
              <hr>
              <div class="timeline">
                <div>
                  <i class="fas bg-green">1</i>
                  <div class="timeline-item">
                    <span class="time"><i class="fas fa-clock"></i> <?= $toko->created_at ?></span>
                    <h3 class="timeline-header no-border">Diajukan Oleh : <a href="#"><?= $toko->spv ?></a></h3>
                  </div>
                </div>
                <div>
                  <i class="fas bg-blue">2</i>
                  <div class="timeline-item">
                    <span class="time"></span>
                    <h3 class="timeline-header"><a href="#"> Manager Marketing</a></h3>
                    <div class="timeline-body">
                      Catatan :
                      <?= $toko->catatan_mm ?  $toko->catatan_mm : "Belum di Proses Manager Marketing" ?>
                    </div>
                  </div>
                </div>
                <div>
                  <i class="fas bg-blue">3</i>
                  <div class="timeline-item">
                    <span class="time"></span>
                    <h3 class="timeline-header"><a href="#"> Audit</a></h3>

                    <div class="timeline-body">
                      Catatan :
                      <?= $toko->catatan_audit ?  $toko->catatan_audit : "Belum di Proses Audit" ?>
                    </div>
                  </div>
                </div>
                <div>
                  <i class="fas bg-blue">4</i>
                  <div class="timeline-item">
                    <span class="time"></span>
                    <h3 class="timeline-header"><a href="#"> Direksi</a></h3>

                    <div class="timeline-body">
                      Catatan :
                      <?= $toko->catatan_direksi ?  $toko->catatan_direksi : "Belum di Proses Direksi" ?>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <?php if ($toko->status == 4) { ?>
                <div class="form-group">
                  <label for=""> Catatan anda</label>
                  <input type="hidden" name="id_toko" value="<?= $toko->id ?>">
                  <textarea name="catatan" cols="3" class="form-control form-control-sm" required></textarea>
                </div>
                <div class="form-group">
                  <label for=""> Keputusan anda</label>
                  <select name="keputusan" class="form-control form-control-sm" required>
                    <option value="">- Pilih -</option>
                    <option value="1"> Setujui </option>
                    <option value="5"> Tolak </option>
                  </select>
                </div>
              <?php } ?>
            </div>
            <div class="card-footer">
              <?php if ($toko->status == 4) { ?>
                <button type="submit" class="btn btn-success float-right btn-sm" id="btn-kirim"><i class="fas fa-save"></i> Simpan</button>
              <?php } ?>
              <a href="<?= base_url('adm/Toko/unduh_pdf/' . $toko->id) ?>" target="_blank" class="btn btn-secondary float-right btn-sm mr-3"><i class="fas fa-download"></i> Unduh</a>
              <a href="<?= base_url('adm/Toko/pengajuanToko') ?>" class="btn btn-danger float-right mr-3 btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
            text: ' Catatan & tindakan tidak boleh kosong',
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        }
      }
    })
  })
</script>