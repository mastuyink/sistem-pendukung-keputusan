<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\helpers\Url;
//use rmrevin\yii\fontawesome\AssetBundle;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="icon" type="image/png" href="/img/pavicon.png">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
  NavBar::begin([
        'brandLabel' => '<b><img id="logo-navbar" alt="logo-navbar" src="/img/logo.png">DISPERINDAG</b>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-fixed-top navbar-inverse',
        ],
    ]);
    $menuItems = [
        [
        'label' => 'Home',
        'url' => Yii::$app->homeUrl,
        ],
        [
        'label' => 'About',
        'url' => ['/about-us'],
        ],
        [
        'label' => 'Fast Boats',
        'url' => ['/fast-boats'],
        ],
        [
        'label' => 'Destination', 'url' => ['/destinations'],
        ],
        [
        'label' => 'Ports', 'url' => ['/ports'],
        ],
        [
        'label' => 'Hotels', 'url' => ['/hotels'],
        ],
        [
        'label' => 'Contact', 'url' => ['/contact-us'],
        ],
        
    ];
    // $menuItems[] ='<li><a class="material-navbar__link" href="/book/detail-data" id="cart"><i class="fa fa-shopping-cart"></i> Cart <span class="badge">'.Yii::$app->gilitransfers->Countcart().'</span></a></li>';
    
    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    
 
    <div class="container">
<!--Translate End -->
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            // 'itemTemplate' => "<li class=\"material-breadcrumb__item\">{link}</li>\n",
            // 'options'=>['class'=>'breadcrumb material-breadcrumb'],
            // 'activeItemTemplate'=>"<li class=\"material-breadcrumb__item\"><span class=\"material-breadcrumb__active-element\">{link}</span></li>\n",

        ]) ?>
        <?= Alert::widget() ?>

        <?= $content ?>

<?= Html::button(' Top <span></span>', [
  'class'       =>'btn',
  'id'          =>'btn-scroll',
  'style'       =>'display:none;',
  'data-toggle' =>'tooltip',
  'title'       =>'Back To Top',
  ]); ?>
    </div>
</div>
<?php $this->endBody() ?>

<?php $customScript = <<< SCRIPT
  $(window).scroll(function(){ 
        if ($(this).scrollTop() > 100) { 
            $('#btn-scroll').fadeIn(); 
        } else { 
            $('#btn-scroll').fadeOut(); 
        } 
    }); 
    $('#btn-scroll').click(function(){ 
        $("html, body").animate({ scrollTop: 0 }, 600); 
        return false; 
    });
SCRIPT;
$this->registerJs($customScript, \yii\web\View::POS_READY); 

$customCss = <<< SCRIPT
#logo-navbar{
    height: 30px;
    width: auto;
    margin-top:0px;
}
#btn-scroll {
    position:fixed;
    right:10px;
    bottom:100px;
    cursor:pointer;
    width:50px;
    height:50px;
    background-color:#f2a12e;
    text-indent:-9999px;
    display:none;
    -webkit-border-radius:60px;
    -moz-border-radius:60px;
    border-radius:60px
}
#btn-scroll span {
    position:absolute;
    top:50%;
    left:50%;
    margin-left:-8px;
    margin-top:-12px;
    height:0;
    width:0;
    border:8px solid transparent;
    border-bottom-color:#ffffff;
}
#btn-scroll:hover {
    background-color:#e74c3c;
    opacity:1;filter:"alpha(opacity=100)";
    -ms-filter:"alpha(opacity=100)";
}

SCRIPT;
$this->registerCss($customCss);
?>

</body>
</html>
<?php $this->endPage() ?>
