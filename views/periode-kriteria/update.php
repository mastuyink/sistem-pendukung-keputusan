<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\models\TPeriodeKriteria */

$this->title = 'Update Periode Kriteria';
$this->params['breadcrumbs'][] = ['label' => 'List Periode Kriteria', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="tperiode-kriteria-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    	<div class="col-md-12">
    		<div class="box box-primary">
	            <div class="box-header with-border">
	            		<center><h3 class="box-title"><?= $this->title ?></h3></center>
	              <!-- /.box-tools -->
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	            	<div class="row">
	              		<div class="col-md-12">
	              			<table class="table table-stripped table-responsive">
	              				<thead>
	              					<tr>
	              						<th>Periode</th>
	              						<th>Kriteria</th>
	              					</tr>
	              				</thead>
	              				<tbody>
	              					<tr>
	              						<td><?= $model->ambilNamaBulan($model->id_bulan_valid_start).'-'.$model->tahunValidStart->tahun.' s/d '.$model->ambilNamaBulan($model->id_bulan_valid_end).'-'.$model->tahunValidEnd->tahun ?></td>
	              						<td><?= $model->idKriteria->kriteria ?></td>
	              					</tr>
	              				</tbody>
	              			</table>
	              		</div>
	            	</div>
	            	<div class="row">
					    <div class="col-md-4">
					        <?= $form->field($model, 'bobot')->widget(MaskedInput::className(), [
					        'mask'               => ['99%'],
					        'clientOptions'      => [
					        'removeMaskOnSubmit' => true,
					        ]
					        ])->label('Bobot Penilaian Dalam %') ?>
					        <?= Html::error($model, 'total_bobot', ['style'=>'color:#dd4b39;']); ?>
					    </div>
					    <div class="col-md-4">
					        <br>
					        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success btn-lg btn-block']) ?>
					    </div>
					</div>
	            </div>
	            <!-- /.box-body -->
	    	</div>
    	</div>
	</div>
    <?php ActiveForm::end(); ?>

</div>