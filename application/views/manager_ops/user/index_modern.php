<?php
date_default_timezone_set('Asia/Jakarta');
$users = is_array($list_users) ? $list_users : array();
$stats = array('total' => count($users), 'leader' => 0, 'spg' => 0, 'online' => 0);

foreach ($users as $item) {
  $online_at = !empty($item->last_online) ? strtotime($item->last_online) : false;
  $is_online = $online_at !== false && (time() - $online_at) >= 0 && (time() - $online_at) <= 300;
  $stats['leader'] += (int) $item->role === 3 ? 1 : 0;
  $stats['spg'] += (int) $item->role === 4 ? 1 : 0;
  $stats['online'] += $is_online ? 1 : 0;
}
?>

<style>
  .ops-users{--primary:#3157c8;--ink:#172033;--muted:#718096;--line:#e7edf5;padding-bottom:30px;color:var(--ink)}
  .ops-users .user-hero{position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:24px;margin-bottom:20px;padding:27px 30px;color:#fff;background:linear-gradient(120deg,#233f9f 0%,#3157c8 58%,#6384e5 120%);border-radius:20px;box-shadow:0 14px 34px rgba(49,87,200,.22)}
  .ops-users .user-hero:before,.ops-users .user-hero:after{position:absolute;content:'';border:1px solid rgba(255,255,255,.14);border-radius:50%}.ops-users .user-hero:before{top:-115px;right:-30px;width:270px;height:270px}.ops-users .user-hero:after{right:210px;bottom:-100px;width:180px;height:180px}
  .ops-users .hero-copy,.ops-users .hero-summary{position:relative;z-index:1}.ops-users .hero-eyebrow{display:inline-flex;align-items:center;gap:7px;margin-bottom:8px;color:rgba(255,255,255,.76);font-size:11px;font-weight:700;letter-spacing:.09em;text-transform:uppercase}
  .ops-users .user-hero h1{margin:0 0 6px;font-size:27px;font-weight:700;letter-spacing:-.02em}.ops-users .user-hero p{max-width:630px;margin:0;color:rgba(255,255,255,.8);font-size:13px;line-height:1.55}
  .ops-users .hero-summary{min-width:178px;padding:14px 17px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);border-radius:13px;backdrop-filter:blur(6px)}.ops-users .hero-summary span,.ops-users .hero-summary small{display:block;color:rgba(255,255,255,.76)}.ops-users .hero-summary span{font-size:11px;font-weight:600}.ops-users .hero-summary strong{display:block;margin:2px 0;font-size:25px;line-height:1.15}.ops-users .hero-summary small{font-size:10px}
  .ops-users .stat-card{display:flex;min-height:94px;align-items:center;gap:13px;margin-bottom:16px;padding:17px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 5px 16px rgba(34,45,70,.04)}.ops-users .stat-icon{display:flex;width:43px;height:43px;flex:0 0 43px;align-items:center;justify-content:center;color:var(--stat-color);background:var(--stat-soft);border-radius:12px;font-size:16px}.ops-users .stat-value{margin:0;color:#111827;font-size:23px;font-weight:700;line-height:1.1}.ops-users .stat-label{margin:4px 0 0;color:var(--muted);font-size:12px}
  .ops-users .list-card{overflow:hidden;background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 7px 22px rgba(34,45,70,.05)}.ops-users .list-header{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:19px 21px;border-bottom:1px solid var(--line)}.ops-users .list-title{margin:0 0 3px;font-size:16px;font-weight:700}.ops-users .list-subtitle{margin:0;color:var(--muted);font-size:12px}.ops-users .role-filter{width:auto;min-width:150px;height:38px;padding:0 30px 0 11px;color:#475569;background-color:#f8fafc;border-color:var(--line);border-radius:9px;font-size:12px}.ops-users .card-table{padding:0 20px 14px}.ops-users .table-responsive{overflow:visible}
  .ops-users .user-table{width:100%!important;margin-bottom:0!important;font-size:12px}.ops-users .user-table thead th{padding:12px 14px;color:#64748b;background:#f8fafc;border-top:0;border-bottom:1px solid var(--line);font-size:10px;font-weight:700;letter-spacing:.055em;text-transform:uppercase;white-space:nowrap}.ops-users .user-table tbody td{padding:13px 14px;vertical-align:middle;border-top:1px solid #f0f3f8}.ops-users .user-table tbody tr:hover{background:#fbfdff}
  .ops-users .user-profile{display:flex;min-width:220px;align-items:center;gap:11px}.ops-users .avatar-wrap{position:relative;width:44px;height:44px;flex:0 0 44px}.ops-users .user-avatar{width:44px;height:44px;object-fit:cover;border:2px solid #fff;border-radius:12px;box-shadow:0 0 0 1px var(--line)}.ops-users .presence{position:absolute;right:-1px;bottom:-1px;width:11px;height:11px;background:#94a3b8;border:2px solid #fff;border-radius:50%}.ops-users .presence.online{background:#22c55e}.ops-users .user-name{display:block;max-width:220px;overflow:hidden;margin-bottom:3px;color:#1f2937;font-size:13px;font-weight:700;text-overflow:ellipsis;white-space:nowrap}.ops-users .presence-label{color:var(--muted);font-size:11px}.ops-users .presence-label i{margin-right:4px;font-size:7px}.ops-users .presence-label.online{color:#169447}
  .ops-users .contact{display:block;color:#475569;white-space:nowrap}.ops-users .contact i{width:17px;color:#9aa7b8}.ops-users .role-pill,.ops-users .status-pill{display:inline-flex;align-items:center;gap:6px;padding:6px 9px;border-radius:999px;font-size:10px;font-weight:700;white-space:nowrap}.ops-users .role-pill{color:#3157c8;background:#eef2ff}.ops-users .status-pill.active{color:#15803d;background:#ecfdf3}.ops-users .status-pill.inactive{color:#b91c1c;background:#fef2f2}.ops-users .status-pill i{font-size:6px}.ops-users .login-time{display:block;color:#334155;font-weight:600;white-space:nowrap}.ops-users .login-note{display:block;margin-top:3px;color:var(--muted);font-size:10px}
  .ops-users .dataTables_wrapper{padding-top:16px}.ops-users .dataTables_filter input{height:36px;margin-left:8px;padding:5px 10px;background:#f8fafc;border:1px solid var(--line);border-radius:8px;font-size:12px}.ops-users .dataTables_filter label,.ops-users .dataTables_info{color:var(--muted);font-size:11px;font-weight:500}.ops-users .dt-buttons .btn{padding:6px 10px;color:#526070;background:#fff;border-color:var(--line);font-size:11px}.ops-users .dt-buttons .btn:hover{color:var(--primary);background:#f8faff;border-color:#cbd6f4}.ops-users .pagination .page-link{margin:0 2px;color:#64748b;border:0;border-radius:7px;font-size:11px}.ops-users .pagination .page-item.active .page-link{color:#fff;background:var(--primary)}
  @media(max-width:991.98px){.ops-users .table-responsive{overflow-x:auto}.ops-users .user-table{min-width:760px}.ops-users .card-table{padding-right:15px;padding-left:15px}}@media(max-width:767.98px){.ops-users .user-hero{align-items:flex-start;padding:23px 20px;border-radius:16px;flex-direction:column}.ops-users .user-hero h1{font-size:23px}.ops-users .hero-summary{width:100%;min-width:0}.ops-users .list-header{align-items:flex-start;flex-direction:column}.ops-users .role-filter{width:100%}}
</style>

<section class="content ops-users"><div class="container-fluid">
  <header class="user-hero">
    <div class="hero-copy"><span class="hero-eyebrow"><i class="fas fa-users-cog"></i> Tim operasional lapangan</span><h1>Team Leader &amp; SPG</h1><p>Pantau komposisi tim, status kehadiran, dan aktivitas login pengguna lapangan dalam satu tampilan.</p></div>
    <div class="hero-summary"><span>Pengguna aktif</span><strong><?= number_format($stats['total']) ?></strong><small>Team Leader dan SPG</small></div>
  </header>

  <div class="row">
    <?php $cards = array(array('total','users','Total pengguna','#3157c8','#eef2ff'),array('leader','user-tie','Team Leader','#7c3aed','#f5f3ff'),array('spg','user-tag','SPG','#d97706','#fff7ed'),array('online','signal','Sedang online','#16a34a','#ecfdf3')); foreach ($cards as $card) : ?>
      <div class="col-6 col-lg-3"><article class="stat-card" style="--stat-color:<?= $card[3] ?>;--stat-soft:<?= $card[4] ?>"><span class="stat-icon"><i class="fas fa-<?= $card[1] ?>"></i></span><div><p class="stat-value"><?= number_format($stats[$card[0]]) ?></p><p class="stat-label"><?= $card[2] ?></p></div></article></div>
    <?php endforeach; ?>
  </div>

  <div class="list-card">
    <div class="list-header"><div><h2 class="list-title">Daftar pengguna</h2><p class="list-subtitle">Gunakan pencarian atau filter role untuk menemukan anggota tim.</p></div><select id="opsRoleFilter" class="form-control role-filter" aria-label="Filter berdasarkan role"><option value="">Semua role</option><option value="Team Leader">Team Leader</option><option value="SPG">SPG</option></select></div>
    <div class="card-table"><div class="table-responsive"><table id="example1" class="table user-table">
      <thead><tr><th>Pengguna</th><th>Kontak</th><th>Role</th><th>Status akun</th><th>Login terakhir</th></tr></thead>
      <tbody>
        <?php foreach ($users as $dd) :
          $online_at = !empty($dd->last_online) ? strtotime($dd->last_online) : false;
          $is_online = $online_at !== false && (time() - $online_at) >= 0 && (time() - $online_at) <= 300;
          $is_active = (int) $dd->status === 1;
          $role_name = (int) $dd->role === 3 ? 'Team Leader' : ((int) $dd->role === 4 ? 'SPG' : 'Role lainnya');
          $photo = empty($dd->foto_diri) ? base_url('assets/img/user.png') : base_url('assets/img/user/' . rawurlencode($dd->foto_diri));
        ?>
          <tr>
            <td><div class="user-profile"><div class="avatar-wrap"><img class="user-avatar" src="<?= $photo ?>" alt="Foto <?= html_escape($dd->nama_user) ?>" loading="lazy" onerror="this.src='<?= base_url('assets/img/user.png') ?>'"><span class="presence <?= $is_online ? 'online' : '' ?>" aria-hidden="true"></span></div><div><span class="user-name"><?= html_escape($dd->nama_user) ?></span><span class="presence-label <?= $is_online ? 'online' : '' ?>"><i class="fas fa-circle"></i><?= $is_online ? 'Online' : 'Offline' ?></span></div></div></td>
            <td><span class="contact"><i class="fas fa-phone-alt"></i><?= !empty($dd->no_telp) ? html_escape($dd->no_telp) : 'Belum tersedia' ?></span></td>
            <td><span class="role-pill"><i class="fas fa-id-badge"></i><?= $role_name ?></span></td>
            <td><span class="status-pill <?= $is_active ? 'active' : 'inactive' ?>"><i class="fas fa-circle"></i><?= $is_active ? 'Aktif' : 'Tidak aktif' ?></span></td>
            <td><span class="login-time"><?= !empty($dd->last_login) ? login(strtotime($dd->last_login)) : 'Belum pernah login' ?></span><span class="login-note"><?= $is_online ? 'Aktif dalam 5 menit terakhir' : 'Tidak sedang aktif' ?></span></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table></div></div>
  </div>
</div></section>

<script>
window.addEventListener('load',function(){
  if(window.jQuery&&$.fn.DataTable&&$.fn.DataTable.isDataTable('#example1')){
    var table=$('#example1').DataTable();
    $('#opsRoleFilter').on('change',function(){var role=this.value;table.column(2).search(role?'^'+$.fn.dataTable.util.escapeRegex(role)+'$':'',true,false).draw()});
  }
});
</script>
