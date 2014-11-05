<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "code".
 *
 * @property integer $id
 * @property string $name
 * @property string $abbreviation
 * @property integer $especial
 *
 * @property Registers[] $registers
 */
class Code extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','abbreviation', 'especial'], 'required'],
            [['name', 'abbreviation'], 'string', 'max' => 45]
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
            'abbreviation' => Yii::t('app', 'Abbreviation'),
            'especial' => Yii::t('app', 'Code Especial'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegisters()
    {
        return $this->hasMany(Registers::className(), ['code' => 'id']);
    }

    public function getEspecialCode()
    {
        if($this->especial == 1 )
        {
            return "Ja";
        }
        else
            {
                return "Nein";
            }
    }
}
