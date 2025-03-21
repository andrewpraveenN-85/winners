<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Members';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <!--
        <p>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
                Create
            </button>
        </p>-->

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
            'first_name',
            'last_name',
            'sin',
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <?php if ($model->isNewRecord) { ?>
                    <?php $form = ActiveForm::begin(['action' => ['create'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?php } else { ?>
                    <?php $form = ActiveForm::begin(['action' => ['update', 'id' => $model->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?php } ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $model->isNewRecord ? 'Create Merchant' : 'Update Merchant - ' . Html::encode($model->first_name . ' ' . $model->last_name) ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'First name', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'middle_name')->textInput(['placeholder' => 'Middle name', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Last name', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'sin')->textInput(['placeholder' => 'NIC/Driving licence/Passport No', 'maxlength' => 25, 'class' => 'form-control bg-light text-dark']) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'mobile')->textInput(['placeholder' => 'Contact mobile', 'maxlength' => 15, 'class' => 'form-control bg-light text-dark']) ?>
                    </div>

                    <div class="mb-3">
                        <?=
                        $form->field($model, 'dob')->input('date', [
                            'min' => date('Y-m-d', strtotime('-100 years')),
                            'max' => date('Y-m-d', strtotime('-18 years')),
                            'class' => 'form-control bg-light text-dark',
                            'id' => 'dob-field'
                        ])
                        ?>
                    </div>
                    <div class = "mb-3">
                        <?=
                        $form->field($model, 'gender')->dropDownList([
                            'Male' => 'Male',
                            'Female' => 'Female',
                            'Other' => 'Other'
                                ], [
                            'prompt' => 'Select Gender',
                            'class' => 'form-control bg-light text-dark'
                        ])
                        ?>

                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'image')->fileInput(['id' => 'profile-image-input', 'placeholder' => 'Profile image', 'class' => 'form-control bg-light text-dark']) ?>
                    </div>
                    
                    <?php if (!$model->isNewRecord) { ?>
                        <div class="mb-3">
                            <img class="img-fluid" src="<?= $model->imgURL; ?>" style="height:100px;">
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <?= $form->field($model, 'address')->textInput(['placeholder' => 'Address', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'notes')->textInput(['placeholder' => 'Additional notes', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
                    </div>
                    <div class="mb-3">
                        <?=
                        $form->field($model, 'dor')->input('date', [
                            'min' => date('Y-m-d', strtotime('-100 years')),
                            'max' => date('Y-m-d'),
                            'class' => 'form-control bg-light text-dark'
                        ])
                        ?>
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
            window.location.href = '/members'; // Replace '/index' with the actual route to your index page.
        });
    });
", \yii\web\View::POS_END); // Add at the end of the page
?>