<?php

namespace common\models\organisation\ngmk;

use common\models\organisation\ngmk\Company;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;
/**
 * CompanySearch represents the model behind the search form of `common\models\Company`.
 */
class CompanySearch extends Company
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'status'], 'integer'],
            [['name', 'logo', 'information', 'address', 'phone', 'email', 'director_full_name', 'created_at', 'updated_at'], 'safe'],
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
        $company_id=Yii::$app->user->identity->company_id;
        $user = \common\models\User::findOne(['id'=>Yii::$app->user->identity->id]);
        if($user->type==\common\models\User::TYPE_SUPERADMIN){
            $query = Company::find()->where(['status'=>1]);
        }
        if($user->type==\common\models\User::TYPE_ADMIN){
            $query = Company::find()->where(['parent_id'=>$company_id])->where(['status'=>1]);
        }


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
            'parent_id' => $this->parent_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'information', $this->information])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'director_full_name', $this->director_full_name]);

        return $dataProvider;
    }
}
