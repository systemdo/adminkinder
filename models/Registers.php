<?php

namespace app\models;

use Yii;
use yii\db\Query;
use app\api\DateFormat;

/**
 * This is the model class for table "registers".
 *
 * @property integer $id
 * @property integer $voucher
 * @property string  $date_buy
 * @property integer $extract
 * @property integer $code
 * @property integer $process
 * @property double $amount
 * @property integer $child
 * @property integer $organization
 * @property integer $extra
 * @property string $create_date
 * @property string $update_date
 *
 * @property Code $code0
 * @property Children $child0
 */
class Registers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extract', 'date_buy','code', 'process', 'amount', 'child'], 'required'],
            [['extract', 'code', 'child'], 'integer'],
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
            'code' => Yii::t('app', 'Code'),
            'abbreviation' => Yii::t('app', 'Abbreviation'),
            'process' => Yii::t('app', 'Process'),
            'amount' => Yii::t('app', 'Amount'),
            'organization' => Yii::t('app', 'Organization'),
            'child' => Yii::t('app', 'Child Name'),
            'childName' => Yii::t('app', 'Child Name'),
            'childSurname' => Yii::t('app', 'Surname'),
            'date_buy' => Yii::t('app', 'Date of Buy'),
            'begin_date' => Yii::t('app', 'Date of Buy'),
            'end_date' => Yii::t('app', 'Date of Buy'),
            //'create_date' => Yii::t('app', 'Create Date'),
            //'update_date' => Yii::t('app', 'Update Date'),
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
        //var_dump(str_replace('-','.', DateFormat::formatDateDe($this->date_buy)));die();
       return str_replace('-','.', DateFormat::formatDateDe($this->date_buy));
    }
    function getFormatDateRegisterEu()
    {
       // var_dump($this->date_buy);
       //return $this->date_buy;
       return DateFormat::formatDateEu($this->date_buy);
    }

    public function getNameCodeByRegister()
    {   
        return Code::findOne($this->code)->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCode()
    {
       
        return $this->hasOne(Code::className(), ['id' => 'code']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
       
        return $this->hasOne(Users::className(), ['id' => 'organization']);
    } 
    
    public function getAbbreviation()
    {
        //var_dump($this->code);
        //var_dump(Code::findOne($this->code));die();
        return Code::findOne($this->code)->abbreviation;
    }
    
    public function getChildName()
    {
         //var_dump($this->child);die();
         return  Children::findOne($this->child)->name;
    }
    public function getChildSurname()
    {
         //var_dump($this->child);die();
         return Children::findOne($this->child)->surname;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
          return $this->hasOne(Children::className(), ['id' => 'child']);
           
    }
   static public function currentAdministrativeMonth($current = false)
    {
        $day = date('d');
        $da = 15;
        $month = date('m');
        $month = $month - 1;
        if($current == 'last')
        {
            $month = $month - 2;
        }
        $year = date('Y');
        //current adminstaive month
        $begin = $year.'-'.$month.'-'.$da;
        
        if ($current == false && $month == 12)
        {
            //End year 
            $year = $year + 1;
            // month is 00 because down I sume with 1
            $month = '00';
        }
        /*elseif ($current == "last" && $month  == "01") {
            
        }*/

        $end = $year.'-'.($month + 1).'-'.$da;

        //var_dump($begin);  
        //var_dump($end);  

        return $ca = array('begin'=> $begin, 'end' => $end);
    }

    public function getListRegisterByChildrenByCode($month = '')
    {
        $query = new Query();
        //$betweendate = Registers::currentDate($month);
        $betweendate = Registers::currentAdministrativeMonth($month);
        $begin = $betweendate['begin'];
        $end = $betweendate['end'];
        //var_dump(Users::getOrg());die();
        $query->select('r.code, r.child, r.amount,h.name, h.organization, h.surname, c.abbreviation as codename, sum(amount)as total')
        ->from(' registers as r')
        ->innerJoin('children as h','r.child = h.id')
        ->innerJoin('code as c','r.code=c.id')
        ->where('r.date_buy >="'.$begin.'"AND r.date_buy <="'. $end.'" And h.organization ='.Users::getOrg())
        //->andwhere()
        ->groupBy('h.surname ,c.abbreviation');
        
        //var_dump($query); die();
        $command = $query->createCommand();
        $registers = $command->queryAll();
        
        $result = [];
        foreach ($registers as $key => $value) {
          
            $result[$value['name']][] = $value; 
        }


        return $result;
    }

    //registers of children by month
    function getChildrenTotalByValue($month= '')
    {
        $children = $this->getListRegisterByChildrenByCode($month);
        $codes = Code::find()->all();
        $result = [];
            foreach ($children as $key => $child) {
                
                foreach ($child as $key => $ch) {
                
                    foreach ($codes as $key => $code) {
                        if($ch['code'] == $code['id']){

                            $result[$ch['name']][$code['abbreviation']] = $ch['total'];             
                        }
                }
                 $result[$ch['name']]['id'] = $ch['child'];
                 $result[$ch['name']]['surname'] = $ch['surname'];
            }
        }    
        return $result;
    }

    static function currentDate($current ='c')
    {
        $day = date('d');
        $month = date('m');
        $year = date('Y');
        $begin = '01';
        $end = '31';
        
        
        if($current == 'l')
        { 
            $month = $month - 1;
            $month = '0'.$month;
        
            if($month == 0)
            {
                $month = "12";
                $year = $year - 1;
            }
        
        }
        
        if (!checkdate($month, $end, $year))
        {
            $end = 30;
            if(!checkdate($month, $end, $year))
            {   
                $end = 29;
                if(!checkdate($month, $end, $year))
                {   
                    $end = 28;
                }
            }
            
        }
        
        return array(
                'begin' =>$year.'-'.$month.'-'.$begin,
                'month' =>$month,
                'year' =>$year,
                'end' =>$year.'-'.$month.'-'.$end
            );
    }

    
    static public function getTotal($month = '')
    {
        //$betweendate = Registers::currentDate($month);
        $betweendate = Registers::currentAdministrativeMonth($month);
        
        $begin = $betweendate['begin'];
        $end = $betweendate['end'];
        
        $query = new Query();
        $query->select('*, sum(amount) as total')
        ->from('registers as r')
        ->innerJoin('code as c','c.id=r.code')
        ->where('c.especial != 1')
        ->andwhere('date_buy >="'.$begin.'"AND date_buy <="'. $end.'" AND r.organization ='.Users::getOrg());
        //->andwhere('r.organization ='.Users::getOrg());
        //->groupBy('c.name');
        //var_dump($query);die();
        $command = $query->createCommand();
        $total = $command->queryAll();
        if(!isset($total[0]['total']))
        {
            return "0,00";
        }
        $total = $total[0]['total'];
        //var_dump($total); die();
        //$total = number_format($total, '2', ',', '.'); 
        return $total;
    }

    static public function getTotalByChild($idchild, $month = '')
    {
        
        //$betweendate = Registers::currentDate($month);
        //var_dump($month);
        $betweendate = Registers::currentAdministrativeMonth($month);

        $begin = $betweendate['begin'];
        $end = $betweendate['end'];

        $query = new Query();
        $query->select('r.amount, r.organization,c.id,c.name,sum(r.amount) as total')
        ->from('registers as r')
        ->innerJoin('children as c','r.child = c.id')
        ->where('c.id='.$idchild.' AND r.date_buy >="'.$begin.'"AND r.date_buy <="'. $end.'"')
        ->where('r.organization ='.Users::getOrg());
        //->groupBy('c.name');
        //var_dump($query);die();
        $command = $query->createCommand();
        $total = $command->queryAll();

        if(!isset($total[0]['total']))
        {
            return "0,00";
        }
        return $total[0]['total'];
    }

    static function getRegistersByMonth($month = "")
    {

        //$betweendate = Registers::currentDate($month);
        $betweendate = Registers::currentAdministrativeMonth($month);

        $begin = $betweendate['begin'];
        $end = $betweendate['end'];

        $query = new Query();
        $query->select('*, c.abbreviation,sum(r.amount) as amount')
        ->from('registers as r')
        ->innerJoin('code as c','c.id=r.code')
        ->where('r.date_buy >="'.$begin.'"AND r.date_buy <="'. $end.'"')
        ->andwhere('r.organization ='.Users::getOrg())
        ->andwhere('c.especial != 1')
        ->groupBy('c.abbreviation');
        $command = $query->createCommand();
        return $registers = $command->queryAll();
    }

    //without especial code
    static function getRegistersByMonthWithAllCode($codes, $current = false)
    {

        //$betweendate = Registers::currentDate($month);
        $registers = Registers::getRegistersByMonth($current);
        $coderegisters = '';
        foreach ($registers as $key => $register) {
            $coderegisters[]= $register['abbreviation'] ;
        }
        if(!empty($coderegisters))
        {
            foreach ($codes as $keys => $code) 
            {
                if(!in_array($code['abbreviation'], $coderegisters))
                {
                   $registers[] = array('abbreviation' => $code['abbreviation'], 'amount' => '0,00'); 
                }
            }
        }
        return $registers;
    }

   

}
