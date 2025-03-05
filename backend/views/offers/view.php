<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Offers $model */

$this->title = $model->package_id;
$this->params['breadcrumbs'][] = ['label' => 'Offers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="offers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'package_id' => $model->package_id, 'merchant_id' => $model->merchant_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'package_id' => $model->package_id, 'merchant_id' => $model->merchant_id], [
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
            'package_id',
            'merchant_id',
            'discount',
        ],
    ]) ?>

</div>
