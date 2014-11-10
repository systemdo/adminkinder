<?php

namespace app\models;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property integer $account
 * @property string $password
 * @property string $email
 * @property string $update_date
 * @property string $create_date
 * @property integer $role
 *
 * @property Roles $role0
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    //private $username;
    static $users = array();
    public $authKey;
    public $accessToken;
    /**
     * @inheritdoc
     **
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        //var_dump(static::findOne($id));die();
        $users = static::findOne($id); 
        return $users;
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     *
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    
    public static function findIdentityByAccessToken($token, $type = null)
    {

        return static::findOne(['access_token' => $token]);
    }

     public static function findByUsername($username)
    {
        ///var_dump(\Yii::$app->user->login());die();
        $users = Users::find()->all();        
        //$users = self::findIdenty(); 
        //echo "<pre>";
        //var_dump(self::$users);       
        //var_dump(Users::find()->all());   die();    
        foreach ($users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
              
                return new static($user);
                }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     *
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

     public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'role'], 'integer'],
            [['update_date', 'create_date'], 'safe'],
            [['role', 'name', 'username', 'email','account'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['surname', 'password'], 'string', 'max' => 200],
            [['username'], 'string', 'max' => 30],
            [['email'], 'email'],
            [['account', 'username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'surname' => Yii::t('app', 'Surname'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'account' => Yii::t('app', 'Account'),
            'password' => Yii::t('app', 'Password'),
            'update_date' => Yii::t('app', 'Update Date'),
            'create_date' => Yii::t('app', 'Create Date'),
            'role' => Yii::t('app', 'Role'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole0()
    {
        return $this->hasOne(Roles::className(), ['id' => 'role']);
    }

    public function getRole()
    {
        return Roles::findOne($this->role)->rule;
    }
     

     public function generatePassword()
    {
        $tring = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        //$tringabcdefghijklmnopqrstuvwxyz"
        $password = $tring[rand(0,25)]. $tring[rand(0,25)]. rand(0,9). rand(0,9);
        $password .=rand(0,9) .rand(0,9). strtolower($tring[rand(0,25)]).strtolower($tring[rand(0,25)]);   
        return $password;
        //return md5($password);
    }

    static public function verifyRole()
    {
        //var_dump(isset(Yii::$app->user->identity));die();
        if(isset(Yii::$app->user->identity))
        {
            //rewview logic and seccion BUli
            if(Yii::$app->user->identity->role == 2 or Yii::$app->user->identity->role == 3)
            {
                throw new NotFoundHttpException('The requested page does not exist.');die();
            }
        }else
            {
                return ['@'];
            }    
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegisters()
    {
        return $this->hasMany(Registers::className(), ['usersystem' => 'id']);
    }

    static public function isSuperAdmin()
    {
        if(isset(Yii::$app->user->identity))
        {
            //rewview logic and seccion BUli
            if(Yii::$app->user->identity->role == 1)
            {
                return true;
            }
        }
        return false;
    }

    static function accountUser()
    {
        if(isset(Yii::$app->user->identity))
        {   
            $id = Yii::$app->user->identity->id;
            $user= Users::find($id)->one();
            
            return $user->account;
        }else
            {
                 throw new NotFoundHttpException('The requested page does not exist.');die();
            }    
    }

    static function hasOrganization()
    {
        
        $session = Yii::$app->session;
        $who = $session->get('organization');
           //var_dump($who); die();     
            if(!empty($who)){
                return ['@'];   
            }else
            {   
                //var_dump(Yii::$app->request->getBaseUrl());
                //die('helo');
                if(Users::isSuperAdmin())
                    Yii::$app->response->redirect(Yii::$app->request->baseUrl.'login/choose-organization'); 
                else
                    Yii::$app->response->redirect('login');
            }
                
    }
    static function getOrg()
    {
        $session = Yii::$app->session;
        $who = $session->get('organization');    
        return $who;     
    }


    
}
