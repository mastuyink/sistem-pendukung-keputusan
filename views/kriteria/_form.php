<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\models\TKriteria */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
    
<div class="row">
  <div class="col-sm-12">
    <?= $form->field($model, 'kriteria')->textInput(['maxlength' => true]) ?>
  </div>
  <div class="col-md-12">
    <?= $form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className(), [
    'clientOptions' => [
        'plugins' => [
                'clips',
                'fontcolor',
                'table',
                'clips',
                'fontfamily',
                'fontsize',
                ]
    ]
    ])?>
  </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-flat btn-lg btn-block btn-success' : 'btn btn-flat btn-lg btn-block btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
$customCss = <<< SCRIPT
    label {
        font-size: 14px;
    }
    #tkaryawan-tanggal_lahir, #tkaryawan-tanggal_kerja{
        background-color: #fff;
    }
SCRIPT;
$this->registerCss($customCss);
$this->registerJs("
$('#picker-valid-start').pickadate({
  min: true,
  format: 'dd-mmm-yyyy',
  formatSubmit: 'yyyy-mm-dd',
  clear:'',
  today:'Hari Ini',
});

$('#picker-valid-end').pickadate({
  format: 'dd-mmm-yyyy',
  formatSubmit: 'yyyy-mm-dd',
  clear:'',
  today:'',
});

var from_input = $('#picker-valid-start').pickadate(),
    from_picker = from_input.pickadate('picker')

var to_input = $('#picker-valid-end').pickadate(),
    to_picker = to_input.pickadate('picker')


// Check if there’s a “from” or “to” date to start with.
if ( from_picker.get('value') ) {
  to_picker.set('min', from_picker.get('select'))
}


// When something is selected, update the “from” and “to” limits.
from_picker.on('set', function(event) {
  if ( event.select ) {
    to_picker.set('min', from_picker.get('select'))    
  }
  else if ( 'clear' in event ) {
    to_picker.set('min', false)
  }
});
    ", \yii\web\View::POS_READY);
?>