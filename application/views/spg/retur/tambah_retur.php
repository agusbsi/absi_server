<style>
  .box {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    margin-bottom: 20px;
    padding: 10px;
  }

  .box-header {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid rgba(0, 123, 255, 1);
    margin-bottom: 5px;
  }

  .box-body {
    display: flex;
    justify-content: space-between;
  }

  .box-body h5 {
    margin: 0;
    font-size: 13px;
    font-weight: bold;
  }

  .detail small {
    display: block;
  }

  .gambar img {
    width: 80px;
    height: auto;
    border-radius: 5px;
    margin-left: 5px;
    object-fit: cover;
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="nav-icon fas fa-plus-circle"></i> Form Pengajuan Retur</h3>
      </div>
      <div class="card-body">
        <!-- Master -->
        <div class="card card-default">
          <div class="card-body">
            <div class="form-group">
              <label>Toko :</label> [ <?= $toko_new->nama_toko ?> ]
            </div>
          </div>
        </div>
        <hr>
        <strong># Keranjang Artikel</strong>
        <hr>
        <?php if (count($data_cart) == 0) { ?>
          <h6 class="text-center">- Keranjang Kosong -</h6>
        <?php } ?>
        <?php
        $no = 0;
        foreach ($this->cart->contents() as $d) {
          $no++; ?>
          <div class="box">
            <div class="box-header">
              <p><?= $no ?></p>
              <a href="<?= base_url('spg/retur/hapus_cart/') . $d['rowid'] ?>"><i class="fa fa-trash text-danger"></i></a>
            </div>
            <div class="box-body">
              <div class="detail">
                <h5><?= $d['options'] ?></h5>
                <small class="mb-2"><?= $d['keterangan']['artikel']; ?></small>
                <small><strong>Jumlah :</strong> <?= $d['qty'] ?></small>
                <small><strong>Keterangan :</strong> <?= $d['keterangan']['status'] ?></small>
                <small><strong>Catatan :</strong> <?= $d['keterangan']['catatan']; ?></small>
              </div>
              <div class="gambar">
                <img src="<?= base_url('assets/img/retur/' . $d['foto_retur']) ?>" alt="img retur">
              </div>
            </div>
          </div>
        <?php } ?>
        <hr>
        <table id="example1" class="table table-bordered table-striped">
          <tr>
            <td colspan="6">
              <button id="btn-tampil" class="btn btn-link btn-block mb-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-plus"></i> Tambah Artikel
              </button>
              <div class="collapse" id="collapseExample">
                <form method="POST" action="<?= base_url('spg/Retur/tambah_cart'); ?>" enctype="multipart/form-data">
                  <div class="form-group">
                    <select name="id" class="form-control select2bs4" id="id_produk" required>
                      <option value="">Pilih Artikel</option>
                      <?php foreach ($list_produk as $l) { ?>
                        <option value="<?= $l->id_produk ?>"><?= $l->kode ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <?php  ?>
                  <div class="form-group" id="show_data">
                    <label> Stok :</label>
                    <input type="text" class="form-control form-control-sm" name="stok" id="stok" readonly>
                  </div>
                  <div class="form-group">
                    <label> Jumlah :</label>
                    <input class="form-control form-control-sm" type="number" min="0" name="qty" required="" placeholder="Jumlah" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label> Foto Artikel :</label>
                    <input type="file" name="foto_retur" class="form-control form-control-sm" id="foto_retur" accept="image/png, image/jpeg, image/jpg" required>
                    <small class="text-danger">* Format : JPG,PNG,JPEG & Max Size foto 2 mb</small>
                  </div>
                  <div class="form-group">
                    <select name="keterangan" class="form-control form-control-sm" required>
                      <option value="">- Pilih Keterangan -</option>
                      <option value="kehilangan">kehilangan <span>(Isi tidak lengkap)</span></option>
                      <option value="cacat">Produk Cacat</option>
                      <option value="lain">Lainnya..</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <textarea name="catatan" class="form-control form-control-sm" placeholder="Tambahkan catatan jika ada.."></textarea>
                    <small>*opsional</small>
                  </div>
                  <div class="form-group text-center">
                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-cart-plus"></i> Tambah Keranjang</button>
                  </div>
                </form>
              </div>
            </td>
          </tr>
        </table>
        <?php if (count($data_cart) > 0) { ?>
          <form action="<?= base_url('spg/Retur/kirim_retur') ?>" enctype="multipart/form-data" method="post" id="form_retur">
            <div class="form-group">
              <label>Tanggal Penjemputan :</label>
              <input type="date" name="tgl_jemput" id="tgl_jemput" class="form-control form-control-sm" min="<?= date('Y-m-d', strtotime('2 days')) ?>" required>
            </div>
            <div class="form-group">
              <label> Lampiran :</label>
              <input class="form-control form-control-sm" name="lampiran" id="lampiran" type="file" accept="image/png, image/jpeg, image/jpg" required>
            </div>
            <div class="form-group">
              <label> Foto Packing :</label>
              <input class="form-control form-control-sm" name="foto_packing" id="packing" type="file" accept="image/png, image/jpeg, image/jpg" required>
            </div>
          </form>
          <hr>
          <a class="btn btn-success btn-sm float-right" id="btn-kirim" href="#">
            <li class="fa fa-paper-plane "></li> Ajukan Retur
          </a>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  $(document).ready(function() {
    $('#btn-tampil').click(function() {
      $('#btn-kirim').toggle();
    })
  });
</script>
<script>
  function validateForm() {
    let isValid = true;
    // Get all required input fields
    $('#form_retur').find('input[required], select[required], textarea[required]').each(function() {
      if ($(this).val() === '') {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    return isValid;
  }
  document.getElementById("btn-kirim").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the default behavior of the link

    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data Pengajuan Retur akan dikirim",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        if (validateForm()) {
          document.getElementById("form_retur").submit();
        } else {
          Swal.fire({
            title: 'Belum lengkap',
            text: "Lampiran,foto Packing & Tgl Jemput harus di isi",
            icon: 'info',
          });
        }

      }
    })
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#id_produk').on('change', function() {
      // menampilkan detail permintaan
      var id = $(this).val();
      const kirim = $('#id_produk option:selected').data('kirim');
      $.ajax({
        type: 'get',
        url: '<?php echo base_url() ?>spg/Retur/tampilkan_detail_produk/' + id,
        async: true,
        data: {
          id: id,
          id_kirim: kirim
        },
        dataType: 'json',
        success: function(data) {
          $('#stok').val(data.stok);
        }

      });
      // end detail permintaan

    });


    $('input[name="qty"]').on('keydown keyup change', function() {
      var input = $(this).val();
      var stok = $('input[name="stok"]').val();
      if (parseInt(input) > parseInt(stok)) {
        Swal.fire(
          'Peringatan !',
          'Pastikan jumlah yang di retur tidak melebihi jumlah Stok.',
          'info'
        )
        $(this).val(stok);
      }
    });

  });
</script>
<script>
  $(document).ready(function() {

    $('#table_retur').DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
    });


  })
</script>