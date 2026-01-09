<section class="content">
  <div class="container-fluid">
    <!-- Header Section -->
    <div class="page-header">
      <div class="header-icon">
        <i class="fas fa-store"></i>
      </div>
      <div class="header-content">
        <h4>Pengajuan Toko</h4>
        <p>Kelola dan proses pengajuan toko baru</p>
      </div>
    </div>

    <!-- Info Banner -->
    <div class="info-alert">
      <i class="fas fa-info-circle"></i>
      <span>Pengajuan toko baru sekarang hanya melalui sistem ABSI</span>
    </div>

    <!-- Table Card -->
    <div class="data-card">
      <div class="table-responsive">
        <table id="example1" class="data-table">
          <thead>
            <tr>
              <th style="width:45px">No</th>
              <th style="width:130px">No Pengajuan</th>
              <th style="width:100px">Tanggal</th>
              <th>Nama Toko</th>
              <th style="width:120px">Kategori</th>
              <th style="width:100px">Status</th>
              <th style="width:100px" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            foreach ($pengajuan as $t) :
              $no++;
              // Set kategori badge class
              $kategori_class = 'kategori-default';
              if ($t->kategori == 1) $kategori_class = 'kategori-baru';
              else if ($t->kategori == 2) $kategori_class = 'kategori-pindah';
              else if ($t->kategori == 3) $kategori_class = 'kategori-tutup';
            ?>
              <tr>
                <td class="text-center text-muted"><?= $no ?></td>
                <td><code class="code-badge"><?= $t->nomor ?></code></td>
                <td>
                  <div class="date-info">
                    <i class="far fa-calendar"></i>
                    <span><?= date('d M Y', strtotime($t->created_at)) ?></span>
                  </div>
                </td>
                <td>
                  <div class="store-info">
                    <div class="store-name"><?= $t->nama_toko ?></div>
                    <div class="store-address"><?= $t->alamat ?></div>
                  </div>
                </td>
                <td>
                  <span class="badge-kategori <?= $kategori_class ?>">
                    <?= kategori_pengajuan($t->kategori) ?>
                  </span>
                </td>
                <td class="text-center">
                  <?= status_pengajuan($t->status) ?>
                </td>
                <td class="text-center">
                  <?php if ($t->kategori == 3) { ?>
                    <a href="<?= base_url('adm/Toko/toko_tutup_d/' . $t->id) ?>"
                      class="btn-action <?= (($t->status == 3 || $t->status == 6) && $this->session->userdata('role') == 1) ? 'btn-success' : 'btn-primary' ?>">
                      <i class="fas fa-<?= (($t->status == 3 || $t->status == 6) && $this->session->userdata('role') == 1) ? 'check' : 'eye' ?>"></i>
                      <span><?= (($t->status == 3 || $t->status == 6) && $this->session->userdata('role') == 1) ? 'Proses' : 'Detail' ?></span>
                    </a>
                  <?php } else { ?>
                    <a href="<?= base_url('adm/Toko/detail/' . $t->id) ?>"
                      class="btn-action <?= $t->status == 3 && $this->session->userdata('role') == 1 ? 'btn-success' : 'btn-primary' ?>">
                      <i class="fas fa-<?= $t->status == 3 && $this->session->userdata('role') == 1 ? 'check' : 'eye' ?>"></i>
                      <span><?= $t->status == 3 && $this->session->userdata('role') == 1 ? 'Proses' : 'Detail' ?></span>
                    </a>
                  <?php } ?>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<style>
  /* Page Header */
  .page-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
  }

  .header-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
  }

  .header-content h4 {
    font-size: 22px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 4px 0;
    line-height: 1.2;
  }

  .header-content p {
    font-size: 14px;
    color: #64748b;
    margin: 0;
    line-height: 1.4;
  }

  /* Info Alert */
  .info-alert {
    background: linear-gradient(to right, #eff6ff, #f0f9ff);
    border-left: 4px solid #3b82f6;
    padding: 14px 18px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #1e40af;
    font-size: 14px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(59, 130, 246, 0.08);
  }

  .info-alert i {
    font-size: 18px;
    flex-shrink: 0;
  }

  /* Data Card */
  .data-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: 1px solid #e2e8f0;
    padding: 20px;
  }

  /* Data Table */
  .data-table {
    width: 100%;
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
  }

  .data-table thead th {
    background: #f8fafc;
    padding: 12px 14px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #64748b;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
  }

  .data-table tbody td {
    padding: 12px 14px;
    border-bottom: 1px solid #f8fafc;
    font-size: 13px;
    color: #334155;
    vertical-align: middle;
  }

  .data-table tbody tr {
    transition: background-color 0.15s ease;
  }

  .data-table tbody tr:hover {
    background-color: #f9fafb;
  }

  .data-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Code Badge */
  .code-badge {
    background: #f1f5f9;
    padding: 4px 9px;
    border-radius: 5px;
    font-size: 11.5px;
    color: #475569;
    font-weight: 600;
    font-family: 'Courier New', monospace;
  }

  /* Date Info */
  .date-info {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #64748b;
    font-size: 12px;
  }

  .date-info i {
    color: #94a3b8;
    font-size: 11px;
  }

  .date-info span {
    font-weight: 500;
  }

  /* Store Info */
  .store-info {
    line-height: 1.35;
  }

  .store-name {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 3px;
    font-size: 13px;
  }

  .store-address {
    font-size: 11.5px;
    color: #94a3b8;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
  }

  /* Badge Kategori dengan warna berbeda */
  .badge-kategori {
    display: inline-flex;
    align-items: center;
    padding: 4px 11px;
    border-radius: 16px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.3px;
    white-space: nowrap;
  }

  .kategori-baru {
    background: #dbeafe;
    color: #1e40af;
  }

  .kategori-pindah {
    background: #fef3c7;
    color: #92400e;
  }

  .kategori-tutup {
    background: #fee2e2;
    color: #991b1b;
  }

  .kategori-default {
    background: #f1f5f9;
    color: #475569;
  }

  /* Action Button - Modern & Slim */
  .btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
  }

  .btn-action.btn-primary {
    background: #3b82f6;
    color: white;
    box-shadow: 0 1px 2px rgba(59, 130, 246, 0.2);
  }

  .btn-action.btn-primary:hover {
    background: #2563eb;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
    transform: translateY(-1px);
  }

  .btn-action.btn-success {
    background: #10b981;
    color: white;
    box-shadow: 0 1px 2px rgba(16, 185, 129, 0.2);
  }

  .btn-action.btn-success:hover {
    background: #059669;
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
    transform: translateY(-1px);
  }

  .btn-action i {
    font-size: 11px;
  }

  .btn-action span {
    font-size: 12px;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .data-table {
      font-size: 12px;
    }

    .data-table thead th,
    .data-table tbody td {
      padding: 10px 8px;
    }

    .page-header h4 {
      font-size: 18px;
    }

    .btn-action {
      width: 28px;
      height: 28px;
    }
  }
</style>