<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\DrawsGifts $model */

$this->title = 'Create Draws Gifts';
$this->params['breadcrumbs'][] = ['label' => 'Draws Gifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draws-gifts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
