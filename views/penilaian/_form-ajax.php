<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\TPenilaian */
/* @var $form yii\widgets\ActiveForm */
$model->id_bulan = date('n');
$model->id_tahun = date('Y');
?>
<div class="col-md-12">
    <?= Html::label('Karyawan', ['class' => 'label-control']); ?>
    <?= Select2::widget([
    'model'         => $model,
    'attribute'     => 'id_karyawan',
    'data'          => $listKaryawan,
    'pluginOptions' => [
        'allowClear' => false
    ],
    'options'       => [
        'placeholder' => 'Pilih Karyawan',
        'onchange' => '
        var vkaryawan = $(this).val();
         if (vkaryawan == null) {
            alert("Silahkan Pilih Karyawan")
         }
        '
    ],
]); ?>
</div>

<div class="form-group ">
        <?= Html::submitButton('Simpan' , ['class' => 'btn btn-success btn-block btn-flat']) ?>
    </div>
