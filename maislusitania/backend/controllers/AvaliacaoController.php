<?php

namespace backend\controllers;

use common\models\Avaliacao;
use backend\models\AvalicaoSearch;
use common\models\LocalCultural;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * AvaliacaoController implements the CRUD actions for Avaliacao model.
 */
class AvaliacaoController extends Controller
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
                        'roles' => ['accessBackoffice', 'viewReviews'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['accessBackoffice', 'editAnyReview', 'editOwnReview'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['accessBackoffice', 'deleteAnyReview'],
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
     * Lists all Avaliacao models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AvalicaoSearch();
        $locaisAtivos = ArrayHelper::map(
        LocalCultural::find()->where(['ativo' => 1])->orderBy('nome')->all(),
            'id',
            'nome'
        );
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'locaisAtivos' => $locaisAtivos,
        ]);
    }

    /**
     * Displays a single Avaliacao model.
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
     * Updates an existing Avaliacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $locaisAtivos = ArrayHelper::map(
            LocalCultural::find()->where(['ativo' => 1])->orderBy('nome')->all(),
            'id',
            'nome'
        );
        $utilizadoresAtivos = ArrayHelper::map(
            User::find()->where(['status' => 10])->orderBy('username')->all(),
            'id',
            'username'
        );

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'locaisAtivos' => $locaisAtivos,
            'utilizadoresAtivos' => $utilizadoresAtivos,
        ]);
    }

    /**
     * Deletes an existing Avaliacao model.
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
     * Finds the Avaliacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Avaliacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Avaliacao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
