<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Draws $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="draws-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'package_id')->textInput() ?>

    <?= $form->field($model, 'date_time')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
