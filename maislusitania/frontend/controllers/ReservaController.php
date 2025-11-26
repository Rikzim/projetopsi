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
     * Criar reserva (já está OK, só garantir autenticação)
     */

    public function actionCreate()
    {
        if (!$this->request->isPost) {
            return $this->redirect(['site/index']);
        }

        $postData = $this->request->post();

        // Se vem com 'confirmar' = 1, GRAVA na BD
        if (isset($postData['confirmar']) && $postData['confirmar'] == '1') {

            if (Yii::$app->user->isGuest) {
                Yii::$app->session->setFlash('error', 'Precisa de estar autenticado.');
                return $this->redirect(['site/login']);
            }

            try {
                $reserva = new Reserva();
                $reserva->GuardarReserva($postData);

                Yii::$app->session->setFlash('success', 'Reserva criada com sucesso!');
                return $this->redirect(['site/bilhetes']);
            } catch (\Exception $e) {
                // NÃO redirecionar - renderizar novamente com os dados
                Yii::$app->session->setFlash('error', $e->getMessage());

                try {
                    $dados = Reserva::obterDadosConfirmacao($postData);
                    return $this->render('create', $dados);
                } catch (\Exception $e2) {
                    Yii::$app->session->setFlash('error', $e2->getMessage());
                    return $this->redirect(['site/index']);
                }
            }
        }

        // Se NÃO tem 'confirmar', MOSTRA a página de prévia (create.php)
        try {
            $dados = Reserva::obterDadosConfirmacao($postData);
            return $this->render('create', $dados);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['site/index']);
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
