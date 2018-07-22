<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\models\TPeriodeKriteria */

$this->title = 'Tambah Periode Kriteria';
$this->params['breadcrumbs'][] = ['label' => 'List Periode Kriteria', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tperiode-kriteria-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    	<div class="col-md-6">
    		<div class="box box-primary">
	            <div class="box-header with-border">
	            		<center><h3 class="box-title">Awal Periode</h3></center>
	              <!-- /.box-tools -->
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <div class="row">
	              	<div class="col-md-6">
			            <?= $form->field($model, 'id_bulan_valid_start')->dropDownList($listBulan,['prompt'=>'Pilih...','class'=>'form-control drop-range','id'=>'drop-bulan-start']); ?>
			        </div>
			        <div class="col-md-6">
			            <?= $form->field($model, 'id_tahun_valid_start')->dropDownList($listTahun,['prompt'=>'Pilih...','class'=>'form-control drop-range','id'=>'drop-tahun-start']); ?>
			        </div>
	              </div>
	            </div>
	            <!-- /.box-body -->
	        </div>
    	</div>
    	<div class="col-md-6">
    		<div class="box box-primary">
	            <div class="box-header with-border">
	            		<center><h3 class="box-title">Akhir Periode</h3></center>
	              <!-- /.box-tools -->
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <div class="row">
			        <div class="col-md-6">
			            <?= $form->field($model, 'id_bulan_valid_end')->dropDownList($listBulan,['prompt'=>'Pilih...','class'=>'form-control drop-range','id'=>'drop-bulan-end']); ?>
			        </div>
			        <div class="col-md-6">
			            <?= $form->field($model, 'id_tahun_valid_end')->dropDownList($listTahun,['prompt'=>'Pilih...','class'=>'form-control drop-range','id'=>'drop-tahun-end']); ?>
			        </div>
	              </div>
	            </div>
	            <!-- /.box-body -->
	        </div>
    	</div>
    	<div class="col-md-12"><?= Html::error($model, 'periode_kriteria', ['style'=>'color:#dd4b39; text-align: center; font-weight: bold;']); ?></div>
    </div>
<div class="row">
    	<div class="col-md-12">
    		<div class="box box-primary">
	            <div class="box-header with-border">
	            		<center><h3 class="box-title">Pilih Kriteria</h3></center>
	              <!-- /.box-tools -->
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	            	<div class="row">
	            	<?php Pjax::begin(['id'=>'pjax-list']); ?>
	            		<?php foreach($listPeriodeKriteria as $periode): ?>
	            		<div class="col-md-6 row">
		            		<div class="col-md-4">
		            			<?php 
		            			$index = $periode['value'];
		            			$model->listKriteria[$index] = $periode['checked'];
		            			 ?>
		            			 <?= $form->field($model, "listKriteria[$index]")->checkbox([
		            			 	'id' => 'checkbox-'.$index,
		            			 ])->label($periode['text']); ?>
						    	<?php 
						    	// Html::activeCheckbox($model, "listKriteria[$index]", [
						    	// 	'label' => $periode['text'],
						    	// 	'id' => 'checkbox-'.$index,
						    	// 	'value' =>true
						    	// ]); ?>
						    </div>
						    <div class="col-md-6">
						        <?= $form->field($model, "bobot[$index]")->widget(MaskedInput::className(), [
								'mask'          => ['99%'],
								'id'            => 'form-bobot-'.$index,
								'options' => [
									'class'=> 'form-control',
									'parent-checkbox' => 'checkbox-'.$index,
									'value' => $periode['bobot'],
								],
								'clientOptions' => [
						        	'removeMaskOnSubmit' => true,
						        ]
						        ])->label('Bobot Dalam %') ?>
						    </div>
						</div>
						<?php endforeach; ?>
					<?php Pjax::end(); ?>
					<div class="col-md-12">
						<?= Html::error($model, 'total_bobot', ['style'=>'color:#dd4b39; text-align: center; font-weight: bold;']); ?>
					</div>
					    <div class="col-md-12">
					        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success btn-lg btn-block']) ?>
					    </div>
					</div>
				</div>
			</div>
		</div>
</div>

    

    <?php ActiveForm::end(); ?>

</div>

<?php 
$this->registerJs('
$(".drop-range").on("change",function(){
	var tahunStart = $("#drop-tahun-start").val();
	var bulanStart = $("#drop-bulan-start").val();
	var tahunEnd = $("#drop-tahun-end").val();
	var bulanEnd = $("#drop-bulan-end").val();
	if (tahunStart != "" && bulanStart != "" && tahunEnd != "" && bulanEnd != "") {
		var tahunBulanStart = tahunStart+"-"+bulanStart;
		var tahunBulanEnd = tahunEnd+"-"+bulanEnd;
		$.pjax.reload({
			url: "/periode-kriteria/create?tahunBulanStart="+tahunBulanStart+"&tahunBulanEnd="+tahunBulanEnd,
			container: "#pjax-list",
		});
	}
});
	', \yii\web\View::POS_READY);
?>