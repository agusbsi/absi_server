<style>
  .kartu {
    width: 100%;
    height: 100%;
    min-height: 150px;
    background-color: #0069d9;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 10px 20px 10px 20px;
    color: #f4f6f9;
  }

  .notifikasi {
    height: 100%;
    width: 100%;
    background-color: #ffc71f;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 10px 20px 10px 20px;
    margin-top: 10px;
    margin-bottom: 10px;
  }

  .kartu .judul {
    color: #e1e1e1;
    margin-bottom: 10px;
  }

  .toko {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 10px;
  }

  .tombol {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }

  .tombol a {
    border-radius: 15px;
    padding: 2px 20px 2px 20px;
    color: #0069d9;
    background-color: #f4f6f9;
  }

  .tombol a:hover {
    background-color: rgb(0, 123, 255);
    color: white;
  }

  .toko i {
    font-size: 32px;
    margin-top: 7px;
  }

  .tombol i {
    font-size: 12px;
  }

  .namaToko {
    display: flex;
    flex-direction: column;
  }

  /* menu livin */
  .menu-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    padding: 5px;
    background-color: #f7f7f7;
  }

  .menu-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-bottom: 10px;
  }

  .menu-item a {
    position: relative;
  }

  .notif {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: #ed2938;
    color: #fff;
    border-radius: 50%;
    padding: 4px 6px;
    font-size: 0.7rem;
    font-weight: bold;
    line-height: 1;
    text-align: center;
    box-shadow: 0 0 0 2px #fff;
    animation: bounce 1.5s infinite;
  }

  .menu-item i {
    font-size: 30px;
    margin-bottom: 5px;
    color: #007bff;
    padding: 12px 16px;
    background-color: #fff;
    border-radius: 25%;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  }

  .menu-item a:hover i {
    color: #28a745;
  }

  .menu-item span {
    font-size: 12px;
    font-weight: 700;
    color: #333;
  }

  .judul-menu {
    font-size: 18px;
    font-weight: 700;
    color: #333;
    margin: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
</style>
<section class="content">
  <div class="judul-menu">
    Hi, <?= $this->session->userdata('nama_user') ?>.
  </div>
  <div class="kartu">
    <div class="judul">Toko Terpilih</div>
    <div class="toko">
      <i class="fas fa-store"></i>
      <div class="namaToko">
        <strong><?= $toko_new->nama_toko ?></strong>
        <small><?= $toko_new->alamat ?></small>
      </div>
    </div>
    <div class="tombol">
      <?php if ($jml > 1) { ?>
        <a href="<?= base_url('Login/list_toko') ?>">Ganti <i class="fas fa-exchange-alt"></i></a>
      <?php } ?>
      <a href="<?= base_url('spg/Dashboard/toko_spg/' . $this->session->userdata('id_toko')) ?>">Lihat <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>
  <?php if ($bap != 0) { ?>
    <div class="notifikasi">
      <div class="toko">
        <i class="fas fa-exclamation-triangle"></i>
        <div class="namaToko">
          <strong>Peringatan !</strong>
          <small>Kamu memiliki <?= $bap ?> pengiriman yang selisih, segera buat BAP.</small>
        </div>
      </div>
    </div>
  <?php } ?>
  <div class="judul-menu">Menu Utama</div>
  <div class="menu-container">
    <div class="menu-item">
      <a href="<?= base_url('spg/permintaan') ?>"><i class="fas fa-file-alt"></i></a>
      <span>PO</span>
    </div>
    <div class="menu-item">
      <a href="<?= base_url('spg/Penerimaan') ?>">
        <?php if ($terima != 0) { ?>
          <div class="notif">
            <?= $terima; ?>
          </div>
        <?php } ?>
        <i class="fas fa-check-circle"></i>
      </a>
      <span>Terima PO</span>
    </div>
    <div class="menu-item">
      <a href="<?= base_url('spg/penjualan') ?>"><i class="fas fa-cart-plus"></i></a>
      <span>Penjualan</span>
    </div>
    <div class="menu-item">
      <a href="<?= base_url('spg/Dashboard/toko_spg/' . $this->session->userdata('id_toko')) ?>"><i class="fas fa-cube"></i></a>
      <span>Stok</span>
    </div>
    <div class="menu-item">
      <a href="<?= base_url('spg/retur') ?>"><i class="fas fa-exchange-alt"></i></a>
      <span>Retur</span>
    </div>
    <div class="menu-item">
      <a href="<?= base_url('spg/Mutasi') ?>">
        <?php if ($mutasi != 0) { ?>
          <div class="notif">
            <?= $mutasi; ?>
          </div>
        <?php } ?>
        <i class="fas fa-copy"></i>
      </a>
      <span>Terima Mutasi</span>
    </div>
    <div class="menu-item">
      <a href="<?= base_url('spg/Aset') ?>"><i class="fas fa-dolly"></i></a>
      <span>Update ASET</span>
    </div>
    <div class="menu-item">
      <a href="<?= base_url('spg/Stok_opname') ?>"><i class="fas fa-chart-pie"></i></a>
      <span>SO</span>
    </div>
    <div class="menu-item">
      <a href="<?= base_url('spg/Bap') ?>">
        <?php if ($bap != 0) { ?>
          <div class="notif">
            <?= $bap; ?>
          </div>
        <?php } ?>
        <i class="fas fa-envelope"></i>
      </a>
      <span>BAP</span>
    </div>
  </div>

</section>