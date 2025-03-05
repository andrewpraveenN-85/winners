<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Offers $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="offers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'package_id')->textInput() ?>

    <?= $form->field($model, 'merchant_id')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
