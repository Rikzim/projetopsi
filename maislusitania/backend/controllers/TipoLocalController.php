<?php

namespace backend\controllers;

use Yii;
use common\models\TipoLocal;
use common\models\UploadForm;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile) {
                    $fileName = uniqid('marker_') . '.' . $uploadForm->imageFile->extension;
                    if ($uploadForm->upload($fileName)) {
                        $model->icone = $fileName;
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            if ($model->load($this->request->post()) && $model->save()) {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile) {
                    $fileName = uniqid('marker_') . '.' . $uploadForm->imageFile->extension;
                    if ($uploadForm->upload($fileName)) {
                        $model->icone = $fileName;
                    }

                    //FALTA REMOVER IMAGEM ANTIGA

                    $model->save(false);
                }
                return $this->redirect(['view', 'id' => $model->id]);
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

        //FALTA REMOVER IMAGEM ASSOCIADA

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
