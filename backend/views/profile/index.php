<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\DetailView;

if ($userRole === 'Admin') {
    $this->title = $model->email;
} elseif ($userRole === 'Merchant') {
    
} elseif ($userRole === 'Profile') {
    $this->title = $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name;
} else {
    $this->title = "Not loaded!";
}
$this->params['breadcrumbs'][] = 'Profile';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-index">

    <?php if ($userRole === 'Admin') { ?>
        <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                Update
            </button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                Password
            </button>
        </p>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'email:email',
                'created_at:datetime',
                'updated_at:datetime'
            ],
        ])
        ?>
    <?php } elseif ($userRole === 'Merchant') { ?>

        <div class="modal fade" id="editPictureModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <?php $formProfilePicture = ActiveForm::begin(['action' => ['picture'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 text-center">
                            <div class="position-relative d-inline-block overflow-hidden" style="height: 230px;">
                                <?= Html::img($model->imgURL, ['class' => 'img-fluid', 'style' => 'height:230px;']); ?>
                                <div class="profile-hover-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                    <label for="profile-upload" class="position-absolute text-white d-flex align-items-center justify-content-center"
                                           style="width: 230px; height: 230px; cursor: pointer;">
                                    </label>
                                    <?= $formProfilePicture->field($model, 'image')->fileInput(['id' => 'profile-upload', 'class' => 'd-none', 'onchange' => 'this.form.submit();'])->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?php if (!empty($model->imgUrl)): ?>
                            <button type="submit" name="remove_picture" value="1" class="btn btn-danger btn-sm mt-2">Remove</button>
                        <?php endif; ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

    <?php } elseif ($userRole === 'Profile') { ?>
        <div class="row">
            <div class="col-3">
                <p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPictureModal">
                        Update
                    </button> 
                </p>
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => '',
                            'format' => ['html'],
                            'value' => Html::img($model->imgURL, ['class' => 'img-fluid', 'style' => 'height:230px;'])
                        ],
                    ],
                ])
                ?>
            </div>
            <div class="col-9">
                <p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        Update
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        Password
                    </button>
                </p>
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => 'Full Name',
                            'format' => ['html'],
                            'value' => $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name
                        ],
                        'sin',
                        'email:email',
                        'mobile',
                        'address',
                        'dob',
                        'gender',
                        'dor',
                        'notes',
                        'created_at:datetime',
                        'updated_at:datetime'
                    ],
                ])
                ?>
            </div>
        </div>

        <div class="modal fade" id="editPictureModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <?php $formProfilePicture = ActiveForm::begin(['action' => ['picture'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 text-center">
                            <div class="position-relative d-inline-block overflow-hidden" style="height: 230px;">
                                <?= Html::img($model->imgURL, ['class' => 'img-fluid', 'style' => 'height:230px;']); ?>
                                <div class="profile-hover-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                    <label for="profile-upload" class="position-absolute text-white d-flex align-items-center justify-content-center"
                                           style="width: 230px; height: 230px; cursor: pointer;">
                                    </label>
                                    <?= $formProfilePicture->field($model, 'image')->fileInput(['id' => 'profile-upload', 'class' => 'd-none', 'onchange' => 'this.form.submit();'])->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?php if (!empty($model->imgUrl)): ?>
                            <button type="submit" name="remove_picture" value="1" class="btn btn-danger btn-sm mt-2">Remove</button>
                        <?php endif; ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <?php
    } else {
        echo "Not loaded!";
    }
    ?>

    <div class="modal fade" id="editProfileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <?php if ($userRole === 'Admin') { ?>
            <div class="modal-dialog modal-dialog-centered">
            <?php } else { ?>
                <div class="modal-dialog modal-dialog-centered modal-lg ">
                <?php } ?>
                <div class="modal-content">
                    <?php $formProfile = ActiveForm::begin(['action' => ['update']]); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <?php if ($userRole === 'Admin') { ?>
                            <div class="mb-3">
                                <?= $formProfile->field($model, 'email')->input('email', ['maxlength' => 255, 'placeholder' => 'Email address']) ?>
                            </div>
                        <?php } elseif ($userRole === 'Merchant') { ?>

                        <?php } elseif ($userRole === 'Profile') { ?>
                            <div class="mb-3">
                                <?= $formProfile->field($model, 'first_name')->textInput(['placeholder' => 'First name', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
                            </div>

                            <div class="mb-3">
                                <?= $formProfile->field($model, 'middle_name')->textInput(['placeholder' => 'Middle name', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
                            </div>

                            <div class="mb-3">
                                <?= $formProfile->field($model, 'last_name')->textInput(['placeholder' => 'Last name', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
                            </div>

                            <div class="mb-3">
                                <?= $formProfile->field($model, 'sin')->textInput(['placeholder' => 'NIC/Driving licence/Passport No', 'maxlength' => 25, 'class' => 'form-control bg-light text-dark']) ?>
                            </div>

                            <div class="mb-3">
                                <?= $formProfile->field($model, 'email')->textInput(['placeholder' => 'Email', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
                            </div>

                            <div class="mb-3">
                                <?= $formProfile->field($model, 'mobile')->textInput(['placeholder' => 'Contact mobile', 'maxlength' => 15, 'class' => 'form-control bg-light text-dark']) ?>
                            </div>

                            <div class="mb-3">
                                <?=
                                $formProfile->field($model, 'dob')->input('date', [
                                    'min' => date('Y-m-d', strtotime('-100 years')),
                                    'max' => date('Y-m-d', strtotime('-18 years')),
                                    'class' => 'form-control bg-light text-dark',
                                    'id' => 'dob-field'
                                ])
                                ?>
                            </div>
                            <div class = "mb-3">
                                <?=
                                $formProfile->field($model, 'gender')->dropDownList([
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
                                <?= $formProfile->field($model, 'address')->textInput(['placeholder' => 'Address', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
                            </div>

                            <div class="mb-3">
                                <?= $formProfile->field($model, 'notes')->textInput(['placeholder' => 'Additional notes', 'maxlength' => 200, 'class' => 'form-control bg-light text-dark']) ?>
                            </div>
                            <?php
                        } else {
                            echo "Not loaded!";
                        }
                        ?>
                    </div>  
                    <div class="modal-footer">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <?php $formPassword = ActiveForm::begin(['action' => ['password']]); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <?=
                            $formPassword->field($passwordmodel, 'password', [
                                'template' => '{label}<div class="input-group">{input}
                            <button type="button" class="btn btn-outline-secondary toggle-password"><i class="fa fa-eye"></i></button>
                            {error}</div>',
                            ])->passwordInput(['placeholder' => 'Current Password', 'id' => 'current-password'])
                            ?>
                        </div>
                        <div class="mb-3">
                            <?=
                            $formPassword->field($passwordmodel, 'newpassword', [
                                'template' => '{label}<div class="input-group">{input}
                            <button type="button" class="btn btn-outline-secondary toggle-password"><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn btn-outline-secondary" id="generate-password" ><i class="fa fa-key"></i></button>
                            {error}</div>',
                            ])->passwordInput(['placeholder' => 'New Password', 'id' => 'new-password'])
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
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
            document.getElementById('new-password').value = password;
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
