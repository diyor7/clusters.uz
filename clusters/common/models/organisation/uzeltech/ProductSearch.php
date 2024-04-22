<?php

namespace common\models\organisation\uzeltech;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\organisation\uzeltech\Product;

/**
 * ProductSearch represents the model behind the search form of `common\models\Product`.
 */
class ProductSearch extends Product
{
    public $type;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'views', 'company_id', 'units_measure_id','type', 'quarter_id', 'status', 'type'], 'integer'],
            [['name', 'price', 'code', 'description', 'created_at', 'updated_at'], 'safe'],
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
        $query = Product::find()->where(['status'=>1]);

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
        if($this->type != ""){
//            $Category = Category::find()->select("id")->where(['type' => $this->status]);
            $query->andFilterWhere(['in', 'type', $this->type]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'views' => $this->views,
            'units_measure_id' => $this->units_measure_id,
            'quarter_id' => $this->quarter_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'company_id', $this->company_id])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }


    public function searchImage($params,$product_id=null)
    {
        $query = Images::find()->where(['product_id'=>$product_id]);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }

}
