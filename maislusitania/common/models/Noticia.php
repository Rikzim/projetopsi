<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "noticia".
 *
 * @property int $id
 * @property string $titulo
 * @property string $conteudo
 * @property string|null $resumo
 * @property string|null $imagem
 * @property string $data_publicacao
 * @property int $ativo
 * @property int $local_id
 * @property int $destaque
 *
 * @property LocalCultural $local
 */
class Noticia extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'noticia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resumo', 'imagem'], 'default', 'value' => null],
            [['ativo'], 'default', 'value' => 1],
            [['destaque'], 'default', 'value' => 0],
            [['titulo', 'conteudo', 'local_id'], 'required'],
            [['conteudo'], 'string'],
            [['data_publicacao'], 'safe'],
            [['ativo', 'local_id', 'destaque'], 'integer'],
            [['titulo'], 'string', 'max' => 200],
            [['resumo'], 'string', 'max' => 500],
            [['imagem'], 'string', 'max' => 255],
            [['local_id'], 'exist', 'skipOnError' => true, 'targetClass' => LocalCultural::class, 'targetAttribute' => ['local_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'conteudo' => 'Conteudo',
            'resumo' => 'Resumo',
            'imagem' => 'Imagem',
            'data_publicacao' => 'Data Publicacao',
            'ativo' => 'Ativo',
            'local_id' => 'Local ID',
            'destaque' => 'Destaque',
        ];
    }

    /**
     * Gets query for [[Local]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalCultural()
    {
        return $this->hasOne(LocalCultural::class, ['id' => 'local_id']);
    }
    public function getLocal()
    {
        return $this->hasOne(LocalCultural::class, ['id' => 'local_id']);
    }
    public function getImage()
    {
        if (empty($this->imagem)) {
            return null;
        }

        return '/uploads/' . $this->imagem;
    }
    public function getImageAPI()
    {
        if (empty($this->imagem)) {
            return null;
        }
        
        /* 
        Retorna a URL completa da imagem com o seguinte formato:
        - hostInfo: Obtém o esquema (http/https) e o host (domínio) da aplicação atual.
        - /projetopsi/maislusitania/frontend/web/uploads/: Caminho
        - $this->imagem_principal: Nome do arquivo da imagem armazenado no banco de dados.
        */
        return Yii::$app->request->hostInfo . '/projetopsi/maislusitania/frontend/web/uploads/' . $this->imagem; 
    }

}
