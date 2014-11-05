<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\FilesSystem;
use app\models\Users;

class FilesController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        //'actions' => ['logout'],
                        'allow' => true,
                        'roles' =>  Users::verifyRole(),
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
        ];
    }

    public function actionIndex()
    {
        
        $model = new FilesSystem();
        
       if (Yii::$app->request->post()) {
            
            //var_dump(Yii::$app->request->post());die();
            $post = Yii::$app->request->post();
            $begin = $post['FilesSystem']['begin_date'];
            $end = $post['FilesSystem']['end_date'];
            
            
            if(isset($post['excel']))
            {
                $model->getExcel($begin, $end);    
            }else
                {
                    $model->getTxt($begin, $end);
                }    
        } 
        else 
            {//var_dump($model); die();
                return $this->render('files', [
                    'model' => $model,
                ]);
            }
    }

    
}
