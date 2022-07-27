<?php

namespace app\models;

use app\models\base\UserBase;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class User extends UserBase implements IdentityInterface
{
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return User::findOne(['token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        throw new NotSupportedException();
    }

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException();
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
