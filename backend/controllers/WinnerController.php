<?php

namespace backend\controllers;

use backend\models\Winner;
use backend\models\WinnerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WinnerController implements the CRUD actions for Winner model.
 */
class WinnerController extends Controller
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
     * Lists all Winner models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WinnerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Winner model.
     * @param int $profile_id Profile ID
     * @param int $draws_gifts_id Draws Gifts ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($profile_id, $draws_gifts_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($profile_id, $draws_gifts_id),
        ]);
    }

    /**
     * Creates a new Winner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Winner();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'profile_id' => $model->profile_id, 'draws_gifts_id' => $model->draws_gifts_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Winner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $profile_id Profile ID
     * @param int $draws_gifts_id Draws Gifts ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($profile_id, $draws_gifts_id)
    {
        $model = $this->findModel($profile_id, $draws_gifts_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'profile_id' => $model->profile_id, 'draws_gifts_id' => $model->draws_gifts_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Winner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $profile_id Profile ID
     * @param int $draws_gifts_id Draws Gifts ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($profile_id, $draws_gifts_id)
    {
        $this->findModel($profile_id, $draws_gifts_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Winner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $profile_id Profile ID
     * @param int $draws_gifts_id Draws Gifts ID
     * @return Winner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($profile_id, $draws_gifts_id)
    {
        if (($model = Winner::findOne(['profile_id' => $profile_id, 'draws_gifts_id' => $draws_gifts_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
