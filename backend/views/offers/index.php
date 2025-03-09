<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\OffersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Offers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offers-index">

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
            [
                'attribute' => 'merchant_id',
                'value' => function ($model) {
                    return $model->merchant ? $model->merchant->bussiness_name : 'Not Assigned'; // Change 'name' based on your package field
                },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'merchant_id',
                        $merchants, // Array of packages ['id' => 'Package Name']
                        ['class' => 'form-control', 'prompt' => 'Select']
                ),
            ],
//            'discount',
            [
                'class' => ActionColumn::className(),
                'template' => '{custom} {del}',
                'buttons' => [
                    'custom' => function ($url, $data, $key) {
                        return Html::a(
                                'Update',
                                ['index', 'package_id' => $data->package_id, 'merchant_id' => $data->merchant_id],
                                [
                                    'class' => 'btn btn-primary text-white',
                                    'data' => [
                                        'pjax' => 0, // Ensure a full page load instead of PJAX.
                                    ],
                                ]
                        );
                    },
                    'del' => function ($url, $data, $key) {
                        return Html::a(
                                'Remove',
                                ['delete', 'package_id' => $data->package_id, 'merchant_id' => $data->merchant_id],
                                [
                                    'class' => 'btn btn-danger text-white',
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
                    <?php $form = ActiveForm::begin(['action' => ['update', 'package_id' => $model->package_id, 'merchant_id' => $model->merchant_id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?php } ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $model->isNewRecord ? 'Create Offers' : 'Update Offer - ' . Html::encode($model->package->name) ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <?= $form->field($model, 'package_id')->dropDownList($packages, ['class' => 'form-control mb-2', 'prompt' => 'Select',]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($model, 'merchant_id')->dropDownList($merchants, ['class' => 'form-control mb-2', 'prompt' => 'Select',]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($model, 'image')->fileInput(['placeholder' => 'Banner image', 'class' => 'form-control bg-light text-dark']) ?>
                    </div>
                    <?php if (!$model->isNewRecord) { ?>
                        <div class="mb-3">
                            <img class="img-fluid" src="<?= $model->imgURL; ?>" style="height:100px;">
                        </div>
                    <?php } ?>
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
        if ('" . Yii::$app->request->get('merchant_id') . "' && '" . Yii::$app->request->get('package_id') . "') {
            $('#modal').modal('show');
        }
        var myModalEl = document.getElementById('modal');
        myModalEl.addEventListener('hidden.bs.modal', function (event) {
            window.location.href = '/offers'; // Replace '/index' with the actual route to your index page.
        });
    });
", \yii\web\View::POS_END); // Add at the end of the page
?>