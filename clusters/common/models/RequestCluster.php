<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "request_cluster".
 *
 * @property int $id
 * @property string $tin
 * @property string $name
 * @property int $country_id
 * @property int $region_id
 * @property string $address
 * @property string $phone
 * @property string|null $email
 * @property string $activity
 * @property string|null $industry
 * @property string $products
 * @property string $investment_size
 * @property int $workplaces
 * @property string $production_capacity
 * @property string|null $created_at
 *
 * @property Region $country
 * @property Region $region
 */
class RequestCluster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request_cluster';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tin', 'name', /*'country_id', */ 'region_id', 'address', 'phone', 'activity', 'products', 'investment_size', 'workplaces', 'production_capacity'], 'required'],
            [['country_id', 'region_id', 'workplaces'], 'integer'],
            [['products'], 'string'],
            [['created_at'], 'safe'],
            [['tin', 'name', 'address', 'phone', 'email', 'activity', 'industry', 'investment_size', 'production_capacity'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],

            [['phone'], 'match', 'pattern' => '/^\+998[0-9]{9}$/', 'message' => getTranslate('Неверный формат номера телефона')],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tin' => t("ИНН предприятия"),
            'name' => t('Наименование предприятия'),
            'country_id' => t('Страна'),
            'region_id' => t('Область'),
            'address' => t('Адрес'),
            'phone' => t('Телефон'),
            'email' => t('Почта'),
            'activity' => t('Вид деятельности'),
            'industry' => t('Отрасль'),
            'products' => t('Выпуская продукция'),
            'investment_size' => t('Объем инвестиций'),
            'workplaces' => t('Создаваемые рабочие места'),
            'production_capacity' => t('Мощность производства'),
            'created_at' => t('Дата заявки'),
        ];
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Region::className(), ['id' => 'country_id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
}
