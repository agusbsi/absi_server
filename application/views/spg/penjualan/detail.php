<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="nav-icon fas fa-cart-plus"></i> Detail</h3>
        <div class="card-tools">
          <a href="<?= base_url('spg/Penjualan') ?>" type="button" class="btn btn-tool">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-3">
            <strong>Nomor :</strong> <br> <?= $jual->id ?>
          </div>
          <div class="col-6 col-sm-4">
            <strong>Tgl Penjualan :</strong> <br> <?= date('d F Y', strtotime($jual->tanggal_penjualan)) ?>
          </div>
          <div class="col-6 col-sm-4">
            <strong>Tgl Dibuat :</strong> <br> <?= date('d F Y', strtotime($jual->created_at)) ?>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <input type="search" class="form-control form-control-sm " id="searchInput" autocomplete="off" placeholder="Cari berdasarkan kode atau nama artikel...">
        </div>
        <table id="myTable" class="table table-bordered table-striped">
          <tr>
            <th class="text-center">No</th>
            <th>Artikel</th>
            <th class="text-center">Qty</th>
          </tr>
          <?php
          $no = 0;
          $total = 0;
          foreach ($detail as $d) {
            $no++; ?>
            <tr>
              <td class="text-center"><?= $no ?></td>
              <td>
                <small>
                  <strong><?= $d->kode ?></strong> <br>
                  <?= $d->nama_produk ?>
                </small>
              </td>
              <td class="text-center"><?= $d->qty ?></td>
            </tr>
          <?php
            $total += $d->qty;
          }
          ?>
          <tr>
            <td colspan="2" class="text-right">Total :</td>
            <td class="text-center"><?= $total ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</section>
<script>
  // Fungsi untuk melakukan pencarian
  function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td");
      for (var j = 0; j < td.length; j++) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break; // keluar dari loop jika sudah ada satu td yang cocok
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
  document.getElementById("searchInput").addEventListener("input", searchTable);
</script>