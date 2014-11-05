<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Registers */

$this->title = Yii::t('app', 'Update Registers') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="registers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'code' => $code,
        'children' => $children,
    ]) ?>

</div>
