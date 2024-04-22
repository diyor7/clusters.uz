<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderRequest;

/**
* OrderRequestSearch represents the model behind the search form about `common\models\OrderRequest`.
*/
class OrderRequestSearch extends OrderRequest
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'order_id', 'company_id', 'is_winner'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
$query = OrderRequest::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'price' => $this->price,
            'company_id' => $this->company_id,
            'is_winner' => $this->is_winner,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

return $dataProvider;
}
}