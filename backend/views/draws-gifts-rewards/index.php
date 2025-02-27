<?php

use backend\models\DrawsGiftsRewards;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\DrawsGiftsRewardsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Draws Gifts Rewards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draws-gifts-rewards-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Draws Gifts Rewards', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'draws_gift_id',
            'rewards_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, DrawsGiftsRewards $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'draws_gift_id' => $model->draws_gift_id, 'rewards_id' => $model->rewards_id]);
                 }
            ],
        ],
    ]); ?>


</div>
