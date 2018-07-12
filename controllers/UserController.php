<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\PasswordReset;
use app\models\LupaPassword;
use app\models\AturUlangPassword;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use app\models\LoginForm;
use app\models\Signup;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [
                        'actions' => ['login','lupa-password','atur-ulang-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (!Yii::$app->user->isGuest) {
                                return Yii::$app->user->identity->level == 1;
                            }
                            
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionLupaPassword()
    {
        $model = new LupaPassword();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (($user = $model->getResetToken()) !== false) {
                //return var_dump($user);
                Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($user->email)
                ->setSubject('Atur Ulang Password '.$user->username)
                ->setHtmlBody($this->renderPartial('/user/lupa-password-email',[
                    'user' => $user,
                    ]))
                ->send();
                Yii::$app->session->setFlash('success', 'Silahkan Periksa Email anda untuk mengatur ulang password');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Mohon maaf, sistenm tidak dapat memproses akun untuk email anda');
            }
        }

        return $this->render('lupa-password', [
            'model' => $model,
        ]);
    }

    public function actionAturUlangPassword($token)
    {
        try {
            $model = new AturUlangPassword($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionResetPassword($id){
        
        $model = new PasswordReset();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->resetPassword($id)) {
                Yii::$app->session->setFlash('success', 'Reset Password Sukses');
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('danger', 'Reset Password gagal');
            }
            
        }
        $findUser = $this->findModel($id);
        return $this->render('reset-password', [
                'model' => $model,
                'user' => $findUser,
            ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save(false);
                Yii::$app->session->setFlash('success', 'Load SUkses');
                return $this->redirect(['index']);
            }           
            Yii::$app->session->setFlash('warning',var_dump($model->getErrors()));
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

     public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new Signup();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                Yii::$app->session->setFlash('success', 'Pendaftaran User Berhasil');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
                'model' => $model,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}