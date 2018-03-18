<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TJabatan */

$this->title = 'Update Tjabatan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tjabatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tjabatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
