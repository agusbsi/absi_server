<?php
if (!empty($jual->total) && !empty($toko_new->stok_akhir)) {
  $rasio = round($toko_new->stok_akhir / $jual->total, 2);
} else {
  $rasio = round($toko_new->stok_akhir / 1, 2);
}

$ssr = $toko_new->ssr;
$maks_po = ROUND($max_po->total * $toko_new->max_po / 100);
$sisa_po = $maks_po - $po->total;
?>
<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="nav-icon fas fa-file"></i> Form PO Artikel</h3>
        <div class="card-tools">
          <a href="<?= base_url('spg/Permintaan') ?>" type="button" class="btn btn-tool">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col">
            <small><b>Toko</b></small><br>
            <small><b>Batas PO</b></small><br>
            <small><b>Stok Rasio</b></small><br>
            <?php if ($toko_new->status_ssr == 1) { ?>
              <small><b>Max kuota PO Bulan ini</b></small><br>
              <small><b>Sisa kuota</b></small><br>
            <?php } ?>
          </div>
          <div class="col">
            : <small><?= $toko_new->nama_toko ? $toko_new->nama_toko : '' ?></small><br>
            : <small><?= $toko_new->status_ssr == 1 ? '<span class="badge badge-success">AKTIF</span>' : '<span class="badge badge-danger">NON-AKTIF</span>' ?></small> <br>
            : <small><?= $rasio ?> <?= $rasio > $ssr ? '<span class="text-danger"> - Stok Tinggi -</span>' : '<span class="text-success"> - Stok Normal -</span>' ?> </small><br>
            <?php if ($toko_new->status_ssr == 1) { ?>
              : <small><?= ($rasio > $ssr) ? $maks_po . ' Pcs ( Semua Artikel )' : '-' ?></small><br>
              : <small><?= ($rasio > $ssr) ? $sisa_po . ' Pcs' : '-' ?></small><br>
            <?php } ?>
            <input type="hidden" id="toko" value="<?= $toko_new->id ?>">
            <input type="hidden" id="status_toko" value="<?= $toko_new->status_ssr ?>">
            <input type="hidden" id="sisa_po" value="<?= $sisa_po ?>">
            <input type="hidden" id="ssr" value="<?= $ssr ?>">
            <input type="hidden" id="rasio" value="<?= $rasio ?>">
          </div>
        </div>
        <hr>
        <i class="nav-icon fas fa-cart-plus"></i> Keranjang Artikel
        <hr>
        <table class="table table-bordered table-striped">
          <tr class="text-center">
            <th>Artikel</th>
            <th>Qty</th>
            <th>Menu</th>
          </tr>
          <?php
          $total = 0;
          foreach ($data_cart as $d) { ?>
            <tr>
              <td>
                <small>
                  <strong><?= $d['options'] ?></strong> <br>
                  Ket : <?= $d['satuan'] ?>
                </small>
              </td>
              <td class="text-center"><?= $d['qty'] ?></td>
              <td class="text-center"><a href="<?= base_url('spg/permintaan/hapus_cart/') . $d['rowid'] ?>"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a></td>
            </tr>
          <?php
            $total += $d['qty'];
          } ?>
          <tr>
            <td class="text-right">Total :</td>
            <td class="text-center total"><strong><?= $total ?></strong></td>
            <td></td>
          </tr>
          <tr>
            <td colspan="4" class="text-center">
              <button id="btn-tampil" class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-plus"></i>Tambah Artikel
              </button>
              <div class="collapse text-left" id="collapseExample">
                <form method="POST" action="<?= base_url('spg/Permintaan/tambah_cart'); ?>">
                  <div class="form-group">
                    <label>Pilih Artikel</label>
                    <select name="id" class="form-control form-control-sm select2" id="id_produk" style="width:300px">
                      <option value="">Pilih Artikel</option>
                      <?php foreach ($list_produk as $l) { ?>
                        <option value="<?= $l->id ?>">| <?= $l->kode ?> | <?= $l->artikel ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <?php  ?>
                  <div class="form-group">
                    <div class="card d-none" id="detail_produk">
                      <div class="card-header">
                        <h3 class="card-title">
                          <small id="nama_produk"></small>
                        </h3>
                      </div>
                      <div class="card-body pt-0">
                        <small>Stok : </small> <small id="stok_tersedia"></small> <br>
                        <small>Satuan :</small> <small id="satuan"></small>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Qty</label>
                    <input class="form-control form-control-sm" id="qty_po" type="number" min="0" name="qty" required>
                  </div>
                  <div class="form-group">
                    <label>Keterangan</label>
                    <textarea class="form-control form-control-sm" name="keterangan" placeholder="Tambahkan keterangan jika ada.."></textarea>
                    <small>*opsional</small>
                  </div>
                  <hr>
                  <div class="form-group text-right">
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambahkan</button>
                  </div>
                </form>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="5" class="text-center"><span class="kuota-terpenuhi text-danger" style="display:none;"> - Kuota PO Bulan ini terpenuhi -</span></td>
          </tr>
          <?php if (count($data_cart) > 0) { ?>
            <tr class="text-center">
              <td colspan="5" class="text-center"><a class="btn btn-sm btn-primary" id="btn-kirim" href="#"><i class="fa fa-paper-plane" aria-hidden="true"></i> Kirim </a></td>
            </tr>
          <?php } ?>

        </table>
      </div>
    </div>

  </div>
</section>

<script type="text/javascript">
  $(document).ready(function() {
    $('#btn-tampil').click(function() {
      $('#btn-kirim').toggle();
    });

    var status_toko = $('#status_toko').val();
    var ssr = parseFloat($('#ssr').val()); // Use parseFloat for potential decimal values
    var rasio = parseFloat($('#rasio').val()); // Use parseFloat for potential decimal values
    var sisa = $('#sisa_po').val();
    var total = $('.total strong').text();
    var sisaInt = parseInt(sisa);
    var totalInt = parseInt(total);

    // Check if the total equals sisa_po and other conditions
    if ((totalInt >= sisaInt) && (status_toko == 1) && (rasio > ssr)) {
      $("#btn-tampil").hide();
      $(".kuota-terpenuhi").show();
    } else {
      $("#btn-tampil").show();
      $(".kuota-terpenuhi").hide();
    }
  });


  $('#btn-kirim').click(function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data permintaan akan dikirim",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        location.href = "<?= base_url('spg/Permintaan/kirim_permintaan') ?>";
      }
    })
  })
