<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\Profiles;
use backend\models\ProfilesSearch;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;
use backend\models\Register;

class MembersController extends Controller {

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
        $model = $id ? $this->findModel($id) : new Profiles();
        $model->status = $id ? $model->user->status : NULL;
        $model->email = $id ? $model->user->email : NULL;
        $searchModel = new ProfilesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

//    public function actionCreate() {
//        $model = new Profiles();
//
//        if ($this->request->isPost && $model->load($this->request->post())) {
//            $userId = $this->createUserAndSave($model);
//            if ($userId) {
//                $this->assignRoleToUser($userId);
//                Yii::$app->session->setFlash('success', 'Member has been created successfully.');
//                return $this->redirect(['index']);
//            }
//        }
//    }
//
//    private function createUserAndSave($model) {
//        $userId = $model->createUser();
//        if ($userId) {
//            $model->user_id = $userId;
//            if ($model->save()) {
//                return $userId;
//            }
//        }
//        return false;
//    }
//
//    private function assignRoleToUser($userId) {
//        $auth = Yii::$app->authManager;
//        $item = $auth->getRole('Profile');
//        $auth->assign($item, $userId);
//    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $this->updateUserAndSave($model) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Member has been updated successfully.');
            return $this->redirect(['index']);
        }else{
            print_r($model->getErrors());
        }
    }

    private function updateUserAndSave($model) {
        $user = $this->findUserModel($model->user_id);
        $user->email = $model->email;
        return $user->save(false);
    }

    protected function findModel($id) {
        if (($model = Profiles::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            return new Profiles();
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
