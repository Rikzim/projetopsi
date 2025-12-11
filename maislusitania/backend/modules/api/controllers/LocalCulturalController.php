<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\Cors;
use common\models\Distrito;
use common\models\LocalCultural;
use common\models\TipoLocal;
use yii\filters\ContentNegotiator;
use Yii;

class LocalCulturalController extends ActiveController
{
    // ========================================
    // Define o modelo
    // ========================================
    public $modelClass = 'common\models\LocalCultural';

    // ========================================
    // Configura data provider
    // ========================================
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view']); // Remover ação view padrão
        unset($actions['index']); // Remover ação index padrão
        return $actions;
    }

    // Lista todos os locais culturais ativos
    public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $locais = $modelClass::find()
            ->where(['ativo' => true])
            ->with(['distrito', 'tipoLocal'])
            ->all();

        $data = array_map(function($local) {
            return [
                'id' => $local->id,
                'nome' => $local->nome,
                'morada' => $local->morada,
                'distrito' => $local->distrito->nome ?? null,
                'descricao' => $local->descricao,
                'imagem' => $local->getImageAPI(),
                'avaliacao_media' => $local->getAverageRating(),
                
            ];
        }, $locais);

        return ['data' => $data];
    }
    // Visualiza um local específico por ID
    public function actionView($id)
    {
        $modelClass = $this->modelClass;
        $local = $modelClass::find()
            ->where(['id' => $id, 'ativo' => true])
            ->with([
                'avaliacaos' => function($query) {
                    $query->andWhere(['ativo' => true]);
                },
                'noticias',
                'eventos',
                'tipoBilhetes' => function($query) {  // ALTERADO: tipoBilhetes (plural)
                    $query->andWhere(['ativo' => true]);
                },
                'horario',
                'tipoLocal',
                'distrito'
            ])
            ->one();

        if (!$local) {
            throw new NotFoundHttpException('Local cultural não encontrado.');
        }
        return ['data' => $this->formatLocalData($local)];
    }
    // Extra Patterns
    public function actionDistrito($nome)
    {
        $distrito = Distrito::find()
            ->where(['LIKE', 'LOWER(nome)', strtolower($nome)])
            ->one();

        if (!$distrito) {
            throw new NotFoundHttpException("Distrito '$nome' não encontrado.");
        }

        // Retorna os locais culturais desse distrito
        $locais = LocalCultural::find()
            ->where(['distrito_id' => $distrito->id])
            ->all();

        if (!$locais) {
            throw new NotFoundHttpException("Distrito '$nome' não encontrado.");
        }

        return [
            'distrito' => $distrito->nome,
            'total' => count($locais),
            'locais' => $locais,
        ];
    }
    public function actionTipoLocal($nome)
    {
        $tipolocal = TipoLocal::find()
            ->where(['LIKE', 'LOWER(nome)', strtolower($nome)])
            ->one();

        // Retorna os locais culturais desse distrito
        $locais = LocalCultural::find()
            ->where(['tipo_id' => $tipolocal->id])
            ->all();

        if (!$locais) {
            throw new NotFoundHttpException("Tipo Local '$nome' não encontrado.");
        }

        return [
            'tipo_local' => $tipolocal->nome,
            'total' => count($locais),
            'locais' => $locais,
        ];
    }

    public function actionSearch($nome)
    {
        $locais = LocalCultural::find()
            ->where(['LIKE', 'LOWER(nome)', strtolower($nome)])
            ->andWhere(['ativo' => true])
            ->all();

        if (empty($locais)) {
            throw new NotFoundHttpException("Nenhum local cultural encontrado com o nome '$nome'.");
        }

        return [
            'total' => count($locais),
            'locais' => $locais,
        ];
    }

    // Método auxiliar para formatar os dados do local
    private function formatLocalData($local)
    {
        return [
            'id' => $local->id,
            'nome' => $local->nome,
            'tipo' => $local->tipoLocal->nome ?? null,
            'distrito' => $local->distrito->nome ?? null,
            'imagem' => $local->getImageAPI(),
            'morada' => $local->morada,
            'descricao' => $local->descricao,
            'contacto_telefone' => $local->contacto_telefone,
            'contacto_email' => $local->contacto_email,
            'website' => $local->website,
            'ativo' => (bool)$local->ativo,
            'latitude' => (float)$local->latitude,
            'longitude' => (float)$local->longitude,
            'horario' =>  $local->horario ? [
                'segunda' => $local->horario->segunda ?? null,
                'terca' => $local->horario->terca ?? null,
                'quarta' => $local->horario->quarta ?? null,
                'quinta' => $local->horario->quinta ?? null,
                'sexta' => $local->horario->sexta ?? null,
                'sabado' => $local->horario->sabado ?? null,
                'domingo' => $local->horario->domingo ?? null,
            ] : "Horário não disponível",
            'avaliacoes' => $local->avaliacaos ? array_map(function($avaliacao) {
                return [
                    'id' => $avaliacao->id,
                    'utilizador' => $avaliacao->user->username ?? 'Anônimo',
                    'classificacao' => (float)$avaliacao->classificacao,
                    'comentario' => $avaliacao->comentario,
                    'data_avaliacao' => date('Y-m-d', strtotime($avaliacao->data_avaliacao)),
                    'ativo' => (bool)$avaliacao->ativo,
                ];
            }, $local->avaliacaos) : "Ainda não existem avaliações. Seja o primeiro a avaliar!",
            'noticias' => $local->noticias ? array_map(function($noticia) {
                return [
                    'id' => $noticia->id,
                    'titulo' => $noticia->titulo,
                    'descricao' => $noticia->resumo,
                    'data_publicacao' => date('Y-m-d H:i', strtotime($noticia->data_publicacao)),
                    'imagem' => $noticia->getImageAPI(),
                ];
            }, $local->noticias) : "Nenhuma notícia relacionada disponível no momento. ",
            'eventos' => $local->eventos ? array_map(function($evento) {
                return [
                    'id' => $evento->id,
                    'titulo' => $evento->titulo,
                    'descricao' => $evento->descricao,
                    'data_inicio' => date('Y-m-d\TH:i:s', strtotime($evento->data_inicio)),
                    'data_fim' => date('Y-m-d\TH:i:s', strtotime($evento->data_fim)),
                    'imagem' => $evento->getImageAPI(),
                ];
            }, $local->eventos) : "Nenhum evento relacionado disponível no momento.",
            'tipos-bilhete' => $local->tipoBilhetes ? array_map(function($tipo) {  // ALTERADO: array_map para iterar todos
                return [
                    'id' => $tipo->id,
                    'nome' => $tipo->nome,
                    'descricao' => $tipo->descricao,  // ADICIONADO: descrição
                    'preco' => number_format($tipo->preco, 2) . '€',  // MELHORADO: formatação do preço
                    'ativo' => (bool)$tipo->ativo,
                ];
            }, $local->tipoBilhetes) : "Nenhum bilhete disponível no momento.",  // ALTERADO: tipoBilhetes (plural)
            
        ];
    }

    // ========================================
    // Define campos a retornar
    // ========================================
    public function fields()
    {
        return [
            'id',
            'nome',
            'tipoLocal',
            'distrito',
            'imagem',
            'morada',
            'descricao',
            'contacto_telefone',
            'contacto_email',
            'website',
            'ativo',
            'latitude',
            'longitude',
        ];
    }

    // ========================================
    // Controle de permissões
    // ========================================
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // CORS para todos os controllers
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET','POST','PUT','DELETE','OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];
        $behaviors['contentNegotiator'] = [ // Resposta em JSON
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        
        return $behaviors;
    } 
}