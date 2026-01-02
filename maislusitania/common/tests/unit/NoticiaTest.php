<?php

namespace common\tests\Unit;

use common\models\Noticia;
use common\models\LocalCultural;
use common\fixtures\LocalCulturalFixture;
use common\tests\UnitTester;
use yii\db\ActiveQuery;

class NoticiaTest extends \Codeception\Test\Unit
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
        $this->assertEquals('noticia', Noticia::tableName());
    }

    // =====================================================
    // TESTES DE VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS
    // =====================================================

    public function testValidacaoCamposObrigatorios()
    {
        $noticia = new Noticia();
        $this->assertFalse($noticia->validate());
        $this->assertArrayHasKey('titulo', $noticia->errors);
        $this->assertArrayHasKey('conteudo', $noticia->errors);
        $this->assertArrayHasKey('local_id', $noticia->errors);
    }

    public function testValidacaoComDadosValidos()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Notícia Teste';
        $noticia->conteudo = 'Conteúdo da notícia teste';
        $noticia->local_id = $local['id'];
        
        $noticia->validate(['titulo', 'conteudo', 'local_id']);
        
        $this->assertArrayNotHasKey('titulo', $noticia->errors);
        $this->assertArrayNotHasKey('conteudo', $noticia->errors);
        $this->assertArrayNotHasKey('local_id', $noticia->errors);
    }

    public function testTituloNaoPodeSerVazio()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = '';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        
        $noticia->validate(['titulo']);
        $this->assertArrayHasKey('titulo', $noticia->errors);
    }

    public function testConteudoNaoPodeSerVazio()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = '';
        $noticia->local_id = $local['id'];
        
        $noticia->validate(['conteudo']);
        $this->assertArrayHasKey('conteudo', $noticia->errors);
    }

    // =====================================================
    // TESTES DE VALIDAÇÃO DE COMPRIMENTO
    // =====================================================

    public function testTituloComprimentoMaximo()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = str_repeat('a', 201);
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        
        $noticia->validate(['titulo']);
        $this->assertArrayHasKey('titulo', $noticia->errors);
    }

    public function testTituloComprimentoValido()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = str_repeat('a', 200);
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        
        $noticia->validate(['titulo']);
        $this->assertArrayNotHasKey('titulo', $noticia->errors);
    }

    public function testResumoComprimentoMaximo()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        $noticia->resumo = str_repeat('a', 501);
        
        $noticia->validate(['resumo']);
        $this->assertArrayHasKey('resumo', $noticia->errors);
    }

    public function testResumoComprimentoValido()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        $noticia->resumo = str_repeat('a', 500);
        
        $noticia->validate(['resumo']);
        $this->assertArrayNotHasKey('resumo', $noticia->errors);
    }

    public function testImagemComprimentoMaximo()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        $noticia->imagem = str_repeat('a', 256);
        
        $noticia->validate(['imagem']);
        $this->assertArrayHasKey('imagem', $noticia->errors);
    }

    public function testImagemComprimentoValido()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        $noticia->imagem = str_repeat('a', 255);
        
        $noticia->validate(['imagem']);
        $this->assertArrayNotHasKey('imagem', $noticia->errors);
    }

    // =====================================================
    // TESTES DE VALIDAÇÃO DE TIPOS
    // =====================================================

    public function testLocalIdDeveSerInteiro()
    {
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = 'abc';
        
        $noticia->validate(['local_id']);
        $this->assertArrayHasKey('local_id', $noticia->errors);
    }

    public function testLocalIdAceitaInteiroValido()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        
        $noticia->validate(['local_id']);
        $this->assertArrayNotHasKey('local_id', $noticia->errors);
    }

    public function testAtivoDeveSerInteiro()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        $noticia->ativo = 'abc';
        
        $noticia->validate(['ativo']);
        $this->assertArrayHasKey('ativo', $noticia->errors);
    }

    public function testAtivoAceitaInteiroValido()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        $noticia->ativo = 1;
        
        $noticia->validate(['ativo']);
        $this->assertArrayNotHasKey('ativo', $noticia->errors);
    }

    public function testDestaqueDeveSerInteiro()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        $noticia->destaque = 'abc';
        
        $noticia->validate(['destaque']);
        $this->assertArrayHasKey('destaque', $noticia->errors);
    }

    public function testDestaqueAceitaInteiroValido()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        $noticia->destaque = 1;
        
        $noticia->validate(['destaque']);
        $this->assertArrayNotHasKey('destaque', $noticia->errors);
    }

    // =====================================================
    // TESTES DE VALORES PADRÃO
    // =====================================================

    public function testValoresPadrao()
    {
        $noticia = new Noticia();
        $noticia->loadDefaultValues();
        
        $this->assertNull($noticia->resumo);
        $this->assertNull($noticia->imagem);
        $this->assertEquals(1, $noticia->ativo);
        $this->assertEquals(0, $noticia->destaque);
    }

    // =====================================================
    // TESTES DE CAMPOS OPCIONAIS
    // =====================================================

    public function testResumoOpcional()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        $noticia->resumo = null;
        
        $this->assertTrue($noticia->validate());
    }

    public function testImagemOpcional()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        $noticia->imagem = null;
        
        $this->assertTrue($noticia->validate());
    }

    public function testDataPublicacaoOpcional()
    {
        $local = $this->tester->grabFixture('local', 0);
        
        $noticia = new Noticia();
        $noticia->titulo = 'Título teste';
        $noticia->conteudo = 'Conteúdo teste';
        $noticia->local_id = $local['id'];
        $noticia->data_publicacao = null;
        
        $this->assertTrue($noticia->validate());
    }

    // =====================================================
    // TESTES DE ATRIBUTOS E LABELS
    // =====================================================

    public function testRotulosAtributos()
    {
        $noticia = new Noticia();
        $labels = $noticia->attributeLabels();
        
        $this->assertEquals('ID', $labels['id']);
        $this->assertEquals('Titulo', $labels['titulo']);
        $this->assertEquals('Conteudo', $labels['conteudo']);
        $this->assertEquals('Resumo', $labels['resumo']);
        $this->assertEquals('Imagem', $labels['imagem']);
        $this->assertEquals('Data Publicacao', $labels['data_publicacao']);
        $this->assertEquals('Ativo', $labels['ativo']);
        $this->assertEquals('Local', $labels['local_id']);
        $this->assertEquals('Destaque', $labels['destaque']);
    }

    // =====================================================
    // TESTES DE MÉTODOS AUXILIARES
    // =====================================================

    public function testObterImagemRetornaNuloQuandoVazio()
    {
        $noticia = new Noticia();
        $noticia->imagem = null;
        
        $this->assertNull($noticia->getImage());
    }

    public function testObterImagemRetornaCaminho()
    {
        $noticia = new Noticia();
        $noticia->imagem = 'noticia.jpg';
        
        $this->assertEquals('/uploads/noticia.jpg', $noticia->getImage());
    }

    public function testObterImagemAPIRetornaNuloQuandoVazio()
    {
        $noticia = new Noticia();
        $noticia->imagem = null;
        
        $this->assertNull($noticia->getImageAPI());
    }

    // =====================================================
    // TESTES DE RELACIONAMENTOS
    // =====================================================

    public function testGetLocal()
    {
        $noticia = new Noticia();
        $this->assertInstanceOf(ActiveQuery::class, $noticia->getLocal());
    }

    public function testGetLocalCultural()
    {
        $noticia = new Noticia();
        $this->assertInstanceOf(ActiveQuery::class, $noticia->getLocalCultural());
    }

    // =====================================================
    // TESTES DE INTEGRAÇÃO COM A BASE DE DADOS (CRUD)
    // =====================================================

    public function testGuardarEEncontrarNoticia()
    {
        $local = $this->tester->grabFixture('local', 0);

        $noticia = new Noticia([
            'titulo' => 'Nova Exposição no Museu',
            'conteudo' => 'O museu apresenta uma nova exposição de arte contemporânea.',
            'resumo' => 'Nova exposição de arte contemporânea',
            'local_id' => $local['id'],
            'data_publicacao' => '2025-06-15 10:00:00',
            'imagem' => 'exposicao.jpg',
            'ativo' => 1,
            'destaque' => 1,
        ]);

        $this->assertTrue($noticia->save(), 'Notícia deveria ser guardada.');

        $noticiaEncontrada = Noticia::findOne($noticia->id);
        $this->assertInstanceOf(Noticia::class, $noticiaEncontrada);
        $this->assertEquals('Nova Exposição no Museu', $noticiaEncontrada->titulo);
        $this->assertEquals($local['id'], $noticiaEncontrada->local_id);
        $this->assertEquals(1, $noticiaEncontrada->destaque);
    }

    public function testAtualizarNoticia()
    {
        $local = $this->tester->grabFixture('local', 0);

        $noticia = new Noticia([
            'titulo' => 'Concerto de Jazz',
            'conteudo' => 'Concerto de jazz no teatro municipal',
            'local_id' => $local['id'],
            'ativo' => 1,
        ]);
        $this->assertTrue($noticia->save());

        $noticia->titulo = 'Grande Concerto de Jazz';
        $noticia->resumo = 'Evento imperdível de jazz';
        $noticia->destaque = 1;
        $this->assertTrue($noticia->save());

        $noticiaAtualizada = Noticia::findOne($noticia->id);
        $this->assertEquals('Grande Concerto de Jazz', $noticiaAtualizada->titulo);
        $this->assertEquals('Evento imperdível de jazz', $noticiaAtualizada->resumo);
        $this->assertEquals(1, $noticiaAtualizada->destaque);
    }

    public function testEliminarNoticia()
    {
        $local = $this->tester->grabFixture('local', 0);

        $noticia = new Noticia([
            'titulo' => 'Notícia Temporária',
            'conteudo' => 'Conteúdo temporário',
            'local_id' => $local['id'],
            'ativo' => 1,
        ]);
        $this->assertTrue($noticia->save());
        $id = $noticia->id;

        $this->assertEquals(1, $noticia->delete());
        $this->assertNull(Noticia::findOne($id));
    }

    public function testNoticiaRelacionamentoComLocal()
    {
        $local = $this->tester->grabFixture('local', 0);

        $noticia = new Noticia([
            'titulo' => 'Notícia do Local',
            'conteudo' => 'Conteúdo da notícia',
            'local_id' => $local['id'],
            'ativo' => 1,
        ]);
        $this->assertTrue($noticia->save());

        $noticia = Noticia::findOne($noticia->id);
        $this->assertInstanceOf(LocalCultural::class, $noticia->local);
        $this->assertEquals($local['nome'], $noticia->local->nome);
    }

    public function testMultiplasNoticiasMesmoLocal()
    {
        $local = $this->tester->grabFixture('local', 0);

        $noticia1 = new Noticia([
            'titulo' => 'Notícia 1',
            'conteudo' => 'Conteúdo 1',
            'local_id' => $local['id'],
            'ativo' => 1,
        ]);
        $this->assertTrue($noticia1->save());

        $noticia2 = new Noticia([
            'titulo' => 'Notícia 2',
            'conteudo' => 'Conteúdo 2',
            'local_id' => $local['id'],
            'ativo' => 1,
        ]);
        $this->assertTrue($noticia2->save());

        $noticias = Noticia::find()->where(['local_id' => $local['id']])->all();
        $this->assertGreaterThanOrEqual(2, count($noticias));
    }

    public function testNoticiaComImagemCompleta()
    {
        $local = $this->tester->grabFixture('local', 0);

        $noticia = new Noticia([
            'titulo' => 'Notícia com Imagem',
            'conteudo' => 'Conteúdo da notícia',
            'local_id' => $local['id'],
            'imagem' => 'noticia_especial.jpg',
            'ativo' => 1,
        ]);
        $this->assertTrue($noticia->save());

        $noticiaEncontrada = Noticia::findOne($noticia->id);
        $this->assertEquals('/uploads/noticia_especial.jpg', $noticiaEncontrada->getImage());
    }

    public function testNoticiaAtivaInativa()
    {
        $local = $this->tester->grabFixture('local', 0);

        $noticia = new Noticia([
            'titulo' => 'Notícia Ativa',
            'conteudo' => 'Conteúdo da notícia',
            'local_id' => $local['id'],
            'ativo' => 1,
        ]);
        $this->assertTrue($noticia->save());
        $this->assertEquals(1, $noticia->ativo);

        $noticia->ativo = 0;
        $this->assertTrue($noticia->save());

        $noticiaAtualizada = Noticia::findOne($noticia->id);
        $this->assertEquals(0, $noticiaAtualizada->ativo);
    }

    public function testNoticiaComDestaque()
    {
        $local = $this->tester->grabFixture('local', 0);

        $noticia = new Noticia([
            'titulo' => 'Notícia em Destaque',
            'conteudo' => 'Conteúdo importante',
            'local_id' => $local['id'],
            'destaque' => 1,
            'ativo' => 1,
        ]);
        $this->assertTrue($noticia->save());

        $noticiaEncontrada = Noticia::findOne($noticia->id);
        $this->assertEquals(1, $noticiaEncontrada->destaque);
    }

    public function testNoticiaSemResumo()
    {
        $local = $this->tester->grabFixture('local', 0);

        $noticia = new Noticia([
            'titulo' => 'Notícia Simples',
            'conteudo' => 'Conteúdo da notícia',
            'local_id' => $local['id'],
            'ativo' => 1,
        ]);
        $this->assertTrue($noticia->save());

        $noticiaEncontrada = Noticia::findOne($noticia->id);
        $this->assertNull($noticiaEncontrada->resumo);
    }

    public function testNoticiaComDataPublicacao()
    {
        $local = $this->tester->grabFixture('local', 0);

        $noticia = new Noticia([
            'titulo' => 'Notícia Agendada',
            'conteudo' => 'Conteúdo da notícia',
            'local_id' => $local['id'],
            'data_publicacao' => '2025-12-25 09:00:00',
            'ativo' => 1,
        ]);
        $this->assertTrue($noticia->save());

        $noticiaEncontrada = Noticia::findOne($noticia->id);
        $this->assertEquals('2025-12-25 09:00:00', $noticiaEncontrada->data_publicacao);
    }
}