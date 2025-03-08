<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \frontend\models\ResetPasswordForm $model */
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="login-container row">
        <!-- Left Side - Form -->
        <div class="col-md-6 login-left">
            <h3 class="text-warning fw-bold">Reset Your Password</h3>
            <p>Enter your new password below.</p>

            <div class="row">
                <div class="col-lg-12">
                    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                    <div class="mb-3">
                        <?=
                        $form->field($model, 'password')->passwordInput([
                            'autofocus' => true,
                            'placeholder' => 'New Password',
                            , 'class' => 'form-control bg-light text-dark'
                        ])->label(false)
                        ?>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Save Password', ['class' => 'btn btn-warning w-100']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <!-- Right Side - Illustration -->
        <div class="col-md-6 login-right">
            <h5>Secure your account</h5>
            <p>Choose a strong password to keep your account safe.</p>
        </div>
    </div>
</div>