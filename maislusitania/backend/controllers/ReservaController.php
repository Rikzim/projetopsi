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
        $searchModel = new ReservaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $locais = ArrayHelper::map(
            LocalCultural::find()->all(),
            'id',
            'nome'
        );

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

        // Obter todos os tipos de bilhete possíveis para este local
        $tiposBilhete = TipoBilhete::find()
            ->where(['local_id' => $model->local_id])
            ->indexBy('id') // Indexar por ID para acesso fácil
            ->all();

        // Obter as linhas de reserva que já existem, indexadas por tipo_bilhete_id
        $linhasExistentes = LinhaReserva::find()
            ->where(['reserva_id' => $model->id])
            ->indexBy('tipo_bilhete_id')
            ->all();

        if ($this->request->isPost && $model->load($this->request->post())) {
            
            $precoTotalFinal = 0;
            $linhasData = $this->request->post('LinhaReserva', []);

            foreach ($linhasData as $tipoBilheteId => $linhaData) {
                $quantidade = (int)($linhaData['quantidade'] ?? 0);
                
                // Encontrar a linha de reserva existente usando o array pré-carregado
                $linha = $linhasExistentes[$tipoBilheteId] ?? null;

                if ($quantidade > 0) {
                    // Se a linha não existir, criar uma nova
                    if ($linha === null) {
                        $linha = new LinhaReserva([
                            'reserva_id' => $model->id,
                            'tipo_bilhete_id' => $tipoBilheteId,
                        ]);
                    }
                    $linha->quantidade = $quantidade;
                    
                    if ($linha->save()) {
                        // Calcular preço usando o array de tipos de bilhete pré-carregado
                        if (isset($tiposBilhete[$tipoBilheteId])) {
                            $precoTotalFinal += $linha->quantidade * $tiposBilhete[$tipoBilheteId]->preco;
                        }
                    } else {
                        $model->addError('preco_total', 'Erro ao guardar uma das linhas da reserva.');
                    }
                } elseif ($linha !== null) {
                    // Se a quantidade for 0 e a linha existir, eliminá-la
                    $linha->delete();
                }
            }

            $model->preco_total = $precoTotalFinal;

            if ($model->save() && !$model->hasErrors()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'tiposBilhete' => $tiposBilhete,       // Passar todos os tipos de bilhete possíveis
            'linhasExistentes' => $linhasExistentes, // Passar as linhas que já existem
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
