<?php

namespace backend\controllers;

use backend\models\Winners;
use backend\models\WinnersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WinnersController implements the CRUD actions for Winners model.
 */
class WinnersController extends Controller
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
     * Lists all Winners models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WinnersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Winners model.
     * @param int $profile_id Profile ID
     * @param int $gift_id Gift ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($profile_id, $gift_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($profile_id, $gift_id),
        ]);
    }

    /**
     * Creates a new Winners model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Winners();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'profile_id' => $model->profile_id, 'gift_id' => $model->gift_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Winners model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $profile_id Profile ID
     * @param int $gift_id Gift ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($profile_id, $gift_id)
    {
        $model = $this->findModel($profile_id, $gift_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'profile_id' => $model->profile_id, 'gift_id' => $model->gift_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Winners model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $profile_id Profile ID
     * @param int $gift_id Gift ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($profile_id, $gift_id)
    {
        $this->findModel($profile_id, $gift_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Winners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $profile_id Profile ID
     * @param int $gift_id Gift ID
     * @return Winners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($profile_id, $gift_id)
    {
        if (($model = Winners::findOne(['profile_id' => $profile_id, 'gift_id' => $gift_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
