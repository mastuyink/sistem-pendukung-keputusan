<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TPendidikanAkhirSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Pendidikan Akhir';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tpendidikan-akhir-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-danger btn-lg btn-flat fa fa-plus-square']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'pendidikan_akhir',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
