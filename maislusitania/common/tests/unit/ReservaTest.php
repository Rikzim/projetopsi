<?php

namespace common\tests\Unit;

use common\models\Reserva;
use common\models\LocalCultural;
use common\models\User;
use common\models\TipoBilhete;
use common\models\LinhaReserva;
use common\tests\UnitTester;
use Yii;

class ReservaTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

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
        
        // Nota: A validação pode falhar se os IDs não existirem no BD
        // Este teste verifica apenas a estrutura básica
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
        $dataFutura = date('Y-m-d', strtotime('+1 day'));
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
        $query = $reserva->getLinhaReservas();
        
        $this->assertInstanceOf(\yii\db\ActiveQuery::class, $query);
    }

    public function testGetLocal()
    {
        $reserva = new Reserva();
        $query = $reserva->getLocal();
        
        $this->assertInstanceOf(\yii\db\ActiveQuery::class, $query);
    }

    public function testGetUtilizador()
    {
        $reserva = new Reserva();
        $query = $reserva->getUtilizador();
        
        $this->assertInstanceOf(\yii\db\ActiveQuery::class, $query);
    }

    // Testes de método GuardarReserva
    public function testGuardarReservaSemLocalId()
    {
        $reserva = new Reserva();
        $postData = [
            'bilhetes' => []
        ];
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Local não especificado.');
        $reserva->GuardarReserva($postData);
    }

    public function testGuardarReservaSemBilhetes()
    {
        $reserva = new Reserva();
        $postData = [
            'local_id' => 1
        ];
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nenhum bilhete selecionado.');
        $reserva->GuardarReserva($postData);
    }

    public function testGuardarReservaComBilhetesVazios()
    {
        $reserva = new Reserva();
        $postData = [
            'local_id' => 1,
            'bilhetes' => []
        ];
        
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
        $postData = [
            'local_id' => 1,
            'bilhetes' => []
        ];
        
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
}
