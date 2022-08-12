<?php

namespace app\models\base;

use Yii;
use app\models\Appointment;
use app\models\PropertyImage;

/**
 * This is the model class for table "property".
 *
 * @property int $id
 * @property int $owner_id
 * @property string|null $headline
 * @property int|null $area
 * @property float|null $price
 * @property string|null $city
 * @property string|null $street
 * @property string|null $description
 * @property float|null $lat
 * @property float|null $lng
 * @property int|null $type
 *
 * @property Appointment[] $appointments
 * @property PropertyImage[] $propertyImages
 */
class PropertyBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner_id'], 'required'],
            [['owner_id', 'area', 'type'], 'integer'],
            [['price', 'lat', 'lng'], 'number'],
            [['description'], 'string'],
            [['headline', 'city', 'street'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'headline' => 'Headline',
            'area' => 'Area',
            'price' => 'Price',
            'city' => 'City',
            'street' => 'Street',
            'description' => 'Description',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'type' => 'Type',
        ];
    }

    /**
     * Gets query for [[Appointments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppointments()
    {
        return $this->hasMany(Appointment::className(), ['property_id' => 'id']);
    }

    /**
     * Gets query for [[PropertyImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyImages()
    {
        return $this->hasMany(PropertyImage::className(), ['property_id' => 'id']);
    }
}
