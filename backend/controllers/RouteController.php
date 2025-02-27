<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii2mod\rbac\models\RouteModel;
use yii2mod\rbac\filters\AccessControl;

class RouteController extends Controller {

    public $modelClass = [
        'class' => RouteModel::class,
    ];

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                    'create' => ['post'],
                    'assign' => ['post'],
                    'remove' => ['post'],
                    'refresh' => ['post'],
                ],
            ],
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['assign', 'remove', 'refresh'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'allowActions' => [
                    'index',
                    'refresh',
                    'assign',
                    'remove'
                ]
            ],
        ];
    }

    /**
     * Lists all Route models.
     *
     * @return mixed
     */
    public function actionIndex() {
        $model = Yii::createObject($this->modelClass);
        $routes = $model->getAvailableAndAssignedRoutes();
        $filteredArray = array_filter($routes['available'], function ($value) {
            return !(preg_match('#^/(rbac|gii|debug)#', $value) || preg_match('#/\*$#', $value));
        });
        $finalArray = [
            'available' => array_values($filteredArray),
            'assigned' => $routes['assigned']
        ];
        return $this->render('index', ['routes' => $finalArray]);
    }

    /**
     * Assign routes
     *
     * @return array
     */
    public function actionAssign(): array {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = Yii::createObject($this->modelClass);
        $model->addNew($routes);

        $route = $model->getAvailableAndAssignedRoutes();
        $filteredArray = array_filter($route['available'], function ($value) {
            return !(preg_match('#^/(rbac|gii|debug)#', $value) || preg_match('#/\*$#', $value));
        });
        $finalArray = [
            'available' => array_values($filteredArray),
            'assigned' => $route['assigned']
        ];

        return $finalArray;
    }

    /**
     * Remove routes
     *
     * @return array
     */
    public function actionRemove(): array {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = Yii::createObject($this->modelClass);
        $model->remove($routes);

        $route = $model->getAvailableAndAssignedRoutes();
        $filteredArray = array_filter($route['available'], function ($value) {
            return !(preg_match('#^/(rbac|gii|debug)#', $value) || preg_match('#/\*$#', $value));
        });
        $finalArray = [
            'available' => array_values($filteredArray),
            'assigned' => $route['assigned']
        ];

        return $finalArray;
    }

    /**
     * Refresh cache of routes
     *
     * @return array
     */
    public function actionRefresh(): array {
        $model = Yii::createObject($this->modelClass);
        $model->invalidate();

        $route = $model->getAvailableAndAssignedRoutes();
        $filteredArray = array_filter($route['available'], function ($value) {
            return !(preg_match('#^/(rbac|gii|debug)#', $value) || preg_match('#/\*$#', $value));
        });
        $finalArray = [
            'available' => array_values($filteredArray),
            'assigned' => $route['assigned']
        ];
        
        return $finalArray;
    }
}
