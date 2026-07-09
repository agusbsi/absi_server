<section class="content request-page">
  <div class="container-fluid">
    <div class="card card-primary request-card">
      <div class="card-header">
        <h3 class="card-title">
          <li class="fas fa-file-alt"></li> Data Permintaan
        </h3>

      </div>
      <div class="card-body">
        <div class="request-filter">
          <label>Filter Pencarian :</label>
          <div class="row">
            <div class="col-md-3">
              <input type="search" id="search_nomor" class="form-control form-control-sm" placeholder="Cari berdasarkan Nomor ...">
            </div>
            <div class="col-md-3">
              <input type="search" id="search_nama_toko" class="form-control form-control-sm" placeholder="Cari berdasarkan Nama Toko ...">
            </div>
            <div class="col-md-2">
              <select id="search_status" class="form-control form-control-sm">
                <option value="">Semua status</option>
                <option value="0">Diproses Leader</option>
                <option value="1">Diproses MV</option>
                <option value="7">Ditunda</option>
                <option value="2">Disetujui</option>
                <option value="4">Dikirim</option>
                <option value="6">Selesai</option>
                <option value="9">DiTolak</option>
              </select>
            </div>
            <div class="col-md-4">
              <input type="text" name="tanggal" id="search_periode" class="form-control form-control-sm" placeholder="Cari per periode ...">
            </div>
          </div>
        </div>
        <div class="request-table-wrap table-responsive">
          <table id="tabel_baru" class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Nomor PO</th>
                <th>Nama Toko</th>
                <th>Status</th>
                <th>Tgl Dibuat</th>
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
  .request-page{--primary:#2563eb;--muted:#64748b;--line:#e2e8f0;color:#0f172a}
  .request-page .request-card{overflow:hidden;border:0;border-radius:16px;background:#fff;box-shadow:0 8px 28px rgba(15,23,42,.08)}
  .request-page .request-card>.card-header{padding:18px 21px;border:0;background:linear-gradient(120deg,#172554,#2563eb)!important}
  .request-page .request-card .card-title{margin:0;color:#fff;font-size:16px;font-weight:700}
  .request-page .request-card>.card-body{padding:18px 20px 20px}
  .request-page .request-filter{padding:15px 16px;margin-bottom:16px;border:1px solid var(--line);border-radius:13px;background:#f8fafc}
  .request-page .request-filter>label{margin-bottom:9px;color:#475569;font-size:10px;font-weight:700;text-transform:uppercase}
  .request-page .request-filter .form-control{height:36px;border-color:#cbd5e1;border-radius:9px;font-size:11px}
  .request-page .request-table-wrap{overflow:visible}
  .request-page #tabel_baru{width:100%!important;margin:0!important}
  .request-page #tabel_baru thead th{padding:12px 10px;border-width:1px 0;border-color:var(--line);color:#475569;background:#f8fafc;font-size:10px;font-weight:700;text-transform:uppercase;white-space:nowrap}
  .request-page #tabel_baru tbody td{padding:13px 10px;border-color:#f1f5f9;vertical-align:middle;font-size:12px}
  .request-page #tabel_baru tbody td:nth-child(2) strong{color:#1d4ed8}
  .request-page #tabel_baru tbody td:nth-child(6) .btn{display:inline-flex;align-items:center;gap:6px;height:32px;padding:0 11px;border-radius:9px;font-size:10px;font-weight:700}
  .request-page .top{align-items:center;margin-bottom:10px}
  .request-page .dataTables_length{color:var(--muted);font-size:11px}
  .request-page .dataTables_length select{height:32px;margin:0 5px;border:1px solid #dbe3ec;border-radius:8px;font-size:11px}
  .request-page .dt-buttons .btn{height:32px;padding:0 11px;border-radius:8px;font-size:10px;font-weight:700}
  .request-page .dataTables_info{color:var(--muted);font-size:11px}
  .request-page .pagination .page-link{margin:0 2px;color:#64748b;border:0;border-radius:7px;font-size:11px}
  .request-page .pagination .page-item.active .page-link{color:#fff;background:var(--primary)}

  @media(max-width:767.98px){
    .request-page{padding:8px 0}
    .request-page .container-fluid{padding-right:10px;padding-left:10px}
    .request-page .request-card{border-radius:14px}
    .request-page .request-card>.card-header{padding:16px}
    .request-page .request-card .card-title{font-size:15px}
    .request-page .request-card>.card-body{padding:13px}
    .request-page .request-filter{padding:12px;margin-bottom:12px;border-radius:12px}
    .request-page .request-filter>label{margin-bottom:7px;font-size:9px}
    .request-page .request-filter .row{margin-right:-4px;margin-left:-4px}
    .request-page .request-filter [class*="col-"]{padding-right:4px;padding-left:4px}
    .request-page .request-filter .form-control{height:34px;margin-bottom:8px;font-size:11px}
    .request-page .request-table-wrap{overflow:visible}
    .request-page .top{display:flex!important;align-items:flex-end!important;gap:8px;margin-bottom:10px}
    .request-page .top .dataTables_length{flex:0 0 auto;font-size:10px}
    .request-page .dataTables_length label{display:block;margin:0;color:var(--muted);line-height:1.2}
    .request-page .dataTables_length select{width:58px;height:32px;margin:4px 0 0;padding:4px 6px}
    .request-page .dt-buttons{display:flex;flex:1 1 auto;justify-content:flex-end;gap:5px;min-width:0}
    .request-page .dt-buttons .btn{height:32px;padding:0 9px;font-size:10px}
    .request-page #tabel_baru{display:block;width:100%!important;border-collapse:separate;border-spacing:0 8px}
    .request-page #tabel_baru thead{display:none}
    .request-page #tabel_baru tbody{display:block}
    .request-page #tabel_baru tbody tr{display:grid;grid-template-columns:1fr auto;gap:5px 10px;margin-bottom:8px;padding:11px 12px;border:1px solid var(--line);border-radius:12px;background:#fff;box-shadow:0 4px 14px rgba(15,23,42,.05)}
    .request-page #tabel_baru tbody td{display:block;padding:0;border:0;font-size:12px;text-align:left}
    .request-page #tabel_baru tbody td:nth-child(1){grid-column:2;grid-row:1;color:#94a3b8;font-size:10px;text-align:right}
    .request-page #tabel_baru tbody td:nth-child(2){grid-column:1;grid-row:1;color:#1d4ed8;font-size:12px;line-height:1.25}
    .request-page #tabel_baru tbody td:nth-child(3){grid-column:1 / -1;grid-row:2;color:#334155;line-height:1.4}
    .request-page #tabel_baru tbody td:nth-child(4){grid-column:1;grid-row:3}
    .request-page #tabel_baru tbody td:nth-child(5){grid-column:1;grid-row:4;color:#64748b;font-size:11px}
    .request-page #tabel_baru tbody td:nth-child(5):before{content:"Dibuat: ";color:#94a3b8;font-weight:700}
    .request-page #tabel_baru tbody td:nth-child(6){grid-column:2;grid-row:3 / 5;align-self:end;text-align:right}
    .request-page #tabel_baru tbody td:nth-child(6) .btn{height:31px;padding:0 10px;font-size:10px}
    .request-page .bottom{margin-top:4px}
    .request-page .dataTables_info{padding-top:4px!important;font-size:10px;text-align:center}
    .request-page .dataTables_paginate .pagination{flex-wrap:wrap;justify-content:center;margin:0}
    .request-page .pagination .page-link{padding:5px 8px;font-size:11px}
  }
</style>
<script>
  $(document).ready(function() {
    var table = $('#tabel_baru').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url('adm/Permintaan/get_po') ?>",
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
            return '<a href="<?= base_url('adm/Permintaan/detail/') ?>' + data + '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>';
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
