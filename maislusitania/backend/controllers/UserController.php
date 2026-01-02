<?php

namespace backend\controllers;

use common\models\UploadForm;
use common\models\User;
use backend\models\SignupForm;
use backend\models\UserSearch;
use backend\models\UpdateForm;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                        'roles' => ['viewUser', 'gestor'], // Added 'gestor'
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['addUser'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['editUser', 'gestor'], // Added 'gestor'
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deleteUser'],
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

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Permitir admin em tudo
        if (Yii::$app->user->can('admin')) {
            return true;
        }

        // Permitir gestor editar/ver só o próprio perfil
        if (
            in_array($action->id, ['update', 'view']) && 
            Yii::$app->user->can('gestor') &&
            Yii::$app->request->get('id') == Yii::$app->user->id
        ) {
            return true;
        }

        // Bloquear tudo o resto
        throw new ForbiddenHttpException('Acesso negado.');
    }
    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'userProfile' => $model->userProfile,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        $uploadForm = new UploadForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile) {
                    $fileName = uniqid('userimage_') . '.' . $uploadForm->imageFile->extension;
                    if ($uploadForm->upload($fileName)) {

                        // Remover imagem antiga se existir
                        $currentImage = $model->imagem_perfil;
                        if (!empty($currentImage)) {
                            $oldImagePath = Yii::getAlias('@uploadPath') . '/' . $currentImage;
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }

                        $model->imagem_perfil = $fileName;
                    }
                }
                $user = $model->signup();
                if ($user) {
                    Yii::$app->session->setFlash('success', 'Utilizador criado com sucesso!');
                    return $this->redirect(['view', 'id' => $user->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao criar utilizador.');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'uploadForm' => $uploadForm,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        // Se não for admin, só pode editar o próprio perfil
        if (!Yii::$app->user->can('admin') && Yii::$app->user->id != $id) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para editar este utilizador.');
        }

        $model = new UpdateForm();
        $uploadForm = new UploadForm();

        if (!$model->loadUser($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $uploadForm->imageFile = \yii\web\UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile) {
                    $fileName = uniqid('userimage_') . '.' . $uploadForm->imageFile->extension;
                    if ($uploadForm->upload($fileName)) {
                        // Remover imagem antiga se existir
                        $currentImage = $model->imagem_perfil;
                        if (!empty($currentImage)) {
                            $oldImagePath = Yii::getAlias('@uploadPath') . '/' . $currentImage;
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }
                        
                        $model->imagem_perfil = $fileName;
                    }
                }
                if ($model->update()) {
                    Yii::$app->session->setFlash('success', 'Utilizador atualizado com sucesso!');
                    return $this->redirect(['view', 'id' => $id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao atualizar utilizador.');
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'uploadForm' => $uploadForm,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Para nao apagar a propria conta
        if ($id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'Não se pode apagar a própria conta.');
            return $this->redirect(['index']);
        }

        // Soft delete
        if ($model->SoftDelete()) {
            Yii::$app->session->setFlash('success', 'Utilizador desativado com sucesso!');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao desativar o utilizador.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
