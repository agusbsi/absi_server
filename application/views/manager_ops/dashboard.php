<?php
$nama_user = html_escape($this->session->userdata('nama_user'));
$is_manager = (string) $this->session->userdata('role') === '17';
$bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
$periode = $bulan[(int) date('n') - 1] . ' ' . date('Y');
$total_minta = (int) ($t_minta->total ?? 0);
$total_kirim = (int) ($t_kirim->total ?? 0);
$total_jual = (int) ($t_jual->total ?? 0);
$total_retur = (int) ($t_retur->total ?? 0);
$total_aktivitas = $total_minta + $total_kirim + $total_jual + $total_retur;
$nilai_tertinggi = max($total_minta, $total_kirim, $total_jual, $total_retur, 1);
$aktivitas = array(
  array('label' => 'Permintaan', 'desc' => 'Artikel diajukan', 'value' => $total_minta, 'icon' => 'fas fa-clipboard-list', 'color' => '#d97706', 'soft' => '#fff7ed'),
  array('label' => 'Pengiriman', 'desc' => 'Artikel dikirim', 'value' => $total_kirim, 'icon' => 'fas fa-truck', 'color' => '#0284c7', 'soft' => '#f0f9ff'),
  array('label' => 'Penjualan', 'desc' => 'Artikel terjual', 'value' => $total_jual, 'icon' => 'fas fa-shopping-bag', 'color' => '#16a34a', 'soft' => '#f0fdf4'),
  array('label' => 'Retur', 'desc' => 'Artikel diretur', 'value' => $total_retur, 'icon' => 'fas fa-undo-alt', 'color' => '#dc2626', 'soft' => '#fef2f2')
);
?>

