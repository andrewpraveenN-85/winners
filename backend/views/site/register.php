<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \backend\models\RegisterForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Register";
?>
<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="row login-container shadow-lg rounded" style="width: 50rem;">
        <!-- Left: Scrollable Form -->
        <div class="col-md-6 bg-white p-4" style="max-height: 80vh; overflow-y: auto; scrollbar-color: #5C4033 #FFD700; scrollbar-width: thin;">
            <h3 class="text-warning fw-bold text-center">Register</h3>
            <?php $form = ActiveForm::begin(['action' => ['register'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
            
            <div class="mb-3">
                <?= $form->field($model, 'package')->dropDownList($packages, ['prompt' => 'Select', 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'first_name')->textInput(['maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'middle_name')->textInput(['maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'last_name')->textInput(['maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'sin')->textInput(['maxlength' => 20, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'email')->textInput(['maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'mobile')->textInput(['maxlength' => 15, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'dob')->input('date', [
                    'min' => date('Y-m-d', strtotime('-100 years')),
                    'max' => date('Y-m-d', strtotime('-18 years')),
                    'class' => 'form-control bg-light text-dark'
                ]) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'image')->fileInput(['class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'dor')->input('date', [
                    'min' => date('Y-m-d', strtotime('-100 years')),
                    'max' => date('Y-m-d'),
                    'class' => 'form-control bg-light text-dark'
                ]) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'address')->textInput(['maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'notes')->textInput(['maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="form-check mb-3">
                <?= $form->field($model, 'accept_terms')->checkbox(['class' => 'form-check-input']) ?>
            </div>

            <div class="form-check mb-3">
                <?= $form->field($model, 'accept_age')->checkbox(['class' => 'form-check-input']) ?>
            </div>

            <div class="mb-3">
                <?= Html::submitButton('Register', ['class' => 'btn btn-warning w-100']) ?>
            </div>

            <p class="mt-3 text-center">Already a member? <?= Html::a('Back to Login', ['site/login'], ['class' => 'text-warning text-decoration-none']) ?></p>
            <?php ActiveForm::end(); ?>
        </div>

        <!-- Right: Logo -->
        <div class="col-md-6 login-right d-flex align-items-center justify-content-center">
            <img src="/media/logo.png" width="300px" alt="Logo"/>
        </div>
    </div>
</div>
