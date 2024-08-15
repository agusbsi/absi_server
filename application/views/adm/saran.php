<section>
    <div class="card card-primary">
        <div class="card-header">
            Saran & Masukan
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Rating</th>
                        <th>Kritik</th>
                        <th>Saran</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($saran as $s):
                        $no++; ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $s->nama ?></td>
                            <td><?= $s->rating ?></td>
                            <td>
                                <address>
                                    <small><?= $s->kritik ?></small>
                                </address>
                            </td>
                            <td>
                                <address>
                                    <small><?= $s->saran ?></small>
                                </address>
                            </td>
                            <td>
                                <small><?= date('d F Y', strtotime($s->created_at)) ?></small>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>