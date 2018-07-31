<?php

namespace app\controllers;

use Yii;
use app\models\TPenilaian;
use app\models\TPenilaianSearch;
use app\models\HasilAkhirSearch;
use app\models\TKaryawan;
use app\models\TKriteria;
use app\models\TPeriodeKriteria;
use app\models\ModelBulan;
use app\models\TTahun;
use app\models\VHasilAkhir;
use app\models\KriteriaPenilaianValidator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
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
                   // 'cari-kriteria'      => ['POST'],
                    'kunci-nilai'        => ['POST'],

                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['detail-nilai'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                       //'actions' => ['index','drop-bulan',''],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->level != 2;
                        },
                    ],
                    // [
                    //    'actions' => ['index','drop-bulan',''],
                    //     'allow' => true,
                    //     'matchCallback' => function ($rule, $action) {
                    //         return Yii::$app->user->identity->level <= 3;
                    //     },
                    // ],
                    // [
                    //    // 'actions' => ['index','drop-bulan',''],
                    //     'allow' => true,
                    //     'matchCallback' => function ($rule, $action) {
                    //         return Yii::$app->user->isGuest ? false : Yii::$app->user->identity->level < 3;
                    //     },
                    // ],
                ],
            ],
        ];
    }
   

    public function actionDetailNilai(){

        $data = Yii::$app->request->post();
        $jumlahNilaiBulanIni = TPenilaian::find()->where(['id_bulan' => $data['id_bulan']])->andWhere(['id_tahun' => $data['id_tahun']])->orderBy(['id_periode_kriteria'=>SORT_ASC])->groupBy('id_periode_kriteria')->all();
        $dataNilai = TPenilaian::find()->joinWith(['idKaryawan','idTahun'])->where(
            [
                'AND',
                ['=','id_karyawan',$data['id_karyawan']],
                ['=','id_tahun',$data['id_tahun']],
                ['=','id_bulan',$data['id_bulan']]
            ])
            ->orderBy(['id_periode_kriteria'=>SORT_ASC])
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
        $cariTahun = TTahun::findOne($tahun);
        $jumlahKriteria = TPeriodeKriteria::find()
            ->joinWith(['tahunValidStart as idTahunValidStart','tahunValidEnd as idTahunValidEnd'])
            ->where('STR_TO_DATE(:bulanTahun, "%Y-%m") BETWEEN STR_TO_DATE(CONCAT(idTahunValidStart.tahun,"-",id_bulan_valid_start), "%Y-%m") AND STR_TO_DATE(CONCAT(idTahunValidEnd.tahun,"-",id_bulan_valid_end), "%Y-%m")',
                [':bulanTahun'=>$cariTahun->tahun.'-'.$bulan
        ])->all();
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
        $listPenilaian = TPenilaian::find()->joinWith(['idKaryawan','idPeriodeKriteria'])->where(
                [
                    'AND',
                    ['=','id_bulan',$bulan],
                    ['=','id_tahun',$tahun],
                ]
            )->andWhere(['id_karyawan' => $karyawan['id']])
            ->all();
             $kriteria[] = "AND";

        foreach ($listPenilaian as $key => $value) {
            $kriteria[] = ['!=','t_periode_kriteria.id',$value['id_periode_kriteria']]; 
        }
        $tahun = TTahun::findOne($tahun);
        $inputTahunBulan = $tahun->tahun.'-'.$bulan;
        $jumlahKriteria = TPeriodeKriteria::find()
        ->joinWith(['tahunValidStart as idTahunValidStart','tahunValidEnd as idTahunValidEnd','idKriteria'])
        ->where($kriteria)
        ->andWhere(
                'STR_TO_DATE(:bulanTahun, "%Y-%m") BETWEEN STR_TO_DATE(CONCAT(idTahunValidStart.tahun,"-",id_bulan_valid_start), "%Y-%m") AND STR_TO_DATE(CONCAT(idTahunValidEnd.tahun,"-",id_bulan_valid_end), "%Y-%m")',
                [':bulanTahun'=>$inputTahunBulan
        ])->orderBy(['t_kriteria.kriteria'=>SORT_ASC])->asArray()->all();
        // foreach ($jumlahKriteria as $key => $valKriteria) {
        //         echo '<label><input name="TPenilaian[id_kriteria]" value="'.$valKriteria['id'].'" type="radio" class="radio-kriteria-penilaian">'.$valKriteria['kriteria'].'</label><br>';
        // }
        $modelKriteriaPenilaian = [new KriteriaPenilaianValidator()];
        return $this->renderAjax('_form-kriteria-penilaian',[
            'jumlahKriteria'         => $jumlahKriteria,
            'modelKriteriaPenilaian' => $modelKriteriaPenilaian,
        ]);
        
        
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
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $listNilai = Yii::$app->request->post('nilai');
                //return var_dump($listNilai);
                foreach ($listNilai as $id_kriteria => $nilai) {
                    if ($nilai != NULL) {
                        if ($nilai >= 0 && $nilai <= 100) {
                            $newPenilaian                      = new TPenilaian();
                            $newPenilaian->load(Yii::$app->request->post());
                            $newPenilaian->id_periode_kriteria = $id_kriteria;
                            $newPenilaian->nilai               = $nilai;
                            $newPenilaian->save(false);
                        }else{
                            $valid = false;
                        }
                        
                    }
                }
                if (!isset($valid)) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Tambah Data Penilaian Sukses');
                    return $this->redirect(['index']);
                }else{
                    Yii::$app->session->setFlash('danger', 'Jumlah Nilai tidak valid');
                    $transaction->rollBack();
                }
                
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
                Yii::$app->session->setFlash('danger', 'Input Tidak Valid, Mohon Periksa Kembali');
            }
            
            
        }

        if (Yii::$app->request->isPjax) {
            $data = Yii::$app->request->post();
            $bulan         = $data['bulan'];
            $tahun         = $data['tahun'];
            $idKaryawan    = $data['id_karyawan'];
            $karyawan      = TKaryawan::find()->where(['id'=>$idKaryawan])->asArray()->one();
            $listPenilaian = TPenilaian::find()->joinWith(['idKaryawan','idPeriodeKriteria'])->where(
                    [
                        'AND',
                        ['=','id_bulan',$bulan],
                        ['=','id_tahun',$tahun],
                    ]
                )->andWhere(['id_karyawan' => $karyawan['id']])
                ->all();
                 $kriteria[] = "AND";

            foreach ($listPenilaian as $key => $value) {
                $kriteria[] = ['!=','t_periode_kriteria.id',$value['id_periode_kriteria']]; 
            }
            $tahun = TTahun::findOne($tahun);
            $inputTahunBulan = $tahun->tahun.'-'.$bulan;
            $jumlahKriteria = TPeriodeKriteria::find()
            ->joinWith(['tahunValidStart as idTahunValidStart','tahunValidEnd as idTahunValidEnd','idKriteria'])
            ->where($kriteria)
            ->andWhere(
                    'STR_TO_DATE(:bulanTahun, "%Y-%m") BETWEEN STR_TO_DATE(CONCAT(idTahunValidStart.tahun,"-",id_bulan_valid_start), "%Y-%m") AND STR_TO_DATE(CONCAT(idTahunValidEnd.tahun,"-",id_bulan_valid_end), "%Y-%m")',
                    [':bulanTahun'=>$inputTahunBulan
            ])->orderBy(['t_kriteria.kriteria'=>SORT_ASC])->asArray()->all();
            $modelKriteriaPenilaian = [new KriteriaPenilaianValidator()];
        }
            return $this->render('create', [
                'model'                  => $model,
                'listBulan'              => $listBulan,
                'listTahun'              => $listTahun,
                'jumlahKriteria'         => isset($jumlahKriteria) ? $jumlahKriteria : [],
                'modelKriteriaPenilaian' => isset($modelKriteriaPenilaian) ? $modelKriteriaPenilaian : [],
            ]);
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
            if ($model->nilai < 0 || $model->nilai > 100) {
                $model->addError('nilai','Jumlah Nilai Invalid');
            }else{
                $model->save(false);
                Yii::$app->session->setFlash('success', 'Update Data Penilaian Sukses');
            return $this->redirect(['index']);
            }
            
            
        } 
            return $this->render('update', [
                'model'     => $model,
            ]);
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
