<?php

namespace app\controllers;

use Yii;
use app\models\RegistersCodeEspecial;
use app\models\RegistersCodeEspecialSearchc;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\db\Expression;
use yii\db\Query;
use yii\db\Command;
use app\models\Code;


use app\api\DateFormat;

/**
 * RegistersCodeEspecialController implements the CRUD actions for RegistersCodeEspecial model.
 */
class RegistersCodeEspecialController extends Controller
{
     public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'actions' => ['registered','index', 'update'], //alows only this accions
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    /*[
                        //'actions' => ['index', 'update'], //alows only this accions
                        'allow' => true,
                        'roles' => Users::verifyRole(),
                    ],*/
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all RegistersCodeEspecial models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistersCodeEspecialSearchc();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RegistersCodeEspecial model.
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
     * Creates a new RegistersCodeEspecial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($extra = false)
    {
        $model = new RegistersCodeEspecial();

        
        $code = new \app\models\Code;


        $model->create_date = new Expression('NOW()');
         
        if($model->load(Yii::$app->request->post())) {
            
            $model->organization =  Yii::$app->user->identity->id;
            $model->date_buy = DateFormat::formatDateEu($model->date_buy);
                
            if($extra != false)
            {
                
                $model->extra = $extra;
                $RE = new RegistersExtra;
                $ob = $RE::findOne($extra);
                
                $ob->restAmount($model->amount);
            
                $ob->save();

            }
           
               // var_dump($model->save());
            if($model->save())
            {     
                return $this->redirect(['view', 'id' => $model->id]);
            }    
        }

            return $this->render('create', [
                'model' => $model,
                 'code' => $code,
            ]);
        
    }

    /**
     * Updates an existing RegistersCodeEspecial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

         $code = new \app\models\Code;
        
        
        if ($model->load(Yii::$app->request->post())) {
            $model->date_buy = DateFormat::formatDateEu($model->date_buy);
            if($model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }    
        }
            return $this->render('update', [
                'model' => $model,
                'code' => $code,
            ]);
        
    }

    /**
     * Deletes an existing RegistersCodeEspecial model.
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
     * Finds the RegistersCodeEspecial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegistersCodeEspecial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegistersCodeEspecial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    function actionOldRegisters()
    {
        $searchModel = new RegistersCodeEspecialSearchc();
        
        $dataProvider = $searchModel->searchAll(Yii::$app->request->queryParams);
        
        if(Yii::$app->user->identity->role == 1)
        {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else
            {
                return $this->render('indexnoadmin', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);   
            }    
    }

    function actionSearchAdvance()
    {
        $searchModel = new RegistersCodeEspecialSearchc();
        $model = new RegistersCodeEspecial();
        //$dataProvider = $searchModel->searchAll(Yii::$app->request->queryParams);
       
        if (Yii::$app->request->post()) {
            
            //var_dump(Yii::$app->request->post());die();
            $post = Yii::$app->request->post();
            $dataProvider = $searchModel->searchAdvance($post);
           
            if(Yii::$app->user->identity->role == 1)
            {
                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }else
                {
                    return $this->render('indexnoadmin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    ]);   
                }
         }       
        return $this->render('_formsearch', [
                   "model" => $searchModel,
                ]);    
    }
}
