<?php

namespace app\modules\constructor\models;

use Yii;
use app\modules\progress\models\UserQuestion;

/**
 * This is the model class for table "questions".
 *
 * @property int $id
 * @property int $number
 * @property string $description
 * @property int $theme_id
 *
 * @property Themes $theme
 * @property UserQuestion[] $userQuestions
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'theme_id'], 'integer'],
            [['description'], 'string'],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Themes::className(), 'targetAttribute' => ['theme_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Номер задания',
            'description' => 'Текст задания',
            'theme_id' => 'Тема задания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Themes::className(), ['id' => 'theme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuestions()
    {
        return $this->hasMany(UserQuestion::className(), ['question_id' => 'id']);
    }
}
