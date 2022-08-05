<?php

namespace app\models\base;

use Yii;
use app\models\PropertyImage;

/**
 * This is the model class for table "property".
 *
 * @property int $id
 * @property int $owner_id
 * @property string|null $headline
 * @property string|null $area
 * @property float|null $price
 * @property string|null $city
 * @property string|null $street
 * @property string|null $description
 *
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
            [['owner_id'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['headline', 'city', 'street'], 'string', 'max' => 255],
            [['area'], 'string', 'max' => 50],
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
        ];
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
