<?php
date_default_timezone_set('Asia/Jakarta');
$users = is_array($list_users) ? $list_users : array();
$total_users = count($users);
$online_users = 0;
$never_login = 0;
$role_ids = array();
$role_names = array();

if (is_array($list_role)) {
  foreach ($list_role as $role_item) {
    if (isset($role_item->id)) {
      $role_names[(string) $role_item->id] = isset($role_item->nama)
        ? trim((string) $role_item->nama)
        : '';
    }
  }
}

foreach ($users as $user) {
  $login_time = !empty($user->last_login) ? strtotime($user->last_login) : false;
  if ($login_time === false) $never_login++;
  elseif ((time() - $login_time) >= 0 && (time() - $login_time) <= 300) $online_users++;
  if (isset($user->role)) $role_ids[(string) $user->role] = true;
}
$offline_users = $total_users - $online_users;
?>

<style>
  .user-page{--primary:#0f766e;--soft:#ecfdf5;--ink:#172033;--muted:#718096;--line:#e8edf5;padding-bottom:28px;color:var(--ink)}
  .user-page .user-hero{position:relative;display:flex;overflow:hidden;align-items:center;justify-content:space-between;gap:24px;margin-bottom:20px;padding:27px 30px;color:#fff;background:linear-gradient(120deg,#115e59 0%,#0f766e 55%,#14b8a6 135%);border-radius:19px;box-shadow:0 14px 34px rgba(15,118,110,.2)}
  .user-page .user-hero:before,.user-page .user-hero:after{position:absolute;content:'';border:1px solid rgba(255,255,255,.15);border-radius:50%}.user-page .user-hero:before{top:-110px;right:-45px;width:255px;height:255px}.user-page .user-hero:after{right:175px;bottom:-110px;width:190px;height:190px}
  .user-page .hero-copy,.user-page .hero-insight{position:relative;z-index:1}.user-page .hero-eyebrow{display:block;margin-bottom:8px;color:rgba(255,255,255,.78);font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase}.user-page .user-hero h1{margin:0 0 7px;font-size:27px;font-weight:700;letter-spacing:-.02em}.user-page .user-hero p{max-width:620px;margin:0;color:rgba(255,255,255,.82);font-size:14px}
  .user-page .hero-insight{display:flex;min-width:205px;align-items:center;gap:12px;padding:13px 15px;background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.17);border-radius:13px;backdrop-filter:blur(7px)}.user-page .hero-insight>i{font-size:22px}.user-page .hero-insight span,.user-page .hero-insight small{display:block;color:rgba(255,255,255,.76);font-size:10px}.user-page .hero-insight strong{display:block;margin:1px 0;font-size:20px;line-height:1.1}
  .user-page .stat-card{display:flex;min-height:91px;align-items:center;gap:13px;margin-bottom:18px;padding:16px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 5px 16px rgba(34,45,70,.04)}.user-page .stat-icon{display:flex;width:43px;height:43px;flex:0 0 43px;align-items:center;justify-content:center;color:var(--color);background:var(--stat-soft);border-radius:12px;font-size:16px}.user-page .stat-value{margin:0;color:#111827;font-size:22px;font-weight:700;line-height:1.1}.user-page .stat-label{margin:4px 0 0;color:var(--muted);font-size:11px}
  .user-page .list-card{overflow:hidden;background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 7px 22px rgba(34,45,70,.05)}.user-page .list-header{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:19px 21px;border-bottom:1px solid var(--line)}.user-page .list-title{margin:0 0 3px;font-size:16px;font-weight:700}.user-page .list-subtitle{margin:0;color:var(--muted);font-size:12px}.user-page .toolbar{display:flex;align-items:center;gap:8px}.user-page .search-box{position:relative;width:280px}.user-page .search-box i{position:absolute;top:50%;left:13px;color:#9aa7b8;font-size:12px;transform:translateY(-50%)}.user-page .search-box input{height:39px;padding-left:36px;background:#f8fafc;border:1px solid var(--line);border-radius:9px;font-size:12px}.user-page .search-box input:focus{background:#fff;border-color:#5eead4;box-shadow:0 0 0 3px rgba(20,184,166,.09)}.user-page .export-tools .btn{height:39px;color:#526070;background:#fff;border:1px solid var(--line);border-radius:8px;font-size:11px}.user-page .export-tools .btn:hover{color:var(--primary);background:var(--soft);border-color:#99f6e4}
  .user-page .table-responsive{overflow:visible}.user-page .user-table{width:100%!important;margin:0!important;font-size:12px}.user-page .user-table thead th{padding:12px 15px;color:#64748b;background:#f8fafc;border-top:0;border-bottom:1px solid var(--line);font-size:10px;font-weight:700;letter-spacing:.055em;text-transform:uppercase;white-space:nowrap}.user-page .user-table tbody td{padding:14px 15px;vertical-align:middle;border-top:1px solid #f0f3f8}.user-page .user-table tbody tr:hover{background:#fbfefd}
  .user-page .user-info{display:flex;min-width:225px;align-items:center;gap:11px}.user-page .user-avatar{display:flex;width:42px;height:42px;flex:0 0 42px;align-items:center;justify-content:center;color:#0f766e;background:#ccfbf1;border-radius:12px;font-size:14px;font-weight:800}.user-page .user-name{display:block;max-width:230px;overflow:hidden;margin-bottom:3px;color:#1f2937;font-size:13px;font-weight:700;text-overflow:ellipsis;white-space:nowrap}.user-page .username{display:block;color:#718096;font-size:10px}.user-page .username i{width:15px;color:#a0aec0;font-size:9px}
  .user-page .role-badge{display:inline-flex;align-items:center;gap:6px;padding:7px 10px;color:#475569;background:#f1f5f9;border-radius:999px;font-size:11px;font-weight:700;white-space:nowrap}.user-page .role-badge i{color:#94a3b8;font-size:9px}.user-page .phone{color:#475569;white-space:nowrap}.user-page .phone i{margin-right:7px;color:#94a3b8;font-size:10px}.user-page .status-badge{display:inline-flex;align-items:center;gap:7px;padding:7px 10px;border-radius:999px;font-size:10px;font-weight:700}.user-page .status-badge i{font-size:7px}.user-page .status-badge.online{color:#047857;background:#ecfdf5}.user-page .status-badge.offline{color:#64748b;background:#f1f5f9}.user-page .login-time{display:block;color:#334155;font-size:11px;font-weight:600;white-space:nowrap}.user-page .login-hint{display:block;margin-top:3px;color:#94a3b8;font-size:10px}
  .user-page .dataTables_wrapper>.row:first-child{display:none}.user-page .dataTables_wrapper>.row:last-child{align-items:center;margin:0;padding:13px 19px;border-top:1px solid var(--line)}.user-page .dataTables_info,.user-page .dataTables_paginate{padding-top:0!important;color:var(--muted);font-size:11px}.user-page .pagination .page-link{margin:0 2px;color:#64748b;border:0;border-radius:7px;font-size:11px}.user-page .pagination .page-item.active .page-link{color:#fff;background:var(--primary)}.user-page .dataTables_empty{height:150px;color:var(--muted)!important;text-align:center}
  @media(max-width:991.98px){.user-page .list-header{align-items:flex-start;flex-direction:column}.user-page .toolbar,.user-page .search-box{width:100%}.user-page .search-box{flex:1}.user-page .table-responsive{overflow-x:auto}}
  @media(max-width:575.98px){.user-page .user-hero{align-items:flex-start;padding:22px;flex-direction:column}.user-page .user-hero h1{font-size:22px}.user-page .hero-insight{width:100%;min-width:0}.user-page .list-header{padding:17px}.user-page .stat-card{min-height:84px;padding:13px}.user-page .stat-value{font-size:19px}.user-page .toolbar{align-items:stretch;flex-direction:column}.user-page .export-tools{display:flex}.user-page .export-tools .btn{flex:1}}
</style>

<section class="content user-page"><div class="container-fluid">
  <div class="user-hero"><div class="hero-copy"><span class="hero-eyebrow"><i class="fas fa-users-cog mr-1"></i> Monitoring akses tim</span><h1>Data User</h1><p>Pantau akun, peran, kontak, dan aktivitas login seluruh pengguna dalam satu tampilan.</p></div><div class="hero-insight"><i class="fas fa-signal"></i><div><span>Status saat ini</span><strong><?= number_format($online_users) ?> online</strong><small>dari <?= number_format($total_users) ?> user terdaftar</small></div></div></div>
  <div class="row">
    <?php $cards=array(array($total_users,'users','Total user','#0f766e','#ecfdf5'),array($online_users,'wifi','Sedang online','#16a34a','#f0fdf4'),array($offline_users,'user-clock','Sedang offline','#64748b','#f1f5f9'),array($never_login,'user-shield','Belum pernah login','#d97706','#fffbeb')); foreach($cards as $card): ?>
      <div class="col-6 col-lg-3"><div class="stat-card" style="--color:<?= $card[3] ?>;--stat-soft:<?= $card[4] ?>"><span class="stat-icon"><i class="fas fa-<?= $card[1] ?>"></i></span><div><p class="stat-value"><?= number_format($card[0]) ?></p><p class="stat-label"><?= $card[2] ?></p></div></div></div>
    <?php endforeach; ?>
  </div>
  <div class="list-card"><div class="list-header"><div><h2 class="list-title">Daftar pengguna</h2><p class="list-subtitle"><?= number_format(count($role_ids)) ?> role terdaftar &bull; status online berdasarkan aktivitas 5 menit terakhir.</p></div><div class="toolbar"><div class="search-box"><i class="fas fa-search"></i><input type="search" id="userSearch" class="form-control" placeholder="Cari nama, username, role..." aria-label="Cari pengguna"></div><div id="userExport" class="export-tools"></div></div></div>
    <div class="table-responsive"><table id="userTable" class="table user-table"><thead><tr><th style="width:55px">No.</th><th>Pengguna</th><th>Role</th><th>Kontak</th><th>Status</th><th>Login terakhir</th></tr></thead><tbody>
      <?php foreach($users as $index=>$user): $name=trim((string)($user->nama_user??'')); $username=trim((string)($user->username??'')); $phone=trim((string)($user->no_telp??'')); $role_id=(string)($user->role??''); $role_name=isset($role_names[$role_id])&&$role_names[$role_id]!==''?$role_names[$role_id]:'Role tidak diketahui'; $last_login=!empty($user->last_login)?strtotime($user->last_login):false; $login_age=$last_login!==false?time()-$last_login:null; $is_online=$login_age!==null&&$login_age>=0&&$login_age<=300; $initial=$name!==''?strtoupper(substr($name,0,1)):'U'; ?>
        <tr><td class="text-center text-muted"><?= $index+1 ?></td><td><div class="user-info"><span class="user-avatar"><?= html_escape($initial) ?></span><div><span class="user-name"><?= html_escape($name!==''?$name:'Tanpa nama') ?></span><span class="username"><i class="fas fa-at"></i><?= html_escape($username!==''?$username:'Username belum tersedia') ?></span></div></div></td><td><span class="role-badge"><i class="fas fa-shield-alt"></i><?= html_escape($role_name) ?></span></td><td><span class="phone"><i class="fas fa-phone-alt"></i><?= html_escape($phone!==''?$phone:'Belum tersedia') ?></span></td><td data-order="<?= $is_online?1:0 ?>"><span class="status-badge <?= $is_online?'online':'offline' ?>"><i class="fas fa-circle"></i><?= $is_online?'Online':'Offline' ?></span></td><td data-order="<?= $last_login!==false?$last_login:0 ?>"><?php if($last_login!==false): ?><span class="login-time"><?= html_escape(login($last_login)) ?></span><span class="login-hint"><?= date('d M Y, H:i',$last_login) ?> WIB</span><?php else: ?><span class="login-time text-muted">Belum pernah login</span><span class="login-hint">Tidak ada aktivitas</span><?php endif; ?></td></tr>
      <?php endforeach; ?>
    </tbody></table></div>
  </div>
</div></section>

<script>
  $(function() {
    var userTable = $('#userTable').DataTable({
      order: [[0, 'asc']],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      pageLength: 10,
      dom: 'Brt<"row align-items-center"<"col-sm-6"i><"col-sm-6"p>>',
      buttons: [
        { extend: 'excel', text: '<i class="fas fa-file-excel mr-1"></i> Excel', titleAttr: 'Ekspor Excel' },
        { extend: 'print', text: '<i class="fas fa-print"></i>', titleAttr: 'Cetak data' }
      ],
      language: {
        emptyTable: 'Belum ada data pengguna',
        zeroRecords: 'Pengguna yang dicari tidak ditemukan',
        info: 'Menampilkan _START_-_END_ dari _TOTAL_ pengguna',
        infoEmpty: 'Menampilkan 0 pengguna',
        infoFiltered: '(difilter dari _MAX_ pengguna)',
        paginate: { previous: '<i class="fas fa-chevron-left"></i>', next: '<i class="fas fa-chevron-right"></i>' }
      }
    });
    userTable.buttons().container().appendTo('#userExport');
    $('#userSearch').on('input', function() { userTable.search(this.value).draw(); });
  });
</script>
