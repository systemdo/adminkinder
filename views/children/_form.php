<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $model app\models\Children */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="children-form">
<?=
                Html::a('Kinder Übersicht', ['/children'], ['class' => 'btn btn-success']) 


        ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => 45]) ?>

    <?php if(Users::isSuperAdmin()){ ?>    
    <?= $form->field($model, 'account_pay')->textInput() ?>
    <?php 
        }
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
