<?php

namespace common\models\crm;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\crm\CrmWorkersEmployed;

/**
 * CrmWorkersEmployedSearch represents the model behind the search form of `common\models\crm\CrmWorkersEmployed`.
 */
class CrmWorkersEmployedSearch extends CrmWorkersEmployed
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'title', 'count', 'workertype_id', 'created_by', 'updated_by', 'company_id'], 'integer'],
            [['date', 'lifetime', 'created_at', 'updated_at'], 'safe'],
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
    public function search($params, $type_id)
    {
        $query = CrmWorkersEmployed::find();

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
            'type' => $type_id,
            'title' => $this->title,
            'count' => $this->count,
            'workertype_id' => $this->workertype_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'lifetime', $this->lifetime]);

        return $dataProvider;
    }
}
