<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Users;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Registers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registers-form">

    <?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'organization')->dropDownList(ArrayHelper::map(Users::find()->all(), 'id', "username"), ['placeholder'=> 'Choose Organization'])?>

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
        <?= Html::submitButton(Yii::t('app', 'Search '), ['class' =>'btn btn-success', 'name' => 'Search']) ?>
        
</div>
<div class="help-block"></div>
    
    <?php ActiveForm::end(); ?>

</div>
