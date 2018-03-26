<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\TKaryawan */
/* @var $form yii\widgets\ActiveForm */
$model->id_jk = 1;
if ($model->isNewRecord) {
  $listKabupaten = [];
  $listKecamatan = [];
  $listKelurahan = [];
}
?>

<div class="tkaryawan-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
  <div class="col-md-6">
    <?= $form->field($model, 'nip')->textInput(['placeholder'=>'Masukkan Nomor Induk Karyawan']) ?>
  </div>
  <div class="col-md-6">
    <?= $form->field($model, 'nama')->textInput(['maxlength' => true,'placeholder'=>'Masukkan Nama Karyawan']) ?>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
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
  </div>
  <div class="col-md-3">
    <?= $form->field($model, 'tanggal_lahir')->widget(kato\pickadate\Pickadate::classname(), [
            'isTime' => false,
            'id'=>'Tanggal Lahir',
            'options'=>[
                'id' => 'picker-tanggal-lahir',
            ]

          ]); ?>
  </div>

  <div class="col-md-3">
    <?= $form->field($model, 'id_jk')->radioList([$model::LAKI_LAKI=>'Laki-Laki',$model::PEREMPUAN=>'Perempuan'],['inline'=>false]); ?>
  </div>
  <div class="col-md-3">
   <?= $form->field($model, 'no_telp')->widget(MaskedInput::className(), [
    'mask'               => ['999-999-999-999'],
    'clientOptions'      => [
    'removeMaskOnSubmit' => true,
    ]
    ]) ?>
  </div>
</div>

<div class="row">
  <div class="col-md-4">
    <?= $form->field($model, 'tanggal_kerja')->widget(kato\pickadate\Pickadate::classname(), [
            'isTime' => false,
            'id'=>'Tanggal Kerja',
            'options'=>[
                'id' => 'picker-tanggal-kerja',
                'class' => 'form-control form-tanggal'
            ]

          ]); ?>
  </div>
  <div class="col-md-4">
    <?= $form->field($model, 'id_bidang')->dropDownList($listBidang, ['prompt' => 'Pilih Bidang ...']); ?>
  </div>
  <div class="col-md-4">
    <?= $form->field($model, 'id_jabatan')->dropDownList($listJabatan, ['prompt' => 'Pilih Jabatan ...']); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-4">
    <?= $form->field($model, 'tanggal_menjabat')->widget(kato\pickadate\Pickadate::classname(), [
            'isTime' => false,
            'options'=>[
                'id' => 'picker-tanggal-menjabat',
            ]

          ]); ?>
  </div>
  <div class="col-md-4">
   <?= $form->field($model, 'id_pendidikan_akhir')->dropDownList($listPendidikan, [
      'prompt' => 'Pilih Pendidikan Terakhir ...',
      'id' => 'form-jurusan-akhir'
      ]); ?>
  </div>
  <div id="div-jurusan" class="col-md-4">
    
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

</div>

<div class="row">
  <div class="col-md-3">
    <?= $form->field($model, 'id_provinsi')->widget(Select2::classname(), [
    'data' => $listProvinsi,
    'options' => [
        'placeholder' => 'Pilih Provinsi...',
        'id'          => 'dropdown-provinsi',

    ],
    'pluginOptions' => [
        'allowClear' => false
    ],
    ]);
     ?>
  </div>

  <div class="col-md-3">
    <?= $form->field($model, 'id_kabupaten')->widget(Select2::classname(), [
    'data' => $listKabupaten,
    'options' => [
        'placeholder' => 'Pilih Kabupaten...',
        'id'          => 'dropdown-kabupaten'
    ],
    'pluginOptions' => [
        'allowClear' => false
    ],
    ]);
     ?>
  </div>

  <div class="col-md-3">
    <?= $form->field($model, 'id_kecamatan')->widget(Select2::classname(), [
    'data' => $listKecamatan,
    'options' => [
        'placeholder' => 'Pilih Kecamatan...',
        'id'          => 'dropdown-kecamatan'
    ],
    'pluginOptions' => [
        'allowClear' => false
    ],
    ]);
     ?>
  </div>
  <div class="col-md-3">
    <?= $form->field($model, 'id_kelurahan')->widget(Select2::classname(), [
    'data' => $listKelurahan,
    'options' => [
        'placeholder' => 'Pilih Kelurahan...',
        'id'          => 'dropdown-kelurahan'

    ],
    'pluginOptions' => [
        'allowClear' => false
    ],
    ]);
     ?>
  </div>
  
