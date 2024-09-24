<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Data Penjualan</h3>
      </div>
      <div class="card-body">
        <label>Filter Pencarian :</label>
        <div class="row">
          <div class="col-md-4">
            <input type="search" id="search_nomor" class="form-control form-control-sm" placeholder="Cari berdasarkan Nomor Penjualan ...">
          </div>
          <div class="col-md-4">
            <input type="search" id="search_nama_toko" class="form-control form-control-sm" placeholder="Cari berdasarkan Nama Toko ...">
          </div>
          <div class="col-md-4">
            <input type="text" name="tanggal" id="search_periode" class="form-control form-control-sm" placeholder="Cari per periode tgl Penjualan...">
          </div>
        </div>
        <br>
        <table id="tabel_baru" class="table table-striped">
          <thead>
            <tr>
              <th rowspan="2">#</th>
              <th rowspan="2">Nomor</th>
              <th rowspan="2">Nama Toko</th>
              <th colspan="2" class="text-center">Tanggal</th>
              <th rowspan="2" class="text-center" style="width: 13%">Menu</th>
            </tr>
            <tr class="text-center">
              <th>Penjualan</th>
              <th>Dibuat</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <form action="<?= base_url('sup/Penjualan/update_jual') ?>" method="post">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="exampleModalLabel">Edit Penjualan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <label for="">No. Penjualan :</label>
          <input type="text" id="nomor" class="form-control form-control-sm" readonly>
          <div class="form-group">
            <label for="">Toko :</label>
            <input type="text" id="toko" class="form-control form-control-sm" readonly>
          </div>
          <div class="form-group">
            <label for="">Tgl Penjualan :</label>
            <input type="date" name="tanggal_edit" id="tgl_jual" class="form-control form-control-sm" autocomplete="off" required>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_jual" id="id_jual" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm" id="export-button"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $(document).on('click', '#btn_delete', function(e) {
    const id = $(this).data('id');
    e.preventDefault();
    Swal.fire({
      title: 'Hapus Data',
      text: "Apakah anda yakin untuk Menghapusnya?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect ke URL hapus
        location.href = "<?php echo base_url('sup/Penjualan/hapus_data/') ?>" + id;
      }
    });
  });
</script>

<script>
  $(document).ready(function() {
    var table = $('#tabel_baru').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url('sup/Penjualan/get_jual') ?>",
        "type": "POST",
        "data": function(d) {
          d.search_nomor = $('#search_nomor').val();
          d.search_nama_toko = $('#search_nama_toko').val();
          d.search_periode = $('#search_periode').val();
          d.search_status = $('#search_status').val();
        }
      },
      "columns": [{
          "data": "nomor_urut"
        },
        {
          "data": "nomor",
          "render": function(data, type, row) {
            return '<small><strong>' + data + '</strong></small>';
          }
        },
        {
          "data": "nama_toko",
          "render": function(data, type, row) {
            return '<small>' + data + '</small>';
          }
        },
        {
          "data": "tgl_jual",
          "render": function(data, type, row) {
            return '<div class="text-center"><small>' + data + '</small></div>';
          }
        },
        {
          "data": "tgl_dibuat",
          "render": function(data, type, row) {
            return '<div class="text-center"><small>' + data + '</small></div>';
          }
        },
        {
          "data": "menu",
          "orderable": false,
          "searchable": false,
          "render": function(data, type, row) {
            if (data.role == 1) {
              return `
              <a href="<?= base_url('sup/Penjualan/detail/') ?>${data.id}" class="btn btn-sm btn-primary" title="Detail">
                <i class="fas fa-eye"></i></a>
              <button class="btn btn-sm btn-warning" onclick="openEdit('${data.id}', '${data.toko}', '${data.tgl}')" title="Edit">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-sm btn-danger" id="btn_delete" data-id="${data.id}">
                <i class="fas fa-trash"></i>
              </button>
            `;
            } else {
              return `
              <a href="<?= base_url('sup/Penjualan/detail/') ?>${data.id}" class="btn btn-sm btn-primary" title="Detail">
                <i class="fas fa-eye"></i> Detail</a>`;
            }
          }
        }


      ],
      "order": [
        [0, "asc"]
      ],
      "searching": false,
    });
    $('#search_nomor, #search_nama_toko, #search_status').on('keyup change', function() {
      table.draw();
    });
    $('input[name="tanggal"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
        cancelLabel: 'Clear',
        applyLabel: 'Apply',
        format: 'YYYY-MM-DD'
      }
    });
    $('input[name="tanggal"]').on('apply.daterangepicker', function(ev, picker) {
      var dateRange = picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD');
      $('#search_periode').val(dateRange);
      table.draw();
    });
    $('input[name="tanggal"]').on('cancel.daterangepicker', function(ev, picker) {
      $('#search_periode').val('');
      $(this).val('');
      table.draw();
    });
  });

  function openEdit(dataId, toko, tgl) {
    var tanggal = tgl.split(' ')[0];
    $('#id_jual').val(dataId);
    $('#nomor').val(dataId);
    $('#toko').val(toko);
    $('#tgl_jual').val(tanggal);
    $('#modalEdit').modal('show');
  }
</script>