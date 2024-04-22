<?php

namespace common\models;

use common\models\TexnoparkApplication;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TexnoparkApplicationSearch represents the model behind the search form about `common\models\TexnoparkApplication`.
 */
class TexnoparkApplicationSearch extends TexnoparkApplication
{
    public $titlesString;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'investment_order', 'owner_identity_doc', 'certificate', 'company_charter', 'business_plan', 'balance_sheet', 'investment_guarantee_letter'], 'string', 'max' => 255],
            [['created_date', 'sort'], 'safe']
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
        $query = TexnoparkApplication::find();

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
            'id' => $this->id
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name]);

        return $dataProvider;
    }
}
