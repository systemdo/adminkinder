<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RegistersExtra */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Registers Extra',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registers Extras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registers-extra-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
