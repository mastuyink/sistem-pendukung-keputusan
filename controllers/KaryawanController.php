<?php

namespace app\controllers;

use Yii;
use app\models\TKaryawan;
use app\models\TJabatanKaryawan;
use app\models\TKaryawanSearch;
use app\models\TBidang;
use app\models\TJabatan;
use app\models\TPendidikanAkhir;
use app\models\TJurusan;
use app\models\TProvinsi;
use app\models\TKabupaten;
use app\models\TKecamatan;
use app\models\TKelurahan;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

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
                    'hapus-user' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                       // 'actions' => ['create','update','delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (!Yii::$app->user->isGuest) {
                                if (Yii::$app->user->identity->level == 1 || Yii::$app->user->identity->level == 3) {
                                    return true;
                                }
                            }
                            return false;
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionHapusUser($id_karyawan){
        if(($karyawan = TKaryawan::find()->where(['AND',['id'=>$id_karyawan],['IS NOT','id_user',NULL]])->one()) !== NULL){
            $karyawan->id_user = NULL;
            $karyawan->save(false);
            Yii::$app->session->setFlash('success', 'Hapus User Sukses');
            
        }else{
            Yii::$app->session->setFlash('danger', 'Hapus User Gagal');
        }

        return $this->redirect(['index']);
    }
    public function actionPilihUser($id_karyawan){
        $modelKaryawan = $this->findModel($id_karyawan);
        if ($modelKaryawan->load(Yii::$app->request->post())) {
            if ($modelKaryawan->id_user != NULL) {
                $modelKaryawan->save(false);
                Yii::$app->session->setFlash('success', 'Pilih User Sukses');
                
            }else{
                Yii::$app->session->setFlash('danger', 'Pilih User Yang diinginkan');
            }
            return $this->redirect(['index']);
            
        }
            $karyawanBeruser = TKaryawan::find()->select('id_user')->where(['IS NOT','id_user',NULL])->all();
            $condition = ['AND'];
            foreach ($karyawanBeruser as $key => $value) {
                $condition[] = ['!=','id',$value->id_user];
            }
            $condition[] = ['status'=> User::STATUS_ACTIVE];
            $listUser = ArrayHelper::map(User::find()->where($condition)->all(), 'id', 'username');
            return $this->renderAjax('pilih-user',[
                'modelKaryawan' => $modelKaryawan,
                'listUser'=>$listUser,
            ]);
    }

    public function actionPilihJabatan($id_karyawan){

        if(($cekKaryawan = TKaryawan::find()->where(['id'=>$id_karyawan])->andWhere(['jenis_karyawan'=>TKaryawan::PNS])->one()) !== null){
            if ($cekKaryawan->idJabatanKaryawan == null) {
                $jabatanKayawan = new TJabatanKaryawan();
            }else{
                $jabatanKayawan = $cekKaryawan->idJabatanKaryawan;
            }
                $jabatanKayawan->id_karyawan = $id_karyawan;
            if ($jabatanKayawan->load(Yii::$app->request->post()) && $jabatanKayawan->validate()) {
                $jabatanKayawan->save(false);

                Yii::$app->session->setFlash('success','Pilih Jabatan Sukses');
                return $this->redirect(['index']);
            }else{
                $listJabatan     = ArrayHelper::map($this->getAllJabatan(), 'id', 'jabatan');
                return $this->render('_form-pilih-jabatan',[
                    'jabatanKayawan'=> $jabatanKayawan,
                    'listJabatan' => $listJabatan,
                ]);
            }
        }else{
            
            throw new \yii\web\HttpException(501,"Karyawan Non PNS Tidak Memiliki Jabatan");
        }
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
        $listKaryawan = TKaryawan::find()->orderBy(['nama'=>SORT_ASC])->all();
        $listBidang = ArrayHelper::map(TBidang::find()->orderBy(['bidang'=>SORT_ASC])->asArray()->all(), 'id','bidang');
        $listJabatan = ArrayHelper::map(TJabatan::find()->orderBy(['jabatan'=>SORT_ASC])->asArray()->all(), 'id','jabatan');
        $listJabatan = ArrayHelper::merge($listJabatan, ['999'=>'Staff']);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'listKaryawan' => $listKaryawan,
            'listBidang' => $listBidang,
            'listJabatan' => $listJabatan,
        ]);
    }

    /**
     * Displays a single TKaryawan model.
     * @param integer $id
     * @return mixed
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

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
            $listTempatLahir = ArrayHelper::map(TKabupaten::ambilKabupaten(), 'id', 'nama');
            $listPendidikan  = ArrayHelper::map($this->getAllPendidikan(), 'id', 'pendidikan_akhir');
            $listJurusan     = ArrayHelper::map(TJurusan::find()->asArray()->all(), 'id', 'jurusan');
            $listProvinsi    = ArrayHelper::map(TProvinsi::ambilSemuaProvinsi(), 'id', 'nama');
            return $this->render('create', [
                'model'           => $model,
                'listBidang'      => $listBidang,
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
            $listTempatLahir = ArrayHelper::map(TKabupaten::ambilKabupaten(), 'id', 'nama');
            $listPendidikan  = ArrayHelper::map($this->getAllPendidikan(), 'id', 'pendidikan_akhir');
            $listJurusan     = ArrayHelper::map(TJurusan::find()->asArray()->all(), 'id', 'jurusan');

            $listProvinsi    = ArrayHelper::map(TProvinsi::ambilSemuaProvinsi(), 'id', 'nama');
            $listKabupaten    = ArrayHelper::map(TKabupaten::ambilKabupaten(['provinsi_id'=>$model->id_provinsi]), 'id', 'nama');
            $listKecamatan    = ArrayHelper::map(TKecamatan::ambilKecamatan(['kabupaten_id'=>$model->id_kabupaten]), 'id', 'nama');
            $listKelurahan    = ArrayHelper::map(TKelurahan::ambilKelurahan(['kecamatan_id'=>$model->id_kecamatan]), 'id', 'nama');
            
            return $this->render('update', [
                'model'           => $model,
                'listBidang'      => $listBidang,
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
