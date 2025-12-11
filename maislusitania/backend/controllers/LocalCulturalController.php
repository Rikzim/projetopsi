<?php

namespace backend\controllers;

use Yii;
use common\models\LocalCultural;
use common\models\Horario;
use common\models\Distrito;
use common\models\TipoLocal;
use backend\models\LocalCulturalSearch;
use common\models\UploadForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class LocalCulturalController extends Controller
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
     * Lists all LocalCultural models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LocalCulturalSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $locais = LocalCultural::find()->all();
        $distritos = ArrayHelper::map(Distrito::find()->all(), 'id', 'nome');
        $tipoLocais = ArrayHelper::map(TipoLocal::find()->all(), 'id', 'nome');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'locais' => $locais,
            'distritos' => $distritos,
            'tipoLocais' => $tipoLocais,
        ]);
    }

    /**
     * Displays a single LocalCultural model.
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

    public function actionCreate()
    {
        $model = new LocalCultural();
        $uploadForm = new UploadForm();
        $horario = new Horario();
        $tipoLocais = ArrayHelper::map(TipoLocal::find()->all(), 'id', 'nome');
        $distritos = ArrayHelper::map(Distrito::find()->all(), 'id', 'nome');

        if (Yii::$app->request->isPost) {
            if (
                $model->load(Yii::$app->request->post()) &&
                $horario->load(Yii::$app->request->post())
            ) {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile) {
                    $fileName = uniqid('local_') . '.' . $uploadForm->imageFile->extension;
                    if ($uploadForm->upload($fileName)) {
                        $model->imagem_principal = $fileName;
                    }
                }
                
                // Save horario first to get an ID, then link it to the model and save the model.
                if ($horario->save()) {
                    $model->horario_id = $horario->id;
                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'uploadForm' => $uploadForm,
            'horario' => $horario,
            'distritos' => $distritos,
            'tipoLocais' => $tipoLocais,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $tipoLocais = ArrayHelper::map(TipoLocal::find()->all(), 'id', 'nome');
        $distritos = ArrayHelper::map(Distrito::find()->all(), 'id', 'nome');
        $uploadForm = new UploadForm();
        $horario = $model->horario ?: new Horario();


        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                
                $horario->load(Yii::$app->request->post());

                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile) {
                    $oldImage = $model->imagem_principal; // Save old name
                    $fileName = uniqid('local_') . '.' . $uploadForm->imageFile->extension;

                    if ($uploadForm->upload($fileName)) {
                        $model->imagem_principal = $fileName;

                        // APAGAR A IMAGEM ANTIGA
                        $path = Yii::getAlias('/uploads/' . $oldImage);
                        if ($oldImage && file_exists($path)) {
                            unlink($path);
                        }
                    }
                }

                if ($model->save()) {
                    // Save the horario (this will UPDATE an existing record or INSERT a new one)
                    if ($horario->save()) {
                        // If the horario was new, we need to link it to the LocalCultural model
                        // and save the model again to persist the foreign key.
                        if (!$model->horario_id) {
                            $model->horario_id = $horario->id;
                            $model->save();
                        }
                    }

                    Yii::$app->session->setFlash('success', 'Local Cultural atualizado!');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'uploadForm' => $uploadForm,
            'horario' => $horario,
            'tipoLocais' => $tipoLocais,
            'distritos' => $distritos,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        //ISTO NAO ME PARECE ESTAR A FUNCIONAR CORRETAMENTE
        // Delete associated image file
        if ($model->imagem_principal) {
            $uploadPath = Yii::getAlias('@uploadPath');
            $imagePath = $uploadPath . DIRECTORY_SEPARATOR . $model->imagem_principal;
            
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
        Yii::$app->session->setFlash('success', 'Local Cultural apagado com sucesso!');

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = LocalCultural::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
