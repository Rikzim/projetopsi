<?php

namespace frontend\controllers;

use Yii;
use common\models\Avaliacao;
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

        // Verificar se já existe uma avaliação (ativa ou inativa)
        $avaliacaoExistente = Avaliacao::findOne([
            'local_id' => $localId,
            'utilizador_id' => $utilizadorId
        ]);

        if ($avaliacaoExistente) {
            // Reativar e atualizar a avaliação existente
            $avaliacao = $avaliacaoExistente;
            $avaliacao->ativo = 1;
        } else {
            // Criar nova avaliação
            $avaliacao = new Avaliacao();
            $avaliacao->utilizador_id = $utilizadorId;
            $avaliacao->local_id = $localId;
        }

        $avaliacao->classificacao = Yii::$app->request->post('classificacao');
        $avaliacao->comentario = Yii::$app->request->post('comentario');
        $avaliacao->data_avaliacao = date('Y-m-d H:i:s');

        if ($avaliacao->save()) {
            Yii::$app->session->setFlash('success', 'Avaliação publicada com sucesso!');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao publicar avaliação.');
        }

        return $this->redirect(['local-cultural/view', 'id' => $localId]);
    }

    public function actionUpdate($id)
    {
        $avaliacao = $this->findModel($id);

        $avaliacao->classificacao = Yii::$app->request->post('classificacao');
        $avaliacao->comentario = Yii::$app->request->post('comentario');

        if ($avaliacao->save()) {
            Yii::$app->session->setFlash('success', 'Avaliação atualizada com sucesso!');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao atualizar avaliação.');
        }

        return $this->redirect(['local-cultural/view', 'id' => $avaliacao->local_id]);
    }

    public function actionDelete($id)
    {
        $avaliacao = $this->findModel($id);
        $localId = $avaliacao->local_id;

        $avaliacao->ativo = 0;

        if ($avaliacao->save(false)) {
            Yii::$app->session->setFlash('success', 'Avaliação eliminada com sucesso!');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao eliminar avaliação.');
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
