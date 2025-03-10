<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\MembershipsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'My Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberships-index">
    <div class="row">
        <div class="col-12">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'format' => ['html'],
                        'value' => function ($data) {
                            return Html::img($data->event->imgURL, ['class' => 'img-fluid', 'style' => 'height: 50px;']); // options of size there
                        },
                    ],
                    [
                        'attribute' => 'event_id',
                        'label' => 'Event Name',
                        'value' => function ($model) {
                            return $model->event->name ?? '(No Event)';
                        },
                        'enableSorting' => false, // Disable sorting
                    ],
                    [
                        'attribute' => 'event_date',
                        'label' => 'Event Date',
                        'value' => function ($model) {
                            return $model->event->date_time ?? '(No Date)';
                        },
                        'enableSorting' => false, // Disable sorting
                    ],
                    [
                        'attribute' => 'address',
                        'label' => 'Address',
                        'value' => function ($model) {
                            return $model->event->address ?? '(No address)';
                        },
                        'enableSorting' => false, // Disable sorting
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Status',
                        'value' => function ($model) {
                            return $model->event->statusText ?? '(No status)';
                        },
                        'enableSorting' => false, // Disable sorting
                    ]
                ],
            ]);
            ?>
        </div>
    </div>

</div>