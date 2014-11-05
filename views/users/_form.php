<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">
<p>
    <?=
                Html::a(Yii::t('app', 'Go to List Users'), ['/users'], ['class' => 'btn btn-success']) 


        ?>
</p>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'account')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 200]) ?>
    

    <?= $form->field($model, 'role')->dropDownList(ArrayHelper::map(app\models\Roles::find()->all(), 'id', "rule"), ['placeholder'=> 'Choose Role']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= !$model->isNewRecord ? Html::submitButton(Yii::t('app', 'Change Password'), ['class' =>'btn btn-success', 'name' => 'change']): '' ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
