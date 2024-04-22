<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PropertyValue;

/**
* PropertyValueSearch represents the model behind the search form about `common\models\PropertyValue`.
*/
class PropertyValueSearch extends PropertyValue
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'property_id'], 'integer'],
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
$query = PropertyValue::find();

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
            'property_id' => $this->property_id,
        ]);

return $dataProvider;
}
}