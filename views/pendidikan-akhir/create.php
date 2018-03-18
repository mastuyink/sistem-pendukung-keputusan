<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TPendidikanAkhir */

$this->title = 'Tambah Pendidikan Akhir';
$this->params['breadcrumbs'][] = ['label' => 'Lst Pendidikan Akhir', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tpendidikan-akhir-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
