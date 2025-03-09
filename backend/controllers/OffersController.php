<?php

namespace backend\controllers;

use Yii;
use yii2mod\rbac\filters\AccessControl;
use backend\models\Offers;
use backend\models\OffersSearch;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use backend\models\Merchants;
use backend\models\Packages;
use backend\models\User;
use yii\web\UploadedFile;

class OffersController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'allowActions' => [
                    'index',
                    'create',
                    'update',
                    'delete'
                ]
            ],
        ];
    }

    public function actionIndex($package_id = null, $merchant_id = null) {
        if ($merchant_id && $package_id) {
            $model = $this->findModel($package_id, $merchant_id);
        } else {
            $model = new Offers();
        }
        $packages = ArrayHelper::map(Packages::find()->andWhere(['status' => 10])->all(), 'id', 'name');
        $merchants = Merchants::find()
                ->select(['merchants.id', "merchants.bussiness_name"])
                ->innerJoinWith(['user' => function ($query) {
                        $query->from(['user' => User::tableName()])
                                ->andWhere(['user.status' => 10]); // Filter users with status 10
                    }], false) // The `false` prevents Yii from auto-selecting `user.*`
                ->asArray()
                ->all();
        $merchantsList = ArrayHelper::map($merchants, 'id', 'bussiness_name');
        $searchModel = new OffersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'packages' => $packages,
                    'merchants' => $merchantsList,
                    'model' => $model,
        ]);
    }

    public function actionCreate() {
        $model = new Offers();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $imageName = 'P_' . $model->package_id . '_M_' . $model->merchant_id . "_Image";
            $image = UploadedFile::getInstance($model, 'image');
            if (!empty($image)) {
                $upload = Yii::$app->params['uploadPathIMG'] . 'offers/' . $imageName . '.' . $image->getExtension();
                $image->saveAs($upload);
                $model->img = $imageName . '.' . $image->getExtension();
            }
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Offer has been created successfully.');
                return $this->redirect(['index']);
            }
        }
    }

    public function actionUpdate($package_id, $merchant_id) {
        $model = $this->findModel($package_id, $merchant_id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->img && file_exists(Yii::getAlias('@webroot/uploads/offers' . $model->img))) {
                unlink(Yii::getAlias('@webroot/uploads/offers/' . $model->img));
            }
            $imageName = 'P_' . $package_id . '_M_' . $merchant_id . "_Image";
            $image = UploadedFile::getInstance($model, 'image');
            if (!empty($image)) {
                $upload = Yii::$app->params['uploadPathIMG'] . 'offers/' . $imageName . '.' . $image->getExtension();
                $image->saveAs($upload);
                $model->img = $imageName . '.' . $image->getExtension();
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Offer has been updated successfully.');
                return $this->redirect(['index']);
            }
        }
    }

    public function actionDelete($package_id, $merchant_id) {
        $model = $this->findModel($package_id, $merchant_id);
        if ($model->img && file_exists(Yii::getAlias('@webroot/uploads/offers' . $model->img))) {
            unlink(Yii::getAlias('@webroot/uploads/offers/' . $model->img));
        }
        $model->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($package_id, $merchant_id) {
        if (($model = Offers::findOne(['package_id' => $package_id, 'merchant_id' => $merchant_id])) !== null) {
            return $model;
        } else {
            return new Offers;
        }
    }
}
