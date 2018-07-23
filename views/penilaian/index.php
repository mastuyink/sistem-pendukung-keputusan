<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;
use yii\helpers\ArrayHelper;
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
<!-- <div class="row">
    <div class="col-md-12">
        <div class="box box-primary collapsed-box">
            <div class="box-header with-border">  
            <button type="button" class="btn btn-box-tool btn-block" data-widget="collapse">
                <h3 class="box-title">Filter Data</h3>
            </button> -->
              <!-- /.box-tools -->
            <!-- </div> -->
            <!-- /.box-header -->
           <!--  <div class="box-body" style="">
              <p> -->
                <?php 
                // $this->render('_search', [
                //     'model'        => $searchModel,
                //     'listBulan'    => $listBulan,
                //     'listKaryawan' => $listKaryawan,
                //     'listKriteria' => $listKriteria,
                //     'listTahun'    => $listTahun,
                //     ]); ?>
            <!-- </p>
            </div>
        </div>
    </div> -->
    
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
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'header'=> 'Tahun',
                'format' =>'raw',
                'value'=>function($model){
                    return $model->idTahun->tahun;
                },
                'group'             =>true,  // enable grouping,
                'groupedRow'        =>true,
            ],
            [
                'header' => 'Bulan',
                'format' => 'raw',
                'value'  =>function($model){
                    return $model::ambilNamaBulan($model->id_bulan)."-".$model->idTahun->tahun;
                },

                'group'      =>true,  // enable grouping,
                'subGroupOf' =>1,
                'groupedRow' =>true,
                
            ],
            [
                'header'     => 'Nama',
                'format'     => 'raw',
                'attribute'  => 'id_karyawan',
                'filterType' => GridView::FILTER_SELECT2,
                'filter'     => $listKaryawan, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                      ],
                'filterInputOptions'=>['placeholder'=>'Semua...'],
                'value'=> function($model){
                    return "<span style='font-size: 17px; padding-left: 20px;'>".$model->idKaryawan->nama."</span>";
                },
                'group'      =>true,  // enable grouping,
                'subGroupOf' =>2,
                'groupedRow' =>true,
            ],
            [
                'header'     => 'Kriteria',
                'format'     => 'raw',
                'attribute'  => 'id_kriteria',
                'filterType' => GridView::FILTER_SELECT2,
                'filter'     => $listKriteria, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                      ],
                'filterInputOptions'=>['placeholder'=>'Semua...'],
                'value'=> function($model){
                    return $model->idPeriodeKriteria->idKriteria->kriteria;
                }
            ],
            [
                'header' => 'NIlai',
                'format' => 'raw',
                'width'=> '75px',
                'attribute' => 'nilai',
                'filterInputOptions'=>['placeholder'=>'...','class'=>'form-control form-number-only'],

            ],
            [
                'header' => 'Bobot',
                'format' => 'raw',
                'attribute'  => 'bobot_saat_ini',
                'filterInputOptions'=>['placeholder'=>'...','class'=>'form-control form-number-only'],
                'width'=> '75px',
                'value'=> function($model){
                    return $model->idPeriodeKriteria->bobot;
                }
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

<?php 
$this->registerJs('
$(".form-number-only").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    ', \yii\web\View::POS_READY);
?>