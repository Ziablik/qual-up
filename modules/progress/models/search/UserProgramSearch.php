<?php

namespace app\modules\progress\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\progress\models\UserProgram;

/**
 * UserProgramSearch represents the model behind the search form of `app\modules\progress\models\UserProgram`.
 */
class UserProgramSearch extends UserProgram
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'program_id', 'finish_test_is_complete'], 'integer'],
            [['progress'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = UserProgram::find();

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
            'program_id' => $this->program_id,
            'progress' => $this->progress,
            'finish_test_is_complete' => $this->finish_test_is_complete,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
