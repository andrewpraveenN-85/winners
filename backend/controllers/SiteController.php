<?php

namespace backend\controllers;

use backend\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\Packages;
use yii\helpers\ArrayHelper;
use backend\models\Register;
use backend\models\Memberships;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'request-password-reset', 'reset-password', 'register'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {

        return $this->render('index', [
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionRegister() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new Register();
        $model->status = 10;
        $packages = ArrayHelper::map(Packages::find()->andWhere(['status' => 10])->all(), 'id', 'name');

        if ($this->request->isPost && $model->load($this->request->post())) {
            $userId = $this->createUserAndSave($model);
            if ($userId) {
                $imageName = $model->id . "_Image";
                $image = UploadedFile::getInstance($model, 'image');
                if (!empty($image)) {
                    $upload = Yii::$app->params['uploadPathIMG'] . 'profile/' . $imageName . '.' . $image->getExtension();
                    $image->saveAs($upload);
                    $model->img = $imageName . '.' . $image->getExtension();
                }
                $this->assignRoleToUser($userId);
                $this->createMembership($model->id, $model->package);
                $model->save(false);
                Yii::$app->session->setFlash('success', 'Member has been created successfully.');
                return $this->goBack();
            }
        }

        return $this->render('register', [
                    'model' => $model,
                    'packages' => $packages,
        ]);
    }

    private function createUserAndSave($model) {
        $userId = $model->createUser();
        if ($userId) {
            $model->user_id = $userId;
            if ($model->save(false)) {
                return $userId;
            }
        }
        return false;
    }

    private function assignRoleToUser($userId) {
        $auth = Yii::$app->authManager;
        $item = $auth->getRole('Profile');
        $auth->assign($item, $userId);
    }

    private function createMembership($profileid, $packageid) {
        $model = new Memberships();
        $model->package_id = $packageid;
        $model->profile_id = $profileid;
        $model->status = 10;
        return $model->save();
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRequestPasswordReset() {
        $this->layout = 'blank';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }
        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        $this->layout = 'blank';
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');
            return $this->goHome();
        }
        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionSignup() {
        $this->layout = 'blank';
        $model = new Guest();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }
}
