<?php

use yii\grid\GridView;

$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="body-content m-3">
        <div class="row">
            <div class="col-sm-2">
                <div class="card text-dark border-warning ">
                    <div class="card-header"><strong>Members</strong></div>
                    <div class="card-body">
                        <p class="card-text text-end"><?= $members; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card text-dark border-warning ">
                    <div class="card-header"><strong>Memberships</strong></div>
                    <div class="card-body">
                        <p class="card-text text-end"><?= $memberships; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card text-dark border-warning ">
                    <div class="card-header"><strong>Packages</strong></div>
                    <div class="card-body">
                        <p class="card-text text-end"><?= $packages; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card text-dark border-warning ">
                    <div class="card-header"><strong>Draws</strong></div>
                    <div class="card-body">
                        <p class="card-text text-end"><?= $draws; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card text-dark border-warning ">
                    <div class="card-header"><strong>Events</strong></div>
                    <div class="card-body">
                        <p class="card-text text-end"><?= $events; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card text-dark border-warning ">
                    <div class="card-header"><strong>Merchants</strong></div>
                    <div class="card-body">
                        <p class="card-text text-end"><?= $merchants; ?></p>
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
                            'attribute' => 'profile.fullName',
                            'label' => 'Member',
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
