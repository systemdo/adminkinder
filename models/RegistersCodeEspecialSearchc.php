<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RegistersCodeEspecial;
use app\models\Registers;

/**
 * RegistersCodeEspecialSearchc represents the model behind the search form about `app\models\RegistersCodeEspecial`.
 */
class RegistersCodeEspecialSearchc extends RegistersCodeEspecial
{
    public $abbreviation;
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
            [['process','extract','abbreviation','create_date', 'update_date', 'date_buy'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RegistersCodeEspecial::find();

        $dateadmin = Registers::currentAdministrativeMonth();
        $begin = $dateadmin['begin']; 
        $end = $dateadmin['end']; 

         if(Yii::$app->user->identity->role != 1)
        {
            $query = RegistersCodeEspecial::find()->where('registers_code_especial.organization='.Yii::$app->user->identity->id);
            
        }
        $query->where('date_buy >="'.$begin.'"AND date_buy <="'. $end.'"');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10],
        ]);

        $dataProvider->sort->attributes['abbreviation'] = 
        [
            'asc' => ['code.abbreviation' => SORT_ASC],
            'desc' => ['code.abbreviation' => SORT_DESC],
        ];


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
         

        $query->andFilterWhere([
            'id' => $this->id,
            'voucher' => $this->voucher,
            'extract' => $this->extract,
            'date_buy' => $this->date_buy,
            'code' => $this->code,
            'amount' => $this->amount,
            'organization' => $this->organization,
            'extra' => $this->extra,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['like', 'process', $this->process]);

        return $dataProvider;
    }

    public function searchAll($params)
    { 
        $query = RegistersCodeEspecial::find();
        $dateadmin = Registers::currentAdministrativeMonth();
        $begin = $dateadmin['begin']; 
        $end = $dateadmin['end']; 

        if(Yii::$app->user->identity->role != 1)
        {
            $query = RegistersCodeEspecial::find()->andwhere('registers_code_especial.organization='.Yii::$app->user->identity->id);
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

        if (!($this->load($params) && $this->validate())) {
    
            $query->joinWith(['code']);
            $query->where('date_buy <"'.$begin.'"');
            return $dataProvider;
        }

        $query->andFilterWhere([
            //'id' => $this->id,
            'voucher' => $this->voucher,
            //'date_buy' => $this->date_buy,
            //'extract' => $this->extract,
            
            //'amount' => $this->amount,
            
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);
        //$query->andFilterWhere(['like', 'extract', $this->extract]);
        $query->andWhere('extract Like "%'.$this->extract.'%"');
        $query->andWhere('date_buy Like "%'.$this->date_buy.'%"');
        $query->andWhere('amount Like "%'.$this->amount.'%"');
        $query->joinWith(['code' => function ($q) {
            $q->where('code.abbreviation LIKE "%' . $this->abbreviation . '%"');
        }]);
    
        //echo "<pre>";
        //var_dump($dataProvider); die();
        return $dataProvider;
    }
    public function searchAdvance($post)
    {
            $organization = $post['RegistersCodeEspecialSearchc']['organization'];
            $begin = $post['RegistersCodeEspecialSearchc']['begin_date'];
            $end = $post['RegistersCodeEspecialSearchc']['end_date'];
        
        $query = RegistersCodeEspecial::find();
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

        
            $query->joinWith(['code']);
            $query->where('date_buy >="'.$begin.'"AND date_buy <="'. $end.'"');
            $query->andWhere('registers_code_especial.organization ='.$organization);
            
            return $dataProvider;
    }
}
