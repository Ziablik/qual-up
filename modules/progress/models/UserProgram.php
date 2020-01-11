<?php

namespace app\modules\progress\models;

use Yii;
use dektrium\user\models\User;
use app\modules\constructor\models\Programs;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "user_program".
 *
 * @property int $id
 * @property int $user_id
 * @property int $program_id
 * @property double $progress
 * @property int $finish_test_is_complete
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Programs $program
 * @property User $user
 */
class UserProgram extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_program';
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
            [['user_id', 'program_id', 'finish_test_is_complete'], 'integer'],
            [['progress'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id', 'program_id'], 'unique', 'targetAttribute' => ['user_id', 'program_id']],
            [['program_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programs::className(), 'targetAttribute' => ['program_id' => 'id']],
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
            'program_id' => 'Program ID',
            'progress' => 'Progress',
            'finish_test_is_complete' => 'Finish Test Is Complete',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function calculateProgress(){
        $program_model = Programs::findOne(['id' => $this->program_id]);
        $max_points = 0;
        $progress_points = 0;
        foreach ($program_model->themes as $theme){
            $user_theme_model = UserTheme::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['theme_id' => $theme->id])
                ->one();

            $max_points += 100;
            $progress_points += $user_theme_model->progress;
        }

        $this->progress = $progress_points/$max_points*100;
        $this->save();
    }
}
