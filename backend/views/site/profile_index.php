<?php

use yii\grid\GridView;

$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="body-content m-3">
        <div class="row">
            <div class="col-sm-3">
                <div class="card text-dark border-warning">
                    <div class="card-header text-center"><strong><i class="fa fa-certificate fa-fw fa-sm"></i>My Package</strong></div>
                    <div class="card-body">
                        <p class="card-text text-center"><?= $package->name; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-dark border-warning">
                    <div class="card-header text-center"><strong><i class="fa fa-gamepad fa-fw fa-sm"></i>Remaining Entries</strong></div>
                    <div class="card-body">
                        <p class="card-text text-center"><?= $package->entry_point; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-dark border-warning">
                    <div class="card-header text-center"><strong><i class="fa fa-building fa-fw fa-sm"></i>Merchants Discounts</strong></div>
                    <div class="card-body">
                        <p class="card-text text-center"><?= $package->merchants_discount; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-dark border-warning">
                    <div class="card-header text-center"><strong><i class="fa fa-calendar fa-fw fa-sm"></i>Smart Saving Events</strong></div>
                    <div class="card-body">
                        <p class="card-text text-center"><?= $package->smart_saving_events ? 'Active' : 'Inactive'; ?></p>
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
</div>
