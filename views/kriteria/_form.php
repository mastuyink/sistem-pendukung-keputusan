<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\models\TKriteria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tkriteria-form">

    <?php $form = ActiveForm::begin(); ?>
    

    <?= $form->field($model, 'kriteria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bobot')->widget(MaskedInput::className(), [
    'mask'               => ['99%'],
    'clientOptions'      => [
    'removeMaskOnSubmit' => true,
    ]
    ])->label('Bobot Penilaian Dalam %') ?>

    <?= Html::error($model, 'total_bobot', ['style'=>'color:red;','class' => 'help-block']); ?>
<div class="row">
  <div class="col-sm-2">
    <?= $form->field($model, 'id_bulan_valid_start')->dropDownList($listBulan, ['id' => 'drop-bulan-start']); ?>
  </div>
  <div class="col-sm-2">
    <?= $form->field($model, 'id_tahun_valid_start')->dropDownList($listTahun, ['id' => 'drop-tahun-start']); ?>
  </div>
</div>

<div class="row">
  <div class="col-sm-2">
    <?= $form->field($model, 'id_bulan_valid_end')->dropDownList($listBulan, ['id' => 'drop-bulan-end']); ?>
  </div>
  <div class="col-sm-2">
    <?= $form->field($model, 'id_tahun_valid_end')->dropDownList($listTahun, ['id' => 'drop-tahun-end']); ?>
  </div>
</div>

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