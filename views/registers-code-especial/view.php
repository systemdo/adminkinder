<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RegistersCodeEspecial */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registers Code Especials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registers-code-especial-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update Registers Code Especial'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?=
                Html::a(Yii::t('app', 'Go to List Registers Code Especial'), ['/registers-code-especial'], ['class' => 'btn btn-success']) 


        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'extract',
            [                    // the owner name of the model
            'label' => $model->getAttributeLabel('date_buy'),
            'value' => $model->getDateBuy(),
            ],
            [                    // the owner name of the model
            'label' => $model->getAttributeLabel('code'),
            'value' => $model->getAbbreviation(),
            ],
            'process:ntext',
            'amount',
        ],
    ]) ?>

</div>
