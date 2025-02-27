<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\MerchantSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="merchant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'bussiness_name') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'owner_name') ?>

    <?php // echo $form->field($model, 'owner_contact_no') ?>

    <?php // echo $form->field($model, 'manager_name') ?>

    <?php // echo $form->field($model, 'manager_contact_no') ?>

    <?php // echo $form->field($model, 'business_category') ?>

    <?php // echo $form->field($model, 'bussiness_logo') ?>

    <?php // echo $form->field($model, 'qr_img') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
