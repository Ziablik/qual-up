<?php

namespace app\modules\constructor\models;

use app\modules\progress\models\UserTquest;
use Yii;


/**
 * This is the model class for table "qvariant".
 *
 * @property int $id
 * @property string $text
 * @property int $tquest_id
 *
 * @property Tquest $tquest
 * @property Tquest[] $tquests
 * @property UserTquest[] $userTquests
 * @property UserTquest[] $userTquests0
 */
class Qvariant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qvariant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['tquest_id'], 'integer'],
            [['tquest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tquest::className(), 'targetAttribute' => ['tquest_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'tquest_id' => 'Tquest ID',
        ];
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
    public function getTquests()
    {
        return $this->hasMany(Tquest::className(), ['right_variant' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTquests()
    {
        return $this->hasMany(UserTquest::className(), ['finish_answer_by_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTquests0()
    {
        return $this->hasMany(UserTquest::className(), ['common_answer_by_user' => 'id']);
    }
}