<?php

namespace backend\models;

use common\models\LocalCultural;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class LocalCulturalForm extends Model
{
    public $nome;
    public $tipo_id;
    public $morada;
    public $distrito_id;
    public $descricao;
    public $horario_funcionamento;
    public $contacto_telefone;
    public $contacto_email;
    public $website;
    public $imageFile;
    public $latitude;
    public $longitude;
    public $ativo;
    
    private $_localCultural;

    public function __construct($localCultural = null, $config = [])
    {
        if ($localCultural instanceof LocalCultural) {
            $this->_localCultural = $localCultural;
            $this->nome = $localCultural->nome;
            $this->tipo_id = $localCultural->tipo_id;
            $this->morada = $localCultural->morada;
            $this->distrito_id = $localCultural->distrito_id;
            $this->descricao = $localCultural->descricao;
            $this->horario_funcionamento = $localCultural->horario_funcionamento;
            $this->contacto_telefone = $localCultural->contacto_telefone;
            $this->contacto_email = $localCultural->contacto_email;
            $this->website = $localCultural->website;
            $this->latitude = $localCultural->latitude;
            $this->longitude = $localCultural->longitude;
            $this->ativo = $localCultural->ativo;
        } else {
            $this->_localCultural = new LocalCultural();
            $this->ativo = 1;
        }
        
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['nome', 'tipo_id', 'morada', 'distrito_id', 'descricao', 'latitude', 'longitude'], 'required'],
            [['tipo_id', 'distrito_id', 'ativo'], 'integer'],
            [['descricao'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['horario_funcionamento', 'contacto_telefone', 'contacto_email', 'website'], 'default', 'value' => null],
            [['nome'], 'string', 'max' => 200],
            [['morada', 'website'], 'string', 'max' => 255],
            [['horario_funcionamento'], 'string', 'max' => 500],
            [['contacto_telefone'], 'string', 'max' => 20],
            [['contacto_email'], 'string', 'max' => 100],
            [['contacto_email'], 'email'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nome' => 'Nome',
            'tipo_id' => 'Tipo',
            'morada' => 'Morada',
            'distrito_id' => 'Distrito',
            'descricao' => 'Descrição',
            'horario_funcionamento' => 'Horário de Funcionamento',
            'contacto_telefone' => 'Telefone',
            'contacto_email' => 'Email',
            'website' => 'Website',
            'imageFile' => 'Imagem Principal',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'ativo' => 'Ativo',
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_localCultural->nome = $this->nome;
        $this->_localCultural->tipo_id = $this->tipo_id;
        $this->_localCultural->morada = $this->morada;
        $this->_localCultural->distrito_id = $this->distrito_id;
        $this->_localCultural->descricao = $this->descricao;
        $this->_localCultural->horario_funcionamento = $this->horario_funcionamento;
        $this->_localCultural->contacto_telefone = $this->contacto_telefone;
        $this->_localCultural->contacto_email = $this->contacto_email;
        $this->_localCultural->website = $this->website;
        $this->_localCultural->latitude = $this->latitude;
        $this->_localCultural->longitude = $this->longitude;
        $this->_localCultural->ativo = $this->ativo;

        // Handle image upload
        if ($this->imageFile instanceof UploadedFile) {
            $uploadPath = Yii::getAlias('@backend/web/uploads/');
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Delete old image if exists
            if (!empty($this->_localCultural->imagem_principal)) {
                $oldImagePath = $uploadPath . $this->_localCultural->imagem_principal;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $fileName = 'local_' . uniqid() . '.' . $this->imageFile->extension;
            $filePath = $uploadPath . $fileName;

            if ($this->imageFile->saveAs($filePath)) {
                $this->_localCultural->imagem_principal = $fileName;
            }
        }

        return $this->_localCultural->save(false);
    }

    public function getLocalCultural()
    {
        return $this->_localCultural;
    }

    public function getCurrentImage()
    {
        return $this->_localCultural->imagem_principal;
    }

    public function getId()
    {
        return $this->_localCultural->id;
    }

    public function getIsNewRecord()
    {
        return $this->_localCultural->isNewRecord;
    }
}