<?php

namespace app\modules\progress\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 *
 * @property UserProgram[] $userPrograms
 * @property UserQuestion[] $userQuestions
 * @property UserTest[] $userTests
 * @property UserTheme[] $userThemes
 * @property UserTquest[] $userTquests
 */
class User extends \dektrium\user\models\User
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPrograms()
    {
        return $this->hasMany(UserProgram::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuestions()
    {
        return $this->hasMany(UserQuestion::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTests()
    {
        return $this->hasMany(UserTest::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserThemes()
    {
        return $this->hasMany(UserTheme::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTquests()
    {
        return $this->hasMany(UserTquest::className(), ['user_id' => 'id']);
    }
}
