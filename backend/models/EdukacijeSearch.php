<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Edukacije;

/**
 * EdukacijeSearch represents the model behind the search form of `common\models\Edukacije`.
 */
class EdukacijeSearch extends Edukacije
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['lecturer', 'lecture_title', 'lecture_date', 'lecture_time', 'subject'], 'safe'],
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
        $query = Edukacije::find();
        
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
            'lecture_date' => $this->lecture_date,
            'lecture_time' => $this->lecture_time,
        ]);
        $query->andFilterWhere(['like', 'lecturer', $this->lecturer])
            ->andFilterWhere(['like', 'lecture_title', $this->lecture_title]);

        return $dataProvider;
    }
}
