<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "instruction".
 *
 * @property int $id
 * @property string $file
 * @property string $icon
 *
 * @property InstructionTranslate[] $instructionTranslates
 */
class Instruction extends \yii\db\ActiveRecord
{
    public $titles;
    public $fayl, $ikon;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'instruction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titles'], 'safe'],
            [['file', 'icon'], 'string', 'max' => 255],
            [['fayl'], 'file', 'extensions' => ['pdf', 'pptx', 'ppt']],
            [['ikon'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'svg']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'file' => Yii::t('main', 'File'),
            'icon' => Yii::t('main', 'Icon'),
        ];
    }

    /**
     * Gets query for [[InstructionTranslates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionTranslates()
    {
        return $this->hasMany(InstructionTranslate::className(), ['instruction_id' => 'id']);
    }

    public function getTranslate()
    {
        return $this->hasOne(InstructionTranslate::className(), ['instruction_id' => 'id'])->andWhere(['lang_id' => Yii::$app->languageId->id]);
    }

    public function getIconurl()
    {
        return siteUrl() . 'uploads/instruction/'.$this->icon;
    }

    public function getFileurl()
    {
        return siteUrl() . 'uploads/instruction/'.$this->file;
    }

    public function getTitle()
    {
        return $this->translate ? $this->translate->title : "";
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->titles)) {
            foreach ($this->titles as $lang => $title) {
                $translate = InstructionTranslate::findOne(['instruction_id' => $this->id, 'lang_id' => $lang]);

                if (!$translate) {
                    $translate = new InstructionTranslate([
                        'instruction_id' => $this->id,
                        'lang_id' => $lang
                    ]);
                }

                $translate->title = $title;
                if(!$translate->save(false)){
                    var_dump($translate->errors); die;
                }
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function beforeSave($insert)
    {
        $this->fayl = UploadedFile::getInstance($this, 'fayl');

        if ($this->fayl != null) {

            $filename = ((int) (microtime(true) * (1000))) . '.' . $this->fayl->extension;

            $this->fayl->saveAs(Yii::getAlias("@uploads") . "/instruction/" . $filename);

            $this->file = $filename;
        }

        $this->fayl = null;

        $this->ikon = UploadedFile::getInstance($this, 'ikon');

        if ($this->ikon != null) {

            $filename = ((int) (microtime(true) * (1000))) . '.' . $this->ikon->extension;

            $this->ikon->saveAs(Yii::getAlias("@uploads") . "/instruction/" . $filename);

            $this->icon = $filename;
        }

        $this->ikon = null;

        return parent::beforeSave($insert);
    }



    public function afterDelete()
    {
        if (file_exists(Yii::getAlias("@uploads") . '/instruction/' . $this->file)) {
            unlink(Yii::getAlias("@uploads") . '/instruction/' . $this->file);
        }

        if (file_exists(Yii::getAlias("@uploads") . '/instruction/' . $this->icon)) {
            unlink(Yii::getAlias("@uploads") . '/instruction/' . $this->icon);
        }

        return parent::afterDelete();
    }
}
