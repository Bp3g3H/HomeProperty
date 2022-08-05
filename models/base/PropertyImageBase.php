<?php

namespace app\models\base;

use Yii;
use app\models\Property;

/**
 * This is the model class for table "property_image".
 *
 * @property int $id
 * @property int $property_id
 * @property string|null $image
 *
 * @property Property $property
 */
class PropertyImageBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_id'], 'required'],
            [['property_id'], 'integer'],
            [['image'], 'string'],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }
}
