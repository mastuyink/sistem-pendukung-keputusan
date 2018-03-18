<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TKriteria */

$this->title = 'Tambah Kriteria Penilaian';
$this->params['breadcrumbs'][] = ['label' => 'List Kriteria', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tkriteria-create">

    <?= $this->render('_form', [
		'model'     => $model,
		'listTahun' => $listTahun,
		'listBulan' => $listBulan
    ]) ?>

</div>
