<?php

namespace app\controllers;

use Yii;
use app\models\TPenilaian;
use app\models\LaporanBulananSearch;
use app\models\VHasilAkhir;
use app\models\TKaryawan;
use app\models\TKriteria;
use app\models\ModelBulan;
use app\models\TTahun;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
/**
 * PenilaianController implements the CRUD actions for TPenilaian model.
 */
class LaporanController extends Controller
{
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
                        'actions' => ['karyawan','detail-nilai-karyawan','download-laporan-karyawan'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                     [
                       // 'actions' => ['karyawan','detail-nilai-karyawan'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionDownloadLaporanKaryawan($id_karyawan){
        $modelHasilAkhir = $modelPenilaian = VHasilAkhir::find()
            ->where(['id_karyawan'=>$id_karyawan])
            ->orderBy(['id_tahun'=>SORT_DESC,'id_bulan'=>SORT_DESC])->all();
        if(!empty($modelHasilAkhir)){
            $Pdf = new Pdf([
                 'filename'=>'Laporan Karyawan.pdf',
                    // A4 paper format
                    'format' => Pdf::FORMAT_A4, 
                    // portrait orientation
                    'orientation' => "L",
                    // simpan file
                    'destination' => Pdf::DEST_DOWNLOAD,

                    'content' => "
                        ".$this->renderPartial('_laporan-karyawan',[
                            'modelHasilAkhir' => $modelHasilAkhir
                            ])." ",
                                     // any css to be embedded if required
                                'cssInline' => '.kv-heading-1{
                                                    font-size:18px
                                                }
                                                @media print{
                                                    .page-break{display: block;page-break-before: always;}
                                                }', 
                                //set mPDF properties on the fly
                                'options'   => ['title' => 'Laporan Bulanan '],
                                // call mPDF methods on the fly
                                'methods'   => [ 
                                'SetHeader' =>['Lapran Karyawan'], 
                                'SetFooter' =>[
                                    'Laporan Karyawan'],
                                ]
                        ]);
            $Pdf->render();
        }else{
            Yii::$app->session->setFlash('danger', 'Data Tidak Ditemukan.. Silahkan Coba Lagi');
            return $this->redirect(['karyawan']);
        }
    }

    public function actionExportLaporanBulanan($id_tahun,$id_bulan){
        if(($modelHasilAkhir = VHasilAkhir::find()->where(['id_bulan'=>$id_bulan])->andWhere(['id_tahun'=>$id_tahun])->all()) !== null){
            $Pdf = new Pdf([
                 'filename'=>'Laporan.pdf',
                    // A4 paper format
                    'format' => Pdf::FORMAT_A4, 
                    // portrait orientation
                    'orientation' => "L",
                    // simpan file
                    'destination' => Pdf::DEST_DOWNLOAD,

                    'content' => "
                        ".$this->renderPartial('_laporan-bulanan',[
                            'modelHasilAkhir' => $modelHasilAkhir
                            ])." ",
                                     // any css to be embedded if required
                                'cssInline' => '.kv-heading-1{
                                                    font-size:18px
                                                }
                                                @media print{
                                                    .page-break{display: block;page-break-before: always;}
                                                }', 
                                //set mPDF properties on the fly
                                'options'   => ['title' => 'Laporan Bulanan '],
                                // call mPDF methods on the fly
                                'methods'   => [ 
                                'SetHeader' =>['Lapran Bulanan Header'], 
                                'SetFooter' =>[
                                    'Laporan Bulanan Footer'],
                                ]
                        ]);
            $Pdf->render();
        }else{
            Yii::$app->session->setFlash('danger', 'Data Tidak Ditemukan.. Silahkan Coba Lagi');
            return $this->redirect(['bulanan']);
        }
    }

    public function actionDetailBulanan(){
        
        if (Yii::$app->request->isAjax) {
            $data           = Yii::$app->request->post();
            $tahun          = $data['id_tahun'];
            $bulan          = $data['id_bulan'];
            $modelHasilAkhir = VHasilAkhir::find()->where(['id_bulan'=>$bulan])->andWhere(['id_tahun'=>$tahun])->all();
            //return var_dump($modelHasilAkhir);
            return $this->renderAjax('_table-bulanan',[
                'modelPenilaian'=>$modelHasilAkhir,

            ]);
        }
    }

    public function actionBulanan(){

        $listBulan = ModelBulan::ambilSemuaBulan();
        $listTahun = ArrayHelper::map(TTahun::find()->asArray()->all(), 'id', 'tahun');
        return $this->render('form-bulanan',[
            'listBulan' => $listBulan,
            'listTahun' => $listTahun,
        ]);
    }

    public function actionDetailNilaiKaryawan(){
        $data = Yii::$app->request->post();
        $modelKaryawan = TKaryawan::find()->where(['nip'=>$data['nip']])->andWhere(['nama'=>$data['nama']])->one();
        if ($modelKaryawan == null) {
            return '<div class="callout callout-danger">
                      <h4>Data Nilai Tidak Ditemukan...</h4>
                       <p>Silahkan Periksa Kembali Masukan Anda</p>
                    </div>';
        }else{
            $tahunPost = Yii::$app->request->post('tahun', date('Y'));
            $tahun = TTahun::find()->where(['tahun'=>$tahunPost])->one();
            $modelPenilaian = VHasilAkhir::find()
                ->where(['id_karyawan'=>$modelKaryawan->id])
                ->andWhere(['id_tahun'=>$tahun->id])
             ->orderBy(['id_tahun'=>SORT_DESC,'id_bulan'=>SORT_DESC])->all();
            if ($modelPenilaian != null) {
                $postData = [
                    'nip' => $data['nip'],
                    'nama' => $data['nama'],
                    'tahun' => $tahunPost,
                ];
                $listTahun = ArrayHelper::map(TTahun::find()->orderBy(['id'=>SORT_ASC])->all(), 'tahun', 'tahun');
                return $this->renderAjax('_table-karyawan',[
                    'modelPenilaian'=>$modelPenilaian,
                    'postData' => $postData,
                    'listTahun' => $listTahun,

                ]);
            }else{
                 return '<div class="callout callout-danger">
                      <h4>Data Nilai Tidak Ditemukan...</h4>
                       <p>Silahkan Periksa Kembali Masukan Anda</p>
                    </div>';
            }
            
        }
    }

    public function actionKaryawan(){
        $listKaryawan = TKaryawan::find()->orderBy(['nama'=>SORT_ASC])->all();
        return$this->render('form-karyawan',[
            'listKaryawan' => $listKaryawan
        ]);
    }
}
