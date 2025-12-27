<?php

namespace common\tests\unit;

use common\models\LocalCultural;
use common\models\Avaliacao;
use common\models\Favorito;
use common\fixtures\UserFixture;
use common\tests\UnitTester;
use yii\db\ActiveQuery;

class LocalCulturalTest extends \Codeception\Test\Unit
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

    // Testes de Validação
    public function testValidationFailsWithEmptyRequiredFields()
    {
        $model = new LocalCultural();
        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('nome', $model->errors);
        $this->assertArrayHasKey('tipo_id', $model->errors);
        $this->assertArrayHasKey('morada', $model->errors);
        $this->assertArrayHasKey('distrito_id', $model->errors);
        $this->assertArrayHasKey('descricao', $model->errors);
        $this->assertArrayHasKey('latitude', $model->errors);
        $this->assertArrayHasKey('longitude', $model->errors);
    }

    public function testValidationPassesWithValidData()
    {
        $model = new LocalCultural([
            'nome' => 'Museu Teste',
            'tipo_id' => 1,
            'morada' => 'Rua do Teste, 123',
            'distrito_id' => 1,
            'descricao' => 'Uma descrição de teste.',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
        ]);

        $this->assertTrue($model->validate());
    }

    public function testInvalidDataTypes()
    {
        $model = new LocalCultural([
            'nome' => 'Museu Teste',
            'tipo_id' => 'not-an-integer',
            'morada' => 'Rua do Teste, 123',
            'distrito_id' => 'not-an-integer',
            'descricao' => 'Uma descrição de teste.',
            'latitude' => 'not-a-number',
            'longitude' => 'not-a-number',
        ]);

        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('tipo_id', $model->errors);
        $this->assertArrayHasKey('distrito_id', $model->errors);
        $this->assertArrayHasKey('latitude', $model->errors);
        $this->assertArrayHasKey('longitude', $model->errors);
    }

    // Testes de Configuração do Modelo
    public function testTableNameIsCorrect()
    {
        $this->assertEquals('local_cultural', LocalCultural::tableName());
    }

    public function testAttributeLabelsAreCorrect()
    {
        $model = new LocalCultural();
        $labels = $model->attributeLabels();
        $this->assertArrayHasKey('nome', $labels);
        $this->assertEquals('Tipo Local', $labels['tipo_id']);
        $this->assertEquals('Distrito', $labels['distrito_id']);
    }

    // Testes de Métodos de Imagem
    public function testGetImageReturnsNullWhenNoImage()
    {
        $model = new LocalCultural();
        $model->imagem_principal = null;
        $this->assertNull($model->getImage());
    }

    public function testGetImageReturnsCorrectPath()
    {
        $model = new LocalCultural();
        $model->imagem_principal = 'test_image.jpg';
        $this->assertEquals('/uploads/test_image.jpg', $model->getImage());
    }

    public function testGetImageAPIReturnsNullWhenNoImage()
    {
        $model = new LocalCultural();
        $model->imagem_principal = null;
        $this->assertNull($model->getImageAPI());
    }

    public function testGetImageAPIReturnsCorrectPath()
    {
        $model = new LocalCultural();
        $model->imagem_principal = 'api_image.jpg';
        $this->assertStringContainsString('/projetopsi/maislusitania/frontend/web/uploads/api_image.jpg', $model->getImageAPI());
    }

    // Testes de Relacionamentos
    public function testGetDistritoReturnsActiveQuery()
    {
        $model = new LocalCultural();
        $this->assertInstanceOf(ActiveQuery::class, $model->getDistrito());
    }

    public function testGetTipoLocalReturnsActiveQuery()
    {
        $model = new LocalCultural();
        $this->assertInstanceOf(ActiveQuery::class, $model->getTipoLocal());
    }

    public function testGetTipoBilhetesReturnsActiveQuery()
    {
        $model = new LocalCultural();
        $this->assertInstanceOf(ActiveQuery::class, $model->getTipoBilhetes());
    }

    public function testGetAvaliacoesReturnsActiveQuery()
    {
        $model = new LocalCultural();
        $this->assertInstanceOf(ActiveQuery::class, $model->getAvaliacoes());
    }

    public function testGetFavoritosReturnsActiveQuery()
    {
        $model = new LocalCultural();
        $this->assertInstanceOf(ActiveQuery::class, $model->getFavoritos());
    }

    public function testGetEventosReturnsActiveQuery()
    {
        $model = new LocalCultural();
        $this->assertInstanceOf(ActiveQuery::class, $model->getEventos());
    }

    public function testGetReservasReturnsActiveQuery()
    {
        $model = new LocalCultural();
        $this->assertInstanceOf(ActiveQuery::class, $model->getReservas());
    }

    public function testGetNoticiasReturnsActiveQuery()
    {
        $model = new LocalCultural();
        $this->assertInstanceOf(ActiveQuery::class, $model->getNoticias());
    }

    public function testGetHorarioReturnsActiveQuery()
    {
        $model = new LocalCultural();
        $this->assertInstanceOf(ActiveQuery::class, $model->getHorario());
    }

    // Testes de Integração com a Base de Dados (CRUD)
    public function testSaveAndFindRecord()
    {
        $model = new LocalCultural([
            'nome' => 'Museu do CRUD',
            'tipo_id' => 1,
            'morada' => 'Rua do Teste',
            'distrito_id' => 1,
            'descricao' => 'Descrição CRUD.',
            'latitude' => 40.1,
            'longitude' => -8.2,
        ]);

        $this->assertTrue($model->save());

        $foundModel = LocalCultural::findOne($model->id);
        $this->assertInstanceOf(LocalCultural::class, $foundModel);
        $this->assertEquals('Museu do CRUD', $foundModel->nome);
    }

    public function testUpdateRecord()
    {
        $model = new LocalCultural([
            'nome' => 'Museu Original',
            'tipo_id' => 1,
            'morada' => 'Morada',
            'distrito_id' => 1,
            'descricao' => 'Desc.',
            'latitude' => 40.2,
            'longitude' => -8.3,
        ]);
        $this->assertTrue($model->save());

        $model->nome = 'Museu Atualizado';
        $this->assertTrue($model->save());

        $foundModel = LocalCultural::findOne($model->id);
        $this->assertEquals('Museu Atualizado', $foundModel->nome);
    }

    public function testDeleteRecord()
    {
        $model = new LocalCultural([
            'nome' => 'Museu para Apagar',
            'tipo_id' => 1,
            'morada' => 'Rua',
            'distrito_id' => 1,
            'descricao' => 'Apagar.',
            'latitude' => 40.3,
            'longitude' => -8.4,
        ]);
        $this->assertTrue($model->save());
        $id = $model->id;

        $this->assertEquals(1, $model->delete());
        $this->assertNull(LocalCultural::findOne($id));
    }

    // Testes de Lógica de Negócio
    public function testRatingLogic()
    {
        $user1 = $this->tester->grabFixture('user', 0);
        $user2 = $this->tester->grabFixture('user', 1);

        $local = new LocalCultural([
            'nome' => 'Local Avaliação',
            'tipo_id' => 1,
            'morada' => 'Rua',
            'distrito_id' => 1,
            'descricao' => 'Desc',
            'latitude' => 40,
            'longitude' => -8
        ]);
        $this->assertTrue($local->save());

        $this->assertEquals(0, $local->getAverageRating());
        $this->assertEquals(0, $local->getRatingCount());

        (new Avaliacao(['local_id' => $local->id, 'classificacao' => 5, 'ativo' => 1, 'utilizador_id' => $user1['id']]))->save();
        (new Avaliacao(['local_id' => $local->id, 'classificacao' => 3, 'ativo' => 1, 'utilizador_id' => $user2['id']]))->save();

        $local = LocalCultural::findOne($local->id);
        $this->assertEquals(4.0, $local->getAverageRating());
        $this->assertEquals(2, $local->getRatingCount());
    }

    public function testFavoriteLogic()
    {
        $user1 = $this->tester->grabFixture('user', 0);
        $user2 = $this->tester->grabFixture('user', 1);

        $local = new LocalCultural([
            'nome' => 'Local Favorito',
            'tipo_id' => 1,
            'morada' => 'Rua',
            'distrito_id' => 1,
            'descricao' => 'Desc',
            'latitude' => 40,
            'longitude' => -8
        ]);
        $this->assertTrue($local->save());

        (new Favorito(['utilizador_id' => $user1['id'], 'local_id' => $local->id]))->save();

        $local = LocalCultural::findOne($local->id);

        $this->assertTrue($local->isFavoritedByUser($user1['id']));
        $this->assertFalse($local->isFavoritedByUser($user2['id']));
        $this->assertNotNull($local->getFavoritoIdByUser($user1['id']));
        $this->assertNull($local->getFavoritoIdByUser($user2['id']));
    }
}
