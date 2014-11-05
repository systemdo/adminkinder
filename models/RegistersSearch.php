<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Registers;

/**
 * RegistersSearch represents the model behind the search form about `app\models\Registers`.
 */
class RegistersSearch extends Registers
{
    public $abbreviation;
    public $childName;  
    public $childSurname;  
    public $begin_date;  
    public $end_date;  

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'voucher', 'extract'], 'integer'],
            [['amount'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['childName','childSurname','process','extract','abbreviation','create_date', 'update_date', 'date_buy'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function searchAdvance($post)
    {
            $organization = $post['RegistersSearch']['organization'];
            $begin = $post['RegistersSearch']['begin_date'];
            $end = $post['RegistersSearch']['end_date'];
        
        $query = Registers::find();
        //var_dump($query);die();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10],
        ]);
        

        $dataProvider->sort->attributes['abbreviation'] = 
        [
            'asc' => ['code.abbreviation' => SORT_ASC],
            'desc' => ['code.abbreviation' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['childName'] = 
        [
            'asc' => ['children.name' => SORT_ASC],
            'desc' => ['children.name' => SORT_DESC],
        ]; 
        $dataProvider->sort->attributes['childSurname'] = 
        [
            'asc' => ['children.surname' => SORT_ASC],
            'desc' => ['children.Surname' => SORT_DESC],
        ];
    
       
    
            $query->joinWith(['code', 'child']);
            $query->where('date_buy >="'.$begin.'"AND date_buy <="'. $end.'"');
            $query->andWhere('registers.organization ='.$organization);
            
            return $dataProvider;
    }

    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $dateadmin = self::currentAdministrativeMonth();
        $begin = $dateadmin['begin']; 
        $end = $dateadmin['end']; 
        
        $query = Registers::find();
        
        if(Yii::$app->user->identity->role != 1)
        {
            $query = Registers::find()->andwhere('registers.organization='.Yii::$app->user->identity->id);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10],
        ]);
        

        $dataProvider->sort->attributes['abbreviation'] = 
        [
            'asc' => ['code.abbreviation' => SORT_ASC],
            'desc' => ['code.abbreviation' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['childName'] = 
        [
            'asc' => ['children.name' => SORT_ASC],
            'desc' => ['children.name' => SORT_DESC],
        ]; 
        $dataProvider->sort->attributes['childSurname'] = 
        [
            'asc' => ['children.surname' => SORT_ASC],
            'desc' => ['children.Surname' => SORT_DESC],
        ];
    
        if (!($this->load($params) && $this->validate())) {
    
            $query->joinWith(['code', 'child']);
            $query->where('date_buy >="'.$begin.'"AND date_buy <="'. $end.'"');
            return $dataProvider;
        }

        $query->andFilterWhere([
            //'id' => $this->id,
            'voucher' => $this->voucher,
            //'date_buy' => $this->date_buy,
            //'extract' => $this->extract,
            
            'amount' => $this->amount,
            
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);
        //$query->andFilterWhere(['like', 'extract', $this->extract]);
        $query->andWhere('extract Like "'.$this->extract.'%"');
        $query->andWhere('date_buy Like "%'.$this->date_buy.'%"');
        $query->joinWith(['code' => function ($q) {
            $q->where('code.abbreviation LIKE "%' . $this->abbreviation . '%"');
        }]);
        $query->joinWith(['child' => function ($q) {
            $q->where('children.name LIKE "%' . $this->childName . '%"');
        }]);
        $query->joinWith(['child' => function ($q) {
            $q->where('children.surname LIKE "%' . $this->childSurname . '%"');
        }]);
        //$query->where('date_buy >="'.$begin.'"AND date_buy <="'. $end.'"');
        //echo '<pre>';
       // var_dump($params);
        //var_dump($query);
        //die();
        //echo "<pre>";
        //var_dump($dataProvider); die();
        return $dataProvider;
    }

    public function searchAll($params)
    { 
        $query = Registers::find();
        $dateadmin = self::currentAdministrativeMonth();
        $begin = $dateadmin['begin']; 
        $end = $dateadmin['end']; 

        if(Yii::$app->user->identity->role != 1)
        {
            $query = Registers::find()->andwhere('registers.organization='.Yii::$app->user->identity->id);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10],
        ]);
        

        $dataProvider->sort->attributes['abbreviation'] = 
        [
            'asc' => ['code.abbreviation' => SORT_ASC],
            'desc' => ['code.abbreviation' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['childName'] = 
        [
            'asc' => ['children.name' => SORT_ASC],
            'desc' => ['children.name' => SORT_DESC],
        ]; 
        $dataProvider->sort->attributes['childSurname'] = 
        [
            'asc' => ['children.surname' => SORT_ASC],
            'desc' => ['children.Surname' => SORT_DESC],
        ];
    
        if (!($this->load($params) && $this->validate())) {
    
            $query->joinWith(['code', 'child']);
            $query->where('date_buy <"'.$begin.'"');
            return $dataProvider;
        }

        $query->andFilterWhere([
            //'id' => $this->id,
            'voucher' => $this->voucher,
            //'date_buy' => $this->date_buy,
            //'extract' => $this->extract,
            
            'amount' => $this->amount,
            
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);
        //$query->andFilterWhere(['like', 'extract', $this->extract]);
        $query->andWhere('extract Like "'.$this->extract.'%"');
        $query->andWhere('date_buy Like "%'.$this->date_buy.'%"');
        $query->joinWith(['code' => function ($q) {
            $q->where('code.abbreviation LIKE "%' . $this->abbreviation . '%"');
        }]);
        $query->joinWith(['child' => function ($q) {
            $q->where('children.name LIKE "%' . $this->childName . '%"');
        }]);
        $query->joinWith(['child' => function ($q) {
            $q->where('children.surname LIKE "%' . $this->childSurname . '%"');
        }]);
        //echo "<pre>";
        //var_dump($dataProvider); die();
        return $dataProvider;
    }
}
