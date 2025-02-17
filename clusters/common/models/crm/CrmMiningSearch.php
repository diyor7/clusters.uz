<?php

namespace common\models\crm;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\crm\CrmMining;

/**
 * CrmMiningSearch represents the model behind the search form of `common\models\crm\CrmMining`.
 */
class CrmMiningSearch extends CrmMining
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'size', 'product_id', 'capacity', 'unit_id', 'mine_id', 'capacity_next', 'capacity_next_unit_id', 'updated_by', 'created_by', 'company_id'], 'integer'],
            [['date', 'updated_at', 'created_at'], 'safe'],
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
        $query = CrmMining::find();

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
            'type' => $this->type,
            'size' => $this->size,
            'product_id' => $this->product_id,
            'capacity' => $this->capacity,
            'unit_id' => $this->unit_id,
            'mine_id' => $this->mine_id,
            'capacity_next' => $this->capacity_next,
            'capacity_next_unit_id' => $this->capacity_next_unit_id,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }
}
