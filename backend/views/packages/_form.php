<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Packages $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="packages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'duration')->dropDownList([ 'monthly' => 'Monthly', 'yearly' => 'Yearly', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'entry_point')->textInput() ?>

    <?= $form->field($model, 'smart_saving_events')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
