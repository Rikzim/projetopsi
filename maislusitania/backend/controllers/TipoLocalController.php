<?php

namespace backend\controllers;

use common\models\TipoLocal;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\models\UploadForm;
use Yii;

/**
 * TipoLocalController implements the CRUD actions for TipoLocal model.
 */
class TipoLocalController extends Controller
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
     * Lists all TipoLocal models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TipoLocal::find(),
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
     * Displays a single TipoLocal model.
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
     * Creates a new TipoLocal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TipoLocal();
        $uploadForm = new UploadForm();
        

        if (Yii::$app->request->isPost) {
            if (
                $model->load(Yii::$app->request->post()) 
            ) {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile && $uploadForm->validate()) {
                    $fileName = uniqid('local_') . '.' . $uploadForm->imageFile->extension;
                    $uploadPath = Yii::getAlias('@backend/web/uploads/') . $fileName;
                    if ($uploadForm->imageFile->saveAs($uploadPath)) {
                        $model->icone = $fileName;
                    }
                }
                if ($model->save(false)) {
                   

                    Yii::$app->session->setFlash('success', 'TipoLocal criado com sucesso!');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao criar TipoLocal.');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'uploadForm' => $uploadForm,
        ]);
    }

    /**
     * Updates an existing TipoLocal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $uploadForm = new UploadForm();

        if (Yii::$app->request->isPost) {
            if (
                $model->load(Yii::$app->request->post())
               
            ) {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile && $uploadForm->validate()) {
                    $fileName = uniqid('local_') . '.' . $uploadForm->imageFile->extension;
                    $uploadPath = Yii::getAlias('@backend/web/uploads/') . $fileName;
                    if ($uploadForm->imageFile->saveAs($uploadPath)) {
                        // Remove old image if exists
                        if ($model->icone) {
                            $oldPath = Yii::getAlias('@backend/web/uploads/') . $model->icone;
                            if (file_exists($oldPath)) {
                                unlink($oldPath);
                            }
                        }
                        $model->icone = $fileName;
                    }
                }
                if ($model->save(false)) {

                    Yii::$app->session->setFlash('success', 'TipoLocal atualizado com sucesso!');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao atualizar TipoLocal.');
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'uploadForm' => $uploadForm,
        ]);
    }

    /**
     * Deletes an existing TipoLocal model.
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
     * Finds the TipoLocal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TipoLocal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TipoLocal::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
