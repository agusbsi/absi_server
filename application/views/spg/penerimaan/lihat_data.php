<style>
  /* Card PO Styling */
  .card-po {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    padding: 20px;
    box-sizing: border-box;
    margin: 0 auto 20px;
  }

  .card-po-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
  }

  .card-po-number {
    font-size: 18px;
    font-weight: bold;
    color: #007bff;
  }

  .card-po-date {
    font-size: 12px;
    color: #666;
  }

  .card-po-subheader {
    font-size: 14px;
    color: #333;
    margin-bottom: 10px;
  }

  .card-po-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
  }

  .card-po-label {
    color: #999;
  }

  .card-po-value {
    font-weight: bold;
    color: #333;
  }

  .card-po-status {
    background: #ffeaa7;
    color: #d35400;
    padding: 4px 8px;
    border-radius: 8px;
    font-size: 12px;
    display: inline-block;
    text-transform: capitalize;
  }

  .card-po-btn {
    display: block;
    width: 100%;
    background: #007bff;
    color: #fff;
    text-align: center;
    padding: 10px 0;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    font-size: 14px;
    margin-top: 20px;
  }

  .card-po-btn:hover {
    background: #0056b3;
  }

  /* Responsive rules */
  @media (max-width: 768px) {
    .table-responsive {
      display: none;
    }

    .card-po-wrapper {
      display: block;
    }
  }

  @media (min-width: 769px) {
    .card-po-wrapper {
      display: none;
    }
  }
</style>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">

    </div>
  </div>
  <div class="row">
    <!-- /.col -->
    <div class="col-md-12">
      <div class="card card-info ">
        <div class="card-header">
          <h3 class="card-title">
            <li class="fas fa-check-circle"></li> Data Penerimaan
          </h3>
          <div class="card-tools">
            <a href="<?= base_url('spg/Dashboard') ?>" type="button" class="btn btn-tool">
              <i class="fas fa-times"></i>
            </a>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="table-responsive">
            <!-- isi konten -->
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th>No.</th>
                  <th>No Pengiriman</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                  <th>Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($list_data as $dd) :
                  $no++;
                ?>
                  <tr class="text-center">
                    <td><?= $no ?></td>
                    <td><?= $dd->id ?></td>
                    <td><?= status_pengiriman($dd->status) ?></td>
                    <td><?= $dd->created_at ?></td>

                    <td>
                      <?php
                      if ($dd->status == 1) {
                      ?>
                        <a type="button" class="btn btn-success btn-sm" href="<?= base_url('spg/penerimaan/terima/' . $dd->id) ?>"><i class="fas fa-arrow-circle-right" aria-hidden="true"></i> Proses</a>
                      <?php
                      } else {
                      ?>
                        <a type="button" class="btn btn-primary btn-sm" href="<?= base_url('spg/penerimaan/detail/' . $dd->id) ?>"><i class="fas fa-eye" aria-hidden="true"></i> Detail</a>
                      <?php }
                      ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>

            </table>
          </div>
          <!-- Card untuk Mobile -->
          <div class="card-po-mobile-tools d-block d-md-none">
            <input type="text" id="cardPoSearch" class="form-control mb-3" placeholder="Cari Nomor PO atau Nama Toko...">
          </div>


          <div class="card-po-wrapper" id="cardPoList">
            <?php foreach ($list_data as $dd) : ?>
              <div class="card-po">
                <div class="card-po-header">
                  <div class="card-po-number"><?= $dd->id ?></div>
                  <div class="card-po-date"><?= date('d-M-Y', strtotime($dd->created_at)) ?></div>
                </div>
                <div class="card-po-subheader">No PO: <a href="<?= base_url('spg/permintaan/detail/' . $dd->id_permintaan) ?>"><?= $dd->id_permintaan ?></a></div>
                <div class="card-po-info">
                  <div class="card-po-label">Status</div>
                  <div><?= status_pengiriman($dd->status); ?></div>
                </div>
                <?php
                if ($dd->status == 1) {
                ?>
                  <a class="btn btn-success btn-sm btn-block" href="<?= base_url('spg/penerimaan/terima/' . $dd->id) ?>"><i class="fa fa-arrow-circle-right"></i> Terima</a>
                <?php
                } else {
                ?>
                  <a class="btn btn-primary btn-sm btn-block" href="<?= base_url('spg/penerimaan/detail/' . $dd->id) ?>"><i class="fa fa-eye"></i> Detail</a>
                <?php }
                ?>

              </div>
            <?php endforeach; ?>
          </div>

          <!-- Pagination -->
          <div class="card-po-pagination mt-3 text-center d-block d-md-none" id="cardPoPagination"></div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('cardPoSearch');
    const cardList = document.getElementById('cardPoList');
    const pagination = document.getElementById('cardPoPagination');
    const cards = Array.from(cardList.getElementsByClassName('card-po'));

    let currentPage = 1;
    const cardsPerPage = 5;

    function displayCards(filteredCards) {
      const start = (currentPage - 1) * cardsPerPage;
      const end = start + cardsPerPage;
      cards.forEach(card => card.style.display = 'none');
      filteredCards.slice(start, end).forEach(card => card.style.display = 'block');
    }

    function updatePagination(filteredCards) {
      pagination.innerHTML = '';
      const pageCount = Math.ceil(filteredCards.length / cardsPerPage);

      if (pageCount <= 1) return;

      const createPageButton = (text, page) => {
        const btn = document.createElement('button');
        btn.textContent = text;
        btn.className = 'btn btn-sm btn-primary mx-1';
        if (page === currentPage) {
          btn.classList.add('active');
        }
        btn.addEventListener('click', () => {
          currentPage = page;
          displayCards(filteredCards);
          updatePagination(filteredCards);
        });
        return btn;
      };

      // Prev Button
      if (currentPage > 1) {
        const prevBtn = createPageButton('« Prev', currentPage - 1);
        pagination.appendChild(prevBtn);
      }

      // Number Buttons
      let startPage = Math.max(1, currentPage - 1);
      let endPage = Math.min(pageCount, currentPage + 1);

      if (currentPage === 1) endPage = Math.min(3, pageCount);
      if (currentPage === pageCount) startPage = Math.max(1, pageCount - 2);

      for (let i = startPage; i <= endPage; i++) {
        const pageBtn = createPageButton(i, i);
        pagination.appendChild(pageBtn);
      }

      // Next Button
      if (currentPage < pageCount) {
        const nextBtn = createPageButton('Next »', currentPage + 1);
        pagination.appendChild(nextBtn);
      }
    }

    function filterCards() {
      const keyword = searchInput.value.toLowerCase();
      const filtered = cards.filter(card =>
        card.textContent.toLowerCase().includes(keyword)
      );
      currentPage = 1;
      displayCards(filtered);
      updatePagination(filtered);
    }

    // Tambahan: hanya aktif kalau di mobile
    function initMobileFeatures() {
      if (window.innerWidth < 768) {
        searchInput.addEventListener('input', filterCards);
        filterCards();
      }
    }

    initMobileFeatures();
  });
</script>