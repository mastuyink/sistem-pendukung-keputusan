<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TKriteria */

$this->title = 'Update Tkriteria: ' . $model->kriteria;
$this->params['breadcrumbs'][] = ['label' => 'List Kriteria', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tkriteria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listTahun' => $listTahun,
        'listBulan' => $listBulan
    ]) ?>

</div>
