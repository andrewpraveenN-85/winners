<?php

/** @var \yii\web\View $this */

/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<!--<body class="d-flex flex-column h-100">-->

<body>
    <?php $this->beginBody() ?>
    <div class="d-flex" id="wrapper">
        <nav id="sidebar" class="bg-light border-end collapse show shadow-lg">
            <div class="p-3">
                <div class="text-center">
                    <img src="<?= Yii::getAlias('@web') ?>/main_logo.jpeg" alt="Reward MIS" style="max-height: 100px;">
                    <h4>Reward MIS</h4>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="fa fa-dashboard fa-fw fa-sm" role="button"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/members">
                            <i class="fa fa-user-secret fa-fw fa-sm"></i>Members
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/memberships">
                            <i class="fa fa-chain fa-fw fa-sm"></i>Memberships
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/draws">
                            <i class="fa fa-gamepad fa-fw fa-sm" role="button"></i>Draws
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/events">
                            <i class="fa fa-calendar fa-fw fa-sm" role="button"></i>Events
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#submenu3" role="button" aria-expanded="false" aria-controls="submenu4">
                            <i class="fa fa-building fa-fw fa-sm"></i>Business<i class="fa fa-angle-down dropdown-arrow"></i>
                        </a>
                        <div class="collapse" id="submenu3">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="/business/merchants">
                                        <i class="fa fa-building fa-fw fa-sm"></i>Merchants
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/business/packages">
                                        <i class="fa fa-bullhorn fa-fw fa-sm" role="button"></i>Packages
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#submenu4" role="button" aria-expanded="false" aria-controls="submenu6">
                            <i class="fa fa-cogs fa-fw fa-sm"></i>Settings<i class="fa fa-angle-down dropdown-arrow"></i>
                        </a>
                        <div class="collapse" id="submenu4">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="/settings/profile">
                                        <i class="fa fa-user fa-fw fa-sm"></i>Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="/settings/admins">
                                        <i class="fa fa-user-secret fa-fw fa-sm"></i>Admins
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <?=
                        Html::a('<i class="fa fa-lock fa-fw fa-sm"></i>Logout', ['/site/logout'], [
                            'class' => 'nav-link',
                            'data' => [
                                'method' => 'post',
                            ],
                        ])
                        ?>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div id="main-content" class="flex-grow-1 p-3">
            <!-- Toggle button for larger screens -->
            <button class="btn btn-primary mb-3 d-none d-md-block" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="true" aria-label="Toggle sidebar">
                <i class="fa fa-bars fa-fw fa-sm"></i>
            </button>
            <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])
            ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const wrapper = document.getElementById('wrapper');

        // Ensure the event listener only triggers for the sidebar collapse
        sidebar.addEventListener('hidden.bs.collapse', (event) => {
            if (event.target === sidebar) { // Check if the event is triggered by the sidebar
                wrapper.classList.add('collapsed');
            }
        });

        sidebar.addEventListener('shown.bs.collapse', (event) => {
            if (event.target === sidebar) { // Check if the event is triggered by the sidebar
                wrapper.classList.remove('collapsed');
            }
        });
    </script>
    <?php $this->endBody() ?>
</body>

</html>
<?php
$this->endPage();
