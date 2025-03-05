<?php

use backend\models\Packages;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

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

// For view modal
$viewModel = Yii::$app->request->get('view_id') ?
    Packages::findOne(Yii::$app->request->get('view_id')) :
    null;
?>
<div class="packages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
            Create Package
        </button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'name',
            // 'description:ntext',
            'duration',
            'entry_point',
            'smart_saving_events',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status ? 'Active' : 'Inactive';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    [0 => 'Inactive', 1 => 'Active'],
                    ['class' => 'form-control', 'prompt' => 'All']
                )
            ],
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-eye"></i> View',
                            ['index', 'view_id' => $model->id],
                            [
                                'class' => 'btn btn-secondary',
                                'data' => ['pjax' => 0],
                            ]
                        );
                    },
                    'update' => function ($url, $model, $key) {
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
    ]); ?>

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

    <!-- View Modal -->
    <?php if ($viewModel): ?>
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">Package: <?= Html::encode($viewModel->name) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?= DetailView::widget([
                            'model' => $viewModel,
                            'attributes' => [
                                'id',
                                'name',
                                'description:ntext',
                                'duration',
                                'entry_point',
                                'smart_saving_events',
                                [
                                    'attribute' => 'status',
                                    'value' => function ($model) {
                                        return $model->status ? 'Active' : 'Inactive';
                                    }
                                ],
                                'created_at',
                                'updated_at',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$this->registerJs("
    $(document).ready(function() {
        // For edit modal
        if ('" . Yii::$app->request->get('id') . "') {
            $('#modal').modal('show');
        }
        
        // For view modal
        if ('" . Yii::$app->request->get('view_id') . "') {
            $('#viewModal').modal('show');
        }
        
        // Edit modal close handler
        var myModalEl = document.getElementById('modal');
        myModalEl.addEventListener('hidden.bs.modal', function (event) {
            window.location.href = '/business/packages';
        });
        
        // View modal close handler
        var viewModalEl = document.getElementById('viewModal');
        if (viewModalEl) {
            viewModalEl.addEventListener('hidden.bs.modal', function (event) {
                window.location.href = '/business/packages';
            });
        }
    });
", \yii\web\View::POS_END);
?>