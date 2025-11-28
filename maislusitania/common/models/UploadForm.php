<?php

namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp, svg'],
        ];
    }

    public function upload($fileName)
    {
        if ($this->validate()) 
        {
            $uploadPath = \Yii::getAlias('@uploadPath');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            if ($this->imageFile->saveAs($uploadPath . '/' . $fileName)) {
                return $fileName;
            }
        }
        return false;
    }
}