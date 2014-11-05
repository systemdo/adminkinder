<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\money\MaskMoney;
/* @var $this yii\web\View */
/* @var $model app\models\RegistersCodeEspecial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registers-code-especial-form">

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'extract')->textInput() ?>

    <div class="form-group field-registers-date_buy required">
    <label class="control-label"><?php echo $model->getAttributeLabel('date_buy')?></label>;
<?=
 \yii\jui\DatePicker::widget([
    'model' => $model,
    'attribute' => 'date_buy',
    'language' => 'de',
    'value' => date('dd-mm-yy'),
    'options' => ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('date_buy'), 'label' => $model->attributeLabels()['date_buy']],
    'clientOptions' => [
        'dateFormat' => 'dd-mm-yy',
    ],
]) 
?>
</div>
<div class="help-block"></div>

    <?= $form->field($model, 'code')->dropDownList(ArrayHelper::map($code::find()->where('code.especial=1')->all(), 'id', "abbreviation"), ['placeholder'=> 'Choose Code'])?>

    <?= $form->field($model, 'process')->textarea() ?>


<?= $form->field($model, 'amount')->widget(MaskMoney::classname(), [
    'pluginOptions' => [
        'prefix' => '€ ' ,
        'suffix' => '',
        'decimal'=> ',',
        'thousands' => '.',
        'allowNegative' => true
    ]
]); ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
