<?php 
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadImage extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $caption;

    public function rules()
    {
        return [
            [['caption','imageFile'],'required'],
            [['caption'],'string','max'=>100],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload()
    {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $modelImage = new TGambar();
            $model->nama_gambar = $this->imageFile->baseName.$this->imageFile->extension;
            $model->caption = $this->caption;
            $model->save(false);
            return true;
            return false;
    }
}