<style>
  .ops-dashboard { --primary:#3157c8; --ink:#172033; --muted:#718096; --line:#e8edf5; padding-bottom:30px; color:var(--ink); }
  .ops-dashboard .dashboard-hero { position:relative; overflow:hidden; padding:30px 32px; color:#fff; background:linear-gradient(120deg,#233f9f 0%,#3157c8 55%,#6384e5 120%); border-radius:20px; box-shadow:0 14px 34px rgba(49,87,200,.22); }
  .ops-dashboard .dashboard-hero::before,.ops-dashboard .dashboard-hero::after { position:absolute; content:''; border:1px solid rgba(255,255,255,.14); border-radius:50%; }
  .ops-dashboard .dashboard-hero::before { top:-130px; right:-50px; width:300px; height:300px; }
  .ops-dashboard .dashboard-hero::after { right:180px; bottom:-125px; width:220px; height:220px; }
  .ops-dashboard .hero-content { position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between; gap:28px; }
  .ops-dashboard .hero-eyebrow { display:inline-flex; align-items:center; gap:8px; margin-bottom:10px; color:rgba(255,255,255,.78); font-size:12px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; }
  .ops-dashboard .dashboard-hero h1 { margin:0 0 8px; font-size:28px; font-weight:700; letter-spacing:-.02em; }
  .ops-dashboard .dashboard-hero p { max-width:630px; margin:0; color:rgba(255,255,255,.8); font-size:14px; line-height:1.6; }
  .ops-dashboard .hero-summary { min-width:220px; padding:16px 18px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.18); border-radius:14px; backdrop-filter:blur(6px); }
  .ops-dashboard .hero-summary span,.ops-dashboard .hero-summary small { display:block; color:rgba(255,255,255,.76); }
  .ops-dashboard .hero-summary span { font-size:12px; font-weight:600; }
  .ops-dashboard .hero-summary strong { display:block; margin:3px 0 2px; font-size:27px; line-height:1.15; }
  .ops-dashboard .hero-summary small { font-size:11px; }
  .ops-dashboard .section-heading { display:flex; align-items:flex-end; justify-content:space-between; gap:16px; margin:28px 0 14px; }
  .ops-dashboard .section-heading h2 { margin:0 0 3px; font-size:18px; font-weight:700; }
  .ops-dashboard .section-heading p { margin:0; color:var(--muted); font-size:13px; }
  .ops-dashboard .section-pill { flex:0 0 auto; padding:7px 11px; color:#526070; background:#fff; border:1px solid var(--line); border-radius:999px; font-size:12px; font-weight:600; }
  .ops-dashboard .section-pill i { margin-right:5px; color:var(--primary); }
  .ops-dashboard .overview-card,.ops-dashboard .activity-card { height:calc(100% - 16px); margin-bottom:16px; background:#fff; border:1px solid var(--line); border-radius:16px; box-shadow:0 5px 18px rgba(34,45,70,.045); }
  .ops-dashboard .overview-card { position:relative; display:flex; min-height:132px; flex-direction:column; padding:18px; transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease; }
  .ops-dashboard .overview-card:hover { border-color:#cbd6f4; box-shadow:0 11px 25px rgba(34,45,70,.085); transform:translateY(-2px); }
  .ops-dashboard .overview-icon,.ops-dashboard .activity-icon { display:inline-flex; width:42px; height:42px; align-items:center; justify-content:center; border-radius:12px; }
  .ops-dashboard .overview-icon { margin-bottom:14px; color:var(--primary); background:#eef2ff; font-size:17px; }
  .ops-dashboard .overview-value { margin:0; color:#111827; font-size:25px; font-weight:700; line-height:1; }
  .ops-dashboard .overview-label { margin:7px 38px 0 0; color:var(--muted); font-size:13px; line-height:1.3; }
  .ops-dashboard .overview-link { position:absolute; top:18px; right:18px; display:inline-flex; width:31px; height:31px; align-items:center; justify-content:center; color:#91a1b3; background:#f7f9fc; border-radius:50%; transition:.18s ease; }
  .ops-dashboard .overview-link:hover { color:#fff; background:var(--primary); }
  .ops-dashboard .activity-card { position:relative; overflow:hidden; min-height:154px; padding:19px; }
  .ops-dashboard .activity-card::after { position:absolute; right:-30px; bottom:-40px; width:105px; height:105px; content:''; background:var(--activity-soft); border-radius:50%; }
  .ops-dashboard .activity-top { display:flex; align-items:center; gap:12px; margin-bottom:15px; }
  .ops-dashboard .activity-icon { color:var(--activity-color); background:var(--activity-soft); }
  .ops-dashboard .activity-label { margin:0 0 2px; color:#253047; font-size:13px; font-weight:700; }
  .ops-dashboard .activity-description { display:block; color:var(--muted); font-size:11px; }
  .ops-dashboard .activity-value { position:relative; z-index:1; margin:0 0 12px; color:#111827; font-size:24px; font-weight:700; }
  .ops-dashboard .activity-value small { color:var(--muted); font-size:12px; font-weight:500; }
  .ops-dashboard .activity-progress { position:relative; z-index:1; overflow:hidden; height:5px; background:#edf1f6; border-radius:999px; }
  .ops-dashboard .activity-progress span { display:block; height:100%; min-width:3px; background:var(--activity-color); border-radius:inherit; }
  .ops-dashboard .dashboard-note { display:flex; align-items:flex-start; gap:12px; margin-top:4px; padding:15px 17px; color:#526070; background:#f8faff; border:1px solid #e4eafd; border-radius:13px; font-size:12px; line-height:1.55; }
  .ops-dashboard .dashboard-note i { margin-top:2px; color:var(--primary); font-size:15px; }
  @media (max-width:767.98px) { .ops-dashboard .dashboard-hero{padding:23px 20px;border-radius:16px}.ops-dashboard .hero-content{align-items:flex-start;flex-direction:column}.ops-dashboard .dashboard-hero h1{font-size:23px}.ops-dashboard .hero-summary{width:100%;min-width:0}.ops-dashboard .section-heading{align-items:flex-start;flex-direction:column;gap:8px} }
  @media (prefers-reduced-motion:reduce) { .ops-dashboard .overview-card,.ops-dashboard .overview-link{transition:none} }
</style>

<section class="content ops-dashboard">
  <div class="container-fluid">
    <header class="dashboard-hero">
      <div class="hero-content">
        <div>
          <span class="hero-eyebrow"><i class="fas fa-chart-line"></i> Dashboard <?= $is_manager ? 'Manager' : 'Staff' ?> Operasional</span>
          <h1>Selamat datang, <?= $nama_user ?>!</h1>
          <p>Pantau data toko, persediaan, dan aktivitas transaksi operasional dalam satu tampilan yang ringkas.</p>
        </div>
        <div class="hero-summary">
          <span>Total aktivitas bulan ini</span>
          <strong><?= number_format($total_aktivitas) ?></strong>
          <small>artikel diproses &bull; <?= $periode ?></small>
        </div>
      </div>
    </header>

    <div class="section-heading">
      <div>
        <h2>Ringkasan operasional</h2>
        <p>Informasi utama jaringan toko, pengguna, aset, dan posisi stok terkini.</p>
      </div>
      <span class="section-pill"><i class="fas fa-sync-alt"></i> Data saat ini</span>
    </div>

    <div class="row">
      <?php foreach ($box as $info_box) :
        $total_box = (int) ($info_box->total ?? 0);
        $url_box = base_url(strtolower(ltrim($info_box->link, '/')));
      ?>
        <div class="col-xl-3 col-lg-4 col-md-6">
          <article class="overview-card">
            <span class="overview-icon"><i class="<?= html_escape($info_box->icon) ?>"></i></span>
            <h3 class="overview-value"><?= number_format($total_box) ?></h3>
            <p class="overview-label"><?= html_escape($info_box->title) ?></p>
            <a href="<?= $url_box ?>" class="overview-link" aria-label="Lihat data <?= html_escape($info_box->title) ?>" title="Lihat data">
              <i class="fas fa-arrow-right"></i>
            </a>
          </article>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="section-heading">
      <div>
        <h2>Aktivitas bulan ini</h2>
        <p>Jumlah artikel pada setiap tahapan alur transaksi operasional.</p>
      </div>
      <span class="section-pill"><i class="far fa-calendar-alt"></i> <?= $periode ?></span>
    </div>

    <div class="row">
      <?php foreach ($aktivitas as $item) :
        $persentase = round(($item['value'] / $nilai_tertinggi) * 100);
      ?>
        <div class="col-xl-3 col-md-6">
          <article class="activity-card" style="--activity-color:<?= $item['color'] ?>;--activity-soft:<?= $item['soft'] ?>">
            <div class="activity-top">
              <span class="activity-icon"><i class="<?= $item['icon'] ?>"></i></span>
              <div>
                <p class="activity-label"><?= $item['label'] ?></p>
                <span class="activity-description"><?= $item['desc'] ?></span>
              </div>
            </div>
            <p class="activity-value"><?= number_format($item['value']) ?> <small>artikel</small></p>
            <div class="activity-progress" title="Perbandingan dengan aktivitas tertinggi bulan ini">
              <span style="width:<?= $persentase ?>%"></span>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="dashboard-note">
      <i class="fas fa-info-circle"></i>
      <span>Angka transaksi dihitung berdasarkan data pada bulan berjalan. Gunakan kartu ringkasan di atas untuk membuka data terkait secara langsung.</span>
    </div>
  </div>
</section>
