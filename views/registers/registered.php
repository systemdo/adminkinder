<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Registers;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RegistersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Registers');
?>
<style>

.grid-view table.items tbody > tr> td
{
        background: #BCE774;  //pon el color que quieras para la fila que este seleccionada
}

.grid-view table.items tbody tr:hover
{
        background: #ECFBD4;//pon el color que quieras para la fila cuando pases el cursor por encima.
        cursor:pointer;     //para que salga que el cursor muestre una mano en lugar de la flecha al pasar sobre una fila
}
</style>
<div class="grid-view">

    <p>
        <?= Html::a(Yii::t('app', 'Create Registers'), ['create'], ['class' => 'btn btn-success']) 
    
    ?>
    </p>
            <pre>
                <h3><?= Html::encode(Yii::t('app', 'Result')) ?>:<?php echo $result_total;?></h3>
            </pre>
            <p>
                <b><?= Html::encode(Yii::t('app', 'Last Month')) ?></b>
            </p>

    <table class="table table-striped table-bordered">
    <thead>
        
        <tr>
  
        <?php 
        if(!empty($lastregisters))
        {
        foreach ($codes as $key => $code) { 
        ?> 
               <th><?php echo $code['abbreviation']?></th>
            
        <?php
        }
        } 
        ?>
        <th><?= Html::encode(Yii::t('app', 'Amount')) ?></th>
        </tr>
        <tr>
       </thead> 
       <tbody>
       
        <?php
            //var_dump($lastregisters);
            foreach ($lastregisters as $key => $register) { 
                //var_dump($register);
                //echo '->'.number_format((float)$register['amount'], 2, ',', '.');
            ?>
    
                    
               <td><?php echo number_format((float)$register['amount'], 2, ',', '.')?></td>
       <?php 
        }
        ?>
         <td><?php echo $lasttotal?$lasttotal :"00,00"?></td>  
        </tr>
    
        
    </tbody>
    </table>
</div>
   <!-- children last month-->
    <div class="grid-view">
    <p>
    <b><?= Html::encode(Yii::t('app', 'Children Last Month')) ?></b>
    </p>


<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th><?= Html::encode(Yii::t('app', 'Name')) ?></th>
            <?php 

                foreach ($codes as $key => $code) { 
            ?>
                
                   <th><?php echo $code['abbreviation'];?></th>
                
            <?php
            } 
            ?>
               <th><?= Html::encode(Yii::t('app', 'Amount')) ?></th>
                
            </tr>
     </thead>
     <tbody>       
        <?php
        foreach ($childrenlastmonth as $key => $child) {                
        ?>
        <tr> 
            <td><?php echo $child['surname'].', '.$key?></td>
       <?php 
            foreach ($codes as $k => $code) {
                //var_dump($code['abbreviation']);die();
        ?>       
            <td><?php echo isset($child[$code['abbreviation']])? number_format((float)$child[$code['abbreviation']],2, ',','.'): "0,00"; ?></td>
        <?php   
         }
        ?>  
            <td><?php echo number_format((float)Registers::getTotalByChild($child['id'], 'last'),2, ',','.')?></td>
        </tr>    
        
        <?php
        }
        ?>    
        </tbody>
    </table>
</div>
<!-- last code especial-->
  <div class="grid-view">
    <p>
    <b><?= Html::encode(Yii::t('app', 'Last Code Especial')) ?></b>
    </p>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th><?= Html::encode(Yii::t('app', 'Code Especial')) ?></th>
            <th colspan="2"><?= Html::encode(Yii::t('app', 'Amount')) ?></th>
            
     </thead>
     <tbody>
    
        <?php
            
            //var_dump($rcelast);
        foreach ($rcelast as $key => $last) {                
        ?>
        <tr> 
            <td><?php echo $last['abbreviation']?></td>
            <td><?php echo number_format((float)$last['amount'],2, ',','.');?></td>
        <?php   
         }
        ?>  
        </tr>    
        
        </tbody>
    </table>
</div>

<!-- children real month-->
<div class="grid-view">
    <p>
        <b><?= Html::encode(Yii::t('app', 'Children')) ?></b>
    </p>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?= Html::encode(Yii::t('app', 'Name')) ?></th>
                <?php 

                    foreach ($codes as $key => $code) { 
                        //foreach ($child as $key => $code) {
                ?>
                    
                       <th><?php //var_dump($child);
                       echo $code['abbreviation'];?></th>
                    
                <?php
                } //}
                ?>
                   <th><?= Html::encode(Yii::t('app', 'Amount'))?></th>
                    
                </tr>
         </thead>
         <tbody>       
            <?php
            foreach ($children as $key => $child) {                
            ?>
            
            <tr> 
                <td><?php echo $child['surname'].', '.$key?></td>
           
           <?php 
                foreach ($codes as $k => $code) 
                {
                   // var_dump($code['abbreviation']);
            ?>       
                    <td><?php echo isset($child[$code['abbreviation']])?number_format((float)$child[$code['abbreviation']],2, ',','.') : "0,00"; ?></td>
            <?php   
                }
            ?>  

                <td><?php echo number_format((float)Registers::getTotalByChild($child['id']),2, ',','.')?></td>
             </tr>    
            
            <?php
            }
            ?>    
        </tbody>
    </table>
</div>
<!-- last code especial-->
  <div class="grid-view">
    <p>
    <b><?= Html::encode(Yii::t('app', 'Actual Code Especial')) ?></b>
    </p>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th colspan="2"><?= Html::encode(Yii::t('app', 'Code Especial')) ?></th>
            
     </thead>
     <tbody>
    
        <?php
            
            //var_dump($rcelast);
        foreach ($rce as $key => $actual) {                
        ?>
        <tr> 
            <td><?php echo $actual['abbreviation']?></td>
            <td><?php echo number_format((float)$actual['amount'],2, ',','.')?></td>
        <?php   
         }
        ?>  
        </tr>    
        
        </tbody>
    </table>
</div>

<div class="grid-view">
    <p>
    <b><?= Html::encode(Yii::t('app', 'Current Month')) ?></b>
    </p>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
    <?php 
        foreach ($registers as $key => $register) { 
    ?>
        
           <th><?php echo $register['abbreviation']?></th>
        
    <?php
    } 
    ?>
       <th><?= Html::encode(Yii::t('app', 'Amount')) ?></th>
        
    </tr>
    <tr>
    <?php

        //var_dump($registers);die();
        foreach ($registers as $key => $register) { 
    ?>
        
            
          <td><?php echo number_format((float)$register['amount'], 2, ',', '.')?></td>
       
   <?php 
    }
    ?>
     <td><?php echo $total?$total :"00,00"?></td>  
       </tr>
    
    </thead>
    <tbody>
        
    </tbody>
    </table>
</div>


    