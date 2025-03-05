<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Draws $model */

$this->title = 'Create Draws';
$this->params['breadcrumbs'][] = ['label' => 'Draws', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draws-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
