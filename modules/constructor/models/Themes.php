<?php

namespace app\modules\constructor\models;

use Yii;
use app\modules\progress\models\UserTheme;

/**
 * This is the model class for table "themes".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $presentation_id file
 * @property int $program_id
 *
 * @property Questions[] $questions
 * @property Files $presentation0
 * @property Programs $program
 * @property Tests[] $tests
 * @property UserTheme[] $userThemes
 */
class Themes extends \yii\db\ActiveRecord
{
    public $presentation;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'themes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['presentation_id', 'program_id'], 'integer'],
            [['presentation'], 'file'],
            [['name'], 'string', 'max' => 255],
            [['presentation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['presentation_id' => 'id']],
            [['program_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programs::className(), 'targetAttribute' => ['program_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название темы',
            'description' => 'Описание темы',
            'presentation_id' => 'Презентация к теме',
            'presentation' => 'Выберите файл презентации к теме',
            'program_id' => 'Образовательная программа',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Questions::className(), ['theme_id' => 'id']);
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
    public function getProgram()
    {
        return $this->hasOne(Programs::className(), ['id' => 'program_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Tests::className(), ['theme_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserThemes()
    {
        return $this->hasMany(UserTheme::className(), ['theme_id' => 'id']);
    }
}
