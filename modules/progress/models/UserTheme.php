<?php

namespace app\modules\progress\models;

use Yii;
use dektrium\user\models\User;
use app\modules\constructor\models\Themes;

/**
 * This is the model class for table "user_theme".
 *
 * @property int $id
 * @property int $user_id
 * @property int $theme_id
 * @property int $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Themes $theme
 * @property User $user
 */
class UserTheme extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_theme';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'theme_id', 'progress', 'created_at', 'updated_at'], 'integer'],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Themes::className(), 'targetAttribute' => ['theme_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'theme_id' => 'Theme ID',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
