<?php

namespace frontend\controllers;

use common\models\Favorito;
use common\models\LocalCultural;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * FavoritoController implements the CRUD actions for Favorito model.
 */
class FavoritoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Favorito models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $user = Yii::$app->user->identity;
        $favorites = $user->favorites;

        return $this->render('index', [
            'favorites' => $favorites,
        ]);
    }
    public function actionToggleFavorite($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $local = LocalCultural::findOne($id);
        if ($local === null) {
            throw new NotFoundHttpException('O local cultural não foi encontrado.');
        }
        $userId = Yii::$app->user->id;

        // Verificar se já existe usando query direta
        $favorito = Favorito::findOne([
            'utilizador_id' => $userId,
            'local_id' => $id,
        ]);
        
        if ($favorito !== null) {
            // Existe, então remover
            $favorito->delete();
            Yii::$app->session->setFlash('success', 'Removido dos favoritos!');
        } else {
            // Se não existe, adicionar
            $favorito = new Favorito();
            $favorito->utilizador_id = $userId;
            $favorito->local_id = $id;
            $favorito->data_adicao = date('Y-m-d H:i:s');
            
            if (!$favorito->save()) {
                Yii::$app->session->setFlash('error', 'Erro ao adicionar aos favoritos.');
            } else {
                Yii::$app->session->setFlash('success', 'Adicionado aos favoritos!');
            }
        }

        if (Yii::$app->request->isPjax) {
            return $this->actionIndex();
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    /**
     * Finds the Favorito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Favorito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Favorito::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
