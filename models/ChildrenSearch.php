<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Children;

/**
 * ChildrenSearch represents the model behind the search form about `app\models\Children`.
 */
class ChildrenSearch extends Children
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'account_pay'], 'integer'],
            [['name', 'surname', 'organization', 'create_date', 'update_date'], 'safe'],
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
       
        if(Yii::$app->user->identity->role != 1)
        {
            $query->where(['organization' => Yii::$app->user->identity->id]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
        'pageSize' => 10],
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            //echo '<pre>';
        //var_dump($dataProvider);
           // die();
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'account_pay' => $this->account_pay,
            'organization' => $this->organization,
            //'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'organization', $this->organization]);

        return $dataProvider;
    }
}
