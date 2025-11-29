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
            [
            ['imageFile'], 'file', 'skipOnEmpty' => true, 
                        'extensions' => 'png, jpg, jpeg, webp, svg',
                        'checkExtensionByMimeType' => false, 
                        'maxSize' => 2 * 1024 * 1024, 
                        'tooBig' => 'O ficheiro não pode exceder 2MB.'
                    ],
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