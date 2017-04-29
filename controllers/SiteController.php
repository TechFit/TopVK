<?php

namespace app\controllers;

use app\models\SignUpForm,
    app\models\LoginForm,
    app\models\AuthHandler;

use Yii;

use yii\filters\AccessControl,
    yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use yii\web\Controller;

use yii\httpclient\Client;

/**
 * Class SiteController
 *
 * @package app\controllers
 *
 * @author Maxym Barvinok
 */
class SiteController extends Controller
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Controllers action map
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays Sign Up page.
     *
     * @return string
     */
    public function actionSignUp()
    {
        $model = new SignUpForm();

        if (Yii::$app->request->post('SignUpForm')) {
            $model->attributes = Yii::$app->request->post('SignUpForm');

            if ($model->validate() && $model->signup()) {
                return $this->goHome();

            }
        }

        return $this->render('sign-up',[
            'model' => $model
        ]);
    }

    /**
     * Displays Login page.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->actionSignUp();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Social auth action
     * @param $client
     */
    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

}
