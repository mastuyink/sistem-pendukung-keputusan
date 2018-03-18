<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TTahun */

$this->title = 'Update Ttahun: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ttahuns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ttahun-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
