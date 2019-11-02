<?php

namespace app\modules\constructor\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\constructor\models\Programs;

/**
 * ProgramsSearch represents the model behind the search form of `app\modules\constructor\models\Programs`.
 */
class ProgramsSearch extends Programs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'image', 'presentation_id'], 'integer'],
            [['name', 'description'], 'safe'],
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
        $query = Programs::find();

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
            'image' => $this->image,
            'presentation_id' => $this->presentation_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
