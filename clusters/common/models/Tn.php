<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tn".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string $code
 * @property int|null $cert_required
 * @property int|null $status
 *
 * @property AuctionTn[] $auctionTns
 * @property CompanyTn[] $companyTns
 * @property Category $category
 * @property TnTranslate[] $tnTranslates
 */
class Tn extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'cert_required', 'status'], 'integer'],
            [['code'], 'required'],
            [['code'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            ['titles', 'required'],
            ['titles', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'code' => 'Code',
            'cert_required' => 'Cert Required',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[AuctionTns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuctionTns()
    {
        return $this->hasMany(AuctionTn::className(), ['tn_id' => 'id']);
    }

    /**
     * Gets query for [[CompanyTns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyTns()
    {
        return $this->hasMany(CompanyTn::className(), ['tn_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[TnTranslates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTnTranslates()
    {
        return $this->hasMany(TnTranslate::className(), ['tn_id' => 'id']);
    }


    public function setTitle($val)
    {
        $this->title = $val;
    }

    public function getTitle()
    {
        return $this->translate ? $this->translate->title : null;
    }

    public function getTranslate()
    {
        return $this->hasOne(TnTranslate::className(), ['tn_id' => 'id'])->andWhere(['tn_translate.lang' => Yii::$app->languageId]);
    }

    public function getTitles()
    {
        return ArrayHelper::map($this->tnTranslates, 'lang', 'title');
    }

    public function setTitles($val)
    {
        $this->titles = $val;
    }

    public function getTitlesString()
    {
        return join(' / ', ArrayHelper::getColumn($this->tnTranslates, 'title'));
    }

    public function setTitlesString($val)
    {
        $this->titlesString = $val;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->titles)) {
            foreach ($this->titles as $lang => $title) {
                $translate = TnTranslate::findOne(['tn_id' => $this->id, 'lang' => $lang]);

                if (!$translate) {
                    $translate = new TnTranslate([
                        'tn_id' => $this->id,
                        'lang' => $lang
                    ]);
                }

                $translate->title = $title;
                $translate->save();
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }
}
