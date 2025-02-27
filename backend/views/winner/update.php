<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Winner $model */

$this->title = 'Update Winner: ' . $model->profile_id;
$this->params['breadcrumbs'][] = ['label' => 'Winners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->profile_id, 'url' => ['view', 'profile_id' => $model->profile_id, 'draws_gifts_id' => $model->draws_gifts_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="winner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
