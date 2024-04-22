<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserProfile;

/**
* UserProfileSearch represents the model behind the search form about `common\models\UserProfile`.
*/
class UserProfileSearch extends UserProfile
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'user_id'], 'integer'],
            [['full_name', 'address', 'description', 'cert_reg_date', 'cert_expiry_date', 'cert_num', 'activity_type', 'additional_activities', 'cert_url'], 'safe'],
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
$query = UserProfile::find();

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
            'user_id' => $this->user_id,
            'cert_reg_date' => $this->cert_reg_date,
            'cert_expiry_date' => $this->cert_expiry_date,
        ]);

        $query->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'cert_num', $this->cert_num])
            ->andFilterWhere(['like', 'activity_type', $this->activity_type])
            ->andFilterWhere(['like', 'additional_activities', $this->additional_activities])
            ->andFilterWhere(['like', 'cert_url', $this->cert_url]);

return $dataProvider;
}
}