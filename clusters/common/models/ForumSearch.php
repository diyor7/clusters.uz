<?php

namespace common\models;

use common\models\Forum;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CategorySearch represents the model behind the search form about `common\models\Category`.
 */
class ForumSearch extends Forum
{
    public $titlesString;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'who_is',  'panel', 'organization', 'phone', 'theme', 'last_name', 'email', 'occupation', 'country', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = \common\models\Forum::find();

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
            'id' => $this->id
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'occupation', $this->occupation])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'panel', $this->panel])
            ->andFilterWhere(['like', 'theme', $this->theme])
            ->andFilterWhere(['like', 'who_is', $this->who_is]);

        return $dataProvider;
    }
}
