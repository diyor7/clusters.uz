<?php

namespace common\models\crm;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\crm\CrmCompanyEquipments;

/**
 * CrmCompanyEquipmentsSearch represents the model behind the search form of `common\models\crm\CrmCompanyEquipments`.
 */
class CrmCompanyEquipmentsSearch extends CrmCompanyEquipments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'code', 'category_id', 'type_id', 'equipment_count', 'created_by', 'updated_by', 'company_id'], 'integer'],
            [['title', 'description', 'parametres', 'created_at', 'updated_at'], 'safe'],
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
        $query = CrmCompanyEquipments::find();

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
            'code' => $this->code,
            'category_id' => $this->category_id,
            'type_id' => $this->type_id,
            'equipment_count' => $this->equipment_count,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'parametres', $this->parametres]);

        return $dataProvider;
    }
}
