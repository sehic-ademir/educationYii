<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserFiles;

/**
 * UserFileSearch represents the model behind the search form of `common\models\UserFiles`.
 */
class UserFileSearch extends UserFiles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'lecture_id'], 'integer'],
            [['file_path'], 'safe'],
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
        $userId = $params['id'];
        $query = UserFiles::find()
        ->where(['user_id' => $userId]);

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
            'user_id' => $this->user_id,
            'lecture_id' => $this->lecture_id,
        ]);
       
        $query->andFilterWhere(['like', 'file_path', $this->file_path]);

        return $dataProvider;
    }
}
