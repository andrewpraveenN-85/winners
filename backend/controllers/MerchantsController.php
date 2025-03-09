<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\Merchants;
use backend\models\MerchantsSearch;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;

class MerchantsController extends Controller {

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
        $model = $id ? $this->findModel($id) : new Merchants();
        $model->status = $id ? $model->user->status : NULL;
        $model->email = $id ? $model->user->email : NULL;
        $searchModel = new MerchantsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    public function actionCreate() {
        $model = new Merchants();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $userId = $this->createUserAndSave($model);
            if ($userId) {
                $this->assignRoleToUser($userId);
                Yii::$app->session->setFlash('success', 'Merchant has been created successfully.');
                return $this->redirect(['index']);
            }
        }
    }

    private function createUserAndSave($model) {
        $userId = $model->createUser();
        if ($userId) {
            $model->user_id = $userId;
            if ($model->save()) {
                return $userId;
            }
        }
        return false;
    }

    private function assignRoleToUser($userId) {
        $auth = Yii::$app->authManager;
        $item = $auth->getRole('Merchant');
        $auth->assign($item, $userId);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $this->updateUserAndSave($model) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Merchant has been updated successfully.');
            return $this->redirect(['index']);
        }
    }

    private function updateUserAndSave($model) {
        $user = $this->findUserModel($model->user_id);
        $user->email = $model->email;
        $user->status = $model->status;
        return $user->save(false);
    }

    protected function findModel($id) {
        if (($model = Merchants::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            return new Merchants();
        }
    }

    protected function findUserModel($id) {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            return new User();
        }
    }
}
