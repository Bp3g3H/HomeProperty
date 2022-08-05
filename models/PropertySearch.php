<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\data\Sort;

class PropertySearch extends Property
{
    public function search($params)
    {
        $query = Property::find();

        $this->load($params, '');

        $query->andFilterWhere(['like', 'headline', $this->headline]);
        $query->andFilterWhere(['like', 'city', $this->city]);
        $query->andFilterWhere(['like', 'street', $this->street]);

        $sort = new Sort([
            'attributes' => [
                'id',
                'headline',
                'city',
                'street',
            ]
        ]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
        ]);
    }
}