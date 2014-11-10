<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use app\models\Roles;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;


/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    public function behaviors()
    {
        return [
            
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['index', 'create'],pensa en una funncion para controles de acccion
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], //solamente a usaurios autenticados
                    ],
                    [
                        //'actions' => ['index', 'update'], //alows only this accions
                        'allow' => true,
                        'roles' => Users::verifyRole(),
                        //'ip' =>'233';
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @param integer $role
     * @return mixed
     */
    public function actionView($id, $role)
    {
        $session = Yii::$app->session;
        $pass = $session->get('pass');
        $session->remove('pass');
        return $this->render('view', [
            'model' => $this->findModel($id, $role),
            'pass' => $pass,
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();
        $model->create_date = new Expression('NOW()');
        if ($model->load(Yii::$app->request->post())) {
        
                $password = $model->generatePassword();
                $model->password = md5($password);
                //var_dump($model->password); die();
            if($model->save()){
                //enviar email
                /*$this->layout=false;
                $html = $this->render('email', ['model' => $model, 'password'  => $password]);
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                @mail($model->email,'Deine Password',$html, $cabeceras);*/
                $session = Yii::$app->session;
                $session->set('pass',$password);

                return $this->redirect(['view', 'id' => $model->id, 'role' => $model->role]);
            }else {
                    return $this->render('create', [
                'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $role
     * @return mixed
     */
    public function actionUpdate($id, $role)
    {
        $model = $this->findModel($id, $role);
        $model->update_date = new Expression('NOW()'); 
                $change = Yii::$app->request->post();
                if(isset($change['change']))
                {
                    $password = $model->generatePassword();
                    $model->password = md5($password);
                    $session = Yii::$app->session;
                    $session->set('pass',$password);

                }    
        //var_dump(Yii::$app->request->post()); die();   
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'role' => $model->role]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $role
     * @return mixed
     */
    public function actionDelete($id, $role)
    {
        $this->findModel($id, $role)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $role
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $role)
    {
        if (($model = Users::findOne(['id' => $id, 'role' => $role])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
