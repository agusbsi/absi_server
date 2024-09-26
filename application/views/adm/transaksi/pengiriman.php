<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-truck"></i> Data Pengiriman</h3>
      </div>
      <div class="card-body">
        <label>Filter Pencarian :</label>
        <div class="row">
          <div class="col-md-3">
            <input type="search" id="search_nomor" class="form-control form-control-sm" placeholder="Cari berdasarkan Nomor Kirim ...">
          </div>
          <div class="col-md-3">
            <input type="search" id="search_nama_toko" class="form-control form-control-sm" placeholder="Cari berdasarkan Nama Toko ...">
          </div>
          <div class="col-md-2">
            <select id="search_status" class="form-control form-control-sm">
              <option value="">Semua status</option>
              <option value="1">Dikirim</option>
              <option value="2">Selesai</option>
              <option value="3">Selisih</option>
            </select>
          </div>
          <div class="col-md-4">
            <input type="text" name="tanggal" id="search_periode" class="form-control form-control-sm" placeholder="Cari per periode ...">
          </div>
        </div>
        <br>
        <table id="tabel_baru" class="table table-striped">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>Nomor</th>
              <th>Nomor PO</th>
              <th>Nama Toko</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th>Menu</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    var table = $('#tabel_baru').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url('adm/Pengiriman/get_kirim') ?>",
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
          "data": "po",
          "render": function(data, type, row) {
            return '<small><strong><a href="<?= base_url('adm/Permintaan/detail/') ?>' + data + '"</a>' + data + '</strong></small>';
          }
        },
        {
          "data": "nama_toko",
          "render": function(data, type, row) {
            return '<small>' + data + '</small>';
          }
        },
        {
          "data": "status"
        },
        {
          "data": "tgl_dibuat",
          "render": function(data, type, row) {
            return '<small>' + data + '</small>';
          }
        },
        {
          "data": "menu",
          "orderable": false,
          "searchable": false,
          "render": function(data, type, row) {
            return '<a href="<?= base_url('adm/Pengiriman/detail/') ?>' + data + '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>';
          }
        }

      ],
      "order": [
        [0, "asc"]
      ],
      "searching": false,
      "dom": '<"top d-flex justify-content-between"lB>rt<"bottom"ip><"clear">',
      "buttons": [{
          extend: 'excel',
          text: 'Excel'
        },
        {
          extend: 'pdf',
          text: 'PDF'
        }
      ]
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
</script>