<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TPeriodeKriteriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Periode Kriteria';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tperiode-kriteria-index">

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-success btn-lg btn-flat fa fa-plus-square']) ?>
    </p>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Data PeriodeKriteria</h3>
            </div>
            
            <div class="box-body" style="">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'header' => 'Periode',
                'format' => 'raw',
                'value'  =>function($model){
                    return $model::ambilNamaBulan($model->id_bulan_valid_start)." ".$model->tahunValidStart->tahun." -> ".$model::ambilNamaBulan($model->id_bulan_valid_end)." ".$model->tahunValidEnd->tahun.Html::a('<i class="fa fa-plus-square"></i>', null, ['class' => 'btn btn-sm btn-success ']);
                },

                'group'      =>true,  // enable grouping,
                'subGroupOf' =>1,
                'groupedRow' =>true,
                
            ],
            [
                'header'=> 'Kriteria',
                'attribute'=>'id_kriteria',
                'format'=> 'raw',
                'value' => 'idKriteria.kriteria'
            ],
            'bobot',
            //  [
            //     'header'=> 'Valid',
            //     'format'=> 'raw',
            //     'value' => function($model){
            //         return $model::ambilNamaBulan($model->id_bulan_valid_start)." ".$model->tahunValidStart->tahun." -> ".$model::ambilNamaBulan($model->id_bulan_valid_end)." ".$model->tahunValidEnd->tahun;
            //     }
            // ],
            // 'description:ntext',
            // 'create_at',
            // 'update_at',

            [
                'header' => 'Action',
                'format' => 'raw',
                'value' => function($model){
                    if (Yii::$app->user->identity->level > 2) {
                        return "";
                    }
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
                                'confirm' => 'Anda Yakin Ingin Menghapus ? <br>Seluruh Data Yang Terkait Juga Akan Ikut Dihapus..',
                                'method'  => 'post',
                        ],
                    ]);
                    return $edit." ".$delete;
                }

            ]
        ],
    ]); ?>
</div>
</div>
</div>
</div>
</div>
