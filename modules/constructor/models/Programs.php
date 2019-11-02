<?php

namespace app\modules\constructor\models;

use Yii;
use app\modules\progress\models\UserProgram;

/**
 * This is the model class for table "programs".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $image
 * @property int $presentation_id
 *
 * @property Files $presentation0
 * @property Tests[] $tests
 * @property Themes[] $themes
 * @property UserProgram[] $userPrograms
 */
class Programs extends \yii\db\ActiveRecord
{
    public $presentation;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'programs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'presentation_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['presentation'], 'file'],
            [['presentation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['presentation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название образовательной программы',
            'description' => 'Описание образовательной программы',
            'image' => 'Изображение',
            'presentation_id' => 'Презентация введения',
            'presentation' => 'Выберите файл презентации',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresentation0()
    {
        return $this->hasOne(Files::className(), ['id' => 'presentation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Tests::className(), ['program_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThemes()
    {
        return $this->hasMany(Themes::className(), ['program_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPrograms()
    {
        return $this->hasMany(UserProgram::className(), ['program_id' => 'id']);
    }
}
