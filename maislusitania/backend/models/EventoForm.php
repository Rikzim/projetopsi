<?php

namespace backend\models;

use common\models\Evento;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class EventoForm extends Model
{
    public $local_id;
    public $titulo;
    public $descricao;
    public $data_inicio;
    public $data_fim;
    public $imageFile;
    public $ativo;
    
    private $_evento;

    public function __construct($evento = null, $config = [])
    {
        if ($evento instanceof Evento) {
            $this->_evento = $evento;
            $this->local_id = $evento->local_id;
            $this->titulo = $evento->titulo;
            $this->descricao = $evento->descricao;
            $this->data_inicio = $evento->data_inicio;
            $this->data_fim = $evento->data_fim;
            $this->ativo = $evento->ativo;
        } else {
            $this->_evento = new Evento();
            $this->ativo = 1;
        }
        
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['local_id', 'titulo', 'descricao', 'data_inicio', 'data_fim'], 'required'],
            [['local_id', 'ativo'], 'integer'],
            [['descricao'], 'string'],
            [['data_inicio', 'data_fim'], 'date', 'format' => 'php:Y-m-d'],
            [['titulo'], 'string', 'max' => 200],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024 * 1024 * 2],
            ['data_fim', 'compare', 'compareAttribute' => 'data_inicio', 'operator' => '>=', 'message' => 'A data de fim deve ser maior ou igual à data de início.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'local_id' => 'Local Cultural',
            'titulo' => 'Título',
            'descricao' => 'Descrição',
            'data_inicio' => 'Data de Início',
            'data_fim' => 'Data de Fim',
            'imageFile' => 'Imagem do Evento',
            'ativo' => 'Ativo',
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_evento->local_id = $this->local_id;
        $this->_evento->titulo = $this->titulo;
        $this->_evento->descricao = $this->descricao;
        $this->_evento->data_inicio = $this->data_inicio;
        $this->_evento->data_fim = $this->data_fim;
        $this->_evento->ativo = $this->ativo;

        // Handle image upload
        if ($this->imageFile instanceof UploadedFile) {
            $uploadPath = Yii::getAlias('@backend/web/uploads/');
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Delete old image if exists
            if (!empty($this->_evento->imagem)) {
                $oldImagePath = $uploadPath . $this->_evento->imagem;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $fileName = 'evento_' . uniqid() . '.' . $this->imageFile->extension;
            $filePath = $uploadPath . $fileName;

            if ($this->imageFile->saveAs($filePath)) {
                $this->_evento->imagem = $fileName;
            }
        }

        return $this->_evento->save(false);
    }

    public function getEvento()
    {
        return $this->_evento;
    }

    public function getCurrentImage()
    {
        return $this->_evento->imagem;
    }

    public function getId()
    {
        return $this->_evento->id;
    }

    public function getIsNewRecord()
    {
        return $this->_evento->isNewRecord;
    }
}