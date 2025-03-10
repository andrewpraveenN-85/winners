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
            [
                'format' => ['html'],
                'value' => function ($data) {
                    return Html::img($data->imgURL, ['class' => 'img-fluid', 'style' => 'height: 50px;']); // options of size there
                },
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
                                    'class' => 'btn btn-primary text-white',
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
                        <?= $form->field($model, 'package_id')->dropDownList($packages, ['class' => 'form-control mb-2', 'prompt' => 'Select',]) ?>
                    </div>
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
                        <?= $form->field($model, 'image')->fileInput(['placeholder' => 'Banner image', 'class' => 'form-control bg-light text-dark']) ?>
                    </div>
                    <?php if (!$model->isNewRecord) { ?>
                        <div class="mb-3">
                            <img class="img-fluid" src="<?= $model->imgURL; ?>" style="height:100px;">
                        </div>
                    <?php } ?>
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