<?php

namespace backend\controllers;

use common\models\LocalCultural;
use backend\models\LocalCulturalForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Yii;

/**
 * LocalCulturalController implements the CRUD actions for LocalCultural model.
 */
class LocalCulturalController extends Controller
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
     * Lists all LocalCultural models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => LocalCultural::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LocalCultural model.
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
     * Creates a new LocalCultural model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new LocalCulturalForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Local Cultural criado com sucesso!');
                    return $this->redirect(['view', 'id' => $model->getLocalCultural()->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao criar Local Cultural.');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LocalCultural model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $localCultural = $this->findModel($id);
        $model = new LocalCulturalForm($localCultural);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Local Cultural atualizado com sucesso!');
                return $this->redirect(['view', 'id' => $model->getLocalCultural()->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao atualizar Local Cultural.');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LocalCultural model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        // Delete image if exists
        if ($model->imagem_principal) {
            $uploadPath = Yii::getAlias('@backend/web/uploads/');
            $imagePath = $uploadPath . $model->imagem_principal;
            
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $model->delete();
        Yii::$app->session->setFlash('success', 'Local Cultural deletado com sucesso!');

        return $this->redirect(['index']);
    }

    /**
     * Finds the LocalCultural model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return LocalCultural the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LocalCultural::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}