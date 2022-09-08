<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\Comment;
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
        $model = $this->findModel($id);
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
        $model = $this->findModel($id);
        return $model->delete();
    }

    public function actionImages($id)
    {
        $model = $this->findModel($id);
        return $model->propertyImages;
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $model->attributes;
    }

    public function actionAddAppointment()
    {
        $post = Yii::$app->request->getRawBody();
        $post = json_decode($post, true);
        if (!$post['time'] || !$post['name'] || !$post['property_id'])
            throw new BadRequestHttpException('Provide time and name and property id');

        $model = $this->findModel($post['property_id']);

        if (Appointment::create($model->id, Yii::$app->user->id, $post['time'], $post['name']))
            return true;
        else
            throw new BadRequestHttpException('Appointment can not be saved');
    }

    public function actionAddComment()
    {
        $post = Yii::$app->request->getRawBody();
        $post = json_decode($post, true);
        if (!$post['message'] || !$post['property_id'])
            throw new BadRequestHttpException('Provide time and name and property id');

        $model = $this->findModel($post['property_id']);
        if (Comment::create(Yii::$app->user->id, $model->id, $post['message']))
            return true;
        else
            throw new BadRequestHttpException('Comment can not be saved');
    }

    public function actionComments($id)
    {
        $model = $this->findModel($id);
        return $model->comments;
    }

    public function findModel($id)
    {
        $model = Property::findOne($id);
        if (!$model)
            throw new NotFoundHttpException();
        return $model;
    }
}