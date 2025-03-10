<?php

namespace backend\controllers;

use backend\models\Config;
use backend\models\ConfigSearch;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;

class ConfigurationsController extends Controller {

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

    public function actionIndex($name = null) {
        $model = $name ? $this->findModel($name) : new Config();
        $searchModel = new ConfigSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    public function actionCreate() {
        $model = new Config();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Configuration has been created successfully.');
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('danger', 'Configuration already available.');
            return $this->redirect(['index']);
        }
    }

    public function actionUpdate($name) {
        $model = $this->findModel($name);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Configuration has been updated successfully.');
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('danger', 'Configuration already available.');
            return $this->redirect(['index']);
        }
    }

    protected function findModel($name) {
        if (($model = Config::findOne(['name' => $name])) !== null) {
            return $model;
        } else {
            return new Config();
        }
    }
}
