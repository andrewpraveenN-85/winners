<?php

namespace backend\controllers;

use backend\models\Activity;
use backend\models\ActivitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends Controller
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
     * Lists all Activity models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ActivitySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Activity model.
     * @param int $profile_id Profile ID
     * @param int $event_id Event ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($profile_id, $event_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($profile_id, $event_id),
        ]);
    }

    /**
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Activity();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'profile_id' => $model->profile_id, 'event_id' => $model->event_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $profile_id Profile ID
     * @param int $event_id Event ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($profile_id, $event_id)
    {
        $model = $this->findModel($profile_id, $event_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'profile_id' => $model->profile_id, 'event_id' => $model->event_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $profile_id Profile ID
     * @param int $event_id Event ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($profile_id, $event_id)
    {
        $this->findModel($profile_id, $event_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $profile_id Profile ID
     * @param int $event_id Event ID
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($profile_id, $event_id)
    {
        if (($model = Activity::findOne(['profile_id' => $profile_id, 'event_id' => $event_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
