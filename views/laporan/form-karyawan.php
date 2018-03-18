<?php 
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = "Laporan Penilaian Karyawan";
?>

<div class="laporan-bulanan-search">
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
            </div>
            
            <div class="box-body" style="">
				<div class="col-sm-3">
					<label class="label-control">NIP</label>
					<?= Html::textInput('nip',null,[
						'class' => 'form-control input-sm',
						'id'    => 'form-nip',
						'placeholder' => 'Masukkan NIP Karyawan'
						]); ?>
				</div>
				<div class="col-sm-3">
					<label class="label-control">Nama Karyawan</label>
					<?= Html::textInput('nama_karyawan',null,[
						'class' => 'form-control input-sm',
						'id'    => 'form-karyawan',
						'placeholder' => 'Masukkan Nama Karyawan'
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

