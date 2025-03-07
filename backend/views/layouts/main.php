<?php
/** @var \yii\web\View $this */

/** @var string $content */
use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use backend\models\User;
use backend\models\Profiles;
use backend\models\Merchants;

$userRole = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));
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
        <style>
            /* Ensure the sidebar takes full height */
            #sidebar {
                min-height: 100vh;
                width: 250px; /* Default width */
                transition: width 0.3s ease, margin-left 0.3s ease; /* Smooth transition for width */
            }

            /* Adjust main content */
            #main-content {
                /*margin-left: 250px;  Default margin to accommodate sidebar */
                transition: margin-left 0.3s ease; /* Smooth transition for content shift */
            }

            /* When sidebar is collapsed */
            .collapsed #sidebar {
                width: 0; /* Smoothly collapse the sidebar */
            }

            /* Adjust main content when sidebar is collapsed */
            .collapsed #main-content {
                margin-left: 0; /* Main content shifts smoothly */
            }

            @media (max-width: 768px) {
                /* On smaller screens, main content spans full width when sidebar is hidden */
                #main-content {
                    margin-left: 0;
                }
            }
            .nav-link i {
                margin-right: 8px; /* Adjust spacing as needed */
                width: 16px !important;
            }
            /* Align the dropdown arrow to the right */
            .dropdown-arrow {
                margin-left: auto; /* Pushes the arrow to the far right */
            }

            .nav-link {
                display: flex; /* Ensure proper alignment of elements */
                align-items: center; /* Vertically center icon and text */
            }

            .hint-block {
                display: block;
                margin-top: 5px;
                color: #999;
            }

            .error-summary {
                color: #a94442;
                background: #fdf7f7;
                border-left: 3px solid #eed3d7;
                padding: 10px 20px;
                margin: 0 0 15px 0;
            }

            .has-error > .help-block {
                color:red;
            }

            .has-success > input, .has-success > select {
                border: 0.5px #28a745 solid;
            }
            .navbar-nav .nav-link {
                color: brown !important;
            }

            .navbar-nav .nav-link:hover {
                color: #8B4513 !important; /* Darker brown on hover */
            }
            .navbar-nav .nav-link {
                color: brown !important; /* Change default link color */
            }

            .navbar-nav .nav-link:hover,
            .navbar-nav .nav-link:focus {
                color: #8B4513 !important; /* Darker brown on hover */
            }
            a {
                color: #8B4513 !important;
                text-decoration: underline;
            }
            .img-circle {
                width: 75px;
                height: 75px;
                border-radius: 50%; /* Ensures circular shape */
                object-fit: cover; /* Prevents distortion */
            }

        </style>
    </head>
    <!--<body class="d-flex flex-column h-100">-->
    <body>
        <?php $this->beginBody() ?>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <nav id="sidebar" class="bg-warning border-end collapse show">
                <div class="p-3">
                    <?php if ($userRole === 'Merchant') { ?>

                    <?php } ?>
                    <?php
                    if ($userRole === 'Profile') {
                        $profile = Profiles::find()->where(['user_id' => Yii::$app->user->id])->one();
                        ?>
                        <div class="text-center">
                            <img src="<?= $profile->imgURL; ?>" class="img-circle" alt="Profile Image" width="75">
                            <h5 class="mt-2">
                                <?= isset($profile) ? Html::encode($profile->first_name . ' ' . $profile->last_name) : 'Guest' ?>
                            </h5>
                        </div>
                    <?php } ?>
                    <?php if ($userRole === 'Admin') { ?>

                    <?php } ?>
                    <ul class="nav flex-column">
                        <?php if (Yii::$app->user->can('dashboard')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-brown" href="/">
                                    <i class="fa fa-dashboard fa-fw fa-sm" role="button" ></i>Dashboard
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (Yii::$app->user->can('memeberManagement')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-brown" aria-current="page" href="/members">
                                    <i class="fa fa-user-secret fa-fw fa-sm"></i>Members
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->can('membershipManagement')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-brown" aria-current="page" href="/memberships">
                                    <i class="fa fa-chain fa-fw fa-sm"></i>Memberships
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->can('myMembership')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-brown" aria-current="page" href="/my-memberships">
                                    <i class="fa fa-chain fa-fw fa-sm"></i>My Memberships
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->can('drawsManagement')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-brown" href="/draws">
                                    <i class="fa fa-gamepad fa-fw fa-sm" role="button" ></i>Draws
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->can('myDraws')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-brown" href="/my-draws">
                                    <i class="fa fa-gamepad fa-fw fa-sm" role="button" ></i>My Draws
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->can('eventManagement')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-brown" href="/events">
                                    <i class="fa fa-calendar fa-fw fa-sm" role="button" ></i>Events
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->can('myEvents')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-brown" href="/my-events">
                                    <i class="fa fa-calendar fa-fw fa-sm" role="button" ></i>My Events
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->can('myMembershipCard')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-brown" href="/my-membership/card">
                                    <i class="fa fa-calendar fa-fw fa-sm" role="button" ></i>Membership Card
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->can('merchantsManagement') || Yii::$app->user->can('packageManagement')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-brown" data-bs-toggle="collapse" href="#submenu3" role="button" aria-expanded="false" aria-controls="submenu4">
                                    <i class="fa fa-building fa-fw fa-sm"></i>Business<i class="fa fa-angle-down dropdown-arrow"></i>
                                </a>
                                <div class="collapse" id="submenu3">
                                    <ul class="nav flex-column ms-3">
                                        <?php if (Yii::$app->user->can('merchantsManagement')): ?>
                                            <li class="nav-item text-brown">
                                                <a class="nav-link" aria-current="page" href="/business/merchants">
                                                    <i class="fa fa-building fa-fw fa-sm"></i>Merchants
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (Yii::$app->user->can('packageManagement')): ?>
                                            <li class="nav-item">
                                                <a class="nav-link text-brown" href="/business/packages">
                                                    <i class="fa fa-bullhorn fa-fw fa-sm" role="button" ></i>Packages
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link text-brown" data-bs-toggle="collapse" href="#submenu4" role="button" aria-expanded="false" aria-controls="submenu6">
                                <i class="fa fa-cogs fa-fw fa-sm"></i>Settings<i class="fa fa-angle-down dropdown-arrow"></i>
                            </a>
                            <div class="collapse" id="submenu4">
                                <ul class="nav flex-column ms-3">
                                    <?php if (Yii::$app->user->can('profileManagement')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link text-brown" href="/settings/profile">
                                                <i class="fa fa-user fa-fw fa-sm"></i>Profile
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (Yii::$app->user->can('adminManagement')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link text-brown" aria-current="page" href="/settings/admins">
                                                <i class="fa fa-user-secret fa-fw fa-sm"></i>Admins
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <?=
                            Html::a('<i class="fa fa-lock fa-fw fa-sm"></i>Logout', ['/site/logout'], [
                                'class' => 'nav-link text-brown',
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
                <button class="btn btn-warning mb-3 d-none d-md-block" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="true" aria-label="Toggle sidebar">
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
