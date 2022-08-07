<?php

namespace app\controllers;

use app\models\Property;
use app\models\PropertySearch;
use yii\filters\auth\HttpHeaderAuth;
use yii\rest\Controller;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PropertyController extends Controller
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
            'optional' => ['index', 'view']
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
        $model = new PropertySearch();
        return $model->search(Yii::$app->request->get());
    }

    public function actionCreate()
    {
        if (Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->getRawBody();
            $model = new Property();
            $model->owner_id = Yii::$app->user->id;
            if ($model->load(json_decode($post, true), '') && $model->save())
            {
                return true;
            }
        }

        throw new BadRequestHttpException();
    }

    public function actionUpdate($id)
    {
        $model = Property::findOne($id);
        if (!$model)
            throw new NotFoundHttpException();

        if (Yii::$app->request->isPut)
        {
            $post = \Yii::$app->request->getRawBody();
            if ($model->load(json_decode($post, true), '') && $model->save())
            {
                return true;
            }
        }

        throw new BadRequestHttpException();
    }

    public function actionDelete($id)
    {
        $model = Property::findOne($id);
        if (!$model)
            throw new NotFoundHttpException();

        return $model->delete();
    }

    public function actionImages($id)
    {
        $model = Property::findOne($id);
        if (!$model)
            throw new NotFoundHttpException();

        return $model->propertyImages;
    }

    public function actionView($id)
    {
        $model = Property::findOne($id);
        if (!$model)
            throw new NotFoundHttpException();

        return $model->attributes;
    }
}