<?php

namespace app\models;

use Yii;

use app\api\DateFormat;
use yii\db\Query;

/**
 * This is the model class for table "registers_code_especial".
 *
 * @property integer $id
 * @property integer $voucher
 * @property integer $extract
 * @property string $date_buy
 * @property integer $code
 * @property string $process
 * @property string $amount
 * @property integer $organization
 * @property integer $extra
 * @property string $create_date
 * @property string $update_date
 */
class RegistersCodeEspecial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registers_code_especial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
       return [
            [['extract', 'date_buy','code', 'process', 'amount'], 'required'],
            [['extract', 'code'], 'integer'],
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
            'code' => Yii::t('app', 'Code'),
            'process' => Yii::t('app', 'Process'),
            'amount' => Yii::t('app', 'Amount'),
            'organization' => Yii::t('app', 'Organization'),
            'extra' => Yii::t('app', 'Extra'),
            'create_date' => Yii::t('app', 'Create Date'),
            'update_date' => Yii::t('app', 'Update Date'),
            'begin_date' => Yii::t('app', 'Date of Buy'),
            'end_date' => Yii::t('app', 'Date of Buy'),
        ];
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
     public function getAbbreviation()
    {
        //var_dump($this->code);
        //var_dump(Code::findOne($this->code));die();
        return Code::findOne($this->code)->abbreviation;
    }
    public function getCodeName()
    {
        //var_dump($this->code);
        //var_dump(Code::findOne($this->code));die();
        return Code::findOne($this->code)->name;
    }

    public function getDateBuy()
    {
        
        return $this->date_buy = DateFormat::formatDateDe($this->date_buy);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCode()
    {
       
        return $this->hasOne(Code::className(), ['id' => 'code']);
    }

     static function getRegistersByMonth($month = false)
    {

        //$betweendate = Registers::currentDate($month);
        $betweendate = Registers::currentAdministrativeMonth($month);

        $begin = $betweendate['begin'];
        $end = $betweendate['end'];

        $query = new Query();
        $query->select('c.abbreviation,sum(r.amount) as amount')
        ->from('registers_code_especial as r')
        ->innerJoin('code as c','c.id=r.code')
        ->where('r.date_buy >="'.$begin.'"AND r.date_buy <="'. $end.'"')
        ->groupBy('c.abbreviation');
        $command = $query->createCommand();
        return $registers = $command->queryAll();
    }

    static public function getTotal($month = false)
    {
        //$betweendate = Registers::currentDate($month);
        $betweendate = Registers::currentAdministrativeMonth($month);
        
        $begin = $betweendate['begin'];
        $end = $betweendate['end'];
        
        $query = new Query();
        $query->select('*, sum(amount) as total')
        ->from('registers_code_especial as r')
        ->where('date_buy >="'.$begin.'"AND date_buy <="'. $end.'"');
        //->groupBy('c.name');
        //var_dump($query);die();
        $command = $query->createCommand();
        $total = $command->queryAll();
        if(!isset($total[0]['total']))
        {
            return "0,00";
        }
        $total = $total[0]['total'];
        //$total = number_format($total, '2', ',', '.'); 
        return $total;
    }

}
