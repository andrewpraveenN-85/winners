<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Memberships $model */

$this->title = 'Update Memberships: ' . $model->profile_id;
$this->params['breadcrumbs'][] = ['label' => 'Memberships', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->profile_id, 'url' => ['view', 'profile_id' => $model->profile_id, 'package_id' => $model->package_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="memberships-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
