<?php

use yii\grid\GridView;

$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="body-content m-3">
        <div class="row">
            <div class="col-sm-2">
                <div class="card text-dark border-warning ">
                    <div class="card-header text-center"><strong><i class="fa fa-user-secret fa-fw fa-sm"></i>Members</strong></div>
                    <div class="card-body">
                        <p class="card-text text-center"><?= $members; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card text-dark border-warning ">
                    <div class="card-header text-center"><strong><i class="fa fa-chain fa-fw fa-sm"></i>Memberships</strong></div>
                    <div class="card-body">
                        <p class="card-text text-center"><?= $memberships; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card text-dark border-warning ">
                    <div class="card-header text-center"><strong><i class="fa fa-certificate fa-fw fa-sm"></i>Packages</strong></div>
                    <div class="card-body">
                        <p class="card-text text-center"><?= $packages; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card text-dark border-warning ">
                    <div class="card-header text-center"><strong><i class="fa fa-gamepad fa-fw fa-sm"></i>Draws</strong></div>
                    <div class="card-body">
                        <p class="card-text text-center"><?= $draws; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card text-dark border-warning ">
                    <div class="card-header text-center"><strong><i class="fa fa-calendar fa-fw fa-sm"></i>Events</strong></div>
                    <div class="card-body">
                        <p class="card-text text-center"><?= $events; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card text-dark border-warning ">
                    <div class="card-header text-center"><strong><i class="fa fa-building fa-fw fa-sm"></i>Merchants</strong></div>
                    <div class="card-body">
                        <p class="card-text text-center"><?= $merchants; ?></p>
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
