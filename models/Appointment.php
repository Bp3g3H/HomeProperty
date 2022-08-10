<?php

namespace app\models;

use app\models\base\AppointmentBase;

class Appointment extends AppointmentBase
{
    public static function create($property_id, $user_id, $time, $name)
    {
        $model = new Appointment();
        $model->property_id = $property_id;
        $model->user_id = $user_id;
        $model->time = $time;
        $model->name = $name;
        return $model->save();
    }
}