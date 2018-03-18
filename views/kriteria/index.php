<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TKriteriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Kriteria';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tkriteria-index">

    <?php if(Yii::$app->user->identity->level < 3): ?>
        <p>
            <?= Html::a('', ['create'], ['class' => 'btn btn-danger btn-lg btn-flat fa fa-plus-square']) ?>
        </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kriteria',
            'bobot',
            [
                'header'=> 'Valid',
                'format'=> 'raw',
                'value' => function($model){
                    return $model::ambilNamaBulan($model->id_bulan_valid_start)." ".$model->tahunValidStart->tahun." -> ".$model::ambilNamaBulan($model->id_bulan_valid_end)." ".$model->tahunValidEnd->tahun;
                }
            ],
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
                                'confirm' => 'Anda Yakin Ingin Menghapus Kriteria <b>'.$model->kriteria.' </b> ? <br>Seluruh Data Yang Terkait Juga Akan Ikut Dihapus..',
                                'method'  => 'post',
                        ],
                    ]);
                    return $edit." ".$delete;
                }

            ]
        ],
    ]); ?>
</div>
<?php
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
    ]]);
?>