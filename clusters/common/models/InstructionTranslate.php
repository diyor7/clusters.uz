<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "instruction_translate".
 *
 * @property int $id
 * @property int $instruction_id
 * @property int $lang_id
 * @property string $title
 */
class InstructionTranslate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'instruction_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['instruction_id', 'lang_id', 'title'], 'required'],
            [['instruction_id', 'lang_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'instruction_id' => Yii::t('main', 'Instruction ID'),
            'lang_id' => Yii::t('main', 'Lang ID'),
            'title' => Yii::t('main', 'Title'),
        ];
    }
}
