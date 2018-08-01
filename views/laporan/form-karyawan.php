<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

$this->title = "Laporan Penilaian Karyawan";
?>

<?php if(!empty($listKaryawan)): ?>
<div class="laporan-bulanan-search">
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
            </div>
            
            <div class="box-body" style="">
				<div class="col-sm-3">
				 	<label class="control-label">NIP</label>
					<?= Select2::widget([
					    'name' => 'nip',
					    'data' => ArrayHelper::map($listKaryawan, 'nip', 'nip'),
					    'options' => [
							'class'       => 'form-control input-sm',
							'id'          => 'form-nip',
							'placeholder' => 'Masukkan NIP Karyawan'
							//'multiple'    => true
					    ],
					]); ?>
				</div>
				<div class="col-sm-3">
					<label class="control-label">Nama Karyawan</label>
					<?= Select2::widget([
					    'name' => 'nama_karyawan',
					    'data' => ArrayHelper::map($listKaryawan, 'nama', 'nama'),
					    'options' => [
							'class'       => 'form-control input-sm',
							'id'          => 'form-karyawan',
							'placeholder' => 'Masukkan Nama Karyawan'
							//'multiple'    => true
					    ],
					]); ?>
				</div>
				
				<div class="form-group col-sm-2">
					<br>
					<?= Html::button('', [
						'class' => 'btn btn-primary btn-lg btn-flat fa fa-search',
						'onclick' =>'
							var vnip = $("#form-nip").val();
							var vnama = $("#form-karyawan").val();
							$("#loading-ajax").html("<img src=\'/img/spinner.svg\'>");
							$.ajax({
								url: "/laporan/detail-nilai-karyawan",
								type: "POST",
								data: {nip: vnip, nama: vnama},
								success: function(data){
									$("#ajax-reload").html(data);
									$("#loading-ajax").html("");
								}
							});
						'
						]); ?>
				</div>

				<div style="margin-top: 50px;" class="row">
					<div class="col-sm-12" id="ajax-reload">
						<center><div id="loading-ajax"></div></center>
						<center><h3>...</h3></center>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php else: ?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
            	<center><p>Anda Belum memiliki akses Untuk Melihat Nilai, Silahkan Hubungi Admin Untuk Mendapatkan Akses<br>Terimaksih</p></center>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

