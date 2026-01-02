<?php

namespace common\tests\Unit;

use common\models\Evento;
use common\models\LocalCultural;
use common\fixtures\LocalCulturalFixture;
use common\tests\UnitTester;
use yii\db\ActiveQuery;

class EventoTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'local' => [
                'class' => LocalCulturalFixture::class,
                'dataFile' => codecept_data_dir() . 'local_cultural.php'
            ]
        ];
    }

    protected function _before()
    {
    }

    // =====================================================
    // TESTES DE NOME DA TABELA
    // =====================================================

    public function testNomeDaTabela()
    {
        $this->assertEquals('evento', Evento::tableName());
    }

    // =====================================================
    // TESTES DE CONSTANTES
    // =====================================================

    public function testConstanteStatusAtivo()
    {
        $this->assertEquals(10, Evento::STATUS_ACTIVE);
    }

    // =====================================================
    // TESTES DE VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS
    // =====================================================

    public function testValidacaoCamposObrigatorios()
    {
        $evento = new Evento();
        $this->assertFalse($evento->validate());
        $this->assertArrayHasKey('local_id', $evento->errors);
        $this->assertArrayHasKey('titulo', $evento->errors);
        $this->assertArrayHasKey('data_inicio', $evento->errors);
    }

    public function testValidacaoComDadosValidos()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $evento = new Evento();
        $evento->local_id = $local['id'];
        $evento->titulo = 'Evento Teste';
        $evento->data_inicio = '2024-01-01';
        
        $evento->validate(['local_id', 'titulo', 'data_inicio']);
        
        $this->assertArrayNotHasKey('titulo', $evento->errors);
        $this->assertArrayNotHasKey('data_inicio', $evento->errors);
        $this->assertArrayNotHasKey('local_id', $evento->errors);
    }

    public function testTituloNaoPodeSerVazio()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $evento = new Evento();
        $evento->local_id = $local['id'];
        $evento->titulo = '';
        $evento->data_inicio = '2024-01-01';
        
        $evento->validate(['titulo']);
        $this->assertArrayHasKey('titulo', $evento->errors);
    }

    // =====================================================
    // TESTES DE VALIDAÇÃO DE COMPRIMENTO
    // =====================================================

    public function testTituloComprimentoMaximo()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $evento = new Evento();
        $evento->local_id = $local['id'];
        $evento->titulo = str_repeat('a', 201);
        $evento->data_inicio = '2024-01-01';
        
        $evento->validate(['titulo']);
        $this->assertArrayHasKey('titulo', $evento->errors);
    }

    public function testTituloComprimentoValido()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $evento = new Evento();
        $evento->local_id = $local['id'];
        $evento->titulo = str_repeat('a', 200);
        $evento->data_inicio = '2024-01-01';
        
        $evento->validate(['titulo']);
        $this->assertArrayNotHasKey('titulo', $evento->errors);
    }

    public function testImagemComprimentoMaximo()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $evento = new Evento();
        $evento->local_id = $local['id'];
        $evento->titulo = 'Evento Teste';
        $evento->data_inicio = '2024-01-01';
        $evento->imagem = str_repeat('a', 256);
        
        $evento->validate(['imagem']);
        $this->assertArrayHasKey('imagem', $evento->errors);
    }

    public function testImagemComprimentoValido()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $evento = new Evento();
        $evento->local_id = $local['id'];
        $evento->titulo = 'Evento Teste';
        $evento->data_inicio = '2024-01-01';
        $evento->imagem = str_repeat('a', 255);
        
        $evento->validate(['imagem']);
        $this->assertArrayNotHasKey('imagem', $evento->errors);
    }

    // =====================================================
    // TESTES DE VALIDAÇÃO DE TIPOS
    // =====================================================

    public function testLocalIdDeveSerInteiro()
    {
        $evento = new Evento();
        $evento->local_id = 'abc';
        $evento->titulo = 'Evento Teste';
        $evento->data_inicio = '2024-01-01';
        
        $evento->validate(['local_id']);
        $this->assertArrayHasKey('local_id', $evento->errors);
    }

    public function testLocalIdAceitaInteiroValido()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $evento = new Evento();
        $evento->local_id = $local['id'];
        $evento->titulo = 'Evento Teste';
        $evento->data_inicio = '2024-01-01';
        
        $evento->validate(['local_id']);
        $this->assertArrayNotHasKey('local_id', $evento->errors);
    }

    public function testAtivoDeveSerInteiro()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $evento = new Evento();
        $evento->local_id = $local['id'];
        $evento->titulo = 'Evento Teste';
        $evento->data_inicio = '2024-01-01';
        $evento->ativo = 'abc';
        
        $evento->validate(['ativo']);
        $this->assertArrayHasKey('ativo', $evento->errors);
    }

    public function testAtivoAceitaInteiroValido()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $evento = new Evento();
        $evento->local_id = $local['id'];
        $evento->titulo = 'Evento Teste';
        $evento->data_inicio = '2024-01-01';
        $evento->ativo = 1;
        
        $evento->validate(['ativo']);
        $this->assertArrayNotHasKey('ativo', $evento->errors);
    }

    // =====================================================
    // TESTES DE VALORES PADRÃO
    // =====================================================

    public function testValoresPadrao()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $evento = new Evento();
        $evento->local_id = $local['id'];
        $evento->titulo = 'Evento Teste';
        $evento->data_inicio = '2024-01-01';
        
        $evento->validate();
        
        $this->assertNull($evento->descricao);
        $this->assertNull($evento->data_fim);
        $this->assertNull($evento->imagem);
    }

    public function testValorPadraoAtivo()
    {
        $evento = new Evento();
        $evento->loadDefaultValues();
        
        $this->assertEquals(1, $evento->ativo);
    }

    // =====================================================
    // TESTES DE CAMPOS OPCIONAIS
    // =====================================================

    public function testDescricaoOpcional()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $evento = new Evento();
        $evento->local_id = $local['id'];
        $evento->titulo = 'Evento Teste';
        $evento->data_inicio = '2024-01-01';
        $evento->descricao = null;
        
        $this->assertTrue($evento->validate());
    }

    public function testDataFimOpcional()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $evento = new Evento();
        $evento->local_id = $local['id'];
        $evento->titulo = 'Evento Teste';
        $evento->data_inicio = '2024-01-01';
        $evento->data_fim = null;
        
        $this->assertTrue($evento->validate());
    }

    // =====================================================
    // TESTES DE ATRIBUTOS E LABELS
    // =====================================================

    public function testRotulosAtributos()
    {
        $evento = new Evento();
        $labels = $evento->attributeLabels();
        
        $this->assertEquals('ID', $labels['id']);
        $this->assertEquals('Local', $labels['local_id']);
        $this->assertEquals('Titulo', $labels['titulo']);
        $this->assertEquals('Descricao', $labels['descricao']);
        $this->assertEquals('Data Inicio', $labels['data_inicio']);
        $this->assertEquals('Data Fim', $labels['data_fim']);
        $this->assertEquals('Imagem', $labels['imagem']);
        $this->assertEquals('Ativo', $labels['ativo']);
    }

    // =====================================================
    // TESTES DE MÉTODOS AUXILIARES
    // =====================================================

    public function testObterImagemRetornaNuloQuandoVazio()
    {
        $evento = new Evento();
        $evento->imagem = null;
        
        $this->assertNull($evento->getImage());
    }

    public function testObterImagemRetornaCaminho()
    {
        $evento = new Evento();
        $evento->imagem = 'test.jpg';
        
        $this->assertEquals('/uploads/test.jpg', $evento->getImage());
    }

    public function testObterImagemAPIRetornaNuloQuandoVazio()
    {
        $evento = new Evento();
        $evento->imagem = null;
        
        $this->assertNull($evento->getImageAPI());
    }

    // =====================================================
    // TESTES DE RELACIONAMENTOS
    // =====================================================

    public function testGetLocal()
    {
        $evento = new Evento();
        $this->assertInstanceOf(ActiveQuery::class, $evento->getLocal());
    }

    // =====================================================
    // TESTES DE INTEGRAÇÃO COM A BASE DE DADOS (CRUD)
    // =====================================================

    public function testGuardarEEncontrarEvento()
    {
        $local = $this->tester->grabFixture('local', 0);

        $evento = new Evento([
            'local_id' => $local['id'],
            'titulo' => 'Concerto de Música Clássica',
            'descricao' => 'Um evento cultural imperdível',
            'data_inicio' => '2025-06-15 20:00:00',
            'data_fim' => '2025-06-15 22:30:00',
            'imagem' => 'concerto.jpg',
            'ativo' => 1,
        ]);

        $this->assertTrue($evento->save(), 'Evento deveria ser guardado.');

        $eventoEncontrado = Evento::findOne($evento->id);
        $this->assertInstanceOf(Evento::class, $eventoEncontrado);
        $this->assertEquals('Concerto de Música Clássica', $eventoEncontrado->titulo);
        $this->assertEquals($local['id'], $eventoEncontrado->local_id);
        $this->assertEquals('2025-06-15 20:00:00', $eventoEncontrado->data_inicio);
    }

    public function testAtualizarEvento()
    {
        $local = $this->tester->grabFixture('local', 0);

        $evento = new Evento([
            'local_id' => $local['id'],
            'titulo' => 'Exposição de Arte',
            'data_inicio' => '2025-07-01 10:00:00',
            'ativo' => 1,
        ]);
        $this->assertTrue($evento->save());

        $evento->titulo = 'Exposição de Arte Moderna';
        $evento->descricao = 'Obras de artistas contemporâneos';
        $evento->data_fim = '2025-07-31 18:00:00';
        $this->assertTrue($evento->save());

        $eventoAtualizado = Evento::findOne($evento->id);
        $this->assertEquals('Exposição de Arte Moderna', $eventoAtualizado->titulo);
        $this->assertEquals('Obras de artistas contemporâneos', $eventoAtualizado->descricao);
        $this->assertEquals('2025-07-31 18:00:00', $eventoAtualizado->data_fim);
    }

    public function testEliminarEvento()
    {
        $local = $this->tester->grabFixture('local', 0);

        $evento = new Evento([
            'local_id' => $local['id'],
            'titulo' => 'Evento Temporário',
            'data_inicio' => '2025-08-01 14:00:00',
            'ativo' => 1,
        ]);
        $this->assertTrue($evento->save());
        $id = $evento->id;

        $this->assertEquals(1, $evento->delete());
        $this->assertNull(Evento::findOne($id));
    }

    public function testEventoRelacionamentoComLocal()
    {
        $local = $this->tester->grabFixture('local', 0);

        $evento = new Evento([
            'local_id' => $local['id'],
            'titulo' => 'Festival de Teatro',
            'data_inicio' => '2025-09-10 19:00:00',
            'ativo' => 1,
        ]);
        $this->assertTrue($evento->save());

        $evento = Evento::findOne($evento->id);
        $this->assertInstanceOf(LocalCultural::class, $evento->local);
        $this->assertEquals($local['nome'], $evento->local->nome);
    }

    public function testMultiplosEventosMesmoLocal()
    {
        $local = $this->tester->grabFixture('local', 0);

        $evento1 = new Evento([
            'local_id' => $local['id'],
            'titulo' => 'Evento 1',
            'data_inicio' => '2025-10-01 15:00:00',
            'ativo' => 1,
        ]);
        $this->assertTrue($evento1->save());

        $evento2 = new Evento([
            'local_id' => $local['id'],
            'titulo' => 'Evento 2',
            'data_inicio' => '2025-10-15 16:30:00',
            'ativo' => 1,
        ]);
        $this->assertTrue($evento2->save());

        $eventos = Evento::find()->where(['local_id' => $local['id']])->all();
        $this->assertGreaterThanOrEqual(2, count($eventos));
    }

    public function testEventoComImagemCompleta()
    {
        $local = $this->tester->grabFixture('local', 0);

        $evento = new Evento([
            'local_id' => $local['id'],
            'titulo' => 'Evento com Imagem',
            'data_inicio' => '2025-11-01 11:00:00',
            'imagem' => 'evento_especial.jpg',
            'ativo' => 1,
        ]);
        $this->assertTrue($evento->save());

        $eventoEncontrado = Evento::findOne($evento->id);
        $this->assertEquals('/uploads/evento_especial.jpg', $eventoEncontrado->getImage());
    }

    public function testEventoAtivoInativo()
    {
        $local = $this->tester->grabFixture('local', 0);

        $evento = new Evento([
            'local_id' => $local['id'],
            'titulo' => 'Evento Ativo',
            'data_inicio' => '2025-12-01 09:00:00',
            'ativo' => 1,
        ]);
        $this->assertTrue($evento->save());
        $this->assertEquals(1, $evento->ativo);

        $evento->ativo = 0;
        $this->assertTrue($evento->save());

        $eventoAtualizado = Evento::findOne($evento->id);
        $this->assertEquals(0, $eventoAtualizado->ativo);
    }

    public function testEventoComDataInicioEFim()
    {
        $local = $this->tester->grabFixture('local', 0);

        $evento = new Evento([
            'local_id' => $local['id'],
            'titulo' => 'Evento com Duração',
            'data_inicio' => '2026-01-10 14:00:00',
            'data_fim' => '2026-01-10 17:30:00',
            'ativo' => 1,
        ]);
        $this->assertTrue($evento->save());

        $eventoEncontrado = Evento::findOne($evento->id);
        $this->assertEquals('2026-01-10 14:00:00', $eventoEncontrado->data_inicio);
        $this->assertEquals('2026-01-10 17:30:00', $eventoEncontrado->data_fim);
    }

    public function testEventoSemDescricao()
    {
        $local = $this->tester->grabFixture('local', 0);

        $evento = new Evento([
            'local_id' => $local['id'],
            'titulo' => 'Evento Simples',
            'data_inicio' => '2026-02-01 10:30:00',
            'ativo' => 1,
        ]);
        $this->assertTrue($evento->save());

        $eventoEncontrado = Evento::findOne($evento->id);
        $this->assertNull($eventoEncontrado->descricao);
    }
}