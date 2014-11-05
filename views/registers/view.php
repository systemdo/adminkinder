<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Registers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) 
        ?>
        <?=
                Html::a(Yii::t('app', 'Go to List Registers'), ['/registers'], ['class' => 'btn btn-success']) 


        ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'voucher',
            'extract',
            [                    // the owner name of the model
            'label' => $model->getAttributeLabel('date_buy'),
            'value' => $model->getFormatDateRegister(),
            ],
            //'code',
            [                    // the owner name of the model
            'label' => $model->getAttributeLabel('code'),
            'value' => $model->getAbbreviation(),
            ],
            'process',
            [                    // the owner name of the model
            'label' => $model->getAttributeLabel('amount'),
            'value' => $model->getAmountFormat(),
            ],
            [                    // the owner name of the model
            'label' => $model->getAttributeLabel('child'),
            'value' => $model->getChildName().' '. $model->getChildSurname(),
            ],
            //'create_date',
            //'update_date',
        ],
    ]) ?>

</div>
