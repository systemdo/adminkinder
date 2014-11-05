<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Children */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'children'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="children-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?=
                Html::a(Yii::t('app', 'Go to List Children'), ['/children'], ['class' => 'btn btn-success']) 


        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'surname',
            //'organization',
            'account_pay',
            //'create_date',
            //'update_date',
        ],
    ]) ?>

</div>
