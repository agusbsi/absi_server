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

  .produk {
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    margin-bottom: 10px;
  }

  .produk-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px 15px;
    background-color: rgb(1, 164, 19, 0.2);
    border-bottom: 2px solid #ddd;
  }

  .produk-number {
    width: 22px;
    height: 22px;
    background-color: #f4f5f6;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: bold;
  }

  .produk-code {
    font-size: 14px;
    flex-grow: 1;
    font-weight: 600;
    margin-left: 10px;
  }

  .produk-close {
    font-weight: bold;
    cursor: pointer;
  }

  .produk-content {
    background-color: rgb(241, 243, 244, 0.8);
    color: #333;
    padding: 5px 15px;
  }

  .produk-content p {
    margin: 0 0 2px 0;
    font-size: 12px;
  }

  .produk-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .produk-info span {
    font-weight: bold;
    font-size: 12px;
  }

  .produk-info input {
    width: 100px;
    padding: 2px;
    border-radius: 15px;
    border: 1px solid rgb(1, 164, 19);
    text-align: center;
    font-size: 12px;
  }

  .total-qty {
    text-align: end;
    padding: 10px;
    padding-right: 55px;
    font-size: 12px;
    font-weight: 700;
    background-color: rgb(1, 164, 19, 0.2);
    border-radius: 10px;
  }
</style>

<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <form action="<?= base_url('spg/Penjualan/simpan') ?>" method="post" id="form_jual">
        <div class="card-header">
          <small>
            <strong><?= $toko->nama_toko ?></strong>
          </small>
          <div class="card-tools">
            <a href="<?= base_url('spg/Penjualan') ?>" type="button" class="btn btn-tool">
              <i class="fas fa-times"></i>
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <small><strong>Tanggal Penjualan : *</strong></small>
            <input type="hidden" name="unique_id" value="<?= uniqid() ?>">
            <input id="tanggal_penjualan" name="tgl_jual" class="form-control form-control-sm" type="date" max="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d', strtotime('-100 days')) ?>" required>
          </div>
          <hr>
          <div class="item-list" id="item-list">
          </div>
          <div class="total-qty" id="total-qty">
            Total Qty: 0
          </div>
          <br>
          <table class="table table-bordered table-striped">
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
                    <input class="form-control form-control-sm" type="number" id="qty" placeholder="Jumlah terjual..." autocomplete="off" required>
                  </div>
                  <div class="form-group text-center">
                    <button type="button" id="btn-tambah" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah List</button>
                  </div>
                </div>
              </td>
            </tr>
          </table>
        </div>
        <div class="card-footer text-center">
          <a href="<?= base_url('spg/Penjualan') ?>" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Close</a>
          <button type="submit" id="btn_simpan" class="btn btn-sm btn-primary"><i class="fas fa-paper-plane"></i> Kirim</button>
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
    $('#form_jual').find('#tanggal_penjualan, .qtyProduk').each(function() {
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
            text: 'Tanggal Penjualan,List Artikel dan qty Produk tidak boleh kosong.',
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
      const itemList = document.getElementById('item-list');
      const totalQtyElement = document.getElementById('total-qty');

      itemList.innerHTML = '';
      let totalQty = 0;
      const items = JSON.parse(localStorage.getItem('items')) || [];

      items.forEach((item, index) => {
        const produk = document.createElement('div');
        produk.className = 'produk';
        produk.innerHTML = `
        <div class="produk-header">
            <div class="produk-number">${index + 1}</div>
            <div class="produk-code">${item.kode}</div>
            <div class="produk-close" onclick="deleteItem(${item.id})">X</div>
        </div>
        <div class="produk-content">
            <p>${item.artikel}</p>
            <div class="produk-info">
                <span>Stok: ${item.stok} </span>
                <div>
                    <span>Qty: </span>
                    <input type="number" class="qtyProduk" name="qtyProduk[]" value="${item.qty}" data-index="${index}" data-stok="${item.stok}" required>
                </div>
            </div>
            <input type="hidden" name="idProduk[]" value="${item.id_produk}">
            <input type="hidden" name="stokProduk[]" value="${item.stok}">
        </div>
    `;
        itemList.appendChild(produk);

        // Tambahkan qty dari item ini ke total qty
        totalQty += parseInt(item.qty, 10);

        const qtyInput = produk.querySelector('.qtyProduk');

        // Mengupdate qty total saat pengguna mengetik
        qtyInput.addEventListener('input', function() {
          const stok = parseInt(this.getAttribute('data-stok'), 10);
          const itemIndex = parseInt(this.getAttribute('data-index'), 10);
          let qtyValue = parseInt(this.value, 10);

          if (isNaN(qtyValue) || qtyValue < 0) {
            qtyValue = 0;
          }

          this.value = qtyValue;

          // Update qty in items array
          items[itemIndex].qty = qtyValue;

          // Perbarui total qty
          updateTotalQty(); // Memperbarui total qty tanpa reload
        });

        // Menyimpan qty ke localStorage setelah pengguna selesai mengetik
        qtyInput.addEventListener('blur', function() {
          // Simpan perubahan qty ke localStorage
          localStorage.setItem('items', JSON.stringify(items));

          // Reload items untuk memastikan data disimpan dengan benar
          loadItems();
        });

        // Fungsi untuk mengupdate total qty
        function updateTotalQty() {
          const totalQty = items.reduce((total, item) => total + parseInt(item.qty, 10), 0);
          document.getElementById('total-qty').textContent = `Total Qty: ${totalQty}`;
        }

      });

      // Update total qty element
      totalQtyElement.textContent = `Total : ${totalQty}`;
    }

    // document.getElementById('qty').addEventListener('input', function() {
    //   const qtyInput = this;
    //   const stok = parseInt(document.getElementById('stok').innerText, 10);
    //   if (qtyInput.value > stok) {
    //     qtyInput.value = stok; // Set value to stok if it exceeds
    //     Swal.fire(
    //       'Peringatan !',
    //       'QTY Tidak boleh melebihi Stok.',
    //       'info'
    //     );
    //   }
    // });
    btnTambah.addEventListener('click', function() {
      if (artikel.textContent === '' || qtyInput.value === '') {
        Swal.fire(
          'Peringatan !',
          'Artikel dan Qty tidak boleh kosong!',
          'info'
        );
        return;
      }

      let items = JSON.parse(localStorage.getItem('items')) || [];

      // Cek jika artikel sudah ada
      const existingItemIndex = items.findIndex(item => item.kode === kode.textContent);

      if (existingItemIndex !== -1) {
        // Jika artikel ditemukan, tambahkan qty-nya
        items[existingItemIndex].qty = parseInt(items[existingItemIndex].qty) + parseInt(qtyInput.value);
        Swal.fire(
          'info',
          'Artikel sudah ada di List, Otomatis jumlah di tambahkan.',
          'info'
        );
      } else {
        const id = new Date().getTime(); // Unique ID based on timestamp
        const item = {
          id: id,
          id_produk: id_produk.value,
          kode: kode.textContent,
          artikel: artikel.textContent,
          stok: stok.textContent,
          qty: parseInt(qtyInput.value)
        };

        items.push(item);
      }
      localStorage.setItem('items', JSON.stringify(items));
      const totalQty = items.reduce((total, item) => total + parseInt(item.qty), 0);
      loadItems();
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
      loadItems();
    };
    loadItems();
  });
</script>