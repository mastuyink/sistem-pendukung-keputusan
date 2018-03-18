<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\TGambar;
use yii\web\UploadedFile;
use yii\filters\AccessControl;


class GambarController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                       // 'actions' => ['index','drop-bulan',''],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->level == 1;
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionHapusGambar($nama){
        if(($model = TGambar::findOne(['nama_gambar'=>$nama])) !== null){
            if(file_exists(Yii::$app->basePath.'/web/carrousel/'.$model->nama_gambar)){
                unlink(Yii::$app->basePath.'/web/carrousel/'.$model->nama_gambar);
            }
            $model->delete();
            Yii::$app->session->setFlash('success', 'Hapus Gambar Sukses');
            return $this->redirect(['index']);
        }
        
    }

    public function actionUpload()
    {
        $model = new TGambar();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                $model->save(false);
                Yii::$app->session->setFlash('success', 'Upload File Success');
                return $this->redirect(['index']);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionIndex(){
        $model = TGambar::find()->all();
        return $this->render('index',['model'=>$model]);
    }
}