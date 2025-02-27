<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\DrawsGifts $model */

$this->title = 'Update Draws Gifts: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Draws Gifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="draws-gifts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
