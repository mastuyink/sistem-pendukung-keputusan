<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;

$this->title = 'Update Nilai ';
$this->params['breadcrumbs'][] = ['label' => 'Tpenilaians', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tpenilaian-update">
<div class="panel panel-success">
        <div class="panel-body">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td width="100">Nama</td>
                        <td> : <?= $model->idKaryawan->nama ?></td>
                    </tr>
                    <tr>
                        <td width="100">Bulan</td>
                        <td> : <?= $model::ambilNamaBulan($model->id_bulan)." ".$model->idTahun->tahun; ?></td>
                    </tr>
                    <tr>
                        <td width="100">Kriteria</td>
                        <td> : <?= $model->idKriteria->kriteria ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php $form = ActiveForm::begin(['enableClientValidation'=>true]); ?>

	<div id="div-nilai">
        <?= $form->field($model, 'nilai')->widget(MaskedInput::className(), [
        'mask'               => ['999','9.99','99.99'],
        'clientOptions'      => [
        'removeMaskOnSubmit' => false,
        ]
        ])?>
    </div>

     <div class="form-group ">
        <?= Html::submitButton('Simpan' , ['class' => 'btn btn-success btn-block btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
