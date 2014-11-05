<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Registers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registers-form">

    <?php $form = ActiveForm::begin(); ?>


<div class="form-group field-registers-begin_date required">
<label class="control-label"><?php echo $model->getAttributeLabel('begin_date')?></label>;
<?=
 \yii\jui\DatePicker::widget([
    'model' => $model,
    'attribute' => 'begin_date',
    'language' => 'de',
    'value' => date('yy-mm-dd'),
    'options' => ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('begin_date'), 'label' => $model->getAttributeLabel('begin_date')],
    'clientOptions' => [
        'dateFormat' => 'yy-mm-dd',
    ],
]) 
?>
</div>
<div class="help-block"></div>

<div class="form-group field-registers-begin_date required">
<label class="control-label"><?php echo $model->getAttributeLabel('end_date')?></label>;
<?=
 \yii\jui\DatePicker::widget([
    'model' => $model,
    'attribute' => 'end_date',
    'language' => 'de',
    'value' => date('yy-mm-dd'),
    'options' => ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('end_date'), 'label' => $model->getAttributeLabel('end_date')],
    'clientOptions' => [
        'dateFormat' => 'yy-mm-dd',
    ],
]) 
?>
</div>
<div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Excel'), ['class' =>'btn btn-success', 'name' => 'excel']) ?>
        <?= Html::submitButton(Yii::t('app', 'Txt'), ['class' =>'btn btn-primary', 'name' => "txt" ]) ?>
        
</div>
<div class="help-block"></div>
    
    <?php ActiveForm::end(); ?>

</div>
