<style>
  td {
    font-size: 12px;
    text-align: left;
  }

  tr {
    font-size: 14px;
  }

  .menu-button {
    display: none;
    transition: transform 0.3s ease;
    transform: translateX(100%);
  }

  tr:hover .menu-button {
    display: inline-block;
    transform: translateX(0);
  }

  tr:hover .menu-status {
    display: none;
  }

  tr:hover {
    background-color: rgba(0, 0, 0, 0.1);
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"> <i class="fas fa-cube"></i> Data Artikel</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <button type="button" id="toggleAktif" class="btn btn-sm btn-primary" style="display: none; margin-bottom: 10px;"><i class="fas fa-check-circle"></i> AKTIFKAN</button>
                <button type="button" id="toggleNonAktif" class="btn btn-sm btn-danger" style="display: none; margin-bottom: 10px;"><i class="fas fa-ban"></i> NON AKTIFKAN</button>
              </div>
              <div class="col-md-6 text-right">
                <a href="<?= base_url('adm/Produk/template_artikel') ?>" class="btn btn-warning btn-sm"><i class="fas fa-download"></i>
                  Download template
                </a>
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-import"><i class="fas fa-upload"></i>
                  Import Artikel
                </button>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i>
                  Tambah Artikel
                </button>
              </div>
            </div>
            <hr>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th rowspan="2"><input type="checkbox" id="checkAll"></th>
                  <th rowspan="2" style="width:10%" class="text-center">Kode</th>
                  <th rowspan="2" class="text-center">Nama Artikel</th>
                  <th rowspan="2">Satuan</th>
                  <th rowspan="2">Brand</th>
                  <th rowspan="2">Min-Pack</th>
                  <th colspan="3" class="text-center">HET</th>
                  <th rowspan="2" style="width:10%">Status</th>
                </tr>
                <tr>
                  <th class="text-center">Jawa</th>
                  <th class="text-center">IndoBarat</th>
                  <th class="text-center">SP</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($list_data as $dd) :
                  $no++; ?>
                  <tr>
                    <td><input type="checkbox" class="rowCheck" value="<?= $dd->id ?>"></td>
                    <td><b><?= $dd->kode ?></b></td>
                    <td><?= $dd->nama_produk ?></td>
                    <td><?= $dd->satuan ?></td>
                    <td><?= $dd->brand ?></td>
                    <td><?= $dd->packing ?></td>
                    <td class="text-right">Rp <?= number_format($dd->harga_jawa) ?></td>
                    <td class="text-right">Rp <?= number_format($dd->harga_indobarat) ?></td>
                    <td class="text-right">Rp <?= number_format($dd->sp) ?></td>
                    <td>
                      <div class="menu-status">
                        <?= status_artikel($dd->status) ?>
                      </div>
                      <div class="menu-button">
                        <button class="btn btn-warning btn-edit btn-sm" data-toggle="modal" data-target="#editModal" data-id="<?= $dd->id; ?>" data-kode="<?= $dd->kode; ?>" data-status="<?= $dd->status; ?>" data-packing="<?= $dd->packing; ?>" data-brand="<?= $dd->brand; ?>" data-nama_produk="<?= $dd->nama_produk; ?>" data-harga1="<?= $dd->harga_jawa; ?>" data-harga2="<?= $dd->harga_indobarat; ?>" data-satuan="<?= $dd->satuan; ?>" data-sp="<?= $dd->sp; ?>">
                          <i class="fas fa-edit"></i></button>
                        <a type="button" class="btn btn-danger btn-hapus btn-sm" href="<?= base_url('adm/produk/hapus/' . $dd->id) ?>" title="Nonaktif artikel"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> <i class="fas fa-cube"></i> Form Tambah Artikel</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?= base_url('adm/produk/proses_tambah') ?>">
          <div class="form-group mb-1">
            <label for="kode">Kode Artikel</label>
            <input type="text" name="kode" class="form-control form-control-sm" autocomplete="off" placeholder="Kode Artikel" required="">
          </div>
          <div class="form-group mb-1">
            <label for="nama">Deskripsi</label>
            <input type="text" name="nama" class="form-control form-control-sm" autocomplete="off" id="nama" placeholder="Nama Artikel" required>
          </div>
          <div class="form-group mb-1">
            <label for="satuan">Satuan</label> </br>
            <select class="form-control form-control-sm" name="satuan" required>
              <option value="">- PIlih Satuan -</option>
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
          <i class="fas fa-times-circle"></i> Cancel
        </button>
        <button type="submit" class="btn btn-success btn-sm">
          <i class="fas fa-save"></i> Simpan
        </button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('adm/produk/proses_update') ?>" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-edit"></i> Update Artikel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-grou mb-1p">
            <label>Kode Artikel</label>
            <input type="text" class="form-control form-control-sm kode" name="kode" required>
          </div>
          <div class="form-group mb-1">
            <label>Nama Artikel</label>
            <input type="text" class="form-control form-control-sm nama_produk" name="nama_produk" required>
          </div>
          <div class="form-group mb-1">
            <label for="satuan">Satuan</label> </br>
            <select class="form-control form-control-sm" id="satuan_edit" name="satuan" required>
              <option value="">-- PIlih Satuan --</option>
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
            <i class="fas fa-times-circle"></i> Cancel
          </button>
          <input type="hidden" name="id" class="id">
          <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa-edit"></i> Update
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modal-import">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <li class="fa fa-excel"></li> Import Excel
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data" action="<?php echo base_url('adm/Produk/import_artikel'); ?>">
          <div class="form-group">
            <label for="file">File Upload</label>
            <input type="file" name="file" class="form-control" id="exampleInputFile" accept=".xlsx,.xls" required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
          <li class="fas fa-times-circle"></li> Cancel
        </button>
        <button type="submit" class="btn btn-primary btn-sm">
          <li class="fas fa-save"></li> Simpan
        </button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Konfirmasi -->
<div id="confirmModal" class="modal fade" tabindex="-1" role="dialog">
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
          confirmMessage.textContent = `Apakah Anda yakin ingin ${actionType} artikel : ${selectedIds.length} yang tercheklist ?`;
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