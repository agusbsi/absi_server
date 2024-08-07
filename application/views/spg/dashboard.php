<style>
  .toko {
    display: flex;
    align-items: flex-start;
    gap: 10px;
  }

  .tombol {
    display: flex;
    justify-content: center;
    gap: 10px;
  }

  .tombol a {
    border-radius: 5px;
    border: 2px solid rgb(0, 123, 255);
    padding: 2px 10px 2px 10px;
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

  /* Grid container untuk area menu */
  .areaMenu {
    display: grid;
    gap: 20px;
    margin-top: 10px;
    margin-bottom: 20px;
  }

  @media (min-width: 992px) {
    .areaMenu {
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
  }

  @media (max-width: 991px) {
    .areaMenu {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  .cardMenu {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    color: #000;
  }

  .cardMenu .notif {
    position: absolute;
    top: 1px;
    right: 5px;
    background-color: #ff0000;
    color: #fff;
    border-radius: 20%;
    padding: 5px 5px 5px 5px;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .cardMenu i {
    font-size: 3rem;
    margin-bottom: 10px;
  }

  .cardMenu:hover {
    box-shadow: 0 8px 16px rgb(0, 123, 255);
  }
</style>
<section class="content">
  Hi, <strong> <?= $this->session->userdata('nama_user') ?>.</strong>
  <div class="card card-primary card-outline mt-3">
    <div class="card-header text-center">
      Toko Terpilih
    </div>
    <div class="card-body">
      <div class="toko">
        <i class="fas fa-store"></i>
        <div class="namaToko">
          <strong><?= $toko_new->nama_toko ?></strong>
          <small><?= $toko_new->alamat ?></small>
        </div>
      </div>
      <hr>
      <div class="tombol">
        <?php if ($jml > 1) { ?>
          <a href="<?= base_url('Login/list_toko') ?>">Ganti <i class="fas fa-exchange-alt"></i></a>
        <?php } ?>
        <a href="<?= base_url('spg/Dashboard/toko_spg/' . $this->session->userdata('id_toko')) ?>">Lihat <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  </div>
  <strong> Menu Utama</strong>
  <div class="areaMenu">
    <a href="<?= base_url('spg/permintaan') ?>" class="cardMenu">
      <i class="fas fa-file-alt"></i>
      <strong>PO Artikel</strong>
    </a>
    <a href="<?= base_url('spg/Penerimaan') ?>" class="cardMenu">
      <?php if ($terima != 0) { ?>
        <div class="notif">
          <?= $terima; ?>
        </div>
      <?php } ?>
      <i class="fas fa-check-circle"></i>
      <strong> Terima PO</strong>
    </a>
    <a href="<?= base_url('spg/penjualan') ?>" class="cardMenu">
      <i class="fas fa-cart-plus"></i>
      <strong>Penjualan</strong>
    </a>
    <a href="<?= base_url('spg/Dashboard/toko_spg/' . $this->session->userdata('id_toko')) ?>" class="cardMenu">
      <i class="fas fa-cube"></i>
      <strong>Stok</strong>
    </a>
    <a href="<?= base_url('spg/retur') ?>" class="cardMenu">
      <i class="fas fa-exchange-alt"></i>
      <strong>Retur Artikel</strong>
    </a>
    <a href="<?= base_url('spg/Mutasi') ?>" class="cardMenu">
      <?php if ($mutasi != 0) { ?>
        <div class="notif">
          <?= $mutasi; ?>
        </div>
      <?php } ?>
      <i class="fas fa-copy"></i>
      <strong>Terima Mutasi</strong>
    </a>
    <a href="<?= base_url('spg/Aset') ?>" class="cardMenu">
      <i class="fas fa-dolly"></i>
      <strong>Update Aset</strong>
    </a>
    <a href="<?= base_url('spg/Stok_opname') ?>" class="cardMenu">
      <i class="fas fa-chart-pie"></i>
      <strong>SO Artikel</strong>
    </a>
  </div>
</section>