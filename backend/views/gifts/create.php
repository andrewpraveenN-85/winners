<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Gifts $model */

$this->title = 'Create Gifts';
$this->params['breadcrumbs'][] = ['label' => 'Gifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gifts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
