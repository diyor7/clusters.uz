<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Auction;

/**
 * AuctionSearch represents the model behind the search form of `common\models\Auction`.
 */
class AuctionSearch extends Auction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'category_id', 'status', 'payment_status', 'delivery_period', 'payment_period', 'region_id', 'views'], 'integer'],
            [['total_sum'], 'number'],
            [['created_at', 'cancel_reason', 'auction_end', 'cancel_date', 'payment_date', 'receiver_email', 'receiver_phone', 'zip_code', 'address'], 'safe'],
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
        $query = Auction::find();

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
            'company_id' => $this->company_id,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'total_sum' => $this->total_sum,
            'created_at' => $this->created_at,
            'auction_end' => $this->auction_end,
            'cancel_date' => $this->cancel_date,
            'payment_status' => $this->payment_status,
            'payment_date' => $this->payment_date,
            'delivery_period' => $this->delivery_period,
            'payment_period' => $this->payment_period,
            'region_id' => $this->region_id,
            'views' => $this->views,
        ]);

        $query->andFilterWhere(['like', 'cancel_reason', $this->cancel_reason])
            ->andFilterWhere(['like', 'receiver_email', $this->receiver_email])
            ->andFilterWhere(['like', 'receiver_phone', $this->receiver_phone])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
