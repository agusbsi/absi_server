<section class="content return-page">
  <div class="container-fluid">
    <div class="card card-primary return-card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-exchange-alt"></i> Data Retur</h3>
      </div>
      <div class="card-body">
        <div class="alert alert-success alert-dismissible return-alert">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <i class="icon fas fa-info"></i>
          <small>Info : Proses verifikasi Retur sekarang berpindah ke manager operasional dan manager marketing. </small>
        </div>
        <div class="return-filter">
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
              <option value="1">Proses Verifikasi (OPR)</option>
              <option value="2">Proses Verifikasi (MM)</option>
              <option value="3">Disetujui</option>
              <option value="7">Proses Pengambilan</option>
              <option value="4">Selesai</option>
              <option value="5">Ditolak</option>
            </select>
          </div>
          <div class="col-md-4">
            <input type="text" name="tanggal" id="search_periode" class="form-control form-control-sm" placeholder="Cari per periode ...">
          </div>
          </div>
        </div>
        <div class="return-table-wrap table-responsive">
        <table id="tabel_baru" class="table table-striped">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>Nomor</th>
              <th>Nama Toko</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th>Tgl Terima</th>
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
  .return-page{--primary:#2563eb;--muted:#64748b;--line:#e2e8f0;color:#0f172a}
  .return-page .return-card{overflow:hidden;border:0;border-radius:16px;background:#fff;box-shadow:0 8px 28px rgba(15,23,42,.08)}
  .return-page .return-card>.card-header{padding:18px 21px;border:0;background:linear-gradient(120deg,#172554,#2563eb)!important}
  .return-page .return-card .card-title{margin:0;color:#fff;font-size:16px;font-weight:700}
  .return-page .return-card>.card-body{padding:18px 20px 20px}
  .return-page .return-alert{display:flex;align-items:flex-start;gap:8px;padding:12px 38px 12px 14px;border:0;border-radius:12px;font-size:11px}
  .return-page .return-alert .close{top:8px;right:10px;padding:0}
  .return-page .return-filter{padding:15px 16px;margin-bottom:16px;border:1px solid var(--line);border-radius:13px;background:#f8fafc}
  .return-page .return-filter>label{margin-bottom:9px;color:#475569;font-size:10px;font-weight:700;text-transform:uppercase}
  .return-page .return-filter .form-control{height:36px;border-color:#cbd5e1;border-radius:9px;font-size:11px}
  .return-page .return-table-wrap{overflow:visible}
  .return-page #tabel_baru{width:100%!important;margin:0!important}
  .return-page #tabel_baru thead th{padding:12px 10px;border-width:1px 0;border-color:var(--line);color:#475569;background:#f8fafc;font-size:10px;font-weight:700;text-transform:uppercase;white-space:nowrap}
  .return-page #tabel_baru tbody td{padding:13px 10px;border-color:#f1f5f9;vertical-align:middle;font-size:12px}
  .return-page #tabel_baru tbody td:nth-child(2) strong{color:#1d4ed8}
  .return-page #tabel_baru tbody td:nth-child(7) .btn{display:inline-flex;align-items:center;gap:6px;height:32px;padding:0 11px;border-radius:9px;font-size:10px;font-weight:700}
  .return-page .dataTables_wrapper>.row:first-child{align-items:center;margin-bottom:10px}
  .return-page .dataTables_length,
  .return-page .dataTables_filter{color:var(--muted);font-size:11px}
  .return-page .dataTables_length select,
  .return-page .dataTables_filter input{height:32px;border:1px solid #dbe3ec;border-radius:8px;font-size:11px}
  .return-page .dataTables_info{color:var(--muted);font-size:11px}
  .return-page .pagination .page-link{margin:0 2px;color:#64748b;border:0;border-radius:7px;font-size:11px}
  .return-page .pagination .page-item.active .page-link{color:#fff;background:var(--primary)}

  @media(max-width:767.98px){
    .return-page{padding:8px 0}
    .return-page .container-fluid{padding-right:10px;padding-left:10px}
    .return-page .return-card{border-radius:14px}
    .return-page .return-card>.card-header{padding:16px}
    .return-page .return-card .card-title{font-size:15px}
    .return-page .return-card>.card-body{padding:13px}
    .return-page .return-alert{gap:7px;padding:11px 34px 11px 12px;margin-bottom:12px;line-height:1.45}
    .return-page .return-filter{padding:12px;margin-bottom:12px;border-radius:12px}
    .return-page .return-filter>label{margin-bottom:7px;font-size:9px}
    .return-page .return-filter .row{margin-right:-4px;margin-left:-4px}
    .return-page .return-filter [class*="col-"]{padding-right:4px;padding-left:4px}
    .return-page .return-filter .form-control{height:34px;margin-bottom:8px;font-size:11px}
    .return-page .return-table-wrap{overflow:visible}
    .return-page .dataTables_wrapper>.row:first-child{display:flex;align-items:flex-end;gap:8px;margin:0 0 10px}
    .return-page .dataTables_wrapper>.row:first-child>[class*="col-"]{width:auto;max-width:none;flex:0 0 auto;padding-right:0;padding-left:0}
    .return-page .dataTables_wrapper>.row:first-child>[class*="col-"]:last-child{flex:1 1 auto;min-width:0}
    .return-page .dataTables_length,
    .return-page .dataTables_filter{font-size:10px;text-align:left!important}
    .return-page .dataTables_length label,
    .return-page .dataTables_filter label{display:block;margin:0;color:var(--muted);line-height:1.2}
    .return-page .dataTables_length select{width:58px;height:32px;margin:4px 0 0;padding:4px 6px}
    .return-page .dataTables_filter input{width:100%!important;max-width:180px;height:32px;margin:4px 0 0;padding:4px 8px}
    .return-page #tabel_baru{display:block;width:100%!important;border-collapse:separate;border-spacing:0 8px}
    .return-page #tabel_baru thead{display:none}
    .return-page #tabel_baru tbody{display:block}
    .return-page #tabel_baru tbody tr{display:grid;grid-template-columns:1fr auto;gap:5px 10px;margin-bottom:8px;padding:11px 12px;border:1px solid var(--line);border-radius:12px;background:#fff;box-shadow:0 4px 14px rgba(15,23,42,.05)}
    .return-page #tabel_baru tbody td{display:block;padding:0;border:0;font-size:12px;text-align:left}
    .return-page #tabel_baru tbody td:nth-child(1){grid-column:2;grid-row:1;color:#94a3b8;font-size:10px;text-align:right}
    .return-page #tabel_baru tbody td:nth-child(2){grid-column:1;grid-row:1;color:#1d4ed8;font-size:12px;line-height:1.25}
    .return-page #tabel_baru tbody td:nth-child(3){grid-column:1 / -1;grid-row:2;color:#334155;line-height:1.4}
    .return-page #tabel_baru tbody td:nth-child(4){grid-column:1;grid-row:3}
    .return-page #tabel_baru tbody td:nth-child(5){grid-column:1;grid-row:4;color:#64748b;font-size:11px}
    .return-page #tabel_baru tbody td:nth-child(5):before{content:"Dibuat: ";color:#94a3b8;font-weight:700}
    .return-page #tabel_baru tbody td:nth-child(6){grid-column:1;grid-row:5;color:#64748b;font-size:11px}
    .return-page #tabel_baru tbody td:nth-child(6):before{content:"Terima: ";color:#94a3b8;font-weight:700}
    .return-page #tabel_baru tbody td:nth-child(7){grid-column:2;grid-row:3 / 6;align-self:end;text-align:right}
    .return-page #tabel_baru tbody td:nth-child(7) .btn{height:31px;padding:0 10px;font-size:10px}
    .return-page .dataTables_wrapper>.row:last-child{gap:8px;margin:4px 0 0}
    .return-page .dataTables_wrapper>.row:last-child>[class*="col-"]{padding-right:0;padding-left:0}
    .return-page .dataTables_info{padding-top:4px!important;font-size:10px;text-align:center}
    .return-page .dataTables_paginate .pagination{flex-wrap:wrap;justify-content:center;margin:0}
    .return-page .pagination .page-link{padding:5px 8px;font-size:11px}
  }
</style>
<script>
  $(document).ready(function() {
    var table = $('#tabel_baru').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url('adm/Retur/get_retur') ?>",
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
          "data": "tgl_terima",
          "render": function(data, type, row) {
            return '<small>' + (data ? data : '-') + '</small>';
          }
        },
        {
          "data": "menu",
          "orderable": false,
          "searchable": false,
          "render": function(data, type, row) {
            return '<a href="<?= base_url('adm/Retur/detail/') ?>' + data + '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>';
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
</script>
