<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\data\Sort;

class UserSearch extends User
{
    public function search($params)
    {
        $query = User::find();

        $this->load($params, '');

        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['type' => $this->type]);

        $sort = new Sort([
            'attributes' => [
                'id',
                'email',
                'type',
            ]
        ]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
        ]);
    }

}