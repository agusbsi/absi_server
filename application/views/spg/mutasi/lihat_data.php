<section class="content">
  <div class="card card-info ">
    <div class="card-header">
      <h3 class="card-title">
        <li class="fas fa-copy"></li> Terima Mutasi
      </h3>
      <div class="card-tools">
        <a href="<?= base_url('spg/Dashboard') ?>" type="button" class="btn btn-tool">
          <i class="fas fa-times"></i>
        </a>
      </div>
    </div>
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
          <tr class="text-center">
            <th>#</th>
            <th>No Mutasi</th>
            <th>Toko Asal</th>
            <th>Menu</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 0;
          foreach ($list_data as $data) :
            $no++;
          ?>
            <tr>
              <td class="text-center"><?= $no ?></td>
              <td class="text-center">
                <small><?= $data->id ?></small>
              </td>
              <td>
                <small>
                  <strong><?= $data->asal ?></strong> <br>
                  <?= date('d-M-Y', strtotime($data->created_at)) ?>
                </small>
              </td>
              <td class="text-center">
                <a href="<?= base_url('spg/Mutasi/detail/' . $data->id) ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-right"></i> Proses</a>
              </td>
            </tr>
          <?php
          endforeach;
          ?>

        </tbody>
      </table>
    </div>
  </div>
</section>