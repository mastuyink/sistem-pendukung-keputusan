<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TJurusan */

$this->title = 'Update Jurusan:'.$model->jurusan;
$this->params['breadcrumbs'][] = ['label' => 'Data Jurusan', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tjurusan-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
