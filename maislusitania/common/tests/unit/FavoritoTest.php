<?php

namespace common\tests\Unit;

use common\models\Favorito;
use common\models\LocalCultural;
use common\models\User;
use common\fixtures\UserFixture;
use common\tests\UnitTester;
use yii\db\ActiveQuery;

class FavoritoTest extends \Codeception\Test\Unit
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

    // =====================================================
    // TESTES DE VALIDAÇÃO
    // =====================================================

    public function testValidationFailsWithEmptyRequiredFields()
    {
        $model = new Favorito();
        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('utilizador_id', $model->errors);
        $this->assertArrayHasKey('local_id', $model->errors);
    }

    public function testValidationFailsWithInvalidDataTypes()
    {
        $model = new Favorito([
            'utilizador_id' => 'not-an-integer',
            'local_id' => 'not-an-integer',
        ]);

        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('utilizador_id', $model->errors);
        $this->assertArrayHasKey('local_id', $model->errors);
    }

    // =====================================================
    // TESTES DE CONFIGURAÇÃO DO MODELO
    // =====================================================

    public function testTableNameIsCorrect()
    {
        $this->assertEquals('favorito', Favorito::tableName());
    }

    public function testAttributeLabelsAreCorrect()
    {
        $model = new Favorito();
        $labels = $model->attributeLabels();

        $this->assertArrayHasKey('id', $labels);
        $this->assertArrayHasKey('utilizador_id', $labels);
        $this->assertArrayHasKey('local_id', $labels);
        $this->assertArrayHasKey('data_adicao', $labels);
    }

    public function testRulesAreNotEmpty()
    {
        $model = new Favorito();
        $rules = $model->rules();

        $this->assertIsArray($rules);
        $this->assertNotEmpty($rules);
    }

    // =====================================================
    // TESTES DE RELACIONAMENTOS
    // =====================================================

    public function testGetLocalReturnsActiveQuery()
    {
        $model = new Favorito();
        $this->assertInstanceOf(ActiveQuery::class, $model->getLocal());
    }

    public function testGetUtilizadorReturnsActiveQuery()
    {
        $model = new Favorito();
        $this->assertInstanceOf(ActiveQuery::class, $model->getUtilizador());
    }

    // =====================================================
    // TESTES DE MÉTODOS ESTÁTICOS
    // =====================================================

    public function testGetFavoriteByUserAndLocalReturnsNullWhenNotFound()
    {
        $result = Favorito::getFavoriteByUserAndLocal(99999, 99999);
        $this->assertNull($result);
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
            'nome' => 'Local Teste Favorito',
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

    public function testSaveAndFindFavorito()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        $favorito = new Favorito([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
        ]);

        $this->assertTrue($favorito->save(), 'Favorito deveria ser guardado. Erros: ' . json_encode($favorito->errors));

        $foundFavorito = Favorito::findOne($favorito->id);
        $this->assertInstanceOf(Favorito::class, $foundFavorito);
        $this->assertEquals($user['id'], $foundFavorito->utilizador_id);
        $this->assertEquals($local->id, $foundFavorito->local_id);
    }

    public function testDeleteFavorito()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        $favorito = new Favorito([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
        ]);
        $this->assertTrue($favorito->save());
        $id = $favorito->id;

        $this->assertEquals(1, $favorito->delete());
        $this->assertNull(Favorito::findOne($id));
    }

    public function testFavoritoDuplicadoFalha()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        // Criar primeiro favorito
        $favorito1 = new Favorito([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
        ]);
        $this->assertTrue($favorito1->save());

        // Tentar criar favorito duplicado
        $favorito2 = new Favorito([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
        ]);
        $this->assertFalse($favorito2->save());
    }

    public function testFavoritoRelacionamentoComUtilizador()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        $favorito = new Favorito([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
        ]);
        $this->assertTrue($favorito->save());

        $favorito = Favorito::findOne($favorito->id);
        $this->assertInstanceOf(User::class, $favorito->utilizador);
        $this->assertEquals($user['username'], $favorito->utilizador->username);
    }

    public function testFavoritoRelacionamentoComLocal()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        $favorito = new Favorito([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
        ]);
        $this->assertTrue($favorito->save());

        $favorito = Favorito::findOne($favorito->id);
        $this->assertInstanceOf(LocalCultural::class, $favorito->local);
        $this->assertEquals('Local Teste Favorito', $favorito->local->nome);
    }

    public function testGetFavoriteByUserAndLocal()
    {
        $user = $this->tester->grabFixture('user', 0);
        $local = $this->criarLocalCultural();

        $favorito = new Favorito([
            'utilizador_id' => $user['id'],
            'local_id' => $local->id,
        ]);
        $this->assertTrue($favorito->save());

        $found = Favorito::getFavoriteByUserAndLocal($user['id'], $local->id);
        $this->assertInstanceOf(Favorito::class, $found);
        $this->assertEquals($favorito->id, $found->id);
    }

    public function testUtilizadorPodeTerMultiplosFavoritos()
    {
        $user = $this->tester->grabFixture('user', 0);

        // Criar dois locais diferentes
        $local1 = $this->criarLocalCultural();
        $local2 = new LocalCultural([
            'nome' => 'Segundo Local Favorito',
            'tipo_id' => 1,
            'morada' => 'Rua Teste 2',
            'distrito_id' => 1,
            'descricao' => 'Descrição teste 2',
            'latitude' => 41.0,
            'longitude' => -7.0,
        ]);
        $local2->save();

        // Criar favoritos para ambos os locais
        $favorito1 = new Favorito([
            'utilizador_id' => $user['id'],
            'local_id' => $local1->id,
        ]);
        $this->assertTrue($favorito1->save());

        $favorito2 = new Favorito([
            'utilizador_id' => $user['id'],
            'local_id' => $local2->id,
        ]);
        $this->assertTrue($favorito2->save());

        // Verificar que o utilizador tem dois favoritos
        $favoritos = Favorito::find()->where(['utilizador_id' => $user['id']])->all();
        $this->assertCount(2, $favoritos);
    }

    public function testLocalPodeSerFavoritoPorMultiplosUtilizadores()
    {
        $user1 = $this->tester->grabFixture('user', 0);
        $user2 = $this->tester->grabFixture('user', 1);
        $local = $this->criarLocalCultural();

        // Ambos os utilizadores adicionam o mesmo local como favorito
        $favorito1 = new Favorito([
            'utilizador_id' => $user1['id'],
            'local_id' => $local->id,
        ]);
        $this->assertTrue($favorito1->save());

        $favorito2 = new Favorito([
            'utilizador_id' => $user2['id'],
            'local_id' => $local->id,
        ]);
        $this->assertTrue($favorito2->save());

        // Verificar que o local tem dois favoritos
        $favoritos = Favorito::find()->where(['local_id' => $local->id])->all();
        $this->assertCount(2, $favoritos);
    }
}
