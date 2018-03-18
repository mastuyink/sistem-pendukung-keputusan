<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TPenilaian */
?>

<div class="row">
	<div class="col-md-12">
		<caption>
			Detail Nilai <?= $dataNilai[0]->idKaryawan->nama ?><br>
			<small>Bulan <?= date('F',strtotime($dataNilai[0]->id_bulan)) ?> Tahun <?= $dataNilai[0]->idTahun->tahun ?></small>
		</caption>
	</div>

	<div class="col-md-12">
		<table class="table table-hover table-responsive">
			<thead>
				<tr>
					<th>No</th>
					<th>Kriteria</th>
					<th>Nilai Asli</th>
					<th>Hasil Akhir</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($jumlahNilaiBulanIni as $key => $val): ?>
					<?php if(isset($dataNilai[$key])): ?>
						<tr>
							<td width="25"><?= $key+1 ?></td>
							<td><?= $dataNilai[$key]->idKriteria->kriteria ?></td>
							<td><?= $dataNilai[$key]->nilai ?></td>
							<td><?= $dataNilai[$key]->nilai_normalisasi*$dataNilai[$key]->bobot_saat_ini ?></td>
						</tr>
						<?php 
						$nilai[] = $dataNilai[$key]->nilai; 
						$nilai_normalisasi[] = $dataNilai[$key]->nilai_normalisasi*$dataNilai[$key]->bobot_saat_ini; 
						?>
					<?php else: ?>
						<tr class="bg-danger">
							<td width="25"><?= $key+1 ?></td>
							<td><?= $val->idKriteria->kriteria ?></td>
							<td>Nilai Belum Diinput</td>
							<td>-</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
				<tr>
					<th style="text-align: center;" colspan="2">TOTAL</th>
					<th><?= array_sum($nilai) ?></th>
					<th><?= array_sum($nilai_normalisasi) ?></th>

				</tr>
			</tbody>
		</table>
	</div>
</div>
