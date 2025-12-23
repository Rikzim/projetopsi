<?php

namespace backend\controllers;

use common\models\Reserva;
use common\models\LocalCultural;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use backend\models\ReservaSearch;
use common\models\LinhaReserva;
use common\models\TipoBilhete;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

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
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['accessBackoffice','viewReservations'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['accessBackoffice','editReservations'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['accessBackoffice','deleteReservations'],
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

    /**
     * Lists all Reserva models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReservaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $locais = ArrayHelper::map(
            LocalCultural::find()->all(),
            'id',
            'nome'
        );

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'locais' => $locais,
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
     * Updates an existing Reserva model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Dados auxiliares
        $tiposBilhete = TipoBilhete::find()
            ->where(['local_id' => $model->local_id])
            ->indexBy('id')
            ->all();

        $linhasExistentes = LinhaReserva::find()
            ->where(['reserva_id' => $model->id])
            ->indexBy('tipo_bilhete_id')
            ->all();

        // POST
        if ($this->request->isPost && $model->load($this->request->post())) {
            
            $linhasData = $this->request->post('LinhaReserva', []);
            
            $novoPrecoTotal = $this->processarLinhasReserva($model, $linhasData, $linhasExistentes, $tiposBilhete);
            
            $model->preco_total = $novoPrecoTotal;

            if (!$model->hasErrors() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'tiposBilhete' => $tiposBilhete,
            'linhasExistentes' => $linhasExistentes,
        ]);
    }

    /**
     * Processa a criação, atualização e remoção de linhas de reserva.
     * Retorna o preço total calculado.
     */
    private function processarLinhasReserva($model, array $linhasData, array $linhasExistentes, array $tiposBilhete): float
    {
        $precoTotal = 0;

        foreach ($linhasData as $tipoBilheteId => $linhaData) {
            $quantidade = (int)($linhaData['quantidade'] ?? 0);
            $linha = $linhasExistentes[$tipoBilheteId] ?? null;

            // Se a quantidade for zero ou negativa -> Remover se existir e passar para o próximo
            if ($quantidade <= 0) {
                if ($linha) {
                    $linha->delete();
                }
                continue; // Salta para a próxima iteração do loop
            }

            // Se a linha não existir, criar nova linha
            if (!$linha) {
                $linha = new LinhaReserva([
                    'reserva_id' => $model->id,
                    'tipo_bilhete_id' => $tipoBilheteId,
                ]);
            }

            // Atualizar e Guardar
            $linha->quantidade = $quantidade;
            
            if ($linha->save()) {
                $precoUnitario = $tiposBilhete[$tipoBilheteId]->preco ?? 0;
                $precoTotal += $linha->quantidade * $precoUnitario;
            }
        }

        return $precoTotal;
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
