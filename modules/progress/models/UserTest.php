<?php

namespace app\modules\progress\models;

use Yii;
use dektrium\user\models\User;
use app\modules\constructor\models\Tests;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "user_test".
 *
 * @property int $id
 * @property int $user_id
 * @property int $test_id
 * @property string $test_type
 * @property int $test_points
 * @property int $count_attempts
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Tests $test
 * @property User $user
 */
class UserTest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_test';
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
            [['user_id', 'test_id', 'test_points', 'count_attempts'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['test_type'], 'string', 'max' => 255],
            [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tests::className(), 'targetAttribute' => ['test_id' => 'id']],
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
            'test_id' => 'Test ID',
            'test_type' => 'Test Type',
            'test_points' => 'Test Points',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Tests::className(), ['id' => 'test_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function calculateCommonTest($test_id, $answers_by_user){
        unset($answers_by_user['_csrf']);

        $right_answers = $this->getRightAnswers($test_id);
        $right_answers_by_user = array_intersect($answers_by_user, $right_answers);
        $wrong_answers_by_user = array_diff($answers_by_user, $right_answers);


        $this->test_points = count($right_answers_by_user);
        $this->count_attempts += 1;
//        $this->save();

        return ['right' => $right_answers_by_user, 'wrong' => $wrong_answers_by_user];
    }

    private function getRightAnswers($test_id){
        $test_model = Tests::findOne(['id' => $test_id]);
        $right_answers = [];
        foreach ($test_model->tquests as $tquest_model){
            $right_answers['tquest_id='.$tquest_model->id] = $tquest_model->right_variant;
        }
        return $right_answers;
    }
}