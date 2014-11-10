<?php

namespace app\controllers;

use Yii;
use app\models\Registers;
use app\models\RegistersSearch;
use app\models\RegistersCodeEspecial;
use yii\web\Controller;
use app\models\Users;
use app\models\Children;
use app\models\RegistersExtra;
use app\models\Code;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
//use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\Query;
use yii\db\Command;

use app\api\DateFormat;
/**
 * RegistersController implements the CRUD actions for Registers model.
 */
class RegistersController extends Controller
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
                    [
                        //'actions' => ['index', 'update'], //alows only this accions
                        'allow' => true,
                        'roles' => Users::hasOrganization(),
                    ],
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
     * Lists all Registers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistersSearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Registers model.
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
     * Creates a new Registers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($extra = false)
    {
        $model = new Registers();
        $children = new \app\models\Children;



        $code = new \app\models\Code;

        $model->create_date = new Expression('NOW()');
        
        if($model->load(Yii::$app->request->post())) {
            
            $session = Yii::$app->session;
            $who = $session->get('organization');    
            if(!empty($who))
            {
                $model->organization = $session->get('organization');
            }
            
            $model->date_buy = DateFormat::formatDateEu($model->date_buy);
            if($extra != false)
            {
                $model->extra = $extra;
               
                $RE = new RegistersExtra;
                $ob = $RE::findOne($extra);
                
                $ob->restAmount($model->amount);
            
                $ob->save();
            }
           
                
            if($model->save())
            {     
                if($extra){
                    return $this->redirect('/registers-extra/view?id='.$extra);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }    

        } else {
            return $this->render('create', [
                'model' => $model,
                'code' => $code,
                'children' => $children,
            ]);
        }
    }

    /**
     * Updates an existing Registers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $extra=false)
    {
        $model = $this->findModel($id);
        $children = new \app\models\Children;
        $code = new \app\models\Code;
        $model->update_date = new Expression('NOW()');
       
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
                'code' => $code,
                'children' => $children,
            ]);
        }
    }

    /**
     * Deletes an existing Registers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id,$extra = false)
    {
        //var_dump($extra); die();
        $model = $this->findModel($id); 
        $model->delete();
        if($extra != false)
        {
            $RE = new RegistersExtra;
            $ob = $RE::findOne($extra);
                
            $ob->sumeAmount($model->amount);
            $ob->save();
            return $this->redirect('/registers-extra/view?id='.$extra);    
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Registers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Registers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Registers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     public function actionRegistered()
    {
        $reg = new \app\models\Registers;
        
        $codes = Code::find()->where('code.especial!=1')->all();
        $codesespecial = Code::find()->where('code.especial=1')->all();
        

        $childrens = $reg->getChildrenTotalByValue();
       
        $childrenlastmonth = $reg->getChildrenTotalByValue('last');
        $rcelast = RegistersCodeEspecial::getRegistersByMonth('last');
        //echo "<pre>";
         //var_dump($childrenlastmonth);die();
        //$registers = Registers::getRegistersByMonth();
        $registers = Registers::getRegistersByMonthWithAllCode($codes);
        $rce = RegistersCodeEspecial::getRegistersByMonth();
        
        $total_rce =  (float) RegistersCodeEspecial::getTotal();
        $total = (float) Registers::getTotal();
        
       //var_dump($total);die();
        //$lastregisters = Registers::getRegistersByMonth('l');
        $lastregisters = Registers::getRegistersByMonthWithAllCode($codes, 'last');
        
        //echo '<pre>';   
        //var_dump($lastregisters);die();
        $lasttotal = (float) Registers::getTotal('last');
        $last_total_rce =  (float) RegistersCodeEspecial::getTotal('last');
        
        $result_total = -($lasttotal+$last_total_rce) + ($total + $total_rce);
        /*echo $result_total = -($lasttotal+$last_total_rce) + ($total + $total_rce).'<br>';
        echo $lasttotal.'+'. $last_total_rce. '='.  ($lasttotal+$last_total_rce).'<br>';
        echo $total.'+'. $total_rce. '='.  ($total+$total_rce);
        die();*/
        $query = Registers::find();
        
        
            return $this->render('registered', [
                'registers' => $registers,
                'lastregisters' => $lastregisters,
                'children' => $childrens,
                'childrenlastmonth' => $childrenlastmonth,
                'total' => $total,
                'lasttotal' => number_format($lasttotal,2,',','.'),
                "rcelast" => $rcelast,
                "rce" => $rce,
                'codes' => $codes,
                'codesespecial' => $codesespecial,
                'result_total' => number_format($result_total,2,',','.'),
            ]);
     
    }

    function actionOldRegisters()
    {
        $searchModel = new RegistersSearch();
        
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
        $searchModel = new RegistersSearch();
        $model = new Registers();
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
