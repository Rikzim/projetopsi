<?php

namespace frontend\controllers;

use common\models\Reserva;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * ReservaController implements the CRUD actions for Reserva model.
 */
class ReservaController extends Controller
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
     * Lists all Reserva models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Reserva::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reserva model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Reserva model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if ($this->request->isPost) {
            $postData = $this->request->post();

            // 1. Verificar se local_id existe
            if (empty($postData['local_id'])) {
                // erro
            }

            // 2. Verificar se há pelo menos 1 bilhete com quantidade > 0
            $bilhetes = $postData['bilhetes'] ?? [];
            $temBilhetes = false;

            foreach ($bilhetes as $bilhete) {
                if (isset($bilhete['quantidade']) && $bilhete['quantidade'] > 0) {
                    $temBilhetes = true;
                    break;
                }
            }

            if (!$temBilhetes) {
                // erro: "Selecione pelo menos 1 bilhete"
                Yii::$app->session->setFlash('error', 'Selecione pelo menos 1 bilhete.');
            }


            // Calcular preço total
            $precoTotal = 0;

            foreach ($bilhetes as $bilhete) {
                $quantidade = (int)($bilhete['quantidade'] ?? 0);
                $preco = (float)($bilhete['preco'] ?? 0);

                if ($quantidade > 0) {
                    $precoTotal += ($quantidade * $preco);
                }
            }

            //Salvar a reserva
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $reserva = new Reserva();

                if (!$reserva->save()) {
                throw new \Exception('Erro ao criar reserva');
    }

                
                $transaction->commit();
            } catch (\Exception $e) {
                // Se houver erro, desfaz TUDO
                $transaction->rollBack();

                // A reserva E os bilhetes são apagados automaticamente!
            }
        }
    }

    /**
     * Updates an existing Reserva model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Reserva model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Reserva model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Reserva the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reserva::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
