<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Registers */

$this->title = Yii::t('app', 'Search', [
    'modelClass' => 'Registers',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'noresult' => $noresult,
    ]) ?>

</div>
