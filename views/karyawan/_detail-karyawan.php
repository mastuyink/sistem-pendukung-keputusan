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
        <?php if($modelKaryawan->jenis_karyawan == $modelKaryawan::PNS):  ?>
            <tr>
                <th>Jabatan</th>
                <td>
                    <?php 
                        if (!empty($modelKaryawan->idJabatanKaryawan)) {
                         echo $modelKaryawan->idJabatanKaryawan->idJabatan->jabatan;
                        }else{
                            echo '<span class="badge bg-orange">Jabatan Belum Dipilih</span>';
                        }
                    ?>
                    
                    Bidang : <?= $modelKaryawan->idBidang->bidang ?></td>
            </tr>
        <?php else: ?>
            <tr>
                <th>Bidang</th>
                <td><?= $modelKaryawan->jenis_karyawan; ?> Bidang : <?= $modelKaryawan->idBidang->bidang ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <th>TTL</th>
            <td><?= $modelKaryawan->idTempatLahir->nama.", ".date('d-M-Y',strtotime($modelKaryawan->tanggal_lahir)) ?></td>
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
            <td><?= $modelKaryawan->idPendidikanAkhir->pendidikan_akhir ?> <?= !empty($modelKaryawan->id_pendidikan_akhir > 3) ? $modelKaryawan->idJurusanKaryawan->idJurusan->jurusan : " " ?></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td><?= "<p>".$modelKaryawan->alamat."</p> <p> Desa ".$modelKaryawan->idKelurahan->nama.", Kecamatan ".$modelKaryawan->idKelurahan->kecamatan->nama." </p><p> Kabupaten ".$modelKaryawan->idKelurahan->kecamatan->kabupaten->nama.", Provinsi ".$modelKaryawan->idKelurahan->kecamatan->kabupaten->provinsi->nama."</p>" ?></td>
        </tr>

    </tbody>
</table>

</div>
