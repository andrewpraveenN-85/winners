<?php

namespace backend\controllers;

use backend\models\Events;
use backend\models\EventsSearch;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;

class EventsController extends Controller {

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
        $model = $id ? $this->findModel($id) : new Events();
        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    public function actionCreate() {
        $model = new Events();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Member has been created successfully.');
            return $this->redirect(['index']);
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Event has been updated successfully.');
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id) {
        if (($model = Events::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            return new Events();
        }
    }
}
