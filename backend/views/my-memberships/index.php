<?php

use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\MembershipsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'My Memberships';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberships-index">
    <p>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
            Membership Card
        </button>
    </p>
    <div class="row">
        <div class="col-6">
            <?=
            DetailView::widget([
                'model' => $package,
                'attributes' => [
                    'name',
                    'description',
                    'duration',
                    'entry_point',
                    'eventText',
                    'merchants_discount'
                ],
            ])
            ?>
        </div>
        <div class="col-6">
            <?=
            DetailView::widget([
                'model' => $membership,
                'attributes' => [
                    'statusText',
                    'created_at:datetime',
                ],
            ])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'merchant.bussiness_name',
                        'label' => 'Merchant',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Membership Card</h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    On Progress...

                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
    
</div>