<?php

namespace backend\controllers;

use Yii;
use common\models\Noticia;
use common\models\UploadForm;
use backend\models\NoticiaSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use common\models\LocalCultural;

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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['accessBackoffice', 'viewNews'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['accessBackoffice', 'addNews'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['accessBackoffice', 'editNews'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['accessBackoffice', 'deleteNews'],
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
     * Lists all Noticia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoticiaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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
        $locais = LocalCultural::find()->select(['nome', 'id'])->indexBy('id')->column();
        $uploadForm = new UploadForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile) {
                    $fileName = uniqid('noticia_') . '.' . $uploadForm->imageFile->extension;
                    if ($uploadForm->upload($fileName)) {
                        $model->imagem = $fileName;
                    }
                }
                if ($model->destaque == 1) {
                    Noticia::updateAll(['destaque' => 0], ['not', ['id' => $model->id]]);
                }

                $model->data_publicacao = date('Y-m-d H:i:s');
                
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }
    }

    return $this->render('create', [
        'model' => $model,
        'locais' => $locais,
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
        $locais = LocalCultural::find()->select(['nome', 'id'])->indexBy('id')->column();
        $uploadForm = new UploadForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $uploadForm->imageFile = \yii\web\UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile) {
                    $fileName = uniqid('noticia_') . '.' . $uploadForm->imageFile->extension;
                    if ($uploadForm->upload($fileName)) {
                        
                        // Remover imagem antiga se existir
                        $currentImage = $model->imagem;
                        if (!empty($currentImage)) {
                            $oldImagePath = Yii::getAlias('@uploadPath') . '/' . $currentImage;
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }
                        $model->imagem = $fileName;
                    }
                }
                if ($model->destaque == 1) {
                    Noticia::updateAll(['destaque' => 0], ['not', ['id' => $model->id]]);
                }
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'locais' => $locais,
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
        $model = $this->findModel($id);
        $currentImage = $model->imagem;

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Notícia deletada com sucesso!');

            if (!empty($currentImage)) {
                $imagePath = Yii::getAlias('@uploadPath') . '/' . $currentImage;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao deletar a notícia.');
        }

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
