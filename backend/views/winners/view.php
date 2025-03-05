<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Winners $model */

$this->title = $model->profile_id;
$this->params['breadcrumbs'][] = ['label' => 'Winners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="winners-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'profile_id' => $model->profile_id, 'gift_id' => $model->gift_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'profile_id' => $model->profile_id, 'gift_id' => $model->gift_id], [
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
            'gift_id',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
