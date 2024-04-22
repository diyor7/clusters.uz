<?php

namespace common\models;

use Imagine\Image\Box;
use Imagine\Imagick\Imagine;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "procurement_plan".
 *
 * @property int $id
 * @property int $company_id
 * @property int $category_id
 * @property int $type 1 Бюджет 2 Корпоратив
 * @property int $year Год
 * @property int $kvartal Квартал 1-12 месяцы 101-104 кварталы
 * @property string|null $title Название товара
 * @property string|null $code ТН ВЭД код
 * @property string|null $filename
 * @property string|null $functionality Функциональность
 * @property string|null $technicality Технические характеристики
 * @property float|null $unit_val Объем
 * @property int|null $unit_id Ед.измерения
 * @property int|null $created_at Дата добавления
 * @property int|null $updated_at Дата обновления
 *
 * @property Unit $unit
 */
class ProcurementPlan extends \yii\db\ActiveRecord
{
    const TYPE_BUDJET = 1;
    const TYPE_KORPORATIV = 2;

    public $file;

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procurement_plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'type', 'year', 'kvartal', 'functionality', 'technicality', 'unit_id', 'unit_val', 'category_id', 'title'], 'required'],
            [['company_id', 'type', 'year', 'kvartal', 'unit_id', 'created_at', 'updated_at', 'category_id'], 'integer'],
            [['functionality', 'technicality', 'filename'], 'string'],
            [['unit_val'], 'number'],
            [['title'], 'string', 'max' => 512],
            [['code'], 'string', 'max' => 12],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit_id' => 'id']],
            ['file', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'tif', 'pdf']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => t('Организация'),
            'type' => t('Тип'),
            'year' => t('Год'),
            'kvartal' => 'Квартал',
            'title' => 'Название товара',
            'code' => 'ТН ВЭД код',
            'functionality' => 'Функциональность',
            'technicality' => 'Технические характеристики',
            'unit_val' => 'Объем',
            'unit_id' => 'Ед.измерения',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата обновления',
            'file' => "Файл (картинка или PDF)",
            'category_id' => "Категория"
        ];
    }

    /**
     * Gets query for [[Unit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }


    public static function kvartals()
    {
        return [
            101 => 'I квартал',
            102 => 'II квартал',
            103 => 'III квартал',
            104 => 'IV квартал',
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь',
            13 => 'Весь год'
        ];
    }

    public function activeKvartal()
    {
        if (isset(self::kvartals()[$this->kvartal])) return self::kvartals()[$this->kvartal];
        return 'Неопределен!';
    }

    public function activeCode()
    {
        $tn = Tn::findOne(['id' => $this->code]);
        if ($tn != null) return $tn->code;
        return 'Неопределен!';
    }

    public function getCompany()
    {
        return Company::findOne($this->company_id);
    }

    public function getCategory()
    {
        return Category::findOne($this->category_id);
    }

    private function deleteFile($filename)
    {
        if ($filename) {
            if (file_exists(Yii::getAlias("@uploads") . '/plan/' . $filename)) {
                unlink(Yii::getAlias("@uploads") . '/plan/' . $filename);
            }
        }
    }

    public function afterDelete()
    {
        $this->deleteFile($this->filename);

        return parent::afterDelete();
    }

    private function saveFile($file)
    {
        $filename = ((int) (microtime(true) * (1000))) . '.' . $file->extension;

        $file->saveAs(Yii::getAlias("@uploads") . "/plan/" . $filename);

        return $filename;
    }

    public function beforeSave($insert)
    {
        $this->file = UploadedFile::getInstance($this, 'file');

        if ($this->file != null) {

            $this->deleteFile($this->filename);

            $filename = $this->saveFile($this->file);

            $this->filename = $filename;
        }

        $this->file = null;

        return parent::beforeSave($insert);
    }
}
