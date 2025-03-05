<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Activity $model */

$this->title = 'Update Activity: ' . $model->profile_id;
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->profile_id, 'url' => ['view', 'profile_id' => $model->profile_id, 'event_id' => $model->event_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
