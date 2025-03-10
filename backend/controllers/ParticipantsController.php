<?php

namespace backend\controllers;

use backend\models\Activity;
use backend\models\ActivitySearch;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;
use yii\helpers\ArrayHelper;
use Yii;
use backend\models\Events;
use backend\models\Profiles;
use backend\models\Memberships;

/**
 * MembershipsController implements the CRUD actions for Memberships model.
 */
class ParticipantsController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'allowActions' => [
                    'index',
                    'create',
                    'update',
                    'get-profiles',
                    'delete'
                ]
            ],
        ];
    }

    public function actionIndex($profile_id = null, $event_id = null) {
        if ($profile_id && $event_id) {
            $model = $this->findModel($profile_id, $event_id);
            $profiles = Memberships::find()
                    ->select(['profiles.id', "CONCAT(profiles.first_name, ' ', profiles.last_name) AS full_name"])
                    ->innerJoin('profiles', 'profiles.id = memberships.profile_id')
                    ->where(['memberships.status' => 10, 'memberships.package_id' => $model->event->package_id])
                    ->asArray()
                    ->all();
        } else {
            $model = new Activity();
            $profiles = Profiles::find()
                    ->select(['profiles.id', "CONCAT(profiles.first_name, ' ', profiles.last_name) AS full_name"])
                    ->asArray()
                    ->all();
        }
        $profilesList = ArrayHelper::map($profiles, 'id', 'full_name');
        $searchModel = new ActivitySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $events = ArrayHelper::map(Events::find()->andWhere(['status' => 10])->all(), 'id', 'name');

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'events' => $events,
                    'members' => $profilesList,
                    'model' => $model,
        ]);
    }

    public function actionGetProfiles($event) {
        $model = Events::findOne(['id' => $event]);
        $profiles = Memberships::find()
                ->select(['profiles.id', "CONCAT(profiles.first_name, ' ', profiles.last_name) AS full_name"])
                ->innerJoin('profiles', 'profiles.id = memberships.profile_id')
                ->where(['memberships.status' => 10, 'memberships.package_id' => $model->package_id])
                ->asArray()
                ->all();
        $options = "<option value=''>Select...</option>";
        $profilesList = ArrayHelper::map($profiles, 'id', 'full_name');
        foreach ($profilesList as $value => $key) {
            $options .= "<option value='" . $value . "'>" . htmlspecialchars($key) . "</option>";
        }
        return json_encode($options);
    }

    public function actionCreate() {
        $model = new Activity();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->session->setFlash('success', 'Event participant has been created successfully.');
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('danger', 'Event participant already available.');
            return $this->redirect(['index']);
        }
    }

    public function actionUpdate($profile_id, $event_id) {
        $model = $this->findModel($profile_id, $event_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Event participant has been updated successfully.');
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('danger', 'Event participant already available.');
            return $this->redirect(['index']);
        }
    }

    public function actionDelete($profile_id, $event_id) {
        $this->findModel($profile_id, $event_id)->delete();
        return $this->redirect(['index']);
    } 

    protected function findModel($profile_id, $event_id) {
        if (($model = Activity::findOne(['profile_id' => $profile_id, 'event_id' => $event_id])) !== null) {
            return $model;
        } else {
            return new Activity();
        }
    }
}
