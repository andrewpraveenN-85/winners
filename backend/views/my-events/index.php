<?php

use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\MembershipsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'My Draws';
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
                        'attribute' => 'check_in',
                        'enableSorting' => false, // Disable sorting
                    ],
                    [
                        'attribute' => 'check_out',
                        'enableSorting' => false, // Disable sorting
                    ],
                    [
                        'attribute' => 'notes',
                        'format' => 'ntext',
                        'enableSorting' => false, // Disable sorting
                    ],
                ],
            ]);
            ?>
        </div>
    </div>

</div>