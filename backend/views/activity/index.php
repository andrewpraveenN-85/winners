<?php

use backend\models\Activity;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ActivitySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Activity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'profile_id',
            'event_id',
            'check_in',
            'check_out',
            'notes:ntext',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Activity $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'profile_id' => $model->profile_id, 'event_id' => $model->event_id]);
                 }
            ],
        ],
    ]); ?>


</div>
