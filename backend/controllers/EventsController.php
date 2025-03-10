<?php

namespace backend\controllers;

use Yii;
use backend\models\Events;
use backend\models\EventsSearch;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use backend\models\Packages;

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
        $packages = ArrayHelper::map(Packages::find()->andWhere(['status' => 10])->all(), 'id', 'name');
        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

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
            $imageName = $model->id . "_Image";
            $image = UploadedFile::getInstance($model, 'image');
            if (!empty($image)) {
                $upload = Yii::$app->params['uploadPathIMG'] . 'events/' . $imageName . '.' . $image->getExtension();
                $image->saveAs($upload);
                $model->img = $imageName . '.' . $image->getExtension();
            }
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Event has been created successfully.');
                return $this->redirect(['index']);
            }
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->img && file_exists(Yii::getAlias('@webroot/uploads/events' . $model->img))) {
                unlink(Yii::getAlias('@webroot/uploads/events/' . $model->img));
            }
            $imageName = $id . "_Image";
            $image = UploadedFile::getInstance($model, 'image');
            if (!empty($image)) {
                $upload = Yii::$app->params['uploadPathIMG'] . 'events/' . $imageName . '.' . $image->getExtension();
                $image->saveAs($upload);
                $model->img = $imageName . '.' . $image->getExtension();
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Event has been updated successfully.');
                return $this->redirect(['index']);
            }
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