</div>
<div class="row">
  
  <div class="col-md-12">
    <?= $form->field($model, 'alamat')->textArea(['maxlength' => true]) ?>
  </div>
</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success btn-block btn-lg btn-flat' : 'btn btn-primary btn-block btn-lg btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
$customCss = <<< SCRIPT
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fff;
}
    label {
        font-size: 14px;
    }
    #tkaryawan-tanggal_lahir, #tkaryawan-tanggal_kerja{
        background-color: #fff;
    }
SCRIPT;
$this->registerCss($customCss);
$this->registerJs("
$(document).ready(function(){
  $('#picker-tanggal-lahir').attr('placeholder','Tanggal Lahir');
  $('#picker-tanggal-menjabat').attr('placeholder','Tanggal Menjabat');
  $('#picker-tanggal-kerja').attr('placeholder','Tanggal Kerja');
  var idProvinsi = $('#dropdown-provinsi').val();
  // if (idProvinsi != ''){
  //   Kabupaten(idProvinsi);
  //   // $('#dropdown-kabupaten').val(3526);
  //   // var idKabupaten = $('#dropdown-kabupaten').val();
  //   // alert(idKabupaten);
  //   // if (idKabupaten != ''){
  //   //   Kecamatan(idKabupaten);
  //   //   var idKecamatan = $('#dropdown-kecamatan').val();

  //   //   if (idKecamatan != ''){
  //   //     Kelurahan(idKecamatan);
  //   //   }
  //   // }

  // } else {
  //   return false;
  // }
});

$('#dropdown-kecamatan').on('change',function(){
  var idKecamatan = $(this).val();
  Kelurahan(idKecamatan);
});

$('#dropdown-kabupaten').on('change',function(){
  var idKabupaten = $(this).val();
  Kecamatan(idKabupaten);
  $('#dropdown-kelurahan').html('');
});

$('#dropdown-provinsi').on('change',function(){
  var idProvinsi = $(this).val();
  Kabupaten(idProvinsi);
  $('#dropdown-kelurahan').html('');
  $('#dropdown-kecamatan').html('');

});

function Kelurahan(idKecamatan){
  $.ajax({
    url: '".Url::to(['dropdown-kelurahan'])."?id_kecamatan='+idKecamatan,
    type: 'GET',
    success: function(data){
      $('#dropdown-kelurahan').html(data);
    }

  });
}

function Kecamatan(idKabupaten){
  $.ajax({
    url: '".Url::to(['dropdown-kecamatan'])."?id_kabupaten='+idKabupaten,
    type: 'GET',
    success: function(data){
      $('#dropdown-kecamatan').html(data);
    }

  });
}

function Kabupaten(idProvinsi){
  $.ajax({
    url: '".Url::to(['dropdown-kabupaten'])."?id_provinsi='+idProvinsi,
    type: 'GET',
    success: function(data){
      $('#dropdown-kabupaten').html(data);
    }

  });
}

var x = $('#form-jurusan-akhir').val();
jurusan(x);

$('#form-jurusan-akhir').on('change',function(){
  var x = $('#form-jurusan-akhir').val();
  jurusan(x);
});

function jurusan(x){
  if (x > 3) {
    $('#div-jurusan').css('visibility','visible');
  } else {
    $('#div-jurusan').css('visibility','hidden');
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