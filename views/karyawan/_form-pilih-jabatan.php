<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

$this->title = "Pilih Jabatan Karyawan ";
$this->params['breadcrumbs'][] = ['label' => 'List Karyawan', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Pilih Jabatan';
?>

<div class="tkaryawan-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">
    	<?= $form->field($jabatanKayawan, 'id_jabatan')->dropDownList($listJabatan, ['prompt' => 'Pilih Jabatan']); ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($jabatanKayawan, 'tanggal_menjabat')->widget(kato\pickadate\Pickadate::classname(), [
            'isTime' => false,
            'id'=>'Tanggal Menjabat',
            'options'=>[
                'id' => 'picker-tanggal-menjabat',
                'class' => 'form-control form-tanggal'
            ]

          ]); ?>
    </div>
    <div class="col-md-12">
    	<?= Html::submitButton('Simpan', ['class' => 'btn btn-lg btn-success btn-block']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs("
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