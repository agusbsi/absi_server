     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
         <div class="row">
           <div class="col-12">

             <!-- /.card -->

             <div class="card card-info">
               <div class="card-header">
                 <h3 class="card-title">
                   <li class="fas fa-hospital"></li> Data Customer
                 </h3>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                 <table id="example1" class="table table-bordered table-striped">
                   <thead>
                     <tr class="text-center">
                       <th rowspan="2" style="width: 2%">No</th>
                       <th rowspan="2">Kode</th>
                       <th rowspan="2">Customer</th>
                       <th colspan="2">Jumlah</th>
                       <th rowspan="2" style="width: 13%;">Menu</th>
                     </tr>
                     <tr>
                       <th>Toko</th>
                       <th>Artikel</th>
                     </tr>
                   </thead>
                   <tbody>
                     <tr>
                       <?php if (!empty($customer)) { ?>
                         <?php $no = 1; ?>
                         <?php foreach ($customer as $dd) : ?>
                           <td><?= $no ?></td>
                           <td><small><b><?= $dd->kode_customer ?></b></small></td>
                           <td>
                             <small><b><?= $dd->nama_cust ?></b>
                               <br>
                               Alamat : <?= ucwords(strtolower($dd->alamat_cust)) ?>
                               <br>
                               Telp : <?= $dd->telp ?>
                             </small>
                           </td>
                           <td class="text-center"><?= $dd->total_toko ?></td>
                           <td class="text-center"><?= $dd->total_produk ?></td>
                           <td>
                             <a href="<?= base_url('adm/Customer/detail/' . $dd->id) ?>" class="btn btn-info btn-sm" title="Detail"><i class="fa fa-eye"></i></a>
                             <button class="btn btn-warning btn-sm btn-edit" title="Update" data-id="<?= $dd->id ?>" data-kode="<?= $dd->kode_customer ?>" data-nama="<?= $dd->nama_cust ?>" data-telp="<?= $dd->telp ?>" data-alamat="<?= $dd->alamat_cust ?>" data-toggle="modal" data-target="#modal-update"><i class="fa fa-edit"></i></button>
                             <button class="btn btn-danger btn-sm btn_hapus" data-id="<?= $dd->id ?>" title="Hapus"><i class="fa fa-trash"></i></button>
                           </td>
                     </tr>
                     <?php $no++; ?>
                   <?php endforeach; ?>
                 <?php } else { ?>
                   <td colspan="6" align="center"><strong>Data Kosong</strong></td>
                 <?php } ?>
                   </tbody>
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
     <div class="modal fade" id="modal-update">
       <div class="modal-dialog modal-lg">
         <div class="modal-content">
           <div class="modal-header bg-warning">
             <h5 class="modal-title">
               Update Customer
             </h5>
           </div>
           <form method="post" action="<?php echo base_url('adm/Customer/update'); ?>">
             <div class="modal-body">

               <div class="row">
                 <div class="col-md-12">
                   <div class="form-group">
                     <label for="file">Kode Customer</label>
                     <input type="hidden" name="id" class="form-control form-control-sm id">
                     <input type="text" name="kode" class="form-control form-control-sm kode" placeholder="kode customer...." required>
                   </div>
                   <div class="form-group">
                     <label for="file">Nama Customer</label>
                     <input type="text" name="nama" class="form-control form-control-sm nama" placeholder="nama customer...." required>
                   </div>
                   <div class="form-group">
                     <label for="file">Telp</label>
                     <input type="text" name="telp" class="form-control form-control-sm telp" placeholder="Telp customer....">
                   </div>
                   <div class="form-group">
                     <label>Alamat</label> </br>
                     <textarea class="form-control alamat" name="alamat"> </textarea>
                   </div>

                 </div>

               </div>
               <!-- end konten -->
             </div>
             <div class="modal-footer right">
               <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                 <li class="fas fa-times-circle"></li> Cancel
               </button>
               <button type="submit" class="btn btn-sm btn-success">
                 <li class="fas fa-save"></li> Simpan
               </button>
             </div>
           </form>
         </div>
       </div>
     </div>
     <script>
       $('.btn-edit').on('click', function() {
         // get data from button edit
         const id = $(this).data('id');
         const nama = $(this).data('nama');
         const telp = $(this).data('telp');
         const alamat = $(this).data('alamat');
         const kode = $(this).data('kode');

         // Set data to Form Edit
         $('.id').val(id);
         $('.nama').val(nama);
         $('.kode').val(kode);
         $('.telp').val(telp);
         $('.alamat').val(alamat);

         // Call Modal Edit
         $('#modal-update').modal('show');
       });
       $('.btn_hapus').click(function(e) {
         var id = $(this).data('id');
         Swal.fire({
           title: 'Apakah anda yakin?',
           text: "Data Customer akan dihapus dari database.",
           icon: 'info',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           cancelButtonText: 'Batal',
           confirmButtonText: 'Yakin'
         }).then((result) => {
           if (result.isConfirmed) {
             window.location.href = "<?= base_url('adm/Customer/hapus_cust') ?>/" + id;
           }
         })
       });
     </script>