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
    const ESTADO_PENDENTE = 'Pendente';
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
            self::ESTADO_PENDENTE => 'Pendente',
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
    public function isEstadoPendente()
    {
        return $this->estado === self::ESTADO_PENDENTE;
    }

    public function setEstadoToPendente()
    {
        $this->estado = self::ESTADO_PENDENTE;
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
     * Validar e preparar dados dos bilhetes
     * @param array $bilhetesPost
     * @return array ['bilhetes' => [], 'precoTotal' => 0]
     * @throws \Exception
     */
    private function prepararBilhetes($bilhetesPost)
    {
        $bilhetesParaGravar = [];
        $precoTotal = 0;

        foreach ($bilhetesPost as $tipoBilheteId => $bilheteData) {
            $quantidade = (int)($bilheteData['quantidade'] ?? 0);

            if ($quantidade > 0) {
                $tipoBilhete = TipoBilhete::findOne($tipoBilheteId);

                if ($tipoBilhete === null) {
                    throw new \Exception("Tipo de bilhete inválido: {$tipoBilheteId}");
                }

                $precoUnitario = floatval($tipoBilhete->preco);
                $subtotal = $quantidade * $precoUnitario;
                $precoTotal += $subtotal;

                $bilhetesParaGravar[] = [
                    'tipo_bilhete_id' => $tipoBilheteId,
                    'tipo' => $tipoBilhete->nome, // Para exibir na confirmação
                    'quantidade' => $quantidade,
                    'preco_unitario' => $precoUnitario,
                    'subtotal' => $subtotal,
                ];
            }
        }

        if (empty($bilhetesParaGravar)) {
            throw new \Exception('Selecione pelo menos 1 bilhete com quantidade maior que 0.');
        }

        return [
            'bilhetes' => $bilhetesParaGravar,
            'precoTotal' => $precoTotal,
        ];
    }

    /**
     * Simplificar GuardarReserva
     */
    public function GuardarReserva($postData)
    {
        // 1. Validações básicas
        if (empty($postData['local_id'])) {
            throw new \Exception('Local não especificado.');
        }

        if (empty($postData['bilhetes'])) {
            throw new \Exception('Nenhum bilhete selecionado.');
        }

        // 2. Preparar bilhetes (validação + cálculo)
        $dadosBilhetes = $this->prepararBilhetes($postData['bilhetes']);

        // 3. Gravar com transação
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->utilizador_id = Yii::$app->user->id;
            $this->local_id = $postData['local_id'];
            $this->data_visita = $postData['data_visita'] ?? date('Y-m-d');
            $this->preco_total = $dadosBilhetes['precoTotal'];
            $this->setEstadoToPendente();
            $this->data_criacao = date('Y-m-d H:i:s');

            if (!$this->save()) {
                throw new \Exception('Erro ao gravar reserva: ' . json_encode($this->errors));
            }

            // Gravar linhas
            foreach ($dadosBilhetes['bilhetes'] as $bilheteData) {
                $linhaReserva = new LinhaReserva();
                $linhaReserva->reserva_id = $this->id;
                $linhaReserva->tipo_bilhete_id = $bilheteData['tipo_bilhete_id'];
                $linhaReserva->quantidade = $bilheteData['quantidade'];

                if (!$linhaReserva->save()) {
                    throw new \Exception('Erro ao gravar linha: ' . json_encode($linhaReserva->errors));
                }
            }

            $transaction->commit();
            return $this;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Obter dados para página de create/confirmação
     */
    public static function obterDadosConfirmacao($postData)
    {
        if (empty($postData['local_id'])) {
            throw new \Exception('Local não especificado.');
        }

        $local = \common\models\LocalCultural::findOne($postData['local_id']);
        if (!$local) {
            throw new \Exception('Local não encontrado.');
        }

        // Reutilizar a lógica privada através de uma instância temporária
        $reservaTemp = new self();
        $dadosBilhetes = $reservaTemp->prepararBilhetes($postData['bilhetes'] ?? []);

        return [
            'local' => $local,
            'bilhetes' => $dadosBilhetes['bilhetes'],
            'precoTotal' => $dadosBilhetes['precoTotal'],
        ];
    }
}
