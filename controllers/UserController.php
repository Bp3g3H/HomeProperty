<?php

namespace app\controllers;

use app\models\User;
use app\models\UserSearch;
use yii\db\Query;
use yii\filters\auth\HttpHeaderAuth;
use yii\rest\ActiveController;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
            'optional' => ['create']
        ];
        return $behaviors;
    }

    public function beforeAction($action)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
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
            $post = \Yii::$app->request->getRawBody();
            $model = new User();
            if ($model->load(json_decode($post, true), ''))
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
            $post = \Yii::$app->request->getRawBody();
            if ($model->load(json_decode($post, true), ''))
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

    public function actionAppointments($id)
    {
        $query = (new Query())
            ->from('appointment')
            ->select([
                'appointment.*',
                'property.headline'
            ])->leftJoin('property', 'appointment.property_id = property.id')
            ->andWhere(['property.owner_id' => $id]);

        return $query->all();
    }
}