<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Code */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="code-form">
		<?=
                Html::a(Yii::t('app', 'Go to List Code'), ['/code'], ['class' => 'btn btn-success']) 


        ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 45]) ?>
    <?= $form->field($model, 'abbreviation')->textInput(['maxlength' => 45]) ?>
    <?php if($model->isNewRecord){?>
    <?= $form->field($model, 'especial')->dropDownList(array('Nein', 'Ja'), ['placeholder'=> 'Choose Code'])?>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
