<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = "Tambah Kriteria untuk periode ".$periodeTerinput[0]::ambilNamaBulan($periodeTerinput[0]->id_bulan_valid_start)."-".$periodeTerinput[0]->tahunValidStart->tahun ." s/d ".$periodeTerinput[0]::ambilNamaBulan($periodeTerinput[0]->id_bulan_valid_end)."-".$periodeTerinput[0]->tahunValidEnd->tahun;
?>
<table class="table table-stripped">
	<caption>Periode Terinput <?= $periodeTerinput[0]::ambilNamaBulan($periodeTerinput[0]->id_bulan_valid_start).'-'.$periodeTerinput[0]->tahunValidStart->tahun ?> s/d <?= $periodeTerinput[0]::ambilNamaBulan($periodeTerinput[0]->id_bulan_valid_end).'-'.$periodeTerinput[0]->tahunValidEnd->tahun ?></caption>
	<thead>
		<tr>
			<th>No</th>
			<th>Kriteria</th>
			<th>Bobot</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($periodeTerinput as $index => $value): ?>
		<tr>
			<td><?= $index+1 ?></td>
			<td><?= $value->idKriteria->kriteria ?></td>
			<td><?= $value->bobot ?></td>
		</tr>
	<?php
	$total_bobot[] = $value->bobot;
	 endforeach; ?>
	 <tr>
	 	<td style="text-align: center;" colspan="2"><b>Total</b></td>
	 	<td><b><?= array_sum($total_bobot) ?></b></td>
	 </tr>
	</tbody>
</table>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-md-3">
	<?= $form->field($periodeBaru, 'id_kriteria')->dropDownList($listKriteria,['prompt'=>'Pilih Kriteria']); ?>
	</div>
	<div class="col-md-3">
	<?= $form->field($periodeBaru, 'bobot')->widget(MaskedInput::className(), [
		'mask'          => ['99%'],
		'id'            => 'form-bobot-'.$index,
		'options' => [
			'class'=> 'form-control',
			'parent-checkbox' => 'checkbox-'.$index,
		],
		'clientOptions' => [
		    'removeMaskOnSubmit' => true,
		]
	])->label('Bobot Dalam %') ?>
	</div>
	<div class="col-md-3">
		<br>
		<?= Html::submitButton('Simpan', ['class' => 'btn btn-success btn-lg btn-block']); ?>
	</div>
</div>
<?php ActiveForm::end(); ?>

