<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\TPenilaianSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tpenilaian-search">
<?php
$config = ['template'=>"<div class='col-md-2'>{label}{input}\n{error}\n{hint}</div>"];
$this->registerJs(
   '$("document").ready(function(){
        $("#pjax-form-search").on("pjax:start", function() {
            $("#loading-pjax").html(\'<img src="/img/spinner.svg">\');
        }); 
        $("#pjax-form-search").on("pjax:end", function() {
            
            $.pjax.reload({
                container:"#pjax-table-penilaian",
                timeout: 5000,
            });  //Reload GridView
            $("#loading-pjax").empty();

        });
    });'
);
?>

<?php yii\widgets\Pjax::begin(['id' => 'pjax-form-search']) ?>
    <?php $form = ActiveForm::begin([
        'options' => ['data-pjax' => true ],
        'action' => [$currentUrl],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_karyawan',$config)->widget(Select2::classname(), [
    'data' => $listKaryawan,
    'theme' => Select2::THEME_BOOTSTRAP,
    'size' => Select2::SMALL,
    'options' => [
        'placeholder' => 'Semua Karyawan',
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
    ]); ?>

    <?= $form->field($model, 'id_bulan',$config)->dropDownList($listBulan, [
        'prompt' => 'Semua Bulan...',
        'class' => 'form-control input-sm'
    ]); ?>

    <?= $form->field($model, 'id_tahun',$config)->dropDownList($listTahun, [
        'prompt' => 'Semua Bulan...',
        'class' => 'form-control input-sm'
    ]); ?>
<?php if(Yii::$app->request->pathInfo == "penilaian/index"): ?>
    <?= $form->field($model, 'id_kriteria',$config)->dropDownList($listKriteria, [
        'prompt' => 'Semua Kriteria...',
        'class' => 'form-control input-sm'
    ]); ?>
<?php endif; ?>

    <div class="form-group col-md-12">
        <?= Html::submitButton('', [
            'class' => 'btn btn-lg btn-flat btn-primary fa fa-search',
            'data-toggle' => 'tooltip',
            'title' => 'Cari'
            ]) ?>
        <?= Html::a('',[$currentUrl], [
                'class' => 'btn btn-lg btn-flat btn-info fa fa-refresh',
                'data-toggle'=>'tooltip',
                'title'=>'Reset Filter',
                ]) ?>
        
    </div>

    <?php ActiveForm::end(); ?>
<?php yii\widgets\Pjax::end(); ?>

</div>
