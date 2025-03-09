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
        <div class="col-md-12 bg-white p-4" style="max-height: 80vh; overflow-y: auto; scrollbar-color: #5C4033 #FFD700; scrollbar-width: thin;">
            <h3 class="text-warning fw-bold text-center">Register</h3>
            <?php $form = ActiveForm::begin(['action' => ['register'], 'options' => ['enctype' => 'multipart/form-data']]); ?>

            <div class="mb-3">
                <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'First name', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'middle_name')->textInput(['placeholder' => 'Middle name', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Last name', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'sin')->textInput(['placeholder' => 'NIC/Driving licence/Passport No', 'maxlength' => 25, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'mobile')->textInput(['placeholder' => 'Contact mobile', 'maxlength' => 15, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?=
                $form->field($model, 'dob')->input('date', [
                    'min' => date('Y-m-d', strtotime('-100 years')),
                    'max' => date('Y-m-d', strtotime('-18 years')),
                    'class' => 'form-control bg-light text-dark',
                    'placeholder' => 'Date of Birth',
                ])
                ?>
            </div>
            <div class="mb-3">
                <?=
                $form->field($model, 'gender')->dropDownList([
                    'Male' => 'Male',
                    'Female' => 'Female',
                    'Other' => 'Other'
                        ], [
                    'prompt' => 'Select Gender',
                    'class' => 'form-control bg-light text-dark'
                ])
                ?>

            </div>

            <div class="mb-3">
                <?= $form->field($model, 'image')->fileInput(['placeholder' => 'Profile image', 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'address')->textInput(['placeholder' => 'Address', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'notes')->textInput(['placeholder' => 'Additional notes', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
            </div>

            <div class="mb-3">
                <?=
                $form->field($model, 'password', [
                    'template' => '{label}<div class="input-group">{input}
                            <button type="button" class="btn btn-outline-secondary toggle-password"><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn btn-outline-secondary" id="generate-password" ><i class="fa fa-key"></i></button>
                            {error}</div>',
                ])->passwordInput(['placeholder' => 'Password', 'id' => 'password'])
                ?>
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
            <?=
            $form->field($model, 'dor', ['template' => '{input}'])->hiddenInput([
                'value' => date('Y-m-d'), // Set default value if needed
            ])->label(false)
            ?>

            <?php ActiveForm::end(); ?>
        </div>

        <!-- Right: Logo -->
        <!--        <div class="col-md-6 login-right d-flex align-items-center justify-content-center">
                    <img src="/media/logo.png" width="300px" alt="Logo"/>
                </div>-->
    </div>
</div>
<?php
$this->registerJs("
    $(document).ready(function() {
        document.getElementById('generate-password').addEventListener('click', function() {
            let charset = \"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+\";
            let password = \"\";
            for (let i = 0; i < 12; i++) {
                password += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            document.getElementById('password').value = password;
        });
        document.querySelectorAll(\".toggle-password\").forEach(button => {
            button.addEventListener(\"click\", function () {
                let input = this.closest(\".input-group\").querySelector(\"input\");
                let icon = this.querySelector(\"i\");

                if (input.type === \"password\") {
                    input.type = \"text\";
                    icon.classList.remove(\"fa-eye\");
                    icon.classList.add(\"fa-eye-slash\");
                } else {
                    input.type = \"password\";
                    icon.classList.remove(\"fa-eye-slash\");
                    icon.classList.add(\"fa-eye\");
                }
            });
       });
    });
", \yii\web\View::POS_END);
?>