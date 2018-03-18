<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TJabatan */

$this->title = 'Tambah Jabatan';
$this->params['breadcrumbs'][] = ['label' => 'List Jabatan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tjabatan-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
