<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TTahun */

$this->title = 'Create Ttahun';
$this->params['breadcrumbs'][] = ['label' => 'Ttahuns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ttahun-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
