<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TPenilaianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hasil Akhir Penilaian';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tpenilaian-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">  
                <button type="button" class="btn btn-box-tool btn-block" data-widget="collapse">
                    <h3 class="box-title">Filter Data</h3>
                </button>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="">
                    <p>
                        <?= $this->render('_search', [
                            'model'        => $searchModel,
                            'listBulan'    => $listBulan,
                            'listKaryawan' => $listKaryawan,
                            'listTahun'    => $listTahun,
                            'currentUrl' => 'hasil-akhir'
                            ]); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
<div class="row">
<div class="col-md-12">
    <center><b id="loading-pjax"></b></center>
<!-- <div class="col-md-12"> -->
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Data Hasil Akhir Penilaian</h3>
              <!-- /.box-tools -->
    </div>
            <!-- /.box-header -->
    <div class="box-body" style="">
<?php Pjax::begin(['id'=>'pjax-table-penilaian']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header'=> 'Tahun',
                'format' =>'raw',
                'value'=>function($model){
                    return "<b>".$model->idTahun->tahun."</b>";
                },
                'group'             =>true,  // enable grouping,
                'groupedRow'        =>true,
            ],
            [
                'header' => 'Bulan',
                'format'    =>'raw',
                'value'     =>function($model){
                    return "<span class='fa fa-calendar'></span> ".$model::ambilNamaBulan($model->id_bulan)."-".$model->idTahun->tahun;;
                },

                'group'      =>true,  // enable grouping,
                'subGroupOf' =>1,
                'groupedRow' =>true,
            ],
            [
                'header' => 'Nama',
                'format' => 'raw',
                'value' => 'idKaryawan.nama'
            ],
            // [
            //     'header'  => 'bulan',
            //     'format'     => 'raw',
            //     'value'  => function($model){
            //         return $model->id_bulan." ".$model->id_tahun;
            //     },
            //     // 'group'      =>true,  // enable grouping,
            //     // 'subGroupOf' => 2,
            //     // 'groupedRow' => true,
            // ],
            [
                'header' => 'Hasil Akhir',
                'format' => 'raw',
                'value' => function($model,$index){

                    return $model->total;
                }
            ],
            [
                'header' =>'Ranking',
                'format' => 'raw',
                'value'  => function($model){
                    $data = [
                            'id_bulan'    => $model->id_bulan,
                            'id_tahun'    => $model->id_tahun,
                            'id_karyawan' => $model->id_karyawan,
                    ];
                    return $model::ambilRanking($data);
                }
            ],
            [
                'header' => 'Detail',
                'format' => 'raw',
                'value' => function($model){
                    return Html::button('', [
                        'class'       => 'btn btn-xs btn-flat btn-primary btn-detail glyphicon glyphicon-modal-window',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Lihat Detail',
                        'id-tahun'    => $model->id_tahun,
                        'id-bulan'    => $model->id_bulan,
                        'id-karyawan' => $model->id_karyawan

                    ]);
                }
            ],
        ],
    ]); ?>

<?php 
$this->registerJs('
$(".btn-detail").on("click",function(){
    $("#modal-detail-nilai").modal();

    $.ajax({
        url: "'.Url::to(['detail-nilai']).'",
        type: "POST",
        data: {
            id_karyawan : $(this).attr("id-karyawan"),
            id_tahun : $(this).attr("id-tahun"),
            id_bulan : $(this).attr("id-bulan"),
        },
        success: function(data){
            $(".modal-body").html(data);
        }

    });
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

<?php Pjax::end(); ?>
</div>
</div>
</div>
</div>
<!-- </div> -->
</div>
</div>
