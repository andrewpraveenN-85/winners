<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Activity $model */

$this->title = $model->profile_id;
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="activity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'profile_id' => $model->profile_id, 'event_id' => $model->event_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'profile_id' => $model->profile_id, 'event_id' => $model->event_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'profile_id',
            'event_id',
            'check_in',
            'check_out',
            'notes:ntext',
        ],
    ]) ?>

</div>
