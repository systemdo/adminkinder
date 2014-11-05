<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Codes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Codes'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name', 
            "abbreviation",
            ['attribute'=>'especial', 'value' => 'especialCode'],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


<p>
<?=
      Html::a(Yii::t('app', 'Clear Consult', [
    'modelClass' => 'Users',
]), [''], ['class' => 'btn btn-primary']) 

?>

</p>

</div>
