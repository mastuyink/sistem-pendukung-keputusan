<?php 
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = "Laporan Bulanan";
?>


<div class="laporan-bulanan-search">
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
            </div>
            
            <div class="box-body" style="">
				<div class="col-sm-2">
					<?= Html::dropDownList('id_bulan',null, $listBulan, [
						'class' => 'form-control input-sm',
						'id' => 'form-bulan'
						]); ?>
				</div>
				<div class="col-sm-2">
					<?= Html::dropDownList('id_tahun',null, $listTahun, [
						'class' => 'form-control input-sm',
						'id' => 'form-tahun'
						]); ?>
				</div> 
				<div class="col-sm-2">
					<?= Html::button('', [
						'class' => 'btn btn-primary btn-lg btn-flat fa fa-search',
						'onclick' =>'
							var vbulan = $("#form-bulan").val();
							var vtahun = $("#form-tahun").val();
							$("#loading-ajax").html("<img src=\'/img/spinner.svg\'>");
							$.ajax({
								url: "'.Url::to(['detail-bulanan']).'",
								type: "POST",
								data: {id_bulan: vbulan, id_tahun: vtahun},
								success: function(data){
									$("#ajax-reload").html(data);
									$("#loading-ajax").html("");
								}
							});
							
						'
						]); ?>
				</div>

				<div style="margin-top: 50px;" class="row">
					<center><div id="loading-ajax"></div></center>
					<div class="col-sm-12" id="ajax-reload">
						<center><h3>Silahkan Pilih Bulan Dan Tahun</h3></center>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

