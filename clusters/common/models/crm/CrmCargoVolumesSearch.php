<?php

namespace common\models\crm;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\crm\CrmCargoVolumes;

/**
 * CrmCargoVolumesSearch represents the model behind the search form of `common\models\crm\CrmCargoVolumes`.
 */
class CrmCargoVolumesSearch extends CrmCargoVolumes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date', 'product_id', 'unit_id', 'size_loaded', 'size_delivered', 'size_remaining', 'company_id', 'created_by', 'updated_by'], 'integer'],
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
        $query = CrmCargoVolumes::find();

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
            'product_id' => $this->product_id,
            'unit_id' => $this->unit_id,
            'size_loaded' => $this->size_loaded,
            'size_delivered' => $this->size_delivered,
            'size_remaining' => $this->size_remaining,
            'company_id' => $this->company_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);
        $query->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }
}
