<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TLogPenilaianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?php if($modelPenilaian != null): ?>
<div class="panel panel-primary">
    <div class="panel-heading"><h4>Laporan Bulan <?= date('F',strtotime($modelPenilaian[0]->id_bulan)) ?></h4></div>
<div class="panel-body">
    <div class="col-md-12">
        <?= Html::a(' Download PDF', ['export-laporan-bulanan','id_tahun'=>$modelPenilaian[0]->id_tahun,'id_bulan'=>$modelPenilaian[0]->id_bulan], [
            'class' => 'btn btn-lg btn-flat btn-success fa fa-download',
            'data' => [
                'method' => 'post'
            ]
            ]); ?>
    </div>
   <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Hasil</th>
                    <th>Ranking</th>
                    <th>Detail</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach($modelPenilaian as $key => $valueNilai): ?>
                    <?php 
                        $data = [
                            'id_bulan'    => $valueNilai->id_bulan,
                            'id_tahun'    => $valueNilai->id_tahun,
                            'id_karyawan' => $valueNilai->id_karyawan,
                        ];
                    ?>
                    <tr>
                        <td width="25"><?= $key+1 ?></td>
                        <td><?= $valueNilai->idKaryawan->nip ?></td>
                        <td><?= $valueNilai->idKaryawan->nama ?></td>
                        <td><?= $valueNilai->total ?></td>
                        <td><?= $valueNilai::ambilRanking($data); ?></td>
                        <td><?= Html::button('', [
                            'class'       => 'btn btn-xs btn-warning glyphicon glyphicon-modal-window tombol-detail-bulanan',
                            'data-toggle' => 'tooltip',
                            'title'       => 'Lihat Detail',
                            'id-karyawan' => $valueNilai->id_karyawan,
                            'id-bulan'    => $valueNilai->id_bulan,
                            'id-tahun'    => $valueNilai->id_tahun,
                        ]); ?></td>
                    </tr>
                <?php endforeach; ?>
               
            </tbody>
    </table>
</div>
</div>
<?php
$this->registerJs('
$(".tombol-detail-bulanan").on("click",function(){
    var idkaryawan = $(this).attr("id-karyawan");
    var idbulan    = $(this).attr("id-bulan");
    var idtahun    = $(this).attr("id-tahun");

    $("#modal-detail-nilai").modal();

    $.ajax({
        url: "'.Url::to(['/penilaian/detail-nilai']).'",
        type: "POST",
        data: {
            id_bulan: idbulan,
            id_tahun: idtahun,
            id_karyawan: idkaryawan
        },

        success: function(data){
            $(".modal-body").html(data);
        }
    })

})
    ', \yii\web\View::POS_READY);
 ?>

 <div class="modal fade" id="modal-detail-nilai">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Detail Nilai</h4>
              </div>
              <div class="modal-body">
                <center>Mohon Tunggu ...<br><i class="fa fa-spinner fa-spin"></i></center>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Keluar</button>
              </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php else: ?>
'<div class="callout callout-danger">
                      <h4>Data Nilai Tidak Ditemukan...</h4>
                       <p>Silahkan Pilih Bulan Atau Tahun Lain</p>
                    </div>'
<?php endif; ?>
