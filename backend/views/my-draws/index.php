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
                        'attribute' => 'draw.date_time',
                        'label' => 'DateTime',
                        'enableSorting' => false,
                    ],
                    [
                        'attribute' => 'draw.description',
                        'label' => 'Description',
                        'enableSorting' => false,
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'status',
                        'enableSorting' => false,
                    ],
                ],
            ]);
            ?>
        </div>
    </div>

</div>