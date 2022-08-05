<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpHeaderAuth;
use yii\web\BadRequestHttpException;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpHeaderAuth::class,
            'optional' => ['login']
        ];

        return $behaviors;
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = \Yii::$app->request->getRawBody();
        $model = new LoginForm();
        if ($model->load(json_decode($post, true), '') && $model->login()) {
            return [
                'icon' => Yii::$app->user->identity->image,
                'id' => Yii::$app->user->id,
                'token' => Yii::$app->user->identity->token,
                'type' => Yii::$app->user->identity->type,
            ];
        }

        throw new BadRequestHttpException();
    }

    public function actionLogout()
    {
        return Yii::$app->user->logout();
    }
}
