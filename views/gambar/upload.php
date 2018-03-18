<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>
    <?= $form->field($model, 'caption')->textInput(['placeholder' => 'Insert Caption For this Image (Optional)']); ?>

    <?= Html::submitButton('Upload', ['class' => 'btn btn-primary btn-flat']); ?>

<?php ActiveForm::end() ?>