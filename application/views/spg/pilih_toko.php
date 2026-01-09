<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ABSI | Pilih Toko</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
      background: #f0f4f8;
      min-height: 100vh;
    }

    /* Header */
    .app-header {
      background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
      padding: 0;
      box-shadow: 0 2px 20px rgba(37, 99, 235, 0.2);
    }

    .header-container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 20px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .brand-icon {
      width: 48px;
      height: 48px;
      background: white;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .brand-icon i {
      font-size: 22px;
      color: #2563eb;
    }

    .brand-info h1 {
      font-size: 26px;
      font-weight: 800;
      color: white;
      line-height: 1;
      margin-bottom: 4px;
      letter-spacing: -0.5px;
    }

    .brand-info p {
      font-size: 11px;
      color: rgba(255, 255, 255, 0.8);
      font-weight: 600;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .user-badge {
      display: flex;
      align-items: center;
      gap: 10px;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      padding: 8px 16px;
      border-radius: 50px;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .user-avatar {
      width: 32px;
      height: 32px;
      background: black;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #2563eb;
      font-weight: 700;
      font-size: 13px;
    }

    .user-name {
      color: black;
      font-weight: 600;
      font-size: 14px;
    }

    /* Main Content */
    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 40px 30px;
    }

    .page-header {
      background: white;
      padding: 28px 32px;
      border-radius: 16px;
      margin-bottom: 32px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      border-top: 4px solid #2563eb;
    }

    .page-title {
      font-size: 28px;
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .page-title i {
      color: #2563eb;
      font-size: 26px;
    }

    .page-subtitle {
      font-size: 15px;
      color: #64748b;
      line-height: 1.6;
    }

    .badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #2563eb;
      color: white;
      padding: 4px 12px;
      border-radius: 20px;
      font-weight: 700;
      font-size: 13px;
      box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
    }

    .badge i {
      font-size: 12px;
    }

    /* Store Grid */
    .store-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
      gap: 14px;
      max-width: 100%;
    }

    .store-card {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid #e2e8f0;
      transition: all 0.3s ease;
      position: relative;
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .store-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 32px rgba(37, 99, 235, 0.15);
      border-color: #2563eb;
    }

    .store-header {
      padding: 28px 28px 24px 28px;
      border-bottom: 1px solid #f1f5f9;
      flex-grow: 1;
    }

    .store-icon {
      width: 56px;
      height: 56px;
      background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;
      border: 2px solid #93c5fd;
    }

    .store-icon i {
      font-size: 24px;
      color: #2563eb;
    }

    .store-name {
      font-size: 19px;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 12px;
      line-height: 1.4;
      letter-spacing: -0.3px;
      word-break: break-word;
      min-height: 54px;
      display: flex;
      align-items: flex-start;
    }

    .store-location {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      font-size: 14px;
      color: #64748b;
      line-height: 1.6;
      min-height: 42px;
    }

    .store-location i {
      color: #94a3b8;
      font-size: 14px;
      margin-top: 3px;
      flex-shrink: 0;
      width: 16px;
    }

    .store-footer {
      padding: 18px 28px;
      background: #f8fafc;
    }

    .btn-select {
      width: 100%;
      padding: 12px 20px;
      background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 700;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all 0.3s ease;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .btn-select:hover {
      background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%);
      box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
      transform: translateY(-1px);
      color: white;
      text-decoration: none;
    }

    .btn-select i {
      font-size: 14px;
      transition: transform 0.3s ease;
    }

    .btn-select:hover i {
      transform: translateX(3px);
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 80px 20px;
      background: white;
      border-radius: 16px;
      border: 1px solid #e2e8f0;
    }

    .empty-state i {
      font-size: 64px;
      color: #cbd5e0;
      margin-bottom: 20px;
    }

    .empty-state h3 {
      font-size: 20px;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 8px;
    }

    .empty-state p {
      font-size: 15px;
      color: #64748b;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .header-container {
        flex-direction: column;
        gap: 16px;
        align-items: stretch;
        padding: 16px 20px;
      }

      .user-badge {
        justify-content: space-between;
      }

      .brand-info h1 {
        font-size: 22px;
      }

      .brand-icon {
        width: 44px;
        height: 44px;
      }

      .brand-icon i {
        font-size: 20px;
      }

      .container {
        padding: 24px 20px;
      }

      .page-header {
        padding: 24px 20px;
      }

      .page-title {
        font-size: 22px;
        flex-wrap: wrap;
      }

      .page-subtitle {
        font-size: 14px;
      }

      .store-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }
    }

    @media (min-width: 768px) and (max-width: 1024px) {
      .store-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 480px) {
      .brand-info h1 {
        font-size: 20px;
      }

      .page-title {
        font-size: 20px;
      }

      .badge {
        font-size: 12px;
        padding: 3px 10px;
      }

      .user-name {
        font-size: 13px;
      }
    }
  </style>
</head>

<body>
  <?php if ($this->session->flashdata('type')) { ?>
    <script>
      Swal.fire({
        title: "<?= $this->session->flashdata('title'); ?>",
        text: "<?= $this->session->flashdata('text'); ?>",
        icon: "<?= $this->session->flashdata('type'); ?>",
        confirmButtonColor: '#2563eb'
      });
    </script>
  <?php } ?>

  <!-- Header -->
  <header class="app-header">
    <div class="header-container">
      <div class="brand">
        <div class="brand-info">
          <h1>ABSI</h1>
          <p>Aplikasi Manajemen Konsinyasi </p>
        </div>
      </div>

    </div>
  </header>

  <!-- Main Content -->
  <main class="container">
    <div class="page-header">
      <h2 class="page-title">
        Selamat Datang, <span><?= ucwords($nama_spg) ?></span>
      </h2>
      <p class="page-subtitle">
        Saat ini Anda terdaftar di <span class="badge"> <?= $jumlah_toko ?> Toko</span>. Silakan pilih toko yang ingin Anda kelola untuk melanjutkan ke dashboard.
      </p>
    </div>

    <?php if (!empty($list_toko)) { ?>
      <div class="store-grid">
        <?php foreach ($list_toko as $row) { ?>
          <div class="store-card">
            <div class="store-header">
              <div class="store-icon">
                <i class="fas fa-store"></i>
              </div>
              <h3 class="store-name"><?= $row->nama_toko ?></h3>
              <div class="store-location">
                <i class="fas fa-map-marker-alt"></i>
                <span><?= $row->alamat ?></span>
              </div>
            </div>
            <div class="store-footer">
              <a href="<?= base_url('login/pilih_toko_act/') . $row->id_toko ?>" class="btn-select">
                Masuk ke Toko Ini
                <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        <?php } ?>
      </div>
    <?php } else { ?>
      <div class="empty-state">
        <i class="fas fa-store-slash"></i>
        <h3>Belum Ada Toko Terdaftar</h3>
        <p>Akun Anda belum memiliki akses ke toko manapun. Silakan hubungi administrator untuk pendaftaran toko.</p>
      </div>
    <?php } ?>
  </main>

  <!-- Scripts -->
  <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>/assets/dist/js/adminlte.min.js"></script>
</body>

</html>