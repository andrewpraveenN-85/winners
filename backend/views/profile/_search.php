<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\ProfileSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="profile-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'middle_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?php // echo $form->field($model, 'sin') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'dob') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'proffetion') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'membership') ?>

    <?php // echo $form->field($model, 'draw_eligible_count') ?>

    <?php // echo $form->field($model, 'shopping_preferences_Behavior') ?>

    <?php // echo $form->field($model, 'favorite_categories') ?>

    <?php // echo $form->field($model, 'reward_participation') ?>

    <?php // echo $form->field($model, 'profile_img') ?>

    <?php // echo $form->field($model, 'qr_img') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
