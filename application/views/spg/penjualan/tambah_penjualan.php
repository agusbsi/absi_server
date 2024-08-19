<style>
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

  #list_suggestions {
    max-height: 300px;
    /* Atur tinggi maksimal sesuai keinginan */
    overflow-y: auto;
    display: none;
    /* Ini untuk menyembunyikan elemen ketika tidak ada hasil pencarian */
  }
</style>

<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <form action="<?= base_url('spg/Penjualan/simpan') ?>" method="post" id="form_jual">
        <div class="card-header">
          <h3 class="card-title"><i class="nav-icon fas fa-cart-plus"></i> Tambah Penjualan</h3>
          <div class="card-tools">
            <a href="<?= base_url('spg/Penjualan') ?>" type="button" class="btn btn-tool">
              <i class="fas fa-times"></i>
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <strong>Nama Toko :</strong>
            <textarea class="form-control form-control-sm" readonly><?= $toko->nama_toko ?></textarea>
          </div>
          <div class="form-group">
            <strong>Tanggal Penjualan : *</strong>
            <input type="hidden" name="unique_id" value="<?= uniqid() ?>">
            <input id="tanggal_penjualan" name="tgl_jual" class="form-control form-control-sm" type="date" max="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d', strtotime('-100 days')) ?>" required>
          </div>
          <hr>
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Artikel</th>
                <th>Qty</th>
                <th>Menu</th>
              </tr>
            </thead>
            <tbody id="item-list"></tbody>
            <tr>
              <td colspan="4">
                <button id="btn-tampil" class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                  <i class="fa fa-plus"></i>Tambah Item
                </button>
                <div class="collapse" id="collapseExample">
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
                      <input type="hidden" id="id_produk">
                      <strong>
                        Stok : <span id="stok"></span> <span id="satuan"></span>
                      </strong>
                    </div>
                  </div>
                  <div class="form-group mt-1" style="width: 92%;">
                    <input class="form-control form-control-sm" type="number" id="qty" placeholder="Jumlah terjual..." required>
                  </div>
                  <div class="form-group text-center">
                    <button type="button" id="btn-tambah" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambahkan ke List</button>
                  </div>
                </div>
              </td>
            </tr>
          </table>
        </div>
        <div class="card-footer text-right">
          <a href="<?= base_url('spg/Penjualan') ?>" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Close</a>
          <button type="submit" id="btn_simpan" class="btn btn-sm btn-primary"><i class="fas fa-paper-plane"></i> Kirim Data</button>
        </div>
      </form>
    </div>

  </div>
</section>


<script>
  function validateForm() {
    let isValid = true;
    if (!localStorage.getItem('items')) {
      isValid = false;
    }
    // Get all required input fields
    $('#form_jual').find('#tanggal_penjualan').each(function() {
      if ($(this).val() === '') {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    return isValid;
  }
  $('#btn_simpan').click(function(e) {
    var tanggal = $("#tanggal_penjualan").val();
    e.preventDefault();
    Swal.fire({
      title: 'Data Penjualan di </br>' + tanggal,
      text: "Apakah anda yakin menyimpanya ?",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        if (validateForm()) {
          document.getElementById("form_jual").submit();
          localStorage.removeItem('items');
        } else {
          Swal.fire({
            icon: 'info',
            title: 'Belum Lengkap',
            text: 'Tanggal Penjualan dan List Artikel tidak boleh kosong.',
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
            $('#detail_produk').html('<p>Detail produk tidak ditemukan.</p>');
          }
          $('#list_suggestions').css('display', 'none');
          $('#txt_cari').val('');
        }
      });
    });

  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const btnClose = document.getElementById('btn-close');
    const btnTambah = document.getElementById('btn-tambah');
    const id_produk = document.getElementById('id_produk');
    const kode = document.getElementById('kode');
    const artikel = document.getElementById('artikel');
    const stok = document.getElementById('stok');
    const qtyInput = document.getElementById('qty');
    const itemList = document.getElementById('item-list');
    const txtCari = document.getElementById('txt_cari');
    const detailProduk = document.getElementById('detail_produk');
    btnClose.addEventListener('click', function() {
      detailProduk.style.display = 'none';
      kode.textContent = '';
      qtyInput.value = '';
    });

    function loadItems() {
      itemList.innerHTML = ''; // Clear existing items
      const items = JSON.parse(localStorage.getItem('items')) || [];
      items.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>
                        <input type="hidden" name="id_produk[]" value="${item.id_produk}">
                        <input type="hidden" name="stok[]" value="${item.stok}">
                        <small><strong>${item.kode}</strong><br>${item.artikel}
                        </td>
                        <td>
                        ${item.qty}
                        <input type="hidden" name="qty[]" value="${item.qty}">
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteItem(${item.id})"><i class="fas fa-trash"></i></button></td>
                    `;
        itemList.appendChild(row);
      });
    }

    btnTambah.addEventListener('click', function() {
      if (artikel.textContent === '' || qtyInput.value === '') {
        Swal.fire(
          'Peringatan !',
          'Artikel dan Qty tidak boleh kosong!',
          'info'
        );
        return;
      }
      if (parseInt(stok.textContent) < qtyInput.value) {
        Swal.fire(
          'Peringatan !',
          'QTY Tidak boleh melebihi Stok.',
          'info'
        );
        return;
      }

      let items = JSON.parse(localStorage.getItem('items')) || [];

      // Cek jika artikel sudah ada
      const isDuplicate = items.some(item => item.kode === kode.textContent);
      if (isDuplicate) {
        Swal.fire(
          'Peringatan !',
          'Artikel sudah ada di List, Pilih artikel lain !',
          'info'
        );
        return;
      }

      const id = new Date().getTime(); // Unique ID based on timestamp
      const item = {
        id: id,
        id_produk: id_produk.value,
        kode: kode.textContent,
        artikel: artikel.textContent,
        stok: stok.textContent,
        qty: qtyInput.value
      };

      items.push(item);
      localStorage.setItem('items', JSON.stringify(items));

      loadItems(); // Refresh item list

      // Reset fields
      txtCari.value = '';
      artikel.textContent = '';
      kode.textContent = '';
      stok.textContent = '';
      qtyInput.value = '';
      detailProduk.style.display = 'none';
    });

    window.deleteItem = function(id) {
      let items = JSON.parse(localStorage.getItem('items')) || [];
      items = items.filter(item => item.id !== id);
      localStorage.setItem('items', JSON.stringify(items));

      loadItems(); // Refresh item list
    };

    loadItems(); // Initial load
  });
</script>