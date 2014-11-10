<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RegistersExtra;
use app\models\Registers;


/**
 * RegistersExtraSearch represents the model behind the search form about `app\models\RegistersExtra`.
 */
class RegistersExtraSearch extends RegistersExtra
{
    public $begin_date;  
    public $end_date;  
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'voucher', 'extract', 'organization'], 'integer'],
            [['date_buy', 'process', 'create_date', 'update_date'], 'safe'],
            [['amount'], 'number'],
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
        $query = RegistersExtra::find();
        $dateadmin = Registers::currentAdministrativeMonth();
        $begin = $dateadmin['begin']; 
        $end = $dateadmin['end']; 
        //var_dump($begin);die();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10],
            'sort'=>[
                        'defaultOrder' => [
                        'date_buy' => SORT_DESC,
                        //'abbreviation' => SORT_ASC 
                        ]
            ]
        ]);
        $query->where('date_buy >="'.$begin.'"AND date_buy <="'. $end.'"');
        $session = Yii::$app->session;
        $who = $session->get('organization');    
        $query->andwhere(['organization' => $who]); 

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'voucher' => $this->voucher,
            //'extract' => $this->extract,
            //'date_buy' => $this->date_buy,
            //'amount' => $this->amount,
            //'organization' => $this->organization,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);
        $query->andWhere('extract Like "'.$this->extract.'%"');
        $query->andWhere('date_buy Like "%'.$this->date_buy.'%"');
        $query->andFilterWhere(['like', 'process', $this->process]);

        return $dataProvider;
    }

    public function searchAll($params)
    { 
        $query = RegistersExtra::find();
        $dateadmin = Registers::currentAdministrativeMonth();
        $begin = $dateadmin['begin']; 
        $end = $dateadmin['end']; 
        $query->where('date_buy <"'.$begin.'"');
        
        $session = Yii::$app->session;
        $who = $session->get('organization');    
        $query->andwhere(['registers_extra.organization' => $who]); 

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10],
            'sort'=>[
                        'defaultOrder' => [
                        'date_buy' => SORT_DESC,
                        //'abbreviation' => SORT_ASC 
                        ]
            ]
        ]);
        

        
        if (!($this->load($params) && $this->validate())) {
    
            return $dataProvider;
        }

        $query->andFilterWhere([
            //'id' => $this->id,
            //'voucher' => $this->voucher,
            //'date_buy' => $this->date_buy,
            //'extract' => $this->extract,
            
            'amount' => $this->amount,
            
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);
        //$query->andFilterWhere(['like', 'extract', $this->extract]);
        $query->andWhere('extract Like "'.$this->extract.'%"');
        $query->andWhere('date_buy Like "%'.$this->date_buy.'%"');
        
        //echo "<pre>";
        //var_dump($dataProvider); die();
        return $dataProvider;
    }
    public function searchAdvance($post)
    {
            $session = Yii::$app->session;
            $who = $session->get('organization');   

            $organization = $who;
            $begin = $post['RegistersExtraSearch']['begin_date'];
            $end = $post['RegistersExtraSearch']['end_date'];
        
        $query = RegistersExtra::find();
        //var_dump($query);die();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10],
            'sort'=>[
                        'defaultOrder' => [
                        'date_buy' => SORT_DESC,
                        //'abbreviation' => SORT_ASC 
                        ]
            ]
        ]);
        
        

             $query->where('date_buy >="'.$begin.'"AND date_buy <="'. $end.'"');
            $query->andWhere('registers_extra.organization ='.$organization);
            
            return $dataProvider;
    }
}
