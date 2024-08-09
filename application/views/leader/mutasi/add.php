<section class="content">
  <div class="container-fluid">
    <form action="<?= base_url('leader/Mutasi/proses_add') ?>" method="POST" id="form_mutasi">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title"><i class="nav-icon fas fa-copy"></i> Buat Mutasi</h3>
          <div class="card-tools">
            <a href="<?= base_url('leader/Mutasi') ?>" type="button" class="btn btn-tool">
              <i class="fas fa-times"></i>
            </a>
          </div>
        </div>
        <div class="card-body">
          <!-- Master -->
          <div class="card card-default">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Toko Asal :</label>
                    <select class="form-control form-control-sm select2bs4" id="toko_asal" name="toko_asal" required>
                      <option selected="selected" value="">- Pilih -</option>
                      <?php foreach ($list_toko as $l) { ?>
                        <option value="<?= $l->id ?>"><?= $l->nama_toko ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Toko tujuan :</label>
                    <select class="form-control form-control-sm select2bs4" id="toko_tujuan" name="toko_tujuan" required disabled>
                      <option selected="selected" value="">- Pilih -</option>
                      <?php foreach ($toko_tujuan as $l) { ?>
                        <option value="<?= $l->id ?>"><?= $l->nama_toko ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end master -->
          <div class="card card-default">
            <div class="card-body">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label>Pilih Artikel</label>
                    <select name="id_produk" class="form-control form-control-sm select2" id="id_produk" disabled>
                    </select>
                  </div>
                </div>
                <div class="col-md-2 text-center">
                  <label>Satuan</label>
                  <input type="text" name="satuan" value="" readonly class="form-control form-control-sm">
                  <input type="hidden" name="kode" value="" readonly class="form-control form-control-sm">
                  <input type="hidden" name="produk" value="" readonly class="form-control form-control-sm">
                </div>
                <div class="col-md-2 text-center">
                  <label>Stok</label>
                  <input type="text" name="stok" value="" readonly class="form-control form-control-sm">
                </div>
                <div class="col-md-2 text-center">
                  <label>Qty</label>
                  <input type="number" name="qty" value="" readonly class="form-control form-control-sm" min="0">
                </div>
                <div class="col-md-1">
                  <label for="">&nbsp;</label>
                  <button disabled type="button" class="btn btn-sm btn-success btn-block" id="tambah"><i class="fa fa-plus"></i></button>
                </div>
              </div>
              <h3 class="card-title ml-3"><i class="fas fa-cube"></i> List Artikel</h3>
              <hr>
              <div class="keranjang table-responsive">
                <table class="table table-bordered table-striped" id="keranjang">
                  <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Artikel</th>
                      <th>Satuan</th>
                      <th>Jumlah</th>
                      <th>Menu</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
              <hr>
              <div class="form-group">
                <label for="">Catatan : *</label>
                <textarea name="catatan" class="form-control form-control-sm" required></textarea>
                <small>* Harus di isi.</small>
              </div>
            </div>
            <div class="card-footer text-center">
              <button type="submit" class="btn btn-sm btn-primary" id="btn_simpan"><i class="fa fa-paper-plane"></i>&nbsp;&nbsp;Ajukan Mutasi</button>
            </div>
          </div>
        </div>
    </form>
  </div>
</section>
<script>
  $(document).on('click', '#tambah', function(e) {
    var idProduk = document.querySelector('[name="id_produk"]').value;
    var satuan = document.querySelector('[name="satuan"]').value;
    var kode = document.querySelector('[name="kode"]').value;
    var produk = document.querySelector('[name="produk"]').value;
    var stok = document.querySelector('[name="stok"]').value;
    var qty = document.querySelector('[name="qty"]').value;
    var storedData = JSON.parse(localStorage.getItem('dataProduk')) || [];
    var isRoleExist = storedData.some(function(data) {
      return data.idProduk === idProduk;
    });
    if (isRoleExist) {
      Swal.fire(
        'Peringatan !',
        'Artikel sudah masuk list keranjang, pilih artikel yang lain.',
        'info'
      );
      return;
    }
    var data = {
      idProduk: idProduk,
      satuan: satuan,
      kode: kode,
      produk: produk,
      stok: stok,
      qty: qty
    };

    if (qty <= 0) {
      Swal.fire(
        'Peringatan!',
        'Jumlah tidak boleh 0',
        'info'
      );
    } else {
      let storedData = JSON.parse(localStorage.getItem('dataProduk')) || [];
      if (!Array.isArray(storedData)) {
        storedData = [];
      }
      storedData.push(data);
      localStorage.setItem('dataProduk', JSON.stringify(storedData));
      loadDataFromLocalStorage();
      reset();
    }
  });

  function loadDataFromLocalStorage() {
    let storedData = JSON.parse(localStorage.getItem('dataProduk')) || [];
    let listPersonilTable = document.getElementById('keranjang').querySelector('tbody');
    listPersonilTable.innerHTML = '';
    storedData.forEach(function(data, index) {
      let row = document.createElement('tr');
      row.innerHTML = `
      <td class='text-center'>${index + 1}</td>
      <td>
        ${data.kode} <br>
        <small><small>${data.produk}</small></small>
        <input type='hidden' name='id_produk[]' value='${data.idProduk}'>
        <input type='hidden' name='qty[]' value='${data.qty}'>
      </td>
      <td class='text-center'>${data.satuan}</td>
      <td class='text-center'>${data.qty}</td>         
      <td class='text-center'><button type='button' class='btn btn-danger btn-sm btn_hapus'><i class='fas fa-trash'></i></button></td>
    `;
      listPersonilTable.appendChild(row);
    });

    // Tambahkan event listener untuk tombol "Hapus"
    listPersonilTable.addEventListener('click', function(e) {
      let btnHapus = e.target.closest('.btn_hapus');
      if (btnHapus) {
        let row = btnHapus.closest('tr');
        let idProduk = row.querySelector('input[name="id_produk[]"]').value;
        let storedData = JSON.parse(localStorage.getItem('dataProduk')) || [];
        if (!Array.isArray(storedData)) {
          storedData = [];
        }
        storedData = storedData.filter(function(data) {
          return data.idProduk !== idProduk;
        });
        localStorage.setItem('dataProduk', JSON.stringify(storedData));
        loadDataFromLocalStorage();
      }
    });
  }
  // funsi reset
  function reset() {
    $('#id_produk').val('');
    $('input[name="produk"]').val('')
    $('input[name="satuan"]').val('')
    $('input[name="stok"]').val('')
    $('input[name="qty"]').val('')
    $('input[name="qty"]').prop('readonly', true)
    $('button#tambah').prop('disabled', true)
  }
  document.addEventListener('DOMContentLoaded', function() {
    loadDataFromLocalStorage();
  });

  function validateForm() {
    let isValid = true;
    let list_artikel = document.getElementById('keranjang').querySelector('tbody');
    $('#form_mutasi').find('select[required],textarea[required]').each(function() {
      if ($(this).val() === '' || list_artikel.innerHTML === '') {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    return isValid;
  }
  $('#btn_simpan').click(function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data Mutasi akan di ajukan.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {

        if (validateForm()) {
          document.getElementById("form_mutasi").submit();
          localStorage.removeItem('dataProduk');
        } else {
          Swal.fire({
            icon: 'info',
            title: 'Peringatan !',
            text: 'Toko asal, Tujuan dan List artikel tidak boleh kosong.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        }
      }
    })
  })
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('tfoot').hide()
    // pilih kota asal
    $('#toko_asal').on('change', function() {
      reset()
      if ($(this).val() != "") {
        document.getElementById("toko_tujuan").disabled = false;
        document.getElementById("id_produk").disabled = false;
        // list produk
        var url = "<?php echo base_url('leader/Mutasi/list_produk'); ?>/" + $(this).val();
        $('#id_produk').load(url);
        return false;
      } else {
        document.getElementById("toko_tujuan").disabled = true;
        document.getElementById("id_produk").disabled = true;
      }
      if ($(this).val() == $('#toko_tujuan').val()) {
        Swal.fire({
          title: 'Peringatan',
          text: "Toko asal & tujuan tidak boleh sama !",
          type: 'info',
          icon: "info",
        })
        $(this).val("");
      }
    });
    // pilih kota tujuan
    $('#toko_tujuan').on('change', function() {

      if ($(this).val() == $('#toko_asal').val()) {
        Swal.fire({
          title: 'Peringatan',
          text: "Toko asal & tujuan tidak boleh sama !",
          type: 'info',
          icon: "info",
        })
        $(this).val("");
      }
    });
    // ketika plih produk
    $('#id_produk').on('change', function() {
      if ($('#toko_tujuan').val() == '') {
        Swal.fire({
          title: 'Peringatan',
          text: "Pilih Toko Tujuan terlebih dahulu !",
          type: 'info',
          icon: "info",
        })
        reset()
      }
      if ($(this).val() == '') {
        reset()
      } else {
        // menampilkan detail permintaan
        var id = $(this).val();
        var id_toko = $('select[name="toko_asal"]').val();
        $.ajax({
          type: 'get',
          url: '<?php echo base_url() ?>leader/Mutasi/tampilkan_detail_produk/' + id,
          async: true,
          data: {
            id: id,
            id_toko: id_toko
          },
          dataType: 'json',
          success: function(data) {
            $('input[name="kode"]').val(data.kode);
            $('input[name="produk"]').val(data.nama_produk);
            $('input[name="stok"]').val(data.qty);
            $('input[name="satuan"]').val(data.satuan);
            $('input[name="qty"]').prop('readonly', false)
            $('button#tambah').prop('disabled', false)
          }

        });
        // end detail permintaan

      }

    });
    // jumlah di isi
    $('input[name="qty"]').on('keydown keyup change', function() {
      var input = $(this).val();
      var stok = $('input[name="stok"]').val();
      if (parseInt(input) > parseInt(stok)) {
        Swal.fire(
          'Peringatan !',
          'Pastikan jumlah yang di Transfer tidak melebihi jumlah stok yang tersedia.',
          'info'
        )
        $(this).val(stok);
      }

    });
  });
</script>