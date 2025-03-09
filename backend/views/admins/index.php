<?php

use backend\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Admins';
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
            Create
        </button>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'email:email',
            [
                'attribute' => 'status',
                'value' => 'statusText',
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        [
                            User::STATUS_ACTIVE => 'Active',
                            User::STATUS_INACTIVE => 'Inactive',
                            User::STATUS_DELETED => 'Deleted',
                        ],
                        ['class' => 'form-control', 'prompt' => 'Select']
                ),
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{custom}',
                'buttons' => [
                    'custom' => function ($url, $data, $key) {
                        return Html::a(
                                'Update',
                                ['index', 'id' => $data->id],
                                [
                                    'class' => 'btn btn-primary',
                                    'data' => [
                                        'pjax' => 0, // Ensure a full page load instead of PJAX.
                                    ],
                                ]
                        );
                    },
                ],
            ],
        ],
    ]);
    ?>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <?php if ($model->isNewRecord) { ?>
                    <?php $form = ActiveForm::begin(['action' => ['create'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?php } else { ?>
                    <?php $form = ActiveForm::begin(['action' => ['update', 'id' => $model->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?php } ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $model->isNewRecord ? 'Create Admin' : 'Update Admin - ' . Html::encode($model->email) ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <?= $form->field($model, 'email')->textInput(['maxlength' => 200, 'class' => 'form-control mb-2']) ?>
                    </div>
                    <?php if ($model->isNewRecord) { ?>
                        <div class="mb-3">
                            <?=
                            $form->field($model, 'password', [
                                'template' => '{label}<div class="input-group">{input}
                            <button type="button" class="btn btn-outline-secondary toggle-password"><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn btn-outline-secondary" id="generate-password" ><i class="fa fa-key"></i></button>
                            {error}</div>',
                            ])->passwordInput(['placeholder' => 'Password', 'id' => 'password'])
                            ?>
                        </div>
                    <?php } ?>
                    <div class="mb-3">
                        <?= $form->field($model, 'status')->dropDownList([0 => 'Deleted', 9 => 'Inactive', 10 => 'Active'], ['class' => 'form-control mb-2', 'prompt' => 'Select',]) ?>
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
    $(document).ready(function() {
        if ('" . Yii::$app->request->get('id') . "') {
            $('#modal').modal('show');
        }
        var myModalEl = document.getElementById('modal');
        myModalEl.addEventListener('hidden.bs.modal', function (event) {
            window.location.href = '/settings/admins'; // Replace '/index' with the actual route to your index page.
        });
        document.getElementById('generate-password').addEventListener('click', function() {
            let charset = \"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+\";
            let password = \"\";
            for (let i = 0; i < 12; i++) {
                password += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            document.getElementById('password').value = password;
        });
        document.querySelectorAll(\".toggle-password\").forEach(button => {
            button.addEventListener(\"click\", function () {
                let input = this.closest(\".input-group\").querySelector(\"input\");
                let icon = this.querySelector(\"i\");

                if (input.type === \"password\") {
                    input.type = \"text\";
                    icon.classList.remove(\"fa-eye\");
                    icon.classList.add(\"fa-eye-slash\");
                } else {
                    input.type = \"password\";
                    icon.classList.remove(\"fa-eye-slash\");
                    icon.classList.add(\"fa-eye\");
                }
            });
       });
    });
", \yii\web\View::POS_END); // Add at the end of the page
?>