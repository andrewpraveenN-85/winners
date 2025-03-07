<?php

use backend\models\Memberships;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\MembershipsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Memberships';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberships-index">

    <p>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
            Create
        </button>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'profile_id',
                'value' => function ($model) {
                    return $model->profile ? $model->profile->first_name . ' ' . $model->profile->last_name : 'Not Assigned'; // Change 'name' based on your package field
                },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'profile_id',
                        $members, // Array of packages ['id' => 'Package Name']
                        ['class' => 'form-control', 'prompt' => 'Select']
                ),
            ],
            [
                'attribute' => 'package_id',
                'value' => function ($model) {
                    return $model->package ? $model->package->name : 'Not Assigned'; // Change 'name' based on your package field
                },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'package_id',
                        $packages, // Array of packages ['id' => 'Package Name']
                        ['class' => 'form-control', 'prompt' => 'Select']
                ),
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:Y-m-d H:i:s'],
                'filter' => Html::input('datetime-local', 'created_at',
                        $searchModel->created_at ? date('Y-m-d\TH:i', strtotime($searchModel->created_at)) : '',
                        ['class' => 'form-control']
                ),
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['datetime', 'php:Y-m-d H:i:s'],
                'filter' => Html::input('datetime-local', 'updated_at',
                        $searchModel->updated_at ? date('Y-m-d\TH:i', strtotime($searchModel->updated_at)) : '',
                        ['class' => 'form-control']
                ),
            ],
            [
                'attribute' => 'status',
                'value' => 'statusText',
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        [
                            Memberships::STATUS_ACTIVE => 'Active',
                            Memberships::STATUS_INACTIVE => 'Inactive',
                            Memberships::STATUS_DELETED => 'Deleted',
                        ],
                        ['class' => 'form-control', 'prompt' => 'Select']
                ),
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{custom}',
                'buttons' => [
                    'custom' => function ($url, $data, $key) {
                        return Html::a(
                                'Update',
                                ['index', 'profile_id' => $data->profile_id, 'package_id' => $data->package_id],
                                [
                                    'class' => 'btn btn-primary',
                                    'data' => [
                                        'pjax' => 0, // Ensure a full page load instead of PJAX.
                                    ],
                                ]
                        );
                    },
                ],
            ],
        ],
    ]);
    ?>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <?php if ($model->isNewRecord) { ?>
                    <?php $form = ActiveForm::begin(['action' => ['create'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?php } else { ?>
                    <?php $form = ActiveForm::begin(['action' => ['update', 'profile_id' => $model->profile_id, 'package_id' => $model->package_id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?php } ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $model->isNewRecord ? 'Create Membership' : 'Update Membership - ' . Html::encode($model->profile->first_name.' '.$model->profile->first_name) ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <?= $form->field($model, 'profile_id')->dropDownList($members, ['class' => 'form-control mb-2', 'prompt' => 'Select',]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($model, 'package_id')->dropDownList($packages, ['class' => 'form-control mb-2', 'prompt' => 'Select',]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($model, 'status')->dropDownList([0 => 'Deleted', 9 => 'Inactive', 10 => 'Active'], ['class' => 'form-control mb-2', 'prompt' => 'Select',]) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success w-100']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div> 

</div>
<?php
$this->registerJs("
    $(document).ready(function() {
        if ('" . Yii::$app->request->get('profile_id') . "' && '".Yii::$app->request->get('package_id')."') {
            $('#modal').modal('show');
        }
        var myModalEl = document.getElementById('modal');
        myModalEl.addEventListener('hidden.bs.modal', function (event) {
            window.location.href = '/memberships'; // Replace '/index' with the actual route to your index page.
        });
    });
", \yii\web\View::POS_END); // Add at the end of the page
?>