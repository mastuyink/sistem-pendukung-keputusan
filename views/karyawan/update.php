<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TKaryawan */

$this->title = 'Update Tkaryawan: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Tkaryawans', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tkaryawan-update

    <?= $this->render('_form', [
		'model'           => $model,
		'listBidang'      => $listBidang,
		'listJabatan'     => $listJabatan,
		'listTempatLahir' => $listTempatLahir,
		'listPendidikan'  => $listPendidikan,
		'listJurusan'     => $listJurusan,
    ]) ?>

</div>
