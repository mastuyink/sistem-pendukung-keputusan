<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TKaryawan */

$this->title = 'Tambah Data Karyawan';
$this->params['breadcrumbs'][] = ['label' => 'List Karyawan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tkaryawan-create">

    <?= $this->render('_form', [
		'model'           => $model,
		'listBidang'      => $listBidang,
		'listTempatLahir' => $listTempatLahir,
		'listPendidikan' => $listPendidikan,
		'listJurusan' => $listJurusan,
		'listProvinsi' => $listProvinsi,
    ]) ?>

</div>
