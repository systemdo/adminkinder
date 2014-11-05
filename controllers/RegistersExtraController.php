<?php

namespace app\controllers;

use Yii;
use app\models\Registers;
use app\models\RegistersSearch;
use app\models\RegistersExtra;
use app\models\RegistersExtraSearch;
use app\api\DateFormat;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegistersExtraController implements the CRUD actions for RegistersExtra model.
 */
class RegistersExtraController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'actions' => ['index', 'update'], //alows only this accions
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
     * Lists all RegistersExtra models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistersExtraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RegistersExtra model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        //$searchModel = new RegistersSearch();
        //$dataProvider = $searchModel->searchByExtra($id);
        $re = new RegistersExtra();
        //echo"<pre>";    
        //var_dump($re->getAllRegistersbyIdExtras($id));
        $registers = $re->getAllRegistersbyIdExtras($id);
        
        $obRegisters = new Registers();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'registers' => $registers,
            're' => $obRegisters
        ]);
    }

    /**
     * Creates a new RegistersExtra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegistersExtra();
        
        if ($model->load(Yii::$app->request->post())) {
            
            $model->date_buy = DateFormat::formatDateEu($model->date_buy);
            $model->organization = Yii::$app->user->identity->id;
        
               if($model->save())
               {
                 return $this->redirect(['view', 'id' => $model->id]);
               }  
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RegistersExtra model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->date_buy = DateFormat::formatDateEu($model->date_buy);
            //var_dump($model->date_buy);die();
            if($model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }    
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RegistersExtra model.
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
     * Finds the RegistersExtra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegistersExtra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegistersExtra::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    function actionOldRegisters()
    {
        $searchModel = new RegistersExtraSearch();
        
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
        $searchModel = new RegistersExtraSearch();
        $model = new RegistersExtra();
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
