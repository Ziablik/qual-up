<?php

namespace app\modules\constructor\models;

use Yii;
use app\modules\progress\models\UserTest;

/**
 * This is the model class for table "tests".
 *
 * @property int $id
 * @property string $type
 * @property int $program_id
 * @property int $theme_id
 *
 * @property Programs $program
 * @property Themes $theme
 * @property Tquest[] $tquests
 * @property UserTest[] $userTests
 */
class Tests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['program_id', 'theme_id'], 'integer'],
            [['type'], 'string', 'max' => 255],
            [['program_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programs::className(), 'targetAttribute' => ['program_id' => 'id']],
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
            'type' => 'Тип теста',
            'program_id' => 'Образовательная программа',
            'theme_id' => 'Тема',
        ];
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
    public function getTheme()
    {
        return $this->hasOne(Themes::className(), ['id' => 'theme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTquests()
    {
        return $this->hasMany(Tquest::className(), ['test_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTests()
    {
        return $this->hasMany(UserTest::className(), ['test_id' => 'id']);
    }
}
