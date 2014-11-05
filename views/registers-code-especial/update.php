<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RegistersCodeEspecial */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Registers Code Especial',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registers Code Especials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="registers-code-especial-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'code' => $code,
    ]) ?>

</div>
