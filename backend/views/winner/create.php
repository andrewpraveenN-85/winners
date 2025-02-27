<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Winner $model */

$this->title = 'Create Winner';
$this->params['breadcrumbs'][] = ['label' => 'Winners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="winner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
