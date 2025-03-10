<?php

namespace backend\controllers;

use Yii;
use backend\models\Packages;
use backend\models\PackagesSearch;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;
use yii\web\UploadedFile;
use backend\models\Offers;

class PackagesController extends Controller {

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
        $model = $id ? $this->findModel($id) : new Packages();
        $searchModel = new PackagesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model
        ]);
    }

    public function actionCreate() {
        $model = new Packages();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $imageName = $model->id . "_Image";
            $image = UploadedFile::getInstance($model, 'image');
            if (!empty($image)) {
                $upload = Yii::$app->params['uploadPathIMG'] . 'packages/' . $imageName . '.' . $image->getExtension();
                $image->saveAs($upload);
                $model->img = $imageName . '.' . $image->getExtension();
            }
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Package has been created successfully.');
                return $this->redirect(['index']);
            }
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            if ($model->img && file_exists(Yii::getAlias('@webroot/uploads/packages' . $model->img))) {
                unlink(Yii::getAlias('@webroot/uploads/packages/' . $model->img));
            }
            $imageName = $id . "_Image";
            $image = UploadedFile::getInstance($model, 'image');
            if (!empty($image)) {
                $upload = Yii::$app->params['uploadPathIMG'] . 'packages/' . $imageName . '.' . $image->getExtension();
                $image->saveAs($upload);
                $model->img = $imageName . '.' . $image->getExtension();
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Package has been updated successfully.');
                return $this->redirect(['index']);
            }
        }
    }

    protected function findModel($id) {
        if (($model = Packages::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            return new Packages();
        }
    }
}
