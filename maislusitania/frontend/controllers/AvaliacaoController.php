<?php

namespace frontend\controllers;

use Yii;
use common\models\Avaliacao;
use frontend\widgets\AvaliacoesWidget;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AvaliacaoController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['addReview'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['editOwnReview'],
                        'matchCallback' => function ($rule, $action) {
                            $id = Yii::$app->request->get('id');
                            $avaliacao = Avaliacao::findOne($id);
                            return $avaliacao && $avaliacao->utilizador_id === Yii::$app->user->id;
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deleteOwnReview'],
                        'matchCallback' => function ($rule, $action) {
                            $id = Yii::$app->request->get('id');
                            $avaliacao = Avaliacao::findOne($id);
                            return $avaliacao && $avaliacao->utilizador_id === Yii::$app->user->id;
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $localId = Yii::$app->request->post('local_id');
        $utilizadorId = Yii::$app->user->id;

        //Procurar uma avaliação existente para ESTE local e ESTE utilizador.
        $avaliacao = Avaliacao::findOne([
            'local_id' => $localId,
            'utilizador_id' => $utilizadorId
        ]);

        if (!$avaliacao) {
            // Se não existir, criar uma nova instância.
            $avaliacao = new Avaliacao([
                'utilizador_id' => $utilizadorId,
                'local_id' => $localId,
            ]);
        }
        
        // Reativar a avaliação caso esteja inativa (soft delete)
        $avaliacao->ativo = 1;
        $avaliacao->data_avaliacao = date('Y-m-d H:i:s');

        // Usar load() para popular o modelo e verificar se save() foi bem-sucedido.
        if (!($avaliacao->load(Yii::$app->request->post(), '') && $avaliacao->save())) {
            // Se houver um erro, registe-o para depuração.
            Yii::error($avaliacao->getErrors());
        }

        if (Yii::$app->request->isPjax) {
            return AvaliacoesWidget::widget(['localCulturalId' => $localId]);
        }

        return $this->redirect(['local-cultural/view', 'id' => $localId]);
    }

    public function actionUpdate($id)
    {
        $avaliacao = $this->findModel($id);

        // Carregar e guardar, verificando o resultado
        if (!($avaliacao->load(Yii::$app->request->post(), '') && $avaliacao->save())) {
             // Registar quaisquer erros para depuração
            Yii::error($avaliacao->getErrors());
        }

        if (Yii::$app->request->isPjax) {
            return AvaliacoesWidget::widget(['localCulturalId' => $avaliacao->local_id]);
        }

        return $this->redirect(['local-cultural/view', 'id' => $avaliacao->local_id]);
    }

    public function actionDelete($id)
    {
        $avaliacao = $this->findModel($id);
        $localId = $avaliacao->local_id;

        $avaliacao->ativo = 0;

        $avaliacao->save(false);

        if (Yii::$app->request->isPjax) {
            return AvaliacoesWidget::widget(['localCulturalId' => $localId]);
        }

        return $this->redirect(['local-cultural/view', 'id' => $localId]);
    }

    protected function findModel($id)
    {
        if (($model = Avaliacao::findOne(['id' => $id, 'ativo' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('A avaliação solicitada não existe.');
    }
}
