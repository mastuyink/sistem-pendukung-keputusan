<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="row">
<?php $form = ActiveForm::begin(); ?>
<div class="col-md-12">
<?= $form->field($modelKaryawan, 'id_user')->radioList($listUser, ['class' => 'col-md-12']); ?>
</div>
<br><br>&nbsp<br>
<div class="col-md-12">
        <?= Html::submitButton('Simpan', ['class' =>'btn btn-primary btn-block btn-flat']) ?>
</div>
 <?php ActiveForm::end(); ?>
</div>