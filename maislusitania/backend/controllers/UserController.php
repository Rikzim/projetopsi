<?php

namespace backend\controllers;

use common\models\User;
use backend\models\SignupForm;
use backend\models\UserSearch;
use backend\models\UpdateForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

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

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
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
        $model = new UpdateForm();
        
        if (!$model->loadUser($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
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
        
        $transaction = Yii::$app->db->beginTransaction();
        
        try {
            // Buscar o perfil do utilizador
            $userProfile = $model->userProfile;
            
            // Deletar imagem de perfil se existir
            if ($userProfile && $userProfile->imagem_perfil) {
                $uploadPath = Yii::getAlias('@backend/web/uploads/');
                $imagePath = $uploadPath . $userProfile->imagem_perfil;
                
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            // Deletar perfil do utilizador
            if ($userProfile) {
                $userProfile->delete();
            }
            
            // Remover todas as roles do utilizador
            $auth = Yii::$app->authManager;
            $auth->revokeAll($model->id);
            
            // Deletar utilizador
            if (!$model->delete()) {
                throw new \Exception('Erro ao deletar utilizador');
            }
            
            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Utilizador deletado com sucesso!');
            
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Erro ao deletar utilizador: ' . $e->getMessage());
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
