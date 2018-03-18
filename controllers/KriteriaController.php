<?php

namespace app\controllers;

use Yii;
use app\models\TKriteria;
use app\models\TKriteriaSearch;
use app\models\TTahun;
use app\models\ModelBulan;
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
                            return Yii::$app->user->identity->level <= 3;
                        },
                    ],
                    [
                       // 'actions' => ['index','drop-bulan',''],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->level < 3;
                        },
                    ],
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
            $bobotTerinput = TKriteria::ambilSemuaBobot();
            $model->total_bobot = $bobotTerinput+$model->bobot;
            if ($model->validate()) {
                Yii::$app->session->setFlash('success', 'Data Kriteria Tersimpan');
                $model->save(false);
                return $this->redirect(['index']);
            }
        } 
            $listTahun = ArrayHelper::map(TTahun::ambilSemuaTahun(), 'id', 'tahun');
            $listBulan = ModelBulan::ambilSemuaBulan();
            return $this->render('create', [
                'model'     => $model,
                'listTahun' => $listTahun,
                'listBulan' => $listBulan
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
        $listTahun = ArrayHelper::map(TTahun::ambilSemuaTahun(), 'id', 'tahun');
        $listBulan = ModelBulan::ambilSemuaBulan();
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save(false);
                $bobotTerinput = TKriteria::ambilSemuaBobot($model->id);
                $model->total_bobot = $bobotTerinput+$model->bobot;
                if ($model->validate()) {
                    Yii::$app->session->setFlash('success', 'Kriteria '.$model->kriteria.' Berhasil Diperbaharui');
                    $model->save(false);
                    $transaction->commit();
                    return $this->redirect(['index']);
                }else{
                    $transaction->rollBack();
                }
                
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
            
        } 
            return $this->render('update', [
                'model' => $model,
                'listTahun' => $listTahun,
                'listBulan' => $listBulan
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
