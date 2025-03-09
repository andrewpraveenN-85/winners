<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \backend\models\LoginForm $model */
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Login";
?>

<div class="container vh-100 d-flex align-items-center">
    <div class="login-container row">
        <!-- Left Side - Form -->
        <div class="col-md-6 login-left">
            <h3 class="text-warning fw-bold text-center">Log in to your Account</h3>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="mb-3">
                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email', 'class' => 'form-control bg-light text-dark'])->label(false) ?>
            </div>
            <div class="mb-3">
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'class' => 'form-control bg-light text-dark'])->label(false) ?>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <?= $form->field($model, 'rememberMe')->checkbox()->label("Remember me") ?>
                </div>
                <div>
                    <?= Html::a('Forgot Password?', ['site/request-password-reset'], ['class' => 'text-warning text-decoration-none']) ?>
                </div>
            </div>
            <?= Html::submitButton('Log in', ['class' => 'btn btn-warning w-100', 'name' => 'login-button']) ?>
            <p class="mt-3 text-center">Not a member? <?= Html::a('Join as a member!', ['site/register'], ['class' => 'text-warning text-decoration-none']) ?></p>
            <?php ActiveForm::end(); ?>
        </div>

        <!-- Right Side - Illustration -->
        <div class="col-md-6 login-right d-flex flex-column align-items-center justify-content-center">
            <img src="/media/logo.png" width="300px" alt="Logo"/>
        </div>
    </div>
</div>
