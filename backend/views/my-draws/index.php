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
                        'attribute' => 'gift.draw.package.name',
                        'label' => 'Package Name',
                    ],
                    [
                        'attribute' => 'gift.draw.id',
                        'label' => 'Draw ID',
                    ],
                    [
                        'attribute' => 'gift.draw.date_time',
                        'label' => 'Draw DateTime',
                    ],
                    [
                        'attribute' => 'gift.name',
                        'label' => 'Gift Name',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>

</div>