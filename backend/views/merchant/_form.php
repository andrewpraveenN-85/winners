<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Merchant $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="merchant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'bussiness_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'owner_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'owner_contact_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manager_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manager_contact_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'business_category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bussiness_logo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qr_img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
