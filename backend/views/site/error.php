<?php
/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */

/** @var Exception $exception */
use yii\helpers\Html;

$this->title = $name;
?>
<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="error-container text-center">
        <h1 class="text-warning fw-bold"><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p class="text-white">
            The above error occurred while the Web server was processing your request.
        </p>
        <p class="text-white">
            Please <a href="/" class="text-warning fw-bold">return to the homepage</a>.
        </p>
    </div>
</div>>
