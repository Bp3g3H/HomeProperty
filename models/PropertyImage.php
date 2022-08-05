<?php

namespace app\models;

use app\models\base\PropertyImageBase;

class PropertyImage extends PropertyImageBase
{
    public static function create($property_id, $image)
    {
        $model = new PropertyImage();
        $model->property_id = $property_id;
        $model->image = $image;
        return $model->save();
    }
}