<?php

namespace backend\controllers;

use common\models\TipoBilhete;
use backend\models\TipoBilheteSearch;
use common\models\LocalCultural;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TipoBilheteController implements the CRUD actions for TipoBilhete model.
 */
class TipoBilheteController extends Controller
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
                        'roles' => ['accessBackoffice','viewBilling'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['accessBackoffice','addBilling'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['accessBackoffice','editBilling'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['accessBackoffice','deleteBilling'],
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
     * Lists all TipoBilhete models.
     *
     * @return string
     */
    public function actionIndex($local_id)
    {
        // Verificar se o local existe
        $localCultural = LocalCultural::findOne($local_id);
        if ($localCultural === null) {
            throw new NotFoundHttpException('Local Cultural não encontrado.');
        }

        $searchModel = new TipoBilheteSearch();
        $searchModel->local_id = $local_id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'localCultural' => $localCultural,
        ]);
    }

    /**
     * Displays a single TipoBilhete model.
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
     * Creates a new TipoBilhete model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($local_id)
    {
        $localCultural = LocalCultural::findOne($local_id);
        if ($localCultural === null) {
            throw new NotFoundHttpException('Local Cultural não encontrado.');
        }

        $model = new TipoBilhete();
        $model->local_id = $local_id;
        $model->ativo = 1; // Set default value for 'ativo'

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                \Yii::$app->session->setFlash('success', 'Tipo de bilhete criado com sucesso.');
                return $this->redirect(['index', 'local_id' => $model->local_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'localCultural' => $localCultural,
        ]);
    }

    /**
     * Updates an existing TipoBilhete model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Tipo de bilhete atualizado com sucesso.');
            return $this->redirect(['index', 'local_id' => $model->local_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'localCultural' => $model->local, // Pass local cultural for context in the view
        ]);
    }

    /**
     * Deletes an existing TipoBilhete model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $local_id = $model->local_id; // Get local_id before deleting
        $model->delete();
        \Yii::$app->session->setFlash('success', 'Tipo de bilhete removido com sucesso.');

        return $this->redirect(['index', 'local_id' => $local_id]);
    }

    /**
     * Finds the TipoBilhete model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TipoBilhete the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TipoBilhete::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
