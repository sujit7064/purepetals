<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <?php $this->beginBody() ?>

    <div class="wrapper">
        <?php
        if (!Yii::$app->user->isGuest) {
        ?>
            <nav id="sidebar" class="sidebar js-sidebar">
                <div class="sidebar-content js-simplebar">
                    <a class="sidebar-brand" href="index">
                        <span class="sidebar-brand-text align-middle">
                            PUREPETAL
                        </span>
                    </a>

                    <ul class="sidebar-nav">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?= Url::toRoute(['site/index']) ?>">
                                <i class="align-middle" data-feather="user"></i> <span class="align-middle">Dashboard</span>
                            </a>
                        </li>

                        </li>
                        <!-- <li class="sidebar-item">
                            <a class="sidebar-link" href="<?= Url::toRoute(['category/index']) ?>">
                                <i class="align-middle" data-feather="user"></i> <span class="align-middle">Category</span>
                            </a>
                        </li> -->
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?= Url::toRoute(['product/index']) ?>">
                                <i class="align-middle" data-feather="user"></i> <span class="align-middle">Product</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?= Url::toRoute(['order-details/index']) ?>">
                                <i class="align-middle" data-feather="user"></i> <span class="align-middle">Order Details</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

        <?php
        }
        ?>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon pe-md-0 dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="align-middle me-1" data-feather="user"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?= Url::toRoute(['site/logout']) ?>" data-method="post">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Feather Icons JavaScript -->
            <script src="https://unpkg.com/feather-icons"></script>
            <script>
                feather.replace();
            </script>

            <!-- Include Bootstrap JavaScript (ensure it's loaded for dropdown functionality) -->
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="#" target="_blank" class="text-muted"><strong>PUREPETALS</strong></a> &copy;
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Help Center</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Terms</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
