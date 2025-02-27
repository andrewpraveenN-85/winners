<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\DrawsGiftsRewards $model */

$this->title = 'Update Draws Gifts Rewards: ' . $model->draws_gift_id;
$this->params['breadcrumbs'][] = ['label' => 'Draws Gifts Rewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->draws_gift_id, 'url' => ['view', 'draws_gift_id' => $model->draws_gift_id, 'rewards_id' => $model->rewards_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="draws-gifts-rewards-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
