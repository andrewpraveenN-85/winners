<?php

use yii\grid\GridView;

$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="body-content m-3">
        <div class="row">
            <div class="col-sm-3">
                <div class="card text-dark border-warning">
                    <div class="card-header"><strong>My Package</strong></div>
                    <div class="card-body">
                        <p class="card-text text-end"><?= $package->name; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-dark border-warning">
                    <div class="card-header"><strong>Remaining Entries</strong></div>
                    <div class="card-body">
                        <p class="card-text text-end"><?= $package->entry_point; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-dark border-warning">
                    <div class="card-header"><strong>Merchants Discounts</strong></div>
                    <div class="card-body">
                        <p class="card-text text-end"><?= $package->merchants_discount; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-dark border-warning">
                    <div class="card-header"><strong>Smart Saving Events</strong></div>
                    <div class="card-body">
                        <p class="card-text text-end"><?= $package->smart_saving_events ? 'Active' : 'Inactive'; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mb-3">
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
</div>
