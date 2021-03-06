<?php

namespace app\controllers;

use Yii;
use app\models\TKriteria;
use app\models\TKriteriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
/**
 * KriteriaController implements the CRUD actions for TKriteria model.
 */
class KriteriaController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (!Yii::$app->user->isGuest) {
                                return Yii::$app->user->identity->level < 4;
                            }
                            
                        },
                    ],
                    [
                        'actions' => ['create','update','delete','drop-bulan'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (!Yii::$app->user->isGuest) {
                                return Yii::$app->user->identity->level == 1 || Yii::$app->user->identity->level == 2;
                            }
                            
                        },
                    ],
                    // [
                    //    // 'actions' => ['index','drop-bulan',''],
                    //     'allow' => true,
                    //     'matchCallback' => function ($rule, $action) {
                    //         return Yii::$app->user->identity->level == 1;
                    //     },
                    // ],
                ],
            ],
        ];
    }

    public function actionDropBulan(){
        if (Yii::$app->request->isAjax) {
            $data       = Yii::$app->request->post();
            $tahun      = $data['bulan'];
            //$modelBulan = TBulan::find()->where([''])
        }else{
            return $this->goHome();
        }
    }


    /**
     * Lists all TKriteria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TKriteriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new TKriteria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TKriteria();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                Yii::$app->session->setFlash('success', 'Data Kriteria Tersimpan');
                $model->save(false);
                return $this->redirect(['index']);
            }
        }
            return $this->render('create', [
                'model'     => $model,
            ]);
        
    }

    /**
     * Updates an existing TKriteria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Kriteria '.$model->kriteria.' Berhasil Diperbaharui');
            return $this->redirect(['index']);
            
        } 
            return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing TKriteria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TKriteria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TKriteria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TKriteria::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
