<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\Sort;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class PropertySearch extends Property
{
    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), [
            'image'
        ]);
    }

    public function search($params)
    {
        $query = (new Query());
        $query->select([
            'property.*',
            'property_image.image'
        ]);
        $query->from('property');
        $query->leftJoin('property_image', 'property_image.property_id = property.id');

        $this->load($params, '');

        $query->andFilterWhere(['like', 'headline', $this->headline]);
        $query->andFilterWhere(['like', 'city', $this->city]);
        $query->andFilterWhere(['like', 'street', $this->street]);
        $query->groupBy('property.id');

        $sort = new Sort([
            'attributes' => [
                'id',
                'headline',
                'city',
                'street',
            ]
        ]);

        return new ArrayDataProvider([
            'allModels' => $query->all(),
            'sort' => $sort,
        ]);
    }
}