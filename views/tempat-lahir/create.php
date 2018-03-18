<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TTempatLahir */

$this->title = 'Create Ttempat Lahir';
$this->params['breadcrumbs'][] = ['label' => 'Ttempat Lahirs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ttempat-lahir-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
