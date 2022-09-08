<?php


namespace app\models;


use app\models\base\CommentBase;

class Comment extends CommentBase
{
    public static function create($user_id, $property_id, $message)
    {
        $model = new Comment();
        $model->user_id = $user_id;
        $model->property_id = $property_id;
        $model->message = $message;

        return $model->save();
    }
}