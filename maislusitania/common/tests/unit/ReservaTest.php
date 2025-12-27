<?php

namespace common\tests\Unit;

use common\models\Reserva;
use common\models\LocalCultural;
use common\models\User;
use common\models\TipoBilhete;
use common\models\LinhaReserva;
use common\fixtures\UserFixture;
use common\tests\UnitTester;
use yii\db\ActiveQuery;
use Yii;

class ReservaTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    protected function _before()
    {
    }

    // Testes de constantes
    public function testConstantesEstado()
    {
        $this->assertEquals('Expirado', Reserva::ESTADO_EXPIRADO);
        $this->assertEquals('Confirmada', Reserva::ESTADO_CONFIRMADA);
        $this->assertEquals('Cancelada', Reserva::ESTADO_CANCELADA);
    }

    // Testes de validação de modelo
    public function testModeloRequerCamposObrigatorios()
    {
        $reserva = new Reserva();
        $this->assertFalse($reserva->validate());
        
        $this->assertArrayHasKey('utilizador_id', $reserva->errors);
        $this->assertArrayHasKey('local_id', $reserva->errors);
        $this->assertArrayHasKey('data_visita', $reserva->errors);
        $this->assertArrayHasKey('preco_total', $reserva->errors);
    }

    public function testModeloComDadosValidos()
    {
        $reserva = new Reserva();
        $reserva->utilizador_id = 1;
        $reserva->local_id = 1;
        $reserva->data_visita = date('Y-m-d', strtotime('+1 day'));
        $reserva->preco_total = 50.00;
        $reserva->estado = Reserva::ESTADO_CONFIRMADA;
        
        $this->assertInstanceOf(Reserva::class, $reserva);
    }

    public function testEstadoDeveSerValorEnum()
    {
        $reserva = new Reserva();
        $reserva->utilizador_id = 1;
        $reserva->local_id = 1;
        $reserva->data_visita = date('Y-m-d', strtotime('+1 day'));
        $reserva->preco_total = 50.00;
        $reserva->estado = 'EstadoInvalido';
        
        $this->assertFalse($reserva->validate(['estado']));
        $this->assertArrayHasKey('estado', $reserva->errors);
    }

    // Testes de métodos de estado
    public function testIsEstadoExpirado()
    {
        $reserva = new Reserva();
        $reserva->estado = Reserva::ESTADO_EXPIRADO;
        $this->assertTrue($reserva->isEstadoExpirado());
        
        $reserva->estado = Reserva::ESTADO_CONFIRMADA;
        $this->assertFalse($reserva->isEstadoExpirado());
    }

    public function testIsEstadoConfirmada()
    {
        $reserva = new Reserva();
        $reserva->estado = Reserva::ESTADO_CONFIRMADA;
        $this->assertTrue($reserva->isEstadoConfirmada());
        
        $reserva->estado = Reserva::ESTADO_EXPIRADO;
        $this->assertFalse($reserva->isEstadoConfirmada());
    }

    public function testIsEstadoCancelada()
    {
        $reserva = new Reserva();
        $reserva->estado = Reserva::ESTADO_CANCELADA;
        $this->assertTrue($reserva->isEstadoCancelada());
        
        $reserva->estado = Reserva::ESTADO_CONFIRMADA;
        $this->assertFalse($reserva->isEstadoCancelada());
    }

    public function testSetEstadoToExpirado()
    {
        $reserva = new Reserva();
        $reserva->setEstadoToExpirado();
        $this->assertEquals(Reserva::ESTADO_EXPIRADO, $reserva->estado);
    }

    public function testSetEstadoToConfirmada()
    {
        $reserva = new Reserva();
        $reserva->setEstadoToConfirmada();
        $this->assertEquals(Reserva::ESTADO_CONFIRMADA, $reserva->estado);
    }

    public function testSetEstadoToCancelada()
    {
        $reserva = new Reserva();
        $reserva->setEstadoToCancelada();
        $this->assertEquals(Reserva::ESTADO_CANCELADA, $reserva->estado);
    }

    // Testes de opções de estado
    public function testOptsEstado()
    {
        $opts = Reserva::optsEstado();
        
        $this->assertIsArray($opts);
        $this->assertArrayHasKey(Reserva::ESTADO_EXPIRADO, $opts);
        $this->assertArrayHasKey(Reserva::ESTADO_CONFIRMADA, $opts);
        $this->assertArrayHasKey(Reserva::ESTADO_CANCELADA, $opts);
        $this->assertEquals('Pendente', $opts[Reserva::ESTADO_EXPIRADO]);
        $this->assertEquals('Confirmada', $opts[Reserva::ESTADO_CONFIRMADA]);
        $this->assertEquals('Cancelada', $opts[Reserva::ESTADO_CANCELADA]);
    }

    public function testDisplayEstado()
    {
        $reserva = new Reserva();
        $reserva->estado = Reserva::ESTADO_CONFIRMADA;
        $this->assertEquals('Confirmada', $reserva->displayEstado());
        
        $reserva->estado = Reserva::ESTADO_CANCELADA;
        $this->assertEquals('Cancelada', $reserva->displayEstado());
    }

    // Testes de validação de data
    public function testValidateDataComDataValida()
    {
        $timestamp = strtotime('+1 day');
        // If tomorrow is Sunday, use Monday instead to make the test deterministic
        if (date('w', $timestamp) == 0) {
            $timestamp = strtotime('+2 days');
        }
        $dataFutura = date('Y-m-d', $timestamp);
        $this->assertTrue(Reserva::validateData($dataFutura));
    }

    public function testValidateDataComDataPassada()
    {
        $dataPassada = date('Y-m-d', strtotime('-1 day'));
        $this->assertFalse(Reserva::validateData($dataPassada));
    }

    public function testValidateDataComDomingo()
    {
        // Encontrar o próximo domingo
        $proximoDomingo = date('Y-m-d', strtotime('next Sunday'));
        $this->assertFalse(Reserva::validateData($proximoDomingo));
    }

    public function testValidateDataComDataInvalida()
    {
        $this->assertFalse(Reserva::validateData('2024-13-45')); // Data inválida
        $this->assertFalse(Reserva::validateData('data-invalida'));
    }

    public function testValidateDataComDataHoje()
    {
        $hoje = date('Y-m-d');
        // Verificar se hoje não é domingo
        if (date('w') != 0) {
            $this->assertTrue(Reserva::validateData($hoje));
        } else {
            $this->assertFalse(Reserva::validateData($hoje));
        }
    }

    // Testes de relacionamentos
    public function testGetLinhaReservas()
    {
        $reserva = new Reserva();
        $this->assertInstanceOf(ActiveQuery::class, $reserva->getLinhaReservas());
    }

    public function testGetLocal()
    {
        $reserva = new Reserva();
        $this->assertInstanceOf(ActiveQuery::class, $reserva->getLocal());
    }

    public function testGetUtilizador()
    {
        $reserva = new Reserva();
        $this->assertInstanceOf(ActiveQuery::class, $reserva->getUtilizador());
    }

    // Testes de método GuardarReserva - validações de entrada
    public function testGuardarReservaSemLocalId()
    {
        $reserva = new Reserva();
        $postData = ['bilhetes' => []];
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Local não especificado.');
        $reserva->GuardarReserva($postData);
    }

    public function testGuardarReservaSemBilhetes()
    {
        $reserva = new Reserva();
        $postData = ['local_id' => 1];
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nenhum bilhete selecionado.');
        $reserva->GuardarReserva($postData);
    }

    public function testGuardarReservaComBilhetesVazios()
    {
        $reserva = new Reserva();
        $postData = ['local_id' => 1, 'bilhetes' => []];
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nenhum bilhete selecionado.');
        $reserva->GuardarReserva($postData);
    }

    // Testes de obterDadosConfirmacao
    public function testObterDadosConfirmacaoSemLocalId()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Local não especificado.');
        Reserva::obterDadosConfirmacao([]);
    }

    public function testObterDadosConfirmacaoComBilhetesVazios()
    {
        $postData = ['local_id' => 1, 'bilhetes' => []];
        
        $this->expectException(\Exception::class);
        Reserva::obterDadosConfirmacao($postData);
    }

    // Teste de atributos
    public function testAttributeLabels()
    {
        $reserva = new Reserva();
        $labels = $reserva->attributeLabels();
        
        $this->assertArrayHasKey('id', $labels);
        $this->assertArrayHasKey('utilizador_id', $labels);
        $this->assertArrayHasKey('local_id', $labels);
        $this->assertArrayHasKey('data_visita', $labels);
        $this->assertArrayHasKey('preco_total', $labels);
        $this->assertArrayHasKey('estado', $labels);
        $this->assertArrayHasKey('data_criacao', $labels);
    }

    // Teste de nome da tabela
    public function testTableName()
    {
        $this->assertEquals('reserva', Reserva::tableName());
    }

    // Teste de regras
    public function testRules()
    {
        $reserva = new Reserva();
        $rules = $reserva->rules();
        
        $this->assertIsArray($rules);
        $this->assertNotEmpty($rules);
    }

    // Teste de preço total numérico
    public function testPrecoTotalDeveSerNumero()
    {
        $reserva = new Reserva();
        $reserva->utilizador_id = 1;
        $reserva->local_id = 1;
        $reserva->data_visita = date('Y-m-d', strtotime('+1 day'));
        $reserva->preco_total = 'nao-numerico';
        
        $this->assertFalse($reserva->validate(['preco_total']));
    }

    public function testPrecoTotalComValorValido()
    {
        $reserva = new Reserva();
        $reserva->preco_total = 99.99;
        
        $this->assertTrue($reserva->validate(['preco_total']));
    }

    // =====================================================
    // TESTES DE INTEGRAÇÃO COM A BASE DE DADOS (CRUD)
    // =====================================================

    /**
     * Helper para criar um LocalCultural para os testes
     */
    private function criarLocalCultural()
    {
        $local = new LocalCultural([
            'nome' => 'Local Teste Reserva',
            'tipo_id' => 1,
            'morada' => 'Rua Teste',
            'distrito_id' => 1,
            'descricao' => 'Descrição teste',
            'latitude' => 40.0,
            'longitude' => -8.0,
        ]);
        $local->save();
        return $local;
    }

    /**
     * Helper para obter uma data válida (não domingo, não passado)
     */
    private function obterDataValida()
    {
        $timestamp = strtotime('+1 day');
        if (date('w', $timestamp) == 0) {
            $timestamp = strtotime('+2 days');
        }
        return date('Y-m-d', $timestamp);
    }

    public function testSaveAndFindReserva()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        $reserva = new Reserva([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
            'data_visita' => $this->obterDataValida(),
            'preco_total' => 50.00,
            'estado' => Reserva::ESTADO_CONFIRMADA,
            'data_criacao' => date('Y-m-d H:i:s'),
        ]);

        $this->assertTrue($reserva->save(), 'Reserva deveria ser guardada.');

        $foundReserva = Reserva::findOne($reserva->id);
        $this->assertInstanceOf(Reserva::class, $foundReserva);
        $this->assertEquals(50.00, $foundReserva->preco_total);
        $this->assertEquals($user['id'], $foundReserva->utilizador_id);
    }

    public function testUpdateReserva()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        $reserva = new Reserva([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
            'data_visita' => $this->obterDataValida(),
            'preco_total' => 50.00,
            'estado' => Reserva::ESTADO_CONFIRMADA,
            'data_criacao' => date('Y-m-d H:i:s'),
        ]);
        $this->assertTrue($reserva->save());

        $reserva->preco_total = 75.00;
        $reserva->setEstadoToCancelada();
        $this->assertTrue($reserva->save());

        $foundReserva = Reserva::findOne($reserva->id);
        $this->assertEquals(75.00, $foundReserva->preco_total);
        $this->assertEquals(Reserva::ESTADO_CANCELADA, $foundReserva->estado);
    }

    public function testDeleteReserva()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        $reserva = new Reserva([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
            'data_visita' => $this->obterDataValida(),
            'preco_total' => 50.00,
            'estado' => Reserva::ESTADO_CONFIRMADA,
            'data_criacao' => date('Y-m-d H:i:s'),
        ]);
        $this->assertTrue($reserva->save());
        $id = $reserva->id;

        $this->assertEquals(1, $reserva->delete());
        $this->assertNull(Reserva::findOne($id));
    }

    public function testReservaRelacionamentoComUtilizador()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        $reserva = new Reserva([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
            'data_visita' => $this->obterDataValida(),
            'preco_total' => 50.00,
            'estado' => Reserva::ESTADO_CONFIRMADA,
            'data_criacao' => date('Y-m-d H:i:s'),
        ]);
        $this->assertTrue($reserva->save());

        $reserva = Reserva::findOne($reserva->id);
        $this->assertInstanceOf(User::class, $reserva->utilizador);
        $this->assertEquals($user['username'], $reserva->utilizador->username);
    }

    public function testReservaRelacionamentoComLocal()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        $reserva = new Reserva([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
            'data_visita' => $this->obterDataValida(),
            'preco_total' => 50.00,
            'estado' => Reserva::ESTADO_CONFIRMADA,
            'data_criacao' => date('Y-m-d H:i:s'),
        ]);
        $this->assertTrue($reserva->save());

        $reserva = Reserva::findOne($reserva->id);
        $this->assertInstanceOf(LocalCultural::class, $reserva->local);
        $this->assertEquals('Local Teste Reserva', $reserva->local->nome);
    }

    public function testReservaComLinhaReservas()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        // Criar tipo de bilhete
        $tipoBilhete = new TipoBilhete([
            'local_id' => $local->id,
            'nome' => 'Bilhete Adulto',
            'preco' => 10.00,
            'descricao' => 'Bilhete para adultos',
            'ativo' => 1,
        ]);
        $this->assertTrue($tipoBilhete->save(), 'TipoBilhete deveria ser guardado. Erros: ' . json_encode($tipoBilhete->errors));

        // Criar reserva
        $reserva = new Reserva([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
            'data_visita' => $this->obterDataValida(),
            'preco_total' => 30.00,
            'estado' => Reserva::ESTADO_CONFIRMADA,
            'data_criacao' => date('Y-m-d H:i:s'),
        ]);
        $this->assertTrue($reserva->save(), 'Reserva deveria ser guardada. Erros: ' . json_encode($reserva->errors));

        // Criar linha de reserva
        $linhaReserva = new LinhaReserva([
            'reserva_id' => $reserva->id,
            'tipo_bilhete_id' => $tipoBilhete->id,
            'quantidade' => 3,
        ]);
        $this->assertTrue($linhaReserva->save(), 'LinhaReserva deveria ser guardada. Erros: ' . json_encode($linhaReserva->errors));

        // Verificar relacionamento
        $reserva = Reserva::findOne($reserva->id);
        $this->assertCount(1, $reserva->linhaReservas);
        $this->assertEquals(3, $reserva->linhaReservas[0]->quantidade);
    }

    public function testMultiplasReservasMesmoUtilizador()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        // Criar primeira reserva
        $reserva1 = new Reserva([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
            'data_visita' => $this->obterDataValida(),
            'preco_total' => 50.00,
            'estado' => Reserva::ESTADO_CONFIRMADA,
            'data_criacao' => date('Y-m-d H:i:s'),
        ]);
        $this->assertTrue($reserva1->save());

        // Criar segunda reserva
        $reserva2 = new Reserva([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
            'data_visita' => $this->obterDataValida(),
            'preco_total' => 75.00,
            'estado' => Reserva::ESTADO_CONFIRMADA,
            'data_criacao' => date('Y-m-d H:i:s'),
        ]);
        $this->assertTrue($reserva2->save());

        // Verificar que ambas existem
        $reservas = Reserva::find()->where(['utilizador_id' => $user['id']])->all();
        $this->assertCount(2, $reservas);
    }

    public function testReservaComDiferentesEstados()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        $reserva = new Reserva([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
            'data_visita' => $this->obterDataValida(),
            'preco_total' => 50.00,
            'estado' => Reserva::ESTADO_CONFIRMADA,
            'data_criacao' => date('Y-m-d H:i:s'),
        ]);
        $this->assertTrue($reserva->save());
        $this->assertTrue($reserva->isEstadoConfirmada());

        $reserva->setEstadoToCancelada();
        $this->assertTrue($reserva->save());
        
        $reserva = Reserva::findOne($reserva->id);
        $this->assertTrue($reserva->isEstadoCancelada());
        $this->assertEquals('Cancelada', $reserva->displayEstado());
    }
}
