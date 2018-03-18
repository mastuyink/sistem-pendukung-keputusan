<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TPenilaianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Penilaian';
$this->params['breadcrumbs'][] = $this->title;

echo Dialog::widget([
'dialogDefaults'=>[
    Dialog::DIALOG_ALERT => [
        'type'        => Dialog::TYPE_DANGER,
        'title'       => 'Danger',
        'buttonClass' => 'btn-primary btn-dialog',
        'buttonLabel' => 'Ok'
    ],
    Dialog::DIALOG_CONFIRM => [
        'type'           => Dialog::TYPE_DANGER,
        'title'          => 'Confirm',
        'btnOKClass'     => 'btn-primary',
        'btnOKLabel'     =>' Ok',
        'btnCancelLabel' =>' Cancel'
        ]
    ]]);?>

<div class="tpenilaian-index">
    

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-success btn-lg btn-flat fa fa-plus-square']) ?>
    </p>
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
                    'listKriteria' => $listKriteria,
                    'listTahun'    => $listTahun,
                    'currentUrl' => 'index'
                    ]); ?>
            </p>
            </div>
            <!-- /.box-body -->
        </div>
          <!-- /.box -->
    </div>
    
</div>
<center><b id="loading-pjax"></b></center>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Data Nilai</h3>
            </div>
            
            <div class="box-body" style="">
<?php Pjax::begin(['id'=>'pjax-table-penilaian']); ?>
<?= GridView::widget([
        'id' => 'grid-table-penilaian',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'            => true,
        'pjaxSettings'    =>[
            'neverTimeout' =>true,
        ],
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
            [
                'header' => 'Kriteria',
                'format' => 'raw',
                'value' => 'idKriteria.kriteria'
            ],
            [
                'header' => 'NIlai',
                'format' => 'raw',
                'value' => 'nilai'
            ],
            [
                'header' => 'Bobot',
                'format' => 'raw',
                'value' => 'bobot_saat_ini'
            ],
            [
                'header' => 'Nilai Normalisasi',
                'format' => 'raw',
                'value' => 'nilai_normalisasi'
            ],

            [
                'header' => 'Action',
                'format' => 'raw',
                'value' => function($model){
                    $edit = Html::a('', ['update','id'=>$model->id], [
                        'class' => 'btn btn-sm btn-primary fa fa-pencil',
                        'data-toggle' => 'tooltip',
                        'title' => 'Update',
                        'id' => 'btn-update-'.$model->id
                    ]);
                    $delete = Html::a('', ['delete','id'=>$model->id], [
                        'class'       => 'btn btn-sm btn-danger fa fa-trash',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Delete',
                        'id' => 'btn-delete-'.$model->id,
                        'data'        => [
                                'confirm' => 'Anda Yakin Ingin Menghapus Data ?',
                                'method'  => 'post',
                        ],
                    ]);
                    return $edit." ".$delete;
                }
            ]
        ],
    ]); ?>


<?php Pjax::end(); ?>
</div>
</div>
</div>
</div>
</div>

