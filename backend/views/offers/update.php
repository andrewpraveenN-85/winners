<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Offers $model */

$this->title = 'Update Offers: ' . $model->package_id;
$this->params['breadcrumbs'][] = ['label' => 'Offers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->package_id, 'url' => ['view', 'package_id' => $model->package_id, 'merchant_id' => $model->merchant_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="offers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
