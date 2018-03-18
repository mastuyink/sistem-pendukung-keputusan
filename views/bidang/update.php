<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TBidang */

$this->title = 'Update Tbidang: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbidangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbidang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
