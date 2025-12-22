<?php

namespace frontend\controllers;

use common\models\UserProfile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UploadForm;
use frontend\models\UpdateForm;
use Yii;
use yii\filters\AccessControl;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class ProfileController extends Controller
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
                        'roles' => ['editProfile'],
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
     * Lists all UserProfile models.
     *
     * @return string
     */
    public function actionMe()
    {
        $user = Yii::$app->user->identity;

        return $this->render('me', [
            'user' => $user,
        ]);
    }
    public function actionUpdate()
    {
        $model = new UpdateForm();
        $uploadForm = new UploadForm();
        $user = Yii::$app->user->identity;

        if (!$model->loadUser($user->id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $uploadForm->imageFile = \yii\web\UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->imageFile) {
                    $fileName = uniqid('userimage_') . '.' . $uploadForm->imageFile->extension;
                    if ($uploadForm->upload($fileName)) {
                        // Remover imagem antiga se existir
                        if (!empty($model->current_image)) {
                            $oldImagePath = Yii::getAlias('@uploadPath') . '/' . $model->current_image;
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }
                        $model->imagem_perfil = $fileName;
                    }
                }
                if ($model->update()) {
                    Yii::$app->session->setFlash('success', 'Utilizador atualizado com sucesso!');
                    return $this->redirect(['me']);
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

    public function actionDelete()
    {
        $user = Yii::$app->user->identity;
        $user->SoftDelete();
        Yii::$app->user->logout();
        return $this->redirect(['site/index']);
    }

    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserProfile::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
