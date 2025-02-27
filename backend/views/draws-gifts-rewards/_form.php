<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\DrawsGiftsRewards $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="draws-gifts-rewards-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'draws_gift_id')->textInput() ?>

    <?= $form->field($model, 'rewards_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
