<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Users;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>

    <div class="wrap">
        <?php

             if(!Yii::$app->user->isGuest)
             {
                    NavBar::begin([
                        'brandLabel' => Html::encode(Yii::t('app', 'Klient/in')),
                        'brandUrl' => Yii::$app->homeUrl,
                        'options' => [
                            'class' => 'navbar-inverse navbar-fixed-top',
                        ],
                    ]);
                    echo Nav::widget([
                        'options' => ['class' => 'navbar-nav navbar-right'],
                        'items' => [
                             ['label' => Html::encode(Yii::t('app', 'Home')), 'url' => ['/registers/registered']],
                             ['label' => Html::encode(Yii::t('app', 'Childrens')), 'url' => ['/children']],
                             
                             ['label' => Html::encode(Yii::t('app', 'Registers')),
                                 'items' => [
                                 ['label' => Html::encode(Yii::t('app', 'Registers')), 'url' => ['/registers']],
                                 '<li class="divider"></li>',
                                 ['label' => Html::encode(Yii::t('app', 'Extra')), 'url' => ['/registers-extra']],
                                 '<li class="divider"></li>',
                                 ['label' => Html::encode(Yii::t('app', 'Code Especial')), 'url' => ['/registers-code-especial']],
                                 '<li class="divider"></li>',
                                 ['label' => Html::encode(Yii::t('app', 'Old Registers')), 'url' => ['registers/old-registers']],
                                 ['label' => Html::encode(Yii::t('app', 'Old Registers Extra')), 'url' => ['registers-extra/old-registers']],
                                 ['label' => Html::encode(Yii::t('app', 'Old Registers Code Especial')), 'url' => ['registers-code-especial/old-registers']],
                                 ],
                            ],

                             Users::isSuperAdmin()?['label' => Html::encode(Yii::t('app', 'Change Organization')), 'url' => ['/login/choose-organization']]:'',
                             Users::isSuperAdmin()?['label' => Html::encode(Yii::t('app', 'Users')), 'url' => ['/users']]:'',
                             Users::isSuperAdmin()?['label' => Html::encode(Yii::t('app', 'Code')), 'url' => ['/code/']]:'',
                             Users::isSuperAdmin()?['label' => Html::encode(Yii::t('app', 'Buli')), 'url' => ['/files']]:'',
                             ['label' => 
                                    'Logout (' . Yii::$app->user->identity->username . ')',
                                    'url' => ['/login/logout'],
                                    'linkOptions' => ['data-method' => 'post']],
                        ],
                    ]);

                    NavBar::end();
               }     
        ?>

        <div class="container">

            <?=

            !Yii::$app->user->isGuest?
                Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]):'';
            ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
