<section class="content shipping-page">
  <div class="container-fluid">
    <div class="card card-primary shipping-card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-truck"></i> Data Pengiriman</h3>
      </div>
      <div class="card-body">
        <div class="shipping-filter">
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
        </div>
        <div class="shipping-table-wrap table-responsive">
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
  </div>
</section>
<style>
  .shipping-page{--primary:#2563eb;--muted:#64748b;--line:#e2e8f0;color:#0f172a}
  .shipping-page .shipping-card{overflow:hidden;border:0;border-radius:16px;background:#fff;box-shadow:0 8px 28px rgba(15,23,42,.08)}
  .shipping-page .shipping-card>.card-header{padding:18px 21px;border:0;background:linear-gradient(120deg,#172554,#2563eb)!important}
  .shipping-page .shipping-card .card-title{margin:0;color:#fff;font-size:16px;font-weight:700}
  .shipping-page .shipping-card>.card-body{padding:18px 20px 20px}
  .shipping-page .shipping-filter{padding:15px 16px;margin-bottom:16px;border:1px solid var(--line);border-radius:13px;background:#f8fafc}
  .shipping-page .shipping-filter>label{margin-bottom:9px;color:#475569;font-size:10px;font-weight:700;text-transform:uppercase}
  .shipping-page .shipping-filter .form-control{height:36px;border-color:#cbd5e1;border-radius:9px;font-size:11px}
  .shipping-page .shipping-table-wrap{overflow:visible}
  .shipping-page #tabel_baru{width:100%!important;margin:0!important}
  .shipping-page #tabel_baru thead th{padding:12px 10px;border-width:1px 0;border-color:var(--line);color:#475569;background:#f8fafc;font-size:10px;font-weight:700;text-transform:uppercase;white-space:nowrap}
  .shipping-page #tabel_baru tbody td{padding:13px 10px;border-color:#f1f5f9;vertical-align:middle;font-size:12px}
  .shipping-page #tabel_baru tbody td:nth-child(2) strong,
  .shipping-page #tabel_baru tbody td:nth-child(3) strong{color:#1d4ed8}
  .shipping-page #tabel_baru tbody td:nth-child(7) .btn{display:inline-flex;align-items:center;gap:6px;height:32px;padding:0 11px;border-radius:9px;font-size:10px;font-weight:700}
  .shipping-page .top{align-items:center;margin-bottom:10px}
  .shipping-page .dataTables_length{color:var(--muted);font-size:11px}
  .shipping-page .dataTables_length select{height:32px;margin:0 5px;border:1px solid #dbe3ec;border-radius:8px;font-size:11px}
  .shipping-page .dt-buttons .btn{height:32px;padding:0 11px;border-radius:8px;font-size:10px;font-weight:700}
  .shipping-page .dataTables_info{color:var(--muted);font-size:11px}
  .shipping-page .pagination .page-link{margin:0 2px;color:#64748b;border:0;border-radius:7px;font-size:11px}
  .shipping-page .pagination .page-item.active .page-link{color:#fff;background:var(--primary)}

  @media(max-width:767.98px){
    .shipping-page{padding:8px 0}
    .shipping-page .container-fluid{padding-right:10px;padding-left:10px}
    .shipping-page .shipping-card{border-radius:14px}
    .shipping-page .shipping-card>.card-header{padding:16px}
    .shipping-page .shipping-card .card-title{font-size:15px}
    .shipping-page .shipping-card>.card-body{padding:13px}
    .shipping-page .shipping-filter{padding:12px;margin-bottom:12px;border-radius:12px}
    .shipping-page .shipping-filter>label{margin-bottom:7px;font-size:9px}
    .shipping-page .shipping-filter .row{margin-right:-4px;margin-left:-4px}
    .shipping-page .shipping-filter [class*="col-"]{padding-right:4px;padding-left:4px}
    .shipping-page .shipping-filter .form-control{height:34px;margin-bottom:8px;font-size:11px}
    .shipping-page .shipping-table-wrap{overflow:visible}
    .shipping-page .top{display:flex!important;align-items:flex-end!important;gap:8px;margin-bottom:10px}
    .shipping-page .top .dataTables_length{flex:0 0 auto;font-size:10px}
    .shipping-page .dataTables_length label{display:block;margin:0;color:var(--muted);line-height:1.2}
    .shipping-page .dataTables_length select{width:58px;height:32px;margin:4px 0 0;padding:4px 6px}
    .shipping-page .dt-buttons{display:flex;flex:1 1 auto;justify-content:flex-end;gap:5px;min-width:0}
    .shipping-page .dt-buttons .btn{height:32px;padding:0 9px;font-size:10px}
    .shipping-page #tabel_baru{display:block;width:100%!important;border-collapse:separate;border-spacing:0 8px}
    .shipping-page #tabel_baru thead{display:none}
    .shipping-page #tabel_baru tbody{display:block}
    .shipping-page #tabel_baru tbody tr{display:grid;grid-template-columns:1fr auto;gap:5px 10px;margin-bottom:8px;padding:11px 12px;border:1px solid var(--line);border-radius:12px;background:#fff;box-shadow:0 4px 14px rgba(15,23,42,.05)}
    .shipping-page #tabel_baru tbody td{display:block;padding:0;border:0;font-size:12px;text-align:left}
    .shipping-page #tabel_baru tbody td:nth-child(1){grid-column:2;grid-row:1;color:#94a3b8;font-size:10px;text-align:right}
    .shipping-page #tabel_baru tbody td:nth-child(2){grid-column:1;grid-row:1;color:#1d4ed8;font-size:12px;line-height:1.25}
    .shipping-page #tabel_baru tbody td:nth-child(3){grid-column:1;grid-row:2;color:#475569;font-size:11px}
    .shipping-page #tabel_baru tbody td:nth-child(3):before{content:"PO: ";color:#94a3b8;font-weight:700}
    .shipping-page #tabel_baru tbody td:nth-child(4){grid-column:1 / -1;grid-row:3;color:#334155;line-height:1.4}
    .shipping-page #tabel_baru tbody td:nth-child(5){grid-column:1;grid-row:4}
    .shipping-page #tabel_baru tbody td:nth-child(6){grid-column:1;grid-row:5;color:#64748b;font-size:11px;line-height:1.45}
    .shipping-page #tabel_baru tbody td:nth-child(7){grid-column:2;grid-row:4 / 6;align-self:end;text-align:right}
    .shipping-page #tabel_baru tbody td:nth-child(7) .btn{height:31px;padding:0 10px;font-size:10px}
    .shipping-page .bottom{margin-top:4px}
    .shipping-page .dataTables_info{padding-top:4px!important;font-size:10px;text-align:center}
    .shipping-page .dataTables_paginate .pagination{flex-wrap:wrap;justify-content:center;margin:0}
    .shipping-page .pagination .page-link{padding:5px 8px;font-size:11px}
  }
</style>
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
            return '<small><strong><a href="<?= base_url('adm/Permintaan/detail/') ?>' + data + '">' + data + '</a></strong></small>';
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
            var html = '<small>';
            html += '<strong>Dibuat:</strong> ' + row.tgl_dibuat + '<br>';
            html += '<strong>Terima:</strong> ' + (row.tgl_terima && row.tgl_terima != '0000-00-00 00:00:00' && row.tgl_terima != '0000-00-00' && !row.tgl_terima.includes('1970') ? row.tgl_terima : "belum diterima");
            html += '</small>';
            return html;
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
