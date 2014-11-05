<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RegistersCodeEspecial */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Registers Code Especial',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registers Code Especials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registers-code-especial-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'code' => $code,
    ]) ?>

</div>
