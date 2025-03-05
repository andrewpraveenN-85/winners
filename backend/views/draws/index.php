<?php

use backend\models\Draws;
use backend\models\Packages;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\DrawsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Draws';
$this->params['breadcrumbs'][] = $this->title;

// Initialize model if editing (from URL parameter) or create new one
$model = Yii::$app->request->get('id') ?
    Draws::findOne(Yii::$app->request->get('id')) :
    new Draws();

$viewModel = Yii::$app->request->get('view_id') ?
    Draws::findOne(Yii::$app->request->get('view_id')) :
    null;

// Set default values for new records
if ($model->isNewRecord) {
    $model->status = 1;
    $model->created_at = time();
}
$model->updated_at = time();
?>
<div class="draws-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
            Create Draw
        </button>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'package_id',
                'value' => 'package.name',
                'filter' => \yii\helpers\ArrayHelper::map(Packages::find()->all(), 'id', 'name')
            ],
            'date_time',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status ? 'Active' : 'Inactive';
                },
                'filter' => [0 => 'Inactive', 1 => 'Active']
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<i class="bi bi-eye"></i> View',
                            ['index', 'view_id' => $model->id],
                            [
                                'class' => 'btn btn-secondary',
                                'data' => ['pjax' => 0],
                            ]
                        );
                    },
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
                    <h5 class="modal-title" id="modalLabel"><?= $model->isNewRecord ? 'Create Draw' : 'Update Draw #' . Html::encode($model->id) ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <?= $form->field($model, 'package_id')->dropDownList(
                                \yii\helpers\ArrayHelper::map(Packages::find()->all(), 'id', 'name'),
                                ['prompt' => 'Select Package', 'class' => 'form-control mb-2']
                            ) ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <?= $form->field($model, 'date_time')->input('datetime-local', [
                                'class' => 'form-control mb-2',
                                'value' => $model->date_time ? date('Y-m-d\TH:i', strtotime($model->date_time)) : ''
                            ]) ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <?= $form->field($model, 'status')->dropDownList(
                                [0 => 'Inactive', 1 => 'Active'],
                                ['prompt' => 'Select Status', 'class' => 'form-control mb-2']
                            ) ?>
                        </div>
                    </div>

                    <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>
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
                        <h5 class="modal-title" id="viewModalLabel">Draw #<?= Html::encode($viewModel->id) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?= DetailView::widget([
                            'model' => $viewModel,
                            'attributes' => [
                                'id',
                                'package.name',
                                'date_time',
                                [
                                    'attribute' => 'status',
                                    'value' => function ($model) {
                                        return $model->status ? 'Active' : 'Inactive';
                                    }
                                ],
                                'created_at:datetime',
                                'updated_at:datetime',
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
        if ('" . Yii::$app->request->get('id') . "') {
            $('#modal').modal('show');
        }
        
        if ('" . Yii::$app->request->get('view_id') . "') {
            $('#viewModal').modal('show');
        }
        
        var myModalEl = document.getElementById('modal');
        myModalEl.addEventListener('hidden.bs.modal', function (event) {
            window.location.href = '/draws';
        });
        
        var viewModalEl = document.getElementById('viewModal');
        if (viewModalEl) {
            viewModalEl.addEventListener('hidden.bs.modal', function (event) {
                window.location.href = '/draws';
            });
        }
    });
", \yii\web\View::POS_END);
?>