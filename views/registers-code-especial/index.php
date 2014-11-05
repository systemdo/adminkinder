<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RegistersCodeEspecialSearchc */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Registers Code Especials');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registers-code-especial-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Registers Code Especial'), ['create'], ['class' => 'btn btn-success'])?>
        <?= Html::a(Yii::t('app', 'Search Advance'), ['search-advance'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'voucher',
            'extract',
            //'date_buy',
            ['attribute'=>'date_buy', 'value' => 'dateBuy'],
            ['attribute'=>'abbreviation', 'value' => 'abbreviation'],
            // 'process:ntext',
            ['attribute'=>'amount', 'value' => 'amountFormat'],
            // 'organization',
            // 'extra',
            // 'create_date',
            // 'update_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
