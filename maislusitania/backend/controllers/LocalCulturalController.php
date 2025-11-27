<?php

namespace backend\controllers;

use common\models\LocalCultural;
use common\models\Horario;
use backend\models\UploadForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Yii;

class LocalCulturalController extends Controller
{
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

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => LocalCultural::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $horario = $this->findModel($id)->getHorarios()->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'horario' => $horario,
        ]);
    }

    public function actionCreate()
    {
        $model = new LocalCultural();
        $uploadForm = new UploadForm();
        $horario = new Horario();

        if (Yii::$app->request->isPost) {
            if (
                $model->load(Yii::$app->request->post()) &&
                $horario->load(Yii::$app->request->post())
            ) {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile && $uploadForm->validate()) {
                    $fileName = uniqid('local_') . '.' . $uploadForm->imageFile->extension;
                    $uploadPath = Yii::getAlias('@backend/web/uploads/') . $fileName;
                    if ($uploadForm->imageFile->saveAs($uploadPath)) {
                        $model->imagem_principal = $fileName;
                    }
                }
                if ($model->save(false)) {
                    $horario->local_id = $model->id;
                    $horario->save(false);

                    Yii::$app->session->setFlash('success', 'Local Cultural criado com sucesso!');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao criar Local Cultural.');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'uploadForm' => $uploadForm,
            'horario' => $horario,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $uploadForm = new UploadForm();
        $horario = new \common\models\Horario();

        if (Yii::$app->request->isPost) {
            if (
                $model->load(Yii::$app->request->post()) &&
                $horario->load(Yii::$app->request->post())
            ) {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile && $uploadForm->validate()) {
                    $fileName = uniqid('local_') . '.' . $uploadForm->imageFile->extension;
                    $uploadPath = Yii::getAlias('@backend/web/uploads/') . $fileName;
                    if ($uploadForm->imageFile->saveAs($uploadPath)) {
                        // Remove old image if exists
                        if ($model->imagem_principal) {
                            $oldPath = Yii::getAlias('@backend/web/uploads/') . $model->imagem_principal;
                            if (file_exists($oldPath)) {
                                unlink($oldPath);
                            }
                        }
                        $model->imagem_principal = $fileName;
                    }
                }
                if ($model->save(false)) {
                    $horario->local_id = $model->id;
                    $horario->save(false);

                    Yii::$app->session->setFlash('success', 'Local Cultural atualizado com sucesso!');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao atualizar Local Cultural.');
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'uploadForm' => $uploadForm,
            'horario' => $horario,
        ]);
    }

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

        // Delete associated horario
        $horario = $model->getHorarios()->one();
        if ($horario) {
            $horario->delete();
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Local Cultural deletado com sucesso!');

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = LocalCultural::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}