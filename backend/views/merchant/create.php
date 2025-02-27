<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Merchant $model */

$this->title = 'Create Merchant';
$this->params['breadcrumbs'][] = ['label' => 'Merchants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merchant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
