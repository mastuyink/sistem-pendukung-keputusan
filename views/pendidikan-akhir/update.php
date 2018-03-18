<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TPendidikanAkhir */

$this->title = 'Update Pendidikan Akhir';
$this->params['breadcrumbs'][] = ['label' => 'Lists Pendidikan Akhir', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tpendidikan-akhir-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
