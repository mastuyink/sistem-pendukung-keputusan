<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
/**
 * This is the model class for table "t_gambar".
 *
 * @property int $id
 * @property string $nama_gambar
 * @property string $caption
 * @property string $datetime
 */
class TGambar extends \yii\db\ActiveRecord
{

    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_gambar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_gambar'], 'string'],
            [['datetime'], 'safe'],
            [['caption'], 'string', 'max' => 100],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_gambar' => 'Nama Gambar',
            'caption' => 'Caption',
            'datetime' => 'Datetime',
        ];
    }


    public function upload()
    {
        if ($this->validate()) {
            $path = Yii::$app->basePath.'/web/carrousel/';
            FileHelper::createDirectory($path, $mode = 0777, $recursive = true);
            $this->imageFile->saveAs($path . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->nama_gambar = $this->imageFile->baseName.".".$this->imageFile->extension;
            $this->save(false);
            return true;
        }else{
            return false;
        }
    }
}
