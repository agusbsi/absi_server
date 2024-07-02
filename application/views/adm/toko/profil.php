<style>
  #loading {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(255, 255, 255, 0.7);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .loader {
    position: relative;
    width: 200px;
    height: 200px;
  }

  .circle {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: conic-gradient(#3498db 0deg, #3498db 0deg, transparent 0deg);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .percentage {
    position: absolute;
    font-size: 2em;
    font-weight: bold;
    color: #ffc107;
  }

  .img-nodata {
    width: 100%;

  }
</style>
<section class="content">
  <div class="container-fluid">
    <?php if ($cek_status->status == 0) { ?>
      <div class="overlay-wrapper">
        <div class="overlay">
          <i class="fas fa-3x fa-sync-alt fa-spin"></i>
          <div class="text-bold pt-2">TOKO NON-AKTIF !</div>
        </div>
      </div>
    <?php } ?>
    <div class="card card-info">
      <div class="card-header">
        Detail Toko
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-7">
            <!-- Profile Image -->
            <div class="card card-outline card-info">
              <div class="card-header">
                Foto
              </div>
              <div class="card-body">
                <div class="text-center">
                  <?php if ($toko->foto_toko == "") {
                  ?>
                    <img style="width: 150px;" class="img-responsive img-rounded" src="<?php echo base_url() ?>assets/img/toko/hicoop.png" alt="User profile picture">
                  <?php
                  } else { ?>
                    <img style="width: 150px;" class=" img-responsive img-rounded" src="<?php echo base_url('assets/img/toko/' . $toko->foto_toko) ?>" alt="User profile picture">
                  <?php } ?>
                </div>
                <h3 class="profile-username text-center"><strong><?= $toko->nama_toko ?></strong></h3>
                <p class="text-muted text-center">[ ID : <?= $toko->id ?> ]</p>

              </div>
              <!-- /.card-body -->
            </div>
            <div class="card card-outline card-info">
              <div class="card-header">
                Detail
              </div>
              <div class="card-body">
                <table class="table table-sm">
                  <tbody>
                    <tr>
                      <td><b>Customer</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->nama_cust ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Jenis Toko</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= jenis_toko($toko->jenis_toko) ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td><b>PIC & Telp</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->nama_pic ?> | <?= $toko->telp ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Provinsi</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->provinsi ?> " readonly>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Kabupaten</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->kabupaten ?> " readonly>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Kecamatan</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->kecamatan ?> " readonly>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Alamat</b></td>
                      <td>
                        <textarea class="form-control form-control-sm" readonly><?= $toko->alamat ?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Di buat</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->created_at ?> " readonly>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card card-outline card-info">
              <div class="card-header">
                Pengaturan
              </div>
              <div class="card-body">
                <table class="table table-sm">
                  <tbody>
                    <tr>
                      <td><b>Max Tgl SO</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->tgl_so ?> / Bulan" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Margin</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->diskon ?> % " readonly>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Target Toko</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="Rp <?= number_format($toko->target) ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Jenis Harga</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->het == 1 ? 'HET JAWA' : 'HET INDOBARAT' ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Batas PO</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->status_ssr == 1 ? 'AKTIF' : 'NON-AKTIF' ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td><b>SSR Toko</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->ssr ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Max PO</b></td>
                      <td>
                        <input type="text" class="form-control form-control-sm" value="<?= $toko->max_po ?> %" readonly>
                        <small>( Dari Total Penjualan bulan kemarin )</small>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card card-outline card-info">
              <div class="card-header">
                Pengguna Sistem
              </div>
              <div class="card-body">
                <table class="table table-sm">
                  <tbody>
                    <tr>
                      <td><b>Supervisor</b></td>
                      <td>
                        : <?= $spv->id_spv == "0" ? "Belum di kaitkan " : $spv->nama_user ?>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Team Leader</b></td>
                      <td>
                        : <?= $leader_toko->id_leader == "0" ? "Belum di kaitkan " : $leader_toko->nama_user ?>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Spg</b></td>
                      <td>
                        : <?= $spg->id_spg == "0" ? "Belum di kaitkan " : $spg->nama_user ?>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <button type="button" class="btn btn-outline-info btn-block btn-sm" id="btnHistori" data-id="<?= $toko->id ?>"><i class="fas fa-feather"></i> Histori Pengajuan </button>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <a href="<?= base_url('adm/Toko/update/' . $toko->id) ?>" class="btn btn-warning btn-sm float-right"><i class="fas fa-edit"></i> Update</a>
      </div>
    </div>
    <!-- Stok-->
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">
          <li class="fas fa-box"></li> Data Stok Artikel
        </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div id="loading" style="display: none;">
          <div class="loader">
            <div class="circle">
              <div class="percentage" id="percentage">0%</div>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-success btn-sm btn_tambah <?= ($this->session->userdata('role') != 1) ? 'd-none' : '' ?>" data-id_toko="<?= $toko->id ?>" data-toggle="modal" data-target="#modal-tambah-produk"><i class="fa fa-plus"></i> Tambah Produk</button>
        <a href="<?= base_url('adm/Toko/templateStok/' . $toko->id) ?>" class="btn btn-warning btn-sm <?= ($cek_status->status != 1) ? 'd-none' : '' ?>"><i class="fa fa-download"></i> Unduh Template</a>
        <button type="button" class="btn btn-primary btn-sm btn_tambah <?= ($this->session->userdata('role') != 1) ? 'd-none' : '' ?>" data-id_toko="<?= $toko->id ?>" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-upload"></i> Import Stok</button>
        <div class="tab-content">
          <?php
          if ($cek_status->status != 1) { ?>
            <div class="overlay-wrapper">
              <div class="overlay">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                <div class="text-bold pt-2"> Belum Aktif ...</div>
              </div>
            </div>
          <?php } ?>
          <hr>
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Artikel</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Max Stok</th>
                <th>Menu</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                $no = 0;
                $total = 0;
                foreach ($stok_produk as $stok) {
                  $no++
                ?>

                  <td><?= $no ?></td>
                  <td>
                    <small><strong><?= $stok->kode ?></strong></small> <br>
                    <small><?= $stok->nama_produk ?></small>
                  </td>
                  <td class="text-center"><small><?= $stok->satuan ?></small></td>
                  <td class="text-center">
                    <?php
                    if ($stok->status == 2) {
                      echo "<span class='badge badge-warning' >belum di approve </span>";
                    } else {
                      echo $stok->qty;
                    }
                    ?>
                  </td>
                  <td class="text-right">
                    <?php
                    if ($stok->status == 2) {
                      echo "<span class='badge badge-warning' >belum di approve </span>";
                    } else {
                      if ($toko->het == 1) {
                        echo "Rp. ";
                        echo number_format($stok->harga_jawa);
                        echo " ,-";
                      } else {
                        echo "Rp. ";
                        echo number_format($stok->harga_indobarat);
                        echo " ,-";
                      }
                    }
                    ?>
                  </td>
                  <td class="text-center">
                    <?= $stok->ssr ?>
                  </td>
                  <td class="text-center">
                    <button class="btn btn-sm btn-success btn_kartu" data-id="<?= $stok->id ?>" data-id_toko="<?= $toko->id ?>" data-toggle="modal" data-target="#modal_kartu"> <i class="fas fa-clipboard-list"></i> <small>Kartu Stok</small></button>
                  </td>
              </tr>
            <?php
                  $total += $stok->qty;
                } ?>

            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" class="text-right"> <strong>Total :</strong> </td>
                <td class="text-center"><b><?php
                                            if ($cek_status_stok > 0) {
                                              echo "<span class='badge badge-warning' >belum di approve </span>";
                                            } else {
                                              echo $total;
                                            }
                                            ?></b></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

            </tfoot>
          </table>
        </div>
        <!-- /.tab-content -->
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="modal-tambah-produk">
  <div class="modal-dialog">
    <form action="<?= base_url('adm/toko/tambah_produk') ?>" role="form" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-supervisor">Tambah Artikel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label>Nama Artikel</label>
            <select name="id_produk" class="form-control select2bs4" required>
              <option value="">- Pilih Artikel -</option>
              <?php foreach ($list_produk as $pr) { ?>
                <option value="<?= $pr->id ?>"><?= $pr->kode . " | " . $pr->nama_produk ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="form-group">
            <label>Harga</label>
            <p>
              * Artikel ini berlaku untuk harga : <strong> <?= status_het($toko->het) ?></strong>
            </p>
            <input class="form-control" type="hidden" name="id_toko" value="<?= $toko->id ?>">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Tambah</button>
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
          <li class="fa fa-excel"></li> Import Excel
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- isi konten -->
        <form method="post" enctype="multipart/form-data" action="<?php echo base_url('adm/Toko/importStok'); ?>">
          <span class="badge badge-danger">Perhatian :</span> <br> - Fitur ini akan memperbarui stok pada toko <b><?= $toko->nama_toko ?>,</b>.
          <br>
          - Pastikan file excel diambil dari template toko <b><?= $toko->nama_toko ?>.</b>
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
<div class="modal fade" id="modal_kartu">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-success">
        Detail Kartu Stok
      </div>
      <div class="modal-body">
        Menampilkan 3 transaksi terakhir :
        <hr>
        <p class="text-center" id="artikel"></p>
        <p class="text-center" id="toko"></p>
        <div class="row mr-4" style="justify-content:flex-end">
          <p class="mr-5">Saldo Awal :</p>
          <strong id="s_awal" class="ml-5"></strong>
        </div>
        <table class="table table-bordered">
          <thead>
            <tr class="text-center">
              <th rowspan="2">Tanggal</th>
              <th rowspan="2">No. Dok</th>
              <th rowspan="2">Transaksi</th>
              <th rowspan="2">Pembuat</th>
              <th colspan="3">Stok Artikel</th>
            </tr>
            <tr class="text-center">
              <th>Masuk</th>
              <th>Keluar</th>
              <th>Sisa</th>
            </tr>
          </thead>
          <tbody id="dataTableBody">
          </tbody>
        </table>
        <div class="row mr-4" style="justify-content:flex-end">
          <p class="mr-5">Saldo Akhir :</p>
          <strong id="s_akhir" class="ml-5"></strong>
        </div>
        <hr>
        # Untuk melihat riwayat transaksi lebih lengkap silahkan buka menu : <a href="<?= base_url('adm/Stok/kartu_stok') ?>">Laporan Kartu Stok</a>
      </div>
      <div class="modal-footer right">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
          <li class="fas fa-times-circle"></li> Close
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Histori Pengajuan -->
<div class="modal fade" id="modalHistori" tabindex="-1" role="dialog" aria-labelledby="modalHistoriTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHistoriTitle">Histori Pengajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="timeline">
          <!-- Tempat untuk menampilkan histori pengajuan -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('.btn_kartu').click(function() {
    var id_produk = $(this).data('id');
    var id_toko = $(this).data('id_toko');
    const url = '<?= base_url('adm/Toko') ?>';
    document.getElementById('loading').style.display = 'flex';
    // Reset the percentage
    var percentageElement = document.getElementById('percentage');
    percentageElement.textContent = '0%';
    var circle = document.querySelector('.circle');
    // Simulate loading data with setInterval
    var percentage = 0;
    var intervalTime = 50; // update every 50ms
    var interval = setInterval(() => {
      if (percentage < 100) {
        percentage += 1;
        percentageElement.textContent = Math.round(percentage) + '%';
        var angle = percentage * 3.6;
        circle.style.background = `conic-gradient(
                    #3498db 0deg,
                    #3498db ${angle}deg,
                    transparent ${angle}deg,
                    transparent 360deg
                )`;
      } else {
        clearInterval(interval);
      }
    }, intervalTime);
    fetch(`${url}/cari_kartu?id_toko=${id_toko}&id_artikel=${id_produk}`)
      .then(response => response.json())
      .then(data => {
        // Additional duration after data is fetched
        var additionalDuration = 2000; // 3 seconds
        var additionalIntervalTime = intervalTime; // same interval time
        var additionalIntervals = additionalDuration / additionalIntervalTime;
        var remainingIntervals = 0;

        var additionalInterval = setInterval(() => {
          remainingIntervals++;
          percentage = Math.min(100, percentage + (1 / additionalIntervals) * 100);
          if (remainingIntervals <= additionalIntervals && percentage <= 100) {
            percentageElement.textContent = Math.round(percentage) + '%';
            var angle = percentage * 3.6;
            circle.style.background = `conic-gradient(
                            #3498db 0deg,
                            #3498db ${angle}deg,
                            transparent ${angle}deg,
                            transparent 360deg
                        )`;
          } else {
            clearInterval(additionalInterval);
            percentageElement.textContent = '100%';
            circle.style.background = `conic-gradient(
                            #3498db 0deg,
                            #3498db 360deg,
                            transparent 360deg,
                            transparent 360deg
                        )`;
            setTimeout(() => {
              // Hide the loading animation
              document.getElementById('loading').style.display = 'none';
              updateUI(data);

            }, 500);
          }
        }, additionalIntervalTime);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
        clearInterval(interval);
        document.getElementById('loading').style.display = 'none';
      });
  });

  function updateUI(data) {
    // Function to format the date
    function formatDate(dateString) {
      const date = new Date(dateString);
      const options = {
        year: 'numeric',
        month: 'long',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
      };
      // Format date using Indonesian locale
      let formattedDate = new Intl.DateTimeFormat('id-ID', options).format(date);
      // Remove the word "pukul"
      formattedDate = formattedDate.replace(' pukul ', ' ');
      return formattedDate;
    }

    // Update the table
    var tableBody = document.getElementById('dataTableBody');
    tableBody.innerHTML = ''; // Clear previous content
    if (data.tabel_data.length > 0) {
      data.tabel_data.forEach((item, index) => {
        var formattedDate = formatDate(item.tanggal);
        var row = document.createElement('tr');
        row.innerHTML = `
                <td class="text-center">${formattedDate}</td>
                <td class="text-center">${item.no_doc}</td>
                <td class="text-center">${item.keterangan}</td>
                <td class="text-center">${item.pembuat}</td>
                <td class="text-center">${item.masuk}</td>
                <td class="text-center">${item.keluar}</td>
                <td class="text-center">${item.sisa}</td>
            `;
        tableBody.appendChild(row);
      });
      // Assuming s_awal is the stock at the start of the period
      $('#s_awal').html(data.s_awal);
      $('#s_akhir').html(data.s_akhir);
    } else {
      // Display message when data is empty
      tableBody.innerHTML = '<tr><td colspan="7" class="text-center">TIDAK ADA RIWAYAT TRANSAKSI</td></tr>';
      $('#s_awal').html('0'); // You can set default values here
      $('#s_akhir').html('0'); // You can set default values here
    }
  }
</script>
<script>
  $(document).ready(function() {
    $('#btnHistori').click(function() {
      var id = $(this).data('id');
      $.ajax({
        url: '<?= base_url('adm/Toko/histori/') ?>' + id, // Ganti url dengan endpoint Anda
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.status === 'success') {
            // Bersihkan konten timeline sebelum menambahkan data baru
            $('.timeline').empty();

            // Iterasi data histori dan tambahkan ke dalam timeline
            $.each(response.data, function(index, item) {
              var timelineItem = `
                <div>
                  <i class="fas bg-blue">${index + 1}</i>
                  <div class="timeline-item">
                    <span class="time"></span>
                    <p class="timeline-header"><small>${item.aksi} <strong>${item.pembuat}</strong></small></p>
                    <div class="timeline-body">
                      <small>
                        ${item.tanggal} <br>
                        Catatan :<br>
                        ${item.catatan}
                      </small>
                    </div>
                  </div>
                </div>
              `;
              $('.timeline').append(timelineItem);
            });

            // Tampilkan modal
            $('#modalHistori').modal('show');
          } else {
            // Tampilkan pesan error jika terjadi kesalahan
            alert('Histori Toko Tidak Ditemukan.');
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          alert('Terjadi kesalahan saat mengambil data histori.');
        }
      });
    });
  });
</script>