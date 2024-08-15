<style>
    .rating {
        display: flex;
        justify-content: center;
        direction: rtl;
    }

    .rating input {
        display: none;
    }

    .rating label {
        font-size: 2em;
        color: #ddd;
        cursor: pointer;
        padding: 0 5px;
    }

    .rating input:checked~label,
    .rating label:hover,
    .rating label:hover~label {
        color: #f5b301;
    }

    .sembunyi {
        cursor: pointer;
        color: #007bff;
        border-bottom: 1px solid #007bff;
        margin: 2px;
        padding: 2px;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <form action="<?= base_url('profile/saran_kirim') ?>" method="post" id="feedbackForm">
                <div class="card-header text-center">
                    SARAN & MASUKAN
                </div>
                <div class="card-body ">
                    <div class="text-center">Beri Rating untuk ABSI</div>
                    <div class="rating text-center">
                        <input type="radio" id="star5" value="5" /><label for="star5" title="5 stars">★</label>
                        <input type="radio" id="star4" value="4" /><label for="star4" title="4 stars">★</label>
                        <input type="radio" id="star3" value="3" /><label for="star3" title="3 stars">★</label>
                        <input type="radio" id="star2" value="2" /><label for="star2" title="2 stars">★</label>
                        <input type="radio" id="star1" value="1" /><label for="star1" title="1 star">★</label>
                    </div>
                    <input type="hidden" name="rating" required>
                    <hr>
                    <div class="form-group">
                        <div style="width:100%;display: flex;justify-content: space-between;">
                            <strong>Nama</strong>
                            <span id="toggleAnonym" class="sembunyi">Sembunyikan</span>
                        </div>
                        <input type="text" name="nama" id="nama" class="form-control form-control-sm" value="<?= $this->session->userdata('nama_user') ?>">
                    </div>
                    <div class="form-group">
                        <strong>Kritik</strong>
                        <textarea name="kritik" class="form-control form-control-sm"></textarea>
                    </div>
                    <div class="form-group">
                        <strong>Saran & Masukan</strong>
                        <textarea name="saran" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-paper-plane"></i> Kirim</button>
                </div>
            </form>
        </div>

    </div>
</section>
<script>
    document.getElementById('toggleAnonym').addEventListener('click', function() {
        var namaField = document.getElementById('nama');
        if (namaField.value !== 'anonimus') {
            namaField.value = 'anonimus';
            namaField.readOnly = true;
        } else {
            namaField.value = '<?= $this->session->userdata('nama_user') ?>';
            namaField.readOnly = false;
        }
    });
    const stars = document.querySelectorAll('.rating input[type="radio"]');
    const ratingInput = document.querySelector('input[name="rating"]');
    stars.forEach(star => {
        star.addEventListener('change', function() {
            ratingInput.value = this.value;
        });
    });


    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var ratingValue = document.querySelector('input[name="rating"]').value;
        if (!ratingValue) {
            Swal.fire(
                'RATING KOSONG',
                'Silakan beri rating terlebih dahulu.',
                'info'
            );
        } else {
            this.submit();
        }
    });
</script>