</script>


<script type="text/javascript">
  $(document).ready(function() {
    $('#id_produk').on('change', function() {
      var id = $(this).val();
      var toko = $('#toko').val();
      var status_toko = $('#status_toko').val();
      $.ajax({
        url: '<?php echo base_url() ?>spg/permintaan/tampilkan_detail_produk/',
        method: "POST",
        data: {
          id: id,
          toko: toko
        },
        dataType: 'json',
        success: function(data) {
          $('#nama_produk').text(data.nama_produk);
          $('#stok_tersedia').text(data.qty);
          $('#satuan').text(data.satuan);
          $('#detail_produk').removeClass('d-none');
        }
      });
    });
    $("#qty_po").on("input", function() {
      var id = $(this).val();
      var sisa = $('#sisa_po').val();
      var status_toko = $('#status_toko').val();
      var totalText = $('.total strong').text();
      var ssr = $('#ssr').val();
      var rasio = $('#rasio').val();

      // Bersihkan nilai total dari kemungkinan format non-angka
      var total = totalText.replace(/[^0-9]/g, '');

      var idInt = parseInt(id, 10);
      var sisaInt = parseInt(sisa, 10);
      var totalInt = parseInt(total, 10);
      var ssrInt = parseFloat(ssr);
      var rasioInt = parseFloat(rasio);
      if ((idInt > (sisaInt - totalInt)) && status_toko == "1" && (rasioInt > ssrInt)) {
        Swal.fire(
          'Melebihi Kuota',
          'Pastikan input jumlah yang sesuai dan tidak melebihi sisa kuota PO',
          'info'
        );
        $(this).val(sisaInt - totalInt);
      }
    });


  });
</script>