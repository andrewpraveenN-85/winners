<?php

namespace backend\controllers;

use backend\models\Memberships;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;
use Yii;
use backend\models\Profiles;
use backend\models\Packages;
use backend\models\Config;
use backend\models\OffersSearch;

/**
 * MembershipsController implements the CRUD actions for Memberships model.
 */
class MyMembershipsController extends Controller {

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
        $membership = Memberships::find()->where(['profile_id' => $profile->id])->orderBy(['created_at' => SORT_DESC])->one();
        $package = Packages::find()->where(['id' => $membership->package_id])->one();
        $searchModel = new OffersSearch(['package_id' => $membership->package_id]);
        $dataProvider = $searchModel->search($this->request->queryParams);
        $package_upgrade = Config::findOne(['name' => 'PACKAGE_UPGRADE']);
        return $this->render('index', [
                    'profile' => $profile,
                    'membership' => $membership,
                    'package' => $package,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'package_upgrade' => $package_upgrade,
        ]);
    }
}
