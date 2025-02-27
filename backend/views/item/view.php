<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\DetailView;
use yii2mod\rbac\RbacAsset;
use yii\widgets\ActiveForm;

RbacAsset::register($this);

/* @var $this yii\web\View */
/* @var $model \yii2mod\rbac\models\AuthItemModel */

$labels = $this->context->getLabels();
$this->title = Yii::t('yii2mod.rbac', $labels['Item'] . ' : {0}', $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii2mod.rbac', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="auth-item-view">
    <h1><?php echo Html::encode($this->title); ?></h1>
    <p>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>
    </p>
    <div class="row">
        <div class="col-sm-12">
            <?php
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                ],
            ]);
            ?>
        </div>
    </div>
    <?php
    echo $this->render('_dualListBox', [
        'opts' => Json::htmlEncode([
            'items' => $finalArray,
        ]),
        'assignUrl' => ['assign', 'id' => $model->name],
        'removeUrl' => ['remove', 'id' => $model->name],
    ]);
    ?>

    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php $updateForm = ActiveForm::begin(['action' => ['update', 'id' => $model->name], 'options' => ['enctype' => 'multipart/form-data', 'id' => 'updateForm']]); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Role - <?= $model->name; ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <?= $updateForm->field($model, 'name')->textInput(['maxlength' => 200, 'class' => 'form-control mb-2']) ?>
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
