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
use app\models\TProvinsi;
use app\models\TKabupaten;
use app\models\TKecamatan;
use app\models\TKelurahan;
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

    public function actionDropdownKelurahan($id_kecamatan){
        $condition = ['kecamatan_id'=>$id_kecamatan];
        $listKelurahan = TKelurahan::ambilKelurahan($condition);
        if (!empty($listKelurahan)) {
            echo '<option value="">Pilih Kelurahan ...</option>';
            foreach ($listKelurahan as $key => $value) {
                echo '<option value="'.$value->id.'">'.$value->nama.'</option>';
            }
        }else{
            echo '<option value="">Kelurahan Tidak Ditemukan</option>';
        }
    }

    public function actionDropdownKecamatan($id_kabupaten){
        $condition = ['kabupaten_id'=>$id_kabupaten];
        $listKecamatan = TKecamatan::ambilKecamatan($condition);
        if (!empty($listKecamatan)) {
            echo '<option value="">Pilih Kecamatan ...</option>';
            foreach ($listKecamatan as $key => $value) {
                echo '<option value="'.$value->id.'">'.$value->nama.'</option>';
            }
        }else{
            echo '<option value="">Kecamatan Tidak Ditemukan</option>';
        }
    }

    public function actionDropdownKabupaten($id_provinsi){
        $condition = ['provinsi_id'=>$id_provinsi];
        $listKabupaten = TKabupaten::ambilKabupaten($condition);
        if (!empty($listKabupaten)) {
            echo '<option value="">Pilih Kabupaten ...</option>';
            foreach ($listKabupaten as $key => $value) {
                echo '<option value="'.$value->id.'">'.$value->nama.'</option>';
            }
        }else{
            echo '<option value="">Kabupaten Tidak Ditemukan</option>';
        }
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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Data Karyawan Tersimpan');
            return $this->redirect(['index']);
        } else {
            $listBidang      = ArrayHelper::map($this->getAllBidang(), 'id', 'bidang');
            $listJabatan     = ArrayHelper::map($this->getAllJabatan(), 'id', 'jabatan');
            $listTempatLahir = ArrayHelper::map($this->getAllTempatLahir(), 'id', 'tempat_lahir');
            $listPendidikan  = ArrayHelper::map($this->getAllPendidikan(), 'id', 'pendidikan_akhir');
            $listJurusan     = ArrayHelper::map(TJurusan::find()->asArray()->all(), 'id', 'jurusan');
            $listProvinsi    = ArrayHelper::map(TProvinsi::ambilSemuaProvinsi(), 'id', 'nama');
            return $this->render('create', [
                'model'           => $model,
                'listBidang'      => $listBidang,
                'listJabatan'     => $listJabatan,
                'listTempatLahir' => $listTempatLahir,
                'listPendidikan'  => $listPendidikan,
                'listJurusan'     => $listJurusan,
                'listProvinsi'    => $listProvinsi,
            ]);
        }
    }

    protected function getAllBidang(){
        return TBidang::find()->all();
    }
    protected function getAllJabatan(){
        return TJabatan::find()->all();
    }
    protected function getAllTempatLahir(){
        return TTempatLahir::find()->all();
    }
    protected function getAllPendidikan(){
        return TPendidikanAkhir::find()->orderBy(['id'=>SORT_ASC])->all();
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
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data Karyawan '.$model->nama.' Berhasil Diperbaharui');
            return $this->redirect(['index']);
        } else {
            $model->id_provinsi = $model->idKelurahan->kecamatan->kabupaten->provinsi_id;
            $model->id_kabupaten = $model->idKelurahan->kecamatan->kabupaten_id;
            $model->id_kecamatan = $model->idKelurahan->kecamatan_id;
            $listBidang      = ArrayHelper::map($this->getAllBidang(), 'id', 'bidang');
            $listJabatan     = ArrayHelper::map($this->getAllJabatan(), 'id', 'jabatan');
            $listTempatLahir = ArrayHelper::map($this->getAllTempatLahir(), 'id', 'tempat_lahir');
            $listPendidikan  = ArrayHelper::map($this->getAllPendidikan(), 'id', 'pendidikan_akhir');
            $listJurusan     = ArrayHelper::map(TJurusan::find()->asArray()->all(), 'id', 'jurusan');

            $listProvinsi    = ArrayHelper::map(TProvinsi::ambilSemuaProvinsi(), 'id', 'nama');
            $listKabupaten    = ArrayHelper::map(TKabupaten::ambilKabupaten(['provinsi_id'=>$model->id_provinsi]), 'id', 'nama');
            $listKecamatan    = ArrayHelper::map(TKecamatan::ambilKecamatan(['kabupaten_id'=>$model->id_kabupaten]), 'id', 'nama');
            $listKelurahan    = ArrayHelper::map(TKelurahan::ambilKelurahan(['kecamatan_id'=>$model->id_kecamatan]), 'id', 'nama');
            
            return $this->render('update', [
                'model'           => $model,
                'listBidang'      => $listBidang,
                'listJabatan'     => $listJabatan,
                'listTempatLahir' => $listTempatLahir,
                'listPendidikan'  => $listPendidikan,
                'listJurusan'     => $listJurusan,
                'listProvinsi'     => $listProvinsi,
                'listKabupaten'     => $listKabupaten,
                'listKecamatan'     => $listKecamatan,
                'listKelurahan'     => $listKelurahan,
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
