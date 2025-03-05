<?php

use backend\models\Events;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\EventsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-index">

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
            'name',
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
                'attribute' => 'registration_deadline',
                'filter' => Html::activeInput('date', $searchModel, 'registration_deadline', [
                    'class' => 'form-control',
                    'placeholder' => 'Select Date',
                ]),
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->registration_deadline);
                },
            ],
            [
                'attribute' => 'maximum_participations',
                'filter' => Html::activeInput('number', $searchModel, 'maximum_participations', [
                    'class' => 'form-control',
                    'step' => 1, // Step set to 1
                    'min' => 1, // Minimum value set to 1
                    'placeholder' => 'Enter number',
                ]),
                'value' => function ($model) {
                    return $model->maximum_participations;
                },
            ],
            [
                'attribute' => 'status',
                'value' => 'statusText',
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        [
                            Events::STATUS_ACTIVE => 'Active',
                            Events::STATUS_INACTIVE => 'Inactive',
                            Events::STATUS_DELETED => 'Deleted',
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
                                ['index', 'id' => $data->id],
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
                    <?php $form = ActiveForm::begin(['action' => ['update', 'id' => $model->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?php } ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $model->isNewRecord ? 'Create Event' : 'Update Event - ' . Html::encode($model->name) ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($model, 'date_time')->textInput(['type' => 'datetime-local']) ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($model, 'registration_deadline')->textInput(['type' => 'date']) ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($model, 'maximum_participations')->textInput(['type' => 'number', 'min'=>1, 'step'=>1]) ?>
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
        if ('" . Yii::$app->request->get('id') . "') {
            $('#modal').modal('show');
        }
        var myModalEl = document.getElementById('modal');
        myModalEl.addEventListener('hidden.bs.modal', function (event) {
            window.location.href = '/events'; // Replace '/index' with the actual route to your index page.
        });
    });
", \yii\web\View::POS_END); // Add at the end of the page
?>