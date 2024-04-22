<?php

namespace common\models\crm;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\crm\CrmWharehouseIel;

/**
 * CrmWharehouseIelSearch represents the model behind the search form of `common\models\crm\CrmWharehouseIel`.
 */
class CrmWharehouseIelSearch extends CrmWharehouseIel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'prduct_type_id', 'product_id', 'product_unit_id', 'balance_from', 'balance_out', 'balance_in', 'balance_left', 'company_id', 'created_by', 'updated_by'], 'integer'],
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
        $query = CrmWharehouseIel::find();

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
            'prduct_type_id' => $this->prduct_type_id,
            'product_id' => $this->product_id,
            'product_unit_id' => $this->product_unit_id,
            'balance_from' => $this->balance_from,
            'balance_out' => $this->balance_out,
            'balance_in' => $this->balance_in,
            'balance_left' => $this->balance_left,
            'company_id' => $this->company_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
