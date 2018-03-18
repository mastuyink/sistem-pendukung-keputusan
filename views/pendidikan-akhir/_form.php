<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TPendidikanAkhir */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tpendidikan-akhir-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pendidikan_akhir')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success btn-lg btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
