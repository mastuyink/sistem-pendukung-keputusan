<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TPenilaian */

$this->title = 'Tambah Penilaian';
$this->params['breadcrumbs'][] = ['label' => 'List Penilaian', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tpenilaian-create">

    <?= $this->render('_form', [
        'model'     => $model,
		'listBulan' => $listBulan,
		'listTahun' => $listTahun,
    ]) ?>

</div>
