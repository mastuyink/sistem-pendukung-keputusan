<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TJabatanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Gambar';
$this->params['breadcrumbs'][] = $this->title;
?>
 <p><?= Html::a('', ['upload'], ['class' => 'btn btn-success btn-lg btn-flat fa fa-plus-square']); ?></p>
 <div class="panel panel-primary">
 	<div class="panel-heading"><h4>DAFTAR GAMBAR</h4></div>
 	<div class="panel-body">
 <table class="table table-striped table-hover">
 	<thead>
 		<tr>
 			<th>No</th>
 			<th>File Name</th>
 			<th>Preview</th>
 			<th>action</th>
 		</tr>
 	</thead>
 	<tbody>
 		<?php foreach ($model as $key => $value): ?>
 			<tr>
 				<td width="100"><?= $key+1 ?></td>
 				<td><?= $value->nama_gambar ?></td>
 				<td width="100"><?= Html::a('', '#preview' , [
						'class'       => 'btn btn-sm btn-flat btn-warning fa fa-eye tombol-preview',
						'nama-gambar' => $value->nama_gambar
 					]); ?> </td>
 				<td width="100">
 					<?= Html::a('', ['hapus-gambar','nama'=>$value->nama_gambar], [
                        'class' => 'btn btn-sm fa fa-trash btn-flat btn-danger',
                        'data'=> [
                            'method'=>'post',
                            'confirm'=>'Anda Yakin Ingin Menghapus Gambar Ini ?'
                        ]
                        ]); ?> 
 				</td>
 					
 			</tr>

 		<?php endforeach; ?>
 	</tbody>
 </table>
</div>
</div>
<?php 
$this->registerJs('
$(".tombol-preview").on("click",function(){
	$("#modal-preview").modal();
	var nama = $(this).attr("nama-gambar");
	$("#detail").html("<img class=\'img img-responsive\' src=\'/carrousel/"+nama+"\'>");
});

$("#modal-preview").on("hidden.bs.modal",function(){
	$("#detail").html("<center>Please Wait....<br><i class=\'fa fa-spin fa-refresh\'></i></center>");
});
	', \yii\web\View::POS_READY);
 ?>
<div class="modal fade" id="modal-preview">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">X</span></button>
                <h4 class="modal-title">Preview Gambar</h4>
            </div>
            <div class="modal-body row" id="detail">
                <center>
                	Please Wait....<br>
                	<i class="fa fa-spin fa-refresh"></i>
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
            <!-- /.modal-content -->
	</div>
          <!-- /.modal-dialog -->
</div>
