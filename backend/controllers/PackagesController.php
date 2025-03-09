<?php

namespace backend\controllers;

use Yii;
use backend\models\Packages;
use backend\models\PackagesSearch;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;
use backend\models\MerchantsSearch;
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
            $this->clearExistingOffers($model->id);
            $this->processMerchants($model);
            Yii::$app->session->setFlash('success', 'Package has been created successfully.');
            return $this->redirect(['index']);
        }
    }

    private function clearExistingOffers($packageId) {
        Offers::deleteAll(['package_id' => $packageId]);
    }

    private function processMerchants($model) {
        if ($model->merchants) {
            $merchantsArray = explode(',', $model->merchants);
            foreach ($merchantsArray as $offer) {
                $this->createOffer($offer, $model->id);
            }
        }
    }

    private function createOffer($offer, $packageId) {
        $parts = explode('-', $offer);
        $offers = new Offers();
        $offers->merchant_id = $parts[0];
        $offers->package_id = $packageId;
        $offers->discount = $parts[1];
        $offers->save();
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $this->clearExistingOffers($id);
            $this->processMerchants($model);
            Yii::$app->session->setFlash('success', 'Package has been updated successfully.');
            return $this->redirect(['index']);
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
