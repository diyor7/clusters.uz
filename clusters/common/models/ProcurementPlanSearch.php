<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProcurementPlan;

/**
 * ProcurementPlanSearch represents the model behind the search form of `common\models\ProcurementPlan`.
 */
class ProcurementPlanSearch extends ProcurementPlan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'type', 'year', 'kvartal', 'unit_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'code', 'functionality', 'technicality'], 'safe'],
            [['unit_val'], 'number'],
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
    public function budjet($params)
    {
        $query = ProcurementPlan::find()
            ->where(['type' => ProcurementPlan::TYPE_BUDJET])
            ->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function search($params)
    {
        $query = ProcurementPlan::find()
            ->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function korporativ($params)
    {
        $query = ProcurementPlan::find()
            ->where(['type' => ProcurementPlan::TYPE_KORPORATIV])
            ->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
