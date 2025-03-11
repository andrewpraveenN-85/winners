<?php

use backend\models\Packages;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\PackagesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Packages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="packages-index">

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
            'name',
            [
                'attribute' => 'duration',
                'value' => 'duration',
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'duration',
                        [
                            1 => 'Monthly',
                            6 => '6 Month',
                            12 => 'Annually',
                        ],
                        ['class' => 'form-control', 'prompt' => 'Select']
                ),
            ],
            [
                'attribute' => 'entry_point',
                'filter' => Html::activeTextInput($searchModel, 'entry_point', [
                    'class' => 'form-control',
                    'type' => 'number',
                    'step' => '1', // Ensures only whole numbers are entered
                    'min' => '1'
                ]),
            ],
            [
                'attribute' => 'smart_saving_events',
                'value' => function ($model) {
                    return $model->smart_saving_events ? 'Active' : 'Inactive';
                },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'smart_saving_events',
                        ['1' => 'True', '0' => 'False'],
                        ['class' => 'form-control', 'prompt' => 'Select']
                ),
            ],
            [
                'attribute' => 'merchants_discount',
                'filter' => Html::activeTextInput($searchModel, 'merchants_discount', [
                    'class' => 'form-control',
                    'type' => 'number',
                    'step' => '1', // Ensures only whole numbers are entered
                    'min' => '1'
                ]),
            ],
            [
                'attribute' => 'status',
                'value' => 'statusText',
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        [
                            Packages::STATUS_ACTIVE => 'Active',
                            Packages::STATUS_INACTIVE => 'Inactive',
                            Packages::STATUS_DELETED => 'Deleted',
                        ],
                        ['class' => 'form-control', 'prompt' => 'Select']
                ),
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{custom} {offers}',
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
                    <h5 class="modal-title" id="modalLabel"><?= $model->isNewRecord ? 'Create Package' : 'Update Package - ' . Html::encode($model->name) ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control mb-2']) ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($model, 'description')->textarea(['rows' => 2, 'class' => 'form-control mb-2']) ?>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <?= $form->field($model, 'entry_point')->input('number', ['class' => 'form-control mb-2', 'min' => 1, 'step' => 1]) ?>
                        </div>
                        <div class="col-3">
                            <?= $form->field($model, 'merchants_discount')->input('number', ['class' => 'form-control mb-2', 'min' => 1, 'step' => 1]) ?>
                        </div>
                        <div class="col-3">
                            <?=
                            $form->field($model, 'smart_saving_events')->dropDownList([
                                1 => 'Active',
                                0 => 'Inactive',
                                    ], ['prompt' => 'Select Status'])
                            ?>
                        </div>
                        <div class="col-3">
                            <?= $form->field($model, 'duration')->dropDownList([
                            1 => 'Monthly',
                            6 => '6 Month',
                            12 => 'Annually',
                        ], ['prompt' => 'Select', 'class' => 'form-control mb-2']) ?>
                        </div>
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
                        <?= $form->field($model, 'purchase_url')->textInput(['maxlength' => true, 'class' => 'form-control mb-2']) ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($model, 'status')->dropDownList([9 => 'Inactive', 10 => 'Active'], ['prompt' => 'Select', 'class' => 'form-control mb-2']) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("
    $(document).ready(function() {
        // Show the modal if 'id' parameter exists in the URL
        if ('" . Yii::$app->request->get('id') . "' !== '') {
            $('#modal').modal('show');
        }

        // Redirect user when the modal is hidden
        var myModalEl = document.getElementById('modal');
        myModalEl.addEventListener('hidden.bs.modal', function (event) {
            window.location.href = '/packages';
        });
    });
", \yii\web\View::POS_END);
