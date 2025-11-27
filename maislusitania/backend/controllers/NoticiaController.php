<?php

namespace backend\controllers;

use Yii;
use common\models\Noticia;
use backend\models\UploadForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NoticiaController implements the CRUD actions for Noticia model.
 */
class NoticiaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Noticia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Noticia::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Noticia model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Noticia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Noticia();
        $uploadForm = new UploadForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $uploadForm->imageFile = \yii\web\UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile && $uploadForm->validate()) {
                    $fileName = uniqid('noticia_') . '.' . $uploadForm->imageFile->extension;
                    $uploadPath = Yii::getAlias('@backend/web/uploads/') . $fileName;
                    if ($uploadForm->imageFile->saveAs($uploadPath)) {
                        $model->imagem = $fileName;
                    }
                }
                if ($model->destaque == 1) {
                    \common\models\Noticia::updateAll(['destaque' => 0], ['not', ['id' => $model->id]]);
                }
                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }
    }

    return $this->render('create', [
        'model' => $model,
        'uploadForm' => $uploadForm,
    ]);
    }

    /**
     * Updates an existing Noticia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        $uploadForm = new UploadForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $uploadForm->imageFile = \yii\web\UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile && $uploadForm->validate()) {
                    $fileName = uniqid('noticia_') . '.' . $uploadForm->imageFile->extension;
                    $uploadPath = Yii::getAlias('@backend/web/uploads/') . $fileName;
                    if ($uploadForm->imageFile->saveAs($uploadPath)) {
                        // Optional: remove old image
                        if ($model->imagem) {
                            $oldPath = Yii::getAlias('@backend/web/uploads/') . $model->imagem;
                            if (file_exists($oldPath)) {
                                unlink($oldPath);
                            }
                        }
                        $model->imagem = $fileName;
                    }
                }
                if ($model->destaque == 1) {
                    \common\models\Noticia::updateAll(['destaque' => 0], ['not', ['id' => $model->id]]);
                }
                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'uploadForm' => $uploadForm,
        ]);
    }

    /**
     * Deletes an existing Noticia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Noticia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Noticia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Noticia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
