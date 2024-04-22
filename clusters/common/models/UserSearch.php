<?php
namespace common\models;

use common\rbac\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for common\models\User.
 */
class UserSearch extends User
{
    public $full_name;
    public $name;
    /**
     * How many users we want to display per page.
     *
     * @var int
     */
    private $_pageSize = 11;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'email', 'status', 'item_name', 'name', 'full_name'], 'safe'],
        ];
    }

    /**
     * Returns a list of scenarios and the corresponding active attributes.
     *
     * @return array
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param  array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        // we make sure that admin can not see users with theCreator role
        if (!Yii::$app->user->can('theCreator')) 
        {
            $query = User::find()->joinWith('role')
                                 ->where(['!=', 'item_name', 'theCreator']);
        }
        else
        {
            $query = User::find()->joinWith('role');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_ASC]],
            'pagination' => [
                'pageSize' => $this->_pageSize,
            ]
        ]);

        // make item_name (Role) sortable
        $dataProvider->sort->attributes['item_name'] = [
            'asc' => ['item_name' => SORT_ASC],
            'desc' => ['item_name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) 
        {
            return $dataProvider;
        }

        $dataProvider->query->joinWith("user_profile");

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'company.name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'user_profile.full_name', $this->full_name])
            ->andFilterWhere(['like', 'item_name', $this->item_name]);

        return $dataProvider;
    }

    /**
     * Returns the array of possible user roles.
     * NOTE: used in user/index view.
     *
     * @return mixed
     */
    public static function getRolesList()
    {
        $roles = [];

        foreach (AuthItem::getRoles() as $item_name) 
        {
            if(!in_array($item_name->name, ['delivery']))
                $roles[$item_name->name] = $item_name->name;
        }

        return $roles;
    }
}
