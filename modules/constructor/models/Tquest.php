<?php

namespace app\modules\constructor\models;

use Yii;
use app\modules\progress\models\UserTquest;

/**
 * This is the model class for table "tquest".
 *
 * @property int $id
 * @property string $description
 * @property int $right_variant
 * @property int $test_id
 *
 * @property Qvariant[] $qvariants
 * @property Qvariant $rightVariant
 * @property Tests $test
 * @property UserTquest[] $userTquests
 */
class Tquest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tquest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['right_variant', 'test_id'], 'integer'],
            [['right_variant'], 'exist', 'skipOnError' => true, 'targetClass' => Qvariant::className(), 'targetAttribute' => ['right_variant' => 'id']],
            [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tests::className(), 'targetAttribute' => ['test_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Текст вопроса',
            'right_variant' => 'Right Variant',
            'test_id' => 'Test ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQvariants()
    {
        return $this->hasMany(Qvariant::className(), ['tquest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRightVariant()
    {
        return $this->hasOne(Qvariant::className(), ['id' => 'right_variant']);
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
    public function getUserTquests()
    {
        return $this->hasMany(UserTquest::className(), ['tquest_id' => 'id']);
    }
}
