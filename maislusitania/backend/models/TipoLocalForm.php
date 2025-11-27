<?php

namespace backend\models;

use common\models\TipoLocal;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class TipoLocalForm extends Model
{
    public $designacao;
    public $iconFile;
    
    private $_tipoLocal;

    public function __construct($tipoLocal = null, $config = [])
    {
        if ($tipoLocal instanceof TipoLocal) {
            $this->_tipoLocal = $tipoLocal;
            $this->designacao = $tipoLocal->designacao;
        } else {
            $this->_tipoLocal = new TipoLocal();
        }
        
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['designacao'], 'required'],
            [['designacao'], 'string', 'max' => 50],
            [['iconFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, svg', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function attributeLabels()
    {
        return [
            'designacao' => 'Designação',
            'iconFile' => 'Ícone do Tipo de Local',
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_tipoLocal->designacao = $this->designacao;

        // Handle icon upload
        if ($this->iconFile instanceof UploadedFile) {
            $uploadPath = Yii::getAlias('@backend/web/uploads/');
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Delete old icon if exists
            if (!empty($this->_tipoLocal->icone)) {
                $oldIconPath = $uploadPath . $this->_tipoLocal->icone;
                if (file_exists($oldIconPath)) {
                    unlink($oldIconPath);
                }
            }

            $fileName = 'tipolocal_' . uniqid() . '.' . $this->iconFile->extension;
            $filePath = $uploadPath . $fileName;

            if ($this->iconFile->saveAs($filePath)) {
                $this->_tipoLocal->icone = $fileName;
            }
        }

        return $this->_tipoLocal->save(false);
    }

    public function getTipoLocal()
    {
        return $this->_tipoLocal;
    }

    public function getCurrentIcon()
    {
        return $this->_tipoLocal->icone;
    }

    public function getId()
    {
        return $this->_tipoLocal->id;
    }

    public function getIsNewRecord()
    {
        return $this->_tipoLocal->isNewRecord;
    }
}