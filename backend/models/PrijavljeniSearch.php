<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Prijavljeni;

/**
 * PrijavljeniSearch represents the model behind the search form of `common\models\Prijavljeni`.
 */
class PrijavljeniSearch extends Prijavljeni
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lecture_id', 'user_id', 'created_at', 'updated_at', 'present'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $edukacijaId = $params['id'];
        $query = Prijavljeni::find()
        ->where(['lecture_id' => $edukacijaId, 'status' => 1]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'lecture_id' => $this->lecture_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'present' => $this->present,
        ]);

        return $dataProvider;
    }
}
