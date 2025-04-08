<?php

use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Breadcrumbs;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Yii2 App',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar navbar-expand-lg navbar-dark bg-dark'],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/site/login']] :
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline'])
                . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout'])
                . Html::endForm()
                . '</li>',
        ],
    ]);

    NavBar::end();
    ?>

    <div class="container mt-4">
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer bg-light text-center p-3">
    <div class="container">
        <p class="text-muted">&copy; <?= date('Y') ?> My Yii2 App. All rights reserved.</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
