<?php
/** @var yii\web\View $this */

/** @var string $content */
use backend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;

AppAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= Html::encode($this->title) ?></title>
        <link rel="icon" type="image/png" href="/media/icon.png"> <!-- Added icon -->
        <?php $this->registerCsrfMetaTags() ?>
        <?php $this->head() ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #d5d5d5; /* Brown theme */
                font-size: 20px; /* Set font size */
            }
            .login-container {
                max-width: 900px;
                margin: auto;
                background: #ffc107; /* Warning color */
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            }
            .login-left {
                padding: 40px;
                background: white;
            }
            .login-right {
                background: #ffb300; /* Darker warning shade */
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 40px;
            }
            .btn-warning {
                background-color: #ff9800;
                border: none;
            }
            .btn-warning:hover {
                background-color: #e68900;
            }
            .nav-tabs .nav-link {
                color: black !important; /* Ensures text is black (Bootstrap default for btn-warning) */
            }
            .nav-tabs .nav-link.active {
                background-color: #ffc107 !important; /* Keeps the warning color */
                color: black !important; /* Keeps text black for the active tab */
                border-color: #ffc107 !important; /* Optional: Keeps border color consistent */
            }
        </style>
    </head>
    <body class="d-flex flex-column h-100">
        <?php $this->beginBody() ?>
        <main role="main">
            <div class="container">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>