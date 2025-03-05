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
$this->params['breadcrumbs'][] = 'Business';
$this->params['breadcrumbs'][] = $this->title;

// Initialize model if editing (from URL parameter) or create new one
$model = Yii::$app->request->get('id') ? 
    Packages::findOne(Yii::$app->request->get('id')) : 
    new Packages();
?>
<div class="packages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
            Create Package
        </button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'description:ntext',
            'duration',
            'entry_point',
            //'smart_saving_events',
            //'status',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($unused, $model) {
                        return Html::a(
                            '<i class="bi bi-eye"></i>',
                            ['view', 'id' => $model->id],
                            ['class' => 'btn btn-outline-secondary btn-sm']
                        );
                    },
                    'update' => function ($unused, $model) {
                        return Html::a(
                            '<i class="bi bi-pencil"></i>',
                            ['index', 'id' => $model->id],
                            [
                                'class' => 'btn btn-outline-primary btn-sm',
                                'data' => ['pjax' => 0],
                            ]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<i class="bi bi-trash"></i>',
                            ['delete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-outline-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

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
                    <h5 class="modal-title" id="modalLabel"><?= $model->isNewRecord ? 'Create Package' : 'Update Package - ' . Html::encode($model->name) ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control mb-2']) ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <?= $form->field($model, 'description')->textarea(['rows' => 6, 'class' => 'form-control mb-2']) ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <?= $form->field($model, 'duration')->dropDownList(['monthly' => 'Monthly', 'yearly' => 'Yearly'], ['prompt' => 'Select', 'class' => 'form-control mb-2']) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($model, 'entry_point')->textInput(['class' => 'form-control mb-2']) ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <?= $form->field($model, 'smart_saving_events')->textInput(['class' => 'form-control mb-2']) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($model, 'status')->dropDownList([0 => 'Inactive', 1 => 'Active'], ['prompt' => 'Select', 'class' => 'form-control mb-2']) ?>
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
            window.location.href = '/business/packages';
        });
    });
", \yii\web\View::POS_END);
?>