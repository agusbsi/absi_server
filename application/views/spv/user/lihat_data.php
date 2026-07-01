<?php
date_default_timezone_set('Asia/Jakarta');
$total_leader = is_array($list_users) ? count($list_users) : 0;
$total_online = 0;
if (!empty($list_users)) foreach ($list_users as $user) {
  if (!empty($user->last_online) && (time() - strtotime($user->last_online)) <= 300) $total_online++;
}
$total_offline = $total_leader - $total_online;
?>
<meta http-equiv="refresh" content="60">
<style>
  .leader-page{--primary:#2563eb;--muted:#64748b;--line:#e2e8f0;color:#0f172a}.leader-page .page-hero{display:flex;align-items:center;justify-content:space-between;padding:25px 27px;margin-bottom:18px;border-radius:19px;color:#fff;background:linear-gradient(125deg,#172554,#1d4ed8 75%,#38bdf8 140%);box-shadow:0 13px 32px rgba(30,64,175,.17)}.leader-page .page-hero h2{margin:0 0 6px;font-size:25px;font-weight:700}.leader-page .page-hero p{margin:0;color:rgba(255,255,255,.78);font-size:12px}.leader-page .refresh-badge{padding:7px 11px;border:1px solid rgba(255,255,255,.25);border-radius:20px;background:rgba(255,255,255,.1);font-size:10px;font-weight:700}
  .leader-page .stat-card{display:flex;align-items:center;height:100%;min-height:88px;padding:16px 18px;border:1px solid var(--line);border-radius:15px;background:#fff;box-shadow:0 4px 16px rgba(15,23,42,.04)}.leader-page .stat-icon{display:flex;width:43px;height:43px;align-items:center;justify-content:center;margin-right:12px;border-radius:12px;color:#2563eb;background:#eff6ff}.leader-page .stat-icon.green{color:#059669;background:#ecfdf5}.leader-page .stat-icon.gray{color:#64748b;background:#f1f5f9}.leader-page .stat-label{display:block;color:var(--muted);font-size:11px;font-weight:600}.leader-page .stat-value{display:block;font-size:21px;line-height:1.2}
  .leader-page .info-note{display:flex;align-items:flex-start;padding:13px 15px;margin:5px 0 18px;border:1px solid #bfdbfe;border-radius:12px;color:#475569;background:#eff6ff;font-size:11px}.leader-page .info-note i{margin:2px 9px 0 0;color:#2563eb}.leader-page .info-note strong{color:#1e3a8a}.leader-page .leader-card{overflow:hidden;border:1px solid var(--line);border-radius:16px;box-shadow:0 5px 18px rgba(15,23,42,.05)}.leader-page .leader-card>.card-header{display:flex;align-items:center;justify-content:space-between;padding:19px 21px;border:0;color:#0f172a;background:#fff}.leader-page .leader-card .card-title{margin:0;font-size:16px;font-weight:700}.leader-page .leader-card>.card-header small{color:var(--muted)}.leader-page .leader-card>.card-body{padding:0 20px 20px}.leader-page .table thead th{padding:13px 11px;border-width:1px 0;border-color:var(--line);color:#475569;background:#f8fafc;font-size:10px;font-weight:700;text-transform:uppercase}.leader-page .table tbody td{padding:14px 11px;border-color:#f1f5f9;vertical-align:middle}.leader-page .user-name{display:block;color:#0f172a;font-size:12px;font-weight:700}.leader-page .username{color:var(--muted);font-size:11px}.leader-page .presence{display:inline-flex;align-items:center;padding:5px 9px;border-radius:20px;font-size:10px;font-weight:700}.leader-page .presence i{margin-right:5px;font-size:7px}.leader-page .presence.online{color:#047857;background:#ecfdf5}.leader-page .presence.offline{color:#475569;background:#f1f5f9}.leader-page .role-badge{padding:5px 8px;border-radius:20px;color:#1d4ed8;background:#eff6ff;font-size:10px;font-weight:700}.leader-page .phone-link{color:#475569;font-size:11px}.leader-page .phone-link:hover{color:#2563eb}.leader-page .last-login{color:var(--muted);font-size:10px;white-space:nowrap}.leader-page .empty-row{padding:38px!important;color:var(--muted);text-align:center}
  @media(max-width:767.98px){.leader-page .page-hero{padding:21px}.leader-page .page-hero h2{font-size:22px}.leader-page .refresh-badge{display:none}.leader-page .stat-card{margin-bottom:12px;height:auto}.leader-page .leader-card>.card-header{align-items:flex-start;flex-direction:column}.leader-page .leader-card>.card-body{padding:0 13px 15px}}
</style>
<section class="content leader-page">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
    
            <div class="page-hero"><div><h2>Team Leader</h2><p>Pantau anggota tim, status kehadiran, dan aktivitas login terakhir.</p></div><span class="refresh-badge"><i class="fas fa-sync-alt mr-1"></i>Refresh otomatis 60 detik</span></div>
            <div class="row">
              <div class="col-4 mb-3"><div class="stat-card"><div class="stat-icon"><i class="fas fa-users"></i></div><div><span class="stat-label">Total Leader</span><strong class="stat-value"><?= number_format($total_leader, 0, ',', '.') ?></strong></div></div></div>
              <div class="col-4 mb-3"><div class="stat-card"><div class="stat-icon green"><i class="fas fa-user-check"></i></div><div><span class="stat-label">Online</span><strong class="stat-value"><?= number_format($total_online, 0, ',', '.') ?></strong></div></div></div>
              <div class="col-4 mb-3"><div class="stat-card"><div class="stat-icon gray"><i class="fas fa-user-clock"></i></div><div><span class="stat-label">Offline</span><strong class="stat-value"><?= number_format($total_offline, 0, ',', '.') ?></strong></div></div></div>
            </div>
            <div class="info-note"><i class="fas fa-info-circle"></i><div><strong>Status online</strong> ditentukan dari aktivitas user dalam lima menit terakhir. Halaman diperbarui otomatis setiap 60 detik.</div></div>
            <div class="card leader-card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list-ul mr-2 text-primary"></i>Daftar Team Leader</h3><small><?= number_format($total_leader, 0, ',', '.') ?> user ditemukan</small>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              
                <div class="table-responsive"><table id="table_user" class="table">
                  <thead>
                    <tr>
                        <th style = "width: 5%">No</th>
                        <th>Nama User</th>
                        <th>username</th>
                        <th>status</th>
                        <th>Role</th>
                        <th>No. Telp</th>
                        <th>Last Login</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($list_users) && is_array($list_users)){ ?>
                    <?php 
                    $no = 0;
                    foreach($list_users as $dd):
                    $no++; ?>
                      <tr>
                        <td><?=$no?></td>
                        <td><span class="user-name"><?= html_escape($dd->nama_user) ?></span></td>
                        <td><span class="username">@<?= html_escape($dd->username) ?></span></td>
                        <td>
                        <?php
                        $login = strtotime($dd->last_online);
                        $hasil = time() - $login;
                        $menit = floor($hasil / 60);
                        if (($menit > 5) or ($dd->last_online == null) )
                        {
                          echo "<span class='presence offline'><i class='fas fa-circle'></i>Offline</span>";
                        }else 
                        {
                          echo "<span class='presence online'><i class='fas fa-circle'></i>Online</span>";
                        }
                     
                        ?>
                        </td>
                        <td>
                        <?php 
                            if($dd->role==3){
                               echo "<span class='role-badge'>Team Leader</span>";
                            }else{
                                echo ""; 
                            }
                            ?>
                          </td>
                        <td><a href="tel:<?= html_escape($dd->no_telp) ?>" class="phone-link"><i class="fas fa-phone-alt mr-1"></i><?= html_escape($dd->no_telp) ?></a></td>
                        <td><span class="last-login"><?= empty($dd->last_login) ? 'Belum pernah login' : format_tanggal1($dd->last_login) ?></span></td>
                       
                        </tr>
                    <?php endforeach;?>
                    <?php } else { ?><tr><td colspan="7" class="empty-row"><i class="fas fa-users fa-2x d-block mb-2"></i>Belum ada Team Leader.</td></tr><?php } ?>
                     
                  </tbody>
                 
                </table></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
  <script>
    $(document).ready(function(){
    
      $('#table_user').DataTable({
          order: [[0, 'asc']],
          responsive: true,
          lengthChange: false,
          autoWidth: false,
      });

    
    })
  </script>

