<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\models\TPenilaian */

$this->title = 'Tambah Penilaian';
$this->params['breadcrumbs'][] = ['label' => 'List Penilaian', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->id_tahun = date('Y')
?>

<div class="tpenilaian-form">

    <?php $form = ActiveForm::begin(['enableClientValidation'=>true]); ?>
    <div class="col-md-12">
        <div class="col-md-2">
            <?= $form->field($model, 'id_bulan')->dropDownList($listBulan, [
                'prompt' => 'Pilih Bulan...',
                'id' => 'form-bulan',
                'class' => 'form-bulan-tahun form-control'

                ]); ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'id_tahun')->dropDownList($listTahun, [
                'id' => 'form-tahun',
                'class' => 'form-bulan-tahun form-control'
                ]); ?>
        </div>
    </div>
    <?= $form->field($model, 'id_karyawan')->widget(Select2::classname(), [
    'data' => [],
    'options' => [
        'id' => 'form-karyawan',
        'placeholder' => 'Pilih Karyawan...',

    ],
    'pluginOptions' => [
        'allowClear' => false
    ],
    ]); ?>
    <?php Pjax::begin(['id'=>'pjax-penilaian']) ?>
    <?php foreach ($jumlahKriteria as $index => $value): ?>
        <div class="col-md-2">
            <?php $idPeriodeKriteria = $value['id'] ?>
            <label class="label-control"><?= $value['idKriteria']['kriteria'] ?></label>
            <?= MaskedInput::widget([
                'name' => 'nilai',
                'mask' => ['999','9','9.99','99','99.9','99.99'],
                'options'=>[
                    'id'=>'form-masked-'.$index,
                    'class' => 'form-control'
                ]
            ]); ?>
        </div>
    <?php endforeach; ?>
    <?php Pjax::end() ?>
    <br>
    <div class="form-group ">
        <?= Html::submitButton('Simpan' , ['class' => 'btn btn-success btn-block btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php 
$this->registerJs('
$(document).ready(function(){
    var vbulan = $("#form-bulan").val();
    var vtahun = $("#form-tahun").val();
    cariKaryawan(vbulan, vtahun);
    var vkaryawan = $("#form-karyawan").val();
    cariKriteria(vbulan, vtahun, vkaryawan);

});
$(".form-bulan-tahun").on("change",function(){
    var vbulan = $("#form-bulan").val();
    var vtahun = $("#form-tahun").val();
    cariKaryawan(vbulan, vtahun);
});

$("#form-karyawan").on("change",function(){
    var vkaryawan = $("#form-karyawan").val();
    var vbulan    = $("#form-bulan").val();
    var vtahun    = $("#form-tahun").val();
    cariKriteria(vbulan, vtahun, vkaryawan);
});

// $("input:radio.radio-kriteria-penilaian").on("change",function(){
//     var vkriteria = $("input:radio.radio-kriteria-penilaian:checked").val();
//     alert(vkriteria);
// });

// function kriteriaTerpilih(val){
//     if (val == "") {
//         $("#div-nilai").hide();
//     } elseif (val == "1") {
//         $("#div-jumlah-absensi").show();
//         $("#div-nilai").hide();
//     } 
// }

function cariKaryawan(vbulan, vtahun){
if (vbulan == "" || vtahun == ""){
        $("#tpenilaian-id_kriteria").html("<b>Silahkan Isi Form Tahun, Bulan dan Karyawan</b>");
        return false;
    } else {
        $.ajax({
            url: "'.Url::to(['cari-data-karyawan']).'",
            type: "POST",
            data: {bulan: vbulan, tahun: vtahun},
            success : function(data){
                $("#form-karyawan").html(data);
                 $("#tpenilaian-id_kriteria").html("<b>Silahkan Isi Form Tahun, Bulan dan Karyawan</b>");
            }
        })
    }
}

function cariKriteria(vbulan, vtahun, vkaryawan){
    if (vkaryawan == "" || vbulan == "" || vtahun == "") {
            $("#tpenilaian-id_kriteria").html("<b>Silahkan Isi Form Tahun, Bulan dan Karyawan</b>");
            return false;
        } else {
            $.pjax.reload({
                url: "/penilaian/create",
                type: "POST",
                data: {id_karyawan: vkaryawan, bulan: vbulan, tahun: vtahun},
                container: "#pjax-penilaian",
            });
           
        }
}
    ', \yii\web\View::POS_READY);
?>
