<?php

namespace app\controllers;

use Yii;
use app\models\TPenilaian;
use app\models\TPenilaianSearch;
use app\models\HasilAkhirSearch;
use app\models\TKaryawan;
use app\models\TKriteria;
use app\models\ModelBulan;
use app\models\TTahun;
use app\models\VHasilAkhir;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * PenilaianController implements the CRUD actions for TPenilaian model.
 */
class PenilaianController extends Controller
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
                    'delete'             => ['POST'],
                    'cari-data-karyawan' => ['POST'],
                    'cari-kriteria'      => ['POST'],
                    'kunci-nilai'        => ['POST'],

                ],
            ],
        ];
    }
   

    public function actionDetailNilai(){

        $data = Yii::$app->request->post();
        $jumlahNilaiBulanIni = TPenilaian::find()->where(['id_bulan' => $data['id_bulan']])->andWhere(['id_tahun' => $data['id_tahun']])->orderBy(['id_kriteria'=>SORT_ASC])->groupBy('id_kriteria')->all();
        $dataNilai = TPenilaian::find()->joinWith(['idKaryawan','idTahun','idKriteria'])->where(
            [
                'AND',
                ['=','id_karyawan',$data['id_karyawan']],
                ['=','id_tahun',$data['id_tahun']],
                ['=','id_bulan',$data['id_bulan']]
            ])
            ->orderBy(['id_kriteria'=>SORT_ASC])
            ->all();

        return $this->renderAjax('_detail-nilai',[
            'dataNilai'      => $dataNilai,
            'jumlahNilaiBulanIni' => $jumlahNilaiBulanIni,

        ]);
    }


    public function actionCariDataKaryawan(){
        $data = Yii::$app->request->post();
        $bulan = $data['bulan'];
        $tahun = $data['tahun'];
        $jumlahKriteria = TKriteria::find()->asArray()->all();
        $listKaryawan = TKaryawan::find()->asArray()->all();
        foreach ($listKaryawan as $key => $value) {
            $listPenilaian = TPenilaian::find()->where(
                [
                    'AND',
                    ['=','id_bulan',$bulan],
                    ['=','id_tahun',$tahun],
                ]
            )->andWhere(['id_karyawan' => $value['id']])
            ->asArray()
            ->all();
            if ($key == 0) {
                    echo '<option value="">Silahkan Pilih Karyawan</option>'; 
                }
            if (count($listPenilaian) < count($jumlahKriteria)) {
                
               echo '<option value="'.$value['id'].'">'.$value['nama'].'</option>'; 
            }
        }
    }

    public function actionCariKriteria(){
        $data          = Yii::$app->request->post();
        $bulan         = $data['bulan'];
        $tahun         = $data['tahun'];
        $idKaryawan    = $data['id_karyawan'];
        $karyawan      = TKaryawan::find()->where(['id'=>$idKaryawan])->asArray()->one();
        $listKaryawan  = TKaryawan::find()->asArray()->all();
        $listPenilaian = TPenilaian::find()->joinWith(['idKaryawan','idKriteria'])->where(
                [
                    'AND',
                    ['=','id_bulan',$bulan],
                    ['=','id_tahun',$tahun],
                ]
            )->andWhere(['id_karyawan' => $karyawan['id']])
            ->asArray()
            ->all();
             $kriteria[] = "AND";

        foreach ($listPenilaian as $key => $value) {
            $kriteria[] = ['!=','id',$value['id_kriteria']]; 
        }
        $jumlahKriteria = TKriteria::find()->where($kriteria)->orderBy(['kriteria'=>SORT_ASC])->asArray()->all();
        foreach ($jumlahKriteria as $key => $valKriteria) {
            // if ($valKriteria['id'] == 1) {
            //     echo '<label><input name="TPenilaian[id_kriteria]" value="'.$valKriteria['id'].'" type="radio">'.$valKriteria['kriteria'].'</label><br>';
            // }else{
                echo '<label><input name="TPenilaian[id_kriteria]" value="'.$valKriteria['id'].'" type="radio" class="radio-kriteria-penilaian">'.$valKriteria['kriteria'].'</label><br>';
          //  }
        }
        
        
    }

    /**
     * Lists all TPenilaian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new TPenilaianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $listBulan    = ModelBulan::ambilSemuaBulan();
        $listKaryawan = ArrayHelper::map(TKaryawan::ambilSemuaKaryawan(), 'id', 'nama');
        $listKriteria = ArrayHelper::map(TKriteria::ambilSemuaKriteria(), 'id', 'kriteria');
        $listTahun    = ArrayHelper::map(TTahun::ambilSemuaTahun(), 'id', 'tahun');
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'listBulan'    => $listBulan,
            'listKaryawan' => $listKaryawan,
            'listKriteria' => $listKriteria,
            'listTahun'    => $listTahun,
        ]);
    }

    public function actionHasilAkhir()
    {
         $searchModel  = new HasilAkhirSearch();
         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         $listBulan    = ModelBulan::ambilSemuaBulan();
         $listKaryawan = ArrayHelper::map(TKaryawan::ambilSemuaKaryawan(), 'id', 'nama');
         $listKriteria = ArrayHelper::map(TKriteria::ambilSemuaKriteria(), 'id', 'kriteria');
         $listTahun    = ArrayHelper::map(TTahun::ambilSemuaTahun(), 'id', 'tahun');
        return $this->render('hasil-akhir', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'listBulan'    => $listBulan,
            'listKaryawan' => $listKaryawan,
            'listKriteria' => $listKriteria,
            'listTahun'    => $listTahun,
        ]);
    }



    /**
     * Displays a single TPenilaian model.
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
     * Creates a new TPenilaian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TPenilaian();
        $listBulan = ModelBulan::ambilSemuaBulan();
        $listTahun = ArrayHelper::map(TTahun::find()->asArray()->all(), 'id', 'tahun');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Tambah Data Penilaian Sukses');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model'     => $model,
                'listBulan' => $listBulan,
                'listTahun' => $listTahun,
            ]);
        }
    }

    /**
     * Updates an existing TPenilaian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Update Data Penilaian Sukses');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model'     => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TPenilaian model.
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
     * Finds the TPenilaian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TPenilaian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TPenilaian::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
