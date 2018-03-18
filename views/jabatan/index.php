<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TJabatanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Jabatan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tjabatan-index">

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-danger btn-lg btn-flat fa fa-plus-square']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'jabatan',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
</div>
