<?php

use backend\models\Packages;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\User;

/** @var yii\web\View $this */
/** @var backend\models\PackagesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Packages';
$this->params['breadcrumbs'][] = 'Business';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="packages-index">

    <p>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
            Create
        </button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'attribute' => 'duration',
                'value' => 'duration',
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'duration',
                        [
                            'monthly' => 'Monthly',
                            'yearly' => 'yearly',
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
                    return $model->smart_saving_events ? 'True' : 'False';
                },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'smart_saving_events',
                        ['1' => 'True', '0' => 'False'],
                        ['class' => 'form-control', 'prompt' => 'Select']
                ),
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

    <!-- Create/Update Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl">
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
                    <div class="row">
                        <div class="col-6">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control mb-2']) ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <?= $form->field($model, 'description')->textarea(['rows' => 2, 'class' => 'form-control mb-2']) ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <?= $form->field($model, 'duration')->dropDownList(['monthly' => 'Monthly', 'yearly' => 'Yearly'], ['prompt' => 'Select', 'class' => 'form-control mb-2']) ?>
                                </div>
                                <div class="col-6">
                                    <?= $form->field($model, 'entry_point')->input('number', ['class' => 'form-control mb-2', 'min' => 1, 'step' => 1]) ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <?= $form->field($model, 'smart_saving_events')->checkbox(['label' => 'Smart Saving Events']) ?>
                                </div>
                                <div class="col-6">
                                    <?= $form->field($model, 'status')->dropDownList([9 => 'Inactive', 10 => 'Active'], ['prompt' => 'Select', 'class' => 'form-control mb-2']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <?=
                            GridView::widget([
                                'dataProvider' => $merchantDataProvider,
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\CheckboxColumn',
                                        'name' => 'Merchants', // The name of the checkbox
                                        'checkboxOptions' => function ($model) {
                                            return [
                                        'value' => $model->id, // Value that will be submitted when checkbox is selected
                                        'class' => 'permission-checkbox', // Add a class to select checkboxes via JS
                                            ];
                                        }
                                    ],
                                    'bussiness_name',
                                    [
                                        'label' => 'Discount Rate',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return Html::textInput("discount_rate[{$model->id}]", '20', [
                                                'class' => 'form-control',
                                                'type' => 'number',
                                                'min' => 0,
                                                'step' => 0.01,
                                                'value' => 20
                                            ]);
                                        }
                                    ],
                                ],
                            ]);
                            ?>
                            <?= $form->field($model, 'merchants')->textInput(['type' => 'hidden'])->label(false) ?>
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
        // Show the modal if 'id' parameter exists in the URL
        if ('" . Yii::$app->request->get('id') . "' !== '') {
            $('#modal').modal('show');
        }

        // Redirect user when the modal is hidden
        var myModalEl = document.getElementById('modal');
        myModalEl.addEventListener('hidden.bs.modal', function (event) {
            window.location.href = '/business/packages';
        });

        // Get stored merchant-discount values if editing
        var merchantsField = $('input[name=\"Packages[merchants]\"]').val();
        if (merchantsField) {
            var merchantsArray = merchantsField.split(','); // Convert stored data into an array

            merchantsArray.forEach(function(item) {
                var parts = item.split('-'); // Split merchant ID and discount rate
                var merchantId = parts[0];
                var discountRate = parts[1];

                // Check the corresponding checkbox
                $('.permission-checkbox[value=\"' + merchantId + '\"]').prop('checked', true);

                // Set the corresponding discount input value
                $(\"input[name='discount_rate[\" + merchantId + \"]']\").val(discountRate);
            });
        }

        // Update merchants field when checkbox state changes
        $('.permission-checkbox').on('change', function() {
            updateMerchantsField();
            $(this).closest('tr').toggleClass('selected', this.checked);
        });

        // Update the merchants field just before form submission
        $('form').on('beforeSubmit', function() {
            updateMerchantsField();

            var merchants = $('input[name=\"Packages[merchants]\"]').val();
            if (!merchants) {
                alert('Please select at least one merchant.');
                return false;
            }
            return true;
        });

        // Function to update the hidden merchants input field
        function updateMerchantsField() {
            var merchants = [];

            $('.permission-checkbox:checked').each(function() {
                var merchantId = $(this).val();
                var discountRate = $(\"input[name='discount_rate[\" + merchantId + \"]']\").val();
                merchants.push(merchantId + '-' + discountRate);
            });

            $('input[name=\"Packages[merchants]\"]').val(merchants.join(','));
        }
    });
", \yii\web\View::POS_END);
