<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Children;

/**
 * ChildrenSearch represents the model behind the search form about `app\models\Children`.
 */
class ChildrenRegistersSearch extends Children
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['surname'], 'safe'],
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
        $query = Children::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $attributes = [];

        $children = $this->getListRegister();

        //echo "<pre>";
        //var_dump($children); die();
        foreach ($children as $key => $value) {
            
            foreach ($value as $key1 => $r) {
               
            //$attributes[$key1] = ['asc' => $key1, 'desc'=> $key1];
                $attributes[] = $key1;
                //$query->andFilterWhere(['like', $key1, $value])
            }//$attributes[$key] = array('asc' => $key);
        }
         
         //echo "<pre>";
        //var_dump($attributes); die();
        
         $dataProvider->setSort([
             'attributes' => $attributes,
        ]);


        return $dataProvider;
    }
}
