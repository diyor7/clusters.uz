<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;
use yii\db\Expression;

/**
* OrderSearch represents the model behind the search form about `common\models\Order`.
*/
class OrderSearch extends Order
{
    public $starting_price;
    public $active_price;
    public $product_id;
    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['id', 'type', 'user_id', 'company_id', 'address_id', 'delivery_type', 'payment_type', 'status', 'payment_status'], 'integer'],
            [['address_text', 'receiver_fio', 'receiver_phone', 'created_at', 'payment_date', 'cancel_reason', 'tender_end', 'request_end', 'cancel_date', 'starting_price', 'active_price',], 'safe'],
            [['total_sum', 'shipping_sum', 'product_id',], 'number'],
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
        $query = Order::find()->joinWith('orderLists'); //->joinWith('orderRequests');

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
                    'type' => $this->type,
                    'user_id' => $this->user_id,
                    'company_id' => $this->company_id,
                    'address_id' => $this->address_id,
                    'delivery_type' => $this->delivery_type,
                    'payment_type' => $this->payment_type,
                    'total_sum' => $this->total_sum,
                    'created_at' => $this->created_at,
                    'shipping_sum' => $this->shipping_sum,
                    'status' => $this->status,
                    'payment_status' => $this->payment_status,
                    'payment_date' => $this->payment_date,
                    'tender_end' => $this->tender_end,
                    'request_end' => $this->request_end,
                    'cancel_date' => $this->cancel_date,
                    'order_list.product_id' => $this->product_id,
                    'total_sum / (SELECT SUM(quantity) FROM order_list GROUP by order_id)' => $this->starting_price,

                ]);

        if($this->active_price){
            $query->andWhere("id in ( select order_id from order_request group by order_id having min(price) = $this->active_price )");
        }

        $query->andFilterWhere(['like', 'address_text', $this->address_text])
            ->andFilterWhere(['like', 'receiver_fio', $this->receiver_fio])
            ->andFilterWhere(['like', 'receiver_phone', $this->receiver_phone])
            ->andFilterWhere(['like', 'cancel_reason', $this->cancel_reason]);

        return $dataProvider;
    }

}