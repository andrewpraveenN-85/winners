<?php

namespace backend\controllers;

use backend\models\DrawsGiftsRewards;
use backend\models\DrawsGiftsRewardsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DrawsGiftsRewardsController implements the CRUD actions for DrawsGiftsRewards model.
 */
class DrawsGiftsRewardsController extends Controller
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
     * Lists all DrawsGiftsRewards models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DrawsGiftsRewardsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DrawsGiftsRewards model.
     * @param int $draws_gift_id Draws Gift ID
     * @param int $rewards_id Rewards ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($draws_gift_id, $rewards_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($draws_gift_id, $rewards_id),
        ]);
    }

    /**
     * Creates a new DrawsGiftsRewards model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DrawsGiftsRewards();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'draws_gift_id' => $model->draws_gift_id, 'rewards_id' => $model->rewards_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DrawsGiftsRewards model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $draws_gift_id Draws Gift ID
     * @param int $rewards_id Rewards ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($draws_gift_id, $rewards_id)
    {
        $model = $this->findModel($draws_gift_id, $rewards_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'draws_gift_id' => $model->draws_gift_id, 'rewards_id' => $model->rewards_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DrawsGiftsRewards model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $draws_gift_id Draws Gift ID
     * @param int $rewards_id Rewards ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($draws_gift_id, $rewards_id)
    {
        $this->findModel($draws_gift_id, $rewards_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DrawsGiftsRewards model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $draws_gift_id Draws Gift ID
     * @param int $rewards_id Rewards ID
     * @return DrawsGiftsRewards the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($draws_gift_id, $rewards_id)
    {
        if (($model = DrawsGiftsRewards::findOne(['draws_gift_id' => $draws_gift_id, 'rewards_id' => $rewards_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
