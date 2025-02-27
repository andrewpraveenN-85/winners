<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\DrawsGifts $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="draws-gifts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'draws_id')->textInput() ?>

    <?= $form->field($model, 'gift_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
