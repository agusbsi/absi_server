<style>
  .status-icon {
    font-size: 10px;
  }

  .online {
    border-color: green;
    border: 3px solid green;
    /* Include border style and color */
  }

  .img-circle {
    width: 100px;
    /* Initial size */
    height: 100px;
    /* Initial size */
    transition: transform 0.3s ease-in-out;
    /* Smooth transition */
  }

  .img-circle:hover {
    transform: scale(5.5);
    /* Scale up the image */
  }
</style>
<meta http-equiv="refresh" content="60">
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">
              <li class="fas fa-users"></li> List SPG
            </h3>
            <div class="card-tools">
              <a href="<?= base_url('leader/Dashboard') ?>" type="button" class="btn btn-tool">
                <i class="fas fa-times"></i>
              </a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th style="width: 3%">No</th>
                  <th>Nama Lengkap</th>
                  <th>username</th>
                  <th>Status</th>
                  <th>Last Login</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($list_users as $dd) :
                  $no++;
                  date_default_timezone_set('Asia/Jakarta');
                  $login = strtotime($dd->last_online);
                  $waktu = strtotime(date("Y-m-d h:i:sa"));
                  $hasil = $waktu - $login;
                  $menit = floor($hasil / 60); ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td>
                      <div class="user-block">
                        <?php if ($dd->foto_diri == null) { ?>
                          <img class="img-circle  <?= (($menit > 5) or ($dd->last_online == null)) ? '' : 'online' ?>" src="<?= base_url('assets/img/user.png') ?>">
                        <?php } else { ?>
                          <img class="img-circle  <?= (($menit > 5) or ($dd->last_online == null)) ? '' : 'online' ?>" src="<?= base_url('assets/img/user/') . $dd->foto_diri ?>">
                        <?php } ?>
                        <span class="username">
                          <?= $dd->nama_user ?>
                        </span>
                        <span class="description">Telp : <?= $dd->no_telp; ?></span>
                        <span class="description">
                          <?php
                          if (($menit > 5) or ($dd->last_online == null)) {
                            echo "<i class='fas fa-circle status-icon' style='color: grey;'></i> Offline";
                          } else {
                            echo "<i class='fas fa-circle status-icon' style='color: green;'></i> Online";
                          }

                          ?>
                        </span>
                      </div>
                    </td>
                    <td class="text-center"><?= $dd->username ?></td>
                    <td class="text-center">
                      <?php
                      if ($dd->status == 0) {
                        echo " <span class='badge badge-secondary'>Tidak Aktif</span>";
                      } else {
                        echo " <span class='badge badge-success'>Aktif</span>";
                      }
                      ?>
                    </td>
                    <td class="text-center"><small><?= $dd->last_login ? login(strtotime($dd->last_online)) : 'Belum Login' ?></small></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>