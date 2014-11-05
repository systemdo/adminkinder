<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegistersExtraSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registers-extra-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'voucher') ?>

    <?= $form->field($model, 'extract') ?>

    <?= $form->field($model, 'date_buy') ?>

    <?= $form->field($model, 'process') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'organization') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'update_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
