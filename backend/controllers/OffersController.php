<?php

namespace backend\controllers;

use backend\models\Offers;
use backend\models\OffersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OffersController implements the CRUD actions for Offers model.
 */
class OffersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Offers models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OffersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Offers model.
     * @param int $package_id Package ID
     * @param int $merchant_id Merchant ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($package_id, $merchant_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($package_id, $merchant_id),
        ]);
    }

    /**
     * Creates a new Offers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Offers();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'package_id' => $model->package_id, 'merchant_id' => $model->merchant_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Offers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $package_id Package ID
     * @param int $merchant_id Merchant ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($package_id, $merchant_id)
    {
        $model = $this->findModel($package_id, $merchant_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'package_id' => $model->package_id, 'merchant_id' => $model->merchant_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Offers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $package_id Package ID
     * @param int $merchant_id Merchant ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($package_id, $merchant_id)
    {
        $this->findModel($package_id, $merchant_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Offers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $package_id Package ID
     * @param int $merchant_id Merchant ID
     * @return Offers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($package_id, $merchant_id)
    {
        if (($model = Offers::findOne(['package_id' => $package_id, 'merchant_id' => $merchant_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
