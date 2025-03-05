<?php

namespace backend\controllers;

use backend\models\Memberships;
use backend\models\MembershipsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MembershipsController implements the CRUD actions for Memberships model.
 */
class MembershipsController extends Controller
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
     * Lists all Memberships models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MembershipsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Memberships model.
     * @param int $profile_id Profile ID
     * @param int $package_id Package ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($profile_id, $package_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($profile_id, $package_id),
        ]);
    }

    /**
     * Creates a new Memberships model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Memberships();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'profile_id' => $model->profile_id, 'package_id' => $model->package_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Memberships model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $profile_id Profile ID
     * @param int $package_id Package ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($profile_id, $package_id)
    {
        $model = $this->findModel($profile_id, $package_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'profile_id' => $model->profile_id, 'package_id' => $model->package_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Memberships model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $profile_id Profile ID
     * @param int $package_id Package ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($profile_id, $package_id)
    {
        $this->findModel($profile_id, $package_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Memberships model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $profile_id Profile ID
     * @param int $package_id Package ID
     * @return Memberships the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($profile_id, $package_id)
    {
        if (($model = Memberships::findOne(['profile_id' => $profile_id, 'package_id' => $package_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
