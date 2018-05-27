<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TKaryawan */

$this->title = 'Update Tkaryawan: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'List Karyawan', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tkaryawan-update">

    <?= $this->render('_form', [
		'model'           => $model,
		'listBidang'      => $listBidang,
		'listTempatLahir' => $listTempatLahir,
		'listPendidikan'  => $listPendidikan,
		'listJurusan'     => $listJurusan,
		'listProvinsi'     => $listProvinsi,
		'listKabupaten'     => $listKabupaten,
		'listKecamatan'     => $listKecamatan,
		'listKelurahan'     => $listKelurahan,
    ]) ?>

</div>
