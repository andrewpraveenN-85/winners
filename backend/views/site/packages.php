<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \backend\models\RegisterForm $model */
use yii\bootstrap5\Html;

$this->title = "Packages";
?>
<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="row login-container shadow-lg rounded" style="width: 50rem;">
        <!-- Left: Scrollable Form -->
        <div class="col-md-12 bg-white p-4" style="max-height: 100vh; overflow-y: auto; scrollbar-color: #5C4033 #FFD700; scrollbar-width: thin;">
            <h3 class="text-warning fw-bold text-center">Packages</h3>

            <!-- Nav Tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-brown active" id="m1-tab" data-bs-toggle="tab" data-bs-target="#m1" type="button" role="tab" aria-controls="monthly" aria-selected="true">Monthly</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-brown " id="m6-tab" data-bs-toggle="tab" data-bs-target="#m6" type="button" role="tab" aria-controls="6-month" aria-selected="false">6 Month</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-brown " id="m12-tab" data-bs-toggle="tab" data-bs-target="#m12" type="button" role="tab" aria-controls="annually" aria-selected="false">Annually</button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="m1" role="tabpanel" aria-labelledby="m1-tab">
                    <?php if (!empty($m1_packages)): ?>
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <?php foreach ($m1_packages as $package): ?>
                                <div class="col">
                                    <div class="card shadow-sm">
                                        <a href="<?= Html::encode($package->purchase_url) ?>"><img src="<?= Html::encode($package->getImgURL()) ?>" class="card-img-top" alt="<?= Html::encode($package->name) ?>" style="height: 100%; object-fit: cover;"></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted">No packages available.</div>
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade" id="m6" role="tabpanel" aria-labelledby="m6-tab">
                    <?php if (!empty($m6_packages)): ?>
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            <?php foreach ($m6_packages as $package): ?>
                                <div class="col">
                                    <div class="card shadow-sm">
                                        <a href="<?= Html::encode($package->purchase_url) ?>"><img src="<?= Html::encode($package->getImgURL()) ?>" class="card-img-top" alt="<?= Html::encode($package->name) ?>" style="height: 100%; object-fit: cover;"></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted">No packages available.</div>
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade" id="m12" role="tabpanel" aria-labelledby="m12-tab">
                    <?php if (!empty($m12_packages)): ?>
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            <?php foreach ($m12_packages as $package): ?>
                                <div class="col">
                                    <div class="card shadow-sm">
                                        <a href="<?= Html::encode($package->purchase_url) ?>"><img src="<?= Html::encode($package->getImgURL()) ?>" class="card-img-top" alt="<?= Html::encode($package->name) ?>" style="height: 100%; object-fit: cover;"></a>
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

    </div>
</div>
