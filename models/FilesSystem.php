<?php

namespace app\models;
use app\api\DateFormat;

use Yii;
use yii\base\Model;
use yii\db\Query;


class FilesSystem extends Model
{
     
     public $begin_date;
     public $end_date;
     /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['begin_date, end_date'], 'requerid'],
            [['begin_date, end_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function getAttributeLabel($e)
    {
        $att = [
            'begin_date' => Yii::t('app', 'Begin Date'),
            'end_date' => Yii::t('app', 'End Date'),
        ];

        return $att[$e];
    }

     function getExcel($b="" , $e="")
     {
        $object= $this->getConsult($b,$e);
        if($object)
            $this->buildExcel($object,$b,$e);
        else
            return false;
     }
    
     /*
        6
        ABCDEF
        A = 6
        B = end number year 
        C = 2
        DE = 2 number's end account 

     */
     private function buildBelegnumber($date)
     {
            $date = explode("-", $date);
            $years = $date[0];
            $years = substr($years,-1);
            $account_user = Users::accountUser();
            $account_user = substr($account_user,-2);
            //var_dump($account_user); die();
            return "6".$years."2".$account_user.$date[1];
     }

     function getTxt($b="" , $e="")
     {
        $object= $this->getConsult($b,$e); 
        //var_dump($object); die();
        //$this->buildTxt($object,$b,$e);
         if($object)
            $this->buildNewTxt($object,$b,$e);
         else
            return false;           
     }  
     
     private function buildTxt($object, $b = '', $e="")
     {
        $space ="    ";
        $content = "Belegnummer". $space;
        $content .= "Buchungsdatum". $space;
        $content .= "Bankkonto". $space;
        $content .= "S Kreditor". $space;
        $content .= "Summe KS". "        ";
        $content .= "Name"."           ";
        $content .= "OP-Nummer". "     ";
        $content .= "Belegdatum". $space;
        $content .= "\n";

        $b = DateFormat::formatDateDe($b); 
        $e = DateFormat::formatDateDe($e); 
        //var_dump($object);
         foreach ($object as $key => $ob)
        {  
            //var_dump($date);die();
            $content .= $this->buildBelegnumber($ob['date_buy'])."         ";
            $content .= $b."       ";
            $content .= Users::accountUser()."      ";
            $content .= 'k'.$ob['account_pay']."       ";
            $content .= number_format($ob['total'],2,',','.')."       ";
            $content .= $ob['name'].' '.$ob['surname']."   ";
            $content .= $this->buildBelegnumber($ob['date_buy'])."     ";
            $content .= $e.$space;
            $content .= "\n";
        }
        //$tpm = "/tpm/buli.txt";

          //$file=fopen($file,"a");
          //fputs($file, $content);             
          //fclose($file);  
            header("Content-type: text/plain");
            //header("Content-type: text/html");
            header("Content-Disposition: attachment; filename=buli.txt");
            echo $content;

     }

     
     private function buildExcel($object, $e="", $b="")
     {

        $objPHPExcel = new \PHPExcel();
        $sheet=0;

  
        $objPHPExcel->setActiveSheetIndex($sheet);
 

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            
        $objPHPExcel->getActiveSheet()->setTitle('Buli Bsp gefüllt')
               
         ->setCellValue('A1', 'Belegnummer')
         ->setCellValue('B1', 'Buchungsdatum')
         ->setCellValue('C1', 'Bankkonto')
         ->setCellValue('D1', 'S Kreditor')
         ->setCellValue('E1', 'Summe KS')
         ->setCellValue('F1', 'Name')
         ->setCellValue('G1', 'OP-Nummer')
         ->setCellValue('H1', 'Belegdatum');
         $row = 2;
         //echo '<pre>';
         //var_dump($object);die();
         foreach ($object as $key => $ob){  
            //var_dump($object);die();
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$this->buildBelegnumber($ob['date_buy']));
                     //$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//ALINEAR A LA DERECHA 
                    
                    //$date = explode(' ', $ob['create_date']);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$b); 
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);//ALINEAR A LA DERECHA 
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,Users::accountUser()); 
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);//ALINEAR A LA DERECHA 
                    if(isset($ob['account_pay']))
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'k'.$ob['account_pay']); 
                    else
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'k'.$ob['process']); 
                        

                    
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$ob['total']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$ob['cliente']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$this->buildBelegnumber($ob['date_buy'])); 
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$e); 
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $row++ ;
            }
           // $objPHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);//ALINEAR A LA DERECHA
            header('Content-Type: application/vnd.ms-excel');
            $filename = "MyExcelReport_".date("d-m-Y-His").".xls";
            header('Content-Disposition: attachment;filename='.$filename .' ');
            header('Cache-Control: max-age=0');
           
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Txt');
           
            $objWriter->save('php://output');       
           
         }

     function getConsult($begin,$end)
     {
        $children = new Registers;
        $codeespecial = RegistersCodeEspecial::find()->with("code")->all();
        /*echo "<pre>";
        foreach($codeespecial as $key => $value) {
        var_dump($value->getCodeName());die(); 
        }*/
        
        $query = new Query();
        $query->select('*,sum(r.amount) as total')
        ->from('registers as r')
        ->innerJoin('children as c','r.child=c.id')
        ->where('r.date_buy >="'.$begin.'"AND r.date_buy <="'. $end.'"')
        ->groupBy('r.child');
        //echo "<pre>";
        //var_dump($query);
        //$registers = $query->all();
        $command = $query->createCommand();
        $registers = $command->queryAll();
        $allregisters = false;
        foreach($registers as $key => $register) {
            $register['cliente'] =  $register['name'].' '.$register['surname'];
            $allregisters [] = $register;
        }
         $query = new Query();
        $query->select('*,sum(r.amount) as total')
        ->from('registers_code_especial as r')
        ->innerJoin('code as c','r.code=c.id')
        ->where('r.date_buy >="'.$begin.'"AND r.date_buy <="'. $end.'"')
        ->andwhere('r.organization ='.Users::getOrg())
        ->groupBy('r.code');
        
        $command = $query->createCommand();
        $codes = $command->queryAll();
        foreach($codes as $key => $code) {
            $code['cliente'] =  $code['name'];
            $allregisters [] = $code;
        }
        if(empty($allregisters))
        {
            return $allregisters;  
        }
       //echo "<pre>";
       //var_dump($allregisters);die();
        return $allregisters;
        
     }
     private function calcSpace($string)
     {
        //echo strlen($string);
        $restWith = 17-strlen($string);  
        //var_dump($restWith);
        return $with = str_repeat(chr(8), $restWith);

     } 
     private function calcSpaceCellName($string)
     {
        //echo strlen($string);
        $restWith = 22-strlen($string);  
        //var_dump($restWith);
        return $with = str_repeat(chr(8), $restWith);

     } 

      private function buildNewTxt($object, $b = '', $e="")
     {
          // var_dump(chr(8));die();
        $A = 'Belegnummer';
        $B = 'Buchungsdatum';
        $C = 'Bankkonto';
        $D = 'S Kreditor';
        $E = 'Summe KS';
        $F = 'Name';
        $G = 'OP-Nummer';
        $H = 'Belegdatum';
         
           $esp = "\t";
           $spacename = str_repeat(" ", 6);
           $txt = fopen('buli.txt','w+' ) or die("Problemas"); 

            fwrite($txt,$A.$this->calcSpace($A));
            fwrite($txt,$B.$this->calcSpace($B));
            fwrite($txt,$C.$this->calcSpace($C));
            fwrite($txt,$D.$this->calcSpace($D));
            fwrite($txt,$E.$this->calcSpace($E));
            fwrite($txt,$F.$this->calcSpaceCellName($F));
            fwrite($txt,$G.$this->calcSpace($G));
            fwrite($txt,$H.$this->calcSpace($H));
            fwrite($txt,"\n\r");
        //die();
        $b = DateFormat::formatDateDe($b); 
        $e = DateFormat::formatDateDe($e); 
        //var_dump($object);
         foreach ($object as $key => $ob)
        {  
            //var_dump($date);die();
            fwrite($txt,$this->buildBelegnumber($ob['date_buy']).$this->calcSpace($this->buildBelegnumber($ob['date_buy'])));
            fwrite($txt,$b.$this->calcSpace($b));
            fwrite($txt,Users::accountUser().$this->calcSpace(Users::accountUser()));
            
            if(isset($ob['account_pay']))
            fwrite($txt,'k'.$ob['account_pay'].$this->calcSpace('k'.$ob['account_pay']));
            else
                fwrite($txt,'k'.$ob['process'].$this->calcSpace('k'.$ob['process']));

            fwrite($txt,number_format($ob['total'],2,',','.').$this->calcSpace($ob['total']));
            fwrite($txt,$ob['cliente'].$this->calcSpaceCellName($ob['cliente']));
            fwrite($txt,$this->buildBelegnumber($ob['date_buy']).$this->calcSpace($this->buildBelegnumber($ob['date_buy'])));
            fwrite($txt,$e.$this->calcSpace($e));
            fwrite($txt,"\n\r");
        }
        //die();
        fclose($txt);  
        //$tpm = "/tpm/buli.txt";
         
          //$file=fopen($file,"a");
          //fputs($file, $content);             
         
            header('Content-disposition: attachment; filename=buli.txt');
            header('Content-type: text/plain');
            readfile('buli.txt');
            exit();


     }
}
