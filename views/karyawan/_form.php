<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\TKaryawan */
/* @var $form yii\widgets\ActiveForm */
$model->id_jk = 1;
?>

<div class="tkaryawan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nip')->textInput(['placeholder'=>'Masukkan Nomor Induk Karyawan']) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true,'placeholder'=>'Masukkan Nama Karyawan']) ?>

    <?= $form->field($model, 'id_jk')->radioList([$model::LAKI_LAKI=>'Laki-Laki',$model::PEREMPUAN=>'Perempuan'],['inline'=>false]); ?>

    <?= $form->field($model, 'id_tempat_lahir')->widget(Select2::classname(), [
    'data' => $listTempatLahir,
    'options' => [
        'placeholder' => 'Pilih Tempat Lahir...',

    ],
    'pluginOptions' => [
        'allowClear' => false
    ],
    ]);
     ?>
    <?= $form->field($model, 'tanggal_lahir')->widget(kato\pickadate\Pickadate::classname(), [
            'isTime' => false,
            'id'=>'Tanggal Lahir',
            'options'=>[
                'id' => 'picker-tanggal-lahir',
            ]

          ]); ?>

    <?= $form->field($model, 'tanggal_kerja')->widget(kato\pickadate\Pickadate::classname(), [
            'isTime' => false,
            'id'=>'Tanggal Kerja',
            'options'=>[
                'id' => 'picker-tanggal-kerja',
            ]

          ]); ?>

    <?= $form->field($model, 'id_bidang')->dropDownList($listBidang, ['prompt' => 'Pilih Bidang ...']); ?>

    <?= $form->field($model, 'id_jabatan')->dropDownList($listJabatan, ['prompt' => 'Pilih Jabatan ...']); ?>

    <?= $form->field($model, 'tanggal_menjabat')->widget(kato\pickadate\Pickadate::classname(), [
            'isTime' => false,
            'options'=>[
                'id' => 'picker-tanggal-menjabat',
            ]

          ]); ?>

    <?= $form->field($model, 'no_telp')->widget(MaskedInput::className(), [
    'mask'               => ['999-999-999-999'],
    'clientOptions'      => [
    'removeMaskOnSubmit' => true,
    ]
    ]) ?>

    <?= $form->field($model, 'id_pendidikan_akhir')->dropDownList($listPendidikan, [
      'prompt' => 'Pilih Pendidikan Terakhir ...',
      'id' => 'form-jurusan-akhir'
      ]); ?>

    <div id="div-jurusan">
    
    
    <?= $form->field($model, 'jurusan')->widget(Select2::classname(), [
    'data' => $listJurusan,
    'options' => [
        'placeholder' => 'Pilih Jurursan...',

    ],
    'pluginOptions' => [
        'allowClear' => false
    ],
    ]);
     ?>
   </div>

    <?= $form->field($model, 'alamat')->textArea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
var x = $('#form-jurusan-akhir').val();
jurusan(x);

$('#form-jurusan-akhir').on('change',function(){
  var x = $('#form-jurusan-akhir').val();
  jurusan(x);
});

function jurusan(x){
  if (x > 3) {
    $('#div-jurusan').show();
  } else {
    $('#div-jurusan').hide();
  }

}
$('#picker-tanggal-lahir').pickadate({
  max:[1996,01,01],
  min:-21535,
  selectYears: true,
  selectMonths: true,
  format: 'dd-mmm-yyyy',
  formatSubmit: 'yyyy-mm-dd',
  today: '',
  clear: 'Hapus',
  close: 'Keluar'
});

$('#picker-tanggal-kerja').pickadate({
  max:true,
  min:-10950,
  selectYears: true,
  selectMonths: true,
  format: 'dd-mmm-yyyy',
  formatSubmit: 'yyyy-mm-dd',
  today: 'Hari Ini',
  clear: 'Hapus',
  close: 'Keluar'
});
$('#picker-tanggal-menjabat').pickadate({
  max:true,
  min:-10950,
  selectYears: true,
  selectMonths: true,
  format: 'dd-mmm-yyyy',
  formatSubmit: 'yyyy-mm-dd',
  today: 'Hari Ini',
  clear: 'Hapus',
  close: 'Keluar'
});
    ", \yii\web\View::POS_READY);
?>