<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Rewards $model */

$this->title = 'Create Rewards';
$this->params['breadcrumbs'][] = ['label' => 'Rewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rewards-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
