<?php

namespace app\models\base;

use Yii;
use app\models\Appointment;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property string|null $token
 * @property int|null $type
 * @property string|null $image
 *
 * @property Appointment[] $appointments
 */
class UserBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['image'], 'string'],
            [['email', 'password', 'token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'token' => 'Token',
            'type' => 'Type',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[Appointments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppointments()
    {
        return $this->hasMany(Appointment::className(), ['user_id' => 'id']);
    }
}
