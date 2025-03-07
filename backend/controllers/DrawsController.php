<?php

namespace backend\controllers;

use backend\models\Draws;
use backend\models\DrawsSearch;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;
use backend\models\Packages;
use yii\helpers\ArrayHelper;

class DrawsController extends Controller {

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
        $model = $id ? $this->findModel($id) : new Draws();
        $searchModel = new DrawsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $packages = ArrayHelper::map(Packages::find()->andWhere(['status' => 10])->all(), 'id', 'name');
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'packages' => $packages,
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
        if (($model = Draws::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            return new Draws();
        }
    }
}
