<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\DrawsGiftsRewards $model */

$this->title = $model->draws_gift_id;
$this->params['breadcrumbs'][] = ['label' => 'Draws Gifts Rewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="draws-gifts-rewards-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'draws_gift_id' => $model->draws_gift_id, 'rewards_id' => $model->rewards_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'draws_gift_id' => $model->draws_gift_id, 'rewards_id' => $model->rewards_id], [
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
            'draws_gift_id',
            'rewards_id',
        ],
    ]) ?>

</div>
