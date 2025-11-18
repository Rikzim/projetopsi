<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reserva".
 *
 * @property int $id
 * @property int $utilizador_id
 * @property int $local_id
 * @property string $data_visita
 * @property float $preco_total
 * @property string|null $estado
 * @property string|null $data_criacao
 *
 * @property LinhaReserva[] $linhaReservas
 * @property LocalCultural $local
 * @property User $utilizador
 */
class Reserva extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;

    /**
     * ENUM field values
     */
    const ESTADO_EXPIRADO = 'Expirado';
    const ESTADO_CONFIRMADA = 'Confirmada';
    const ESTADO_CANCELADA = 'Cancelada';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reserva';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => '_utf8mb4\'Pendente\''],
            [['utilizador_id', 'local_id', 'data_visita', 'preco_total'], 'required'],
            [['utilizador_id', 'local_id'], 'integer'],
            [['data_visita', 'data_criacao'], 'safe'],
            [['preco_total'], 'number'],
            [['estado'], 'string'],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['utilizador_id' => 'id']],
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
            'utilizador_id' => 'Utilizador ID',
            'local_id' => 'Local ID',
            'data_visita' => 'Data Visita',
            'preco_total' => 'Preco Total',
            'estado' => 'Estado',
            'data_criacao' => 'Data Criacao',
        ];
    }

    /**
     * Gets query for [[LinhaReservas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaReservas()
    {
        return $this->hasMany(LinhaReserva::class, ['reserva_id' => 'id']);
    }

    /**
     * Gets query for [[Local]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocal()
    {
        return $this->hasOne(LocalCultural::class, ['id' => 'local_id']);
    }

    /**
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(User::class, ['id' => 'utilizador_id']);
    }


    /**
     * column estado ENUM value labels
     * @return string[]
     */
    public static function optsEstado()
    {
        return [
            self::ESTADO_EXPIRADO => 'Pendente',
            self::ESTADO_CONFIRMADA => 'Confirmada',
            self::ESTADO_CANCELADA => 'Cancelada',
        ];
    }

    /**
     * @return string
     */
    public function displayEstado()
    {
        return self::optsEstado()[$this->estado];
    }

    /**
     * @return bool
     */
    public function isEstadoExpirado()
    {
        return $this->estado === self::ESTADO_EXPIRADO;
    }

    public function setEstadoToExpirado()
    {
        $this->estado = self::ESTADO_EXPIRADO;
    }

    /**
     * @return bool
     */
    public function isEstadoConfirmada()
    {
        return $this->estado === self::ESTADO_CONFIRMADA;
    }

    public function setEstadoToConfirmada()
    {
        $this->estado = self::ESTADO_CONFIRMADA;
    }

    /**
     * @return bool
     */
    public function isEstadoCancelada()
    {
        return $this->estado === self::ESTADO_CANCELADA;
    }

    public function setEstadoToCancelada()
    {
        $this->estado = self::ESTADO_CANCELADA;
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    //Metodos adicionados
    /**
     * Guarda uma nova reserva com os seus bilhetes
     * @param array $postData Dados do formulário
     * @return Reserva|null Retorna a reserva criada ou null em caso de erro
     * @throws \Exception
     */
    public function GuardarReserva($postData)
    {
        // 1. Validar se os dados essenciais existem
        if (empty($postData['local_id'])) {
            throw new \Exception('Local não especificado.');
        }

        if (empty($postData['bilhetes'])) {
            throw new \Exception('Nenhum bilhete selecionado.');
        }

        // 2. Verificar se há pelo menos 1 bilhete com quantidade > 0
        $temBilhetes = false;
        foreach ($postData['bilhetes'] as $bilhete) {
            if (isset($bilhete['quantidade']) && $bilhete['quantidade'] > 0) {
                $temBilhetes = true;
                break;
            }
        }

        if (!$temBilhetes) {
            throw new \Exception('Selecione pelo menos 1 bilhete com quantidade maior que 0.');
        }

        foreach ($postData['bilhetes'] as $tipoBilheteId => $bilheteData) {
            $quantidade = (int)($bilheteData['quantidade'] ?? 0);

            if ($quantidade > 0) {
                // IMPORTANTE: Buscar o preço real da BD, não confiar no POST
                $tipoBilhete = TipoBilhete::findOne($tipoBilheteId);

                if ($tipoBilhete === null) {
                    throw new \Exception("Tipo de bilhete inválido: {$tipoBilheteId}");
                }

                $precoUnitario = floatval($tipoBilhete->preco);
                $subtotal = $quantidade * $precoUnitario;
                $precoTotal += $subtotal;

                // Guardar para criar as linhas depois
                $bilhetesParaGravar[] = [
                    'tipo_bilhete_id' => $tipoBilheteId,
                    'quantidade' => $quantidade,
                    'preco_unitario' => $precoUnitario,
                    'subtotal' => $subtotal,
                ];
            }
        }

        // 4. Iniciar transação
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // 4.1. Preencher os dados da reserva
            $this->utilizador_id = Yii::$app->user->id;
            $this->local_id = $postData['local_id'];
            $this->data_visita = $postData['data_visita'] ?? date('Y-m-d'); // ou podes pedir no formulário
            $this->preco_total = $precoTotal;
            $this->setEstadoToExpirado(); // Usar o método que já tens
            $this->data_criacao = date('Y-m-d H:i:s');

            // 4.2. Gravar a reserva
            if (!$this->save()) {
                throw new \Exception('Erro ao gravar reserva: ' . json_encode($this->errors));
            }

            // PRÓXIMO PASSO: Gravar as linhas de reserva
            // (vou dar-te no próximo bloco)

            $transaction->commit();
            return $this;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e; // Re-lançar a exceção para o controller tratar
        }
    }
}
