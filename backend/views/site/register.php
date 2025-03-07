<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \backend\models\LoginForm $model */
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Register";
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 75rem;">
        <h4 class="text-center mb-3">Register</h4>
        <?php $form = ActiveForm::begin(['action' => ['register'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row mb-3">
            <div class="col-3">
                <?= $form->field($model, 'package')->dropDownList($packages, ['class' => 'form-control mb-2', 'prompt' => 'Select',]) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'first_name')->textInput(['maxlength' => 200, 'class' => 'form-control mb-2']) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'middle_name')->textInput(['maxlength' => 200, 'class' => 'form-control mb-2']) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'last_name')->textInput(['maxlength' => 200, 'class' => 'form-control mb-2']) ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                <?= $form->field($model, 'sin')->textInput(['maxlength' => 20, 'class' => 'form-control mb-2']) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'email')->textInput(['maxlength' => 200, 'class' => 'form-control mb-2']) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'mobile')->textInput(['maxlength' => 15, 'class' => 'form-control mb-2']) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'dob')->input('date', ['class' => 'form-control mb-2']) ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                <?= $form->field($model, 'image')->fileInput(['class' => 'form-control mb-2']) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'dor')->input('date', ['class' => 'form-control mb-2']) ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'address')->textInput(['maxlength' => 200, 'class' => 'form-control mb-2']) ?>
            </div>
        </div>  `
        <div class="row mb-3">
            <div class="col-6">
                <?= $form->field($model, 'notes')->textInput(['maxlength' => 200, 'class' => 'form-control mb-2']) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'accept_terms')->checkbox(['class' => 'mb-2']) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'accept_age')->checkbox(['class' => 'mb-2']) ?>
            </div>
        </div>
        <?= Html::submitButton('Register', ['class' => 'btn btn-warning w-100', 'name' => 'login-button']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>