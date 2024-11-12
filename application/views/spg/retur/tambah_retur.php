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

  #list_suggestions {
    max-height: 300px;
    overflow-y: auto;
    display: none;
  }

  .list-group-item {
    cursor: pointer;
    padding: 5px;
  }

  .list-group-item:hover {
    background-color: #17a2b8;
    color: #f2f2f2;
  }

  .list-group-item strong {
    display: block;
  }

  .list-group-item small {
    display: block;
  }

  .kartu {
    position: relative;
    width: 92%;
    height: 100%;
    min-height: 50px;
    background-color: #0069d9;
    border-radius: 5px;
    padding: 5px 20px 10px 20px;
    color: #f4f6f9;
    margin-top: 5px;
    margin-bottom: 5px;
  }

  .kartu strong {
    display: block;
  }

  .kartu small {
    display: block;
  }

  .kartu #btn-close {
    position: absolute;
    top: 5px;
    right: 10px;
    font-size: 16px;
    color: #f4f6f9;
    cursor: pointer;
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
        $total_jumlah = 0; // Variabel untuk menyimpan total jumlah
        foreach ($this->cart->contents() as $d) {
          $no++;
          $total_jumlah += $d['qty']; // Tambahkan jumlah item ke total
        ?>
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

        <!-- Menampilkan Total Jumlah di luar loop -->
        <div class="total-jumlah">
          <strong>Total : <?= $total_jumlah ?></strong>
        </div>

        <hr>
        <table class="table table-bordered table-striped">
          <tr>
            <td colspan="6">
              <button id="btn-tampil" class="btn btn-link btn-block mb-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-plus"></i> Tambah Artikel
              </button>
              <div class="collapse" id="collapseExample">
                <form method="POST" action="<?= base_url('spg/Retur/tambah_cart'); ?>" enctype="multipart/form-data" id="form_cart">
                  <div class="form-group">
                    <div style="display: flex; align-items: center; position: relative; width: 100%;">
                      <input type="search" class="form-control form-control-sm" id="txt_cari" placeholder="Cari berdasarkan kode atau artikel.." autocomplete="off" style="flex: 1;">
                      <i class="fas fa-search" style="padding-left: 10px;"></i>
                    </div>
                    <div id="list_suggestions" style="border: 1px solid #17a2b8; width: 92%; background-color: white; z-index: 1000; display: none;">
                    </div>
                    <div id="detail_produk" style="display: none;">
                      <div class="kartu">
                        <i class="fas fa-times" id="btn-close"></i>
                        <small>Terpilih</small>
                        <strong id="kode"></strong>
                        <small id="artikel"></small>
                        <input type="hidden" name="id_produk" id="id_produk">
                        <strong>
                          Stok : <span id="stok"></span> <span id="satuan"></span>
                        </strong>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <p class="mb-0">Jumlah : *</p>
                    <input class="form-control form-control-sm" type="number" min="0" name="qty" id="qty" required="" placeholder="Jumlah" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <p class="mb-0">Foto Artikel : *</p>
                    <input type="file" name="foto_retur" class="form-control form-control-sm" id="foto_retur" accept="image/png, image/jpeg, image/jpg" required>
                    <small class="text-danger">* Format : JPG,PNG,JPEG & Max Size foto 2 mb</small>
                  </div>
                  <div class="form-group">
                    <p class="mb-0">Keterangan : *</p>
                    <select name="keterangan" class="form-control form-control-sm" required>
                      <option value="">- Pilih Keterangan -</option>
                      <option value="kehilangan">kehilangan (Isi tidak lengkap)</option>
                      <option value="cacat">Produk Cacat</option>
                      <option value="lain">Lainnya..</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <textarea name="catatan" class="form-control form-control-sm" placeholder="Tambahkan catatan jika ada.."></textarea>
                    <small>*opsional</small>
                  </div>
                  <div class="form-group text-center">
                    <button type="submit" class="btn btn-success btn-sm" id="btn-tambah"><i class="fa fa-plus"></i> Tambah ke lIst</button>
                  </div>
                </form>
              </div>
            </td>
          </tr>
        </table>
        <?php if (count($data_cart) > 0) { ?>
          <form action="<?= base_url('spg/Retur/kirim_retur') ?>" enctype="multipart/form-data" method="post" id="form_retur">
            <div class="form-group">
              <label>Tanggal Penjemputan :*</label>
              <input type="date" name="tgl_jemput" id="tgl_jemput" class="form-control form-control-sm" min="<?= date('Y-m-d', strtotime('2 days')) ?>" required>
            </div>
            <div class="form-group">
              <label> Lampiran :*</label>
              <input class="form-control form-control-sm" name="lampiran" id="lampiran" type="file" accept="image/png, image/jpeg, image/jpg" required>
            </div>
            <div class="form-group">
              <label> Foto Packing :*</label>
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
<script>
  $(document).ready(function() {
    $('#btn-tampil').click(function() {
      $('#btn-kirim').toggle();
    })
    const btnClose = document.getElementById('btn-close');
    const qtyInput = document.getElementById('qty');
    const kode = document.getElementById('kode');
    const detailProduk = document.getElementById('detail_produk');
    btnClose.addEventListener('click', function() {
      detailProduk.style.display = 'none';
      kode.textContent = '';
      qtyInput.value = '';
    });
    $('#txt_cari').on('keyup', function() {
      var query = $(this).val();
      if (query !== '') {
        $.ajax({
          url: '<?= base_url("spg/Penjualan/cari") ?>',
          method: 'POST',
          data: {
            query: query
          },
          success: function(data) {
            $('#list_suggestions').html(data);
            $('#list_suggestions').css('display', 'block');
          }
        });
      } else {
        $('#list_suggestions').css('display', 'none');
      }
    });

    function validateForm() {
      let isValid = true;
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

    function validateCart() {
      let isValid = true;
      $('#form_cart').find('input[required], select[required], textarea[required]').each(function() {
        if ($(this).val() === '') {
          isValid = false;
          $(this).addClass('is-invalid');
        } else {
          $(this).removeClass('is-invalid');
        }
      });
      return isValid;
    }
    $('#btn-tambah').on('click', function() {
      event.preventDefault();
      if (artikel.textContent === '') {
        Swal.fire(
          'Belum lengkap',
          'Artikel tidak boleh kosong!',
          'info'
        );
        return;
      }
      if (validateCart()) {
        document.getElementById("form_cart").submit();
      } else {
        Swal.fire({
          title: 'Belum lengkap',
          text: "Jumlah,foto Artikel & keterangan harus di isi",
          icon: 'info',
        });
      }
    });
    $('#btn-kirim').on('click', function() {
      event.preventDefault();
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
  });
  $(document).on('click', 'li', function() {
    var kode = $(this).data('kode');
    $.ajax({
      url: '<?= base_url("spg/Penjualan/pilih_list") ?>',
      method: 'POST',
      data: {
        kode: kode
      },
      success: function(response) {
        var data = JSON.parse(response);
        if (data.success) {
          $('#id_produk').val(data.id_produk);
          $('#kode').text(data.kode);
          $('#artikel').text(data.nama_produk);
          $('#stok').text(data.stok);
          $('#satuan').text(data.satuan);
          $('#detail_produk').css('display', 'block');
        } else {
          $('#detail_produk').css('display', 'none');
          alert('Produk tidak ditemukan.');
        }
        $('#list_suggestions').css('display', 'none');
        $('#txt_cari').val('');
      }
    });
  });
</script>