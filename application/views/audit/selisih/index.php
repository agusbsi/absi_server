 <!-- Main content -->
 <section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <!-- /.card -->

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"> <li class="fas fa-cube"></li> Data Selisih Penerimaan Barang</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id ="example1" class="table table-bordered table-striped">
              <thead>

                <tr>
                  <th style="width: 1%">No</th>
                  <th style="width:20%">Kode Pengiriman</th>
                  <th>Toko</th>
                  <th>Nama SPG</th>
                  <th>Tgl</th>
                  <th>Menu</th> 
                </tr>
              </thead>
              <tbody>
              <tr>
                <?php if(is_array($selisih)){ ?>
                  <?php $no = 1;?>
                  <?php foreach ($selisih as $data) : ?>
                    <td><?=$no?></td>
                    <td><?=$data->id?></td>

                    <td><?=$data->nama_toko?></td>
                    <td><?=$data->nama_user?></td>
                    <td><?= format_tanggal1($data->created_at) ?></td>
                    <td>                  
                    <a type="button" class="btn btn-primary"  href="<?=base_url('audit/selisih/detail/'.$data->id)?>" name="btn_detail" ><i class="fas fa-eye" aria-hidden="true"></i> Detail</a>
                  </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php $no++; ?>
                  <?php }else { ?>
                        <td colspan="7" align="center"><strong>Data Kosong</strong></td>
                  <?php } ?>
                </tr>
                 
              </tbody>
              <tfoot>
              <tr>
              <th colspan="7"></th>
              </tr>
              </tfoot>
            </table>
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

<!-- jQuery -->
<script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/app/js/alert.js"></script>

<!-- /.content -->