<?php

namespace app\controllers;

use Yii;
use app\models\TPeriodeKriteria;
use app\models\TPeriodeKriteriaSearch;
use app\models\TKriteria;
use app\models\ModelBulan;
use app\models\TTahun;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * PeriodeKriteriaController implements the CRUD actions for TPeriodeKriteria model.
 */
class PeriodeKriteriaController extends Controller
{
    /**
     * {@inheritdoc}
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

    public function actionTambahKriteria(){
        $periodeBaru = new TPeriodeKriteria();
        $periodeBaru->load(Yii::$app->request->get());
        $periodeTerinput = TPeriodeKriteria::find()->where(['AND',
            ['id_bulan_valid_start'=>$periodeBaru->id_bulan_valid_start],
            ['id_tahun_valid_start'=>$periodeBaru->id_tahun_valid_start],
            ['id_bulan_valid_end'=>$periodeBaru->id_bulan_valid_end],
            ['id_tahun_valid_end'=>$periodeBaru->id_tahun_valid_end],
        ])->all();
        if (!empty($periodeTerinput)) {
            $condition = ['AND'];
           foreach ($periodeTerinput as $key => $value) {
               $condition[]=['!=','id',$value->id_kriteria];
               $jumlahBobotDiinput[] = $value->bobot;
           }
        
           if ($periodeBaru->load(Yii::$app->request->post())) {
            $total = array_sum($jumlahBobotDiinput)+$periodeBaru->bobot;
            if ($total <= 100) {
                $periodeBaru->save(false);
                Yii::$app->session->setFlash('success', 'Penambahan Periode Sukses');
                return $this->redirect(['index']);
            }else{
                $periodeBaru->addError('bobot','Total Keseluruhan Bobot tidak boleh melebihi 100, terdeteksi '.$total);
            }
           }


           if (count($condition) > 1) {
               $kriterias = TKriteria::find()->where($condition)->all();
           }else{
                $kriterias = TKriteria::find()->all();
           }
           $listKriteria = ArrayHelper::map($kriterias, 'id', 'kriteria');
           return $this->render('_tambah-periode',[
            'periodeBaru' => $periodeBaru,
            'periodeTerinput' => $periodeTerinput,
            'listKriteria' => $listKriteria,
           ]);
        }else{
            Yii::$app->session->setFlash('danger', 'Periode Invalid');
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Lists all TPeriodeKriteria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TPeriodeKriteriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TPeriodeKriteria model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TPeriodeKriteria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($tahunBulanStart = null,$tahunBulanEnd = null)
    {
        $model = new TPeriodeKriteria();
       // $periode = Yii::$app->request->get();
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->validasiPeriode()) {
                    if ($model->validate()) {
                    
                        foreach ($model->listKriteria as $id_kriteria => $valKriteria) {
                            if ($valKriteria == true) {
                                
                                // if ($kriteriaDiinput != NULL && ($newModel = find())) {

                                // }else{
                                    $newModel                       = new TPeriodeKriteria();
                                //}
                                
                                $newModel->id_bulan_valid_start = $model->id_bulan_valid_start;
                                $newModel->id_tahun_valid_start = $model->id_tahun_valid_start;
                                $newModel->id_bulan_valid_end   = $model->id_bulan_valid_end;
                                $newModel->id_tahun_valid_end   = $model->id_tahun_valid_end;
                                $newModel->id_kriteria          = $id_kriteria;
                                $newModel->bobot                = $model->bobot[$id_kriteria];
                                $newModel->save(false);
                                $bobotDiinput[] = $model->bobot[$id_kriteria];
                            }
                        }
                        $model->total_bobot = array_sum($bobotDiinput);
                        if (isset($bobotDiinput) && $model->validate()) {
                            Yii::$app->session->setFlash('success', 'Penambahan Sukses');
                            $transaction->commit();
                            return $this->redirect(['index']); 
                        }
                    }
                }
               
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        $listPeriodeKriteria = [];
        if ($tahunBulanStart != NULL && $tahunBulanEnd != NULL) {
            //index 0 = tahunindex 1 = bulan
            $start                       = explode('-', $tahunBulanStart);
            $end                         = explode('-', $tahunBulanEnd);
            $model->id_bulan_valid_start = isset($start[1]) ? $start[1] : NULL;
            $model->id_tahun_valid_start = isset($start[0]) ? $start[0] : NULL;
            $model->id_bulan_valid_end   = isset($end[1]) ? $end[1] : NULL;
            $model->id_tahun_valid_end   = isset($end[0]) ? $end[0] : NULL;

            $allKriteria = TKriteria::find()->orderBy(['kriteria'=>SORT_ASC])->indexBy('id')->all();
            $periodeKriteriaTerInput = TPeriodeKriteria::find()->joinWith(['idKriteria'])->where(['AND',['CONCAT(id_tahun_valid_start,"-",id_bulan_valid_start)'=>$tahunBulanStart],['CONCAT(id_tahun_valid_end,"-",id_bulan_valid_end)'=>$tahunBulanEnd]])->orderBy(['t_kriteria.kriteria'=>SORT_ASC])->indexBy('id_kriteria')->all();
            // TPeriodeKriteria::find()->joinWith(['tahunValidStart as idTahunValidStart','tahunValidEnd as idTahunValidEnd'])
            // ->where(
            //     'STR_TO_DATE(:bulanTahun, "%Y-%m") BETWEEN STR_TO_DATE(CONCAT(idTahunValidStart.tahun,"-",id_bulan_valid_start), "%Y-%m") AND STR_TO_DATE(CONCAT(idTahunValidEnd.tahun,"-",id_bulan_valid_end), "%Y-%m")',
            //     [':bulanTahun'=>$inputTahunBulan])->one();
           // if (!empty($periodeKriteriaTerInput)) {
                foreach ($allKriteria as $id_kriteria => $kriteria) {
                    if (array_key_exists($id_kriteria, $periodeKriteriaTerInput)) {
                        $listPeriodeKriteria[] = ['value'=>$id_kriteria,'text'=>$kriteria->kriteria,'bobot'=>$periodeKriteriaTerInput[$id_kriteria]->bobot,'checked'=>true];
                    }else{
                        $listPeriodeKriteria[] = ['value'=>$id_kriteria,'text'=>$kriteria->kriteria,'bobot'=>NULL,'checked'=>false];
                    }
                }
        }   

        $listKriteria = ArrayHelper::map(TKriteria::find()->orderBy(['kriteria'=>SORT_ASC])->all(), 'id', 'kriteria');
        $listBulan    = ModelBulan::ambilSemuaBulan();
        $listTahun    = ArrayHelper::map(TTahun::ambilSemuaTahun(), 'id', 'tahun');
        return $this->render('create', [
            'model' => $model,
            'listKriteria' => $listKriteria,
            'listBulan' => $listBulan,
            'listTahun' => $listTahun,
            'listPeriodeKriteria' => $listPeriodeKriteria,
        ]);
    }

    /**
     * Updates an existing TPeriodeKriteria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Update Sukses');
            return $this->redirect(['index']);
        }
        $listKriteria = ArrayHelper::map(TKriteria::find()->orderBy(['kriteria'=>SORT_ASC])->all(), 'id', 'kriteria');
        $listBulan    = ModelBulan::ambilSemuaBulan();
        $listTahun    = ArrayHelper::map(TTahun::ambilSemuaTahun(), 'id', 'tahun');
        return $this->render('update', [
            'model' => $model,
            'listKriteria' => $listKriteria,
            'listBulan' => $listBulan,
            'listTahun' => $listTahun,
        ]);
    }

    /**
     * Deletes an existing TPeriodeKriteria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TPeriodeKriteria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TPeriodeKriteria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TPeriodeKriteria::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
