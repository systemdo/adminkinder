<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\api\DateFormat;


/* @var $this yii\web\View */
/* @var $searchModel app\models\RegistersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Registers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registers-index">

    <h1><?= Html::encode($this->title) ?></h1>
   

    <p>
        <?= Html::a(Yii::t('app', 'Create Registers'), ['create'], ['class' => 'btn btn-success']) ?>
         <?= Html::a(Yii::t('app', 'Search Advance'), ['search-advance'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'extract',
            ['attribute'=>'date_buy', 'value' => 'formatDateRegister'],
            ['attribute'=>'childName', 'value' => 'childName'],
            ['attribute'=>'childSurname', 'value' => 'childSurname'],
            'process',
            ['attribute'=>'abbreviation', 'value' => 'abbreviation'],
            //'voucher',
            ['attribute'=>'amount', 'value' => 'amountFormat'],
            // 'create_date',
            // 'update_date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<p>
<?=
      Html::a(Yii::t('app', 'Clear Consult'), [''], ['class' => 'btn btn-primary']) 

?>

</p>