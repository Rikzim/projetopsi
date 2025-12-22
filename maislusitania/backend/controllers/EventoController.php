<?php

namespace backend\controllers;

use Yii;
use common\models\Evento;
use backend\models\EventoSearch;
use common\models\LocalCultural;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\UploadForm;
use Symfony\Contracts\EventDispatcher\Event;
use yii\filters\AccessControl;

/**
 * EventoController implements the CRUD actions for Evento model.
 */
class EventoController extends Controller
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
                        'roles' => ['viewEvent'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['addEvent'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['editEvent'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deleteEvent'],
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
     * Lists all Evento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $locais = ArrayHelper::map(LocalCultural::find()->all(), 'id', 'nome');

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'locais' => $locais,
        ]);
    }

    /**
     * Displays a single Evento model.
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
     * Creates a new Evento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Evento();
        $uploadForm = new UploadForm();
        $locais = ArrayHelper::map(LocalCultural::find()->all(), 'id', 'nome');
        

        if (Yii::$app->request->isPost) {
            if (
                $model->load(Yii::$app->request->post()) 
            ) {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile) {
                    $fileName = uniqid('evento_') . '.' . $uploadForm->imageFile->extension;
                    if ($uploadForm->upload($fileName)) {
                        $model->imagem = $fileName;
                    }
                }
                if ($model->save()) {
                   

                    Yii::$app->session->setFlash('success', 'Evento criado com sucesso!');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao criar Evento.');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'uploadForm' => $uploadForm,
            'locais' => $locais,
        ]);
    }

    /**
     * Updates an existing Evento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $locais = ArrayHelper::map(LocalCultural::find()->all(), 'id', 'nome');
        $uploadForm = new UploadForm();

        if (Yii::$app->request->isPost) {
            if (
                $model->load(Yii::$app->request->post())
               
            ) {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile) {
                    $fileName = uniqid('evento_') . '.' . $uploadForm->imageFile->extension;
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
                if ($model->save()) {

                    Yii::$app->session->setFlash('success', 'Evento atualizado com sucesso!');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao atualizar Evento.');
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
     * Deletes an existing Evento model.
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
            Yii::$app->session->setFlash('success', 'Evento deletado com sucesso!');

            if (!empty($currentImage)) {
                $imagePath = Yii::getAlias('@uploadPath') . '/' . $currentImage;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao deletar o evento.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Evento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Evento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Evento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
