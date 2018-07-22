<?php 
use yii\helpers\Html;
 ?>
<center><h3>Laporan Karyawan Sisten Pendukung Keputusan Dinas Perindustrian dan Perdagangan</h3></center>
<h3>Bulan <?= $modelHasilAkhir[0]::ambilNamaBulan($modelHasilAkhir[0]['id_bulan']) ?> Tahun <?= $modelHasilAkhir[0]['idTahun']['tahun'] ?></h3>

	<table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Total Nilai</th>
                    <th>Ranking</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach($modelHasilAkhir as $key => $valueHasilAkhir): ?>
                    <?php
                        $data = [
                            'id_bulan'    => $valueHasilAkhir->id_bulan,
                            'id_tahun'    => $valueHasilAkhir->id_tahun,
                            'id_karyawan' => $valueHasilAkhir->id_karyawan,
                        ];
                    ?>
                    <tr>
                        <td width="25"><?= $key+1 ?></td>
                        <td><?= $valueHasilAkhir->idKaryawan->nip ?></td>
                        <td><?= $valueHasilAkhir->idKaryawan->nama ?></td>
                        <td><?= $valueHasilAkhir->total ?></td>
                        <td><?= $valueHasilAkhir::ambilRanking($data) ?></td>
                    </tr>
               <?php endforeach; ?>
            </tbody>
    </table>
