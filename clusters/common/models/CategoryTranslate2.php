<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category_translate".
 *
 * @property integer $category_id
 * @property integer $lang
 * @property string $title
 *
 * @property Category $category
 */
class CategoryTranslate2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_translate3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['category_id', 'lang', 'title'], 'required'],
            [['category_id', 'lang'], 'integer'],
            [['title'], 'string'],
            // [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'lang' => 'Lang',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category2::className(), ['category_id' => 'category_id']);
    }
    
    // public function beforeSave($insert) {
	// 	if(parent::beforeSave($insert)) {
            
	// 		// $this->lang = \Yii::$app->language; // записываем текущий язык перед сохранением записи
	// 		$this->lang = Yii::$app->languageId->id; // записываем текущий язык перед сохранением записи
	// 		return true;
	// 	}
	// 	return false;
	// }
}
