<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id, 'role' => $model->role], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id, 'role' => $model->role], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?=
                Html::a(Yii::t('app', 'Go to List Users'), ['/users'], ['class' => 'btn btn-success']) 


        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            //'surname',
            'username',
            'account',
            isset($pass)?['label' =>$model->getAttributeLabel('password'), 'value'=> $pass]:['label' =>'', 'value'=> ''],
            //['label' =>$model->getAttributeLabel('password'), 'value'=> $pass],
            //'update_date',
            //'create_date',
            ['label' =>$model->getAttributeLabel('role'), 'value'=> $model->getRole()],
        ],
    ]) ?>

</div>
