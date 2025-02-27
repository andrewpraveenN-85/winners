<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\DrawsGiftsRewards $model */

$this->title = 'Create Draws Gifts Rewards';
$this->params['breadcrumbs'][] = ['label' => 'Draws Gifts Rewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draws-gifts-rewards-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
