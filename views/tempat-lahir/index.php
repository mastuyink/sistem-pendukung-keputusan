<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TTempatLahirSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tempat Lahir';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ttempat-lahir-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-danger btn-lg btn-flat fa fa-plus-square']) ?>
    </p>

<?php Pjax::begin(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Data Nilai</h3>
            </div>
            
            <div class="box-body" style="">
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'tempat_lahir',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?></div>
