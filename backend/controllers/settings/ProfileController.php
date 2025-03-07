<?php

namespace backend\controllers\settings;

use Yii;
use backend\models\User;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii2mod\rbac\filters\AccessControl;
use backend\models\Profiles;

class ProfileController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'allowActions' => [
                    'index',
                    'update',
                    'picture',
                    'password'
                ]
            ],
        ];
    }

    public function actionIndex() {
        $userRole = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));
        $passwordmodel = $this->findModel(Yii::$app->user->id);
        if ($userRole === 'Admin') {
            $model = $this->findModel(Yii::$app->user->id);
        } elseif ($userRole === 'Merchant') {
            
        } elseif ($userRole === 'Profile') {
            $model = Profiles::find()->where(['user_id' => Yii::$app->user->id])->one();
            $model->email = $passwordmodel->email;
            $model->status = $passwordmodel->status;
        } else {
            
        }

        return $this->render('index', [
                    'model' => $model,
                    'userRole' => $userRole,
                    'passwordmodel' => $passwordmodel
        ]);
    }

    public function actionUpdate() {

        $userRole = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));
        if ($userRole === 'Admin') {
            $model = $this->findModel(Yii::$app->user->id);
            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully.');
                return $this->redirect(['index']);
            }
        } elseif ($userRole === 'Merchant') {
            
        } elseif ($userRole === 'Profile') {
            $model = Profiles::find()->where(['user_id' => Yii::$app->user->id])->one();
            $model->status = 10;
            if ($this->request->isPost && $model->load($this->request->post()) && $this->updateUserAndSave($model) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully.');
                return $this->redirect(['index']);
            } else {
                print_r($model->getErrors());
            }
        } else {
            return $this->redirect(['index']);
        }
    }

    private function updateUserAndSave($model) {
        $user = $this->findModel(Yii::$app->user->id);
        $user->email = $model->email;
        return $user->save(false);
    }

    public function actionPicture() {
        $model = Profiles::find()->where(['user_id' => Yii::$app->user->id])->one();
        if (Yii::$app->request->isPost) {
            if (Yii::$app->request->post('remove_picture') && !empty($model->img) && file_exists(Yii::getAlias('@webroot/uploads/profile' . $model->img))) {
                unlink(Yii::getAlias('@webroot/uploads/profile/' . $model->img));
                $model->img = null;
            } else {
                $image = UploadedFile::getInstance($model, 'image');
                if (!empty($image)) {
                    $uploadPath = Yii::getAlias('@webroot/uploads/profile/') . $model->id . "_Image" . '.' . $image->getExtension();
                    if ($image->saveAs($uploadPath)) {
                        $model->img = $model->id . "_Image" . '.' . $image->getExtension();
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
                    Yii::$app->session->setFlash('success', 'Password updated successfully.');
                    return $this->redirect(['index']);
                }
            }
        }
    }

    protected function findProfileModel($id) {
        if (($model = Profiles::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            return new Profiles();
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
