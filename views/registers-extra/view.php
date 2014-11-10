<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\RegistersExtra */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registers Extras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registers-extra-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       <?= Html::a(Yii::t('app', 'Create Registers'), ['registers/create', 'extra' => $model->id], ['class' => 'btn btn-success']) ?>
       
       <?= Html::a(Yii::t('app', 'Create Registers Code Especial'), ['registers-code-especial/create', 'extra' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'extract',
            'date_buy',
            'process:ntext',
            'amount',
        ],
    ]) ?>
    
<table class="table table-striped table-bordered">
<thead>
<tr>
<th><?php echo $re->attributeLabels()['extract']?></th>
<th><?php echo $re->attributeLabels()['date_buy']?></th>
<!--<th><?php //echo $re->attributeLabels()['code']?></th>-->
<th><?php echo $re->attributeLabels()['process']?></th>
<th><?php echo $re->attributeLabels()['amount']?></th>
<th></th>
</tr>
</thead>
<tbody>
<pre>
<?php 

///var_dump($registers);
    foreach ($registers as $key => $register) {
?>

<tr data-key="<?php echo $register['id']?>">
    
    <td><?php echo $register['extract']?></td>
    <td><?php echo $register['date_buy']?></td>
    <!--<td><?php //echo $register['code']?></td>-->
    <td><?php echo $register['process']?></td>
    <td><?php echo $register['amount']?></td>
    <td>
        <a href="/registers/view?id=<?php echo $register['id']?>?extra=<?php echo $model->id?>" title="Anzeigen" data-pjax="0">
            <span class="glyphicon glyphicon-eye-open"></span>
        </a> 
        <a href="/registers/update?id=<?php echo $register['id']?>&extra=<?php echo $model->id?>" title="Bearbeiten" data-pjax="0">
            <span class="glyphicon glyphicon-pencil"></span>
        </a> 
        <a href="/registers/delete?id=<?php echo $register['id']?>&extra=<?php echo $model->id?>" title="Löschen" data-confirm="Wollen Sie diesen Eintrag wirklich löschen?" data-method="post" data-pjax="0">
        <span class="glyphicon glyphicon-trash"></span>
        </a>
        </td>
<tr>
<?php 
} 
?>
<tr><td colspan="5"><h3><?php echo Yii::t('app', 'With Especial Code')?></h3></td></tr>

<?php 

//var_dump($registercs);die();
    foreach ($registercs as $key => $register) {
?>

<tr data-key="<?php echo $register['id']?>">
    
    <td><?php echo $register['extract']?></td>
    <td><?php echo $register['date_buy']?></td>
    <!--<td><?php //echo $register['code']?></td>-->
    <td><?php echo $register['process']?></td>
    <td><?php echo $register['amount']?></td>
    <td>
        <a href="/registers/view?id=<?php echo $register['id']?>?extra=<?php echo $model->id?>" title="Anzeigen" data-pjax="0">
            <span class="glyphicon glyphicon-eye-open"></span>
        </a> 
        <a href="/registers/update?id=<?php echo $register['id']?>&extra=<?php echo $model->id?>" title="Bearbeiten" data-pjax="0">
            <span class="glyphicon glyphicon-pencil"></span>
        </a> 
        <a href="/registers/delete?id=<?php echo $register['id']?>&extra=<?php echo $model->id?>" title="Löschen" data-confirm="Wollen Sie diesen Eintrag wirklich löschen?" data-method="post" data-pjax="0">
        <span class="glyphicon glyphicon-trash"></span>
        </a>
        </td>
<tr>
<?php 
} 
?>
</tbody>
</table>
</div>
