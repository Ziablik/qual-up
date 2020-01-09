<?php

namespace app\modules\progress\models;

use Yii;
use dektrium\user\models\User;
use app\modules\constructor\models\Qvariant;
use app\modules\constructor\models\Tquest;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "user_tquest".
 *
 * @property int $id
 * @property int $user_id
 * @property int $tquest_id
 * @property int $common_answer_by_user
 * @property int $finish_answer_by_user
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Qvariant $finishAnswerByUser
 * @property Qvariant $commonAnswerByUser
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

    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'tquest_id', 'common_answer_by_user', 'finish_answer_by_user'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['finish_answer_by_user'], 'exist', 'skipOnError' => true, 'targetClass' => Qvariant::className(), 'targetAttribute' => ['finish_answer_by_user' => 'id']],
            [['common_answer_by_user'], 'exist', 'skipOnError' => true, 'targetClass' => Qvariant::className(), 'targetAttribute' => ['common_answer_by_user' => 'id']],
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
            'common_answer_by_user' => 'Common Answer By User',
            'finish_answer_by_user' => 'Finish Answer By User',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinishAnswerByUser()
    {
        return $this->hasOne(Qvariant::className(), ['id' => 'finish_answer_by_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommonAnswerByUser()
    {
        return $this->hasOne(Qvariant::className(), ['id' => 'common_answer_by_user']);
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