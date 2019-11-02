<?php

namespace app\modules\progress\models;

use Yii;
use dektrium\user\models\User;
use app\modules\constructor\models\Qvariant;
use app\modules\constructor\models\Tquest;

/**
 * This is the model class for table "user_tquest".
 *
 * @property int $id
 * @property int $user_id
 * @property int $tquest_id
 * @property int $answer_by_user
 * @property int $common_flag
 * @property int $finish_flag
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Qvariant $answerByUser
 * @property Tquest $tquest
 * @property User $user
 */
class UserTquest extends \yii\db\ActiveRecord
{
    public $answerList;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_tquest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'tquest_id', 'answer_by_user', 'common_flag', 'finish_flag', 'created_at', 'updated_at'], 'integer'],
            [['answer_by_user'], 'exist', 'skipOnError' => true, 'targetClass' => Qvariant::className(), 'targetAttribute' => ['answer_by_user' => 'id']],
            [['tquest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tquest::className(), 'targetAttribute' => ['tquest_id' => 'id']],
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
            'tquest_id' => 'Tquest ID',
            'answer_by_user' => 'Answer By User',
            'common_flag' => 'Common Flag',
            'finish_flag' => 'Finish Flag',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerByUser()
    {
        return $this->hasOne(Qvariant::className(), ['id' => 'answer_by_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTquest()
    {
        return $this->hasOne(Tquest::className(), ['id' => 'tquest_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
