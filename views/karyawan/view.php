<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TKaryawan */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tkaryawans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tkaryawan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nip',
            'nama',
            'id_jk',
            'id_tempat_lahir',
            'tanggal_lahir',
            'tanggal_kerja',
            'id_bidang',
            'id_jabatan',
            'no_telp',
            'alamat',
            'id_user',
            'create_at',
            'update_at',
        ],
    ]) ?>

</div>
