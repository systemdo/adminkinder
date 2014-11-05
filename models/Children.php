<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "children".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $organization
 * @property integer $account_pay
 * @property string $create_date
 * @property string $update_date
 *
 * @property Registers[] $registers
 */
class Children extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'children';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_pay','organization' ], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['surname'], 'string', 'max' => 45]
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
            'organization' => Yii::t('app', 'Organization'),
            'account_pay' => Yii::t('app', 'Account Pay'),
            'create_date' => Yii::t('app', 'Create Date'),
            'update_date' => Yii::t('app', 'Update Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegisters()
    {
        return $this->hasMany(Registers::className(), ['child' => 'id']);
    }

    public function getListRegister()
    {

        $query = new Query();
        $query->select('c.name, c.surname, r.amount, e.abbreviation as codename, sum(amount) as total')
        ->from('children as c')
        ->innerJoin('registers as r','c.id = r.child')
        ->innerJoin('code as e','r.code= e.id')
        ->groupBy('c.name');
        //$registers = $query->all();
        $command = $query->createCommand();
        $registers = $command->queryAll();
        return $registers;
    }
}
