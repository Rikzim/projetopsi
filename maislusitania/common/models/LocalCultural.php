<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "local_cultural".
 *
 * @property int $id
 * @property string $nome
 * @property int $tipo_id
 * @property string $morada
 * @property int $distrito_id
 * @property string $descricao
 * @property string|null $horario_funcionamento
 * @property string|null $contacto_telefone
 * @property string|null $contacto_email
 * @property string|null $website
 * @property string|null $imagem_principal
 * @property int $ativo
 * @property float $latitude
 * @property float $longitude
 *
 * @property Avaliacao[] $avaliacaos
 * @property Distrito $distrito
 * @property Evento[] $eventos
 * @property Favorito[] $favoritos
 * @property Horario[] $horarios
 * @property Noticia[] $noticias
 * @property Reserva[] $reservas
 * @property TipoLocal $tipo
 * @property TipoBilhete $tipoBilhete
 * @property User[] $utilizadors
 * @property User[] $utilizadors0
 */
class LocalCultural extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'local_cultural';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['horario_funcionamento', 'contacto_telefone', 'contacto_email', 'website', 'imagem_principal'], 'default', 'value' => null],
            [['ativo'], 'default', 'value' => 1],
            [['nome', 'tipo_id', 'morada', 'distrito_id', 'descricao', 'latitude', 'longitude'], 'required'],
            [['tipo_id', 'distrito_id', 'ativo'], 'integer'],
            [['descricao'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['nome'], 'string', 'max' => 200],
            [['morada', 'website', 'imagem_principal'], 'string', 'max' => 255],
            [['horario_funcionamento'], 'string', 'max' => 500],
            [['contacto_telefone'], 'string', 'max' => 20],
            [['contacto_email'], 'string', 'max' => 100],
            [['tipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoLocal::class, 'targetAttribute' => ['tipo_id' => 'id']],
            [['distrito_id'], 'exist', 'skipOnError' => true, 'targetClass' => Distrito::class, 'targetAttribute' => ['distrito_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'tipo_id' => 'Tipo ID',
            'morada' => 'Morada',
            'distrito_id' => 'Distrito ID',
            'descricao' => 'Descricao',
            'horario_funcionamento' => 'Horario Funcionamento',
            'contacto_telefone' => 'Contacto Telefone',
            'contacto_email' => 'Contacto Email',
            'website' => 'Website',
            'imagem_principal' => 'Imagem Principal',
            'ativo' => 'Ativo',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * Gets query for [[Avaliacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacaos()
    {
        return $this->hasMany(Avaliacao::class, ['local_id' => 'id']);
    }

    /**
     * Gets query for [[Distrito]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistrito()
    {
        return $this->hasOne(Distrito::class, ['id' => 'distrito_id']);
    }

    /**
     * Gets query for [[Eventos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventos()
    {
        return $this->hasMany(Evento::class, ['local_id' => 'id']);
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favorito::class, ['local_id' => 'id']);
    }

    /**
     * Gets query for [[Horarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHorarios()
    {
        return $this->hasMany(Horario::class, ['local_id' => 'id']);
    }

    /**
     * Gets query for [[Noticias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNoticias()
    {
        return $this->hasMany(Noticia::class, ['local_id' => 'id']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['local_id' => 'id']);
    }

    /**
     * Gets query for [[Tipo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(TipoLocal::class, ['id' => 'tipo_id']);
    }

    /**
     * Gets query for [[TipoBilhete]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoBilhete()
    {
        return $this->hasOne(TipoBilhete::class, ['local_id' => 'id']);
    }

    /**
     * Gets query for [[Utilizadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizadors()
    {
        return $this->hasMany(User::class, ['id' => 'utilizador_id'])->viaTable('avaliacao', ['local_id' => 'id']);
    }

    /**
     * Gets query for [[Utilizadors0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizadors0()
    {
        return $this->hasMany(User::class, ['id' => 'utilizador_id'])->viaTable('favorito', ['local_id' => 'id']);
    }

}
