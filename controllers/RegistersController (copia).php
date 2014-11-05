<?php

namespace app\controllers;

use Yii;
use app\models\Registers;
use app\models\RegistersSearch;
use yii\web\Controller;
use app\models\Users;
use app\models\Children;
use app\models\Code;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
//use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\Query;
use yii\db\Command;
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
     * Lists all Registers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistersSearch();
        //Users::verifyRole();
        //echo "<pre>";
        //var_dump(Yii::app()->user->checkAccess());
         //var_dump(Yii::$app->user->identity->role); die();
         //var_dump(Yii::$app->authManager); die();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        //$user = new Users;
        //$user->getIndenty();
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
    public function actionCreate()
    {
        $model = new Registers();
        $children = new \app\models\Children;

        $code = new \app\models\Code;

        $model->create_date = new Expression('NOW()');
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $children = new \app\models\Children;
        $code = new \app\models\Code;
        $model->update_date = new Expression('NOW()');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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
        //var_dump(date("Y-m-d"));die();
        $betweendate = Registers::currentDate();
        $begin = $betweendate['begin'];
        $end = $betweendate['end'];
        //var_dump(Registers::currentDate());die();
        //$childrens = $reg->getListRegisterByChildrenByCode();
        $childrens = $reg->getChildrenTotalByValue();
        $childrenlastmonth = $reg->getChildrenTotalByValue('l');

        $query = new Query();
        $query->select('c.abbreviation,sum(r.amount) as amount')
        ->from('registers as r')
        ->innerJoin('code as c','c.id=r.code')
        ->where('r.date_buy >="'.$begin.'"AND r.date_buy <="'. $end.'"')
        ->groupBy('c.abbreviation');

        $command = $query->createCommand();
        $registers = $command->queryAll();
        $total = Registers::getTotal($begin, $end);
        //var_dump($total); die();
        
        $betweendate = Registers::currentDate('l');
        $begin = $betweendate['begin'];
        

        $query2 = new Query();
        $query2->select('c.abbreviation,sum(r.amount) as amount')
        ->from('registers as r')
        ->innerJoin('code as c','c.id=r.code')
        ->where('r.date_buy >="'.$begin.'"AND r.date_buy <="'. $end.'"')
        ->groupBy('c.abbreviation');
        //var_dump($query2);die();
        $command2 = $query2->createCommand();
        $lastregisters = $command2->queryAll();
        
        $lasttotal = Registers::getTotal($begin, $end);
        //var_dump($lasttotal); die();
        $query = Registers::find();
        
        $codes = Code::find()->all();
        
            return $this->render('registered', [
                'registers' => $registers,
                'lastregisters' => $lastregisters,
                'children' => $childrens,
                'childrenlastmonth' => $childrenlastmonth,
                'total' => $total,
                'lasttotal' => $lasttotal,
                'codes' => $codes,
            ]);
     
    }

}
