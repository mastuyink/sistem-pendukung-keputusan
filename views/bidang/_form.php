<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TBidang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbidang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bidang')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
