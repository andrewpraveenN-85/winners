<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel \yii2mod\rbac\models\search\AuthItemSearch */

$labels = $this->context->getLabels();
$this->title = Yii::t('yii2mod.rbac', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">
    <h1><?php echo Html::encode($this->title); ?></h1>
    <p>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
            Create
        </button>
    </p>
    <?php Pjax::begin(['timeout' => 5000, 'enablePushState' => false]); ?>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'label' => Yii::t('yii2mod.rbac', 'Name'),
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{custom1} {custom2}',
                'buttons' => [
                    'custom1' => function ($url, $data, $key) {
                        return Html::a('View', ['view', 'id' => $data->name], ['class' => 'btn btn-primary']);
                    },
                    'custom2' => function ($url, $data, $key) {
                        $modelData = htmlspecialchars(json_encode(['id' => $data->name]), ENT_QUOTES, 'UTF-8');
                        return "<button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#updateModal\" data-model='$modelData'>Update</button>";
                    }
                ],
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php $creatForm = ActiveForm::begin(['action' => ['create'], 'options' => ['enctype' => 'multipart/form-data', 'id' => 'createForm']]); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <?= $creatForm->field($model, 'name')->textInput(['maxlength' => 200, 'class' => 'form-control mb-2']) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success w-100']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php $updateForm = ActiveForm::begin(['action' => ['update'], 'options' => ['enctype' => 'multipart/form-data', 'id' => 'updateForm']]); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <?= $updateForm->field($model, 'name')->textInput(['maxlength' => 200, 'class' => 'form-control mb-2']) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success w-100']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>

<?php
$this->registerJs("
var updateModal = document.getElementById('updateModal');
updateModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var modelData = button.getAttribute('data-model');
    var model = JSON.parse(modelData); // Parse JSON data
    
    // Update the modal title
    var modalTitle = updateModal.querySelector('.modal-title');
    modalTitle.textContent = 'Update Role - ' + model.id;

    // Update the form action dynamically
    var updateForm = updateModal.querySelector('#updateForm');
    updateForm.action = '/permission/update?id=' + model.id;

    // Set the form fields dynamically
    var nameField = updateModal.querySelector('input[name=\"AuthItemModel[name]\"]'); // Adjust the name attribute if different

    if (nameField) nameField.value = model.id;
});
", \yii\web\View::POS_END); // Add at the end of the page
?>