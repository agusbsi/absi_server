    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <!-- /.card -->

            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">
                  <li class="fas fa-hospital"></li> Data Master Aset
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-4"></div>
                  <div class="col-md-4 text-right">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i>
                      Tambah Aset
                    </button>

                  </div>
                </div>
                <hr>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Kode Aset #</th>
                      <th>Nama Aset</th>
                      <th>Jumlah</th>
                      <th>Satuan</th>
                      <th>Menu</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php if (is_array($list_data)) { ?>
                        <?php $no = 1; ?>
                        <?php foreach ($list_data as $dd) : ?>
                          <td><?= $no ?></td>
                          <td><?= $dd->kode ?></td>
                          <td><?= $dd->aset ?></td>
                          <td><?= $dd->qty ?></td>
                          <td class="text-center"><?= $dd->unit ?>
                          </td>
                          <td>
                            <button class="btn btn-warning btn-sm" onclick="getUpdate('<?php echo $dd->id; ?>')" data-toggle="modal" data-target="#modalUpdate"><i class="fa fa-edit"></i> Update</button>
                          </td>
                    </tr>
                    <?php $no++; ?>
                  <?php endforeach; ?>
                <?php } else { ?>
                  <td colspan="6" align="center"><strong>Data Kosong</strong></td>
                <?php } ?>
                  </tbody>

                </table>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- modal tambah data -->
    <div class="modal fade" id="modal-tambah">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-success">
            <h4 class="modal-title">
              <li class="fas fa-plus-circle"></li> Form Tambah Aset
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- isi konten -->
            <form method="POST" action="<?= base_url('hrd/aset/proses_tambah') ?>" role="form" method="post" enctype="multipart/form-data">
              <div class="form-group mb-1">
                <label for="nik">Kode
                </label>
                <input type="text" name="kode" class="form-control form-control-sm" placeholder="...." required>
              </div>
              <div class="form-group mb-1">
                <label for="nama"> Nama Aset
                </label> </br>
                <input type="text" name="aset" class="form-control form-control-sm" placeholder="...." required="">
              </div>
              <div class="form-group mb-1">
                <label for="nama"> Jumlah
                </label> </br>
                <input type="number" name="qty" class="form-control form-control-sm" placeholder="...." required="">
              </div>
              <div class="form-group mb-1">
                <label for="nama"> Unit
                </label> </br>
                <input type="text" name="unit" class="form-control form-control-sm" placeholder="...." required="">
              </div>
          </div>
          <div class="modal-footer ">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
              <li class="fas fa-times-circle"></li> Cancel
            </button>
            <button type="submit" class="btn btn-success btn-sm">
              <li class="fas fa-save"></li> Simpan
            </button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- modal tambah data -->
    <div class="modal fade" id="modalDetail">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h4 class="modal-title">
              Detail Aset
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <div class="position-relative">
                  <img src="" alt="Photo 1" class="img-fluid">
                  <div class="ribbon-wrapper ribbon-lg">
                    <div class="ribbon bg-success text-lg">
                      Aset
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group mb-1">
                  <label for="nik">Kode
                  </label>
                  <input type="text" name="kode" class="form-control form-control-sm" id="id_detail" readonly>
                </div>
                <div class="form-group mb-1">
                  <label for="nama"> Nama Aset
                  </label> </br>
                  <input type="text" name="aset" class="form-control form-control-sm" id="nama_detail" readonly>
                </div>
                <div class="form-group mb-1">
                  <label for="nama"> Jumlah
                  </label> </br>
                  <input type="number" name="qty" class="form-control form-control-sm" readonly>
                </div>
                <div class="form-group mb-1">
                  <label for="nama"> Unit
                  </label> </br>
                  <input type="text" name="unit" class="form-control form-control-sm" readonly>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer ">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
              <li class="fas fa-times-circle"></li> close
            </button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modalUpdate">
      <div class="modal-dialog modal-lg">
        <form method="POST" action="<?= base_url('hrd/Aset/proses_update') ?>" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header bg-warning">
              <h4 class="modal-title">
                Update Aset
              </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="position-relative">

                    <div class="ribbon-wrapper ribbon-lg">
                      <div class="ribbon bg-success text-lg">
                        Aset
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-8">
                  <div class="form-group mb-1">
                    <label for="nik">Kode
                    </label>
                    <input type="text" name="kode" class="form-control form-control-sm" id="kode_edit" required>
                    <input type="hidden" name="id" class="form-control form-control-sm" id="id_edit">
                  </div>
                  <div class="form-group mb-1">
                    <label for="nama"> Nama Aset
                    </label> </br>
                    <input type="text" name="aset" class="form-control form-control-sm" id="aset_edit" required>
                  </div>
                  <div class="form-group mb-1">
                    <label for="nama"> Jumlah
                    </label> </br>
                    <input type="number" name="qty" class="form-control form-control-sm" id="qty_edit" required>
                  </div>
                  <div class="form-group mb-1">
                    <label for="nama"> Unit
                    </label> </br>
                    <input type="text" name="unit" class="form-control form-control-sm" id="unit_edit" required>
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer ">
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                <li class="fas fa-times-circle"></li> close
              </button>
              <button type="submit" class="btn btn-primary btn-sm">
                <li class="fas fa-save"></li> Simpan
              </button>
            </div>
          </div>
        </form>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <script>
      function getDetail(aset) {
        $.ajax({
          url: "<?php echo base_url('hrd/Aset/get_detail'); ?>",
          method: "POST",
          data: {
            aset: aset
          },
          dataType: "json", // Ubah ke dataType "json" jika data yang diambil dari server adalah JSON
          success: function(data) {
            var fotoAset = data.foto_aset ? "<?php echo base_url('assets/img/aset/'); ?>" + data.foto_aset : "<?php echo base_url('assets/img/user.png'); ?>";
            var imgElement = $("#modalDetail img");
            imgElement.attr("src", fotoAset);

            $("#id_detail").val(data.id);
            $("#nama_detail").val(data.nama_aset);
            $("#keterangan_detail").val(data.keterangan);
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      }

      function getUpdate(aset) {
        $.ajax({
          url: "<?php echo base_url('hrd/Aset/get_detail'); ?>",
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
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      }
    </script>