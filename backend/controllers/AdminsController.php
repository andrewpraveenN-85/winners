<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;

class AdminsController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'allowActions' => [
                    'index',
                    'create',
                    'update'
                ]
            ],
        ];
    }

    public function actionIndex($id = null) {
        $model = $id ? $this->findModel($id) : new User();
        if(!$id){$model->scenario = User::SCENARIO_ADMIN;}
        $searchModel = new UserSearch(['role' => 'Admin']);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    public function actionCreate() {
        $model = new User();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $this->assignAdminRole($model);
            Yii::$app->session->setFlash('success', 'Admin has been created successfully.');
            return $this->redirect(['index']);
        }
    }

    private function assignAdminRole($model) {
        $auth = Yii::$app->authManager;
        $item = $auth->getRole('Admin');
        $auth->assign($item, $model->id);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Admin has been updated successfully.');
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id) {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            return new User();
        }
    }
}
