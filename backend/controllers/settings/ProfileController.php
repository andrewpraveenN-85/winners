<?php

namespace backend\controllers\settings;

use Yii;
use backend\models\User;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii2mod\rbac\filters\AccessControl;

class ProfileController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'allowActions' => [
                    'index',
                    'update'
                ]
            ],
        ];
    }

    public function actionIndex() {
        $model = $this->findModel(Yii::$app->user->id);
        $userRole = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));
        return $this->render('index', [
                    'model' => $model,
                    'userRole' => $userRole
        ]);
    }

    public function actionUpdate() {
        $model = $this->findModel(Yii::$app->user->id);
        $userRole = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));
        if ($userRole === 'Admin') {
            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully.');
                return $this->redirect(['index']);
            }
        } elseif ($userRole === 'Merchant') {
            
        } elseif ($userRole === 'Profile') {
            
        } else {
            return $this->redirect(['index']);
        }
    }

    public function actionImg() {
        $model = $this->findModel(Yii::$app->user->id);
        if (!is_dir(Yii::getAlias('@webroot/storage/' . $model->company_id))) {
            mkdir(Yii::getAlias('@webroot/storage/' . $model->company_id), 0777, true);
        }
        if (!is_dir(Yii::getAlias('@webroot/storage/' . $model->company_id . '/profile_picture'))) {
            mkdir(Yii::getAlias('@webroot/storage/' . $model->company_id . '/profile_picture'), 0777, true);
        }
        if (Yii::$app->request->isPost) {
            if (Yii::$app->request->post('remove_picture') && !empty($model->profile_picture) && file_exists(Yii::getAlias('@webroot/storage/' . $model->company_id . '/profile_picture/' . $model->profile_picture))) {
                unlink(Yii::getAlias('@webroot/storage/' . $model->company_id . '/profile_picture/' . $model->profile_picture));
                $model->profile_picture = null;
            } else {
                $image = UploadedFile::getInstance($model, 'picture');
                if (!empty($image)) {
                    $uploadPath = Yii::getAlias('@webroot/storage/' . $model->company_id . '/profile_picture/') . $model->id . '.' . $image->getExtension();
                    if ($image->saveAs($uploadPath)) {
                        $model->profile_picture = $model->id . '.' . $image->getExtension();
                    }
                }
            }
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Profile picture updated successfully.');
                return $this->redirect(['index']);
            }
        }
    }

    public function actionPassword() {
        $model = $this->findModel(Yii::$app->user->id);
        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->validatePassword($model->password)) {
                $model->setPassword($model->newpassword);
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Profile password updated successfully.');
                    return $this->redirect(['index']);
                }
            }
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
