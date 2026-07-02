<style>
  .repair-stat{border-radius:12px;color:#fff;min-height:125px}.repair-stat .value{font-size:2.2rem;font-weight:700}.repair-log{background:#111827;color:#d1fae5;height:270px;overflow:auto;padding:16px;border-radius:8px;font:13px/1.55 Consolas,monospace}.status-dot{width:10px;height:10px;display:inline-block;border-radius:50%;margin-right:7px;background:#6c757d}.status-dot.running{background:#28a745;animation:pulse 1s infinite}@keyframes pulse{50%{opacity:.35}}
</style>
<section class="content-header"><div class="container-fluid"><h1>Perbaikan Kartu Stok</h1><small class="text-muted">Pemeriksaan, backup, dan perbaikan data berulang.</small></div></section>
<section class="content"><div class="container-fluid">
 <div class="alert alert-warning"><i class="fas fa-exclamation-triangle mr-1"></i>Buat backup sebelum memulai. Backup baru mengganti <code>tb_kartu_stok_backup</code> sebelumnya.</div>
 <div class="row">
  <div class="col-md-4"><div class="repair-stat bg-danger p-4 mb-3"><div class="mb-3">Stok tidak sinkron</div><div id="total-stok" class="value"><?= (int)$ringkasan['total_stok_tidak_sinkron'] ?></div></div></div>
  <div class="col-md-4"><div class="repair-stat bg-warning p-4 mb-3"><div class="mb-3">Sisa tidak sesuai</div><div id="total-sisa" class="value"><?= (int)$ringkasan['total_sisa_salah'] ?></div></div></div>
  <div class="col-md-4"><div class="repair-stat bg-info p-4 mb-3"><div class="mb-3">Total masalah</div><div id="total-masalah" class="value"><?= (int)$ringkasan['total_masalah'] ?></div></div></div>
 </div>
 <div class="card"><div class="card-header"><strong>Kontrol</strong></div><div class="card-body">
  <button id="btn-cek" class="btn btn-info"><i class="fas fa-search mr-1"></i>Cek ulang</button> <button id="btn-backup" class="btn btn-secondary"><i class="fas fa-database mr-1"></i>Backup data</button> <button id="btn-mulai" class="btn btn-success"><i class="fas fa-play mr-1"></i>Mulai</button> <button id="btn-proses" class="btn btn-primary" disabled><i class="fas fa-step-forward mr-1"></i>Proses</button> <button id="btn-stop" class="btn btn-danger" disabled><i class="fas fa-stop mr-1"></i>Berhenti</button>
  <div class="mt-3"><span id="status-dot" class="status-dot"></span><span id="status-text">Siap</span></div>
 </div></div>
 <div class="card"><div class="card-header d-flex"><strong>Result</strong><button id="btn-clear" class="btn btn-xs btn-outline-secondary ml-auto">Bersihkan</button></div><div class="card-body"><div id="result" class="repair-log">Menunggu perintah...</div></div></div>
</div></section>
<script>
$(function(){
 const u={cek:'<?= base_url('adm/Stok/cek_perbaikan_stok') ?>',backup:'<?= base_url('adm/Stok/backup_kartu_stok') ?>',mulai:'<?= base_url('adm/Stok/mulai_perbaikan_stok') ?>',proses:'<?= base_url('adm/Stok/proses_perbaikan_stok') ?>',stop:'<?= base_url('adm/Stok/berhenti_perbaikan_stok') ?>'};let jalan=false,otomatis=false,putaran=0;
 function log(s){let w=new Date().toLocaleTimeString('id-ID'),safe=$('<span>').text(s).html();$('#result').append('<div>['+w+'] '+safe+'</div>').scrollTop($('#result')[0].scrollHeight)}
 function angka(d){$('#total-stok').text(d.total_stok_tidak_sinkron);$('#total-sisa').text(d.total_sisa_salah);$('#total-masalah').text(d.total_masalah)}
 function status(s,a){$('#status-text').text(s);$('#status-dot').toggleClass('running',!!a)} function tombol(a){jalan=a;$('#btn-mulai,#btn-backup,#btn-cek').prop('disabled',a);$('#btn-proses,#btn-stop').prop('disabled',!a)}
 function gagal(x){otomatis=false;tombol(false);status('Gagal',false);log('ERROR: '+((x.responseJSON&&x.responseJSON.message)||x.statusText||'Request gagal'))}
 function proses(){if(!jalan)return;$('#btn-proses').prop('disabled',true);$.post(u.proses).done(function(r){angka(r.data);if(r.stopped){otomatis=false;tombol(false);status('Dihentikan',false);log('Proses dihentikan.');return}putaran++;log('Putaran '+putaran+': '+r.diperbaiki.sisa+' sisa dan '+r.diperbaiki.stok+' stok diperbaiki. Tersisa '+r.data.total_masalah+' masalah.');if(r.selesai){otomatis=false;tombol(false);status('Selesai',false);log('SELESAI: seluruh data normal sudah konsisten.');return}$('#btn-proses').prop('disabled',false);if(otomatis)setTimeout(proses,250)}).fail(gagal)}
 $('#btn-cek').click(function(){status('Memeriksa...',true);$.getJSON(u.cek).done(function(r){angka(r.data);status('Pemeriksaan selesai',false);log('Ditemukan '+r.data.total_masalah+' masalah.')}).fail(gagal)});
 $('#btn-backup').click(function(){if(!confirm('Backup lama akan diganti. Lanjutkan?'))return;status('Membuat backup...',true);$(this).prop('disabled',true);$.post(u.backup).done(function(r){status('Backup tersedia',false);log('Backup berhasil: '+r.jumlah+' baris pada '+r.waktu+'.');$('#btn-backup').prop('disabled',false)}).fail(gagal)});
 $('#btn-mulai').click(function(){if(!confirm('Pastikan backup sudah dibuat. Mulai perbaikan otomatis?'))return;putaran=0;otomatis=true;status('Menyiapkan...',true);$.post(u.mulai).done(function(r){angka(r.data);tombol(true);status('Proses berjalan',true);log('Perbaikan dimulai dengan '+r.data.total_masalah+' masalah.');if(r.data.total_masalah===0){otomatis=false;tombol(false);status('Tidak ada masalah',false);log('Data sudah konsisten.')}else proses()}).fail(gagal)});
 $('#btn-proses').click(function(){otomatis=false;proses()});$('#btn-stop').click(function(){otomatis=false;status('Menghentikan...',true);$.post(u.stop).done(function(){tombol(false);status('Dihentikan',false);log('Permintaan berhenti diterima.')}).fail(gagal)});$('#btn-clear').click(function(){$('#result').html('')});
});
</script>
