<?php

namespace backend\controllers;

use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;
use Yii;
use backend\models\Profiles;
use backend\models\WinnersSearch;

/**
 * MembershipsController implements the CRUD actions for Memberships model.
 */
class MyDrawsController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'allowActions' => [
                    'index',
                ]
            ],
        ];
    }

    public function actionIndex() {
        $profile = Profiles::find()->where(['user_id' => Yii::$app->user->id])->one();
        $searchModel = new WinnersSearch(['profile_id' => $profile->id, 'status'=>10]);
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
}
