<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\models\TPeriodeKriteria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tperiode-kriteria-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'id_bulan_valid_start')->dropDownList($listBulan,['prompt'=>'Pilih...']); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_tahun_valid_start')->dropDownList($listTahun,['prompt'=>'Pilih...']); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_bulan_valid_end')->dropDownList($listBulan,['prompt'=>'Pilih...']); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_tahun_valid_end')->dropDownList($listTahun,['prompt'=>'Pilih...']); ?>
        </div>
    </div>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'id_kriteria')->dropDownList($listKriteria,['prompt'=>'Pilih...']); ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'bobot')->widget(MaskedInput::className(), [
        'mask'               => ['99%'],
        'clientOptions'      => [
        'removeMaskOnSubmit' => true,
        ]
        ])->label('Bobot Penilaian Dalam %') ?>
        <?= Html::error($model, 'total_bobot', ['style'=>'color:#dd4b39;']); ?>
    </div>
    <div class="col-md-4">
        <br>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success btn-lg btn-block']) ?>
    </div>
</div>

    

    <?php ActiveForm::end(); ?>

</div>
