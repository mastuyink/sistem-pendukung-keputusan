<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;
use app\models\TKriteria;
use app\models\TGambar;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
       // $this->layout = "kosong";
        $model = TKriteria::find()->all();
        $listGambar = TGambar::find()->orderBy(['datetime'=>SORT_DESC])->all();
        return $this->render('index',[
            'model'      => $model,
            'listGambar' => $listGambar
        ]);
    }


}
