<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Users;


class LoginController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->actionLogin('index');
    }

    public function actionLogin()
    {
        

        if (!\Yii::$app->user->isGuest) {
            //die('hola');
            return $this->goHome();
        }

        $model = new LoginForm();
        //var_dump(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //if(Yii::$app->user->identity->role == 1)
            //{
                return $this->redirect(Yii::$app->request->getBaseUrl().'/login/choose-organization');
                die();
            //}else
           //return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        //var_dump(Yii::$app->user->loginUrl);die();
        Yii::$app->user->logout();

        return $this->redirect(Yii::$app->user->loginUrl);
    }

    public function actionChooseOrganization()
    {
        
        $session = Yii::$app->session;

        if(!isset(Yii::$app->user->identity->username))
        {
            return $this->goBack();
        }
        if( Yii::$app->user->identity->role != 1)
        {
            $session->set('organization', Yii::$app->user->identity->id); 
            
            return $this->goBack();
        }
                
            $model = new Users();
               
            if ($model->load(Yii::$app->request->post())) {
                //var_dump(Yii::$app->request->post());die();
                $value = Yii::$app->request->post()['Users'];
    
                $session->set('organization', $value['username']); 

                return $this->goBack();
            }
            
            //return $this->goBack();
            //$this->layout = false;  
            return $this->render('choose-organization', [
                'model' => $model,
            ]);
    }

}
