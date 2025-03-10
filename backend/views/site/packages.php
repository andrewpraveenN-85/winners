<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \backend\models\RegisterForm $model */
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Packages";
?>
<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="row login-container shadow-lg rounded" style="width: 50rem;">
        <!-- Left: Scrollable Form -->
        <div class="col-md-12 bg-white p-4" style="max-height: 80vh; overflow-y: auto; scrollbar-color: #5C4033 #FFD700; scrollbar-width: thin;">
            <h3 class="text-warning fw-bold text-center">Packages</h3>
            <?php if (!empty($packages)): ?>
                <div class="card-group">
                    <?php foreach ($packages as $package): ?>
                        <div class="card shadow-sm">
                            <img src="<?= Html::encode($package->getImgURL()) ?>" class="card-img-top" alt="<?= Html::encode($package->name) ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= Html::encode($package->name) ?></h5>
                                <p class="card-text"><strong>Duration:</strong> <?= Html::encode($package->duration) ?></p>
                                <p class="card-text"><strong>Entries:</strong> <?= Html::encode($package->entry_point) ?></p>
                                <p class="card-text"><strong>Events:</strong> <?= Html::encode($package->getEventText()) ?></p>
                                <p class="card-text"><strong>Discount:</strong> <?= Html::encode($package->merchants_discount) ?>%</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Last updated <?= date('d M Y', $package->updated_at) ?></small>
                                <a href="<?= Html::encode($package->purchase_url) ?>" class="btn btn-primary btn-sm float-end" target="_blank">Purchase</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center text-muted">No packages available.</div>
            <?php endif; ?>
        </div>

    </div>
</div>
