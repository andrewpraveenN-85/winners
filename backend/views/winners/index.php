<?php

use backend\models\Winners;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\WinnersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Winners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="winners-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Winners', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'profile_id',
            'gift_id',
            'status',
            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Winners $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'profile_id' => $model->profile_id, 'gift_id' => $model->gift_id]);
                 }
            ],
        ],
    ]); ?>


</div>
