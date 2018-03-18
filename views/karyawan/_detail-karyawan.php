<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TKaryawan */
?>
<div class="tkaryawan-view row col-md-12">
<table class="table table-responsive table-stripped table-hover">
    <tbody>
        <tr>
            <th>NIP</th>
            <td><?= $modelKaryawan->nip ?></td>
        </tr>
        <tr>
            <th>Nama</th>
            <td><?= $modelKaryawan->nama ?></td>
        </tr>
        <tr>
            <th>Jabatan</th>
            <td><?= $modelKaryawan->idJabatan->jabatan." Bidang : ".$modelKaryawan->idBidang->bidang ?></td>
        </tr>
        <tr>
            <th>TTL</th>
            <td><?= $modelKaryawan->idTempatLahir->tempat_lahir.", ".date('d-M-Y',strtotime($modelKaryawan->tanggal_lahir)) ?></td>
        </tr>
        <tr>
            <th>Tanggal Kerja</th>
            <td><?= date('d-M-Y',strtotime($modelKaryawan->tanggal_kerja)) ?></td>
        </tr>
        <tr>
            <th>Telp</th>
            <td><?= $modelKaryawan->no_telp ?></td>
        </tr>
        <tr>
            <th>Pendidikan</th>
            <td><?= $modelKaryawan->idPendidikanAkhir->pendidikan_akhir ?> <?= !empty($modelKaryawan->id_pendidikan_akhir > 3) ? $modelKaryawan->idJurusanKaryawan->jurusan->jurusan : " " ?></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td><?= $modelKaryawan->alamat ?></td>
        </tr>

    </tbody>
</table>

</div>
