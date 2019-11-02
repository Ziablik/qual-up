<?php

namespace app\modules\constructor\models;

use DateTime;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $path
 * @property string $name
 * @property string $description
 * @property string $extension
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Programs[] $programs
 * @property Themes[] $themes
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['path', 'description', 'extension'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'name' => 'Name',
            'description' => 'Description',
            'extension' => 'Extension',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograms()
    {
        return $this->hasMany(Programs::className(), ['presentation' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThemes()
    {
        return $this->hasMany(Themes::className(), ['presentation' => 'id']);
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    public function upload($model){
        $date = new \DateTime();
        $hash = Yii::$app->getSecurity()->generatePasswordHash($date->format('Y-m-d H:i:s'));
        $hash = mb_substr($hash, 0, 10);

        $file = UploadedFile::getInstance($model, 'presentation');
        if($file){

            if($model->presentation_id){
                $this->deleteFile($model->presentation_id);
            }

            FileHelper::createDirectory('uploads/files/'.$hash.'/'.$date->format('d'));
            $fileName = Yii::$app->security->generateRandomString(10);

            $this->path = 'uploads/files/'.$hash.'/'.$date->format('d').'/'.
                $fileName . '.' . $file->extension;
            $this->name = $file->name;
            $this->extension = $file->extension;
            $this->save();

            $file->saveAs('uploads/files/'.$hash.'/'.$date->format('d').'/'.
                $fileName . '.' . $file->extension);
            return true;
        }
        return false;
    }

    public static function deleteFile($id){
        $file = Files::findOne(['id' => $id]);
        unlink($file->path);
    }
}
