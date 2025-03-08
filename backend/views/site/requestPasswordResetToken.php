<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \frontend\models\PasswordResetRequestForm $model */
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="login-container row">
        <!-- Left Side - Form -->
        <div class="col-md-6 login-left">
            <h3 class="text-warning fw-bold">Forgot your Password?</h3>
            <p>Enter your email address, and we'll send you a link to reset your password.</p>

            <div class="row">
                <div class="col-lg-12">
                    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                    <div class="mb-3">
                        <?=
                        $form->field($model, 'email')->textInput([
                            'autofocus' => true,
                            'placeholder' => 'Email',
                            , 'class' => 'form-control bg-light text-dark'
                        ])->label(false)
                        ?>
                    </div>
                    <div class="form-group">
                    <?= Html::submitButton('Send Reset Link', ['class' => 'btn btn-warning w-100']) ?>
                    </div>

<?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <!-- Right Side - Illustration -->
        <div class="col-md-6 login-right">
            <h5>Reset your password easily!</h5>
            <p>Receive an email with a secure link to create a new password.</p>
        </div>
    </div>
</div>
