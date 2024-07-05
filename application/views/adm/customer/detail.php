     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
         <div class="row">
           <div class="col-12">

             <!-- /.card -->

             <div class="row">
               <div class="col-md-3">
                 <div class="callout callout-danger text-center">
                   <strong><?= $customer->nama_cust ?></strong>
                   <br>
                   [ ID : <?= $customer->id ?> ]
                 </div>
               </div>
               <div class="col-md-9">
                 <div class="card card-primary card-outline card-outline-tabs">
                   <div class="card-header p-0 border-bottom-0">
                     <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                       <li class="nav-item">
                         <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Alamat</a>
                       </li>
                       <li class="nav-item">
                         <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">PIC & Telp</a>
                       </li>
                       <li class="nav-item">
                         <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">T.O.P & Tagihan</a>
                       </li>
                       <li class="nav-item">
                         <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Berkas</a>
                       </li>
                     </ul>
                   </div>
                   <div class="card-body">
                     <div class="tab-content" id="custom-tabs-four-tabContent">
                       <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                         <div class="form-group">
                           <address><?= $customer->alamat_cust ?></address>
                         </div>
                       </div>
                       <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                         <div class="forn-group">
                           <label for="">Nama PIC :</label>
                           <input type="text" class="form-control" value="<?= $customer->nama_pic ?>" readonly>
                         </div>
                         <div class="forn-group">
                           <label for="">Telp :</label>
                           <input type="text" class="form-control" value="<?= $customer->telp ?>" readonly>
                         </div>
                       </div>
                       <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                         <div class="forn-group">
                           <label for="">T.O.P :</label>
                           <input type="text" class="form-control" value="<?= $customer->top ?>" readonly>
                         </div>
                         <div class="forn-group">
                           <label for="">Dari :</label>
                           <input type="text" class="form-control" value="<?= $customer->tagihan ?>" readonly>
                         </div>
                       </div>
                       <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                         <div class="row">
                           <div class="col-md-5">
                             <div class="form-group">
                               <label for="">Foto KTP:</label> <br>
                               <img src="<?= base_url('assets/img/customer/' . $customer->foto_ktp) ?>" class="img img-rounded " style="width: 70%;" alt="foto ktp">
                             </div>
                           </div>
                           <div class="col-md-2"></div>
                           <div class="col-md-5">
                             <div class="form-group">
                               <label for="">Foto NPWP:</label> <br>
                               <img src="<?= base_url('assets/img/customer/' . $customer->foto_npwp) ?>" class="img img-rounded " style="width: 70%;" alt="foto npwp">
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>
                   <!-- /.card -->
                 </div>
               </div>
             </div>
             <hr>
             <li class="fas fa-store"></li> List Toko
             <hr>
             <div class="card">
               <div class="card-body">
                 <table id="example4" class="table table-bordered table-striped table-responsive">
                   <thead>
                     <tr>
                       <th style="width: 2%">#</th>
                       <th>Nama Toko</th>
                       <th class="text-center">Menu</th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php
                      $no = 0;
                      foreach ($list_toko as $a) :
                        $no++;
                      ?>
                       <tr>
                         <td><?= $no ?></td>
                         <td>
                           <small>
                             <b><?= $a->nama_toko ?></b>
                           </small>
                         </td>
                         <td class="text-center">
                           <button class="btn btn-sm btn-primary btn_pindah" data-toggle="modal" data-target="#pindahModal" data-id="<?= $a->id; ?>" data-id_cust="<?= $a->id_customer; ?>" data-toko="<?= $a->nama_toko; ?>">Pindah <i class="fas fa-arrow-right"></i></button>
                         </td>
                       </tr>
                     <?php endforeach ?>
                   </tbody>
                 </table>
               </div>
             </div>
             <hr>
             <li class="fas fa-box"></li> List Artikel
             <hr>
             <div class="card">
               <div class="card-header p-2">
                 <ul class="nav nav-pills">
                   <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Cluster 1</a></li>
                   <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Cluster 2</a></li>
                   <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Cluster 3</a></li>
                 </ul>
               </div><!-- /.card-header -->
               <div class="card-body">
                 <div class="tab-content">
                   <div class="active tab-pane" id="activity">
                     <div>
                       <button type="button" class="btn btn-success btn-sm float-right mr-2 btn_tambah" data-toggle="modal" data-target="#modal-tambah-produk"><i class="fa fa-plus"></i> Tambah Artikel</button>
                       <button type="button" class="btn btn-info btn-sm float-right mr-2 " data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-upload"></i> Import Barcode</button>
                       <a href="<?= base_url('adm/Customer/template_barcode/' . $customer->id) ?>" class="btn btn-warning btn-sm float-right mr-2 "><i class="fa fa-download"></i> Template Barcode</a>
                     </div>
                     <br>
                     <hr>
                     <table id="example1" class="table table-bordered table-striped table-responsive">
                       <thead>
                         <tr>
                           <th style="width: 2%">#</th>
                           <th>Kode</th>
                           <th>Artikel</th>
                           <th class="text-center">Satuan</th>
                           <th class="text-center">Barcode</th>
                           <th class="text-center">Menu</th>
                         </tr>
                       </thead>
                       <tbody>
                         <?php
                          $no = 0;
                          foreach ($cluster1 as $a) :
                            $no++;
                          ?>
                           <tr>
                             <td><?= $no ?></td>
                             <td>
                               <small>
                                 <b><?= $a->kode ?></b>
                               </small>
                             </td>
                             <td>
                               <small>
                                 <?= $a->nama_produk ?>
                               </small>
                             </td>
                             <td class="text-center">
                               <small>
                                 <?= $a->satuan ?>
                               </small>
                             </td>
                             <td class="text-center">
                               <small>
                                 <b><?= $a->barcode ?></b>
                               </small>
                             </td>
                             <td class="text-center">
                               <a href="#" data-toggle="modal" data-target="#editModal" data-id="<?= $a->detail; ?>" data-kode="<?= $a->kode; ?>" data-artikel="<?= $a->nama_produk; ?>" data-barcode="<?= $a->barcode; ?>" title="Update Barcode" class="text-warning btn_edit"><i class="fas fa-edit"></i></a>
                               <a href="<?= base_url('adm/Customer/hapus_item/' . $a->detail) ?>" title="Hapus Data" class="text-danger"><i class="fas fa-trash"></i></a>
                             </td>
                           </tr>
                         <?php endforeach ?>
                       </tbody>

                     </table>
                   </div>
                   <!-- /.tab-pane -->
                   <div class="tab-pane" id="timeline">
                     <div>
                       <button type="button" class="btn btn-success btn-sm float-right mr-2 btn_cluster2" data-toggle="modal" data-target="#modal-cluster2"><i class="fa fa-plus"></i> Tambah Artikel</button>
                     </div>
                     <br>
                     <hr>
                     <table id="example2" class="table table-bordered table-striped table-responsive">
                       <thead>
                         <tr>
                           <th style="width: 2%">#</th>
                           <th>Kode</th>
                           <th>Artikel</th>
                           <th class="text-center">Satuan</th>
                           <th class="text-center">Barcode</th>
                           <th class="text-center">Menu</th>
                         </tr>
                       </thead>
                       <tbody>
                         <?php
                          $no = 0;
                          foreach ($cluster2 as $a) :
                            $no++;
                          ?>
                           <tr>
                             <td><?= $no ?></td>
                             <td>
                               <small>
                                 <b><?= $a->kode ?></b>
                               </small>
                             </td>
                             <td>
                               <small>
                                 <?= $a->nama_produk ?>
                               </small>
                             </td>
                             <td class="text-center">
                               <small>
                                 <?= $a->satuan ?>
                               </small>
                             </td>
                             <td class="text-center">
                               <small>
                                 <b><?= $a->barcode ?></b>
                               </small>
                             </td>
                             <td class="text-center">
                               <a href="#" data-toggle="modal" data-target="#editModal" data-id="<?= $a->detail; ?>" data-kode="<?= $a->kode; ?>" data-artikel="<?= $a->nama_produk; ?>" data-barcode="<?= $a->barcode; ?>" title="Update Barcode" class="text-warning btn_edit"><i class="fas fa-edit"></i></a>
                               <a href="<?= base_url('adm/Customer/hapus_item2/' . $a->detail) ?>" title="Hapus Data" class="text-danger"><i class="fas fa-trash"></i></a>
                             </td>
                           </tr>
                         <?php endforeach ?>
                       </tbody>

                     </table>
                   </div>
                   <!-- /.tab-pane -->

                   <div class="tab-pane" id="settings">
                     <div>
                       <button type="button" class="btn btn-success btn-sm float-right mr-2 btn_cluster3" data-toggle="modal" data-target="#modal-cluster3"><i class="fa fa-plus"></i> Tambah Artikel</button>
                     </div>
                     <br>
                     <hr>
                     <table id="example3" class="table table-bordered table-striped table-responsive">
                       <thead>
                         <tr>
                           <th style="width: 2%">#</th>
                           <th>Kode</th>
                           <th>Artikel</th>
                           <th class="text-center">Satuan</th>
                           <th class="text-center">Barcode</th>
                           <th class="text-center">Menu</th>
                         </tr>
                       </thead>
                       <tbody>
                         <?php
                          $no = 0;
                          foreach ($cluster3 as $a) :
                            $no++;
                          ?>
                           <tr>
                             <td><?= $no ?></td>
                             <td>
                               <small>
                                 <b><?= $a->kode ?></b>
                               </small>
                             </td>
                             <td>
                               <small>
                                 <?= $a->nama_produk ?>
                               </small>
                             </td>
                             <td class="text-center">
                               <small>
                                 <?= $a->satuan ?>
                               </small>
                             </td>
                             <td class="text-center">
                               <small>
                                 <b><?= $a->barcode ?></b>
                               </small>
                             </td>
                             <td class="text-center">
                               <a href="#" data-toggle="modal" data-target="#editModal" data-id="<?= $a->detail; ?>" data-kode="<?= $a->kode; ?>" data-artikel="<?= $a->nama_produk; ?>" data-barcode="<?= $a->barcode; ?>" title="Update Barcode" class="text-warning btn_edit"><i class="fas fa-edit"></i></a>
                               <a href="<?= base_url('adm/Customer/hapus_item3/' . $a->detail) ?>" title="Hapus Data" class="text-danger"><i class="fas fa-trash"></i></a>
                             </td>
                           </tr>
                         <?php endforeach ?>
                       </tbody>

                     </table>
                   </div>
                   <!-- /.tab-pane -->
                 </div>
                 <!-- /.tab-content -->
               </div><!-- /.card-body -->
             </div>
           </div>
           <!-- /.col -->
         </div>
         <!-- /.row -->
       </div>
       <!-- /.container-fluid -->
     </section>
     <div class="modal fade" id="modal-tambah-produk" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
       <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
           <div class="modal-header bg-success">
             <h5 class="modal-title" id="modal-supervisor">Tambah Artikel</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           <div class="modal-body">
             Sumber Data : Master Artikel
             <hr>
             <div class="col-lg-8">
               <div class="input-group mb-3">
                 <div class="input-group-prepend">
                   <span class="input-group-text"><i class="fas fa-search"></i></span>
                 </div>
                 <input type="text" class="form-control form-control-sm " id="searchInput" placeholder="Cari artikel...">
               </div>
             </div>
             <form action="<?= base_url('adm/Customer/tambah_artikel') ?>" role="form" method="post">
               <div style="overflow-x: auto; max-height : 300px;">
                 <table id="myTable" class="table table-bordered table-striped">
                   <thead>
                     <tr>
                       <th>No</th>
                       <th>Kode</th>
                       <th>Artikel</th>
                       <th>
                         Pilih
                       </th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php
                      $no = 0;
                      foreach ($list_produk as $pr) {
                        $no++; ?>
                       <tr>
                         <td><?= $no ?></td>
                         <td><small><?= $pr->kode ?></small></td>
                         <td><small><?= $pr->nama_produk ?></small></td>
                         <td class="text-center">
                           <input type="checkbox" name="id_produk[]" class="checkbox-item" value="<?= $pr->id ?>">
                         </td>
                       </tr>
                     <?php } ?>
                   </tbody>
                 </table>
               </div>
           </div>
           <div class="modal-footer">
             <input type="hidden" name="id_customer" value="<?= $customer->id ?>">
             <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
             <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Tambah Data</button>
           </div>
           </form>
         </div>
       </div>
     </div>
     <div class="modal fade" id="modal-cluster2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
       <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
           <div class="modal-header bg-success">
             <h5 class="modal-title" id="modal-supervisor">Tambah Artikel</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           <div class="modal-body">
             Sumber Data : Artikel Cluster 1
             <hr>
             <div class="col-lg-8">
               <div class="input-group mb-3">
                 <div class="input-group-prepend">
                   <span class="input-group-text"><i class="fas fa-search"></i></span>
                 </div>
                 <input type="text" class="form-control form-control-sm " id="search2" placeholder="Cari artikel...">
               </div>
             </div>
             <form action="<?= base_url('adm/Customer/tambah_artikel2') ?>" role="form" method="post">
               <div style="overflow-x: auto; max-height : 300px;">
                 <table id="tabel2" class="table table-bordered table-striped">
                   <thead>
                     <tr>
                       <th>No</th>
                       <th>Kode</th>
                       <th>Artikel</th>
                       <th>
                         Pilih
                       </th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php
                      $no = 0;
                      foreach ($list2 as $pr) {
                        $no++; ?>
                       <tr>
                         <td><?= $no ?></td>
                         <td><small><?= $pr->kode ?></small></td>
                         <td><small><?= $pr->nama_produk ?></small></td>
                         <td class="text-center">
                           <input type="checkbox" name="id_produk[]" class="checkbox-item" value="<?= $pr->id ?>">
                         </td>
                       </tr>
                     <?php } ?>
                   </tbody>
                 </table>
               </div>
           </div>
           <div class="modal-footer">
             <input type="hidden" name="id_customer" value="<?= $customer->id ?>">
             <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
             <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Tambah Data</button>
           </div>
           </form>
         </div>
       </div>
     </div>
     <div class="modal fade" id="modal-cluster3" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
       <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
           <div class="modal-header bg-success">
             <h5 class="modal-title" id="modal-supervisor">Tambah Artikel</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           <div class="modal-body">
             Sumber Data : Artikel Cluster 1
             <hr>
             <div class="col-lg-8">
               <div class="input-group mb-3">
                 <div class="input-group-prepend">
                   <span class="input-group-text"><i class="fas fa-search"></i></span>
                 </div>
                 <input type="text" class="form-control form-control-sm " id="search2" placeholder="Cari artikel...">
               </div>
             </div>
             <form action="<?= base_url('adm/Customer/tambah_artikel3') ?>" role="form" method="post">
               <div style="overflow-x: auto; max-height : 300px;">
                 <table id="tabel2" class="table table-bordered table-striped">
                   <thead>
                     <tr>
                       <th>No</th>
                       <th>Kode</th>
                       <th>Artikel</th>
                       <th>
                         Pilih
                       </th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php
                      $no = 0;
                      foreach ($list3 as $pr) {
                        $no++; ?>
                       <tr>
                         <td><?= $no ?></td>
                         <td><small><?= $pr->kode ?></small></td>
                         <td><small><?= $pr->nama_produk ?></small></td>
                         <td class="text-center">
                           <input type="checkbox" name="id_produk[]" class="checkbox-item" value="<?= $pr->id ?>">
                         </td>
                       </tr>
                     <?php } ?>
                   </tbody>
                 </table>
               </div>
           </div>
           <div class="modal-footer">
             <input type="hidden" name="id_customer" value="<?= $customer->id ?>">
             <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
             <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Tambah Data</button>
           </div>
           </form>
         </div>
       </div>
     </div>
     <!-- edit barcode -->
     <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
         <form action="<?= base_url('adm/Customer/update_barcode') ?>" method="POST">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-edit"></i> Update Barcode</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body">
               <div class="form-grou mb-1p">
                 <label>Kode</label>
                 <input type="text" class="form-control form-control-sm kode" readonly>
               </div>
               <div class="form-group mb-1">
                 <label>Artikel</label>
                 <input type="text" class="form-control form-control-sm artikel" readonly>
               </div>
               <div class="form-group mb-1">
                 <label>Barcode</label>
                 <input type="text" class="form-control form-control-sm barcode" name="barcode">
               </div>
             </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                 <i class="fas fa-times-circle"></i> Cancel
               </button>
               <input type="hidden" name="id" class="id">
               <button type="submit" class="btn btn-primary btn-sm">
                 <i class="fas fa-edit"></i> Update
               </button>
             </div>

           </div>
         </form>
       </div>
     </div>
     <div class="modal fade" id="modal-tambah">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header bg-success">
             <h4 class="modal-title">
               <li class="fa fa-excel"></li> Import Barcode
             </h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           <div class="modal-body">
             <!-- isi konten -->
             <form method="post" enctype="multipart/form-data" action="<?php echo base_url('adm/Customer/import_barcode'); ?>">
               - Pastikan file excel diambil dari template <b><?= $customer->nama_cust ?>.</b>
               <br>
               - pastikan data di input dengan benar.</b>
               <hr>
               <div class="form-group">
                 <label for="file">File Upload</label>
                 <input type="file" name="file" class="form-control" id="exampleInputFile" accept=".xlsx,.xls" required>
               </div>
               <!-- end konten -->
           </div>
           <div class="modal-footer right">
             <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
               <li class="fas fa-times-circle"></li> Cancel
             </button>
             <button type="submit" class="btn btn-sm btn-success">
               <li class="fas fa-save"></li> Import
             </button>
           </div>
           </form>
         </div>
       </div>
     </div>
     <div class="modal fade" id="pindahModal">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header bg-primary">
             <h4 class="modal-title">
               <li class="fa fa-excel"></li> Pindah Toko
             </h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           <div class="modal-body">
             <!-- isi konten -->
             <form method="post" enctype="multipart/form-data" action="<?php echo base_url('adm/Customer/pindahToko'); ?>">
               Fitur ini di gunakan untuk mengaitkan Customer/Group pada toko.
               <hr>
               <div class="form-group">
                 <label for="">Nama Toko</label>
                 <input type="hidden" name="id_cust" class="form-control form-control-sm id_cust" readonly>
                 <input type="hidden" name="id_toko" class="form-control form-control-sm id_pindah" readonly>
                 <input type="text" id="toko_pindah" class="form-control form-control-sm " readonly>
               </div>
               <i class="fas fa-arrow-down"></i> Pindah ke :
               <div class="form-group mt-2">
                 <label for="file">Customer</label>
                 <select name="customer" class="form-control form-control-sm select2" required>
                   <option value="">- Pilih Customer -</option>
                   <?php foreach ($cust as $c) : ?>
                     <option value="<?= $c->id ?>"><?= $c->nama_cust ?></option>
                   <?php endforeach ?>
                 </select>
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
       $(document).ready(function() {
         $('.btn_pindah').on('click', function() {
           // get data from button edit
           const id_cust = $(this).data('id_cust');
           const id = $(this).data('id');
           const toko = $(this).data('toko');
           // Set data to Form Edit
           $('.id_pindah').val(id);
           $('.id_cust').val(id_cust);
           $('#toko_pindah').val(toko);
           $('#pindahModal').modal('show');
         });
         $('.btn_edit').on('click', function() {
           // get data from button edit
           const id = $(this).data('id');
           const kode = $(this).data('kode');
           const artikel = $(this).data('artikel');
           const barcode = $(this).data('barcode');
           // Set data to Form Edit
           $('.id').val(id);
           $('.artikel').val(artikel);
           $('.kode').val(kode);
           $('.barcode').val(barcode);
           $('#editModal').modal('show');
         });

         $(".checkbox-item").change(function() {
           if (!$(this).prop("checked")) {}
         });
         // Fungsi untuk melakukan pencarian
         function searchTable() {
           var input, filter, table, tr, td, i, txtValue;
           input = document.getElementById("searchInput");
           filter = input.value.toUpperCase();
           table = document.getElementById("myTable");
           tr = table.getElementsByTagName("tr");
           for (i = 0; i < tr.length; i++) {
             td = tr[i].getElementsByTagName("td");
             for (var j = 0; j < td.length; j++) {
               txtValue = td[j].textContent || td[j].innerText;
               if (txtValue.toUpperCase().indexOf(filter) > -1) {
                 tr[i].style.display = "";
                 break; // keluar dari loop jika sudah ada satu td yang cocok
               } else {
                 tr[i].style.display = "none";
               }
             }
           }
         }
         document.getElementById("searchInput").addEventListener("input", searchTable);

         function searchCluster2() {
           var input, filter, table, tr, td, i, txtValue;
           input = document.getElementById("search2");
           filter = input.value.toUpperCase();
           table = document.getElementById("tabel2");
           tr = table.getElementsByTagName("tr");
           for (i = 0; i < tr.length; i++) {
             td = tr[i].getElementsByTagName("td");
             for (var j = 0; j < td.length; j++) {
               txtValue = td[j].textContent || td[j].innerText;
               if (txtValue.toUpperCase().indexOf(filter) > -1) {
                 tr[i].style.display = "";
                 break; // keluar dari loop jika sudah ada satu td yang cocok
               } else {
                 tr[i].style.display = "none";
               }
             }
           }
         }
         document.getElementById("search2").addEventListener("input", searchCluster2);


       })
     </script>
     <script>
       $(function() {
         $("#example3").DataTable({
           "responsive": true,
           "lengthChange": false,
           "autoWidth": false,
           "buttons": ["excel", "pdf", "print"]
         }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
       });
     </script>
     <script>
       $(function() {
         $("#example4").DataTable({
           "responsive": true,
           "lengthChange": false,
           "autoWidth": false,
           "buttons": ["excel", "pdf", "print"]
         }).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');
       });
     </script>