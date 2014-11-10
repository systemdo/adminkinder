<?php

namespace app\models;
use Yii;
use yii\db\Query;

use app\api\DateFormat;
use app\models\Users;

/**
 * This is the model class for table "registers_extra".
 *
 * @property integer $id
 * @property integer $voucher
 * @property integer $extract
 * @property string $date_buy
 * @property string $process
 * @property string $amount
 * @property integer $organization
 * @property string $create_date
 * @property string $update_date
 */
class RegistersExtra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registers_extra';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
       return [
            [['extract', 'date_buy', 'process', 'amount'], 'required'],
            [['extract'], 'integer'],
            [['amount'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['create_date', 'update_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'voucher' => Yii::t('app', 'Voucher'),
            'extract' => Yii::t('app', 'Extract'),
            'date_buy' => Yii::t('app', 'Date Buy'),
            'process' => Yii::t('app', 'Process'),
            'amount' => Yii::t('app', 'Amount'),
            'organization' => Yii::t('app', 'Organization'),
            'create_date' => Yii::t('app', 'Create Date'),
            'update_date' => Yii::t('app', 'Update Date'),
            'begin_date' => Yii::t('app', 'Date of Buy'),
            'end_date' => Yii::t('app', 'Date of Buy'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
       
        return $this->hasOne(Users::className(), ['id' => 'organization']);
    }

    function getAmountFormat()
     {
        return  number_format((float)$this->amount, 2, ',', '.');
     }

     function getFormatDateRegister()
    {
       // var_dump($this->date_buy);
       //return $this->date_buy;
       return str_replace('-','.', DateFormat::formatDateDe($this->date_buy));
    }
    function getFormatDateRegisterEu()
    {
       // var_dump($this->date_buy);
       //return $this->date_buy;
       return DateFormat::formatDateEu($this->date_buy);
    }

    public function getDateBuy()
    {
        
        return DateFormat::formatDateDe($this->date_buy);
    }

    function restAmount($rest)
    {
        
        $this->amount = $this->amount - $rest;
        //var_dump($this->amount);
        //var_dump($rest); die();
    }

    function sumeAmount($sume)
    {
        $this->amount = $this->amount + $sume;

    }

    function getAllRegistersbyIdExtras($id_extra)
    {
        $query = new Query();
        $query->select('*')
        ->from('registers')
        ->where('extra='.$id_extra)
         ->andwhere('organization ='.Users::getOrg());
        //->groupBy('c.name');
        //var_dump($query);die();
        $command = $query->createCommand();
        $registers = $command->queryAll();
        return $registers;

    }

    function getAllRegistersbyCodeEspecialIdExtras($id_extra)
    {
        $query = new Query();
        $query->select('*')
        ->from('registers_code_especial')
        ->where('extra='.$id_extra)
        ->andwhere('organization ='.Users::getOrg());
        //->groupBy('c.name');
        //var_dump($query);die();
        $command = $query->createCommand();
        $registers = $command->queryAll();
        return $registers;

    }
}
