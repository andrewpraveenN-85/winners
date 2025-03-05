<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Winners $model */

$this->title = 'Update Winners: ' . $model->profile_id;
$this->params['breadcrumbs'][] = ['label' => 'Winners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->profile_id, 'url' => ['view', 'profile_id' => $model->profile_id, 'gift_id' => $model->gift_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="winners-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
