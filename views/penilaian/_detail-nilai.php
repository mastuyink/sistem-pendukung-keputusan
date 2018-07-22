<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TPenilaian */
?>

<div class="row">
	<div class="col-md-12">
		<caption>
			Detail Nilai <?= $dataNilai[0]->idKaryawan->nama ?><br>
			
		</caption>
	</div>

	<div class="col-md-12">
		<table class="table table-hover table-responsive">
			<thead>
				<tr>
					<th>No</th>
					<th>Kriteria</th>
					<th>Nilai Asli</th>
					<th>Bobot</th>
					<th>Nilai Terbobotkan</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($jumlahNilaiBulanIni as $key => $val): ?>
					<?php if(isset($dataNilai[$key])): ?>
						<tr>
							<td width="25"><?= $key+1 ?></td>
							<td><?= $dataNilai[$key]->idPeriodeKriteria->idKriteria->kriteria ?></td>
							<td><?= $dataNilai[$key]->nilai ?></td>
							<td><?= $dataNilai[$key]->idPeriodeKriteria->bobot ?></td>
							<td><?= $dataNilai[$key]->nilai_normalisasi*$dataNilai[$key]->idPeriodeKriteria->bobot ?></td>
						</tr>
						<?php 
						$nilai[] = $dataNilai[$key]->nilai; 
						$nilai_normalisasi[] = $dataNilai[$key]->nilai_normalisasi*$dataNilai[$key]->idPeriodeKriteria->bobot; 
						?>
					<?php else: ?>
						<tr class="bg-danger">
							<td width="25"><?= $key+1 ?></td>
							<td><?= $val->idPeriodeKriteria->idKriteria->kriteria ?></td>
							<td>Nilai Belum Diinput</td>
							<td>-</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
				<tr>
					<th style="text-align: center;" colspan="2">TOTAL (Hasil Akhir)</th>
					<th><?= array_sum($nilai) ?></th>
					<th></th>
					<th><?= array_sum($nilai_normalisasi) ?></th>

				</tr>
			</tbody>
		</table>
	</div>
</div>
