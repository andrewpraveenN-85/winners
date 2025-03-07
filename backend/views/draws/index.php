<?php

use backend\models\Draws;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\DrawsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Draws';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draws-index">
    <p>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
            Create Draw
        </button>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
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
                'attribute' => 'date_time',
                'filter' => Html::activeInput('datetime-local', $searchModel, 'date_time', [
                    'class' => 'form-control',
                    'placeholder' => 'Select Date and Time',
                ]),
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->date_time);
                },
            ],
            [
                'attribute' => 'status',
                'value' => 'statusText',
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        [
                            Draws::STATUS_ACTIVE => 'Active',
                            Draws::STATUS_INACTIVE => 'Inactive',
                            Draws::STATUS_DELETED => 'Deleted',
                        ],
                        ['class' => 'form-control', 'prompt' => 'Select']
                ),
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                                '<i class="bi bi-pencil"></i> Update',
                                ['index', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-primary',
                                    'data' => ['pjax' => 0],
                                ]
                        );
                    },
                ],
            ],
        ],
    ]);
    ?>

    <!-- Create/Update Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <?php if ($model->isNewRecord) { ?>
                    <?php $form = ActiveForm::begin(['action' => ['create'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?php } else { ?>
                    <?php $form = ActiveForm::begin(['action' => ['update', 'id' => $model->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?php } ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"><?= $model->isNewRecord ? 'Create Draw' : 'Update Draw #' . Html::encode($model->id) ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="mb-3">
                                <?= $form->field($model, 'package_id')->dropDownList($packages, ['class' => 'form-control mb-2', 'prompt' => 'Select',]) ?>
                            </div>
                            <div class="mb-3">
                                <?= $form->field($model, 'date_time')->textInput(['type' => 'datetime-local']) ?>
                            </div>
                            <div class="mb-3">
                                <?= $form->field($model, 'status')->dropDownList([0 => 'Deleted', 9 => 'Inactive', 10 => 'Active'], ['class' => 'form-control mb-2', 'prompt' => 'Select',]) ?>
                            </div>
                        </div>
                        <div class="col-6">

                        </div>
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
        if ('" . Yii::$app->request->get('id') . "') {
            $('#modal').modal('show');
        }

        var myModalEl = document.getElementById('modal');
        myModalEl.addEventListener('hidden.bs.modal', function (event) {
            window.location.href = '/draws';
        });
    });
", \yii\web\View::POS_END);
?>