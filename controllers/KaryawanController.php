<?php

namespace app\controllers;

use Yii;
use app\models\TKaryawan;
use app\models\TKaryawanSearch;
use app\models\TBidang;
use app\models\TJabatan;
use app\models\TTempatLahir;
use app\models\TPendidikanAkhir;
use app\models\TJurusan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * KaryawanController implements the CRUD actions for TKaryawan model.
 */
class KaryawanController extends Controller
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
        ];
    }

    public function actionDetailKaryawan(){
       //if (Yii::$app->request->isAjax) {
            $modelKaryawan = $this->findModel(Yii::$app->request->post('id_karyawan'));
            return $this->renderPartial('_detail-karyawan',['modelKaryawan'=>$modelKaryawan]);
       // }
    }

    /**
     * Lists all TKaryawan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TKaryawanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TKaryawan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TKaryawan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model           = new TKaryawan();
        $listBidang      = ArrayHelper::map($this->getAllBidang(), 'id', 'bidang');
        $listJabatan     = ArrayHelper::map($this->getAllJabatan(), 'id', 'jabatan');
        $listTempatLahir = ArrayHelper::map($this->getAllTempatLahir(), 'id', 'tempat_lahir');
        $listPendidikan  = ArrayHelper::map($this->getAllPendidikan(), 'id', 'pendidikan_akhir');
        $listJurusan     = ArrayHelper::map(TJurusan::find()->asArray()->all(), 'id', 'jurusan');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Data Karyawan Tersimpan');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model'           => $model,
                'listBidang'      => $listBidang,
                'listJabatan'     => $listJabatan,
                'listTempatLahir' => $listTempatLahir,
                'listPendidikan' => $listPendidikan,
                'listJurusan' => $listJurusan,
            ]);
        }
    }

    protected function getAllBidang(){
        return TBidang::find()->asArray()->all();
    }
    protected function getAllJabatan(){
        return TJabatan::find()->asArray()->all();
    }
    protected function getAllTempatLahir(){
        return TTempatLahir::find()->asArray()->all();
    }
    protected function getAllPendidikan(){
        return TPendidikanAkhir::find()->orderBy(['id'=>SORT_ASC])->asArray()->all();
    }

    /**
     * Updates an existing TKaryawan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!empty($model->idJurusanKaryawan)) {
            $model->jurusan = $model->idJurusanKaryawan->id_jurusan;
        }
        
        $listBidang      = ArrayHelper::map($this->getAllBidang(), 'id', 'bidang');
        $listJabatan     = ArrayHelper::map($this->getAllJabatan(), 'id', 'jabatan');
        $listTempatLahir = ArrayHelper::map($this->getAllTempatLahir(), 'id', 'tempat_lahir');
        $listPendidikan  = ArrayHelper::map($this->getAllPendidikan(), 'id', 'pendidikan_akhir');
        $listJurusan     = ArrayHelper::map(TJurusan::find()->asArray()->all(), 'id', 'jurusan');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Kriteria '.$model->nama.' Berhasil Diperbaharui');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model'           => $model,
                'listBidang'      => $listBidang,
                'listJabatan'     => $listJabatan,
                'listTempatLahir' => $listTempatLahir,
                'listPendidikan' => $listPendidikan,
                'listJurusan' => $listJurusan,
            ]);
        }
    }

    /**
     * Deletes an existing TKaryawan model.
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
     * Finds the TKaryawan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TKaryawan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TKaryawan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
