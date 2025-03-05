<?php

use backend\models\Memberships;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\MembershipsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Memberships';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberships-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Memberships', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'profile_id',
            'package_id',
            'status',
            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Memberships $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'profile_id' => $model->profile_id, 'package_id' => $model->package_id]);
                 }
            ],
        ],
    ]); ?>


</div>
