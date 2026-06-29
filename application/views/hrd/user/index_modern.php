<?php
date_default_timezone_set('Asia/Jakarta');
$users = is_array($list_users) ? $list_users : array();
$stats = array('total' => count($users), 'active' => 0, 'inactive' => 0, 'online' => 0);
foreach ($users as $item) {
  $login_age = !empty($item->last_login) ? time() - strtotime($item->last_login) : null;
  $online = $login_age !== null && $login_age >= 0 && $login_age <= 300;
  $stats['active'] += ((int) $item->status === 1) ? 1 : 0;
  $stats['inactive'] += ((int) $item->status === 1) ? 0 : 1;
  $stats['online'] += $online ? 1 : 0;
}
?>

<style>
  .user-page{--primary:#2563eb;--ink:#172033;--muted:#718096;--line:#e7edf5;padding-bottom:28px;color:var(--ink)}
  .user-page .user-hero{position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:24px;margin-bottom:20px;padding:25px 28px;color:#fff;background:linear-gradient(120deg,#1e40af 0%,#2563eb 58%,#38bdf8 140%);border-radius:18px;box-shadow:0 14px 34px rgba(37,99,235,.2)}
  .user-page .user-hero:after{position:absolute;top:-85px;right:12%;width:220px;height:220px;content:'';border:1px solid rgba(255,255,255,.16);border-radius:50%}
  .user-page .hero-copy,.user-page .hero-action{position:relative;z-index:1}.user-page .hero-eyebrow{display:block;margin-bottom:6px;color:rgba(255,255,255,.76);font-size:11px;font-weight:700;letter-spacing:.09em;text-transform:uppercase}
  .user-page .user-hero h1{margin:0 0 5px;font-size:25px;font-weight:700;letter-spacing:-.02em}.user-page .user-hero p{margin:0;color:rgba(255,255,255,.8);font-size:13px}
  .user-page .btn-add{padding:10px 16px;color:#1d4ed8;background:#fff;border:0;border-radius:10px;box-shadow:0 6px 18px rgba(15,23,42,.14);font-size:13px;font-weight:700;white-space:nowrap}.user-page .btn-add:hover{color:#1e3a8a;background:#f8fbff;transform:translateY(-1px)}
  .user-page .stat-card{display:flex;min-height:94px;align-items:center;gap:13px;margin-bottom:16px;padding:17px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 5px 16px rgba(34,45,70,.04)}
  .user-page .stat-icon{display:flex;width:43px;height:43px;flex:0 0 43px;align-items:center;justify-content:center;color:var(--color);background:var(--soft);border-radius:12px;font-size:16px}.user-page .stat-value{margin:0;color:#111827;font-size:23px;font-weight:700;line-height:1.1}.user-page .stat-label{margin:4px 0 0;color:var(--muted);font-size:12px}
  .user-page .list-card{overflow:hidden;background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 7px 22px rgba(34,45,70,.05)}.user-page .list-header{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:19px 21px;border-bottom:1px solid var(--line)}
  .user-page .list-title{margin:0 0 3px;font-size:16px;font-weight:700}.user-page .list-subtitle{margin:0;color:var(--muted);font-size:12px}.user-page .toolbar{display:flex;align-items:center;gap:9px}.user-page .search-box{position:relative;min-width:245px}.user-page .search-box i{position:absolute;top:50%;left:12px;color:#9aa7b8;font-size:12px;transform:translateY(-50%)}
  .user-page .search-box input{height:38px;padding-left:34px;background:#f8fafc;border:1px solid var(--line);border-radius:9px;font-size:12px}.user-page .filter-select{width:auto;min-width:130px;height:38px;background-color:#f8fafc;border-color:var(--line);border-radius:9px;font-size:12px}
  .user-page .table-responsive{overflow:visible}.user-page .user-table{width:100%!important;margin:0!important;font-size:12px}.user-page .user-table thead th{padding:12px 15px;color:#64748b;background:#f8fafc;border-top:0;border-bottom:1px solid var(--line);font-size:10px;font-weight:700;letter-spacing:.055em;text-transform:uppercase;white-space:nowrap}.user-page .user-table tbody td{padding:13px 15px;vertical-align:middle;border-top:1px solid #f0f3f8}.user-page .user-table tbody tr:hover{background:#fbfdff}
  .user-page .user-profile{display:flex;min-width:230px;align-items:center;gap:11px}.user-page .avatar-wrap{position:relative;width:44px;height:44px;flex:0 0 44px}.user-page .user-avatar{width:44px;height:44px;object-fit:cover;border:2px solid #fff;border-radius:12px;box-shadow:0 0 0 1px var(--line)}.user-page .presence{position:absolute;right:-1px;bottom:-1px;width:11px;height:11px;background:#94a3b8;border:2px solid #fff;border-radius:50%}.user-page .presence.online{background:#22c55e}
  .user-page .user-name{display:block;max-width:215px;overflow:hidden;margin-bottom:2px;color:#1f2937;font-size:13px;font-weight:700;text-overflow:ellipsis;white-space:nowrap}.user-page .username{color:var(--muted);font-size:11px}.user-page .contact{display:block;margin:2px 0;color:#475569;white-space:nowrap}.user-page .contact i{width:15px;color:#a0aec0}
  .user-page .role-pill,.user-page .status-pill{display:inline-flex;align-items:center;gap:6px;padding:6px 9px;border-radius:999px;font-size:10px;font-weight:700;white-space:nowrap}.user-page .role-pill{color:#475569;background:#f1f5f9}.user-page .status-pill.active{color:#15803d;background:#ecfdf3}.user-page .status-pill.inactive{color:#b91c1c;background:#fef2f2}.user-page .status-pill i{font-size:6px}.user-page .login-time{display:block;color:#334155;font-weight:600;white-space:nowrap}.user-page .login-note{display:block;margin-top:3px;color:var(--muted);font-size:10px}
  .user-page .actions{display:flex;justify-content:flex-end;gap:5px;white-space:nowrap}.user-page .action-btn{display:inline-flex;width:32px;height:32px;align-items:center;justify-content:center;padding:0;color:#64748b;background:#f8fafc;border:1px solid var(--line);border-radius:8px;cursor:pointer;transition:.15s}.user-page .action-btn:hover{color:var(--primary);background:#eff6ff;border-color:#bfdbfe}.user-page .action-btn.danger:hover{color:#dc2626;background:#fef2f2;border-color:#fecaca}.user-page .action-btn.success:hover{color:#15803d;background:#ecfdf3;border-color:#bbf7d0}
  .user-page .table-footer{display:flex;align-items:center;justify-content:space-between;padding:13px 19px;border-top:1px solid var(--line)}.user-page .dataTables_info,.user-page .dataTables_paginate{padding-top:0!important}.user-page .dataTables_info{color:var(--muted);font-size:11px}.user-page .pagination .page-link{margin:0 2px;color:#64748b;border:0;border-radius:7px;font-size:11px}.user-page .pagination .page-item.active .page-link{color:#fff;background:var(--primary)}
  .user-modal .modal-content{overflow:hidden;border:0;border-radius:16px;box-shadow:0 20px 55px rgba(15,23,42,.2)}.user-modal .modal-header{padding:19px 22px;color:#fff;background:linear-gradient(120deg,#1d4ed8,#38bdf8);border:0}.user-modal .modal-title{font-size:17px;font-weight:700}.user-modal .modal-header .close{color:#fff;opacity:.8;text-shadow:none}.user-modal .modal-body{padding:22px}.user-modal .form-section{height:100%;padding:18px;background:#f8fafc;border:1px solid #e7edf5;border-radius:12px}.user-modal .section-label{margin-bottom:16px;color:#334155;font-size:12px;font-weight:700;letter-spacing:.04em;text-transform:uppercase}.user-modal label{color:#475569;font-size:11px;font-weight:700}.user-modal .form-control{min-height:38px;border-color:#dfe6ef;border-radius:8px;font-size:12px}.user-modal textarea.form-control{min-height:72px}.user-modal .field-note{display:block;margin-top:5px;color:#94a3b8;font-size:10px}.user-modal .modal-footer{padding:14px 22px;background:#f8fafc;border-top-color:#e7edf5}
  @media(max-width:991.98px){.user-page .list-header{align-items:flex-start;flex-direction:column}.user-page .toolbar{width:100%}.user-page .search-box{min-width:0;flex:1}.user-page .table-responsive{overflow-x:auto}}
  @media(max-width:575.98px){.user-page .user-hero{align-items:flex-start;padding:21px;flex-direction:column}.user-page .user-hero h1{font-size:21px}.user-page .hero-action,.user-page .btn-add{width:100%}.user-page .toolbar{align-items:stretch;flex-direction:column}.user-page .filter-select{width:100%}.user-page .list-header{padding:17px}}
</style>

<section class="content user-page"><div class="container-fluid">
  <div class="user-hero">
    <div class="hero-copy"><span class="hero-eyebrow"><i class="fas fa-user-shield mr-1"></i> Manajemen akses</span><h1>Kelola Pengguna</h1><p>Pantau akun, status akses, dan aktivitas pengguna dari satu tempat.</p></div>
    <div class="hero-action"><button type="button" class="btn btn-add" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus mr-2"></i>Tambah pengguna</button></div>
  </div>
  <div class="row">
    <?php $cards=array(array('total','users','Total pengguna','#2563eb','#eff6ff'),array('active','user-check','Akun aktif','#16a34a','#ecfdf3'),array('inactive','user-slash','Akun nonaktif','#dc2626','#fef2f2'),array('online','signal','Sedang online','#0891b2','#ecfeff')); foreach($cards as $card){ ?>
      <div class="col-6 col-lg-3"><div class="stat-card" style="--color:<?= $card[3] ?>;--soft:<?= $card[4] ?>"><span class="stat-icon"><i class="fas fa-<?= $card[1] ?>"></i></span><div><p class="stat-value"><?= $stats[$card[0]] ?></p><p class="stat-label"><?= $card[2] ?></p></div></div></div>
    <?php } ?>
  </div>
  <div class="list-card">
    <div class="list-header"><div><h2 class="list-title">Daftar pengguna</h2><p class="list-subtitle">Cari dan filter akun yang ingin dikelola.</p></div>
      <div class="toolbar"><div class="search-box"><i class="fas fa-search"></i><input type="search" id="userSearch" class="form-control" placeholder="Cari nama, username, NIK..." aria-label="Cari pengguna"></div>
        <select id="statusFilter" class="form-control filter-select"><option value="">Semua status</option><option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option></select>
        <select id="roleFilter" class="form-control filter-select"><option value="">Semua role</option><?php foreach($list_role as $role_item){ ?><option value="<?= html_escape($role_item->nama) ?>"><?= html_escape($role_item->nama) ?></option><?php } ?></select>
      </div>
    </div>
    <div class="table-responsive"><table id="table_user" class="table user-table"><thead><tr><th>Pengguna</th><th>Kontak &amp; Identitas</th><th>Role</th><th>Status</th><th>Login terakhir</th><th class="text-right">Aksi</th></tr></thead><tbody>
      <?php foreach($users as $dd):
        $login_age=!empty($dd->last_login)?time()-strtotime($dd->last_login):null; $online=$login_age!==null&&$login_age>=0&&$login_age<=300; $active=((int)$dd->status===1);
        $photo=empty($dd->foto_diri)?base_url('assets/img/user.png'):base_url('assets/img/user/'.rawurlencode($dd->foto_diri)); $role_name=!empty($dd->nama)?$dd->nama:'Tanpa role'; ?>
        <tr>
          <td><div class="user-profile"><div class="avatar-wrap"><img class="user-avatar" src="<?= $photo ?>" alt="Foto <?= html_escape($dd->nama_user) ?>" loading="lazy" onerror="this.src='<?= base_url('assets/img/user.png') ?>'"><span class="presence <?= $online?'online':'' ?>" title="<?= $online?'Online':'Offline' ?>"></span></div><div><span class="user-name"><?= html_escape($dd->nama_user) ?></span><span class="username">@<?= html_escape($dd->username) ?> · <?= $online?'Online':'Offline' ?></span></div></div></td>
          <td><span class="contact"><i class="fas fa-phone-alt"></i><?= !empty($dd->no_telp)?html_escape($dd->no_telp):'-' ?></span><span class="contact"><i class="far fa-id-card"></i><?= !empty($dd->nik_ktp)?html_escape($dd->nik_ktp):'-' ?></span></td>
          <td><span class="role-pill"><i class="fas fa-shield-alt"></i><?= html_escape($role_name) ?></span></td>
          <td><span class="status-pill <?= $active?'active':'inactive' ?>"><i class="fas fa-circle"></i><?= $active?'Aktif':'Nonaktif' ?></span></td>
          <td><span class="login-time"><?= $dd->last_login?login(strtotime($dd->last_login)):'Belum pernah login' ?></span><span class="login-note"><?= $online?'Aktif dalam 5 menit terakhir':'Offline' ?></span></td>
          <td><div class="actions">
            <a href="<?= base_url('hrd/User/detail/'.$dd->id) ?>" class="action-btn" title="Lihat detail"><i class="fas fa-eye"></i></a><a href="<?= base_url('hrd/User/update/'.$dd->id) ?>" class="action-btn" title="Edit pengguna"><i class="fas fa-pen"></i></a>
            <a href="#" class="action-btn <?= ($this->session->userdata('role')==7)?'d-none':'' ?>" title="Reset password" data-toggle="modal" data-target="#modal_reset" onclick="getreset('<?= $dd->id ?>')"><i class="fas fa-key"></i></a>
            <?php if($active){ ?><button type="button" data-id="<?= $dd->id ?>" class="action-btn danger btn-nonaktif" title="Nonaktifkan"><i class="fas fa-user-slash"></i></button><?php }else{ ?><button type="button" data-id="<?= $dd->id ?>" class="action-btn success btn-aktif" title="Aktifkan"><i class="fas fa-user-check"></i></button><?php } ?>
            <button type="button" data-id="<?= $dd->id ?>" class="action-btn danger btn_hapus" title="Hapus pengguna"><i class="fas fa-trash-alt"></i></button>
          </div></td>
        </tr>
      <?php endforeach; ?>
    </tbody></table></div>
  </div>
</div></section>

<div class="modal fade user-modal" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="addUserTitle" aria-hidden="true"><div class="modal-dialog modal-xl" role="document"><div class="modal-content">
  <?php echo form_open_multipart('hrd/user/proses_tambah_baru'); ?>
  <div class="modal-header"><div><h4 class="modal-title" id="addUserTitle"><i class="fas fa-user-plus mr-2"></i>Tambah Pengguna</h4><small>Lengkapi profil dan akses akun baru.</small></div><button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span>&times;</span></button></div>
  <div class="modal-body"><div class="row">
    <div class="col-lg-6 mb-3 mb-lg-0"><div class="form-section"><div class="section-label"><i class="far fa-address-card mr-2"></i>Informasi pribadi</div>
      <div class="row"><div class="form-group col-md-7"><label for="nama">Nama lengkap *</label><input type="text" name="nama" class="form-control" id="nama" placeholder="Nama lengkap" required></div><div class="form-group col-md-5"><label for="telp">No. telepon *</label><input type="tel" name="telp" class="form-control" id="telp" placeholder="08xxxxxxxxxx" required></div></div>
      <div class="row"><div class="form-group col-md-6"><label for="nik">NIK KTP *</label><input type="text" inputmode="numeric" name="nik_ktp" class="form-control" id="nik" placeholder="16 digit NIK" minlength="16" maxlength="16" required></div><div class="form-group col-md-6"><label for="email">Email</label><input type="email" name="email" class="form-control" id="email" placeholder="nama@email.com"></div></div>
      <div class="form-group"><label for="alamat">Alamat</label><textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat lengkap"></textarea></div>
      <div class="row"><div class="form-group col-md-5"><label for="id_bank">Bank <span class="spg-required d-none">*</span></label><select name="id_bank" class="form-control select2" id="id_bank"><option value="">Pilih bank</option><?php foreach($list_bank as $bank){ ?><option value="<?= $bank->id ?>"><?= html_escape($bank->nama_bank) ?></option><?php } ?></select></div><div class="form-group col-md-7"><label for="norek">No. rekening <span class="spg-required d-none">*</span></label><input type="text" name="no_rek" id="norek" placeholder="Nomor rekening" class="form-control"></div></div>
    </div></div>
    <div class="col-lg-6"><div class="form-section"><div class="section-label"><i class="fas fa-lock mr-2"></i>Akun &amp; akses</div>
      <div class="form-group"><label for="id_role">Role pengguna *</label><select name="id_role" class="form-control select2" id="id_role" required><option value="">Pilih role</option><?php foreach($list_role as $role_item){ ?><option value="<?= $role_item->id ?>" data-role-name="<?= html_escape(strtoupper(trim($role_item->nama))) ?>"><?= html_escape($role_item->nama) ?></option><?php } ?></select></div>
      <div class="form-group foto_selfie d-none"><div class="row"><div class="col-md-6"><label for="selfie">Foto selfie</label><input type="file" name="selfi" class="form-control" id="selfie" accept="image/png,image/jpeg"><span class="field-note">JPG/PNG, maksimal 2 MB</span></div><div class="col-md-6"><label for="ktp">Foto KTP</label><input type="file" name="ktp" class="form-control" id="ktp" accept="image/png,image/jpeg"><span class="field-note">JPG/PNG, maksimal 2 MB</span></div></div></div>
      <div class="form-group"><label for="username">Username *</label><input type="text" name="username" class="form-control" id="username" autocomplete="off" required placeholder="Username untuk login"></div>
      <div class="row"><div class="form-group col-md-6"><label for="pass">Password *</label><input type="password" name="pass" class="form-control" id="pass" autocomplete="new-password" required placeholder="Password"></div><div class="form-group col-md-6"><label for="konfirm">Konfirmasi password *</label><input type="password" name="konfirm" class="form-control" id="konfirm" autocomplete="new-password" required placeholder="Ulangi password"></div></div>
    </div></div>
  </div></div>
  <div class="modal-footer"><button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save mr-1"></i>Simpan pengguna</button></div><?php echo form_close(); ?>
</div></div></div>

<div class="modal fade user-modal" id="modal_reset" tabindex="-1" role="dialog" aria-labelledby="resetTitle" aria-hidden="true" data-backdrop="static"><form action="<?= base_url('hrd/User/reset') ?>" method="POST"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
  <div class="modal-header"><h5 class="modal-title" id="resetTitle"><i class="fas fa-key mr-2"></i>Reset Password</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div><div class="modal-body"><div class="alert alert-info py-2 small"><i class="fas fa-info-circle mr-1"></i>Password baru akan disamakan dengan username.</div><div class="form-group"><label for="NamaLengkap_r">Nama lengkap</label><input type="text" id="NamaLengkap_r" class="form-control" readonly><input type="hidden" name="id_user" id="id_user_r"></div><div class="form-group mb-0"><label for="username_r">Username</label><input type="text" name="username" id="username_r" class="form-control" readonly></div></div><div class="modal-footer"><button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary btn-sm">Reset password</button></div>
</div></div></form></div>

<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script><script src="<?= base_url('assets/app/js/alert.js') ?>"></script>
<script>
$(function(){
  var table=$('#table_user').DataTable({order:[],responsive:true,lengthChange:false,autoWidth:false,pageLength:10,dom:'rt<"table-footer"ip>',language:{emptyTable:'Belum ada data pengguna',zeroRecords:'Pengguna yang dicari tidak ditemukan',info:'Menampilkan _START_–_END_ dari _TOTAL_ pengguna',infoEmpty:'Menampilkan 0 pengguna',infoFiltered:'(difilter dari _MAX_ pengguna)',paginate:{previous:'<i class="fas fa-chevron-left"></i>',next:'<i class="fas fa-chevron-right"></i>'}},columnDefs:[{targets:5,orderable:false,searchable:false}]});
  $('#userSearch').on('input',function(){table.search(this.value).draw()});
  $('#roleFilter').on('change',function(){table.column(2).search(this.value?'^'+$.fn.dataTable.util.escapeRegex(this.value)+'$':'',true,false).draw()});
  $('#statusFilter').on('change',function(){table.column(3).search(this.value?'^'+$.fn.dataTable.util.escapeRegex(this.value)+'$':'',true,false).draw()});
  $(document).on('click','.btn-aktif,.btn-nonaktif,.btn_hapus',function(e){e.preventDefault();var b=$(this),id=b.data('id'),del=b.hasClass('btn_hapus'),activate=b.hasClass('btn-aktif'),action=del?'menghapus':(activate?'mengaktifkan':'menonaktifkan'),url=del?'<?= base_url('hrd/user/hapus/') ?>':(activate?'<?= base_url('hrd/user/aktif/') ?>':'<?= base_url('hrd/user/nonaktif/') ?>');Swal.fire({title:'Konfirmasi tindakan',text:'Anda yakin ingin '+action+' pengguna ini?',icon:'warning',showCancelButton:true,confirmButtonColor:del?'#dc2626':'#2563eb',cancelButtonColor:'#94a3b8',cancelButtonText:'Batal',confirmButtonText:'Ya, lanjutkan'}).then(function(r){if(r.isConfirmed)window.location.href=url+id})});
  $('#nik').on('input',function(){this.value=this.value.replace(/\D/g,'').slice(0,16)}).on('change',function(){if(this.value.length!==16)return;$.ajax({url:'<?= base_url('hrd/user/cek_nik') ?>',type:'POST',dataType:'JSON',data:{nik:this.value},success:function(d){if(d===true){Swal.fire('NIK sudah digunakan','Periksa kembali NIK yang dimasukkan.','error');$('#nik').val('').focus()}}})});
  $('#username').on('change',function(){ $.ajax({url:'<?= base_url('hrd/user/cek_username') ?>',type:'POST',dataType:'JSON',data:{username:this.value},success:function(d){if(d===true){Swal.fire('Username sudah digunakan','Silakan gunakan username lain.','error');$('#username').val('').focus()}}})});
  $('select[name="id_role"]').on('change',function(){var required=$(this).find(':selected').data('role-name')==='SPG';$('.foto_selfie,.spg-required').toggleClass('d-none',!required);$('#selfie,#ktp,#id_bank,#norek').prop('required',required)}).trigger('change');
});
function getreset(id){$('#NamaLengkap_r,#username_r').val('Memuat...');$.ajax({url:'<?= base_url('hrd/User/getdata') ?>',type:'GET',dataType:'json',data:{id_user:id},success:function(r){if(r&&r.id){$('#id_user_r').val(r.id);$('#NamaLengkap_r').val(r.nama_user);$('#username_r').val(r.username)}},error:function(){$('#modal_reset').modal('hide');Swal.fire('Gagal memuat data','Silakan coba beberapa saat lagi.','error')}})}
</script>
