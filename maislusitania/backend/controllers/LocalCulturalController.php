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
        $TipoLocais = ArrayHelper::map(TipoLocal::find()->all(), 'id', 'nome');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'locais' => $locais,
            'distritos' => $distritos,
            'TipoLocais' => $TipoLocais,
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
                if ($uploadForm->imageFile) {
                    $fileName = uniqid('local_') . '.' . $uploadForm->imageFile->extension;
                    if ($uploadForm->upload($fileName)) {
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
        $horario = $model->getHorarios()->one() ?: new Horario();

        if (!$horario) {
            $horario = new Horario();
        }

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

                if ($model->save(false)) {
                    $horario->local_id = $model->id;
                    $horario->save(false);

                    Yii::$app->session->setFlash('success', 'Local Cultural atualizado!');
                    return $this->redirect(['view', 'id' => $model->id]);
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
