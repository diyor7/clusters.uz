<?php

namespace common\models\organisation\ngmk;

use common\models\organisation\ngmk\ProductFeature;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductFeatureSearch represents the model behind the search form of `common\models\ProductFeature`.
 */
class ProductFeatureSearch extends ProductFeature
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'feature_id', 'status'], 'integer'],
            [['value', 'created_at', 'uptadet_at'], 'safe'],
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
    public function search($params,$product_id=null)
    {
        $query = ProductFeature::find()->where(['product_id'=>$product_id]);
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
            'feature_id' => $this->feature_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'uptadet_at' => $this->uptadet_at,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
