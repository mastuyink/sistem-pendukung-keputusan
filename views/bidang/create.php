<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TBidang */

$this->title = 'Tambah Bidang';
$this->params['breadcrumbs'][] = ['label' => 'List Bidang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbidang-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
