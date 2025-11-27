<?php

namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $uploadPath = \Yii::getAlias('@backend/web/uploads/');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $fileName = uniqid('noticia_') . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($uploadPath . $fileName);
            return $fileName;
        }
        return false;
    }
}