<?php

namespace backend\controllers;

use backend\models\Memberships;
use backend\models\MembershipsSearch;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;
use yii\helpers\ArrayHelper;
use Yii;
use backend\models\Profiles;
use backend\models\Packages;
use backend\models\User;

/**
 * MembershipsController implements the CRUD actions for Memberships model.
 */
class MembershipsController extends Controller {

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

    public function actionIndex($profile_id = null, $package_id = null) {
        if ($profile_id && $package_id) {
            $model = $this->findModel($profile_id, $package_id);
        } else {
            $model = new Memberships();
        }
        $searchModel = new MembershipsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $packages = ArrayHelper::map(Packages::find()->andWhere(['status' => 10])->all(), 'id', 'name');
        $profiles = Profiles::find()
                ->select(['profiles.id', "CONCAT(profiles.first_name, ' ', profiles.last_name) AS full_name"])
                ->innerJoinWith(['user' => function ($query) {
                        $query->from(['user' => User::tableName()])
                                ->andWhere(['user.status' => 10]); // Filter users with status 10
                    }], false) // The `false` prevents Yii from auto-selecting `user.*`
                ->asArray()
                ->all();
        $profilesList = ArrayHelper::map($profiles, 'id', 'full_name');
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'packages' => $packages,
                    'members' => $profilesList,
                    'model' => $model,
        ]);
    }

    public function actionCreate() {
        $model = new Memberships();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Membership has been created successfully.');
            return $this->redirect(['index']);
        }
    }

    public function actionUpdate($profile_id, $package_id) {
        $model = $this->findModel($profile_id, $package_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Membership has been updated successfully.');
            return $this->redirect(['index']);
        }
    }

    protected function findModel($profile_id, $package_id) {
        if (($model = Memberships::findOne(['profile_id' => $profile_id, 'package_id' => $package_id])) !== null) {
            return $model;
        } else {
            return new Memberships();
        }
    }
}
