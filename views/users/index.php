<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Users'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            //'surname',
            'username',
            'account',
            // 'password',
            // 'update_date',
            // 'create_date',
            // 'role',

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
