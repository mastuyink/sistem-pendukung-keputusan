<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kato\pickadate\Pickadate;
/* @var $this yii\web\View */
/* @var $model app\models\TKaryawanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tkaryawan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
<div class="col-md-3">
    <?= $form->field($model, 'nip')->widget(Select2::classname(), [
    'data' => ArrayHelper::map($listKaryawan, 'nip', 'nip'),
    'options' => [
        'placeholder' => 'Pilih NIP...',

    ],
    'pluginOptions' => [
        'allowClear' => true,
        'tags' => true
    ],
    ]); ?>
</div>
<div class="col-md-3">
    <?= $form->field($model, 'nama')->widget(Select2::classname(), [
    'data' => ArrayHelper::map($listKaryawan, 'nama', 'nama'),
    'options' => [
        'placeholder' => 'Cari Nama Karyawan...',

    ],
    'pluginOptions' => [
        'allowClear' => true,
        'tags' => true
    ],
    ]); ?>
</div>
<div class="col-md-3">
    <?= $form->field($model, 'id_jk')->dropDownList(['1'=>'Laki-Laki','2'=>'Perempuan'], ['prompt' => 'Semua Jenis Kelamin']); ?>
</div>
<div class="col-md-3">
    <?= $form->field($model, 'id_tempat_lahir')->widget(Select2::classname(), [
    'data' => ArrayHelper::map($listKaryawan, 'id_tempat_lahir', 'idTempatLahir.nama'),
    'options' => [
        'placeholder' => 'Cari Tempat Lahir...',

    ],
    'pluginOptions' => [
        'allowClear' => true,
    ],
    ]); ?>
</div>

<div class="col-md-3">
    <?= $form->field($model, 'id_bidang')->widget(Select2::classname(), [
    'data' => ArrayHelper::map($listKaryawan, 'id_bidang', 'idBidang.bidang'),
    'options' => [
        'placeholder' => 'Semua Bidang...',

    ],
    'pluginOptions' => [
        'allowClear' => true,
    ],
    ]); ?>
</div>
<div class="col-md-3">
    <?= $form->field($model, 'id_jabatan')->widget(Select2::classname(), [
    'data' => ArrayHelper::map($listKaryawan, 'id_jabatan', 'idJabatan.jabatan'),
    'options' => [
        'placeholder' => 'Cari Jabatann...',

    ],
    'pluginOptions' => [
        'allowClear' => true,
        'tags' => true
    ],
    ]); ?>
</div>
<div class="col-md-3">
    <?php // echo $form->field($model, 'no_telp') ?>
</div>
<div class="col-md-3">
    <?php // echo $form->field($model, 'alamat') ?>
</div>
<div class="col-md-3">
    <?php // echo $form->field($model, 'id_user') ?>
</div>
<div class="col-md-3">
    <?php // echo $form->field($model, 'create_at') ?>
</div>
<div class="col-md-3">
    <?php // echo $form->field($model, 'update_at') ?>
</div>
    <div class="form-group col-md-12">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
