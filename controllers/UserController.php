<?php

namespace app\controllers;

use app\models\User;
use app\models\UserSearch;
use yii\filters\auth\HttpHeaderAuth;
use yii\rest\ActiveController;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class UserController extends Controller
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
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $model = new UserSearch();
        return $model->search(Yii::$app->request->get());
    }

    public function actionCreate()
    {
        if (Yii::$app->request->isPost)
        {
            $model = new User();
            if ($model->load(Yii::$app->request->post(), ''))
            {
                $model->token = Yii::$app->security->generateRandomString();
                if ($model->save())
                    return true;
                else
                    return $model->getErrors();
            }
        }

        throw new BadRequestHttpException();
    }

    public function actionUpdate($id)
    {
        $model = User::findOne($id);
        if (!$model)
            throw new NotFoundHttpException();

        if (Yii::$app->request->isPut)
        {
            if ($model->load(Yii::$app->request->post(), ''))
            {
                if ($model->save())
                    return true;
                else
                    return $model->getErrors();
            }
        }

        throw new BadRequestHttpException();
    }

    public function actionDelete($id)
    {
        $model = User::findOne($id);
        if (!$model)
            throw new NotFoundHttpException();

        return $model->delete();
    }
}