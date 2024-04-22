<?php

namespace common\models\crm;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\crm\CrmProductionVolumes;

/**
 * CrmProductionVolumesSearch represents the model behind the search form of `common\models\crm\CrmProductionVolumes`.
 */
class CrmProductionVolumesSearch extends CrmProductionVolumes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date', 'product_id', 'unit_id', 'stock_volume', 'defective_volume', 'next_volume', 'company_id', 'created_by', 'updated_by'], 'integer'],
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
        $query = CrmProductionVolumes::find();

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
            'stock_volume' => $this->stock_volume,
            'defective_volume' => $this->defective_volume,
            'next_volume' => $this->next_volume,
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
