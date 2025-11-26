<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\LocalCultural;
use common\models\Horario;
use yii\web\UploadedFile;

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
    public $ativo;
    public $latitude;
    public $longitude;
    public $imageFile;
    
    // Horário fields
    public $segunda;
    public $terca;
    public $quarta;
    public $quinta;
    public $sexta;
    public $sabado;
    public $domingo;

    private $_localCultural;
    private $_horario;

    public function __construct(LocalCultural $localCultural = null, $config = [])
    {
        if ($localCultural !== null) {
            $this->_localCultural = $localCultural;
            $this->setAttributes($localCultural->attributes, false);
            
            // Load horario data if exists
            $horario = Horario::findOne(['local_id' => $localCultural->id]);
            if ($horario !== null) {
                $this->_horario = $horario;
                $this->segunda = $horario->segunda;
                $this->terca = $horario->terca;
                $this->quarta = $horario->quarta;
                $this->quinta = $horario->quinta;
                $this->sexta = $horario->sexta;
                $this->sabado = $horario->sabado;
                $this->domingo = $horario->domingo;
            }
        } else {
            $this->_localCultural = new LocalCultural();
            $this->_horario = new Horario();
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
            [['nome'], 'string', 'max' => 200],
            [['morada', 'website'], 'string', 'max' => 255],
            [['horario_funcionamento'], 'string', 'max' => 500],
            [['contacto_telefone'], 'string', 'max' => 20],
            [['contacto_email'], 'string', 'max' => 100],
            [['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'], 'string', 'max' => 100],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
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
            'contacto_telefone' => 'Contacto Telefone',
            'contacto_email' => 'Contacto Email',
            'website' => 'Website',
            'ativo' => 'Ativo',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'imageFile' => 'Imagem Principal',
            'segunda' => 'Segunda-feira',
            'terca' => 'Terça-feira',
            'quarta' => 'Quarta-feira',
            'quinta' => 'Quinta-feira',
            'sexta' => 'Sexta-feira',
            'sabado' => 'Sábado',
            'domingo' => 'Domingo',
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        // Save LocalCultural
        $this->_localCultural->setAttributes($this->attributes, false);
        
        if ($this->imageFile) {
            $uploadPath = Yii::getAlias('@backend/web/uploads/');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $fileName = uniqid() . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($uploadPath . $fileName);
            $this->_localCultural->imagem_principal = $fileName;
        }

        if (!$this->_localCultural->save()) {
            return false;
        }

        // Save or update Horario
        if ($this->_horario->isNewRecord) {
            $this->_horario = new Horario();
        }
        
        $this->_horario->local_id = $this->_localCultural->id;
        $this->_horario->segunda = $this->segunda;
        $this->_horario->terca = $this->terca;
        $this->_horario->quarta = $this->quarta;
        $this->_horario->quinta = $this->quinta;
        $this->_horario->sexta = $this->sexta;
        $this->_horario->sabado = $this->sabado;
        $this->_horario->domingo = $this->domingo;

        if (!$this->_horario->save()) {
            return false;
        }

        return true;
    }

    public function getLocalCultural()
    {
        return $this->_localCultural;
    }
    
    public function getHorario()
    {
        return $this->_horario;
    }
}