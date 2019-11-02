<?php

namespace app\modules\constructor\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\constructor\models\Qvariant;

/**
 * QvariantSearch represents the model behind the search form of `app\modules\constructor\models\Qvariant`.
 */
class QvariantSearch extends Qvariant
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tquest_id'], 'integer'],
            [['text'], 'safe'],
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
        $query = Qvariant::find();

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
            'tquest_id' => $this->tquest_id,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
